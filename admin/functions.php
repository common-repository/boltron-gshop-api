<?php

    function boltron_merchant_center_settings(){
    
	    $boltron_object = new Bontron_merchant_center; 
	    add_action('boltron_merchant_center_settings',array($boltron_object, 'setting'));
	    do_action('boltron_merchant_center_settings');
    }
    
    function boltron_merchant_center_save_settings(){
    
	    $retrieved_nonce = $_REQUEST['_wpnonce'];
	    if (!wp_verify_nonce($retrieved_nonce, 'my_save_settings' ) ) die( 'Failed security check' );
	    
	    $merchant_clientid = sanitize_text_field($_POST['merchant_clientid']);
	    $merchant_client_secret = sanitize_text_field($_POST['merchant_client_secret']);
	    $merchant_id = sanitize_text_field($_POST['merchant_id']);
    
	    update_option('boltron_merchant_center_merchant_clientid',$merchant_clientid);
	    update_option('boltron_merchant_center_merchant_client_secret',$merchant_client_secret);
	    update_option('boltron_merchant_center_merchant_id',$merchant_id);
    
	    $url = admin_url('admin.php?page=Boltron_Merchant_Center&status=1');
	    wp_redirect( $url );
	    exit;
    }
    
    function boltron_merchant_center_merchant_products(){
    
	    $boltron_object = new Bontron_merchant_center; 
	    add_action('boltron_merchant_center_merchant_products',array($boltron_object, 'merchant_products'));
	    do_action('boltron_merchant_center_merchant_products');
    
    }
     
    function boltron_merchant_center_sync_merchant_products(){
	
	$boltron_object = new Bontron_merchant_center; 
	add_action('boltron_merchant_center_crone',array($boltron_object, 'boltron_merchant_center_crone'));
	do_action('boltron_merchant_center_crone');
	
    }
     
    
    function get_language_from_country(){
	
	if ( ! check_ajax_referer( 'google_merchant_extra_fields', 'security' ) ) {
	    wp_send_json_error( 'Invalid security token sent.' );
	    wp_die();
	}
	
	
	$targetCountry = sanitize_text_field($_POST['targetCountry']);
	
	$boltron_object = new Bontron_merchant_center; 
	add_action('boltron_merchant_center_merchant_products',array($boltron_object, 'get_language_from_country'),$targetCountry);
	do_action('boltron_merchant_center_merchant_products',$targetCountry);
	
    }
    
    
    
?>