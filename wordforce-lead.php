<?php    
/*
 * Plugin Name: WordForce Lead 
 * Description: WordForce Lead ,Plugin the shortcode of this plugin is [WF_LEAD], just copy or paste it on a page or use the widget to display your form.
 * Version: 2.1.0
 * Author: BugendaiTech
 * Author URI: https://www.bugendaitech.com 
 * Text Domain: wordforce-lead
 * Domain Path: /translation
 */

// disable direct access


//call at the time of activation
register_activation_hook(__FILE__, 'wdfl_create_table'); 
register_deactivation_hook(__FILE__, 'wdfl_drop_table'); 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
if(!defined('WDFL_PLUGIN'))
define( 'WDFL_PLUGIN', __FILE__ );

if(!defined('WDFL_PLUGIN_BASENAME'))
define( 'WDFL_PLUGIN_BASENAME', plugin_basename( WDFL_PLUGIN ) );

if(!defined('WDFL_PLUGIN_NAME'))
define( 'WDFL_PLUGIN_NAME', trim( dirname( WDFL_PLUGIN_BASENAME ), '/' ) );

if(!defined('WDFL_PLUGIN_DIR'))
define( 'WDFL_PLUGIN_DIR', untrailingslashit( dirname( WDFL_PLUGIN ) ) );
 
 
if(!defined('WDFL_TEXT_DOMAIN')) //text domain
define( 'WDFL_TEXT_DOMAIN', 'wdfl-form' );

if(!defined('WDFL_PLUGIN_VERSION')) //Plugin_Version
define('WDFL_PLUGIN_VERSION','2.0');


// include main file
include WDFL_PLUGIN_DIR.'/wdfl-class-object.php';

// enqueue plugin scripts
function wdfl_include_assets() {
	
	wp_enqueue_style('wdfl_style', plugins_url('/assets/css/wdfl-style.css',__FILE__),'');
	wp_enqueue_style('bootstrap',  plugins_url('/assets/css/bootstrap.min.css',__FILE__),'');
	wp_enqueue_style('datatable_css',  plugins_url('/assets/css/dataTables.min.css',__FILE__),'');
	wp_enqueue_style("notifybar", plugins_url('/assets/css/jquery.notifyBar.css',__FILE__),'');
	wp_enqueue_style("font-awesome",  plugins_url('/assets/css/font-awesome.css',__FILE__),'');
	wp_enqueue_style("map",  plugins_url('/assets/css/bootstrap.css.map',__FILE__),'');
	
	//scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap.min.js',  plugins_url('/assets/js/bootstrap.min.js',__FILE__),'', true);
    wp_enqueue_script('validate.min.js',  plugins_url('/assets/js/validate.min.js',__FILE__),'', true);
    wp_enqueue_script('jquery_notifyBar_css',  plugins_url('/assets/js/jquery.notifyBar.js',__FILE__),'', true);
    wp_enqueue_script('dataTables_js',  plugins_url('/assets/js/dataTables.min.js',__FILE__),'', true);
    wp_enqueue_script('sweetalert_js',  plugins_url('/assets/js/sweetalert.min.js',__FILE__),'', true);
    wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );


    wp_enqueue_script( 'script.js', plugins_url('/assets/js/script.js',__FILE__),'', true);
    wp_add_inline_script( 'script.js', 'const MYSCRIPT = ' . json_encode( array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'otherParam' => 'wdfl',
) ), 'before' );    
}
 
add_action("init", "wdfl_include_assets"); 
add_action("wp_ajax_my_credential","wdfl_ajax_handler");
function wdfl_ajax_handler(){    
	global $wpdb;	
	if ($_REQUEST['param']=="save_data") {

    
		$table 	 = 	"wdfl_data";
		$user_id =  sanitize_text_field($_REQUEST['customer_id']);
		$data 	 =	wdfl_get_particular_data_form_table($table,$user_id); 
		$table3  =	"wdfl_credentials";
		$cur_id  =	'1';  
		$data3 	 =  wdfl_get_particular_data_form_table($table3,sanitize_text_field($cur_id));
        $table2  =  "wdfl_form_object";	

	    $columnDetails=wdfl_get_particular_data_form_table($table2,$cur_id);	


 		$title 			= sanitize_text_field($columnDetails['leadTitle']);
 		$user_name 		= sanitize_text_field($data['name']);
 		$user_email 	= sanitize_email($data['email']);
 		$user_phone 	= sanitize_text_field($data['phone']);
 		$user_address 	= sanitize_textarea_field($data['address']);
 		$user_message 	= sanitize_textarea_field($data['message']);


 			if((empty($user_id))||(empty($title))||(empty($user_name))||(empty($user_email))||(empty($user_phone))||(empty($user_address))||(empty($user_message))) {						 
				echo json_encode(array("status"=>0,"message"=>"Please check because all details are required"));			
			}else{

				$table4  =	"wdfl_form_object";
				$cur_id  =	'1';  
				$data4 	 =  wdfl_get_particular_data_form_table($table4,sanitize_text_field($cur_id));
					$post_data_api = json_encode(array(
						
		sanitize_text_field($data4['col1']) 	=> sanitize_text_field($title),
		sanitize_text_field($data4['col2'])		=> sanitize_text_field($user_name),
		sanitize_text_field($data4['col3'])		=> sanitize_text_field($user_email),
		sanitize_text_field($data4['col4'])		=> sanitize_text_field($user_phone),
		sanitize_text_field($data4['col5'])		=> sanitize_text_field($user_address),
		sanitize_text_field($data4['col6'])		=> sanitize_text_field($user_message)
				));		 
		    $WDFLSalesforceAPI = new WDFL_Salesforce_API();		    
			$return_array = $WDFLSalesforceAPI->wdfl_post_data_in_salesforce($post_data_api,$user_id);				
			if(isset($return_array[0]['message']) && $return_array[0]['message'] == 'Use one of these records?'){
				echo json_encode(array("status"=>0,"message"=>"Duplicate Data"));
			}elseif((isset($return_array['id'])) && ($return_array['success'] == 'true')){	 
				  echo json_encode(array("status"=>1,"message"=>"Data Synced Successfully"));
			}
		}

	}elseif ($_REQUEST['param']=="revokeBtn") {
 
 				$cur_id   =  1;

			    $table_name = $wpdb->prefix . 'wdfl_accounts';			
					$ok=$wpdb->update($table_name,array(				
					"status"=>2,
					"final_status"=>0),array(
					"id"=>($cur_id)
					));

				$table_name = $wpdb->prefix . 'wdfl_form_object';			
					$ok=$wpdb->update($table_name,array(	
					"allObjects"=>"",
					"objectName"=>"",
					"objectAllFields"=>"",
					"col1"=>"",
					"col2"=>"",
					"col3"=>"",
					"col4"=>"",
					"col5"=>"",
					"col6"=>"",
					"status"=>0),array(
					"id"=>($cur_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Connection Removed Successfully !!"));
			}else{
				echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			} 
	}elseif ($_REQUEST['param']=="finalSubmit") {
 
		$table 	 	 = 	"wdfl_accounts";
		$txtfullname =  sanitize_text_field($_REQUEST['txtfullname']);
		// $production  =  sanitize_text_field($_REQUEST['production']);
		$api 		 =  sanitize_text_field($_REQUEST['api']);  
 		$cur_id      =  1;
 
		$data3 	 =  wdfl_get_particular_data_form_table($table,sanitize_text_field($cur_id)); 
 			
 		$data 			= sanitize_text_field($data3['data']);
 		$status 		= sanitize_text_field($data3['status']); 

 			if((empty($txtfullname)) ||(empty($data))|| $status != 1) {		
				echo json_encode(array("status"=>0,"message"=>"Please check because all details are required"));
			}else{ 
			    $table_name = $wpdb->prefix . 'wdfl_accounts';			
					$ok=$wpdb->update($table_name,array( 
					"name"=>$txtfullname,					
					"final_status"=>1),array(
					"id"=>($cur_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Account Linked Successfully !!"));
			}else{
				echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			} 
		}
	}elseif($_REQUEST['param']=="accountName"){
		$value	   	   = sanitize_text_field($_REQUEST['value']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($value, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_accounts';
			    $ok=$wpdb->update($table_name,array( 				 
					"name"=>$value),array(
					"id"=>($main_id)
					));
			   if($ok){
			echo json_encode(array("status"=>1,"message"=>""));
			}else{
			echo json_encode(array("status"=>0,"message"=>""));
			}
		}
	}elseif($_REQUEST['param']=="leadTitle"){
		$value	   = sanitize_text_field($_REQUEST['value']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($value, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_accounts';
			    $ok=$wpdb->update($table_name,array( 				 
					"name"=>$value),array(
					"id"=>($main_id)
					));
			   if($ok){
			echo json_encode(array("status"=>1,"message"=>""));
			}else{
			echo json_encode(array("status"=>0,"message"=>""));
			}
		}
	}elseif($_REQUEST['param']=="objectVal"){

		// $allObjects	   = sanitize_text_field($_REQUEST['allObjects']);
		$objectVal	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1; 
		$allObjects    = json_encode(wdfl_get_data_object()); 
		if((strpos($objectVal, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Object is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';			
					$ok=$wpdb->update($table_name,array( 
					"allObjects"=>$allObjects,	
					"objectName"=>$objectVal,	
					"objectAllFields"=>$objectVal,				
					"col1"=>"",
					"col2"=>"",
					"col3"=>"",
					"col4"=>"",
					"col5"=>"",
					"col6"=>"",
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
				$objectDetails= wdfl_get_particular_data_form_table("wdfl_form_object","1"); 
				
				$fields = get_wdfl_fields($objectDetails['objectName']);
				$objectAllFields = json_encode($fields);
				$table_name = $wpdb->prefix . 'wdfl_form_object';			
					$ok=$wpdb->update($table_name,array(
					"objectAllFields"=>$objectAllFields, 
					"status"=>0),array(
					"id"=>($main_id)
					));
				$html='';
				$html.='<option value="value">--Choose Value--</option>';
						foreach($fields as $value){
						if(isset($value['req']) && $value['req']=='true'){
							$attr='<span class="pull-right" style="color: red!important;">( * Required  )</span>';
						}else{
							$attr='';
						}
				$html.='<option value="'.$value['name'].'">'.$value['label']." ".$attr.'</option>';
						}
			echo json_encode(array("status"=>1,"body"=>$html,"message"=>"Object Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column1"){
		$column1	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column1, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';
			
					$ok=$wpdb->update($table_name,array( 				 
					"col1"=>$column1,
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 1 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column2"){
		$column2	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column2, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';
			    $ok=$wpdb->update($table_name,array( 				 
					"col2"=>$column2,
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 2 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column3"){
		$column3	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column3, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';
			    $ok=$wpdb->update($table_name,array( 				 
					"col3"=>$column3,
					"status"=>0),array(
					"id"=>($main_id)
					));
			   if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 3 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column4"){
		$column4	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column4, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';			
					$ok=$wpdb->update($table_name,array( 				 
					"col4"=>$column4,
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 4 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column5"){
		$column5	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column5, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';		
					$ok=$wpdb->update($table_name,array( 				 
					"col5"=>$column5,
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 5 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="column6"){

		$column6	   = sanitize_text_field($_REQUEST['object']);
		$all_check     = "all_ok";	
		$main_id       = 1;
		if((strpos($column6, ".")!== False)){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';
			    $ok=$wpdb->update($table_name,array( 				 
					"col6"=>$column6,
					"status"=>0),array(
					"id"=>($main_id)
					));
			if($ok){
			echo json_encode(array("status"=>1,"message"=>"Field 6 Set Successfully !!"));
			}else{
			echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}elseif($_REQUEST['param']=="finalObject"){
		$allValues = wdfl_get_particular_data_form_table("wdfl_form_object","1"); 
		$all_check = "all_ok";
		$main_id   = '1';
		if($allValues['objectName']=='' || $allValues['col1']=='' || $allValues['col2']=='' || $allValues['col3']=='' || $allValues['col4']=='' || $allValues['col5']=='' || $allValues['col6']=='' || $allValues['objectName']=='value' || $allValues['col1']=='value' || $allValues['col2']=='value' || $allValues['col3']=='value' || $allValues['col4']=='value' || $allValues['col5']=='value' || $allValues['col6']=='value' ){
			$all_check  = "not_valid"; 
			echo json_encode(array("status"=>0,"message"=>"Field Name is not Valid, Please check and try again"));
		}
		if($all_check == "all_ok")
			{ 
			    $table_name = $wpdb->prefix . 'wdfl_form_object';
			    $ok=$wpdb->update($table_name,array( 				 
					"status"=>1),array(
					"id"=>($main_id)
					));
			if($ok){
				echo json_encode(array("status"=>1,"message"=>"Setup Done Successfully !!"));
			}else{
				echo json_encode(array("status"=>0,"message"=>"Please try again !!"));
			}
		}
	}       
	wp_die();
} 

// form submissions
$list_submissions_setting = get_option('wdfl-setting-2');
if ($list_submissions_setting == 'yes') {
	// create submission post type
	function wdfl_custom_postype() {
		$wdfl_args = array(
			'labels' => array('name' => esc_attr__( 'Submissions', 'wdfl-form' )),
			'menu_icon' => 'dashicons-email',
			'public' => false,
			'can_export' => true,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'capability_type' => 'post',
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
 			'supports' => array( 'title', 'editor' )
		);
		register_post_type( 'submission', $wdfl_args );
	}
	add_action( 'init', 'wdfl_custom_postype' );

	// dashboard submission columns
	function wdfl_custom_columns( $columns ) {
		$columns['name_column'] = esc_attr__( 'Name', 'wdfl-form' );
		$columns['email_column'] = esc_attr__( 'Email', 'wdfl-form' );
		$custom_order = array('cb', 'title', 'name_column', 'email_column', 'date');
		foreach ($custom_order as $colname) {
			$new[$colname] = $columns[$colname];
		}
		return $new;
	}
	add_filter( 'manage_submission_posts_columns', 'wdfl_custom_columns', 10 );

	function wdfl_custom_columns_content( $column_name, $post_id ) {
		if ( 'name_column' == $column_name ) {
			$name = get_post_meta( $post_id, 'name_sub', true );
			echo esc_attr($name);
		}
		if ( 'email_column' == $column_name ) {
			$email = get_post_meta( $post_id, 'email_sub', true );
			echo esc_attr($email);
		}
	}
	add_action( 'manage_submission_posts_custom_column', 'wdfl_custom_columns_content', 10, 2 );

	// make name and email column sortable
	function wdfl_column_register_sortable( $columns ) {
		$columns['name_column'] = 'name_sub';
		$columns['email_column'] = 'email_sub';
		return $columns;
	}
	add_filter( 'manage_edit-submission_sortable_columns', 'wdfl_column_register_sortable' );

	function wdfl_name_column_orderby( $vars ) {
		if(is_admin()) {
			if ( isset( $vars['orderby'] ) && 'name_sub' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'name_sub',
					'orderby' => 'meta_value'
				) );
			}
		}
		return $vars;
	}
	add_filter( 'request', 'wdfl_name_column_orderby' );

	function wdfl_email_column_orderby( $vars ) {
		if(is_admin()) {
			if ( isset( $vars['orderby'] ) && 'email_sub' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'email_sub',
					'orderby' => 'meta_value'
				) );
			}
		}
		return $vars;
	}
	add_filter( 'request', 'wdfl_email_column_orderby' );
}

// add settings link
function wdfl_action_links( $links ) {
	$settingslink = array( '<a href="'. admin_url( 'admin.php?page=wdfl-general' ) .'">'.esc_attr__('Settings', 'wdfl-form').'</a>' );
	return array_merge( $links, $settingslink );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wdfl_action_links' );

// get ip of user
if (!function_exists('wdfl_get_the_ip')){ 
function wdfl_get_the_ip() {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}
}
}

// create from email header
if (!function_exists('wdfl_from_header')){
function wdfl_from_header() {
	if ( !isset( $from_email ) ) {
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		return 'wordpress@' . $sitename;
	}
}
}

// create random number for captcha
if (!function_exists('wdfl_random_number')){
	function wdfl_random_number() {
	$page_number = mt_rand(100, 999);
	return $page_number;
}
}

// create random number for sum captcha
if (!function_exists('wdfl_random_number_sum_one')){
	function wdfl_random_number_sum_one() {
	$sum_one = mt_rand(1, 9);
	return $sum_one;
}
}

if (!function_exists('wdfl_random_number_sum_two')){
	function wdfl_random_number_sum_two() {
	$sum_two = mt_rand(1, 9);
	return $sum_two;
}
}

// redirect when sending succeeds
if (!function_exists('wdfl_redirect_success')){
	function wdfl_redirect_success() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&wdfl-sh=success";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?wdfl-sh=success";
		} else {
			$url_with_param = $current_url."/?wdfl-sh=success";
		}
	}
	return $url_with_param;
}
}

if (!function_exists('wdfl_widget_redirect_success')){
	function wdfl_widget_redirect_success() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&wdfl-wi=success";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?wdfl-wi=success";
		} else {
			$url_with_param = $current_url."/?wdfl-wi=success";
		}
	}
	return $url_with_param;
}
}

// redirect when sending fails
if (!function_exists('wdfl_redirect_error')){
	function wdfl_redirect_error() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&wdfl-sh=fail";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?wdfl-sh=fail";
		} else {
			$url_with_param = $current_url."/?wdfl-sh=fail";
		}
	}
	return $url_with_param;
}
}

if (!function_exists('wdfl_widget_redirect_error')){
	function wdfl_widget_redirect_error() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&wdfl-wi=fail";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?wdfl-wi=fail";
		} else {
			$url_with_param = $current_url."/?wdfl-wi=fail";
		}
	}
	return $url_with_param;
}
}

add_action( 'admin_enqueue_scripts', 'wdfl_add_color_picker' );
function wdfl_add_color_picker( $hook ) {
	wp_enqueue_style( 'wp-color-picker');
	wp_enqueue_script( 'wp-color-picker'); 
}

// form anchor
function wdfl_anchor_footer() {
	$anchor_setting = get_option('wdfl-setting-21');
	//if ($anchor_setting == 'yes') {
		echo '<script type="text/javascript">';
		echo 'if(document.getElementById("wdflnc")) { document.getElementById("wdflnc").scrollIntoView({behavior:"smooth", block:"center"}); };';
?>
document.getElementById('wdfl_phone').addEventListener('input', function (e) {
  var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
  e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});
<?php
		echo '</script>';
	
}
add_action('wp_footer', 'wdfl_anchor_footer');


// form css
function wdfl_css_head() {
	// include variables
	include WDFL_PLUGIN_DIR.'/wdfl-variables.php'; 
	echo '<style type="text/css">';
	echo '#wdfl .form-group input[type="text"], #wdfl .form-group input[type="email"],#wdfl .form-group textarea {font-size:'.esc_attr($wdfl_input_font_setting).'px;border-radius:'.esc_attr($wdfl_field_radius).'px;box-shadow:'.$wdfl_form_field_shadow .';}';
	echo '#wdfl .form-group button {font-size:'.esc_attr($wdfl_button_font_size).'px;width:'.esc_attr($wdfl_button_size).'%;background: '.esc_attr($wdfl_button_back_color).';border: 1px solid '.esc_attr($wdfl_button_back_color).';color: '.esc_attr($wdfl_button_txt_color).';}#wdfl .form-group.wdfl-submit-group{text-align:'.esc_attr($wdfl_button_align).'}';
	
	if($wdfl_form_show_back == 'no') {
		echo '.wdfl-container{background: none;padding:0}';
	}
	else {
		echo '.wdfl-container{background: '.esc_attr($wdfl_form_back_color).';border-radius: '.esc_attr($wdfl_form_radius).'px;}';
	}
	echo '#wdfl .wdfl-error {color: '.esc_attr($wdfl_form_error_color).';font-size: 12px;}#wdfl .wdfl-success {color: '.esc_attr($wdfl_form_success_color).';font-size: 12px;}';
	echo '</style>';
	
}
add_action('wp_head', 'wdfl_css_head');

//table creation function

if ( ! function_exists( 'wdfl_create_table' ) ) {
/**
 * wdfl_create_table // used for create tables
 * 
 */
 function wdfl_create_table(){
	//on activate 
	global $wpdb; 
	
	$tableName1 = $wpdb->prefix . 'wdfl_credentials';  // table 1
	$tableName2 = $wpdb->prefix . 'wdfl_data';         // table 2
	$tableName3 = $wpdb->prefix . 'wdfl_accounts';     // table 3
	$tableName4 = $wpdb->prefix . 'wdfl_form_object';  // table 4
	
	$charset_collate = $wpdb->get_charset_collate();

	$wpdb->query("drop table if exists $tableName1");

	$sql = "CREATE TABLE $tableName1 (
		id mediumint(11) NOT NULL AUTO_INCREMENT,
		created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		title text NOT NULL,
		name text NOT NULL, 
		clientid text NOT NULL,
		clientsrid text NOT NULL,
		insturl text NOT NULL,
		username text NOT NULL,
		password text NOT NULL,
		token text NOT NULL, 
		status text NOT NULL,  
		PRIMARY KEY  (id)
	) $charset_collate;";

	$wpdb->query($sql); 
	$id_d='1';
	$wpdb->query(
		$wpdb->prepare(
			"INSERT INTO $tableName1 (id) VALUES('%d')","$id_d")
	);
 
   

   $charset_collate = $wpdb->get_charset_collate();

	$wpdb->query("drop table if exists $tableName2");

	$sql = "CREATE TABLE $tableName2 (
		id mediumint(11) NOT NULL AUTO_INCREMENT,
		created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		in_object text NOT NULL,
		name text NOT NULL,
		email text NOT NULL,
		phone text NOT NULL,
		address text NOT NULL,
		message text NOT NULL,
		r_id text NOT NULL, 
		PRIMARY KEY  (id)
	) $charset_collate;"; 
   $wpdb->query($sql);

   $charset_collate = $wpdb->get_charset_collate();
	 $wpdb->query("drop table if exists $tableName3");
   $sql = "CREATE TABLE $tableName3 (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
	 `name` varchar(250) NOT NULL,
	 `data` longtext NOT NULL,
	 `meta` longtext NOT NULL,
	 `status` int(1) NOT NULL,
	 `final_status` int(1) NOT NULL,
	 `time` datetime DEFAULT NULL,
	 `updated` datetime DEFAULT NULL,
	 	PRIMARY KEY  (id)
		) $charset_collate;"; 
	   $wpdb->query($sql); 
		$id_d='1';
		$staticStatus='9';
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $tableName3 (id,status) VALUES('%d','%d')","$id_d","$staticStatus")
		);

	  $charset_collate = $wpdb->get_charset_collate();
	 $wpdb->query("drop table if exists $tableName4");
   $sql = "CREATE TABLE $tableName4 (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
	 `allObjects` Text NOT NULL,
	 `objectName` varchar(250) NOT NULL,
	 `objectAllFields` Text NOT NULL,
	 `leadTitle` varchar(250) NOT NULL,
	 `col1` varchar(250) NOT NULL,
	 `col2` varchar(250) NOT NULL,
	 `col3` varchar(250) NOT NULL,
	 `col4` varchar(250) NOT NULL,
	 `col5` varchar(250) NOT NULL,
	 `col6` varchar(250) NOT NULL, 
	 `status` int(1) NOT NULL, 
	 	PRIMARY KEY  (id)
		) $charset_collate;";
	 
	  $wpdb->query($sql); 
		$id_d='1';
		$objectName='value'; 
		$staticStatus='0';
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $tableName4 (id,objectName,status) VALUES('%d','%s','%d')","$id_d","$objectName","$staticStatus")
		);
   
}
}

// table drop function

if(! function_exists('wdfl_drop_table')){

	/**
 * wdfl_drop_table // used for drop tables
 * 
 */

	function wdfl_drop_table(){  
		global $wpdb; 
		
		$table_name = $wpdb->prefix . 'wdfl_credentials';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "DROP TABLE $table_name "; 
	    $wpdb->query($sql);

	  	$table_name = $wpdb->prefix . 'wdfl_data';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "DROP TABLE $table_name "; 
	    $wpdb->query($sql);

	    $table_name = $wpdb->prefix . 'wdfl_accounts';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "DROP TABLE $table_name "; 
	    $wpdb->query($sql);

	    $table_name = $wpdb->prefix . 'wdfl_form_object';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "DROP TABLE $table_name "; 
	    $wpdb->query($sql);
	}
}


if(! function_exists('wdfl_get_submitted_data_form_table')){
  	function wdfl_get_submitted_data_form_table($table,$row_id=''){

        global $wpdb;
        $table_name = $wpdb->prefix . $table;              
        $charset_collate = $wpdb->get_charset_collate();
        	if($row_id>0){
               	$sql = "SELECT * FROM $table_name WHERE id=$row_id";
            }else{
              	$sql = "SELECT * FROM $table_name ";
            }
               
            $result1=$wpdb->get_results($sql); 
            $result1=wdfl_object_to_array_data_for_plugin($result1);              
            return $result1;

    }
  }
  
  if(! function_exists('wdfl_get_home_url')){
      function wdfl_get_home_url($type=''){
          global $wpdb;
          $table = $wpdb->prefix . "options";
          $siteUrl=$wpdb->get_var("SELECT option_value from $table where option_name='siteurl'");
          if($type==''){
              return $siteUrl; 
          }else{
              $strpos = strpos($siteUrl,":");
              $refineUrl = substr($siteUrl,$strpos+3);
              return $refineUrl; 
          }
          
      }
  }


 if(! function_exists('wdfl_get_particular_data_form_table')){
	function wdfl_get_particular_data_form_table($table,$row_id){

		global $wpdb;
		$table_name = $wpdb->prefix . $table;              
		$charset_collate = $wpdb->get_charset_collate();
		$stu_details= $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM $table_name WHERE id= %d ",$row_id
			),ARRAY_A
		);
		return $stu_details;
		}
	}
		if ( ! function_exists( 'wdfl_object_to_array_data_for_plugin' ) ) {
		/**
		 * object_to_array_data_for_plugin // convert object to an array
		 *
		 * @param array $args
		 * @return array
		 */
  	function wdfl_object_to_array_data_for_plugin($data) {
		    if ((! is_array($data)) and (! is_object($data)))
		        return 'xxx'; // $data;

		    $result = array();

		    $data = (array) $data;
		    foreach ($data as $key => $value) {
		        if (is_object($value))
		            $value = (array) $value;
		        if (is_array($value))
		            $result[$key] = wdfl_object_to_array_data_for_plugin($value);
		        else
		            $result[$key] = $value;
		    }
		    return $result;
			}
		}

    //include files
	include WDFL_PLUGIN_DIR.'/wdfl-shortcodes.php';
	include WDFL_PLUGIN_DIR.'/wdfl-options.php';  
	include WDFL_PLUGIN_DIR.'/new-api-file.php';