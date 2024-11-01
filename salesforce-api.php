<?php   
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
 
 
class WDFL_Salesforce_API 
{
// function for get token from SF Org
 public function wdfl_get_token(){
  $info=array();
  $stu_details= wdfl_get_particular_data_form_table("wdfl_credentials","1"); // gat data form db
  $password=$stu_details['password']."".$stu_details['token'];

  ////////it is oauth    
  $body=array("client_id"=>$stu_details['clientid'],"client_secret"=>$stu_details['clientsrid'],"grant_type"=>"password","username"=>$stu_details['username'],"password"=>$password);
  
  if($stu_details['insturl']!==''){

    $wdfl_url = $stu_details['insturl']."/services/oauth2/token";
  }else{
    $wdfl_url = "https://login.salesforce.com/services/oauth2/token";
  }
   
       
  $res=$this->wdfl_post_sales('token',$wdfl_url,"post",$body); 

  $re=json_decode($res,true); 
  if(isset($re['access_token']) && $re['access_token'] !=""){ 
      $info["access_token"]=$re['access_token'];
      $info["instance_url"]=$re['instance_url'];
      $info["issued_at"]=$re['issued_at'];
      //  $info["org_id"]=$re['id'];
      $info["class"]='updated';
      $token=$info;
  }else{
      $info['error']=$re['error_description'];
      $info['access_token']="";
       $info["class"]='error';
      $token=array(array('errorCode'=>'406','message'=>$re['error_description']));
  }
      return $info; 
  }
  
   public function wdfl_post_sales($token_key,$path,$method,$body="",$head=''){
  
  if($token_key == 'token'){
  $header=array('content-type'=>'application/x-www-form-urlencoded');   
  }else{
  $header=array("Authorization"=>' Bearer ' . $token_key,'content-type'=>'application/json');     
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
  'headers' => $header,
  'body' => $body
  )
  );

  return !is_wp_error($response) && isset($response['body']) ? $response['body'] : "";
  }

    public  function wdfl_post_data_in_salesforce($post_data_api,$customer_id=''){
    
    global $wpdb;
    $body = $post_data_api;  
  
    $sales_res= wdfl_post_sales_arr('/services/data/v42.0/sobjects/',"get","");
    //$get_token= $this->wdfl_get_token();
    $cur_id = 1;
    $table3="wdfl_form_object";   
    $columnDetails=wdfl_get_particular_data_form_table($table3,$cur_id);

    $getAccountDetails  = wdfl_get_account(); 
    $integrationDetails = wdfl_object_to_array_data_for_plugin(json_decode($getAccountDetails['data'])); 

    $in_object  = $columnDetails['objectName']; 
    $token      = $integrationDetails['access_token'];  // return token from org
    $inst_url   = $integrationDetails['instance_url'];  // return inst_url form org
    $path       = $inst_url."/services/data/v42.0/sobjects/".$in_object."/";  // contact org URL of ORG
    $method     = "post";     // method type (POST)
     // Object name
 


    

        $sendJSON=json_decode($post_data_api,true);

        if($customer_id>0){

          $obj_details    = wdfl_get_submitted_data_form_table("wdfl_data",$customer_id); 
        

          $name_d         =   sanitize_text_field($obj_details['name']);
          $email_d        =   sanitize_email($obj_details['email']);
          $mobile_d       =   sanitize_text_field($obj_details['mobile']);
          $address_d      =   sanitize_textarea_field($obj_details['address']);
          $message_d      =   sanitize_textarea_field($obj_details['message']);      

        }else{

          $name_d         =   sanitize_text_field($sendJSON[$columnDetails['col2']]);
          $email_d        =   sanitize_email($sendJSON[$columnDetails['col3']]);
          $mobile_d       =   sanitize_text_field($sendJSON[$columnDetails['col4']]);
          $address_d      =   sanitize_textarea_field($sendJSON[$columnDetails['col5']]);
          $message_d      =   sanitize_textarea_field($sendJSON[$columnDetails['col6']]);  

        }



  $header=array("Authorization"=>' Bearer ' . $token,'content-type'=>'application/json');     
  if(!empty($head) && is_array($head)){ $header=array_merge($header,$head);  }
 
  if(is_array($body)&& count($body)>0)
  { $body=http_build_query($body);
  }
  if($method == "post"){
    $header['content-length']= !empty($body) ? strlen($body) : 0;
  }   
  $response = wp_remote_post( $path, array(
  'method' => strtoupper($method), 
  'headers' => $header,
  'body' => $body
  )
  );

 
  $response_array=json_decode($response['body'],true); 
  
  
  if(array_key_exists("id",$response_array)){
      $return_id = sanitize_text_field($response_array['id']); // return id from SF Org
  }else{
      $return_id = "Error"; // return id from SF Org
  }  

    if($return_id!=="Error"){

      $r_id = $return_id;
    
    }else{

      $r_id = "";

    }



      if($customer_id>0){
          $table_name = $wpdb->prefix . 'wdfl_data';
                $wpdb->update($table_name,array(
                        "r_id"=>$r_id
                        ),array(
                            "id"=>$customer_id
                        ));

      }else{
          
          if(isset($response_array[0]['message']) && $response_array[0]['message'] == 'Use one of these records?'){
              
          }else{
              
              $table_name = $wpdb->prefix . 'wdfl_data';
    
                $wpdb->query(
                        $wpdb->prepare(
                            "INSERT INTO $table_name (name,email,phone,address,message,r_id,in_object) VALUES('%s','%s','%s','%s','%s','%s','%s')","$name_d","$email_d","$mobile_d","$address_d","$message_d","$r_id","$in_object")
                        );
              
          }
    
        
      }
      
    
      return !is_wp_error($response_array) && isset($response_array) ? $response_array : "";

  }

}







 
?>