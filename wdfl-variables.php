<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wdfl_form_title = get_option('wdfl-setting-55');
if(empty($wdfl_form_title)) {
	$wdfl_form_title = "WordForce Lead";
}
$wdfl_admin_email = get_option('wdfl-setting-22');

$wdfl_show_title = get_option( 'wdfl-setting-102' );
if(empty($wdfl_show_title)) {
	$wdfl_show_title = "yes";
}

$wdfl_name = get_option('wdfl-setting-78');
$wdfl_phone = get_option('wdfl-setting-57');
$wdfl_email = get_option('wdfl-setting-63');
$wdfl_address = get_option('wdfl-setting-59');
$wdfl_address_format = get_option('wdfl-setting-61');
$wdfl_message = get_option('wdfl-setting-62');
$wdfl_api_key = get_option('wdfl-setting-65');

$name_label = $wdfl_name_label = get_option('wdfl-setting-56');

$phone_label = $wdfl_phone_label = get_option('wdfl-setting-58');
$email_label = $wdfl_email_label = get_option('wdfl-setting-6');
$user_label = $wdfl_user_label = get_option('wdfl-setting-a');
$pass_label = $wdfl_pass_label = get_option('wdfl-setting-b');
$url_label = $wdfl_url_label = get_option('wdfl-setting-c');
$address_label = $wdfl_address_label = get_option('wdfl-setting-60');
if(empty($address_label)) {
	$address_label = "Address";
}
$message_label = $wdfl_message_label = get_option('wdfl-setting-9');

$wdfl_label_setting = get_option('wdfl-setting-68');
if($wdfl_label_setting == "") {
	$wdfl_label_setting = 1;
}

/// design
$wdfl_input_setting = get_option('wdfl-setting-69');

if(empty($wdfl_input_setting)) {
	$wdfl_input_setting = 'md';
}
$wdfl_input_font_setting = get_option('wdfl-setting-70');
if(empty($wdfl_input_font_setting)) {
	$wdfl_input_font_setting = 14;
}
$wdfl_button_font_size = get_option('wdfl-setting-71');
if(empty($wdfl_button_font_size)) {
	$wdfl_button_font_size = 14;
}
$wdfl_form_field_shadow = get_option('wdfl-setting-72');
if(empty($wdfl_form_field_shadow) || $wdfl_form_field_shadow  == 'yes') {
	$wdfl_form_field_shadow ='0px 2px 4px rgba(0, 0, 0, 0.07);';
}
else {
	$wdfl_form_field_shadow ='none';
}
$wdfl_field_radius = get_option('wdfl-setting-73');
if(empty($wdfl_field_radius)) {
	$wdfl_field_radius = "2";
}
$wdfl_form_radius = get_option('wdfl-setting-74');
if(empty($wdfl_form_radius)) {
	$wdfl_form_radius = "2";
}
$wdfl_form_back_color = get_option('wdfl-setting-77');
if(empty($wdfl_form_back_color)) {
	$wdfl_form_back_color = "#FFFFFF";
}

$wdfl_form_show_back = get_option( 'wdfl-setting-101' );
if(empty($wdfl_form_show_back)) {
	$wdfl_form_show_back = "yes";
}

$wdfl_button_txt_color = get_option('wdfl-setting-75');
if(empty($wdfl_button_txt_color)) {
	$wdfl_button_txt_color = "#FFFFFF";
}
$wdfl_button_back_color = get_option('wdfl-setting-76');
if(empty($wdfl_button_back_color)) {
	$wdfl_button_back_color = "#FF8000";
}
$wdfl_button_align = get_option('wdfl-setting-81');
if(empty($wdfl_button_align)) {
	$wdfl_button_align = 'center';
}

$wdfl_button_size = get_option('wdfl-setting-82');
if(empty($wdfl_button_size)) {
	$wdfl_button_size = '50';
}

$wdfl_form_error_color = get_option('wdfl-setting-120');
if(empty($wdfl_form_error_color)) {
	$wdfl_form_error_color = "#FF0000";
}

$wdfl_form_success_color = get_option('wdfl-setting-121');
if(empty($wdfl_form_success_color)) {
	$wdfl_form_success_color = "#008000";
}

$address_ln1_label = "";
$address_ln2_label = "";
$address_state_label = "";
$address_city_label = "";
$address_zip_label = "";
$error_phone_label = "";
$error_captcha_label = "";


// get custom settings from settingspage
$list_submissions_setting = get_option('wdfl-setting-2');
$subject_setting = get_option('wdfl-setting-23');
$captcha_setting = get_option('wdfl-setting-24');
$auto_reply_setting = get_option('wdfl-setting-3');
$privacy_setting = get_option('wdfl-setting-4');
$ip_address_setting = get_option('wdfl-setting-19');
$anchor_setting = get_option('wdfl-setting-21');

// get custom labels from settingspage
//$name_label = get_option('wdfl-setting-5');
//$email_label = get_option('wdfl-setting-6');
//$subject_label = get_option('wdfl-setting-7');
//$message_label = get_option('wdfl-setting-9');
$submit_label = get_option('wdfl-setting-10');
if(empty($submit_label)) {
	$submit_label = "Submit";
}
$error_name_label = "Name field is required";//get_option('wdfl-setting-11');
$error_email_label = "Invalid email id";//get_option('wdfl-setting-13');
$error_message_label = "Message field is required";//get_option('wdfl-setting-12');

// get custom messages from settingspage
$server_error_message = get_option('wdfl-setting-15');
$thank_you_message = get_option('wdfl-setting-16');


// name label
$value = $name_label;
if (empty($wdfl_atts['label_name'])) {
	if (empty($value)) {
		$name_label = __( 'Name', 'wdfl-form' );
	} else {
		$name_label = $value;
	}
} else {
	$name_label = $wdfl_atts['label_name'];
}

// email label
$value = $email_label;
if (empty($wdfl_atts['label_email'])) {
	if (empty($value)) {
		$email_label = __( 'Email', 'wdfl-form' );
	} else {
		$email_label = $value;
	}
} else {
	$email_label = $wdfl_atts['label_email'];
}

// username label
$value = $user_label;
if (empty($wdfl_atts['label_user'])) {
	if (empty($value)) {
		$user_label = __( 'Username', 'wdfl-form' );
	} else {
		$user_label = $value;
	}
} else {
	$user_label = $wdfl_atts['label_user'];
}

// password label
$value = $pass_label;
if (empty($wdfl_atts['label_pass'])) {
	if (empty($value)) {
		$pass_label = __( 'Password', 'wdfl-form' );
	} else {
		$pass_label = $value;
	}
} else {
	$pass_label = $wdfl_atts['label_pass'];
}

// phone label
$value = $phone_label;
if (empty($wdfl_atts['label_phone'])) {
	if (empty($value)) {
		$phone_label = __( 'Phone', 'wdfl-form' );
	} else {
		$phone_label = $value;
	}
} else {
	$phone_label = $wdfl_atts['label_phone'];
}

// address label
$value = $address_label;
if (empty($wdfl_atts['address_label'])) {
	if (empty($value)) {
		$address_label = __( 'Address', 'wdfl-form' );
	} else {
		$address_label = $value;
	}
} else {
	$address_label = $wdfl_atts['address_label'];
}

// address label line 1
$value = $address_ln1_label;
if (empty($wdfl_atts['address_ln1_label'])) {
	if (empty($value)) {
		$address_ln1_label = __( 'Address Line 1', 'wdfl-form' );
	} else {
		$address_ln1_label = $value;
	}
} else {
	$address_ln1_label = $wdfl_atts['address_ln1_label'];
}

// address label line 2
$value = $address_ln2_label;
if (empty($wdfl_atts['address_ln2_label'])) {
	if (empty($value)) {
		$address_ln2_label = __( 'Address Line 2', 'wdfl-form' );
	} else {
		$address_ln2_label = $value;
	}
} else {
	$address_ln2_label = $wdfl_atts['address_ln2_label'];
}

// address label state
$value = $address_state_label;
if (empty($wdfl_atts['address_state_label'])) {
	if (empty($value)) {
		$address_state_label = __( 'State', 'wdfl-form' );
	} else {
		$address_state_label = $value;
	}
} else {
	$address_state_label = $wdfl_atts['address_state_label'];
}

// address label state
$value = $address_city_label;
if (empty($wdfl_atts['address_city_label'])) {
	if (empty($value)) {
		$address_city_label = __( 'City', 'wdfl-form' );
	} else {
		$address_city_label = $value;
	}
} else {
	$address_city_label = $wdfl_atts['address_city_label'];
}

// address label zip
$value = $address_zip_label;
if (empty($wdfl_atts['address_zip_label'])) {
	if (empty($value)) {
		$address_zip_label = __( 'Zip', 'wdfl-form' );
	} else {
		$address_zip_label = $value;
	}
} else {
	$address_zip_label = $wdfl_atts['address_zip_label'];
}

// message label
$value = $message_label;
if (empty($wdfl_atts['label_message'])) {
	if (empty($value)) {
		$message_label = __( 'Message', 'wdfl-form' );
	} else {
		$message_label = $value;
	}
} else {
	$message_label = $wdfl_atts['label_message'];
}

// submit label
$value = $submit_label;
if (empty($wdfl_atts['label_submit'])) {
	if (empty($value)) {
		$submit_label = __( 'Submit', 'wdfl-form' );
	} else {
		$submit_label = $value;
	}
} else {
	$submit_label = $wdfl_atts['label_submit'];
}

// error name label
$value = $error_name_label;
if (empty($wdfl_atts['error_name'])) {
	if (empty($value)) {
		$error_name_label = __( 'Please enter at least 2 characters', 'wdfl-form' );
	} else {
		$error_name_label = $value;
	}
} else {
	$error_name_label = $wdfl_atts['error_name'];
}

// error email label
$value = $error_email_label;
if (empty($wdfl_atts['error_email'])) {
	if (empty($value)) {
		$error_email_label = __( 'Please enter a valid email', 'wdfl-form' );
	} else {
		$error_email_label = $value;
	}
} else {
	$error_email_label = $wdfl_atts['error_email'];
}

// error name label
$value = $error_phone_label;
if (empty($wdfl_atts['error_phone'])) {
	if (empty($value)) {
		$error_phone_label = __( 'Phone field is required', 'wdfl-form' );
	} else {
		$error_phone_label = $value;
	}
} else {
	$error_phone_label = $wdfl_atts['error_phone'];
}


// error subject label
/*$value = $error_subject_label;
if (empty($wdfl_atts['error_subject'])) {
	if (empty($value)) {
		$error_subject_label = __( 'Please enter at least 2 characters', 'wdfl-form' );
	} else {
		$error_subject_label = $value;
	}
} else {
	$error_subject_label = $wdfl_atts['error_subject'];
}*/

// error captcha label
$value = $error_captcha_label;
if (empty($wdfl_atts['error_captcha'])) {
	if (empty($value)) {
		$error_captcha_label = __( 'Please enter the correct number', 'wdfl-form' );
	} else {
		$error_captcha_label = $value;
	}
} else {
	$error_captcha_label = $wdfl_atts['error_captcha'];
}

// error captcha label sum
/*$value = $error_captcha_label_sum;
if (empty($wdfl_atts['error_captcha_sum'])) {
	if (empty($value)) {
		$error_captcha_label_sum = __( 'Please enter the correct result', 'wdfl-form' );
	} else {
		$error_captcha_label_sum = $value;
	}
} else {
	$error_captcha_label_sum = $wdfl_atts['error_captcha_sum'];
}*/

// error message label
$value = $error_message_label;
if (empty($wdfl_atts['error_message']) || empty($value)) {
	if (empty($value)) {
		$error_message_label = __( 'Please enter at least 10 characters', 'wdfl-form' );
	} else {
		$error_message_label = $value;
	}
} else {
	$error_message_label = $wdfl_atts['error_message'];
}

// server error message
$value = $server_error_message;
if (empty($wdfl_atts['message_error'])) {
	if (empty($value)) {
		$server_error_message= __( 'Error: "Your request was unable to be completed at this time. Please check that your information was entered correctly or try again later, thank you.', 'wdfl-form' );
	} else {
		$server_error_message = $value;
	}
} else {
	$server_error_message = $wdfl_atts['message_error'];
}

// thank you message
$value = sanitize_text_field($thank_you_message);
if (empty($wdfl_atts['message_success']) || empty(sanitize_text_field($value))) {
	if (empty($value)) {
		$thank_you_message = __( 'Thank you for your response.', 'wdfl-form' );
	} else {
		$thank_you_message = $value;
	}
} else {
	$thank_you_message = $wdfl_atts['message_success'];
}

// form anchor
if (sanitize_text_field($anchor_setting) == 'yes') {
	$anchor_begin = '<div id="wdfl-anchor">';
	$anchor_end = '</div>';
} else {
	$anchor_begin = '';
	$anchor_end = '';
}