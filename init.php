<?php

/*
Plugin Name: Boltron GShop Api
Description: Sync your WooCommerce Store to Google Merchants with our API Integration
Version: 1.0
Author: Abacab Ltd.
Author URI: https://boltron.co
*/

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

define('BOLTRON_MERCHANT_CENTER_ROOTDIRR', plugin_dir_path(__FILE__));


require_once dirname(dirname(__FILE__)).'/woocommerce/woocommerce.php';
require_once(BOLTRON_MERCHANT_CENTER_ROOTDIRR.'class/bontron_merchant_center.php');
require_once(BOLTRON_MERCHANT_CENTER_ROOTDIRR.'admin/functions.php');      
require_once dirname(__FILE__).'/includes/Google/Client.php';
require_once dirname(__FILE__).'/includes/Google/Service/ShoppingContent.php';
require_once dirname(__FILE__).'/hook/customhooks.php';


add_action('admin_menu','boltron_merchant_center_menu');
register_activation_hook(__FILE__, 'boltron_merchant_center_plugin_install_method');
register_deactivation_hook( __FILE__, 'boltron_merchant_center_plugin_uninstall_method' );


function boltron_merchant_center_plugin_install_method(){
	global $wp;
	global $wpdb;
	
	$charset_collate = $wpdb->get_charset_collate();
	
	$table_name = $wpdb->prefix.'google_synchronised_product';
	
	$sql = "CREATE TABLE $table_name (
	    id mediumint(9) NOT NULL AUTO_INCREMENT,
	    product_id int(11) NOT NULL,
	    product_name text NOT NULL,
	    datetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	    PRIMARY KEY  (id)
	) $charset_collate;";
	
	
	$table_name1 = $wpdb->prefix.'merchant_synchronised_product_counter_datewise';
	$sql1 = "CREATE TABLE $table_name1 (
	    id int(11) NOT NULL AUTO_INCREMENT,
	    merchant_boltron_id int(11) NOT NULL,
	    merchant_google_id double NOT NULL,
	    synchronised_product int(11) NOT NULL,
	    PRIMARY KEY  (id)
	) $charset_collate;";
	
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sql1 );
	
}



function boltron_merchant_center_plugin_uninstall_method(){
    
	global $wpdb;
        
	$table_name = $wpdb->prefix.'google_synchronised_product';
	$table_name1 = $wpdb->prefix.'merchant_synchronised_product_counter_datewise';
	
	$wpdb->query( "DROP TABLE IF EXISTS ".$table_name );
	$wpdb->query( "DROP TABLE IF EXISTS ".$table_name1 );
}



function boltron_merchant_center_menu(){
	$plugin_directory = plugin_dir_url(__FILE__);
	$icon_svg=$plugin_directory.'images/favicon.png';

	
	add_menu_page('Boltron GShop API', //page title
	'Boltron GShop API', //menu title
	'manage_options', //capabilities
	'Boltron_Merchant_Center', //menu slug
	'boltron_merchant_center_settings', //function
	$icon_svg
	);

	

	add_submenu_page('null', //parent slug  nul
	'merchant_center_save_settings', //page title
	'merchant_center_save_settings', //menu title
	'manage_options', //capability
	'boltron_merchant_center_save_settings', //menu slug
	'boltron_merchant_center_save_settings'); //function 

	

	add_submenu_page('Boltron_Merchant_Center', //parent slug
	'Merchant Products', //page title
	'Merchant Products', //menu title
	'manage_options', //capability
	'boltron_merchant_center_merchant_products', //menu slug
	'boltron_merchant_center_merchant_products'); //function
	
	add_submenu_page('null', //parent slug
	'Sync Your Products', //page title
	'Sync Your Products', //menu title
	'manage_options', //capability
	'boltron_merchant_center_sync_merchant_products', //menu slug
	'boltron_merchant_center_sync_merchant_products'); //function  
}




add_action( 'wp_ajax_get_language_from_country', 'get_language_from_country' );
add_action( 'wp_ajax_nopriv_get_language_from_country', 'get_language_from_country' );



add_action('admin_enqueue_scripts', 'boltron_merchant_center_scripts');
function boltron_merchant_center_scripts() {   

    wp_register_style( 'bmc_custom_style', plugin_dir_url( __FILE__ ) . 'css/custom.css' );
    wp_enqueue_style( 'bmc_custom_style' );
    
    wp_register_script( 'bmc_custom_script', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), NULL, true);
    wp_enqueue_script( 'bmc_custom_script' );

}

