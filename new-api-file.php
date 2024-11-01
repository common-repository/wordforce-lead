<?php   

//=================================main functions=====================
 function get_token($info=""){
  
  if(!is_array($info)){
  
    $getDetails = wdfl_get_account();
    $info = wdfl_object_to_array_data_for_plugin(json_decode($getDetails['data'])); 
  }
    
  
  if(!isset($info['refresh_token']) || empty($info['refresh_token'])){
   return $info;   
  }
  $client=wdfl_client_info();
  ////////it is oauth    
  $body=array("client_id"=>$client['client_id'],"client_secret"=>$client['client_secret'],"redirect_uri"=>$client['call_back'],"grant_type"=>"refresh_token","refresh_token"=>$info['refresh_token']);
     $env='login';

      if( !empty($info['env'])){
       $env='test';  
      }
  
  $res=wdfl_post_sales_new('token',"https://$env.salesforce.com/services/oauth2/token","post",$body);

  $re=json_decode($res,true); 
  if(isset($re['access_token']) && $re['access_token'] !=""){ 
    $info["access_token"]=$re['access_token'];
    $info["instance_url"]=$re['instance_url'];
    $info["issued_at"]=$re['issued_at'];
    
    $info["class"]='updated';
    $token=$info;
  }else{
    $info['error']=$re['error_description'];
    $info['access_token']="";
    $info["class"]='error';
    $token=array(array('errorCode'=>'406','message'=>$re['error_description']));

  }
  $info["valid_api"]=current_time('timestamp')+86400; //api validity check
  //update salesforce info 
  //got new token , so update it in db

  wdfl_update_info( array("data"=> $info),1); 
  
  return $info; 
  }




 function post($key, $arr="") {
  if($arr!=""){
  return isset($arr[$key])  ? $arr[$key] : "";
  }
  return isset($_REQUEST[$key]) ? clean($_REQUEST[$key]) : "";
}
  function clean($var,$key=''){
    if ( is_array( $var ) ) {
  $a=array();
    foreach($var as $k=>$v){
  $a[$k]= clean($v,$k);    
    }
  return $a;  
    }else {
     $var=wp_unslash($var);   
  if(in_array($key,array('note_val','value'))){
 $var=sanitize_textarea_field($var);      
  }else{
  $var=sanitize_text_field($var);    
  }      
return  $var;
    }
}

 function wdfl_update_info($data,$id) {
 
if(empty($id)){
    return;
}

 $time = current_time( 'mysql' ,1);

  $sql=array('updated'=>$time);
  if(is_array($data)){
  
    if(isset($data['meta'])){
  $sql['meta']= json_encode($data['meta']);    
  }
  if( isset($data['data']) && is_array($data['data'])){ 
     $acount=wdfl_get_account($id="1");
       if(array_key_exists('time' , $data['data']) && empty($data['data']['time'])){
  $sql['time']= $time;    
  $sql['status']= '2';    
  } 
  if(isset($data['data']['class'])){
  $sql['status']= $data['data']['class'] == 'updated' ? '1' : '2'; 
  }
  if(isset($data['data']['meta'])){
      unset($data['data']['meta']);
  }
  if(isset($data['data']['status'])){
      unset($data['data']['status']);
  }
  if(isset($data['data']['name'])){
     $sql['name']=$data['data']['name'];  
     // unset($data['data']['name']);
  }else if(isset($_GET['id'])){
       $sql['name']="Account Name"; 
  }
    $sql['name']="Account Name"; 
    $str=json_encode($data['data']);

   // enc off
   $enc_str=wdfl_en_crypt($str);

   $enc_str=$str;
   $sql['data']=$enc_str;
  }
  }  
$result = wdfl_update_info_data($sql,$id);  
return $result;
}

 function wdfl_en_crypt($str){
  $str=trim($str);
  if($str == "")
  return '';
  $key=wdfl_get_key();
if(function_exists("openssl_encrypt")) {
$method='AES-256-CBC';
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
$enc_str=openssl_encrypt($str,$method, $key,false,$iv);
$enc_str.=":".base64_encode($iv);
  }else{
      $enc_str=$str;
  }
  $enc_str=base64_encode($enc_str);
  return $enc_str;
  }

  function request($path="",$method='POST',$body="",$head=array()) {

        $args = array(
            'body' => $body,
            'headers'=> $head,
            'method' => strtoupper($method), // GET, POST, PUT, DELETE, etc.
            'sslverify' => false,
            'timeout' => 20,
        );

       $response = wp_remote_request($path, $args);

        if(is_wp_error($response)) { 
            $this->error_msg= $response->get_error_message();
            return false;
        } else if(isset($response['response']['code']) && $response['response']['code'] != 200 && $response['response']['code'] != 404) {
            $this->error_msg = strip_tags($response['body']);
            return false;
        } else if(!$response) {
            return false;
        }
   $result=wp_remote_retrieve_body($response);
        return $result;
    }

  function wdfl_get_data_object(){   
    $sales_res= wdfl_post_sales_arr('/services/data/v42.0/sobjects/',"get","");

  $fields=array();
  if(isset($sales_res['sobjects'])){
  foreach($sales_res['sobjects'] as $object){
  if($object['createable'] == true && $object['layoutable'] == true){
  $fields[$object['name']]=$object['label'];  
  }     
  }
  return $fields;
  }
  $msg="No Objects Found";
  if(isset($sales_res[0]['errorCode'])){
  $msg=$sales_res[0]['message'];    
  }
  return $msg;
  }

  function wdfl_post_sales_arr($path,$method,$body=""){
    $getDetails = wdfl_get_account();
  $info = wdfl_object_to_array_data_for_plugin(json_decode($getDetails['data']));  
  $get_token=false; $error=array(array( 'errorCode'=>'2005' , 'message'=>__('No Access to Salesforce API - 2005','gravity-forms-salesforce-crm'))); 
if(!isset($info['instance_url']) || empty($info['instance_url'])){
    return $error;
}
  $url=$info['instance_url'];
  $dev_key=$info['access_token'];
  $head=array(); 
  if(!empty($body) && is_array($body)){ 
  if(isset($body['disable_rules'])){
  $head['Sforce-Auto-Assign']='false'; 
  unset($body['disable_rules']);   
  }
  $body=json_encode($body);

  }
if(!empty($dev_key)){
  $sales_res=wdfl_post_sales_new($dev_key,$url.$path,$method,$body,$head); 
  $sales_response=json_decode($sales_res,true); 
}else{
  $get_token=true;    
}
  if(isset($sales_response[0]['errorCode']) && $sales_response[0]['errorCode'] == "INVALID_SESSION_ID"){ 
  $get_token=true;         
  }

  if($get_token){  
  
   $token=get_token();     
      if(!empty($token['access_token'])){
      $dev_key=$token['access_token'];     
      $url=$token['instance_url'];
      $sales_res=wdfl_post_sales_new($dev_key,$url.$path,$method,$body,$head);
      $sales_response=json_decode($sales_res,true);  
      }else{
          return $error;
      }

} 
  return $sales_response;   
  }

  function wdfl_get_key(){
  $k='Wezj%+l-x.4fNzx%hJ]FORKT5Ay1w,iczS=DZrp~H+ve2@1YnS;;g?_VTTWX~-|t';
  if(defined('AUTH_KEY')){
  $k=AUTH_KEY;
  }
  return substr($k,0,30);        
  }

 function wdfl_update_info_data($sql, $id) {
global $wpdb;

$table = $wpdb->prefix . 'wdfl_accounts';
$res=$wpdb->update($table,$sql,array('id'=>$id));
return $res;
}

//============================end of main functions==================================

function wdfl_get_info($id="1"){  
 $info=wdfl_get_account($id="1");
 $data=array();  
 $meta=$info_arr=array(); 
if(is_array($info)){
    if(!empty($info['data'])){  
       $info_arr=json_decode(($info['data']),true);   
        if(!is_array($info_arr)){
            $info_arr=array();
        }
    }

$info_arr['time']=$info['time']; 
$info_arr['id']=$info['id']; 
$info['data']=$info_arr; 
if(!empty($info['meta'])){  
  $meta=json_decode($info['meta'],true); 
} 
$info['meta']=is_array($meta) ? $meta : array();    
}
  return $info;    
  }

 function wdfl_get_account($id="1") {
global $wpdb;

 $id=(int)$id;
$table = $wpdb->prefix . 'wdfl_accounts';
$res=$wpdb->get_row( 'SELECT * FROM '.$table.' where id='.$id.' limit 1',ARRAY_A );
return $res;
}

   function wdfl_client_info(){
    $info = wdfl_get_info();; 
    $client_id  = "3MVG9pRzvMkjMb6knRiSgKNIA_C3688fgYAvdyKGv0QO7ovcQtySRt0eVEsGPne26ZSCzUiGw41tYdIgqaze1";
$client_secret="8100FCC5556C559BEAC5DA2A06B9F4E84E23444F9E99AA7949016FCDC6A87722";
  $call_back="https://bugendaitech.com/wordforce-lead/my-callback-page.php";
  

  //custom app
  if(is_array($info)){
      if(post('custom_app',$info) == "yes" && post('app_id',$info) !="" && post('app_secret',$info) !="" && post('app_url',$info) !=""){
     $client_id=post('app_id',$info);     
     $client_secret=post('app_secret',$info);     
     $call_back=post('app_url',$info);     
      }
  }
  return array("client_id"=>$client_id,"client_secret"=>$client_secret,"call_back"=>$call_back);
  }
 
 function wdfl_handle_code(){
 
   $client['client_id'] = "3MVG9pRzvMkjMb6knRiSgKNIA_C3688fgYAvdyKGv0QO7ovcQtySRt0eVEsGPne26ZSCzUiGw41tYdIgqaze1"; 
   $client['client_secret']="8100FCC5556C559BEAC5DA2A06B9F4E84E23444F9E99AA7949016FCDC6A87722";
   $client['call_back'] = "https://bugendaitech.com/wordforce-lead/my-callback-page.php";


  $log_str=$res=""; $token=array();

  if(isset($_REQUEST['code'])){
 
    $code=post('code');   

    if(!empty($code)){ 
        $env='login'; 

        if(!empty($_REQUEST['vx_env']) || !empty($info['env'])){
         $env='test'; $info['env']='test';  
        }
    $body=array("client_id"=>$client['client_id'],"client_secret"=>$client['client_secret'],"redirect_uri"=>$client['call_back'],"grant_type"=>"authorization_code","code"=>$code);
  
    $res=wdfl_post_sales_new("token","https://$env.salesforce.com/services/oauth2/token","post",$body);
    
    $log_str="Getting access token from code";
     $token=json_decode($res,true); 
    
     if(!isset($token['access_token'])){
        $log_str.=" =".$res; 
     }
    }

    if(isset($_REQUEST['error'])){
     $token['error_description']=post('error_description');   
    }

  }else{ 
    echo "yYes";
    if(isset($info['instance_url']) && $info['instance_url']!="")
    $res=request($info['instance_url']."/services/oauth2/revoke?token=".$info['refresh_token'],"get","");  

    print_r($res);
    $log_str="Access token Revoked on Request";
  }
 
    $info['instance_url']=post('instance_url',$token);
    $info['access_token']=post('access_token',$token);
    $info['client_id']=$client['client_id'];
    $info['_id']=post('id',$token);
    $info['refresh_token']=post('refresh_token',$token);
    $info['issued_at']=time();
    $info['signature']=post('signature',$token);
    $info['sales_token_time']=current_time('timestamp');
    $info['error']=post('error_description',$token);
    $info['api']="api";
    $info["class"]='error';

    if(!empty($info['access_token'])){
        $info["class"]='updated';
    } 
      wdfl_update_info(array('data'=> $info) , 1); 
      return $info;
}
 

  function link_to_settings( $tab='' ) {
  $q=array('page'=>$this->id);

  if(!empty($tab)){
   $q['tab']=$tab;   
  }
  $url = admin_url('admin.php?'.http_build_query($q));
  
  return  $url;
  }

       function wdfl_post_sales_new($dev_key,$path,$method,$body="",$head=''){ 
  
  if($dev_key == 'token'){
  $header=array('content-type'=>'application/x-www-form-urlencoded');   
  }else{
  $header=array("Authorization"=>' Bearer ' . $dev_key,'content-type'=>'application/json');     
  if(!empty($head) && is_array($head)){ $header=array_merge($header,$head);  }
  }
  if(is_array($body)&& count($body)>0)
  { $body=http_build_query($body);
  }
  if($method != "get"){
$header['content-length']= !empty($body) ? strlen($body) : 0;
  }   
  $response = wp_remote_post( $path, array(
  'method' => strtoupper($method),
  'timeout' => '123456789',
  'headers' => $header,
  'body' => $body
  )
  );

   
  return !is_wp_error($response) && isset($response['body']) ? $response['body'] : "";
  }

 function wdfl_setup_plugin(){
        global $wpdb;

  if(isset($_REQUEST['tab_action']) && $_REQUEST['tab_action']=="get_token"){      
            if(true){
              $id=1;
              $info=wdfl_get_info($id="1"); 
              $info_data=wdfl_handle_code();
              $token=post('access_token',$info_data);
              $goBack = wdfl_get_home_url()."/wp-admin/admin.php?page=wdfl-general"; ?> 
           <script>window.location.href='<?php echo $goBack ?>'</script> 
           <?php  } 
  }
  }

 wdfl_setup_plugin();


 function get_wdfl_fields($object,$is_options=false){ 

$sales_response=wdfl_post_sales_arr('/services/data/v42.0/sobjects/'.ucfirst($object)."/describe","get",""); 
 
  if(isset($sales_response['fields']) && is_array($sales_response['fields'])){
  $field_info=array();
  foreach($sales_response['fields'] as $k=>$field){ 
  
        if( (isset($field['createable']) && $field['createable'] ==true) || $field['name'] == 'Id' || (isset($field['custom']) && $field['custom'] ==true) ){
        
          $required=""; 
  if( !empty($field['nameField']) || (!empty($field['createable']) && empty($field['nillable']) && empty($field['defaultedOnCreate']))  ){
  $required="true";   
  } 
  $type=$field['type'];
  if($type == 'reference' && !empty($field['referenceTo']) && is_array($field['referenceTo'])){
   $type=reset($field['referenceTo']);   
  }
  $field_arr=array('name'=>$field['name'],"type"=>$type);
  $field_arr['label']=$field['label']; 
  $field_arr['req']=$required;
  $field_arr["maxlength"]=$field['length'];
  $field_arr["custom"]=$field['custom'];    
            
         if(isset($field['picklistValues']) && is_array($field['picklistValues']) && count($field['picklistValues'])>0){
         $field_arr['options']=$field['picklistValues'];
             $egs=array();
         foreach($field['picklistValues'] as $op){
         $egs[]=$op['value'].'='.$op['label'];    
         }
            $field_arr['eg']=implode(', ',array_slice($egs,0,30));
          }
      if($is_options ){
          if(!empty($field_arr['options'])){
       $field_info[$field['name']]=$field_arr;
          } 
      }else{
  
  $field_info[$field['name']]=$field_arr;  
  } }
      
  } 
  if(isset($field_info['Id'])){
     $id=$field_info['Id'];
     unset($field_info['Id']);
   $field_info['Id']=$id;   
  }
  return $field_info;
  }
  $msg=__("No Fields Found",'gravity-forms-salesforce-crm');
  if(isset($sales_response[0]['errorCode'])){
  $msg=$sales_response[0]['message'];    
  }
  if(isset($sales_response['error'])){
  $msg=$sales_response['error'];    
  } 

  return $msg;
  }
 ?>