<?php 

class Bontron_merchant_center {

	const BASE_URL = 'https://boltron.co/dev/project/';
	public $merchant_clientid='';
	public $merchant_client_secret='';
	public $merchant_id='';
	public $merchant_redirect_uri='';
	public $email='';
	public $planname='';
	public $productlimit='';
	
	public function __construct(){
		
		$id=get_option('boltron_merchant_review_merchant_id');

		$merchant_clientid = get_option('boltron_merchant_center_merchant_clientid');
		$merchant_client_secret = get_option('boltron_merchant_center_merchant_client_secret');
		$merchant_id = get_option('boltron_merchant_center_merchant_id');

		$this->merchant_clientid = $merchant_clientid;
		$this->merchant_client_secret = $merchant_client_secret;
		$this->merchant_id = $merchant_id;
		$this->id = $id;
		
		$api_url= self::BASE_URL.'api/merchant_detail.php' ;
		
		$nonce = 'get_merchentdata';
		
		$args=array('body'=>array(
			'id'=>$id,
			'action'=>'get_merchentdata',
			'nonce'=>$nonce
		)); 
		
		$response = wp_remote_post(esc_url($api_url),$args);
		$response = json_decode( wp_remote_retrieve_body( $response ) );
		
		$data = $response->merchent;
		
		$this->email = $data->email;
		$this->planname = $data->name;
		$this->productlimit = $data->product_limit;
		$this->membership_list_id = $data->membership_list_id;
		$this->sync_interval_per_day = $data->sync_interval_per_day;
		
		$this->membership_start_date = $data->membership_start_date;
		$this->membership_end_date = $data->membership_end_date;
		
	}	

	

	function setting(){

		$merchant_clientid = $this->merchant_clientid;
		$merchant_client_secret = $this->merchant_client_secret;
		$merchant_id = $this->merchant_id;

	?>

		<?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == '1'){ ?>
			<div class="updated notice is-dismissible">
				<p><?php _e( 'Voila! Setting saved successfully.', 'my_plugin_textdomain' ); ?></p>
			</div>
		<?php } ?>
		
		<div class="notice notice-info is-dismissible">
			<p><?php _e( 'You must sign up for a boltron account at <a href="https://boltron.co/dev/project/merchant/register.php"> boltron.co</a> and download the <a href="https://boltron.co/product/woocommerce-prestashop-merchant-reviews/"> boltron merchant review</a> plugin and activate it.', 'my_plugin_textdomain' ); ?></p>
		</div>
		
		<div class="wrap">
		<h1>Settings</h1>
		<hr>
		<div class="rewrap">
		<form action="?page=boltron_merchant_center_save_settings" method="post">	
			<div class="row">
			<h3><label><b>Client ID<em>*</em></b></label></h3>
			<input  type="text" name="merchant_clientid" id="merchant_clientid" class="inputwidth" value="<?php echo $merchant_clientid; ?>"  />
			</div>

			<?php wp_nonce_field('my_save_settings'); ?>
			
			<div class="row">
			<h3><label><b>Client Secret<em>*</em></b></label></h3>
			<input  type="text" name="merchant_client_secret" id="merchant_client_secret" class="inputwidth" value="<?php echo $merchant_client_secret; ?>"  />
			</div>

			

			<div class="row">
			<h3><label><b>Merchant Id<em>*</em></b></label></h3>
			<input  type="text" name="merchant_id" id="merchant_id" class="inputwidth" value="<?php echo $merchant_id; ?>"  />
			</div>

			<div class="row">
			<h3><label><b>Authorized Rredirect uri<em>*</em></b></label></h3>
			<label><?php echo $url = admin_url('admin.php?page=boltron_merchant_center_merchant_products'); ?></label>
			<br>
			<label><?php echo $url = admin_url('admin.php?page=boltron_merchant_center_sync_merchant_products'); ?></label>
			<br><br>
			<label>These both urls you will be needed to set as a Authorized redirect URIs in Google APIs when you creating a new client ID for google api authenticate.</label>
			</div>

			<br><br>

			<div class="row">
			<button type="submit" class="button-primary" name="submit" value="submit">Save Settings</button>	
			</div>

		</form>

		</div>
		</div>

		<?php
	}

	

	

	function merchant_products(){

		$languages = include(dirname(dirname(__FILE__)).'/includes/languages.php');
		$countries = include(dirname(dirname(__FILE__)).'/includes/countries.php');
	
		$merchant_clientid = $this->merchant_clientid;
		$merchant_client_secret = $this->merchant_client_secret;
		$merchant_id = $this->merchant_id;

		
		session_start();

		if(isset($_REQUEST['proid']) && $_REQUEST['proid'] != '' && isset($_SESSION['gmc_services']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'deletegmp' && isset($_REQUEST['_wpnonce']) && $_REQUEST['_wpnonce'] != ''){
			
			$delete_nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($delete_nonce, 'delete_google_merchant_product' ) ) die( 'Failed security check' );
			
			$service = $_SESSION['gmc_services'];
		
			$product_id = $_REQUEST['proid'];
			$result = $service->products->delete($merchant_id, $product_id);
			$_SESSION['gmp_product_delete_status'] = true; 
		}
		
		
		
		$client = new Google_Client();
		$client->setApplicationName('Boltron');
		$client->setClientId($merchant_clientid);
		$client->setClientSecret($merchant_client_secret);
		$redirect_url = admin_url('admin.php?page=boltron_merchant_center_merchant_products');
		$client->setRedirectUri($redirect_url);
		$client->setScopes('https://www.googleapis.com/auth/content');

		if($client->isAccessTokenExpired()) {
			unset($_SESSION['oauth_access_token']);
		}
		
		
		if (isset($_SESSION['oauth_access_token'])) {
		  $client->setAccessToken($_SESSION['oauth_access_token']);
		} elseif (isset($_GET['code'])) {
		  $token = $client->authenticate($_GET['code']);
		  $_SESSION['oauth_access_token'] = $token;
		} else {
		  header('Location: ' . $client->createAuthUrl());
		  exit;
		}
		
			
		$service = new Google_Service_ShoppingContent($client);
		$_SESSION['gmc_services'] = $service;
		
		$products = $service->products->listProducts($merchant_id);
		$products = $products->getResources();
		
		?>
		
		<?php
		
		if(isset($_SESSION['gmp_product_delete_status']) && $_SESSION['gmp_product_delete_status'] == true){
		unset($_SESSION['gmp_product_delete_status']);
		?>
		<br><br>
		<div class="notice notice-success is-dismissible" style="margin:0px;">
			<p><?php _e( 'Voila! Product deleted successfully. It take some time to delete from the google merchant center.', 'my_plugin_textdomain' ); ?></p>
		</div>
		<br>
		<?php
			
		}
		
		?>
		
		<?php
		if(count($products) > 0){
		?>
		
		
		<h1 style="float:left;">Google Merchant Center Products</h1>
		<a style="float:left; margin:1% 0 4% 5%;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=boltron_merchant_center_sync_merchant_products" class="btn btn-primary">Sync Your New Products</a>
		<table class="mproducts">
		  <tr>
		    <th>Id</th>
			<th>Title</th>
			<th>Price</th>
			<th>Availability</th>
			<th>Condition</th>
			<th>Country</th>
			<th>Language</th>
			<th>Delete</th>
		  </tr>
		
		
		<?php

		foreach($products as $product){

			$additionalImageLinks = $product->additionalImageLinks;
			$adult = $product->adult;
			$adwordsGrouping = $product->adwordsGrouping;
			$adwordsLabels = $product->adwordsLabels;
			$adwordsRedirect = $product->adwordsRedirect;
			$ageGroup = $product->ageGroup;
			$availability = $product->availability;
			$availabilityDate = $product->availabilityDate;
			$brand = $product->brand;
			$channel = $product->channel;
			$color = $product->color;
			$condition = $product->condition;
			$contentLanguage = $product->contentLanguage;
			$description = $product->description;
			$energyEfficiencyClass = $product->energyEfficiencyClass;
			$expirationDate = $product->expirationDate;
			$gender = $product->gender;
			$googleProductCategory = $product->googleProductCategory;
			$gtin = $product->gtin;
			$id = $product->id;
			$identifierExists = $product->identifierExists;
			$imageLink = $product->imageLink;
			$isBundle = $product->isBundle;
			$itemGroupId = $product->itemGroupId;
			$kind = $product->kind;
			$link = $product->link;
			$material = $product->material;
			$merchantMultipackQuantity = $product->merchantMultipackQuantity;
			$mobileLink = $product->mobileLink;
			$mpn = $product->mpn;
			$offerId = $product->offerId;
			$onlineOnly = $product->onlineOnly;
			$pattern = $product->pattern;
			$productType = $product->productType;
			$salePriceEffectiveDate = $product->salePriceEffectiveDate;
			$sizeSystem = $product->sizeSystem;
			$sizeType = $product->sizeType;
			$sizes = $product->sizes;
			$targetCountry = $product->targetCountry;
			$title = $product->title;
			$unitPricingBaseMeasure = $product->unitPricingBaseMeasure;
			$unitPricingMeasure = $product->unitPricingMeasure;
			$validatedDestinations = $product->validatedDestinations;
			$title = $product->title;
			$prices = $product->getPrice();

			$price_value = $prices->value;
			$price_currency = $prices->currency;

			$nonced_url = wp_nonce_url('admin.php?page=boltron_merchant_center_merchant_products&action=deletegmp&proid='.$id, 'delete_google_merchant_product');
			?>

			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $title; ?></td>
				<td><?php echo $price_value.' '.$price_currency; ?></td>
				<td><?php echo $availability; ?></td>
				<td><?php echo $condition; ?></td>
				<td><?php echo $countries[$targetCountry]; ?></td>
				<td><?php echo $languages[$contentLanguage]; ?></td>
				<td><a onclick="return confirm('Are you sure to delete this product from google merchant center ?')" href="<?php echo $nonced_url; ?>">Delete</a></td>
			</tr>

			
		<?php } ?>

		</table>
			
			
   
		<?php
		}
		else
		{
		?>
		<h1 style="float:left;">Google Merchant Center Products</h1>
		<a style="float:left; margin:1% 0 4% 5%;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=boltron_merchant_center_sync_merchant_products" class="btn btn-primary">Sync Your New Products</a><br><br><br><br><br>
		<center><h2>Sorry, No Products have synced with Google Merchant Center, yet. Please allow 24 hours for initial sync.</h2></center>
		<?php
		}

	}

	
	function get_language_from_country($targetCountry){
		
		$countrylanguage = include(dirname(dirname(__FILE__)).'/includes/countrylanguage.php');
		$currencyofcountry = include(dirname(dirname(__FILE__)).'/includes/currencyofcountry.php');
		
		$language = $countrylanguage[$targetCountry];
		$currency = $currencyofcountry[$targetCountry];
		$return = array("language"=>$language, "currency"=>$currency);
		echo json_encode($return);
		exit;
		
	}
	

	function boltron_merchant_center_crone(){ 
		$this->wp_merchant_center_synchronise_new_products();
	}  
 
	function wp_merchant_center_synchronise_new_products(){
           
		echo "<br><br> <span>&#x2192;</span> <a href='".site_url()."/wp-admin/admin.php?page=boltron_merchant_center_merchant_products'>Click here</a> to go back to Merchant Products.<br>";
		   
		global $woocommerce, $post, $wpdb;
		
		$merchant_id = $this->merchant_id;
		$merchant_boltron_id = $this->id;
		$membership_list_id = $this->membership_list_id;
		$sync_interval_per_day = $this->sync_interval_per_day;
		
		
		$merchant_clientid = $this->merchant_clientid;
		$merchant_client_secret = $this->merchant_client_secret;	
			
	
		if($membership_list_id > 0){
		
		$merchant_productlimit = $this->productlimit;
		$membership_start_date = $this->membership_start_date;
		$membership_end_date = $this->membership_end_date;
		
		$current_date = date('Y-m-d');
		$resultsdata = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}merchant_synchronised_product_counter_datewise WHERE merchant_google_id = {$merchant_id} AND merchant_boltron_id = {$merchant_boltron_id}"  );
		if(empty($resultsdata)){
			$product_sync_count = 0;
		}else{
			$product_sync_count = $resultsdata[0]->synchronised_product;
		}
		
		//This is for the Basic (free) Plan Merchant who have 10 products limit
		if(($merchant_productlimit > 0) && ($product_sync_count >= $merchant_productlimit)){
			echo "<br><br>";
			echo "<h3><span>&#x2192;</span> You are a basic member, your account is limited to 10 syncs. To get unlimited syncs, please upgrade at <a href='https://boltron.co/dev/project/merchant/login.php'>boltron</a>.</h3>";
			echo "<br><br>";
			exit;
		}
		
		//This is for the premium memerbers i check
		if($merchant_productlimit <= 0){
			
			$curdate=strtotime($current_date);
			$mydate=strtotime($membership_end_date);
			
			if($curdate > $mydate)
			{
			    echo "Subscription Plan is expired. Please update the membership plan.";
			    exit;
			}
			
		}
		
		
		$args     = array( 'post_type' => 'product', 'orderby'   => 'ID', 'order' => 'DESC', 'posts_per_page' => '500000' );
		$products = get_posts( $args ); 
		
		
		session_start();

		$client = new Google_Client();
		$client->setApplicationName('Boltron');
		$client->setClientId($merchant_clientid);
		$client->setClientSecret($merchant_client_secret);
		$redirect_url = admin_url('admin.php?page=boltron_merchant_center_sync_merchant_products');
		$client->setRedirectUri($redirect_url);
		$client->setScopes('https://www.googleapis.com/auth/content');

		if($client->isAccessTokenExpired()) {
			unset($_SESSION['oauth_access_token']);
		}
		
		
		if (isset($_SESSION['oauth_access_token'])) {
		  $client->setAccessToken($_SESSION['oauth_access_token']);
		} elseif (isset($_GET['code'])) {
		  $token = $client->authenticate($_GET['code']);
		  $_SESSION['oauth_access_token'] = $token;
		} else {
		  header('Location: ' . $client->createAuthUrl());
		  exit;
		}
		
		
		$service = new Google_Service_ShoppingContent($client);

		$woocommerce_weight_unit = get_option('woocommerce_weight_unit');
		$woocommerce_dimension_unit = get_option('woocommerce_dimension_unit');

		$googleproduct = new Google_Service_ShoppingContent_Product();
		
		$product_synchronised = 0;
		
		foreach($products as $product){

			$p_exclude_product = get_post_meta( $product->ID, '_boltron_google_exclude_product', true );
			if($p_exclude_product == 'yes'){	
				continue;
			}
		
			$p_offerID = $product->ID;
			$p_title = $product->post_title;
			$p_description = $product->post_content;
			$p_link = get_permalink( $product->ID );

			$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );
			$p_imagelink = $image_array[0];
			

			$p_contentlanguage = get_post_meta( $product->ID, '_boltron_google_content_language', true );
			$p_targetcountry = get_post_meta( $product->ID, '_boltron_google_target_country', true );
			$p_channel = 'online';

			$status = get_post_meta( $product->ID, '_stock_status', true );
			
			//If product have not enough stock then not consider this product
			if($status == 'outofstock'){
				continue;
			}
			
			
			$p_availability = '';
			if($status == 'instock'){
				$p_availability = 'in stock';
			}

			if($status == 'outofstock'){
				$p_availability = 'out of stock';
			}

			if($status == ''){
				$p_availability = 'in stock';
			}

			$p_price = get_post_meta( $product->ID, '_regular_price', true);
			
			$p_sale_price = get_post_meta( $product->ID, '_sale_price', true);
			
			$p_sale_price_start_date_in_timeformat = get_post_meta( $product->ID, '_sale_price_dates_from', true);
			$p_sale_price_end_date_in_timeformat = get_post_meta( $product->ID, '_sale_price_dates_to', true);

			$p_sale_price_start_date = date("Y-m-d", $p_sale_price_start_date_in_timeformat);
			$p_sale_price_end_date = date("Y-m-d", $p_sale_price_end_date_in_timeformat);
			
			$p_default_wp_price_currency = get_option('woocommerce_currency');
			
			$p_price_currency = get_post_meta( $product->ID, '_boltron_google_product_price_currency', true);

			$p_brand = get_post_meta( $product->ID, '_boltron_google_brand', true );
			$p_gtin = get_post_meta( $product->ID, '_boltron_google_gtin', true );
			$p_mpn = get_post_meta( $product->ID, '_boltron_google_mpn', true );
			$p_optimized_title = get_post_meta( $product->ID, '_boltron_google_optimized_title', true );
			$p_unit_pricing_measure = get_post_meta( $product->ID, '_boltron_google_unit_pricing_measure', true );
			$p_unit_pricing_base_measure = get_post_meta( $product->ID, '_boltron_google_unit_pricing_base_measure', true );
			$p_unit_pricing_installment_months = get_post_meta( $product->ID, '_boltron_google_installment_months', true );
			$p_condition = get_post_meta( $product->ID, '_boltron_google_condition', true );
			$p_google_product_category = get_post_meta( $product->ID, '_boltron_google_product_category', true );
			$p_adult = get_post_meta( $product->ID, '_boltron_google_adult', true );
			$p_multipack = get_post_meta( $product->ID, '_boltron_google_product_multipack', true );
			$p_isbundle = get_post_meta( $product->ID, '_boltron_google_isbundle', true );
			$p_agegroup = get_post_meta( $product->ID, '_boltron_google_agegroup', true );
			$p_color = get_post_meta( $product->ID, '_boltron_google_product_color', true );
			$p_gender = get_post_meta( $product->ID, '_boltron_google_product_gender', true );
			$p_material = get_post_meta( $product->ID, '_boltron_google_product_material', true );
			$p_pattern = get_post_meta( $product->ID, '_boltron_google_product_pattern', true );
			
			$p_woocommerce_weight = get_post_meta( $product->ID, '_weight', true );
			
			$p_woocommerce_length = get_post_meta( $product->ID, '_length', true );
			$p_woocommerce_width = get_post_meta( $product->ID, '_width', true );
			$p_woocommerce_height = get_post_meta( $product->ID, '_height', true );
			
			
			$p_shipping_country = get_post_meta( $product->ID, '_boltron_google_shipping_country', true );
			$p_shipping_region = get_post_meta( $product->ID, '_boltron_google_shipping_region', true );
			$p_shipping_postcode = get_post_meta( $product->ID, '_boltron_google_shipping_postcode', true );
			$p_shipping_price = get_post_meta( $product->ID, '_boltron_google_shipping_price', true );
			$p_shipping_price_currency = get_post_meta( $product->ID, '_boltron_google_shipping_price_currency', true );
			$p_shipping_service = get_post_meta( $product->ID, '_boltron_google_shipping_service', true );
			$p_shipping_weight_unit = get_post_meta( $product->ID, '_boltron_google_shipping_weight_unit', true );
			$p_shipping_weight_value = get_post_meta( $product->ID, '_boltron_google_shipping_weight_value', true );
			$p_custom_label_0 = get_post_meta( $product->ID, '_boltron_google_custom_label_0', true );
			$p_custom_label_1 = get_post_meta( $product->ID, '_boltron_google_custom_label_1', true );
			$p_custom_label_2 = get_post_meta( $product->ID, '_boltron_google_custom_label_2', true );
			$p_custom_label_3 = get_post_meta( $product->ID, '_boltron_google_custom_label_3', true );
			$p_custom_label_4 = get_post_meta( $product->ID, '_boltron_google_custom_label_4', true );
			
			$p_mobile_link = get_post_meta( $product->ID, '_boltron_google_mobile_link', true );
			
			$p_online_only = get_post_meta( $product->ID, '_boltron_google_online_only', true );

			
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}google_synchronised_product WHERE product_id = {$p_offerID}" );

			
			if(empty($results) && $p_offerID != '' && $p_title != '' && $p_description != '' && $p_link != '' && $p_imagelink != '' && $p_availability != '' && $p_price != '' && $p_price_currency != '')
			{
			
				$googleproduct->setOfferId($p_offerID);
				
				if($p_optimized_title != ''){
					$googleproduct->setTitle($p_optimized_title);
				}else{
					$googleproduct->setTitle($p_title);
				}
				
				$googleproduct->setDescription($p_description);
				$googleproduct->setLink($p_link);
				$googleproduct->setImageLink($p_imagelink);
				$googleproduct->setContentLanguage($p_contentlanguage);
				$googleproduct->setTargetCountry($p_targetcountry);
				$googleproduct->setChannel($p_channel);
				$googleproduct->setAvailability($p_availability);
				
				$price = new Google_Service_ShoppingContent_Price();
				$price->setValue($p_price);
				$price->setCurrency($p_price_currency);
				$googleproduct->setPrice($price);
				
				if($p_sale_price != '' && $p_sale_price > 0){
					
					$saleprice = new Google_Service_ShoppingContent_Price();
					$saleprice->setValue($p_sale_price);
					$saleprice->setCurrency($p_price_currency);
					$googleproduct->setSalePrice($saleprice);
					
					if($p_sale_price_start_date != '' && $p_sale_price_end_date != ''){
						$googleproduct->setSalePriceEffectiveDate($p_sale_price_start_date.'/'.$p_sale_price_end_date);
					}
					
				}
				

				
				if($p_brand != ''){
					$googleproduct->setBrand($p_brand);
				}
				
				if($p_gtin != ''){
					$googleproduct->setGtin($p_gtin);
				}
				
				if($p_gtin == '' && $p_mpn != ''){
					$googleproduct->setMpn($p_mpn);
				}
				
				if($p_gtin == '' && $p_mpn == ''){
					$googleproduct->setIdentifierExists('no');
				}
				
				if($p_unit_pricing_measure != ''){
					$googleproduct->setUnitPricingMeasure($p_unit_pricing_measure);
				}
				
				if($p_unit_pricing_base_measure != ''){
					$googleproduct->setUnitPricingBaseMeasure($p_unit_pricing_base_measure);
				}
				
				
				
				if($p_unit_pricing_installment_months != ''){
					$installment = new Google_Service_ShoppingContent_ProductInstallment();
					$installment->setMonths($p_unit_pricing_installment_months);
					$installment->setAmount($price);
					$googleproduct->setInstallment($installment);
				}
				
				if($p_condition != ''){
					$googleproduct->setCondition($p_condition);
				}
				
				if($p_google_product_category != ''){
					$googleproduct->setGoogleProductCategory($p_google_product_category);
				}
				
				if($p_adult != ''){
					$googleproduct->setAdult($p_adult);	
				}
				
				if($p_multipack != ''){
					$googleproduct->setMerchantMultipackQuantity($p_multipack);
				}
				
				if($p_isbundle != ''){
					$googleproduct->setIsBundle($p_isbundle);
				}
				
				if($p_agegroup != ''){
					$googleproduct->setAgeGroup($p_agegroup);
				}
				
				if($p_color != ''){
					$googleproduct->setColor($p_color);
				}
				
				if($p_gender != ''){
					$googleproduct->setGender($p_gender);
				}
				
				if($p_material != ''){
					$googleproduct->setMaterial($p_material);
				}
				
				if($p_pattern != ''){
					$googleproduct->setPattern($p_pattern);
				}

				
				if($p_shipping_price != '' && $p_shipping_price_currency != ''){
					
					$shipping_price = new Google_Service_ShoppingContent_Price();
					$shipping_price->setValue($p_shipping_price);
					$shipping_price->setCurrency($p_shipping_price_currency);
					
					$shipping = new Google_Service_ShoppingContent_ProductShipping();
					$shipping->setPrice($shipping_price);
					
					if($p_shipping_country != ''){
						$shipping->setCountry($p_shipping_country);
					}
					
					if($p_shipping_region != ''){
						$shipping->setRegion($p_shipping_region);
					}else{
						if($p_shipping_postcode != ''){
							$shipping->setRegion($p_shipping_postcode);
						}
					}
					
					
					if($p_shipping_service != ''){
						$shipping->setService($p_shipping_service);
					}
					
					
					$googleproduct->setShipping(array($shipping));
					
				}
				

				
				if($p_shipping_weight_unit != '' && $p_shipping_weight_value != ''){
					$shipping_weight = new Google_Service_ShoppingContent_ProductShippingWeight();
					
					$shipping_weight->setValue($p_shipping_weight_value);
					$shipping_weight->setUnit($p_shipping_weight_unit);
					
					$googleproduct->setShippingWeight($shipping_weight);
				}
	
				
				if($p_custom_label_0 != ''){
					$googleproduct->setCustomLabel0($p_custom_label_0);
				}
				
				if($p_custom_label_1 != ''){
					$googleproduct->setCustomLabel1($p_custom_label_1);
				}
				
				if($p_custom_label_2 != ''){
					$googleproduct->setCustomLabel2($p_custom_label_2);
				}
				
				if($p_custom_label_3 != ''){
					$googleproduct->setCustomLabel3($p_custom_label_3);
				}
				
				if($p_custom_label_4 != ''){
					$googleproduct->setCustomLabel4($p_custom_label_4);
				}
				
				if($p_mobile_link != ''){
					$googleproduct->setMobileLink($p_mobile_link);
				}

				if($p_online_only != ''){
					$googleproduct->setOnlineOnly($p_online_only);
				}
				

				$result = $service->products->insert($merchant_id, $googleproduct);
				
				$inserted_product_title = $result->title;
				$inserted_product_id = $result->offerId;
				
				if(!empty($result)){
					$product_synchronised++;
					
					
					$current_date = date('Y-m-d');
					$resultsdata = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}merchant_synchronised_product_counter_datewise WHERE merchant_google_id = {$merchant_id} AND merchant_boltron_id = {$merchant_boltron_id}"  );
					
					
					
					if(empty($resultsdata)){
						$tablename=$wpdb->prefix.'merchant_synchronised_product_counter_datewise';
						
						$insertdata=array(
							'merchant_boltron_id' => $merchant_boltron_id, 
							'merchant_google_id' => $merchant_id,
							'synchronised_product' => 1
						);
						
						$wpdb->insert( $tablename, $insertdata);
					}else{
						
						$synchronised_product_count_today = $resultsdata[0]->synchronised_product;
						
						$synchronised_product_count_today++;
						
						$tablename=$wpdb->prefix.'merchant_synchronised_product_counter_datewise';
						
						$sql = "UPDATE $tablename SET synchronised_product='$synchronised_product_count_today' WHERE merchant_google_id = '".$merchant_id."' AND merchant_boltron_id = '".$merchant_boltron_id."'";
						$wpdb->query($sql);
					
					}
					

					$tablename=$wpdb->prefix.'google_synchronised_product';
					
					$data=array(
						'product_id' => $inserted_product_id, 
						'product_name' => $inserted_product_title,
						'datetime' => date('Y-m-d H:i:s')
					);
					
					
					$wpdb->insert( $tablename, $data);
					
				}
				
				echo "<br><br>";
				echo "<h3><span>&#x2192;</span> Product id = ".$inserted_product_id.", title = ".$inserted_product_title." is synchronised successfully with google merchant center.</h3>";
				
			}
		} //end of product foreach loop

		if($product_synchronised == '0'){
			echo "<br>";
			echo "<h3><span>&#x2192;</span> No New Products Available for Synchronization.</h3>";
		}
		
		
		exit;
		
	}
}

	
}

?>