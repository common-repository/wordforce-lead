<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
    
    
// sending and saving form submission
if ($error == false) {
	
	// hook to support plugin Contact Form DB
	do_action( 'wdfl_before_send_mail', $form_data );
	// site name
	$blog_name = htmlspecialchars_decode(get_bloginfo('name'), ENT_QUOTES);
	
	// email address admin
	$email_admin = 'admin@gmail.com';
	$email_settings = get_option('sales-setting-22');
	if (!empty($wdfl_atts['email_to'])) {
		$to = $wdfl_atts['email_to'];
	} else {
		if (!empty($email_settings)) {
			$to = $email_settings;
		} else {
			$to = $email_admin;
		}
	}
	
	// from email 
	$from = get_option('admin_email');
	$subject = "(".$blog_name.") WordForce Lead";
	
	// show or hide ip address
	if ($ip_address_setting == 'yes') {
		$ip_address = '';
	} else {
		$ip_address = sprintf( esc_attr__( 'IP: %s', 'sales-lead-form' ), wdfl_get_the_ip() );
	}
	 
	$form_data['form_phone'] = str_replace("(","",$form_data['form_phone']);
	$form_data['form_phone'] = str_replace(")","",$form_data['form_phone']);
	$form_data['form_phone'] = str_replace("-","",$form_data['form_phone']);
	
	$content = $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email']. "\r\n\r\n" . $form_data['form_phone']. "\r\n\r\n" . $form_data['form_address']. "\r\n\r\n" . $form_data['form_message'] . "\r\n\r\n" . $ip_address;
	
	// save form submission in database
	if ($list_submissions_setting == 'yes') {
		$wdfl_post_information = array(
			'post_title' => wp_strip_all_tags($subject),
			'post_content' => $content,
			'post_type' => 'submission',
			'post_status' => 'pending',
			'meta_input' => array( "name_sub" => $form_data['form_name'],
			"email_sub" => $form_data['form_email'] )
		);
		$post_id = wp_insert_post($wdfl_post_information);
	}
	// mail
	
	$headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
	$headers .= "From: ".$form_data['form_name']." <".$from.">" . "\r\n";
	 
	$auto_reply_headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
	$auto_reply_headers .= "From: ".$blog_name." <".$from.">" . "\r\n";
	
	//wp_mail(esc_attr($to), wp_strip_all_tags($subject), $content, $headers);
	// get POST (or GET) data
	$GLPDomain  =  sanitize_text_field($blog_name);
	$name_first = sanitize_text_field($form_data['form_name']);
	$name_last  = "";
	$email  	= sanitize_email($form_data['form_email']);
	$lead_notes  = sanitize_textarea_field($form_data['form_message']);
	$lead_notesnew = stripslashes($lead_notes);
	$phone_number  = sanitize_text_field($form_data['form_phone']);
	$street_line1  = sanitize_textarea_field($form_data['form_address']);
	//$zip  = $form_data['wdfl_address_zip'];
	$IPAddress  = $ip_address;
	$CompanyName = ""; //$_REQUEST["CompanyName"];
	$CompanySize = ""; //$_REQUEST["CompanySize"];
	$HttpReferrer = $_SERVER['HTTP_REFERER'];
	// tests
	$domain = get_option('siteurl');
	$domain = str_replace('http://', '', $domain);
	$domain = str_replace('https://', '', $domain);
	$domain = str_replace('www', '', $domain);
	$domain = str_replace('/', '', $domain);
	//echo $domain = strstr($domain, '/', true);
		// 
	 $GLPDomain = $domain;
 

	 	$table2="wdfl_credentials";
	 	
		$cur_id='1';
		$data2=wdfl_get_particular_data_form_table($table2,$cur_id);

		$table3="wdfl_form_object";	  
		$columnDetails=wdfl_get_particular_data_form_table($table3,$cur_id);

		$post_data_api = json_encode(array( 		
		
			$columnDetails['col1']	=> $columnDetails['leadTitle'],
			$columnDetails['col2']  => $name_first,
			$columnDetails['col3']	=> $email,
			$columnDetails['col4']	=> $phone_number,
			$columnDetails['col5']	=> $street_line1,
			$columnDetails['col6']	=> $lead_notes 

		)); 

		   //for check our data in JSON object form
			// print_r($post_data_api);
			// die();
			
  
    $WDFLSalesforceAPI = new WDFL_Salesforce_API();
    
	$return_array = $WDFLSalesforceAPI->wdfl_post_data_in_salesforce($post_data_api,'');

		//  for check response from salesforce
			// print_r($return_array);
			// die();
	 
	if(isset($return_array[0]) && $return_array[0] == 'false') {	 
 
		$fail = true;
	}
	else {
		 
		$sent = true;
	}

}