jQuery(document).ready(function() {  
 	
 			jQuery(".c").hide(); 
			jQuery(".b").click(function(){
				jQuery(".c").toggle();
			}); 
			jQuery(".d").hide(); 
 
			jQuery("#org").click(function(){
				jQuery(".d").show();
				jQuery(".login").hide();
			});
 
			jQuery("#api").click(function(){
				jQuery(".d").hide();
				jQuery(".login").show();
			});
 
		 jQuery('#production').change(function(){
		   let  btn=jQuery('#login_btn');
		   let  link=btn.attr('data-login');   
			   if(jQuery(this).val() == 'Sendbox'){
			    link=btn.attr('data-test');   
			  }
		  		btn.attr('href',link);
		  });


	let obj_status  = jQuery('#obj_status').val();
	let obj_session = jQuery('#obj_session').val();
 	
 	let objectName  = jQuery('#objectVal').val();
 	if(objectName !=='' ){
 		jQuery('.custom').css("display", "block");
 	}
 
    jQuery('#my-unique-table').DataTable();

  
		jQuery(".click_okay").on('click',function(){
		    swal("Processing!", "Process in Progress!", "info");
			jQuery(".sales_form").validate(); 
			let  post_data = "action=my_credential&param=save_data&" + jQuery(".sales_form").serialize();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);				
				if(data.status==1){
					if(data.status==1){
						jQuery('.sales_form').trigger("reset");
						swal("Successfully!", data.message, "success");
				// 		jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
						setTimeout(function(){
							location.reload();
						},2000)
					}else{
					}
				}else{
					jQuery('.sales_form').trigger("reset");				
					swal("Error!", data.message, "error");
					//jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					setTimeout(function(){
						location.reload();
					},2000)
				} 
 			});
		});

		jQuery("#finalSetBtn").on('click',function(){
			jQuery("#setForm").validate(); 
			let  post_data = "action=my_credential&param=finalSubmit&" + jQuery("#setForm").serialize();
      jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);
				if(data.status==1){
					if(data.status==1){ 
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
						setTimeout(function(){
							jQuery('#responses').removeClass("danger success").html('');
						},2000)
					}else{
					}
				}else{						 
					jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					setTimeout(function(){
						jQuery('#responses').removeClass("danger success").html('');
					},2000)
				} 
 			});
		});

		jQuery("#revokeBtn").on('click',function(){  
			let  post_data = "action=my_credential&param=revokeBtn";
      jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);
				if(data.status==1){
					if(data.status==1){ 
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
						setTimeout(function(){
							jQuery('#responses').removeClass("danger success").html('');
							location.reload();
						},2000)
					}else{
					}
				}else{						 
					jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					setTimeout(function(){
						jQuery('#responses').removeClass("danger success").html('');
					},2000)
				} 
 			});
		}); 

		jQuery("#accountName").on('blur',function(){
			let value = jQuery("#accountName").val();
			if(value!='value'){
			let post_data = "action=my_credential&param=accountName&value=" + jQuery("#accountName").val();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);
				if(data.status==1){						 
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
				}else{
 					  jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
				}
			});
		}
		});
		jQuery("#txtfullname").on('blur',function(){
           let value = jQuery("#txtfullname").val();
			
			if(value!='value'){
			let post_data = "action=my_credential&param=leadTitle&value=" + jQuery("#txtfullname").val();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);
				
				if(data.status==1){						 
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
				}else{
 					  jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
				}
			});
		}
		});

		jQuery("#objectVal").on('change',function(){
			let value = jQuery("#objectVal").val(); 
			let objInc =  document.querySelector('#objInc');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
			let  post_data = "action=my_credential&param=objectVal&object=" + jQuery("#objectVal").val();
			// console.log(post_data);
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				console.log(response);
				let  data= jQuery.parseJSON(response);
				//console.log(data.body);
 				if(data.status==1){	
 				    objInc.classList.remove('fa-spin','fa-spinner');
                    objInc.classList.add('fa-check-circle');
 					  jQuery('#column1').html(data.body);
 					  jQuery('#column2').html(data.body);
 					  jQuery('#column3').html(data.body);
 					  jQuery('#column4').html(data.body);
 					  jQuery('#column5').html(data.body);
 					  jQuery('#column6').html(data.body);
					  jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
					  jQuery('.field').css("display", "block");
					  jQuery('.columnValue').val('value');	
					}else{
					  jQuery('#column1').html('<option value="value">--Choose Value--</option>');
 					  jQuery('#column2').html('<option value="value">--Choose Value--</option>');
 					  jQuery('#column3').html('<option value="value">--Choose Value--</option>');
 					  jQuery('#column4').html('<option value="value">--Choose Value--</option>');
 					  jQuery('#column5').html('<option value="value">--Choose Value--</option>');
 					  jQuery('#column6').html('<option value="value">--Choose Value--</option>');
					  jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					}
				});
			}
		});

		jQuery("#column1").on('change',function(){
			let value = jQuery("#column1").val();
				let objInc =  document.querySelector('#col1');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
			let post_data = "action=my_credential&param=column1&object=" + jQuery("#column1").val();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response);
				if(data.status==1){	
				        objInc.classList.remove('fa-spin','fa-spinner');
                        objInc.classList.add('fa-check-circle');
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
				}else{
 					  jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
				}
			});
		}
		});

		jQuery("#column2").on('change',function(){			
			let value = jQuery("#column2").val();
			let objInc =  document.querySelector('#col2');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
			let  post_data = "action=my_credential&param=column2&object=" + jQuery("#column2").val();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response); 
					if(data.status==1){	
					    objInc.classList.remove('fa-spin','fa-spinner');
                        objInc.classList.add('fa-check-circle');
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
				  }else{						 
					  jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
				  }
 				});
			}
		});

		jQuery("#column3").on('change',function(){			
			let value = jQuery("#column3").val();
			let objInc =  document.querySelector('#col3');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
				let  post_data = "action=my_credential&param=column3&object=" + jQuery("#column3").val();
				jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
					let  data= jQuery.parseJSON(response);
					if(data.status==1){	
					        objInc.classList.remove('fa-spin','fa-spinner');
                            objInc.classList.add('fa-check-circle');
							jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
					}else{						 
						jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					}
	 			});
			}
		});

		jQuery("#column4").on('change',function(){			
				let value = jQuery("#column4").val();
				let objInc =  document.querySelector('#col4');
                objInc.classList.add('fa-spinner','fa-spin');
				if(value!=='value'){
					let  post_data = "action=my_credential&param=column4&object=" + jQuery("#column4").val();
					jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
						let  data= jQuery.parseJSON(response); 
						if(data.status==1){	
    						    objInc.classList.remove('fa-spin','fa-spinner');
                                objInc.classList.add('fa-check-circle');
								jQuery('#responses').removeClass("danger").addClass("success").html(data.message);					  
						}else{						 
							jQuery('#responses').removeClass("success").addClass("danger").html(data.message);					 
						}
		 			});
			  }
		});

		jQuery("#column5").on('change',function(){
			let value = jQuery("#column5").val();
				let objInc =  document.querySelector('#col5');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
				let  post_data = "action=my_credential&param=column5&object=" + jQuery("#column5").val();
				jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
					let  data= jQuery.parseJSON(response);
					if(data.status==1){	
					        objInc.classList.remove('fa-spin','fa-spinner');
                            objInc.classList.add('fa-check-circle');
							jQuery('#responses').removeClass("danger").addClass("success").html(data.message);
					}else{						 
						jQuery('#responses').removeClass("success").addClass("danger").html(data.message);
					}
	 			});
			}
		});

		jQuery("#column6").on('change',function(){			
			let value = jQuery("#column6").val();
			let objInc =  document.querySelector('#col6');
                objInc.classList.add('fa-spinner','fa-spin');
			if(value!='value'){
			let  post_data = "action=my_credential&param=column6&object=" + jQuery("#column6").val();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){
				let  data= jQuery.parseJSON(response); 
				if(data.status==1){	
				        objInc.classList.remove('fa-spin','fa-spinner');
                        objInc.classList.add('fa-check-circle');
						jQuery('#responses').removeClass("danger").addClass("success").html(data.message);					  
				}else{						 
					jQuery('#responses').removeClass("success").addClass("danger").html(data.message);					 
				} 
 			});
		 }
		});

	jQuery("#edit_btn").click(function(){
		jQuery("#frm_editcredential").validate(); 			
			let  post_data = "action=my_credential&param=edit_credential&" + jQuery("#frm_editcredential").serialize();
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){ 
				let  data= jQuery.parseJSON(response);
				if(data.status==1){
					if(data.status==1){						 
							jQuery('#frm_editcredential').trigger("reset");
							jQuery('#response').removeClass("danger").addClass("success").html(data.message);
							setTimeout(function(){ 
							location.reload();
						},2000)
					}
				}else{
					jQuery('#response').removeClass("success").addClass("danger").html(data.message);								 
				} 
			});		
	});

	jQuery("#mapBtn").click(function(){		
			let  post_data = "action=my_credential&param=finalObject";
			jQuery.post(MYSCRIPT.ajaxUrl,post_data,function(response){ 
				let  data= jQuery.parseJSON(response);
				if(data.status==1){				 				 							 
					jQuery('#response').removeClass("danger").addClass("success").html(data.message);
					setTimeout(function(){
						jQuery('#response').removeClass("danger success").html('');
					},2000)				 
				}else{
					jQuery('#response').removeClass("success").addClass("danger").html(data.message);
					setTimeout(function(){
						jQuery('#response').removeClass("danger success").html('');
					},2000)								 
				} 
			});		
	});

		if(obj_status == '1'){ 			 
			jQuery('#getResponse').fadeIn(); 
			jQuery('#getResponse').removeClass('response_two').addClass('response_one').html('Connection Established Successfully !!.');
			setTimeout(function(){
				jQuery('#getResponse').fadeOut("slow");
			},2000)	

		}else{
			jQuery('#getResponse').fadeIn(); 
			jQuery('#getResponse').removeClass('response_one').addClass('response_two').html('Connection not Established.');
			setTimeout(function(){
				jQuery('#getResponse').fadeOut("slow");
			},2000)
		}
} );