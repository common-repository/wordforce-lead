<?php $getDetails = wdfl_get_account();

if($getDetails['status']==1){
  $data = wdfl_object_to_array_data_for_plugin(json_decode($getDetails['data']));  
}else{
    $data['instance_url'] = '';
    //$getDetails['name'] = '';
}
?>
<style>
  .button{
    height: 40px;width: 200px;font-size: 13px;color: #2271b1;border: 1px solid #2271b1;background: #f6f7f7;
  }
</style>
<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12"><h3><img src="<?php echo plugins_url('/assets/screenshots/icon-128x128.png',__FILE__)?>" width="80px" class="img-thumbnail mr-3">WordForce Lead - Create Account</h3></div>
    </div>
    <hr>
     
        <div class="row form-box"> 
    <div class="col-sm-10 offset-sm-1 innerbox">
        
        <div class="panel panel-secondary">
            <div class="panel-heading">Set Account <span class="text-danger">( All * Fields are Required )</span></div>
            <br>
            <div class="panel-body">

                <form action="javascript:void(0)" id="setForm">
                  
                  <div class="row">
                        <div class="col-md-3" >
                            <label for="exampleInputEmail1" style="font-size: 13px;">Account Name</label>
                            </div>
                            <div class="col-md-9">
                            <input type="text" required="" value="<?php echo $getDetails['name']; ?>" class="form-control" id="txtfullname" name="txtfullname" placeholder="Account Name Here">
                        </div>
                           </div>

                      <br />
                     <!--  <div class="row">
                      <div class="col-md-3" >
                     <label for="exampleInputEmail1" style="font-size: 13px;">Environment</label>
                       </div>
                        <div class="col-md-4">
                      <select class="form-control"  id="production" name="production">
                             <option value="Production">Production</option>
                           <option value="Sandbox">Sandbox</option>
                          </select>
                      </div>
                        </div> -->
                  

                      <br />
                      
                      <br/>
                      <?php
                        $test_link='https://test.salesforce.com/services/'; 
                        $link_href=$link='https://login.salesforce.com/services/' 
                       ?>
                    <div class="row login" style="margin-top: -5%;">
                        <div class="col-md-3">
                            <label for="exampleInputEmail1" style="font-size: 13px;">Salesforce Access</label>
                          </div>
                          
                            <?php

                            $client_id        = '3MVG9pRzvMkjMb6knRiSgKNIA_C3688fgYAvdyKGv0QO7ovcQtySRt0eVEsGPne26ZSCzUiGw41tYdIgqaze1';
                            $id               = '1';
                            $client_call_back = 'https://bugendaitech.com/wordforce-lead/my-callback-page.php'; 
                            // $link             = 'internaltesting.bugendaitech.com/wp-admin/admin';
                            
                            $link = wdfl_get_home_url("refine")."/wp-admin/admin"; 
                        
                            // urlencode($link."&".$this->id."_tab_action=get_token&id=".$id."&vx_nonce=".$nonce.'&vx_env=')
                            
                            
                            $link_href='https://login.salesforce.com/services/oauth2/authorize?response_type=code&state='.urlencode($link)."&client_id=".$client_id."&redirect_uri=".urlencode($client_call_back).'&scope='.urlencode('api refresh_token');  ?> 
                            <?php 
                            if($getDetails['status']==9 || $getDetails['status']==2){
                             ?>
                             <div class="col-md-3">
                             <a href="<?php echo $link_href ?>" id="login_btn" class="button text-center bg-info" style="padding-top: 5px;"><h5 class="text-white">Login</h5></a> 
                         <?php }else{ ?>
                            <div class="col-md-6">
                             <span class="badge text-center bg-success" style="padding-top: 4px;"><p class="text-white" style="font-size: 10pt;font-weight: normal;margin:2px 4px;padding-top: 2px;padding-bottom: 1px"><?php echo $data['instance_url'];?></p></span>
                            </div>
                             <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <button class="btn btn-info" id="revokeBtn"><p class="text-white" style="margin-bottom: 0px;font-size: 10pt;">Revoke Connection</p></button>
                            </div>
                         <?php } ?>
                        </div>
                    </div>

                    <br/> 
                   

                    <div class="row">
                      <div class="col-sm-3">
                        <button id="finalSetBtn" type="submit" class="btn btn-primary py-2">Save changes</button>
                      </div>
                      <div class="col-sm-6">
                        <div id="responses"></div>
                      </div>
                    </div>
                </form>
            </div>      
        </div>
    </div>
     
</div>  
</div>
</div>