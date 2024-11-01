<?php $getDetails = wdfl_get_account(); 
$objectDetails    = wdfl_get_particular_data_form_table("wdfl_form_object","1");
$object           = wdfl_get_data_object(); 
 
 ?>


<div class="container">
	<div class="row" style="margin-top: 10px;">
		<div class="col-sm-12"><h3><img src="<?php echo plugins_url('/assets/screenshots/icon-128x128.png',__FILE__)?>" width="80px" class="img-thumbnail mr-3">WordForce Lead - Create Account</h3></div>
	</div>
	<hr>
	
	<div class="row form-box">
		<div class="col-sm-12 innerbox">
			
			<div class="panel panel-secondary">
				<div class="panel-heading">Map Form Fields <span class="text-danger">( All * Fields are Required )</span></div>
				<br>
				<div class="panel-body">
					<form action="javascript:void(0)" id="frm_map">
						
						<div class="row">
							<div class="col-md-3" >
								<label for="exampleInputEmail1" style="font-size: 13px;">Account Name</label>
							</div>
							<div class="col-md-8">
								<input type="text" required="" value="<?php echo $getDetails['name']; ?>" class="form-control" id="accountName" name="accountName" placeholder="Account Name Here">
								 
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Instant URL</label>
							</div>
							<?php
							//$getDetails['status']=9;
							if($getDetails['status']==9 || $getDetails['status']==2){

							?>
							<div class="col-md-6">
								<a href="<?php echo "admin.php?page=wdfl-add-new-account" ?>" id="login_btn" class="button text-center bg-info" style="padding-top: 5px;"><h5 class="text-white">Login</h5></a>
								<?php }else{
								$data = wdfl_object_to_array_data_for_plugin(json_decode($getDetails['data'])); 
								 ?>
								<div class="col-md-8">
									<span class="badge text-center bg-success" style="padding-top: 4px;"><p class="text-white" style="font-size: 12pt;font-weight: normal;margin:2px 4px"><?php echo $data['instance_url'];?></p></span>
									<?php } ?>
								</div>
							</div> 
 						</div> 
 						<br>
						 
 
							<?php 
								if($getDetails['status']==1){
							?>
							
							<div class="row">
                            
								<div class="col-md-3" >
									<label for="exampleInputEmail1" style="font-size: 13px;">Lead Title</label>
								</div>
								<div class="col-md-8">
									<input type="text" required="" value="<?php echo $objectDetails['leadTitle']; ?>" class="form-control" id="txtfulltitle" name="txtfulltitle" placeholder="Lead Title for Filter">
								</div>
							</div>
							<br>
						
							<div class="row">
								<div class="col-md-3">
									<label for="exampleInputEmail1" style="font-size: 13px;">Select Object</label>
								</div>
							
								<div class="col-md-8">
										<select class="form-control" style="width:100%;max-width: 100%;" name="objectVal" id="objectVal">
										||<option value="value">Option</option> 
										 
										<?php $allObjects = json_decode($objectDetails['allObjects']);

										if($allObjects!="Session expired or invalid" && $allObjects!=''){
										foreach ($allObjects as $key => $value) { ?>
											<option a <?php if($objectDetails['objectName'] == $key){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>  
											<?php } ?>
										<?php }else{
										 if(count($object)>0){
										foreach ($object as $key => $value) { ?>
											<option <?php if($objectDetails['objectName'] == $key){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>  
										<?php } ?>
										<?php } } ?>
									 </select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa  " id="objInc" style="color:green;"></i>
                           </span>
								</div>
							</div>
							<br/>
						<?php } ?>


						<?php 
								if($getDetails['status']==1){
							?>
							<div class="custom" style="display:none">
							<div class="row">
                            <div class="col-sm-12 text-center"><hr>
								<p>Please select all the required fields from the drop downs</p></div>
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Title</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;" name="column1" id="column1">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col1']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col1" style="color:green;"></i>
                           </span>
								</div>
							</div>
						 	<br>

							<div class="row" >
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Name</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;" name="column2" id="column2">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col2']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col2" style="color:green;"></i>
                               </span>
								</div>
							</div>
						 	<br>

							<div class="row" >
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Email</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;" name="column3" id="column3">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col3']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col3" style="color:green;"></i>
                           </span>
								</div>
							</div>
						 	<br>

							<div class="row" >
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Phone</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;"  name="column4" id="column4">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col4']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col4" style="color:green;"></i>
                           </span>
								</div>
							</div>
							 <br>

							<div class="row" >
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Address</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;"  name="column5" id="column5">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col5']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?> 
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col5" style="color:green;"></i>
                           </span>
								</div>
							</div>
							 <br>

							<div class="row" >
							<div class="col-md-3">
								<label for="exampleInputEmail1" style="font-size: 13px;">Select Field for Message</label>
							</div>
							
								<div class="col-md-8">
									<select class="form-control columnValue" style="width:100%;max-width: 100%;" name="column6" id="column6">
										<option value="value">--Choose Value--</option>
										<?php  
										$fields = get_wdfl_fields($objectDetails['objectName']);
										foreach($fields as $value){
										if($value['name'] == $objectDetails['col6']){
											$attr="selected";
										}else{
											$attr='';
										}
										if(isset($value['req']) && $value['req']==true){
											$attr1='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
										}else{
											$attr1='';
										} ?>
								 		<option value="<?php echo $value['name'] ?>" <?php echo $attr ?>><?php echo $value['label']." ".$attr1; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
								<span>
                                <i class="fa " id="col6" style="color:green;"></i>
                           </span>
								</div>
							</div>
							 
						<?php } ?>
						<br>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<button id="mapBtn" type="submit" class="btn btn-primary py-2">Save changes</button>
								</div>
								<div class="col-sm-6">
									 <div id="response"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
 </div>
</div>