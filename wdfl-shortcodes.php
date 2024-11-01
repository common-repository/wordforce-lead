<?php 
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
// shortcode for page
function wdfl_shortcode($wdfl_atts) {
	// attributes
	$wdfl_atts = shortcode_atts(array(
		'class' => 'wdfl-container',
		'email_to' => '',
		'from_header' => wdfl_from_header(),
		'prefix_subject' => '',
		'subject' => '',
		'label_name' => '',
		'label_email' => '',
		'label_subject' => '',
		'label_captcha' => '',
		'label_captcha_sum' => '',
		'label_message' => '',
		'label_privacy' => '',
		'label_submit' => '',
		'error_name' => '',
		'error_email' => '',
		'error_subject' => '',
		'error_captcha' => '',
		'error_captcha_sum' => '',
		'error_message' => '',
		'message_success' => '',
		'message_error' => '',
		'auto_reply_message' => ''
	), $wdfl_atts);

	// initialize variables
	$form_data = array(
		'form_name' => '',
		'form_email' => '',
		'form_subject' => '',
		'form_captcha' => '',
		'form_captcha_hidden_one' => '',
		'form_captcha_hidden_two' => '',
		'form_message' => '',
		'form_privacy' => '',
		'form_firstname' => '',
		'form_lastname' => ''
	);
	$error = false;
	$sent = false;
	$fail = false;

	// include variables
	include WDFL_PLUGIN_DIR.'/wdfl-variables.php';

	// set nonce field
	$wdfl_nonce_field = wp_nonce_field( 'wdfl_nonce_action', 'wdfl_nonce', true, false );

	// name and id of submit button
	$submit_name_id = 'wdfl_send';

	// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && sanitize_text_field(isset($_POST['wdfl_send'])) && sanitize_text_field(isset( $_POST['wdfl_nonce']) ) && wp_verify_nonce( $_POST['wdfl_nonce'], 'wdfl_nonce_action' ) ) {
		// sanitize input
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['wdfl_name']),
			'form_email' => sanitize_email($_POST['wdfl_email']), 
			'form_phone' => sanitize_text_field($_POST['wdfl_phone']),
			'form_address' => sanitize_textarea_field($_POST['wdfl_address']), 
			'form_firstname' => sanitize_text_field($_POST['wdfl_firstname']),
			'form_lastname' => sanitize_text_field($_POST['wdfl_lastname']),
			'form_message' => sanitize_textarea_field($_POST['wdfl_message'])
		);

		// include validation
		include WDFL_PLUGIN_DIR.'/wdfl-validate.php';
		
		// api functions 
		//include(plugin_dir_path( __FILE__ ).'salesforce.php');

		// include sending and saving form submission
		include WDFL_PLUGIN_DIR.'/wdfl-submission.php';
	}

		// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['wdfl_send_re']) && isset( $_POST['wdfl_nonce'] ) && wp_verify_nonce( $_POST['wdfl_nonce'], 'wdfl_nonce_action' ) ) {
		echo "yes";
		// sanitize input
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['wdfl_name']),
			'form_email' => sanitize_email($_POST['wdfl_email']),
			//'form_url' => sanitize_url($_POST['wdfl_url']),
			'form_phone' => sanitize_text_field($_POST['wdfl_phone']),
			'form_address' => sanitize_textarea_field($_POST['wdfl_address']), 
			'form_firstname' => sanitize_text_field($_POST['wdfl_firstname']),
			'form_lastname' => sanitize_text_field($_POST['wdfl_lastname'])
		);

		// include validation
		include WDFL_PLUGIN_DIR.'/wdfl-validate.php';
		
		// api functions 
		//include(plugin_dir_path( __FILE__ ).'salesforce.php');

		// include sending and saving form submission
		include WDFL_PLUGIN_DIR.'/wdfl-submission.php';
	}

	// include form
	include WDFL_PLUGIN_DIR. '/wdfl-form.php';

	// after form validation
	if ($sent == true) {
		return '<script type="text/javascript">window.location="'.wdfl_redirect_success().'"</script>';
	} elseif ($fail == true) {
		///return '<script type="text/javascript">window.location="'.wdfl_redirect_error().'"</script>';
		return '<p id="wdflnc" class="wdfl-info wdfl-error">'.esc_attr($server_error_message).'</p>' .esc_attr($anchor_begin).sanitize_email($email_form). esc_attr($anchor_end);
	}

	// display form or the result of submission
	if ( sanitize_text_field(isset($_GET['wdfl-sh'])) ) {
		if ( sanitize_text_field($_GET['wdfl-sh']) == 'success' ) {
			//$form_data = array();
			//return $anchor_begin . '<p class="wdfl-info">'.esc_attr($thank_you_message).'</p>' . $anchor_end;
			//echo "sadas";
			return '<p id="wdflnc" class="wdfl-info wdfl-success">'.esc_attr($thank_you_message).'</p>'.$email_form;
		}/* elseif ( $_GET['wdfl-sh'] == 'fail' ) {
			//return $anchor_begin . '<p class="wdfl-info">'.esc_attr($server_error_message).'</p>' . $anchor_end;
			return '<p class="wdfl-info">'.esc_attr($server_error_message).'</p>' .$email_form;
		}*/	
	} else {
		if ($error == true) {
			return '<p id="wdflnc" class="wdfl-info wdfl-success"></p>' .$email_form. $anchor_end;
		} else {
			return $email_form;
		}
	}	   		
} 
add_shortcode('WF_LEAD', 'wdfl_shortcode');
