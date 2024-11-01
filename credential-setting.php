<?php    
// return data from db
$stu_details= wdfl_get_particular_data_form_table("wdfl_credentials","1"); 

if($stu_details['status']=='1'){
    
    $WDFLSalesforceAPI = new WDFL_Salesforce_API();
    
    $getObject= $WDFLSalesforceAPI->wdfl_get_token();  
  
  //print_r($getObject);
  
  // if connected to org then return array
  if($getObject['class']=='updated'){
    $isConnected='1';
  }else{
    $isConnected='0';
  } 
}
 

?>

<div class="container">
	<br>
	<div class="row">
		<div class="col-sm-12"><h3><img src="<?php echo plugins_url('/assets/screenshots/icon-128x128.png',__FILE__)?>" width="80px" class="img-thumbnail mr-3">WordForce Lead - Credential Settings</h3></div>
	</div>
	<hr>
	 
		<div class="row form-box"> 
	<div class="col-sm-10 offset-sm-1 innerbox">
        
		<div class="panel panel-secondary">
            <div class="panel-heading">Credentials Setting <span class="text-danger">( All * Fields are Required )</span></div>
            <br>
            <div class="panel-body">

                <form action="javascript:void(0)" id="frm_editcredential">
                  <input type="hidden" name="main_id" value="<?php echo esc_html("1");?>">
                  <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Full Name:</label>
                            <input type="text" required="" value="<?php echo esc_html($stu_details['name']) ?>" class="form-control" id="txtfullname" name="txtfullname" placeholder="Enter Full Name Here">
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Title:</label>
                            <input type="text" required="" value="<?php echo esc_html($stu_details['title']);?>" class="form-control" id="txtTitle" name="txtTitle" placeholder="Enter Title Here">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Consumer Key:</label>
                            <input type="text" required="" value="<?php echo esc_html($stu_details['clientid']);?>" class="form-control" id="txtclientid" name="txtclientid" placeholder="Enter Consumer Id Here">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Consumer Secret:</label>

                            <input type="text" required="" class="form-control" value="<?php echo esc_html($stu_details['clientsrid']);?>" id="txtclientscr" name="txtclientscr" placeholder="Enter Consumer Secret Id Here">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Username:</label>

                            <input type="text" required="" value="<?php echo esc_html($stu_details['username']);?>" class="form-control" id="txtusername" name="txtusername" placeholder="Enter Username Here">
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Password:</label>

                            <input type="password" required=""  value="<?php echo esc_html($stu_details['password']);?>" class="form-control" id="txtpassword" name="txtpassword" placeholder="Enter Password Here">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Security Token :</label>

                            <input type="password" required=""  value="<?php echo esc_html($stu_details['token']);?>" class="form-control" id="txttoken" name="txttoken" placeholder="Enter Latest Security Token Here">
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Login Base URL:</label>

                            <input type="text" required=""  value="<?php echo esc_url(__($stu_details['insturl']));?>" class="form-control"  id="txtinitial" name="txtinitial" placeholder="Ex- https://login.salesforce.com/">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                      <div class="col-sm-3">
                        <button id="edit_btn" type="submit" class="btn btn-primary py-2">Save Credentials</button>
                      </div>
                      <div class="col-sm-4 p-0">
                        <div id="response"></div>
                      </div>
                      <?php if($stu_details['status']=='1') {?>
                        <div class="col-sm-5">
                           
                          <input type="hidden"  value="<?php echo esc_html($isConnected); ?>" id="obj_status">
                          <?php if($isConnected=='1' || $isConnected=='0'){ ?>
                                <p id="getResponse"></p>
                          <?php }else{ ?>

                          <?php } ?>
                        </div>
                      <?php } ?>
                    </div> 

                       
                </form>
            </div>      
        </div>
	</div>
	 
</div>

 
   
</div>
</div>