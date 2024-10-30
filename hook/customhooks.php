<?php

add_filter( 'woocommerce_product_data_tabs', 'add_my_custom_product_data_tab' , 99 , 1 );
function add_my_custom_product_data_tab( $product_data_tabs ) {
    $product_data_tabs['my-custom-tab'] = array(
        'label' => __( 'Google Merchant', 'woocommerce' ),
        'target' => 'my_custom_product_data',
    );
    return $product_data_tabs;
}




add_action( 'woocommerce_product_data_panels', 'add_my_custom_product_data_fields' );
function add_my_custom_product_data_fields() {
    global $woocommerce, $post;
    ?>
    <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
    <div id="my_custom_product_data" class="panel woocommerce_options_panel options_group">
        <?php
	    
			// Brand field
			woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_brand',
						'label'       => __( 'Brand <span style="color:red;">*</span>', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_brand', true ),
						'description' => __( "Your product's brand name for ex. Google", 'woocommerce' )
					)

			);

			
			// Global Trade Item Number (GTIN) Field

	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_boltron_google_gtin',
	                        	'label'       => __( 'GTIN <span style="color:red;">*</span>', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_gtin', true ),
	                        	'description' => __( "Your product's Global Trade Item Number (GTIN) for ex. 3234567890126. Also supported for UPC, EAN, JAN, ISBN or ITF-14", 'woocommerce' ),
	                	)

	        	);

			
			// MPN Field

	        	woocommerce_wp_text_input(

	                	array(
	                        	'id'          => '_boltron_google_mpn',
	                        	'label'       => __( 'MPN (SKU) <span style="color:red;">*</span>', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_mpn', true ),
	                        	'description' => __( "Your product's Manufacturer Part Number (mpn) for ex. GO12345OOGLE. Required Only if your new product does not have a manufacturer assigned GTIN", 'woocommerce' ),
	                	)
	        	);
			
			
			// Unit pricing measure Field
	        	woocommerce_wp_text_input(

	                	array(
	                        	'id'          => '_boltron_google_unit_pricing_measure',
	                        	'label'       => __( 'Unit pricing measure', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_unit_pricing_measure', true ),
	                        	'description' => __( 'The measure and dimension of your product as it is sold for ex. 1.5kg. Use the same unit of measure for both unit_pricing_measure and unit_pricing_base_measure', 'woocommerce' ),
	                	)

	        	);

			// Unit pricing base measure Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_boltron_google_unit_pricing_base_measure',
	                        	'label'       => __( 'Unit pricing base measure', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_unit_pricing_base_measure', true ),
	                        	'description' => __( "The product's base measure for pricing (e.g. 100ml means the price is calculated based on a 100ml units. Use the same unit of measure for both unit_pricing_measure and unit_pricing_base_measure", 'woocommerce' ),
	                	)
	        	);


			// Installment months

	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_boltron_google_installment_months',
	                        	'label'       => __( 'Installment months', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_installment_months', true ),
	                        	'description' => __( 'Enter the number of monthly installments the buyer has to pay.', 'woocommerce' ),
	                	)
	        	);

			
			// Google Product Category
	        	woocommerce_wp_text_input(

	                	array(
	                        	'id'          => '_boltron_google_product_category',
	                        	'label'       => __( 'Google Product Category <span style="color:red;">*</span>', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_category', true ),
	                        	'description' => __( 'Google-defined product category for your product for ex. Apparel & Accessories > Clothing > Outerwear > Coats & Jackets or 371', 'woocommerce' ),
	                	)
	        	);
				
			echo "<p class='form-field'><label></label>Please click on <a target='_blank' href='https://www.google.com/basepages/producttype/taxonomy.en-US.txt'>this link</a>, copy and paste google taxonomy that matches your product.</p>";
				
			    // Add product condition drop-down
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_condition',
						'label'		=> __( 'Product condition <span style="color:red;">*</span>', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'The condition of your product at time of sale', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_condition', true ),
						'options'	=> array (
							''		=> __( 'Select', 'woocommerce' ),
							'new'		=> __( 'new', 'woocommerce' ),
							'refurbished'	=> __( 'refurbished', 'woocommerce' ),
							'used'		=> __( 'used', 'woocommerce' ),
						)
					)
				);
				
				
				// adult content
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_adult',
						'label'		=> __( 'Adult Content', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'Indicate a product includes sexually suggestive content', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_adult', true ),
						'options'	=> array (
							''		=> __( 'Select', 'woocommerce' ),
							'yes'		=> __( 'yes', 'woocommerce' ),
							'no'		=> __( 'no', 'woocommerce' ),
						)
					)
				);
				
				
				
				// Multipack
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_product_multipack',
						'label'       => __( 'Multipack', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_multipack', true ),
						'description' => __( "The number of identical products sold within a merchant-defined multipack. For example, you're selling 6 bars of soap together then enter 6. Enter greater than 1 (multipacks cannot contain 1 product)", 'woocommerce' ),
					)
				);
				
				
				// Is Bundle product
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_isbundle',
						'label'		=> __( 'Is Bundle', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'Indicates a product is custom group of different products featuring one main product. For example, a camera combined with a lens and bag.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_isbundle', true ),
						'options'	=> array (
							''		=> __( 'Select', 'woocommerce' ),
							'yes'		=> __( 'yes', 'woocommerce' ),
							'no'		=> __( 'no', 'woocommerce' ),
						)
					)
				);
				
				
				// Age Group
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_agegroup',
						'label'		=> __( 'Age Group', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'The demographic for which your product is intended.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_agegroup', true ),
						'options'	=> array (
						    ''			=> __( 'Select', 'woocommerce' ),
						    'newborn'		=> __( 'newborn', 'woocommerce' ),
						    'infant'		=> __( 'infant', 'woocommerce' ),
						    'toddler'		=> __( 'toddler', 'woocommerce' ),
						    'kids'		=> __( 'kids', 'woocommerce' ),
						    'adult'		=> __( 'adult', 'woocommerce' ),
						)
					)
				);
				
				
				// Color
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_product_color',
						'label'       => __( 'Color', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_color', true ),
						'description' => __( "Your product's color(s) for ex. Black. Don't use hexa color code. Don't combine several color names into 1 word, such as RedPinkBlue. Instead, separate them with a /, such as Red/Pink/Blue.", 'woocommerce' ),
					)
				);
				
				// Gender
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_product_gender',
						'label'		=> __( 'Gender', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'The gender for which your product is intended.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_gender', true ),
						'options'	=> array (
						    ''			=> __( 'Select', 'woocommerce' ),
						    'male'		=> __( 'male', 'woocommerce' ),
						    'female'		=> __( 'female', 'woocommerce' ),
						    'unisex'		=> __( 'unisex', 'woocommerce' ),
						)
					)
				);
				
				
				
				// Material
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_product_material',
						'label'       => __( 'Material', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_material', true ),
						'description' => __( "Your product's fabric or material. for ex. leather. If having multiple materials than separated by a /. for ex. cotton/polyester/elastane.", 'woocommerce' ),
					)
				);
				
				// Pattern
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_product_pattern',
						'label'       => __( 'Pattern', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_pattern', true ),
						'description' => __( "Your product's pattern or graphic print. for ex. striped or polka dot or paisley etc..", 'woocommerce' ),
					)
				);
				

			// Optimized product custom title Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_boltron_google_optimized_title',
	                        	'label'       => __( 'Optimized Title', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
					'value'           =>  get_post_meta( $post->ID, '_boltron_google_optimized_title', true ),
	                        	'description' => __( 'Enter a optimized product title.', 'woocommerce' ),
	                	)
	        	);

				
				
				// Target Country
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_target_country',
						'label'		=> __( 'Target Country <span style="color:red;">*</span>', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'Select the target country.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_target_country', true ),
						'options'	=> array (
						    ''			=> __( 'Select', 'woocommerce' ),
						    'AU'		=> __( 'Australia', 'woocommerce' ),
						    'AT'		=> __( 'Austria', 'woocommerce' ),
						    'BE'		=> __( 'Belgium', 'woocommerce' ),
						    'BR'		=> __( 'Brazil', 'woocommerce' ),
						    'CA'		=> __( 'Canada', 'woocommerce' ),
						    'CN'		=> __( 'China', 'woocommerce' ),
						    'CZ'		=> __( 'Czech Republic', 'woocommerce' ),
						    'DK'		=> __( 'Denmark', 'woocommerce' ),
						    'FR'		=> __( 'France', 'woocommerce' ),
						    'DE'		=> __( 'Germany', 'woocommerce' ),
						    'IN'		=> __( 'India', 'woocommerce' ),
						    'IT'		=> __( 'Italy', 'woocommerce' ),
						    'JP'		=> __( 'Japan', 'woocommerce' ),
						    'MX'		=> __( 'Mexico', 'woocommerce' ),
						    'NL'		=> __( 'Netherlands', 'woocommerce' ),
						    'NO'		=> __( 'Norway', 'woocommerce' ),
						    'PL'		=> __( 'Poland', 'woocommerce' ),
						    'RU'		=> __( 'Russia', 'woocommerce' ),
						    'ES'		=> __( 'Spain', 'woocommerce' ),
						    'SE'		=> __( 'Sweden', 'woocommerce' ),
						    'CH'		=> __( 'Switzerland', 'woocommerce' ),
						    'TR'		=> __( 'Turkey', 'woocommerce' ),
						    'GB'		=> __( 'United Kingdom (UK)', 'woocommerce' ),
						    'US'		=> __( 'United States (US)', 'woocommerce' ),
						)
					)
				);
				
				echo '<input type="hidden" name="google_merchant_extra_fields" id="google_merchant_extra_fields" value="' . wp_create_nonce( 'google_merchant_extra_fields' ) . '" />';
				
				// Content Language
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_content_language',
						'label'		=> __( 'Content Language', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'Select the content language.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_content_language', true ),
						'options'	=> array (
						    ''			=> __( 'Select', 'woocommerce' ),
						    'aa'=> __( 'Afar (aa)', 'woocommerce' ),
						    'ab'=> __( 'Abkhazian (ab)', 'woocommerce' ),
						    'ae'=> __( 'Avestan (ae)', 'woocommerce' ),
						    'af'=> __( 'Afrikaans (af)', 'woocommerce' ),
						    'ak'=> __( 'Akan (ak)', 'woocommerce' ),
						    'am'=> __( 'Amharic (am)', 'woocommerce' ),
						    'an'=> __( 'Aragonese (an)', 'woocommerce' ),
						    'ar'=> __( 'Arabic (ar)', 'woocommerce' ),
						    'as'=> __( 'Assamese (as)', 'woocommerce' ),
						    'av'=> __( 'Avaric (av)', 'woocommerce' ),
						    'ay'=> __( 'Aymara (ay)', 'woocommerce' ),
						    'az'=> __( 'Azerbaijani (az)', 'woocommerce' ),
						    'ba'=> __( 'Bashkir (ba)', 'woocommerce' ),
						    'be'=> __( 'Belarusian (be)', 'woocommerce' ),
						    'bg'=> __( 'Bulgarian (bg)', 'woocommerce' ),
						    'bh'=> __( 'Bihari languages (bh)', 'woocommerce' ),
						    'bi'=> __( 'Bislama (bi)', 'woocommerce' ),
						    'bm'=> __( 'Bambara (bm)', 'woocommerce' ),
						    'bn'=> __( 'Bengali (bn)', 'woocommerce' ),
						    'bo'=> __( 'Tibetan (bo)', 'woocommerce' ),
						    'br'=> __( 'Breton (br)', 'woocommerce' ),
						    'bs'=> __( 'Bosnian (bs)', 'woocommerce' ),
						    'ca'=> __( 'Catalan; Valencian (ca)', 'woocommerce' ),
						    'ce'=> __( 'Chechen (ce)', 'woocommerce' ),
						    'ch'=> __( 'Chamorro (ch)', 'woocommerce' ),
						    'co'=> __( 'Corsican (co)', 'woocommerce' ),
						    'cr'=> __( 'Cree (cr)', 'woocommerce' ),
						    'cs'=> __( 'Czech (cs)', 'woocommerce' ),
						    'cu'=> __( 'Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic (cu)', 'woocommerce' ),
						    'cv'=> __( 'Chuvash (cv)', 'woocommerce' ),
						    'cy'=> __( 'Welsh (cy)', 'woocommerce' ),
						    'da'=> __( 'Danish (da)', 'woocommerce' ),
						    'de'=> __( 'German (de)', 'woocommerce' ),
						    'dv'=> __( 'Divehi; Dhivehi; Maldivian (dv)', 'woocommerce' ),
						    'dz'=> __( 'Dzongkha (dz)', 'woocommerce' ),
						    'ee'=> __( 'Ewe (ee)', 'woocommerce' ),
						    'el'=> __( 'Greek, Modern (1453-) (el)', 'woocommerce' ),
						    'en'=> __( 'English (en)', 'woocommerce' ),
						    'eo'=> __( 'Esperanto (eo)', 'woocommerce' ),
						    'es'=> __( 'Spanish; Castilian (es)', 'woocommerce' ),
						    'et'=> __( 'Estonian (et)', 'woocommerce' ),
						    'eu'=> __( 'Basque (eu)', 'woocommerce' ),
						    'fa'=> __( 'Persian (fa)', 'woocommerce' ),
						    'ff'=> __( 'Fulah (ff)', 'woocommerce' ),
						    'fi'=> __( 'Finnish (fi)', 'woocommerce' ),
						    'fj'=> __( 'Fijian (fj)', 'woocommerce' ),
						    'fo'=> __( 'Faroese (fo)', 'woocommerce' ),
						    'fr'=> __( 'French (fr)', 'woocommerce' ),
						    'fy'=> __( 'Western Frisian (fy)', 'woocommerce' ),
						    'ga'=> __( 'Irish (ga)', 'woocommerce' ),
						    'gd'=> __( 'Gaelic; Scottish Gaelic (gd)', 'woocommerce' ),
						    'gl'=> __( 'Galician (gl)', 'woocommerce' ),
						    'gn'=> __( 'Guarani (gn)', 'woocommerce' ),
						    'gu'=> __( 'Gujarati (gu)', 'woocommerce' ),
						    'gv'=> __( 'Manx (gv)', 'woocommerce' ),
						    'ha'=> __( 'Hausa (ha)', 'woocommerce' ),
						    'he'=> __( 'Hebrew (he)', 'woocommerce' ),
						    'hi'=> __( 'Hindi (hi)', 'woocommerce' ),
						    'ho'=> __( 'Hiri Motu (ho)', 'woocommerce' ),
						    'hr'=> __( 'Croatian (hr)', 'woocommerce' ),
						    'ht'=> __( 'Haitian; Haitian Creole (ht)', 'woocommerce' ),
						    'hu'=> __( 'Hungarian (hu)', 'woocommerce' ),
						    'hy'=> __( 'Armenian (hy)', 'woocommerce' ),
						    'hz'=> __( 'Herero (hz)', 'woocommerce' ),
						    'ia'=> __( 'Interlingua (International Auxiliary Language Association) (ia)', 'woocommerce' ),
						    'id'=> __( 'Indonesian (id)', 'woocommerce' ),
						    'ie'=> __( 'Interlingue; Occidental (ie)', 'woocommerce' ),
						    'ig'=> __( 'Igbo (ig)', 'woocommerce' ),
						    'ii'=> __( 'Sichuan Yi; Nuosu (ii)', 'woocommerce' ),
						    'ik'=> __( 'Inupiaq (ik)', 'woocommerce' ),
						    'io'=> __( 'Ido (io)', 'woocommerce' ),
						    'is'=> __( 'Icelandic (is)', 'woocommerce' ),
						    'it'=> __( 'Italian (it)', 'woocommerce' ),
						    'iu'=> __( 'Inuktitut (iu)', 'woocommerce' ),
						    'ja'=> __( 'Japanese (ja)', 'woocommerce' ),
						    'jv'=> __( 'Javanese (jv)', 'woocommerce' ),
						    'ka'=> __( 'Georgian (ka)', 'woocommerce' ),
						    'kg'=> __( 'Kongo (kg)', 'woocommerce' ),
						    'ki'=> __( 'Kikuyu; Gikuyu (ki)', 'woocommerce' ),
						    'kj'=> __( 'Kuanyama; Kwanyama (kj)', 'woocommerce' ),
						    'kk'=> __( 'Kazakh (kk)', 'woocommerce' ),
						    'kl'=> __( 'Kalaallisut; Greenlandic (kl)', 'woocommerce' ),
						    'km'=> __( 'Central Khmer (km)', 'woocommerce' ),
						    'kn'=> __( 'Kannada (kn)', 'woocommerce' ),
						    'ko'=> __( 'Korean (ko)', 'woocommerce' ),
						    'kr'=> __( 'Kanuri (kr)', 'woocommerce' ),
						    'ks'=> __( 'Kashmiri (ks)', 'woocommerce' ),
						    'ku'=> __( 'Kurdish (ku)', 'woocommerce' ),
						    'kv'=> __( 'Komi (kv)', 'woocommerce' ),
						    'kw'=> __( 'Cornish (kw)', 'woocommerce' ),
						    'ky'=> __( 'Kirghiz; Kyrgyz (ky)', 'woocommerce' ),
						    'la'=> __( 'Latin (la)', 'woocommerce' ),
						    'lb'=> __( 'Luxembourgish; Letzeburgesch (lb)', 'woocommerce' ),
						    'lg'=> __( 'Ganda (lg)', 'woocommerce' ),
						    'li'=> __( 'Limburgan; Limburger; Limburgish (li)', 'woocommerce' ),
						    'ln'=> __( 'Lingala (ln)', 'woocommerce' ),
						    'lo'=> __( 'Lao (lo)', 'woocommerce' ),
						    'lt'=> __( 'Lithuanian (lt)', 'woocommerce' ),
						    'lu'=> __( 'Luba-Katanga (lu)', 'woocommerce' ),
						    'lv'=> __( 'Latvian (lv)', 'woocommerce' ),
						    'mg'=> __( 'Malagasy (mg)', 'woocommerce' ),
						    'mh'=> __( 'Marshallese (mh)', 'woocommerce' ),
						    'mi'=> __( 'Maori (mi)', 'woocommerce' ),
						    'mk'=> __( 'Macedonian (mk)', 'woocommerce' ),
						    'ml'=> __( 'Malayalam (ml)', 'woocommerce' ),
						    'mn'=> __( 'Mongolian (mn)', 'woocommerce' ),
						    'mr'=> __( 'Marathi (mr)', 'woocommerce' ),
						    'ms'=> __( 'Malay (ms)', 'woocommerce' ),
						    'mt'=> __( 'Maltese (mt)', 'woocommerce' ),
						    'my'=> __( 'Burmese (my)', 'woocommerce' ),
						    'na'=> __( 'Nauru (na)', 'woocommerce' ),
						    'nb'=> __( 'Bokmal, Norwegian; Norwegian Bokmal (nb)', 'woocommerce' ),
						    'nd'=> __( 'Ndebele, North; North Ndebele (nd)', 'woocommerce' ),
						    'ne'=> __( 'Nepali (ne)', 'woocommerce' ),
						    'ng'=> __( 'Ndonga (ng)', 'woocommerce' ),
						    'nl'=> __( 'Dutch; Flemish (nl)', 'woocommerce' ),
						    'nn'=> __( 'Norwegian Nynorsk; Nynorsk, Norwegian (nn)', 'woocommerce' ),
						    'no'=> __( 'Norwegian (no)', 'woocommerce' ),
						    'nr'=> __( 'Ndebele, South; South Ndebele (nr)', 'woocommerce' ),
						    'nv'=> __( 'Navajo; Navaho (nv)', 'woocommerce' ),
						    'ny'=> __( 'Chichewa; Chewa; Nyanja (ny)', 'woocommerce' ),
						    'oc'=> __( 'Occitan (post 1500); Provencal (oc)', 'woocommerce' ),
						    'oj'=> __( 'Ojibwa (oj)', 'woocommerce' ),
						    'om'=> __( 'Oromo (om)', 'woocommerce' ),
						    'or'=> __( 'Oriya (or)', 'woocommerce' ),
						    'os'=> __( 'Ossetian; Ossetic (os)', 'woocommerce' ),
						    'pa'=> __( 'Panjabi; Punjabi (pa)', 'woocommerce' ),
						    'pi'=> __( 'Pali (pi)', 'woocommerce' ),
						    'pl'=> __( 'Polish (pl)', 'woocommerce' ),
						    'ps'=> __( 'Pushto; Pashto (ps)', 'woocommerce' ),
						    'pt'=> __( 'Portuguese (pt)', 'woocommerce' ),
						    'qu'=> __( 'Quechua (qu)', 'woocommerce' ),
						    'rm'=> __( 'Romansh (rm)', 'woocommerce' ),
						    'rn'=> __( 'Rundi (rn)', 'woocommerce' ),
						    'ro'=> __( 'Romanian; Moldavian; Moldovan (ro)', 'woocommerce' ),
						    'ru'=> __( 'Russian (ru)', 'woocommerce' ),
						    'rw'=> __( 'Kinyarwanda (rw)', 'woocommerce' ),
						    'sa'=> __( 'Sanskrit (sa)', 'woocommerce' ),
						    'sc'=> __( 'Sardinian (sc)', 'woocommerce' ),
						    'sd'=> __( 'Sindhi (sd)', 'woocommerce' ),
						    'se'=> __( 'Northern Sami (se)', 'woocommerce' ),
						    'sg'=> __( 'Sango (sg)', 'woocommerce' ),
						    'si'=> __( 'Sinhala; Sinhalese (si)', 'woocommerce' ),
						    'sk'=> __( 'Slovak (sk)', 'woocommerce' ),
						    'sl'=> __( 'Slovenian (sl)', 'woocommerce' ),
						    'sm'=> __( 'Samoan (sm)', 'woocommerce' ),
						    'sn'=> __( 'Shona (sn)', 'woocommerce' ),
						    'so'=> __( 'Somali (so)', 'woocommerce' ),
						    'sq'=> __( 'Albanian (sq)', 'woocommerce' ),
						    'sr'=> __( 'Serbian (sr)', 'woocommerce' ),
						    'ss'=> __( 'Swati (ss)', 'woocommerce' ),
						    'st'=> __( 'Sotho, Southern (st)', 'woocommerce' ),
						    'su'=> __( 'Sundanese (su)', 'woocommerce' ),
						    'sv'=> __( 'Swedish (sv)', 'woocommerce' ),
						    'sw'=> __( 'Swahili (sw)', 'woocommerce' ),
						    'ta'=> __( 'Tamil (ta)', 'woocommerce' ),
						    'te'=> __( 'Telugu (te)', 'woocommerce' ),
						    'tg'=> __( 'Tajik (tg)', 'woocommerce' ),
						    'th'=> __( 'Thai (th)', 'woocommerce' ),
						    'ti'=> __( 'Tigrinya (ti)', 'woocommerce' ),
						    'tk'=> __( 'Turkmen (tk)', 'woocommerce' ),
						    'tl'=> __( 'Tagalog (tl)', 'woocommerce' ),
						    'tn'=> __( 'Tswana (tn)', 'woocommerce' ),
						    'to'=> __( 'Tonga (Tonga Islands) (to)', 'woocommerce' ),
						    'tr'=> __( 'Turkish (tr)', 'woocommerce' ),
						    'ts'=> __( 'Tsonga (ts)', 'woocommerce' ),
						    'tt'=> __( 'Tatar (tt)', 'woocommerce' ),
						    'tw'=> __( 'Twi (tw)', 'woocommerce' ),
						    'ty'=> __( 'Tahitian (ty)', 'woocommerce' ),
						    'ug'=> __( 'Uighur; Uyghur (ug)', 'woocommerce' ),
						    'uk'=> __( 'Ukrainian (uk)', 'woocommerce' ),
						    'ur'=> __( 'Urdu (ur)', 'woocommerce' ),
						    'uz'=> __( 'Uzbek (uz)', 'woocommerce' ),
						    've'=> __( 'Venda (ve)', 'woocommerce' ),
						    'vi'=> __( 'Vietnamese (vi)', 'woocommerce' ),
						    'vo'=> __( 'Volapuk (vo)', 'woocommerce' ),
						    'wa'=> __( 'Walloon (wa)', 'woocommerce' ),
						    'wo'=> __( 'Wolof (wo)', 'woocommerce' ),
						    'xh'=> __( 'Xhosa (xh)', 'woocommerce' ),
						    'yi'=> __( 'Yiddish (yi)', 'woocommerce' ),
						    'yo'=> __( 'Yoruba (yo)', 'woocommerce' ),
						    'za'=> __( 'Zhuang; Chuang (za)', 'woocommerce' ),
						    'zh'=> __( 'Chinese (zh)', 'woocommerce' ),
						    'zu'=> __( 'Zulu (zu)', 'woocommerce' ),
						)
					)
				);
				
				
				
				// Price Currency
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_product_price_currency',
						'label'       => __( 'Price Currency <span style="color:red;">*</span>', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_product_price_currency', true ),
						'description' => __( 'The currency of the price.', 'woocommerce' ),
					)
				);
				
				
				// Shipping Country Field
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_shipping_country',
						'label'		=> __( 'Shipping Country', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description' => __( 'Select country to which an item will ship.', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_country', true ),
						'options'	=> array (
						    ''	  => __( 'Select', 'woocommerce' ),
						    'AF'  => __( 'Afghanistan', 'woocommerce' ),
						    'AX'  => __( 'Aland Islands', 'woocommerce' ),
						    'AL'  => __( 'Albania', 'woocommerce' ),
						    'DZ'  => __( 'Algeria', 'woocommerce' ),
						    'AS'  => __( 'American Samoa', 'woocommerce' ),
						    'AD'  => __( 'Andorra', 'woocommerce' ),
						    'AO'  => __( 'Angola', 'woocommerce' ),
						    'AI'  => __( 'Anguilla', 'woocommerce' ),
						    'AQ'  => __( 'Antarctica', 'woocommerce' ),
						    'AG'  => __( 'Antigua and Barbuda', 'woocommerce' ),
						    'AR'  => __( 'Argentina', 'woocommerce' ),
						    'AM'  => __( 'Armenia', 'woocommerce' ),
						    'AW'  => __( 'Aruba', 'woocommerce' ),
						    'AU'  => __( 'Australia', 'woocommerce' ),
						    'AT'  => __( 'Austria', 'woocommerce' ),
						    'AZ'  => __( 'Azerbaijan', 'woocommerce' ),
						    'BS'  => __( 'Bahamas', 'woocommerce' ),
						    'BH'  => __( 'Bahrain', 'woocommerce' ),
						    'BD'  => __( 'Bangladesh', 'woocommerce' ),
						    'BB'  => __( 'Barbados', 'woocommerce' ),
						    'BY'  => __( 'Belarus', 'woocommerce' ),
						    'BE'  => __( 'Belgium', 'woocommerce' ),
						    'BZ'  => __( 'Belize', 'woocommerce' ),
						    'BJ'  => __( 'Benin', 'woocommerce' ),
						    'BM'  => __( 'Bermuda', 'woocommerce' ),
						    'BT'  => __( 'Bhutan', 'woocommerce' ),
						    'BO'  => __( 'Bolivia', 'woocommerce' ),
						    'BA'  => __( 'Bosnia and Herzegovina', 'woocommerce' ),
						    'BW'  => __( 'Botswana', 'woocommerce' ),
						    'BV'  => __( 'Bouvet Island', 'woocommerce' ),
						    'BR'  => __( 'Brazil', 'woocommerce' ),
						    'IO'  => __( 'British Indian Ocean Territory', 'woocommerce' ),
						    'BN'  => __( 'Brunei Darussalam', 'woocommerce' ),
						    'BG'  => __( 'Bulgaria', 'woocommerce' ),
						    'BF'  => __( 'Burkina Faso', 'woocommerce' ),
						    'BI'  => __( 'Burundi', 'woocommerce' ),
						    'KH'  => __( 'Cambodia', 'woocommerce' ),
						    'CM'  => __( 'Cameroon', 'woocommerce' ),
						    'CA'  => __( 'Canada', 'woocommerce' ),
						    'CV'  => __( 'Cape Verde', 'woocommerce' ),
						    'KY'  => __( 'Cayman Islands', 'woocommerce' ),
						    'CF'  => __( 'Central African Republic', 'woocommerce' ),
						    'TD'  => __( 'Chad', 'woocommerce' ),
						    'CL'  => __( 'Chile', 'woocommerce' ),
						    'CN'  => __( 'China', 'woocommerce' ),
						    'CX'  => __( 'Christmas Island', 'woocommerce' ),
						    'CC'  => __( 'Cocos (Keeling) Islands', 'woocommerce' ),
						    'CO'  => __( 'Colombia', 'woocommerce' ),
						    'KM'  => __( 'Comoros', 'woocommerce' ),
						    'CG'  => __( 'Congo', 'woocommerce' ),
						    'CD'  => __( 'Congo, The Democratic Republic of The', 'woocommerce' ),
						    'CK'  => __( 'Cook Islands', 'woocommerce' ),
						    'CR'  => __( 'Costa Rica', 'woocommerce' ),
						    'CI'  => __( "Cote D'ivoire", 'woocommerce' ),
						    'HR'  => __( 'Croatia', 'woocommerce' ),
						    'CU'  => __( 'Cuba', 'woocommerce' ),
						    'CY'  => __( 'Cyprus', 'woocommerce' ),
						    'CZ'  => __( 'Czechia', 'woocommerce' ),
						    'DK'  => __( 'Denmark', 'woocommerce' ),
						    'DJ'  => __( 'Djibouti', 'woocommerce' ),
						    'DM'  => __( 'Dominica', 'woocommerce' ),
						    'DO'  => __( 'Dominican Republic', 'woocommerce' ),
						    'EC'  => __( 'Ecuador', 'woocommerce' ),
						    'EG'  => __( 'Egypt', 'woocommerce' ),
						    'SV'  => __( 'El Salvador', 'woocommerce' ),
						    'GQ'  => __( 'Equatorial Guinea', 'woocommerce' ),
						    'ER'  => __( 'Eritrea', 'woocommerce' ),
						    'EE'  => __( 'Estonia', 'woocommerce' ),
						    'ET'  => __( 'Ethiopia', 'woocommerce' ),
						    'FK'  => __( 'Falkland Islands (Malvinas)', 'woocommerce' ),
						    'FO'  => __( 'Faroe Islands', 'woocommerce' ),
						    'FJ'  => __( 'Fiji', 'woocommerce' ),
						    'FI'  => __( 'Finland', 'woocommerce' ),
						    'FR'  => __( 'France', 'woocommerce' ),
						    'GF'  => __( 'French Guiana', 'woocommerce' ),
						    'PF'  => __( 'French Polynesia', 'woocommerce' ),
						    'TF'  => __( 'French Southern Territories', 'woocommerce' ),
						    'GA'  => __( 'Gabon', 'woocommerce' ),
						    'GM'  => __( 'Gambia', 'woocommerce' ),
						    'GE'  => __( 'Georgia', 'woocommerce' ),
						    'DE'  => __( 'Germany', 'woocommerce' ),
						    'GH'  => __( 'Ghana', 'woocommerce' ),
						    'GI'  => __( 'Gibraltar', 'woocommerce' ),
						    'GR'  => __( 'Greece', 'woocommerce' ),
						    'GL'  => __( 'Greenland', 'woocommerce' ),
						    'GD'  => __( 'Grenada', 'woocommerce' ),
						    'GP'  => __( 'Guadeloupe', 'woocommerce' ),
						    'GU'  => __( 'Guam', 'woocommerce' ),
						    'GT'  => __( 'Guatemala', 'woocommerce' ),
						    'GG'  => __( 'Guernsey', 'woocommerce' ),
						    'GN'  => __( 'Guinea', 'woocommerce' ),
						    'GW'  => __( 'Guinea-bissau', 'woocommerce' ),
						    'GY'  => __( 'Guyana', 'woocommerce' ),
						    'HT'  => __( 'Haiti', 'woocommerce' ),
						    'HM'  => __( 'Heard Island and Mcdonald Islands', 'woocommerce' ),
						    'VA'  => __( 'Holy See (Vatican City State)', 'woocommerce' ),
						    'HN'  => __( 'Honduras', 'woocommerce' ),
						    'HK'  => __( 'Hong Kong', 'woocommerce' ),
						    'HU'  => __( 'Hungary', 'woocommerce' ),
						    'IS'  => __( 'Iceland', 'woocommerce' ),
						    'IN'  => __( 'India', 'woocommerce' ),
						    'ID'  => __( 'Indonesia', 'woocommerce' ),
						    'IR'  => __( 'Iran, Islamic Republic of', 'woocommerce' ),
						    'IQ'  => __( 'Iraq', 'woocommerce' ),
						    'IE'  => __( 'Ireland', 'woocommerce' ),
						    'IM'  => __( 'Isle of Man', 'woocommerce' ),
						    'IL'  => __( 'Israel', 'woocommerce' ),
						    'IT'  => __( 'Italy', 'woocommerce' ),
						    'JM'  => __( 'Jamaica', 'woocommerce' ),
						    'JP'  => __( 'Japan', 'woocommerce' ),
						    'JE'  => __( 'Jersey', 'woocommerce' ),
						    'JO'  => __( 'Jordan', 'woocommerce' ),
						    'KZ'  => __( 'Kazakhstan', 'woocommerce' ),
						    'KE'  => __( 'Kenya', 'woocommerce' ),
						    'KI'  => __( 'Kiribati', 'woocommerce' ),
						    'KP'  => __( "Korea, Democratic People's Republic of", 'woocommerce' ),
						    'KR'  => __( 'Korea, Republic of', 'woocommerce' ),
						    'KW'  => __( 'Kuwait', 'woocommerce' ),
						    'KG'  => __( 'Kyrgyzstan', 'woocommerce' ),
						    'LA'  => __( "Lao People's Democratic Republic", 'woocommerce' ),
						    'LV'  => __( 'Latvia', 'woocommerce' ),
						    'LB'  => __( 'Lebanon', 'woocommerce' ),
						    'LS'  => __( 'Lesotho', 'woocommerce' ),
						    'LR'  => __( 'Liberia', 'woocommerce' ),
						    'LY'  => __( 'Libyan Arab Jamahiriya', 'woocommerce' ),
						    'LI'  => __( 'Liechtenstein', 'woocommerce' ),
						    'LT'  => __( 'Lithuania', 'woocommerce' ),
						    'LU'  => __( 'Luxembourg', 'woocommerce' ),
						    'MO'  => __( 'Macao', 'woocommerce' ),
						    'MK'  => __( 'Macedonia, The Former Yugoslav Republic of', 'woocommerce' ),
						    'MG'  => __( 'Madagascar', 'woocommerce' ),
						    'MW'  => __( 'Malawi', 'woocommerce' ),
						    'MY'  => __( 'Malaysia', 'woocommerce' ),
						    'MV'  => __( 'Maldives', 'woocommerce' ),
						    'ML'  => __( 'Mali', 'woocommerce' ),
						    'MT'  => __( 'Malta', 'woocommerce' ),
						    'MH'  => __( 'Marshall Islands', 'woocommerce' ),
						    'MQ'  => __( 'Martinique', 'woocommerce' ),
						    'MR'  => __( 'Mauritania', 'woocommerce' ),
						    'MU'  => __( 'Mauritius', 'woocommerce' ),
						    'YT'  => __( 'Mayotte', 'woocommerce' ),
						    'MX'  => __( 'Mexico', 'woocommerce' ),
						    'FM'  => __( 'Micronesia, Federated States of', 'woocommerce' ),
						    'MD'  => __( 'Moldova, Republic of', 'woocommerce' ),
						    'MC'  => __( 'Monaco', 'woocommerce' ),
						    'MN'  => __( 'Mongolia', 'woocommerce' ),
						    'ME'  => __( 'Montenegro', 'woocommerce' ),
						    'MS'  => __( 'Montserrat', 'woocommerce' ),
						    'MA'  => __( 'Morocco', 'woocommerce' ),
						    'MZ'  => __( 'Mozambique', 'woocommerce' ),
						    'MM'  => __( 'Myanmar', 'woocommerce' ),
						    'NA'  => __( 'Namibia', 'woocommerce' ),
						    'NR'  => __( 'Nauru', 'woocommerce' ),
						    'NP'  => __( 'Nepal', 'woocommerce' ),
						    'NL'  => __( 'Netherlands', 'woocommerce' ),
						    'AN'  => __( 'Netherlands Antilles', 'woocommerce' ),
						    'NC'  => __( 'New Caledonia', 'woocommerce' ),
						    'NZ'  => __( 'New Zealand', 'woocommerce' ),
						    'NI'  => __( 'Nicaragua', 'woocommerce' ),
						    'NE'  => __( 'Niger', 'woocommerce' ),
						    'NG'  => __( 'Nigeria', 'woocommerce' ),
						    'NU'  => __( 'Niue', 'woocommerce' ),
						    'NF'  => __( 'Norfolk Island', 'woocommerce' ),
						    'MP'  => __( 'Northern Mariana Islands', 'woocommerce' ),
						    'NO'  => __( 'Norway', 'woocommerce' ),
						    'OM'  => __( 'Oman', 'woocommerce' ),
						    'PK'  => __( 'Pakistan', 'woocommerce' ),
						    'PW'  => __( 'Palau', 'woocommerce' ),
						    'PS'  => __( 'Palestinian Territory, Occupied', 'woocommerce' ),
						    'PA'  => __( 'Panama', 'woocommerce' ),
						    'PG'  => __( 'Papua New Guinea', 'woocommerce' ),
						    'PY'  => __( 'Paraguay', 'woocommerce' ),
						    'PE'  => __( 'Peru', 'woocommerce' ),
						    'PH'  => __( 'Philippines', 'woocommerce' ),
						    'PN'  => __( 'Pitcairn', 'woocommerce' ),
						    'PL'  => __( 'Poland', 'woocommerce' ),
						    'PT'  => __( 'Portugal', 'woocommerce' ),
						    'PR'  => __( 'Puerto Rico', 'woocommerce' ),
						    'QA'  => __( 'Qatar', 'woocommerce' ),
						    'RE'  => __( 'Reunion', 'woocommerce' ),
						    'RO'  => __( 'Romania', 'woocommerce' ),
						    'RU'  => __( 'Russian Federation', 'woocommerce' ),
						    'RW'  => __( 'Rwanda', 'woocommerce' ),
						    'SH'  => __( 'Saint Helena', 'woocommerce' ),
						    'KN'  => __( 'Saint Kitts and Nevis', 'woocommerce' ),
						    'LC'  => __( 'Saint Lucia', 'woocommerce' ),
						    'PM'  => __( 'Saint Pierre and Miquelon', 'woocommerce' ),
						    'VC'  => __( 'Saint Vincent and The Grenadines', 'woocommerce' ),
						    'WS'  => __( 'Samoa', 'woocommerce' ),
						    'SM'  => __( 'San Marino', 'woocommerce' ),
						    'ST'  => __( 'Sao Tome and Principe', 'woocommerce' ),
						    'SA'  => __( 'Saudi Arabia', 'woocommerce' ),
						    'SN'  => __( 'Senegal', 'woocommerce' ),
						    'RS'  => __( 'Serbia', 'woocommerce' ),
						    'SC'  => __( 'Seychelles', 'woocommerce' ),
						    'SL'  => __( 'Sierra Leone', 'woocommerce' ),
						    'SG'  => __( 'Singapore', 'woocommerce' ),
						    'SK'  => __( 'Slovakia', 'woocommerce' ),
						    'SI'  => __( 'Slovenia', 'woocommerce' ),
						    'SB'  => __( 'Solomon Islands', 'woocommerce' ),
						    'SO'  => __( 'Somalia', 'woocommerce' ),
						    'ZA'  => __( 'South Africa', 'woocommerce' ),
						    'GS'  => __( 'South Georgia and The South Sandwich Islands', 'woocommerce' ),
						    'ES'  => __( 'Spain', 'woocommerce' ),
						    'LK'  => __( 'Sri Lanka', 'woocommerce' ),
						    'SD'  => __( 'Sudan', 'woocommerce' ),
						    'SR'  => __( 'Suriname', 'woocommerce' ),
						    'SJ'  => __( 'Svalbard and Jan Mayen', 'woocommerce' ),
						    'SZ'  => __( 'Swaziland', 'woocommerce' ),
						    'SE'  => __( 'Sweden', 'woocommerce' ),
						    'CH'  => __( 'Switzerland', 'woocommerce' ),
						    'SY'  => __( 'Syrian Arab Republic', 'woocommerce' ),
						    'TW'  => __( 'Taiwan, Province of China', 'woocommerce' ),
						    'TJ'  => __( 'Tajikistan', 'woocommerce' ),
						    'TZ'  => __( 'Tanzania, United Republic of', 'woocommerce' ),
						    'TH'  => __( 'Thailand', 'woocommerce' ),
						    'TL'  => __( 'Timor-leste', 'woocommerce' ),
						    'TG'  => __( 'Togo', 'woocommerce' ),
						    'TK'  => __( 'Tokelau', 'woocommerce' ),
						    'TO'  => __( 'Tonga', 'woocommerce' ),
						    'TT'  => __( 'Trinidad and Tobago', 'woocommerce' ),
						    'TN'  => __( 'Tunisia', 'woocommerce' ),
						    'TR'  => __( 'Turkey', 'woocommerce' ),
						    'TM'  => __( 'Turkmenistan', 'woocommerce' ),
						    'TC'  => __( 'Turks and Caicos Islands', 'woocommerce' ),
						    'TV'  => __( 'Tuvalu', 'woocommerce' ),
						    'UG'  => __( 'Uganda', 'woocommerce' ),
						    'UA'  => __( 'Ukraine', 'woocommerce' ),
						    'AE'  => __( 'United Arab Emirates', 'woocommerce' ),
						    'GB'  => __( 'United Kingdom', 'woocommerce' ),
						    'US'  => __( 'United States', 'woocommerce' ),
						    'UM'  => __( 'United States Minor Outlying Islands', 'woocommerce' ),
						    'UY'  => __( 'Uruguay', 'woocommerce' ),
						    'UZ'  => __( 'Uzbekistan', 'woocommerce' ),
						    'VU'  => __( 'Vanuatu', 'woocommerce' ),
						    'VE'  => __( 'Venezuela', 'woocommerce' ),
						    'VN'  => __( 'Viet Nam', 'woocommerce' ),
						    'VG'  => __( 'Virgin Islands, British', 'woocommerce' ),
						    'VI'  => __( 'Virgin Islands, U.S.', 'woocommerce' ),
						    'WF'  => __( 'Wallis and Futuna', 'woocommerce' ),
						    'EH'  => __( 'Western Sahara', 'woocommerce' ),
						    'YE'  => __( 'Yemen', 'woocommerce' ),
						    'ZM'  => __( 'Zambia', 'woocommerce' ),
						    'ZW'  => __( 'Zimbabwe', 'woocommerce' ),
						)
					)
				);
				
				
				
				
				
				// Shipping Region Field
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_region',
						'label'       => __( 'Shipping Region', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_region', true ),
						'description' => __( 'The geographic region to which a shipping rate applies (e.g. zip code).', 'woocommerce' ),
					)
				);
				
				
				// Shipping Postcode
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_postcode',
						'label'       => __( 'Shipping Postcode', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_postcode', true ),
						'description' => __( 'The postal code range that the shipping rate applies to, represented by a postal code, a postal code prefix using * wildcard, a range between two postal codes or two postal code prefixes of equal length.', 'woocommerce' ),
					)
				);
				
				
				// Shipping Price Field
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_price',
						'label'       => __( 'Shipping Price', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_price', true ),
						'description' => __( 'The price represented as a number.', 'woocommerce' ),
					)
				);
				
				
				// Shipping Price Currency
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_price_currency',
						'label'       => __( 'Shipping Price Currency', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_price_currency', true ),
						'description' => __( 'The currency of the shipping price.', 'woocommerce' ),
					)
				);
				
				// Shipping Service
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_service',
						'label'       => __( 'Shipping Service', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_service', true ),
						'description' => __( 'A free-form description of the service class or delivery speed.', 'woocommerce' ),
					)
				);
				
				
				// Shipping Weight Unit
				woocommerce_wp_select(
					array(
						'id'		=> '_boltron_google_shipping_weight_unit',
						'label'		=> __( 'Shipping Weight Unit', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'description'	=> __( 'The unit of value. Supported units are lb, oz, g, kg', 'woocommerce' ),
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_weight_unit', true ),
						'options'	=> array (
						    ''			=> __( 'Select', 'woocommerce' ),
						    'lb'		=> __( 'lb', 'woocommerce' ),
						    'oz'		=> __( 'oz', 'woocommerce' ),
						    'g'			=> __( 'gram', 'woocommerce' ),
						    'kg'		=> __( 'kg', 'woocommerce' ),
						)
					)
				);
				
				
				
				
				
				
				// Shipping Weight Value
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_shipping_weight_value',
						'label'       => __( 'Shipping Weight Value', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_shipping_weight_value', true ),
						'description' => __( 'The weight of the product used to calculate the shipping cost of the item.', 'woocommerce' ),
					)
				);
				
				
				// Custom Label 0
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_custom_label_0',
						'label'       => __( 'Custom Label 0', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_custom_label_0', true ),
						'description' => __( 'Use a value that you shall recognize in your Shopping campaign. for ex. seasonal, clearance, holiday, sale, price range', 'woocommerce' ),
					)
				);
				
				// Custom Label 1
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_custom_label_1',
						'label'       => __( 'Custom Label 1', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_custom_label_1', true ),
						'description' => __( 'Use a value that you shall recognize in your Shopping campaign. for ex. seasonal, clearance, holiday, sale, price range', 'woocommerce' ),
					)
				);
				
				// Custom Label 2
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_custom_label_2',
						'label'       => __( 'Custom Label 2', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_custom_label_2', true ),
						'description' => __( 'Use a value that you shall recognize in your Shopping campaign. for ex. seasonal, clearance, holiday, sale, price range', 'woocommerce' ),
					)
				);
				
				
				// Custom Label 3
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_custom_label_3',
						'label'       => __( 'Custom Label 3', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_custom_label_3', true ),
						'description' => __( 'Use a value that you shall recognize in your Shopping campaign. for ex. seasonal, clearance, holiday, sale, price range', 'woocommerce' ),
					)
				);
				
				// Custom Label 4
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_custom_label_4',
						'label'       => __( 'Custom Label 4', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_custom_label_4', true ),
						'description' => __( 'Use a value that you shall recognize in your Shopping campaign. for ex. seasonal, clearance, holiday, sale, price range', 'woocommerce' ),
					)
				);
				
				// Mobile Link
				woocommerce_wp_text_input(
					array(
						'id'          => '_boltron_google_mobile_link',
						'label'       => __( 'Mobile Link', 'woocommerce' ),
						'desc_tip'    => 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_mobile_link', true ),
						'description' => __( "Your product's mobile-optimized page when you have a different URL for mobile and desktop. Start with http or https. Use your verified domain name only.", 'woocommerce' ),
					)
				);
				
				
				// Online Only
				woocommerce_wp_checkbox(
					array(
						'id'		=> '_boltron_google_online_only',
						'label'		=> __( 'Online Only', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_online_only', true ),
						'description'	=> __( 'Whether an item is available for purchase only online.', 'woocommerce' ),
					)
				);
				
				// Exclude product from feed
				woocommerce_wp_checkbox(
					array(
						'id'		=> '_boltron_google_exclude_product',
						'label'		=> __( 'Exclude from feeds', 'woocommerce' ),
						'desc_tip'	=> 'true',
						'value'           =>  get_post_meta( $post->ID, '_boltron_google_exclude_product', true ),
						'description'	=> __( 'Check this box if you want this product to be excluded from product feeds.', 'woocommerce' ),
					)
				);
				

        ?>
    </div>
    <?php
}






add_action( 'woocommerce_process_product_meta', 'save_custom_general_fields' );

function save_custom_general_fields( $post_id ) {

	$woocommerce_brand   		       		= sanitize_text_field( $_POST['_boltron_google_brand'] );
	$woocommerce_gtin                      		= sanitize_text_field( $_POST['_boltron_google_gtin'] );
	$woocommerce_mpn                       		= sanitize_text_field( $_POST['_boltron_google_mpn'] );
	$woocommerce_title                     		= sanitize_text_field( $_POST['_boltron_google_optimized_title'] );
	$woocommerce_unit_pricing_measure      		= sanitize_text_field( $_POST['_boltron_google_unit_pricing_measure'] );
	$woocommerce_unit_pricing_base_measure 		= sanitize_text_field( $_POST['_boltron_google_unit_pricing_base_measure'] );
	$woocommerce_installment_months        		= sanitize_text_field( $_POST['_boltron_google_installment_months'] );
	//$woocommerce_installment_amount        		= sanitize_text_field( $_POST['_boltron_google_installment_amount'] );
	$woocommerce_condition                 		= sanitize_text_field( $_POST['_boltron_google_condition'] );
	$woocommerce_product_category          		= sanitize_text_field( $_POST['_boltron_google_product_category'] );
	$woocommerce_product_adult          		= sanitize_text_field( $_POST['_boltron_google_adult'] );
	$woocommerce_product_multipack          	= sanitize_text_field( $_POST['_boltron_google_product_multipack'] );
	$woocommerce_product_isbundle          		= sanitize_text_field( $_POST['_boltron_google_isbundle'] );
	$woocommerce_product_agegroup          		= sanitize_text_field( $_POST['_boltron_google_agegroup'] );
	$woocommerce_product_color          		= sanitize_text_field( $_POST['_boltron_google_product_color'] );
	$woocommerce_product_gender          		= sanitize_text_field( $_POST['_boltron_google_product_gender'] );
	$woocommerce_product_material          		= sanitize_text_field( $_POST['_boltron_google_product_material'] );
	$woocommerce_product_pattern          		= sanitize_text_field( $_POST['_boltron_google_product_pattern'] );
	
	
	$woocommerce_product_target_country          	= sanitize_text_field( $_POST['_boltron_google_target_country'] );
	$woocommerce_product_content_language          	= sanitize_text_field( $_POST['_boltron_google_content_language'] );
	$woocommerce_product_price_currency          	= sanitize_text_field( $_POST['_boltron_google_product_price_currency'] );
	$woocommerce_product_shipping_country          	= sanitize_text_field( $_POST['_boltron_google_shipping_country'] );
	$woocommerce_product_shipping_region          	= sanitize_text_field( $_POST['_boltron_google_shipping_region'] );
	$woocommerce_product_shipping_postcode          = sanitize_text_field( $_POST['_boltron_google_shipping_postcode'] );
	$woocommerce_product_shipping_price          	= sanitize_text_field( $_POST['_boltron_google_shipping_price'] );
	$woocommerce_product_shipping_price_currency    = sanitize_text_field( $_POST['_boltron_google_shipping_price_currency'] );
	$woocommerce_product_shipping_service          	= sanitize_text_field( $_POST['_boltron_google_shipping_service'] );
	$woocommerce_product_shipping_weight_unit       = sanitize_text_field( $_POST['_boltron_google_shipping_weight_unit'] );
	$woocommerce_product_shipping_weight_value      = sanitize_text_field( $_POST['_boltron_google_shipping_weight_value'] );
	$woocommerce_product_custom_label_0          	= sanitize_text_field( $_POST['_boltron_google_custom_label_0'] );
	$woocommerce_product_custom_label_1          	= sanitize_text_field( $_POST['_boltron_google_custom_label_1'] );
	$woocommerce_product_custom_label_2          	= sanitize_text_field( $_POST['_boltron_google_custom_label_2'] );
	$woocommerce_product_custom_label_3          	= sanitize_text_field( $_POST['_boltron_google_custom_label_3'] );
	$woocommerce_product_custom_label_4          	= sanitize_text_field( $_POST['_boltron_google_custom_label_4'] );
	
	$woocommerce_product_mobile_link          	= sanitize_text_field( $_POST['_boltron_google_mobile_link'] );
	
	$woocommerce_product_online_only          	= sanitize_text_field( $_POST['_boltron_google_online_only'] );

	
	if( isset( $woocommerce_product_target_country ) )
	    update_post_meta( $post_id, '_boltron_google_target_country', $woocommerce_product_target_country );
	    
	if( isset( $woocommerce_product_content_language ) )
	    update_post_meta( $post_id, '_boltron_google_content_language', $woocommerce_product_content_language );
	
	if( isset( $woocommerce_product_price_currency ) )
	    update_post_meta( $post_id, '_boltron_google_product_price_currency', $woocommerce_product_price_currency );
	
	if( isset( $woocommerce_product_shipping_country ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_country', $woocommerce_product_shipping_country );
	    
	if( isset( $woocommerce_product_shipping_region ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_region', $woocommerce_product_shipping_region );
	    
	if( isset( $woocommerce_product_shipping_postcode ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_postcode', $woocommerce_product_shipping_postcode );
	    
	if( isset( $woocommerce_product_shipping_price ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_price', $woocommerce_product_shipping_price );
	    
	if( isset( $woocommerce_product_shipping_price_currency ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_price_currency', $woocommerce_product_shipping_price_currency );
	    
	if( isset( $woocommerce_product_shipping_service ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_service', $woocommerce_product_shipping_service );
	    
	if( isset( $woocommerce_product_shipping_weight_unit ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_weight_unit', $woocommerce_product_shipping_weight_unit );
	    
	if( isset( $woocommerce_product_shipping_weight_value ) )
	    update_post_meta( $post_id, '_boltron_google_shipping_weight_value', $woocommerce_product_shipping_weight_value );
	    
	if( isset( $woocommerce_product_custom_label_0 ) )
	    update_post_meta( $post_id, '_boltron_google_custom_label_0', $woocommerce_product_custom_label_0 );
	    
	if( isset( $woocommerce_product_custom_label_1 ) )
	    update_post_meta( $post_id, '_boltron_google_custom_label_1', $woocommerce_product_custom_label_1 );
	    
	if( isset( $woocommerce_product_custom_label_2 ) )
	    update_post_meta( $post_id, '_boltron_google_custom_label_2', $woocommerce_product_custom_label_2 );
	    
	if( isset( $woocommerce_product_custom_label_3 ) )
	    update_post_meta( $post_id, '_boltron_google_custom_label_3', $woocommerce_product_custom_label_3 );
	    
	if( isset( $woocommerce_product_custom_label_4 ) )
	    update_post_meta( $post_id, '_boltron_google_custom_label_4', $woocommerce_product_custom_label_4 );
	    
	if( isset( $woocommerce_product_mobile_link ) )
	    update_post_meta( $post_id, '_boltron_google_mobile_link', $woocommerce_product_mobile_link );
	
	if( !empty( $woocommerce_product_online_only ) ){
	    update_post_meta( $post_id, '_boltron_google_online_only', 'on' );
	}else{
	    update_post_meta( $post_id, '_boltron_google_online_only', '' );
	}
	
    
	if( !empty( $_POST['_boltron_google_exclude_product'] ) ){
	    $woocommerce_exclude_product = sanitize_text_field( $_POST['_boltron_google_exclude_product'] );

	} else {
	    $woocommerce_exclude_product = "no";
	}

	
	if( isset( $woocommerce_brand ) )
	    update_post_meta( $post_id, '_boltron_google_brand', $woocommerce_brand );

	if( isset( $woocommerce_mpn ) )
	    update_post_meta( $post_id, '_boltron_google_mpn', esc_attr( $woocommerce_mpn ) );

	if( isset( $woocommerce_upc ) )
	    update_post_meta( $post_id, '_boltron_google_upc', esc_attr( $woocommerce_upc ) );

	if( isset( $woocommerce_ean ) )
	    update_post_meta( $post_id, '_boltron_google_ean', esc_attr( $woocommerce_ean ) );

	if( isset( $woocommerce_gtin ) )
	    update_post_meta( $post_id, '_boltron_google_gtin', esc_attr( $woocommerce_gtin ) );

	if( isset( $woocommerce_title ) )
	    update_post_meta( $post_id, '_boltron_google_optimized_title', $woocommerce_title );

	if( isset( $woocommerce_unit_pricing_measure ) )
	    update_post_meta( $post_id, '_boltron_google_unit_pricing_measure', $woocommerce_unit_pricing_measure );

	if( isset( $woocommerce_unit_pricing_base_measure ) )
	    update_post_meta( $post_id, '_boltron_google_unit_pricing_base_measure', $woocommerce_unit_pricing_base_measure );

	if( isset( $woocommerce_condition ) )
	    update_post_meta( $post_id, '_boltron_google_condition', $woocommerce_condition );

	if( isset( $woocommerce_installment_months ) )
	    update_post_meta( $post_id, '_boltron_google_installment_months', esc_attr( $woocommerce_installment_months ) );

	if( isset( $woocommerce_exclude_product ) )
	    update_post_meta( $post_id, '_boltron_google_exclude_product', esc_attr( $woocommerce_exclude_product));	

	if( isset( $woocommerce_product_category ) )
	    update_post_meta( $post_id, '_boltron_google_product_category', $woocommerce_product_category );

	if( isset( $woocommerce_product_adult ) )
	    update_post_meta( $post_id, '_boltron_google_adult', $woocommerce_product_adult );
	    
	if( isset( $woocommerce_product_multipack ) )
	    update_post_meta( $post_id, '_boltron_google_product_multipack', $woocommerce_product_multipack );
	    
	if( isset( $woocommerce_product_isbundle ) )
	    update_post_meta( $post_id, '_boltron_google_isbundle', $woocommerce_product_isbundle );
	    
	if( isset( $woocommerce_product_agegroup ) )
	    update_post_meta( $post_id, '_boltron_google_agegroup', $woocommerce_product_agegroup );
	    
	if( isset( $woocommerce_product_color ) )
	    update_post_meta( $post_id, '_boltron_google_product_color', $woocommerce_product_color );
	    
	if( isset( $woocommerce_product_gender ) )
	    update_post_meta( $post_id, '_boltron_google_product_gender', $woocommerce_product_gender );
	    
	if( isset( $woocommerce_product_material ) )
	    update_post_meta( $post_id, '_boltron_google_product_material', $woocommerce_product_material );
	    
	if( isset( $woocommerce_product_pattern ) )
	    update_post_meta( $post_id, '_boltron_google_product_pattern', $woocommerce_product_pattern );

}














?>