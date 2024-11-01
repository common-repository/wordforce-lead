<?php 
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// contact form
$email_form = '<form id="wdfl"  class="'.$wdfl_atts['class'].'" method="post">';
if(empty($wdfl_show_title)) {
	$email_form .= (!empty($wdfl_form_title)?'<h3 class="wdfl-form-title">'.$wdfl_form_title.'</h3>':'');
}

if($wdfl_name != 'no'){	
	if(!empty($wdfl_label_setting)) {
		$email_form .='<div class="form-group asterisk wdfl-name-group">';
		if(isset($error_class['form_name'])) {
			$email_form .='<label for="wdfl_name"><span class="wdfl-error" >'.esc_attr($error_name_label).'</span></label>';
		}
		$email_form .='<input type="text" name="wdfl_name" id="wdfl_name" '.(isset($error_class['form_name']) ? ' class="form-control input-'.$wdfl_input_setting.'  wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr($form_data['form_name']).'" aria-required="true" placeholder="'.esc_attr($name_label).' *"/>
		</div>';
	}
	else {
	$email_form .='<div class="form-group required wdfl-name-group">
		<label for="wdfl_name">'.esc_attr($name_label).': <span class="'.(isset($error_class['form_name']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr($error_name_label).'</span></label>
		<input type="text" name="wdfl_name" id="wdfl_name" '.(isset($error_class['form_name']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr($form_data['form_name']).'" aria-required="true" />
	</div>';
	}
}

if($wdfl_email != 'no'){
	if(!empty($wdfl_label_setting)) {
		$email_form .='<div class="form-group wdfl-email-group">
			<input type="email" name="wdfl_email" required=""
			id="wdfl_email" '.(isset($error_class['form_email']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr($form_data['form_email']).'" aria-required="true"  placeholder="'.esc_attr($email_label).' *"/>
		</div>';
	}
	else {
		$email_form .='<div class="form-group wdfl-email-group">
			<label for="wdfl_email">'.esc_attr($email_label).': <span class="'.(isset($error_class['form_email']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr($error_email_label).'</span></label>
			<input type="email" name="wdfl_email" id="wdfl_email" '.(isset($error_class['form_email']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr($form_data['form_email']).'" aria-required="true" />
		</div>';
	}
}

if($wdfl_phone != 'no'){	
	if(!empty($wdfl_label_setting)) {
		$email_form .='<div class="form-group wdfl-phone-group">';
		if(isset($error_class['form_phone'])) {
			$email_form .='<label for="wdfl_phone"><span class="wdfl-error" >'.esc_attr($error_phone_label).'</span></label>';
		}
		$email_form .='<input type="text" name="wdfl_phone" id="wdfl_phone" '.(isset($error_class['form_phone']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_phone']).'" aria-required="true" placeholder="'.esc_attr($phone_label).' *"/>
		</div>';
	}
	else {
		$email_form .='<div class="form-group required wdfl-phone-group">
			<label for="wdfl_phone">'.esc_attr($phone_label).': <span class="'.(isset($error_class['form_phone']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr($error_phone_label).'</span></label>
			<input type="text" name="wdfl_phone" id="wdfl_phone" '.(isset($error_class['form_phone']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_phone']).'" aria-required="true" />
		</div>';
	}
}


if($wdfl_address != 'no'){	
	if($wdfl_address_format =='no') {
		if(!empty($wdfl_label_setting)) {
			$email_form .='
				<div class="form-group wdfl-address-ln1-group">
			<input type="text" name="wdfl_address_ln1" id="wdfl_address_ln1" '.(isset($error_class['form_address_ln1']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_ln1']).'" aria-required="true" placeholder="'.esc_attr($address_ln1_label).' *" />
			</div>';
			$email_form .='<div class="form-group wdfl-address-ln2-group">
			<input type="text" name="wdfl_address_ln2" id="wdfl_address_ln2" '.(isset($error_class['form_address_ln2']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_ln2']).'" aria-required="true" placeholder="'.esc_attr($address_ln2_label).'"/>
			</div>';
			$email_form .='<div class="row">
				<div class="col-md-4 mgrt0">
			<div class="form-group wdfl-address-city-group">
			<input type="text" name="wdfl_address_city" id="wdfl_address_city" '.(isset($error_class['form_address_city']) ? ' class="form-control wdfl-error input-'.$wdfl_input_setting.'"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_city']).'" aria-required="true" placeholder="'.esc_attr($address_city_label).'" />
			</div></div>';
			$email_form .='<div class="col-md-4 mgrt0"><div class="form-group wdfl-address-state-group">
			<input type="text" name="wdfl_address_state" id="wdfl_address_state" '.(isset($error_class['form_address_state']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_state']).'" aria-required="true" placeholder="'.esc_attr($address_state_label).'" />
			</div></div>';
			$email_form .='<div class="col-md-4"><div class="form-group wdfl-address-zip-group">
			<input type="text" name="wdfl_address_zip" id="wdfl_address_zip" '.(isset($error_class['form_address_zip']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_zip']).'" aria-required="true" placeholder="'.esc_attr($address_zip_label).'"/>
			</div></div></div>';
		}
		else {
			$email_form .='<div class="form-group wdfl-address-ln1-group">
			<label for="wdfl_address_ln1">'.esc_attr($address_ln1_label).': <span class="'.(isset($error_class['form_address_ln1']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr(@$error_address_ln1_label).'</span></label>
			<input type="text" name="wdfl_address_ln1" id="wdfl_address_ln1" '.(isset($error_class['form_address_ln1']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_ln1']).'" aria-required="true" />
			</div>';
			$email_form .='<div class="form-group wdfl-address-ln2-group">
			<label for="wdfl_address_ln2">'.esc_attr($address_ln2_label).': <span class="'.(isset($error_class['form_address_ln2']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr(@$error_address_ln2_label).'</span></label>
			<input type="text" name="wdfl_address_ln2" id="wdfl_address_ln2" '.(isset($error_class['form_address_ln2']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_ln2']).'" aria-required="true" />
			</div>';
			
			$email_form .='<div class="row"><div class="col-md-4 mgrt0"><div class="form-group wdfl-address-city-group">
			<label for="wdfl_address_city">'.esc_attr($address_city_label).': <span class="'.(isset($error_class['form_address_city']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr(@$error_address_city_label).'</span></label>
			<input type="text" name="wdfl_address_city" id="wdfl_address_city" '.(isset($error_class['form_address_city']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_city']).'" aria-required="true" />
			</div></div>';
			$email_form .='<div class="col-md-4 mgrt0"><div class="form-group wdfl-address-state-group">
			<label for="wdfl_address_state">'.esc_attr(@$address_state_label).': <span class="'.(isset($error_class['form_address_state']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr(@$error_address_state_label).'</span></label>
			<input type="text" name="wdfl_address_state" id="wdfl_address_state" '.(isset($error_class['form_address_state']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_state']).'" aria-required="true" />
			</div></div>';
			$email_form .='<div class="col-md-4"><div class="form-group wdfl-address-zip-group">
			<label for="wdfl_address_zip">'.esc_attr(@$address_zip_label).': <span class="'.(isset($error_class['form_address_zip']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr(@$error_address_zip_label).'</span></label>
			<input type="text" name="wdfl_address_zip" id="wdfl_address_zip" '.(isset($error_class['form_address_zip']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' value="'.esc_attr(@$form_data['form_address_zip']).'" aria-required="true" />
			</div></div></div>';
		}
	}
	else {
		if(!empty($wdfl_label_setting)) {
			$email_form .='<div class="form-group wdfl-address-group">
			<textarea required="" type="text" name="wdfl_address" id="wdfl_address" '.(isset($error_class['form_address']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' placeholder="'.$address_label.' *" aria-required="true">'.esc_attr(@$form_data['form_address']).'</textarea>
			</div>';
		}
		else {
			$email_form .='<div class="form-group wdfl-address-group">
			<label for="wdfl_address">'.esc_attr($address_label).': <span class="'.(isset($error_class['form_address']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr($error_address_label).'</span></label>
			<textarea type="text" name="wdfl_address" id="wdfl_address" '.(isset($error_class['form_address']) ? ' class="form-controlwdfl-error"' : ' class="form-control input-'.$wdfl_input_setting.'"').' aria-required="true">'.esc_attr(@$form_data['form_address']).'</textarea>
			</div>';
		}
	}
}

$email_form .='		
	<div class="form-group wdfl-hide">
		<input type="text" name="wdfl_firstname" id="wdfl_firstname" class="form-control" value="'.esc_attr(@$form_data['form_firstname']).'" />
	</div>
	<div class="form-group wdfl-hide">
		<input type="text" name="wdfl_lastname" id="wdfl_lastname" class="form-control" value="'.esc_attr(@$form_data['form_lastname']).'" />
	</div>';

if($wdfl_message != 'no'){
	if(!empty($wdfl_label_setting)) {
		$email_form .='<div class="form-group wdfl-message-group">';
			if(isset($error_class['form_message'])) {
				$email_form .='<label for="wdfl_message"><span class="wdfl-error" >'.esc_attr($error_message_label).'</span></label>';
			}
			$email_form .='<textarea name="wdfl_message" id="wdfl_message" rows="5" '.(isset($error_class['form_message']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control"').' aria-required="true" placeholder="'.esc_attr($message_label).' *">'.esc_textarea(@$form_data['form_message']).'</textarea>
			</div>';
	}
	else {
		$email_form .='	
			<div class="form-group required wdfl-message-group">
				<label for="wdfl_message">'.esc_attr($message_label).': <span class="'.(isset($error_class['form_message']) ? "wdfl-error" : "wdfl-hide").'" >'.esc_attr($error_message_label).'</span></label>
				<textarea name="wdfl_message" id="wdfl_message" rows="5" '.(isset($error_class['form_message']) ? ' class="form-control input-'.$wdfl_input_setting.' wdfl-error"' : ' class="form-control"').' aria-required="true">'.esc_textarea(@$form_data['form_message']).'</textarea>
			</div>';
	}
}

	
$email_form .='
	<div class="form-group wdfl-hide">
		'.$wdfl_nonce_field.'
	</div>
	<div class="form-group wdfl-submit-group">
		<button type="submit" name="'.$submit_name_id.'" id="'.$submit_name_id.'" class="btn btn-primary btn-'.$wdfl_input_setting.' wdfl-btn">'.esc_attr($submit_label).'</button>
	</div>
</form>';