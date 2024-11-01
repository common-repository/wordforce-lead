<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
  



// add admin options page
function wdfl_menu_page() {

    add_menu_page( esc_attr__( 'WordForce Lead', 'wordforce-lead-form' ), esc_attr__( 'WordForce Lead', 'wordforce-lead-form' ), 'manage_options', 'wdfl-general', 'wordforce_new_account','dashicons-cloud-upload',21 );

    add_submenu_page('wdfl-general','WordForce Lead','Credential Settings','manage_options','wdfl-general','wordforce_new_account');
    
    // add_submenu_page('wdfl-general','WordForce Lead','Create new account','manage_options','wdfl-add-new-account','wordforce_new_account');
 	
 	add_submenu_page('wdfl-general','WordForce Lead','Map Form Fields','manage_options','wdfl-map-form-fields','wordforce_map_form_fields');

    
    add_submenu_page('wdfl-general','WordForce Lead','View Submitted Data','manage_options','view-submit-data','wdfl_form_data_list');

    add_submenu_page('wdfl-general','WordForce Lead','Form Settings','manage_options','wdfl-form-setting','wordforce_options_page');


}
add_action( 'admin_menu', 'wdfl_menu_page' );
//disabled="disabled"
// add admin settings and such


function wdfl_admin_init() {
	
	add_settings_section( 'wdfl-general-section-g', esc_attr__( 'General Settings', 'wordforce-lead-form' ), '', 'wdfl-general' );
 
	
	add_settings_field( 'wdfl-field-99', esc_attr__( 'Shortcode', 'wordforce-lead-form' ), 'wdfl_field_callback_99', 'wdfl-general', 'wdfl-general-section-g' );
	
	
	add_settings_section( 'wdfl-general-section', esc_attr__( 'Basic Fields', 'wordforce-lead-form' ), '', 'wdfl-general' );
	
	// name
	add_settings_field( 'wdfl-field-78', esc_attr__( 'Show Name Field', 'wordforce-lead-form' ), 'wdfl_field_callback_78', 'wdfl-general', 'wdfl-general-section' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-78', array('sanitize_callback' => 'sanitize_key') );
	
	//phone
	add_settings_field( 'wdfl-field-57', esc_attr__( 'Show Phone Field', 'wordforce-lead-form' ), 'wdfl_field_callback_57', 'wdfl-general', 'wdfl-general-section' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-57', array('sanitize_callback' => 'sanitize_key') );
	
	//email
	add_settings_field( 'wdfl-field-63', esc_attr__( 'Show Email Field', 'wordforce-lead-form' ), 'wdfl_field_callback_63', 'wdfl-general', 'wdfl-general-section' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-63', array('sanitize_callback' => 'sanitize_key') );
	
	
	add_settings_section( 'wdfl-general-section-a', esc_attr__( 'Choose Address Fields', 'wordforce-lead-form' ), '', 'wdfl-general' );
	//comment
	add_settings_field( 'wdfl-field-59', esc_attr__( 'Show Address Field', 'wordforce-lead-form' ), 'wdfl_field_callback_59', 'wdfl-general', 'wdfl-general-section-a' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-59', array('sanitize_callback' => 'sanitize_key') );
	
	// address format
	add_settings_field( 'wdfl-field-61', esc_attr__( 'Address Field Format', 'wordforce-lead-form' ), 'wdfl_field_callback_61', 'wdfl-general', 'wdfl-general-section-a' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-61', array('sanitize_callback' => 'sanitize_key') );
	
	add_settings_section( 'wdfl-general-section-m', esc_attr__( 'Choose Message Fields', 'wordforce-lead-form' ), '', 'wdfl-general' );

	// message
	add_settings_field( 'wdfl-field-62', esc_attr__( 'Message/Comment Field', 'wordforce-lead-form' ), 'wdfl_field_callback_62', 'wdfl-general', 'wdfl-general-section-m' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-62', array('sanitize_callback' => 'sanitize_key') );
	
	/*add_settings_field( 'wdfl-field-65', esc_attr__( 'API Key', 'wordforce-lead-form' ), 'wdfl_field_callback_65', 'wdfl-general', 'wdfl-general-section' );
	register_setting( 'wdfl-api-options', 'wdfl-setting-65', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-23', esc_attr__( 'Subject', 'wordforce-lead-form' ), 'wdfl_field_callback_23', 'wdfl-general', 'wdfl-general-section' );
	register_setting( 'wdfl-general-options', 'wdfl-setting-23', array('sanitize_callback' => 'sanitize_key') );
	*/


	/*  credentials setting  */

	add_settings_section( 'wdfl-credential-section', esc_attr__( 'Credentials Setting', 'wordforce-lead-form' ), '', 'credential_options' );
	
	add_settings_field( 'wdfl-field-60', esc_attr__( 'Username', 'wordforce-lead-form' ), 'wdfl_field_callback_a', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-a', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'wdfl-field-9', esc_attr__( 'Password', 'wordforce-lead-form' ), 'wdfl_field_callback_b', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-b', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'wdfl-field-22', esc_attr__( 'Initial URL', 'wordforce-lead-form' ), 'wdfl_field_callback_c', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-c', array('sanitize_callback' => 'sanitize_url') );

	//name
	add_settings_field( 'wdfl-field-56', esc_attr__( 'Owner Id', 'wordforce-lead-form' ), 'wdfl_field_callback_d', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-d', array('sanitize_callback' => 'sanitize_text_field') );
	
	//phone
	add_settings_field( 'wdfl-field-58', esc_attr__( 'Client Id', 'wordforce-lead-form' ), 'wdfl_field_callback_e', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-e', array('sanitize_callback' => 'sanitize_text_field') );
	
	//email
	add_settings_field( 'wdfl-field-6', esc_attr__( 'Client Secret Id', 'wordforce-lead-form' ), 'wdfl_field_callback_f', 'credential_options', 'wdfl-credential-section' );
	register_setting( 'wdfl-credential-options', 'wdfl-setting-f', array('sanitize_callback' => 'sanitize_text_field') );

	


	/*  credentials setting  */


	
	/*** label option starts **/
	add_settings_section( 'wdfl-label-section', esc_attr__( 'Form Labels', 'wordforce-lead-form' ), '', 'wdfl-label' );
	
	//name
	add_settings_field( 'wdfl-field-56', esc_attr__( 'Label of Name Field', 'wordforce-lead-form' ), 'wdfl_field_callback_56', 'wdfl-label', 'wdfl-label-section' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-56', array('sanitize_callback' => 'sanitize_text_field') );
	
	//phone
	add_settings_field( 'wdfl-field-58', esc_attr__( 'Label of Phone Field', 'wordforce-lead-form' ), 'wdfl_field_callback_58', 'wdfl-label', 'wdfl-label-section' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-58', array('sanitize_callback' => 'sanitize_text_field') );
	
	//email
	add_settings_field( 'wdfl-field-6', esc_attr__( 'Label of Email Field', 'wordforce-lead-form' ), 'wdfl_field_callback_6', 'wdfl-label', 'wdfl-label-section' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-6', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_section( 'wdfl-label-section-a', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-label' );
	
	//address
	add_settings_field( 'wdfl-field-60', esc_attr__( 'Label of Address Field', 'wordforce-lead-form' ), 'wdfl_field_callback_60', 'wdfl-label', 'wdfl-label-section-a' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-60', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_section( 'wdfl-label-section-m', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-label' );
	
	//message
	add_settings_field( 'wdfl-field-9', esc_attr__( 'Label of Message', 'wordforce-lead-form' ), 'wdfl_field_callback_9', 'wdfl-label', 'wdfl-label-section-m' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-9', array('sanitize_callback' => 'sanitize_text_field') );
	
	/*
	add_settings_field( 'wdfl-field-7', esc_attr__( 'Subject', 'wordforce-lead-form' ), 'wdfl_field_callback_7', 'wdfl-label', 'wdfl-label-section' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-7', array('sanitize_callback' => 'sanitize_text_field') );*/

	add_settings_section( 'wdfl-label-section-b', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-label' );

	add_settings_field( 'wdfl-field-10', esc_attr__( 'On Button', 'wordforce-lead-form' ), 'wdfl_field_callback_10', 'wdfl-label', 'wdfl-label-section-b' );
	register_setting( 'wdfl-label-options', 'wdfl-setting-10', array('sanitize_callback' => 'sanitize_text_field') );
 
 
	
	/*** design settings **/
	add_settings_section( 'wdfl-design-section', esc_attr__( 'Form Customization', 'wordforce-lead-form' ), '', 'wdfl-design' );
	
	
	
	add_settings_field( 'wdfl-field-72', esc_attr__( 'Form Field Shadow', 'wordforce-lead-form' ), 'wdfl_field_callback_72', 'wdfl-design', 'wdfl-design-section' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-72', array('sanitize_callback' => 'sanitize_key') );
	
	
	add_settings_field( 'wdfl-field-74', esc_attr__( 'Form Border Radius', 'wordforce-lead-form' ), 'wdfl_field_callback_74', 'wdfl-design', 'wdfl-design-section' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-74', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-73', esc_attr__( 'Fields Border Radius', 'wordforce-lead-form' ), 'wdfl_field_callback_73', 'wdfl-design', 'wdfl-design-section' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-73', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'wdfl-field-68', esc_attr__( '', 'wordforce-lead-form' ), 'wdfl_field_callback_68', 'wdfl-design', 'wdfl-design-section' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-68', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_section( 'wdfl-design-section-i', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-design' );
	
	add_settings_field( 'wdfl-field-69', esc_attr__( 'Input Field Size', 'wordforce-lead-form' ), 'wdfl_field_callback_69', 'wdfl-design', 'wdfl-design-section-i' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-69', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-70', esc_attr__( 'Input Font', 'wordforce-lead-form' ), 'wdfl_field_callback_70', 'wdfl-design', 'wdfl-design-section-i' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-70', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_section( 'wdfl-design-section-b', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-design' );
	
	
	add_settings_field( 'wdfl-field-71', esc_attr__( 'Button Font', 'wordforce-lead-form' ), 'wdfl_field_callback_71', 'wdfl-design', 'wdfl-design-section-b' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-71', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-82', esc_attr__( 'Button Size(%)', 'wordforce-lead-form' ), 'wdfl_field_callback_82', 'wdfl-design', 'wdfl-design-section-b' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-82', array('sanitize_callback' => 'sanitize_text_field') );
	

	add_settings_field( 'wdfl-field-81', esc_attr__( 'Button Align', 'wordforce-lead-form' ), 'wdfl_field_callback_81', 'wdfl-design', 'wdfl-design-section-b' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-81', array('sanitize_callback' => 'sanitize_text_field') );
	
	
	add_settings_section( 'wdfl-design-section-c', esc_attr__( '', 'wordforce-lead-form' ), '', 'wdfl-design' );
	
	add_settings_field( 'wdfl-field-77', esc_attr__( 'Form Background Color', 'wordforce-lead-form' ), 'wdfl_field_callback_77', 'wdfl-design', 'wdfl-design-section-c' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-77', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-101', esc_attr__( 'Form Background', 'wordforce-lead-form' ), 'wdfl_field_callback_101', 'wdfl-design', 'wdfl-design-section-c' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-101', array('sanitize_callback' => 'sanitize_text_field') );
	
	
	add_settings_field( 'wdfl-field-75', esc_attr__( 'Button Text', 'wordforce-lead-form' ), 'wdfl_field_callback_75', 'wdfl-design', 'wdfl-design-section-c' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-75', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-76', esc_attr__( 'Button Background', 'wordforce-lead-form' ), 'wdfl_field_callback_76', 'wdfl-design', 'wdfl-design-section-c' );
	register_setting( 'wdfl-design-options', 'wdfl-setting-76', array('sanitize_callback' => 'sanitize_text_field') );
	
	
	add_settings_section( 'wdfl-message-section', esc_attr__( 'Messages', 'wordforce-lead-form' ), '', 'wdfl-message' );
	
  
	
	/** message option starts **/
	add_settings_section( 'wdfl-message-section', esc_attr__( 'Response', 'wordforce-lead-form' ), '', 'wdfl-message' );
	//#FF0000
	add_settings_field( 'wdfl-field-15', esc_attr__( 'Error Message', 'wordforce-lead-form' ), 'wdfl_field_callback_15', 'wdfl-message', 'wdfl-message-section' );
	
	add_settings_field( 'wdfl-field-120', esc_attr__( '', 'wordforce-lead-form' ), 'wdfl_field_callback_120', 'wdfl-message', 'wdfl-message-section' );
	register_setting( 'wdfl-message-options', 'wdfl-setting-120', array('sanitize_callback' => 'sanitize_text_field') );
	
	
	register_setting( 'wdfl-message-options', 'wdfl-setting-15', array('sanitize_callback' => 'sanitize_text_field') );
	add_settings_field( 'wdfl-field-16', esc_attr__( 'Thank You Message', 'wordforce-lead-form' ), 'wdfl_field_callback_16', 'wdfl-message', 'wdfl-message-section' );
	register_setting( 'wdfl-message-options', 'wdfl-setting-16', array('sanitize_callback' => 'sanitize_text_field') );
	
	add_settings_field( 'wdfl-field-121', esc_attr__( '', 'wordforce-lead-form' ), 'wdfl_field_callback_121', 'wdfl-message', 'wdfl-message-section' );
	register_setting( 'wdfl-message-options', 'wdfl-setting-121', array('sanitize_callback' => 'sanitize_text_field') );
 
	
}
add_action( 'admin_init', 'wdfl_admin_init' );

if(!function_exists('wdfl_credentials_setting_fucntion')){
	function wdfl_credentials_setting_fucntion(){
	// credential setting page
	include_once WDFL_PLUGIN_DIR.'/credential-setting.php';
}
}


if(!function_exists('wdfl_form_data_list')){
function wdfl_form_data_list(){
	//drop table
	include_once WDFL_PLUGIN_DIR.'/submitted-list-data.php';
}
}
 
if(!function_exists('wordforce_new_account')){
function wordforce_new_account(){
	// credential setting page
	include_once WDFL_PLUGIN_DIR.'/add-new-account.php';
}
}

if(!function_exists('wordforce_map_form_fields')){
	function wordforce_map_form_fields(){
		// form map fields
		 include_once WDFL_PLUGIN_DIR.'/map-form-fields.php';
	}
}

/*** general ***/
if(!function_exists('wdfl_field_callback_55')){
function wdfl_field_callback_55() {
	// $placeholder = esc_attr__( 'WordForce Lead Form', 'wordforce-lead-form' );
	// $value = esc_attr( get_option( 'wdfl-setting-55' ) );
	// if(empty($value)) {
	// 	$value = $placeholder;
	// }
	// ?>
	// <!-- <input type='text' size='40' name='wdfl-setting-55' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' /> -->
	// <?php
}
}

if(!function_exists('wdfl_field_callback_99')){
function wdfl_field_callback_99() {
	?>
	<b>[WF_LEAD]</b>
	<?php
}
}

if(!function_exists('wdfl_field_callback_22')){
function wdfl_field_callback_22() {
	$placeholder = '';
	$value = esc_attr( get_option( 'wdfl-setting-22' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-22' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_102')){
function wdfl_field_callback_102() {
	$value = esc_attr( get_option( 'wdfl-setting-102' ) );
	if(empty($value)) {
		$value = "yes";
	}
	?>
	<label><input type='checkbox' name='wdfl-setting-102' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Hide Title', 'wordforce-lead-form' ); ?></label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_2')){
function wdfl_field_callback_2() {
	$value = esc_attr( get_option( 'wdfl-setting-2' ) );
	?>
	<input type='hidden' name='wdfl-setting-2' value='yes'>
	<label><input type='hidden' name='wdfl-setting-2' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( '', 'wordforce-lead-form' ); ?></label>
	<?php
}
}


if(!function_exists('wdfl_field_callback_78')){
function wdfl_field_callback_78() {
	$value = esc_attr( get_option( 'wdfl-setting-2' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-78' value='yes'>
	<label><input type='checkbox' disabled="disabled" name='wdfl-setting-78' <?php checked( $value, 'yes' ); ?> value='yes'> </label>
	<?php
}
}


if(!function_exists('wdfl_field_callback_57')){
function wdfl_field_callback_57() {
	$value = esc_attr( get_option( 'wdfl-setting-57' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-57' value='yes'>
	<label><input type='checkbox' disabled="disabled" name='wdfl-setting-57' <?php checked( $value, 'yes' ); ?> value='yes'> </label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_63')){
function wdfl_field_callback_63() {
	$value = esc_attr( get_option( 'wdfl-setting-63' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-63' value='yes'>
	<label><input  type='checkbox' name='wdfl-setting-63' <?php checked( $value, 'yes' ); ?> value='yes'> <a href="?page=wdfl&tab=label_options" target="_blank">edit label</a></label> 
	<?php
}
}

if(!function_exists('wdfl_field_callback_59')){
function wdfl_field_callback_59() {
	$value = esc_attr( get_option( 'wdfl-setting-59' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-59' value='yes'>
	<label><input type='checkbox' name='wdfl-setting-59' <?php checked( $value, 'yes' ); ?> value='yes'> <a href="?page=wdfl&tab=label_options" target="_blank">edit label</a></label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_61')){
function wdfl_field_callback_61() {
	$value = esc_attr( get_option( 'wdfl-setting-61' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-61' value='yes'>
	<label><input type='radio' name='wdfl-setting-61' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Address(Text Area)', 'wordforce-lead-form' ); ?></label>
	<label><input type='hidden' name='wdfl-setting-61' <?php checked( $value, 'no' ); ?> value='no'> <?php esc_attr_e( '', 'wordforce-lead-form' ); ?></label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_62')){
function wdfl_field_callback_62() {
	$value = esc_attr( get_option( 'wdfl-setting-62' ) );
	$value = empty($value)?'yes':$value;
	?>
	<input type='hidden' name='wdfl-setting-62' value='yes'>
	<label><input type='checkbox' disabled="disabled"  name='wdfl-setting-62' <?php checked( $value, 'yes' ); ?> value='yes'> </label>
	<?php
}
}
/*
function wdfl_field_callback_65() {
	$placeholder = esc_attr__( 'API Key', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-65' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-65' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php 
}

/**** label section*/

if(!function_exists('wdfl_field_callback_56')){
function wdfl_field_callback_56() {
	$placeholder = esc_attr__( 'Name', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-56' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-56' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_58')){
function wdfl_field_callback_58() {
	$placeholder = esc_attr__( 'Phone', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-58' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-58' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_6')){
function wdfl_field_callback_6() {
	$placeholder = esc_attr__( 'Email', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-6' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-6' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_60')){
function wdfl_field_callback_60() {
	$placeholder = esc_attr__( 'Address', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-60' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-60' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_a')){
function wdfl_field_callback_a() {
	$placeholder = esc_attr__( 'Username', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-a' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-a' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_b')){
function wdfl_field_callback_b() {
	$placeholder = esc_attr__( 'Password', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-b' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-b' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_c')){
function wdfl_field_callback_c() {
	$placeholder = esc_attr__( 'Initial URL', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-c' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-c' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_d')){
function wdfl_field_callback_d() {
	$placeholder = esc_attr__( 'Owner Id', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-d' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-d' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_e')){
function wdfl_field_callback_e() {
	$placeholder = esc_attr__( 'Client Id', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-e' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-e' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_f')){
function wdfl_field_callback_f() {
	$placeholder = esc_attr__( 'Client Secret Id', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-f' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-f' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}


if(!function_exists('wdfl_field_callback_9')){
function wdfl_field_callback_9() {
	$placeholder = esc_attr__( 'Message', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-9' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-9' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

/*
function wdfl_field_callback_7() {
	$placeholder = esc_attr__( 'Subject', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-7' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-7' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}*/
/*
}
*/
if(!function_exists('wdfl_field_callback_10')){
function wdfl_field_callback_10() {
	$placeholder = esc_attr__( 'Submit', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-10' ) );
	if(empty($value)) {
		$value = $placeholder;
	}
	?>
	<input type='text' size='40' name='wdfl-setting-10' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_11')){
function wdfl_field_callback_11() {
	$placeholder = esc_attr__( 'Please enter at least 2 characters', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-11' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-11' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_13')){
function wdfl_field_callback_13() {
	$placeholder = esc_attr__( 'Please enter a valid email', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-13' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-13' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_20')){
function wdfl_field_callback_20() {
	$placeholder = esc_attr__( 'Please enter at least 2 characters', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-20' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-20' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}


if(!function_exists('wdfl_field_callback_14')){
function wdfl_field_callback_14() {
	$placeholder = esc_attr__( 'Please enter the correct number', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-14' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-14' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_26')){
function wdfl_field_callback_26() {
	$placeholder = esc_attr__( 'Please enter the correct result', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-26' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-26' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

/*** design section */
if(!function_exists('wdfl_field_callback_68')){
function wdfl_field_callback_68() {
	$value = esc_attr( get_option( 'wdfl-setting-68' ) );
	if($value == "") {
		$value = 1;
	}
	?>
	<label><input type='radio'  name='wdfl-setting-68' <?php checked( $value, '1' ); ?> value='1' style="display:none"> <?php esc_attr_e( '', 'wordforce-lead-form' ); ?></label> 
	<label><input type='radio' disabled='' name='wdfl-setting-68' <?php checked( $value, '0' ); ?> value='0' style="display:none"> <?php esc_attr_e( '', 'wordforce-lead-form' ); ?>
 </label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_69')){
function wdfl_field_callback_69() {
	$value = esc_attr( get_option( 'wdfl-setting-69' ) );
	if(empty($value)) {
		$value = "md";
	}
	?>
	<label><input type='radio' name='wdfl-setting-69' <?php checked( $value, 'sm' ); ?> value='sm'> <?php esc_attr_e( 'Small', 'wordforce-lead-form' ); ?></label>
	<label><input type='radio' name='wdfl-setting-69' <?php checked( $value, 'md' ); ?> value='md'> <?php esc_attr_e( 'Medium', 'wordforce-lead-form' ); ?></label>
	<label><input type='radio' name='wdfl-setting-69' <?php checked( $value, 'lg' ); ?> value='lg'> <?php esc_attr_e( 'Large', 'wordforce-lead-form' ); ?></label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_70')){
function wdfl_field_callback_70() {
	$value = esc_attr( get_option( 'wdfl-setting-70' ) );
	if(empty($value)) {
		$value = 14;
	}
	?>
	<select name='wdfl-setting-70'>
	<?php
	for($i=10;$i<=60;$i++) {
	?>
	<option value="<?php echo esc_html($i); ?>" <?php echo esc_html($i==$value?'selected="selected"':'');?>><?php echo esc_html($i); ?> px</option>
	<?php }?>
	</select>
	<?php
}
}

if(!function_exists('wdfl_field_callback_71')){
function wdfl_field_callback_71() {
	$value = esc_attr( get_option( 'wdfl-setting-71' ) );
	if(empty($value)) {
		$value = 14;
	}
	?>
	<select name='wdfl-setting-71'>
	<?php
	for($i=10;$i<=32;$i++) {
	?>
	<option value="<?php echo esc_html($i); ?>" <?php echo esc_html($i==$value?'selected="selected"':'');?>><?php echo esc_html($i); ?> px</option>
	<?php }?>
	</select>
	<?php
}
}


if(!function_exists('wdfl_field_callback_72')){
function wdfl_field_callback_72() {
	$value = esc_attr( get_option( 'wdfl-setting-72' ) );
	?>
	<input type='hidden' name='wdfl-setting-72' value='yes'>
	<label><input type='checkbox' name='wdfl-setting-72' <?php checked( $value, 'yes' ); ?> value='yes'> </label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_73')){
function wdfl_field_callback_73() {
	$value = esc_attr( get_option( 'wdfl-setting-73' ) );
	if(empty($value)) {
		$value = 2;
	}
	?>
	<select name='wdfl-setting-73'>
	<?php
	for($i=0;$i<=12;$i++) {
	?>
	<option value="<?php echo esc_html($i); ?>" <?php echo esc_html($i==$value?'selected="selected"':'');?>><?php echo esc_html($i); ?> px</option>
	<?php }?>
	</select>
	<?php
}
}

if(!function_exists('wdfl_field_callback_74')){
function wdfl_field_callback_74() {
	$value = esc_attr( get_option( 'wdfl-setting-74' ) );
	if(empty($value)) {
		$value = 2;
	}
	?>
	<select name='wdfl-setting-74'>
	<?php
	for($i=0;$i<=12;$i++) {
	?>
	<option value="<?php echo esc_html($i); ?>" <?php echo esc_html($i==$value?'selected="selected"':'');?>><?php echo esc_html($i); ?> px</option>
	<?php }?>
	</select>
	<?php
}
}


if(!function_exists('wdfl_field_callback_82')){
function wdfl_field_callback_82() {
	$value = esc_attr( get_option( 'wdfl-setting-82' ) );
	if(empty($value)) {
		$value = 50;
	}
	?>
	<select name='wdfl-setting-82'>
	<?php
	$i=10;
	while($i<=100) {
	?>
	<option value="<?php echo esc_html($i); ?>" <?php echo esc_html($i==$value?'selected="selected"':'');?>><?php echo esc_html($i); ?> %</option>
	<?php 
	$i=$i+10;
	}?>
	</select>
	<?php
}
}



if(!function_exists('wdfl_field_callback_81')){
function wdfl_field_callback_81() {
	$value = esc_attr( get_option( 'wdfl-setting-81' ) );
	if(empty($value)) {
		$value = "center";
	}
	?>
	<label><input type='radio' name='wdfl-setting-81' <?php checked( $value, 'left' ); ?> value='left'> <?php esc_attr_e( 'Left', 'wordforce-lead-form' ); ?></label>
	<label><input type='radio' name='wdfl-setting-81' <?php checked( $value, 'center' ); ?> value='center'> <?php esc_attr_e( 'Center', 'wordforce-lead-form' ); ?></label>
	<label><input type='radio' name='wdfl-setting-81' <?php checked( $value, 'right' ); ?> value='right'> <?php esc_attr_e( 'Right', 'wordforce-lead-form' ); ?></label>
	<?php
}
}

if(!function_exists('wdfl_field_callback_75')){
function wdfl_field_callback_75() {
	$placeholder = esc_attr__( 'Hex Code', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-75' ) );
	if(empty($value)) {
		$value = "#FFFFFF";
	}
	?>
	<input type='text' size='40' name='wdfl-setting-75' class="color_field" placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_76')){
function wdfl_field_callback_76() {
	$placeholder = esc_attr__( 'Hex Code', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-76' ) );
	if(empty($value)) {
		$value = "#FF8000";
	}
	?>
	<input type='text' size='40' name='wdfl-setting-76' class="color_field" placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_77')){
function wdfl_field_callback_77() {
	$placeholder = esc_attr__( 'Hex Code', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-77' ) );
	if(empty($value)) {
		$value = "#FFFFFF";
	}
	?>
	<input type='text' size='40' name='wdfl-setting-77' class="color_field" placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_101')){
function wdfl_field_callback_101() {
	$value = esc_attr( get_option( 'wdfl-setting-101' ) );
	$value = empty($value)?'yes':$value;
	?>
	<label><input type='radio' name='wdfl-setting-101' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Show Background', 'wordforce-lead-form' ); ?></label>
	<label><input type='radio' name='wdfl-setting-101' <?php checked( $value, 'no' ); ?> value='no'> <?php esc_attr_e( 'Hide Background', 'wordforce-lead-form' ); ?></label>
	
	
	<?php
}
}

/*** message section */
if(!function_exists('wdfl_field_callback_12')){
function wdfl_field_callback_12() {
	$placeholder = esc_attr__( 'Please enter at least 10 characters', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-12' ) );
	?>
	<input type='text' size='40' name='wdfl-setting-12' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_15')){
function wdfl_field_callback_15() {
	$placeholder = esc_attr__( 'Error : Please try again after sometime.', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-15' ) );
	if(empty($value)) {
		$value = $placeholder;	
	}
	?>
	<input type='text' size='60' name='wdfl-setting-15' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' style='margin-right:15px!important;'/>


	<?php
	$placeholder = esc_attr__( 'Hex Code', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-120' ) );
	if(empty($value)) {
		$value = "#FF0000";
	}
	?>
	<input type='text' size='50' name='wdfl-setting-120' class="color_field" placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_16')){
function wdfl_field_callback_16() {
	$placeholder = esc_attr__( 'Thank you ! for your response', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-16' ) );
	if(empty($value)) {
		$value = $placeholder;	
	}
	?>
	<input type='text' size='60' name='wdfl-setting-16' placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' style='margin-right:15px!important;margin-top: 5px!important;'/>
	<?php

	$placeholder = esc_attr__( 'Hex Code', 'wordforce-lead-form' );
	$value = esc_attr( get_option( 'wdfl-setting-121' ) );
	if(empty($value)) {
		$value = "#008000";
	}
	?>
	<input type='text' size='40' name='wdfl-setting-121' class="color_field" placeholder='<?php echo esc_html($placeholder); ?>' value='<?php echo esc_html($value); ?>' />
	<?php
}
}

if(!function_exists('wdfl_field_callback_120')){
function wdfl_field_callback_120() {
	
}
}



if(!function_exists('wdfl_field_callback_121')){
function wdfl_field_callback_121() {
	
}
}



// display admin options page
if(!function_exists('wordforce_options_page')){
function wordforce_options_page() {
?>
<div class="wrap">
	<h2><img src="<?php echo plugins_url('/assets/screenshots/icon-128x128.png',__FILE__)?>" width="80px" class="img-thumbnail mr-3"><?php esc_attr_e( 'WordForce Lead Plugin', 'wordforce-lead-form' ); ?></h2>
	<?php
	 
	// $active_tab = sanitize_text_field(isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'general_options';
	$active_tab = sanitize_text_field(isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'label_options';
	?>
	<h2 class="nav-tab-wrapper">
		 
		<!-- <a href="?page=wdfl-form-setting&tab=general_options" class="nav-tab <?php //echo esc_attr($active_tab) == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php //esc_attr_e( 'General Settings', 'wordforce-lead-form' ); ?></a> -->
		
		<a href="?page=wdfl-form-setting&tab=label_options" class="nav-tab <?php echo esc_attr($active_tab) == 'label_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Form Labels', 'wordforce-lead-form' ); ?></a>
		<a href="?page=wdfl-form-setting&tab=design_options" class="nav-tab <?php echo esc_attr($active_tab) == 'design_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Form Customization', 'wordforce-lead-form' ); ?></a>
		<a href="?page=wdfl-form-setting&tab=message_options" class="nav-tab <?php echo esc_attr($active_tab) == 'message_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Response', 'wordforce-lead-form' ); ?></a>
	</h2>
	<form action="options.php" method="POST">


		 
		<?php //if( $active_tab == 'general_options' ) { ?>
			<?php //settings_fields( 'wdfl-general-options' ); ?>
			<?php //do_settings_sections( 'wdfl-general' ); ?>

		<?php if( $active_tab == 'label_options' ) { ?>
			<?php settings_fields( 'wdfl-label-options' ); ?>
			<?php do_settings_sections( 'wdfl-label' ); ?>

		<?php } elseif( $active_tab == 'short_code' ) { ?>
			<?php do_settings_sections( 'wdfl-label' ); ?>

		<?php } elseif( $active_tab == 'design_options' ) { ?>
			<?php settings_fields( 'wdfl-design-options' ); ?>
			<?php do_settings_sections( 'wdfl-design' ); ?>

		<?php } else { ?>
			<?php settings_fields( 'wdfl-message-options' ); ?>
			<?php do_settings_sections( 'wdfl-message' ); ?>
		<?php } ?>


		<?php submit_button(); ?>
	</form>
</div>
 <script>
	jQuery(document).ready(function($){
		jQuery('.color_field').each(function(){
			$(this).wpColorPicker();
		});
	});
</script>
<?php
}
}