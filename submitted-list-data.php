<?php   $array_a     =    wdfl_get_submitted_data_form_table("wdfl_data",''); ?>

<div class="container">
	<br>
	<div class="row">
		<div class="col-sm-12"><h3><img src="<?php echo plugins_url('/assets/screenshots/icon-128x128.png',__FILE__)?>" width="80px" class="img-thumbnail mr-3">WordForce Lead - List of Submited Data</h3></div>
	</div>
	<hr>
	 
		<div class="row"> 
	<div class="col-sm-12">
        
		<div class="card" style="max-width:100%">
            <div class="card-heading">
                <div class="row py-2 bg-primary">
                    <div class="col-sm-6 bg-primary text-white"><h2 class="text-white">Data Inserted By WordForce Lead Plugin Into Salesforce</h2></div>
                    <div class="col-sm-6 bg-primary pt-2"><div id="responses" class="bg-white"></div></div>
                </div>

            </div>
            <div class="card-body">

               <div class="table-responsive">

                <!-- my-book -->
            <table id="my-unique-table" class="table-bordered cus_table display">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Salesforce Id</th>
                        <th>In Object</th>
                        <th>Full Name</th>
                        <th>Email</th>  
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                     if(count($array_a)>0){
                 $i='1';
                 foreach($array_a as $result_pp){
                    ?>
                    <tr>
                        <td style="padding-top:1%;padding-bottom: 1%;"><?php echo esc_html($i);?></td>
                        <td style="padding-top:1%;padding-bottom: 1%;">
                            <?php  if(!empty(esc_html($result_pp['r_id']))){?>
                                <?php echo esc_html($result_pp['r_id']);?>
                            <?php }else{ ?>
                                  <span class="badge" style="background-color:orange">Not Synced</span> 
                            <?php } ?>
                        </td>
                            <td style="padding-top:1%;padding-bottom: 1%;"><?php echo esc_html($result_pp['in_object']);?></td>
                        <td style="padding-top:1%;padding-bottom: 1%;"><?php echo esc_html($result_pp['name']);?></td>
                        <td style="padding-top:1%;padding-bottom: 1%;"><?php echo esc_html($result_pp['email']);?></td>
  
                        <td style="padding-top:1%;padding-bottom: 1%;"><?php echo esc_html($result_pp['created_at']);?></td> 


                        <td style="padding-top:1%;padding-bottom: 1%;">
                            <?php  if(!empty($result_pp['r_id'])){?>
                                <span class="badge" style="background: green;color:white">Synced</span>
                            <?php }else{ ?>
                                <form class="sales_form" action="javascript:void(0)" >

                                <div class="form-group">
                                    <input type="hidden" name="customer_id"  class="form-control input-md" value="<?php echo esc_html($result_pp['id']);?>" aria-required="true" placeholder="Name *">
                                </div>

                                <div class="form-group sales-submit-group">
                                    <button type="button" class="btn btn-primary btn-sm sales-btn click_okay">Click To Sync</button>
                                </div>
                                <span class="text-danger" id="res_ponse"></span>
                            </form>
                                
                            <?php } ?>
                        </td>
                    </tr>
                <?php $i++;
            } } ?>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Sr. No</th>
                        <th>Salesforce Id</th>
                        <th>In Object</th>
                        <th>Full Name</th>
                        <th>Email</th> 
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
    </table>
         </div>
            </div>      
        </div>
	</div>
	 
</div>
</div>