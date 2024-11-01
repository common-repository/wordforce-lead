<?php 
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// validate name
$value = stripslashes($post_data['form_name']);
if ( strlen($value) < 2 ) {
	$error_class['form_name'] = true;
	$error = true;
}
$form_data['form_name'] = $value;

// validate email
$value = $post_data['form_email'];
/*if ( empty($value) ) {
	$error_class['form_email'] = true;
	$error = true;
}*/
if(!empty($value)) {
	if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
		$error_class['form_email'] = true;
		$error = true;
	}
}

$form_data['form_email'] = $value;

// validate phone
$value = stripslashes($post_data['form_phone']);
if ( strlen($value) < 14 ||  strlen($value) > 14) {
	$error_class['form_phone'] = true;
	$error = true;
}
$form_data['form_phone'] = $value;

// validate form_address
$value = stripslashes($post_data['form_address']);
if ( strlen($value) < 4 ) {
	$error_class['form_address'] = true;
	$error = true;
}
$form_data['form_address'] = $value;
 

// validate form_address_ln1
//$value = stripslashes($post_data['form_address_ln1']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_ln1'] = $value;

// validate form_address_ln2
//$value = stripslashes($post_data['form_address_ln2']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_ln2'] = $value;

// validate form_address_city
//$value = stripslashes($post_data['form_address_city']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_city'] = $value;

// validate form_address_state
//$value = stripslashes($post_data['form_address_state']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_state'] = $value;

// validate form_address_state
//$value = stripslashes($post_data['form_address_state']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_state'] = $value;

// validate form_address_zip
//$value = stripslashes($post_data['form_address_zip']);
/*if ( strlen($value) < 2 ) {
	$error_class['form_phone'] = true;
	$error = true;
}*/
$form_data['form_address_zip'] = $value;

// validate message
$value = stripslashes($post_data['form_message']);
if ( strlen($value)<4 ) {
	$error_class['form_message'] = true;
	$error = true;
}
$form_data['form_message'] = $value;

// validate first honeypot field
$value = stripslashes($post_data['form_firstname']);
if ( strlen($value)>0 ) {
	$error = true;
}
$form_data['form_firstname'] = $value;

// validate second honeypot field
$value = stripslashes($post_data['form_lastname']);
if ( strlen($value)>0 ) {
	$error = true;
}
$form_data['form_lastname'] = $value;
