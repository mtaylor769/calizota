<?php
////////////////////////////////////////////
// ADMIN INITIALIZE/LOCALIZE AJAX Functions
////////////////////////////////////////////
if( is_admin( ) )
	include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/core/class-tgm-plugin-activation.php' );

add_action( 'admin_enqueue_scripts', 'ec_load_admin_scripts' );
add_action( 'admin_menu', 'ec_create_menu' );
add_action( 'admin_init', 'ec_custom_downloads', 1 );
add_action( 'admin_init', 'ec_intuit_connect', 1 );
add_action( 'admin_notices', 'ec_install_admin_notice' );
add_action( 'save_post', 'ec_post_save_match_store_meta', 13 );
add_action( 'init', 'ec_add_editor_buttons' );
add_action( 'admin_footer', 'ec_print_editor' );
add_action( 'wp_ajax_ec_editor_update_sub_menu', 'ec_editor_update_sub_menu' );
add_action( 'wp_ajax_ec_editor_update_subsub_menu', 'ec_editor_update_subsub_menu' );

function ec_install_admin_notice() {
	if( current_user_can( 'manage_options' ) ){
		
		if( isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "basic-setup" ){
			update_option( 'ec_option_show_install_message', '1' );
		}
		
		if( !get_option( 'ec_option_show_install_message' ) && ( !get_option( 'ec_option_accountpage' ) || !get_option( 'ec_option_cartpage' ) || !get_option( 'ec_option_storepage' ) ) ){
		?>
		<div class="updated">
			<p>You Have not Setup Your WP EasyCart! Please <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">Click Here to Setup</a>.</p>
		</div>
		<?php
		}
		
		// Check if the admin manage notice should be removed
		if( isset( $_GET['page'] ) && $_GET['page'] == "ec_adminv2" && isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "admin-console" && isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "admin" && isset( $_GET['ec_notice'] ) && $_GET['ec_notice'] == "dismiss" ){
			update_option( 'ec_option_hide_admin_notice', '1' );
		}
		
		if( is_plugin_active( "wp-easycart-admin/wpeasycart-admin.php" ) && version_compare( EC_AD_CURRENT_VERSION, "3.1.4" ) < 0 ){
			?>
			<div class="error">
				<p>A new version of the WP EasyCart Admin is now available, please update for best results!</p>
			</div>
			<?php
		}
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){ ?>
		
		<div class="error">
			<p>Your server appears to be missing the wp-easycart-data folder, which could cause data loss on upgrade. Please <a href="http://v3docs.wpeasycart.com/3.0.0/index/upgrading.php" target="_blank">click here</a> to learn how to correct this issue.</p>
		</div>
			
		<?php
		}
		
		if( get_option( 'ec_option_display_as_catalog' ) ){ ?>
		
		<div class="updated">
			<p>You currently have your store in catalog only mode. This means that your customers can only view the products, not add to cart or checkout. If you think this was turned on by mistake, you can turn it off by <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=advanced-setup">clicking here</a> and set Display Store as Catalog to Off.</p>
		</div>
		
		<?php }
		
		if( get_option( 'ec_option_accountpage' ) != '' && get_post_status( get_option( 'ec_option_accountpage' ) ) != 'publish' ){
		?>
		<div class="error">
			<p>Your store's account page is not available, <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">click here to setup</a>.</p>
		</div>
		<?php
		}
		
		if( get_option( 'ec_option_cartpage' ) != '' && get_post_status( get_option( 'ec_option_cartpage' ) ) != 'publish' ){
		?>
		<div class="error">
			<p>Your store's cart page is not available, <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">click here to setup</a>.</p>
		</div>
		<?php
		}
		
		if( get_option( 'ec_option_storepage' ) != '' && get_post_status( get_option( 'ec_option_storepage' ) ) != 'publish' ){
		?>
		<div class="error">
			<p>Your store's main page is not available, <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">click here to setup</a>.</p>
		</div>
		<?php
		}
		
	}
}

function ec_load_admin_scripts( ){
	
	if( current_user_can( 'manage_options' ) ){
		
		//register admin css
		wp_register_style( 'wpeasycart_admin_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/wpadmin_stylesheet.css' ), array(), EC_CURRENT_VERSION );
		wp_enqueue_style( 'wpeasycart_admin_css' );
		
		//register admin css
		wp_register_style( 'wpeasycart_adminv2_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/css/wpeasycart_adminv2.css' ), array(), EC_CURRENT_VERSION );
		wp_enqueue_style( 'wpeasycart_adminv2_css' );
		
		//register admin css
		wp_register_style( 'wpeasycart_editor_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/css/editor.css' ), array(), EC_CURRENT_VERSION );
		wp_enqueue_style( 'wpeasycart_editor_css' );
		
		include( 'style.php' );
		
		wp_enqueue_media();
		
		wp_register_script( 'wpeasycart_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/admin_ajax_functions.js' ), array( 'jquery' ) );
		wp_enqueue_script( 'wpeasycart_admin_js' );
		
		wp_register_script( 'wpeasycart_simple_admin_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/admin/assets/js/admin.js' ), array( 'jquery' ) );
		wp_enqueue_script( 'wpeasycart_simple_admin_js' );
		
		$https_link = "";
		if( class_exists( "WordPressHTTPS" ) ){
			$https_class = new WordPressHTTPS( );
			$https_link = $https_class->getHttpsUrl() . '/wp-admin/admin-ajax.php';
		}else{
			$https_link = str_replace( "http://", "https://", admin_url( 'admin-ajax.php' ) );
		}
		
		if( isset( $_SERVER['HTTPS'] ) )
			wp_localize_script( 'wpeasycart_admin_js', 'wpeasycart_ajax_object', array( 'ajax_url' => $https_link ) );
		else
			wp_localize_script( 'wpeasycart_admin_js', 'wpeasycart_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			
	}
}

function ec_create_menu() {
	
	//V2 Admin
	$wp_version = get_bloginfo( 'version' );
	if( $wp_version < 3.8 ){
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'images/wp_16x16_icon.png', __FILE__ ) );
	}else{
		add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', 'dashicons-cart' );
		//add_menu_page( 'EasyCart Admin', 'EasyCart Admin', 'manage_options', 'ec_adminv2', 'ec_adminv2_page_callback', plugins_url( 'assets/images/sidebar_icon.png', __FILE__ ) );
	}
}

function ec_custom_downloads( ){
	
	// Add Pages
	if( current_user_can( 'manage_options' ) && isset( $_GET['ec_action'] )  && $_GET['ec_action'] == "add_pages" ){
		require_once( "assets/inc/adminv2_functions.php" );
		ec_easycart_add_pages( );
		wp_redirect( "admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup" );
	}
	
	// AMFPHP Fix
	if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_amfphp'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "admin-console" && $_GET['ec_panel'] == "admin" && $_GET['ec_amfphp'] == "true" ){
		
		if( get_option( 'ec_option_amfphp_fix' ) )
			update_option( 'ec_option_amfphp_fix', 0 );
		
		else
			update_option( 'ec_option_amfphp_fix', 1 );
			
		header( "location: admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin" );
		
	}
	
	if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && ( $_GET['ec_action'] == "download_designs" || $_GET['ec_action'] == "download_products" ) ){
		
		if( $_GET['ec_action'] == "download_designs" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/design.zip";
			$zip_shortname = "design.zip";
		}else if( $_GET['ec_action'] == "download_products" ){
			$zipname = WP_PLUGIN_DIR . "/wp-easycart-data/products.zip";
			$zip_shortname = "products.zip";
		}
		$zip = new ZipArchive;
		$zip->open( $zipname, ZipArchive::CREATE );
		
		if( $_GET['ec_action'] == "download_designs" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/design/";
		}else if( $_GET['ec_action'] == "download_products" ){
			$source = WP_PLUGIN_DIR . "/wp-easycart-data/products/";
		}
		$source = str_replace( '\\', '/', realpath( $source ) );
		
		$files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $source ), RecursiveIteratorIterator::SELF_FIRST );

        foreach( $files as $file ){
            $file = str_replace( '\\', '/', realpath( $file ) );

            if( is_dir( $file ) === true ){
                $zip->addEmptyDir( str_replace( $source . '/', '', $file . '/' ) );
            
			}else if( is_file( $file ) === true ){
                $zip->addFromString( str_replace( $source . '/', '', $file ), file_get_contents( $file ) );
            }
        }
		
		$zip->close( );
		
		if( file_exists( $zipname ) ){
			header( "Cache-Control: public, must-revalidate" );
			header( "Pragma: no-cache" );
			header( 'Content-Type: application/octet-stream' );
			header( "Content-Length: " . ( string )( filesize( $zipname ) ) );
			header( 'Content-Disposition: attachment; filename="' . $zip_shortname . '"' );
			header( "Content-Transfer-Encoding: binary\n" );
			
			$fh = fopen( $zipname, "rb" );
				
			while( !feof( $fh ) ){
				$buffer = fread( $fh, 8192 );
				echo $buffer;
				ob_flush( );
				flush( ); 
			}
			
			fclose( $fh );
			
			unlink( $zipname );
			exit;
		
		}else{
			exit( "Could not find the zip to be downloaded" );
		}
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "backup-store" && $_GET['ec_action'] == "download_db" ){
		
		error_reporting(0);
		
		$file_contents = ec_databasedump( );
		
		$sql_shortname = "Storefront_Backup_" . date( 'Y_m_d' ) . ".sql";
		$sqlname = WP_PLUGIN_DIR . "/wp-easycart-data/" . $sql_shortname;
		
		file_put_contents( $sqlname, $file_contents );
		
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header( "Content-type: text/plain");
		header( 'Content-Disposition: attachment; filename=' . $sql_shortname );
		header( 'Content-Length: ' . ( string )( filesize( $sqlname ) ) );
		header( "Content-Transfer-Encoding: binary" );
		header( 'Expires: 0');
		header( 'Cache-Control: private');
		header( 'Pragma: private');
		
		readfile( $sqlname );
		unlink( $sqlname );
		
		// Stop the page execution so that it doesn't print HTML to the file accidently
		die();
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "inventory-status" && $_GET['ec_action'] == "export_inventory_list" ){
		// output headers so that the file is downloaded rather than displayed
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		fputcsv( $output, array( 'Title (Options)', 'Quantity' ) );
		
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.title, ec_product.model_number, ec_product.stock_quantity, ec_product.use_optionitem_quantity_tracking, ec_product.show_stock_quantity, ec_product.option_id_1, ec_product.option_id_2, ec_product.option_id_3, ec_product.option_id_4, ec_product.option_id_5 FROM ec_product WHERE ec_product.activate_in_store = 1 ORDER BY ec_product.title ASC" );
		
		$inventory_cvs = "";
		
		foreach( $products as $product ){
			
			if( $product->use_optionitem_quantity_tracking ){ 
				/* START THE CREATION OF A COMPLEX QUERY. THIS COMBINES MULTIPLE OPTIONS TO ALLOW A USER TO ENTER A QUANTITY FOR EACH */
				$sql = "";
				if( $product->option_id_1 != 0 ){
					$sql .= $wpdb->prepare( "SELECT * FROM ( SELECT optionitem_name AS optname1, optionitem_id as optid1 FROM ec_optionitem WHERE option_id = %d ) as optionitems1 ", $product->option_id_1 );
				}
				
				if($product->option_id_2 != 0){
					$sql .= $wpdb->prepare(" JOIN ( SELECT optionitem_name AS optname2, optionitem_id as optid2 FROM ec_optionitem WHERE option_id = %d ) as optionitems2 ON (1=1) ", $product->option_id_2 );
				}
				
				if($product->option_id_3 != 0){
					$sql .= $wpdb->prepare(" JOIN ( SELECT optionitem_name AS optname3, optionitem_id as optid3 FROM ec_optionitem WHERE option_id = %d ) as optionitems3 ON (1=1) ", $product->option_id_3 );
				}
				
				if($product->option_id_4 != 0){
					$sql .= $wpdb->prepare(" JOIN ( SELECT optionitem_name AS optname4, optionitem_id as optid4 FROM ec_optionitem WHERE option_id = %d ) as optionitems4 ON (1=1) ", $product->option_id_4 );
				}
				
				if($product->option_id_5 != 0){
					$sql .= $wpdb->prepare(" JOIN ( SELECT optionitem_name AS optname5, optionitem_id as optid5 FROM ec_optionitem WHERE option_id = %s ) as optionitems5 ON (1=1) ", $product->option_id_5 );
				}
				
				$sql .= " LEFT JOIN ec_optionitemquantity ON ( 1=1 ";
				
				if($product->option_id_1 != 0){
					$sql .= " AND ec_optionitemquantity.optionitem_id_1 = optid1";
				}
				
				if($product->option_id_2 != 0){
					$sql .= " AND ec_optionitemquantity.optionitem_id_2 = optid2";
				}
				
				if($product->option_id_3 != 0){
					$sql .= " AND ec_optionitemquantity.optionitem_id_3 = optid3";
				}
				
				if($product->option_id_4 != 0){
					$sql .= " AND ec_optionitemquantity.optionitem_id_4 = optid4";
				}
				
				if($product->option_id_5 != 0){
					$sql .= " AND ec_optionitemquantity.optionitem_id_5 = optid5";
				}
				
				$sql .= $wpdb->prepare( " AND ec_optionitemquantity.product_id = %d )", $product->product_id );
				
				$sql .= " ORDER BY optname1";
		
				//Finally, get the query results
				$optionitems = $wpdb->get_results( $sql );
				foreach( $optionitems as $optionitem ){ 
				
					$opt_title = $product->title . " (";
					if( $optionitem->optionitem_id_1 != 0 ){
						$opt_title .= $optionitem->optname1;
					}
					if( $optionitem->optionitem_id_2 != 0 ){
						$opt_title .= ", " . $optionitem->optname2;
					}
					if( $optionitem->optionitem_id_3 != 0 ){
						$opt_title .= ", " . $optionitem->optname3;
					}
					if( $optionitem->optionitem_id_4 != 0 ){
						$opt_title .= ", " . $optionitem->optname4;
					}
					if( $optionitem->optionitem_id_5 != 0 ){
						$opt_title .= ", " . $optionitem->optname5;
					}
					
					$opt_title .= ")";
					
					fputcsv( $output, array( $opt_title, $optionitem->quantity ) ); 
				
				} // Close optionitem quantity tracking loop
				
			}else if( $product->show_stock_quantity ){
					
				fputcsv( $output, array( $product->title, $product->stock_quantity ) );
				
            } // Close product type if
        
		} // Close foreach
		
		die( );
		
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "google-merchant" && $_GET['ec_action'] == "download-feed" ){
		//Download XML Feed
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.model_number, ec_product.show_stock_quantity, ec_product.stock_quantity, ec_product.title, ec_product.description, ec_product.price, ec_product.list_price, ec_product.weight, ec_product.post_id, ec_product.image1, ec_product.option_id_1, ec_product.option_id_2, ec_product.option_id_3, ec_product.option_id_4, ec_product.option_id_5, ec_manufacturer.name as manufacturer_name FROM ec_product LEFT JOIN ec_manufacturer ON ec_manufacturer.manufacturer_id = ec_product.manufacturer_id WHERE ec_product.activate_in_store = 1 ORDER BY ec_product.title ASC" );
		
			
		$file_contents =  "<?xml version=\"1.0\"?>\r\n";
		$file_contents .=  "<rss version=\"2.0\" xmlns:g=\"http://base.google.com/ns/1.0\">\r\n";
			$file_contents .=  "<channel>\r\n";
				$file_contents .=  "<title>WP EasyCart Data Feed</title>\r\n";
				$file_contents .=  "<link>" . site_url( ) . "</link>\r\n";
				$file_contents .=  "<description>My Site Products</description>\r\n";
				foreach( $products as $product ){
					
					// Get Product Link
					if( !get_option( 'ec_option_use_old_linking_style' ) && $product->post_id != "0" ){
						$link = get_permalink( $product->post_id );
					}else{
						$storepageid = get_option( 'ec_option_storepage' );
						if( function_exists( 'icl_object_id' ) ){
							$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
						}
						
						$store_page = get_permalink( $storepageid );
						
						if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
							$https_class = new WordPressHTTPS( );
							$store_page = $https_class->makeUrlHttps( $store_page );
						}
						
						if( substr_count( $store_page, '?' ) )						
							$permalink_divider = "&";
						else																
							$permalink_divider = "?";
						
						$link = $store_page . $permalink_divider . "model_number=" . $product->model_number;
					}
					
					// Get Image Link
					$test_src = ABSPATH . "wp-content/plugins/wp-easycart-data/products/pics1/" . $product->image1;
					$test_src2 = ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ec_image_not_found.jpg";
					
					if( file_exists( $test_src ) && !is_dir( $test_src ) ){
						$image_link = plugins_url( "/wp-easycart-data/products/pics1/" . $product->image1 );
					}else if( file_exists( $test_src2 ) ){
						$image_link = plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ec_image_not_found.jpg" );
					}else{
						$image_link = plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/ec_image_not_found.jpg" );
					}
					
					// Get Attributes
					$attributes_result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ec_product_google_attributes WHERE ec_product_google_attributes.product_id = %d", $product->product_id ) );
					
					$attributes = json_decode( $attributes_result->attribute_value, true );
					
					// Check the product has required attributes
					$is_valid = true;
					if( $attributes['gtin'] == "" && $attributes['mpn'] == "" ){
						$is_valid = false;
					}
					
					if( $attributes['condition'] == "" ){
						$is_valid = false;
					}
					
					if( $is_valid ){
					
				$file_contents .=  "<item>\r\n";
					$file_contents .=  "<g:id>" . htmlspecialchars( $product->model_number ) . "</g:id>\r\n";
					$file_contents .=  "<g:title>" . htmlspecialchars( $product->title ) . "</g:title>\r\n";
					$file_contents .=  "<g:description>" . htmlspecialchars( $product->description ) . "</g:description>\r\n";
					$file_contents .=  "<g:link>" . htmlspecialchars( $link ) . "</g:link>\r\n";
					$file_contents .=  "<g:image_link>" . htmlspecialchars( $image_link ) . "</g:image_link>\r\n";
					if( !$product->show_stock_quantity || $product->stock_quantity > 0 ){
						$file_contents .=  "<g:availability>in stock</g:availability>\r\n";
					}else{
						$file_contents .=  "<g:availability>out of stock</g:availability>\r\n";
					}
					if( $product->list_price > 0 ){
						$file_contents .=  "<g:price currency=\"" . get_option( 'ec_option_base_currency' ). "\">" . number_format( $product->list_price, 2, '.', '' ) . "</g:price>\r\n";
						$file_contents .=  "<g:sale_price currency=\"" . get_option( 'ec_option_base_currency' ). "\">" . number_format( $product->price, 2, '.', '' ) . "</g:sale_price>\r\n";
					}else{
						$file_contents .=  "<g:price currency=\"" . get_option( 'ec_option_base_currency' ). "\">" . number_format( $product->price, 2, '.', '' ) . "</g:price>\r\n";
					}
					$file_contents .=  "<g:brand>" . htmlspecialchars( $product->manufacturer_name ) . "</g:brand>\r\n";
					
					foreach( $attributes as $key => $value ){
						if( $key == "weight_type" ){
							$file_contents .=  "<g:shipping_weight>".$product->weight . " " . $value ."</g:shipping_weight>\r\n";
						}else if( $value != "" && $value != "None Selected" ){
							$file_contents .=  "<g:".$key.">".htmlspecialchars( $value )."</g:".$key.">\r\n";
						}
					}
					
				$file_contents .=  "</item>\r\n";
					}// Close check is valid
				
				}// Close foreach loop
			
			$file_contents .=  "</channel>\r\n";
		$file_contents .=  "</rss>\r\n";
		
		$xml_shortname = "Google_Merchant_Feed_" . date( 'Y_m_d' ) . ".xml";
		$xmlname = WP_PLUGIN_DIR . "/wp-easycart-data/" . $xml_shortname;
		
		file_put_contents( $xmlname, $file_contents );
		
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header( "Content-type: text/xml");
		header( 'Content-Disposition: attachment; filename=' . $xml_shortname );
		header( 'Content-Length: ' . ( string )( filesize( $xmlname ) ) );
		header( "Content-Transfer-Encoding: binary" );
		header( 'Expires: 0');
		header( 'Cache-Control: private');
		header( 'Pragma: private');
		
		readfile( $xmlname );
		unlink( $xmlname );
		
		// Stop the page execution so that it doesn't print HTML to the file accidently
		die();
		
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "woo-importer" && $_GET['ec_action'] == "import-woo-products" ){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$new_optionsets = array( ); // Keep list of attribute ids to option_ids
		$new_categories = array( ); // Keep list of cat ids to category_ids
		$new_products = array( ); // Keep list of product ids to post ids
		$add_crosssale = array( ); // Keep list of product_id + cross-sale post_ids, cross-reference new_product with post_id to update products
		
		$optionsets = $wpdb->get_results( "SELECT * FROM " . $prefix . "woocommerce_attribute_taxonomies" );
		
		foreach( $optionsets as $optionset ){
			$attribute_id = $optionset->attribute_id;
			$option_name = $optionset->attribute_name;
			$option_label = $optionset->attribute_label;
			$option_type = $optionset->attribute_type;
			
			if( $option_type == "select" ){
				$option_type = "combo";
			}
			
			$optionitems = $wpdb->get_results( $wpdb->prepare( "SELECT " . $prefix . "terms.* FROM " . $prefix . "term_taxonomy LEFT JOIN " . $prefix . "terms ON (" . $prefix . "terms.term_id = " . $prefix . "term_taxonomy.term_id ) WHERE " . $prefix . "term_taxonomy.taxonomy = %s", "pa_" . $option_name ) );
			
			// Insert option
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option( option_name, option_label, option_type, option_required ) VALUES( %s, %s, %s, 0 )", $option_name, $option_label, $option_type ) );
			$option_id = $wpdb->insert_id;
			$new_optionsets["pa_" . $option_name] = $option_id;
			
			// Insert option items
			$order_num = 0;
			foreach( $optionitems as $optionitem ){
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_optionitem( option_id, optionitem_name, optionitem_order ) VALUES( %d, %s, %d )", $option_id, $optionitem->name, $order_num ) );
				$order_num++;
			}
		}
		
		$categories = $wpdb->get_results( "SELECT " . $prefix . "terms.* FROM " . $prefix . "term_taxonomy LEFT JOIN " . $prefix . "terms ON (" . $prefix . "terms.term_id = " . $prefix . "term_taxonomy.term_id ) WHERE " . $prefix . "term_taxonomy.taxonomy = 'product_cat'" );
		foreach( $categories as $category ){
			
			// Insert Category
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_category( category_name ) VALUES( %s )", $category->name ) );
			$category_id = $wpdb->insert_id;
			$new_categories["id-".$category->term_id] = $category_id;
			
			// Insert Category WordPress Post
			$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $category->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			
			// Update Category Post ID
			$wpdb->query( $wpdb->prepare( "UPDATE ec_category SET ec_category.post_id = %s WHERE ec_category.category_id = %d", $post_id, $category_id ) );
			
		}
		
		//----------manufacturer-------
		$wpdb->query( "INSERT INTO ec_manufacturer( `name` ) VALUES( 'Woo Products' )" );
		$manufacturer_id = $wpdb->insert_id;
		
		// Insert a WordPress Custom post type post.
		$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturer_id . "\"]",
						'post_status'	=> "publish",
						'post_title'	=> "WOO Products",
						'post_type'		=> "ec_store"
		);
		$post_id = wp_insert_post( $post );
		
		// Update manufacturer
		$wpdb->query( $wpdb->prepare( "UPDATE ec_manufacturer SET ec_manufacturer.post_id = %s WHERE ec_manufacturer.manufacturer_id = %d", $post_id, $manufacturer_id ) );
		
		$product_args = array( 'posts_per_page' => 100000, 'offset' => 0, 'post_type' => 'product' );
		$woo_products = get_posts( $product_args );
		
		foreach( $woo_products as $product ){
			
			$post_meta = get_post_meta( $product->ID );
			
			//----------model number-------
			$sku = $post_meta['_sku'][0];
			if( $sku == "" )
				$model_number = rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 ) . rand( 0, 9 );
			else
				$model_number = $sku;
			
			//---------basic info------------
			$title = $product->post_title;
			$description = $product->post_content;
			$short_description = $product->post_excerpt;
			
			//---------activate in store------
			$visibility = $post_meta['_visibility'][0]; // visible if show in store
			if( $product->post_status == "publish" ){
				$is_active = true;
			}else{
				$is_active = false;
			}
			
			if( $is_active && $visibility == "visible" )
				$activate_in_store = true;
			else
				$activate_in_store = false;
			
			//-----------price options------
			$regular_price = $post_meta['_regular_price'][0];
			$sale_price = $post_meta['_sale_price'][0]; // use if not empty
			$price = $post_meta['_price'][0]; // Not sure what is different between price and regular price?
			if( $sale_price != "" ){ // If a sale is setup
				$price = $sale_price;
				$list_price = $regular_price;
			}
			
			//------------tax options-------
			$tax_status = $post_meta['_tax_status'][0]; // taxable if tax enabled
			if( $tax_status == "taxable" )
				$is_taxable = true;
			else
				$is_taxable = false;
			
			//------------stock options------
			$manage_stock = $post_meta['_manage_stock'][0]; // yes if we should we keep track of stock
			$stock_status = $post_meta['_stock_status'][0]; // instock if available
			$stock = $post_meta['_stock'][0]; // Stock value
			if( $manage_stock == "yes" && $stock != "" ){
				$stock_quantity = $stock;
			}else if( $stock_status == "instock" ){
				$stock_quantity = 9999;
			}else{
				$stock_quantity = 0;
			}
			if( $manage_stock == "yes" )
				$show_stock_quantity = true;
			else
				$show_stock_quantity = false;
			
			//------------diminsions options-----
			$virtual = $post_meta['_virtual'][0]; // set values to 0 if service item
			$weight = $post_meta['_weight'][0]; // if no value, set to 0?
			if( $weight == "" || $virtual == "yes" )
				$weight = 0;
			$length = $post_meta['_length'][0];
			if( $length == "" || $virtual == "yes"  )
				$length = 0;
			$width = $post_meta['_width'][0];
			if( $width == "" || $virtual == "yes"  )
				$width = 0;
			$height = $post_meta['_height'][0];
			if( $height == "" || $virtual == "yes"  )
				$height = 0;
			
			//-----------custom reviews option-----
			if( $product->comment_status == "open" )
				$use_customer_reviews = true;
			else
				$use_customer_reviews = false;
				
			$reviews = get_comments( array( "post_id" => $product->ID ) );
			
			//----------download-----------
			$downloadable = $post_meta['_downloadable'][0]; // no if not downloadable
			if( $downloadable == "yes" ){
				$files = maybe_unserialize( $post_meta['_downloadable_files'][0] );
				foreach( $files as $file ){
					break;
				}
				
				$path = pathinfo( $file['file'] );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $file['file'], WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" . $file_name );
				
				$is_download = true;
				$download_file_name = $file_name;
				$maximum_downloads_allowed = $post_meta['_download_limit'][0];
				$download_timelimit_seconds = $post_meta['_download_expiry'][0] * 24 * 60 * 60;
			}else{
				$is_download = false;
				$download_file_name = "";
				$maximum_downloads_allowed = 0;
				$download_timelimit_seconds = 0;
			}
			
			//----------images-------------
			$image1 = wp_get_attachment_url( get_post_thumbnail_id( $product->ID ) );
			$image2 = "";
			$image3 = "";
			$image4 = "";
			$image5 = "";
			
			$gallery_images_string = $post_meta['_product_image_gallery'][0];
			$gallery_images_array = explode( ",", $gallery_images_string );
			if( $gallery_images_array[0] != "" ){
				$product_images = array( );
				foreach( $gallery_images_array as $gallery_item ){
					$product_images[] = wp_get_attachment_url( $gallery_item );
				}
				
				for( $i=0; $i<count( $product_images ) && $i<5; $i++ ){
					if( $i == 0 )
						$image1 = $product_images[$i];
					else if( $i == 1 )
						$image2 = $product_images[$i];
					else if( $i == 2 )
						$image3 = $product_images[$i];
					else if( $i == 3 )
						$image4 = $product_images[$i];
					else if( $i == 4 )
						$image5 = $product_images[$i];
				}
			}
			
			if( $image1 != "" ){
				$path = pathinfo( $image1 );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $image1, WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" . $file_name );
				$image1 = $file_name;
			}
			
			if( $image2 != "" ){
				$path = pathinfo( $image2 );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $image2, WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/" . $file_name );
				$image2 = $file_name;
			}
			
			if( $image3 != "" ){
				$path = pathinfo( $image3 );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $image3, WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/" . $file_name );
				$image3 = $file_name;
			}
			
			if( $image4 != "" ){
				$path = pathinfo( $image4 );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $image4, WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/" . $file_name );
				$image4 = $file_name;
			}
			
			if( $image5 != "" ){
				$path = pathinfo( $image5 );
				$file_name = $path['filename'] . "_" . rand( 100000, 999999 ) . "." . $path['extension'];
				copy( $image5, WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/" . $file_name );
				$image5 = $file_name;
			}
			
			//----------options setup------
			$product_attributes = maybe_unserialize( $post_meta['_product_attributes'][0] ); // need to link to option sets
			$product_options = array( );
			foreach( $product_attributes as $key => $value ){
				$product_options[] = $new_optionsets[$key]; // Add option_id to product option array
			}
			
			//-------------categories-------
			$product_cats = $wpdb->get_results( $wpdb->prepare( "SELECT " . $prefix . "term_relationships.term_taxonomy_id FROM " . $prefix . "term_relationships, " . $prefix . "terms, " . $prefix . "term_taxonomy WHERE " . $prefix . "term_taxonomy.taxonomy = 'product_cat' AND " . $prefix . "term_taxonomy.term_id = " . $prefix . "terms.term_id AND " . $prefix . "terms.term_id = " . $prefix . "term_relationships.term_taxonomy_id AND " . $prefix . "term_relationships.object_id = %d", $product->ID ) );
			
			$product_categories = array( );
			foreach( $product_cats as $value ){
				$product_categories[] = $new_categories["id-".$value->term_taxonomy_id]; // Add category_id to product option array
			}
			
			//----------featured products--
			$crosssell_ids = maybe_unserialize( $post_meta['_crosssell_ids'][0] );
			
			//----------startup show-----
			$show_on_startup = true;
			
			//----------shippable status---
			$is_shippable = true;
			if( $is_download || $weight <= 0 )
				$is_shippable = false;
			
			//------------Need to insert product----------
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product( 	model_number, activate_in_store, title, description, 
																	price, list_price, stock_quantity, weight, width, 
																	height, length, use_customer_reviews, manufacturer_id, download_file_name, 
																	image1, image2, image3, image4, image5, 
																	use_advanced_optionset, featured_product_id_1, featured_product_id_2, featured_product_id_3, featured_product_id_4, 
																	is_download, is_taxable, is_shippable, show_on_startup, show_stock_quantity, 
																	maximum_downloads_allowed, download_timelimit_seconds ) VALUES( 
																	%s, %d, %s, %s, 
																	%s, %s, %d, %s, %s, 
																	%s, %s, %d, %d, %s, 
																	%s, %s, %s, %s, %s, 
																	1, %d, %d, %d, %d, 
																	%d, %d, %d, %d, %d, 
																	%s, %s )",
																	$model_number, $activate_in_store, $title, $description,
																	$price, $list_price, $stock_quantity, $weight, $width,
																	$height, $length, $use_customer_reviews, $manufacturer_id, $download_file_name,
																	$image1, $image2, $image3, $image4, $image5,
																	$featured_id_1, $featured_id_2, $featured_id_3, $featured_id_4,
																	$is_download, $is_taxable, $is_shippable, $show_on_startup, $show_stock_quantity,
																	$maximum_downloads_allowed, $download_timelimit_seconds ) );
			$product_id = $wpdb->insert_id;
			$new_products["id-".$product->ID] = $product_id;
			if( $crosssell_ids )
				$add_crosssale["id-".$product_id] = $crosssell_ids;
			
			
			// Need to Insert WordPress Post
			if( $activate_in_store )
				$status = "publish";
			else
				$status = "private";
			
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $model_number . "\"]",
							'post_status'	=> $status,
							'post_title'	=> $title,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			
			// Need to Update Product for post id
			$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.post_id = %s WHERE ec_product.product_id = %d", $post_id, $product_id ) );
			
			// Apply optionsets to product, ec_option_to_product
			foreach( $product_options as $option_id ){
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option_to_product( option_id, product_id ) VALUES( %d, %d )", $option_id, $product_id ) );
			}
			
			// Apply products to categories via ec_categoryitem
			foreach( $product_categories as $category_id ){
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_categoryitem( category_id, product_id ) VALUES( %d, %d )", $category_id, $product_id ) );
			}
			
			// Add Reviews to System
			foreach( $reviews as $review ){
				$approved = $review->comment_approved;
				$rating = get_comment_meta( $review->comment_ID, 'rating', true );
				$comment_title = "";
				$comment_description = $review->comment_content;
				$date_submitted = $review->comment_date;
				$wpdb->query( $wpdb->prepare( "INSERT INTO ec_review( product_id, approved, rating, title, description, date_submitted ) VALUES( %d, %d, %d, %s, %s, %s )", $product_id, $approved, $rating, $comment_title, $comment_description, $date_submitted ) );
			}
			
		}
		
		// Now add cross sales to products
		foreach( $add_crosssale as $key => $value ){
			
			$product_id = substr( $key, 3 );
			$featured_ids = array( );
			foreach( $value as $the_post_id ){
				$featured_ids[] = $new_products["id-".$the_post_id];
			}
			$featured_id_1 = 0;
			if( count( $featured_ids ) > 0 )
				$featured_id_1 = $featured_ids[0];
			$featured_id_2 = 0;
			if( count( $featured_ids ) > 1 )
				$featured_id_2 = $featured_ids[1];
			$featured_id_3 = 0;
			if( count( $featured_ids ) > 2 )
				$featured_id_3 = $featured_ids[2];
			$featured_id_4 = 0;
			if( count( $featured_ids ) > 3 )
				$featured_id_4 = $featured_ids[3];
				
			$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.featured_product_id_1 = %d, ec_product.featured_product_id_2 = %d, ec_product.featured_product_id_3 = %d, ec_product.featured_product_id_4 = %d WHERE ec_product.product_id = %d", $featured_id_1, $featured_id_2, $featured_id_3, $featured_id_4, $product_id ) ); 
			
		}
		
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=woo-importer&ec_success=woo-imported" );
		
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "oscommerce-importer" && $_GET['ec_action'] == "import-oscommerce-products" ){
	
		global $wpdb;
		$wpdb->show_errors();
		
		/* IMPORT CATEGORIES */
		$categories = $wpdb->get_results( "SELECT * FROM categories_description" );
		for( $i=0; $i<count( $categories ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_category( category_name ) VALUES( %s )", $categories[$i]->categories_name ) );
			$categories[$i]->category_id = $wpdb->insert_id;
		}
		
		/* IMPORT MANUFACTURERS */
		$manufacturers = array( );
		$os_manufacturers = $wpdb->get_results( "SELECT * FROM manufacturers" );
		for( $i=0; $i<count( $os_manufacturers ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_manufacturer( `name` ) VALUES( %s )", $os_manufacturers[$i]->manufacturers_name ) );
			$manufacturers[$os_manufacturers[$i]->manufacturers_id]->manufacturer_id = $wpdb->insert_id;
		}
		
		/* IMPORT OPTIONS */
		$options = array( );
		$os_options = $wpdb->get_results( "SELECT * FROM products_options" );
		for( $i=0; $i<count( $os_options ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option( `option_name`, `option_label`, `option_required` ) VALUES( %s, %s, 0 )", $os_options[$i]->products_options_name, $os_options[$i]->products_options_name ) );
			$options[$os_options[$i]->products_options_id]->name = $os_options[$i]->products_options_name;
			$options[$os_options[$i]->products_options_id]->option_id = $wpdb->insert_id;
		}
		
		/* IMPORT OPTION ITEMS */
		$optionitems = array( );
		$os_optionitems = $wpdb->get_results( "SELECT * FROM products_options_values" );
		for( $i=0; $i<count( $os_optionitems ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_optionitem( `optionitem_name` ) VALUES( %s )", $os_optionitems[$i]->products_options_values_name ) );
			$optionitems[$os_optionitems[$i]->products_options_values_id]->optionitem_id = $wpdb->insert_id;
		}
		
		/* IMPORT PRODUCTS */
		$products = array( );
		$os_products = $wpdb->get_results( "SELECT * FROM products" );
		for( $i=0; $i<count( $os_products ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product( `stock_quantity`, `model_number`, `image1`, `price`, `weight`, `manufacturer_id` ) VALUES( %s, %s, %s, %s, %s, %s )", $os_products[$i]->products_quantity, $os_products[$i]->products_model, $os_products[$i]->products_image, $os_products[$i]->products_price, $os_products[$i]->products_weight, $manufacturers[$os_products[$i]->manufacturers_id]->manufacturer_id ) );
			$products[$os_products[$i]->products_id]->product_id = $wpdb->insert_id;
		}
		
		// Add Descriptions
		$os_product_descriptions = $wpdb->get_results( "SELECT * FROM products_description" );
		for( $i=0; $i<count( $os_product_descriptions ); $i++ ){
			echo $wpdb->prepare( "UPDATE ec_product SET activate_in_store = 1, title = %s, description = %s WHERE product_id = %d", $os_product_descriptions[$i]->products_name, $os_product_descriptions[$i]->products_description, $products[$os_product_descriptions[$i]->products_id]->product_id );
			$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET activate_in_store = 1, show_on_startup = 1, title = %s, description = %s WHERE product_id = %d", $os_product_descriptions[$i]->products_name, $os_product_descriptions[$i]->products_description, $products[$os_product_descriptions[$i]->products_id]->product_id ) );
		}
		
		// Connect Option items to Options
		$os_option_to_optionitems = $wpdb->get_results( "SELECT * FROM products_options_values_to_products_options" );
		for( $i=0; $i<count( $os_option_to_optionitems ); $i++ ){
			$wpdb->query( $wpdb->prepare( "UPDATE ec_optionitem SET option_id = %d WHERE optionitem_id = %d", $options[$os_option_to_optionitems[$i]->products_options_id]->option_id, $optionitems[$os_option_to_optionitems[$i]->products_options_values_id]->optionitem_id ) );
		}
		
		// Connect Options to Products
		$os_option_to_product = $wpdb->get_results( "SELECT * FROM products_attributes GROUP BY products_id, options_id" );
		for( $i=0; $i<count( $os_option_to_product ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_option_to_product( `option_id`, `product_id` ) VALUES( %s, %s )", $options[$os_option_to_product[$i]->options_id]->option_id, $products[$os_option_to_product[$i]->products_id]->product_id ) );
		}
		
		// Add Option Item Pricing to Option Items
		$os_optionitem_pricing = $wpdb->get_results( "SELECT * FROM products_attributes" );
		for( $i=0; $i<count( $os_optionitem_pricing ); $i++ ){
			if( $os_optionitem_pricing[$i]->price_prefix = "+" )
				$price_change = $os_optionitem_pricing[$i]->options_values_price;
			else
				$price_change = (-1) * $os_optionitem_pricing[$i]->options_values_price;
			
			$wpdb->query( $wpdb->prepare( "UPDATE ec_optionitem SET optionitem_price = %s WHERE optionitem_id = %d", $price_change, $optionitems[$os_optionitem_pricing[$i]->options_values_id]->optionitem_id ) );
		}
		
		// Connect Products to Categories
		$os_product_to_category = $wpdb->get_results( "SELECT * FROM products_to_categories" );
		for( $i=0; $i<count( $os_product_to_category ); $i++ ){
			$wpdb->query( $wpdb->prepare( "INSERT INTO ec_categoryitem( `category_id`, `product_id` ) VALUES( %d, %d )", $categories[$os_product_to_category[$i]->categories_id]->category_id, $products[$os_product_to_category[$i]->products_id]->product_id ) );
		}
		
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=oscommerce-importer&ec_success=oscommerce-imported" );
	
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "mymail-integration" && $_GET['ec_action'] == "import-subscribers" ){
		
		if( function_exists( 'mymail' ) ){
			
			global $wpdb;
			$subscribers = $wpdb->get_results( "SELECT * FROM ec_subscriber" );
			
			foreach( $subscribers as $subscriber ){
				
				$subscriber_id = mymail('subscribers')->add(array(
					'fistname' => $subscriber->first_name,
					'lastname' => $subscriber->last_name,
					'email' => $subscriber->email,
					'status' => 1,
				), false );
			
			}
			
			header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=mymail-integration&ec_success=mymail-imported" );
			
		}
		
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "google-merchant" && $_GET['ec_action'] == "download-google-csv" ){
	
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.model_number, ec_product.title, ec_product.price, ec_product.list_price, ec_manufacturer.name as manufacturer_name FROM ec_product LEFT JOIN ec_manufacturer ON ec_manufacturer.manufacturer_id = ec_product.manufacturer_id ORDER BY ec_product.title ASC" );
		
		$data = 'product_id,model_number,title,price,sale_price,brand,google_product_category,product_type,condition,gtin,mpn,identifier_exists,gender,age_group,size_type,size_system,item_group_id,color,material,pattern,size,weight_type,shipping_label';
		
		$data .= "\n";
		
		foreach( $products as $product ){ 
			
			$attributes_result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ec_product_google_attributes WHERE product_id = %d", $product->product_id ) );
			
			if( $attributes_result ){
				$attributes = json_decode( $attributes_result->attribute_value, true );
			
			}else{
				$attributes = array( 	"google_product_category" => "None Selected",
										"product_type" => "",
										"condition" => "",
										"gtin" => "",
										"mpn" => "",
										"identifier_exists" => "",
										"gender" => "",
										"age_group" => "",
										"size_type" => "",
										"size_system" => "",
										"item_group_id" => "",
										"color" => "",
										"material" => "",
										"pattern" => "",
										"size" => "",
										"weight_type" => "lb",
										"shipping_label" => "" );
			
			}
			
			$data .= '"' . str_replace( '"', '""', $product->product_id ) . '","' . str_replace( '"', '""', $product->model_number ) . '","' . str_replace( '"', '""', $product->title ) . '","' . str_replace( '"', '""', $product->price ) . '","' . str_replace( '"', '""', $product->list_price ) . '","' . str_replace( '"', '""', $product->manufacturer_name ) . '"';
			foreach( $attributes as $attribute ){
				$data .= ',"' . str_replace( '"', '""', $attribute ) . '"';
			}
		
			$data .= "\n";
			
		}
		
		
		
		header("Content-type: text/csv; charset=UTF-8");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Disposition: attachment; filename=google-feed.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
	
		echo $data;
		
		die( );
		
	}else if( current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && isset( $_GET['ec_page'] ) && isset( $_GET['ec_panel'] ) && isset( $_GET['ec_action'] ) && $_GET['page'] == "ec_adminv2" && $_GET['ec_page'] == "store-setup" && $_GET['ec_panel'] == "google-merchant" && $_GET['ec_action'] == "upload-google-csv" ){
		
		global $wpdb;
		
		$file = fopen( $_FILES['csv_file']['tmp_name'], "r" );
		
		$headers = fgetcsv( $file );
		
		if( $headers[0] != "product_id" ){
			
			echo "You must upload a CSV with the first column product_id";
			die( );
		
		}else if( count( $headers ) != 23 ){
			
			echo "You must have 23 columns in your CSV file. You should download and add content, do not delete columns or rows.";
			die( );
		
		}else{
		
			$line_number = 1;
			$eof_reached = false;
		
			while( !feof( $file ) && !$eof_reached ){ // each time through, run up to the limit of items until eof hit.
				
				$row = fgetcsv( $file );
			
				if( strlen( trim( $row[0] ) ) <= 0 ){ // checking for file with extra rows that are empty
					$eof_reached = true;
				
				}else{
					
					if( count( $row ) != 23 ){
						
						echo "Something went wrong when processing line " . $line_number . ". Please ensure you have data in all 23 columns to continue.";
						die( );
						
					}else{
				
						// Save your Google Merchant Product Options
						$attribute_array = array( 	"google_product_category" 	=> $row[6],
													"product_type" 				=> $row[7],
													"condition" 				=> $row[8],
													"gtin" 						=> $row[9],
													"mpn" 						=> $row[10],
													"identifier_exists" 		=> $row[11],
													"gender" 					=> $row[12],
													"age_group" 				=> $row[13],
													"size_type" 				=> $row[14],
													"size_system" 				=> $row[15],
													"item_group_id" 			=> $row[16],
													"color" 					=> $row[17],
													"material" 					=> $row[18],
													"pattern" 					=> $row[19],
													"size" 						=> $row[20],
													"weight_type" 				=> $row[21],
													"shipping_label" 			=> $row[22] );
													
						$attribute_json = json_encode( $attribute_array );
						
						$product = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.product_id FROM ec_product WHERE ec_product.product_id = %d", $row[0] ) );
						if( $product ){
							$wpdb->query( $wpdb->prepare( "DELETE FROM ec_product_google_attributes WHERE product_id = %d", $row[0] ) );
							$wpdb->query( $wpdb->prepare( "INSERT INTO ec_product_google_attributes(product_id, attribute_value) VALUES( %d, %s )", $row[0], $attribute_json ) );
						}else{
							
							echo "No product found with product_id " . $row[0] . " on line " . $line_number;
							die( );
							
						}
				
					}// close row check
				
					$line_number++;
					
				} // close end of file check
				
			} // close while loop
			
			
			fclose( $file );
			
		}
		
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_success=google-import-complete" );
	
	}// Close if/else to decide which action to take
	
}

//store settings menu
function ec_settings_page_callback(){
	include("ec_install.php");
}

function ec_install_page_callback(){
	include("ec_install.php");
}

function ec_setup_page_callback(){
	include("store_setup.php");
}

function ec_payment_page_callback(){
	include("payment.php");
}

function ec_social_icons_page_callback(){
	include("social_icons.php");
}

function ec_language_page_callback(){
	include("language.php");
}


//administration menu
function ec_administration_callback() {
	include("demos.php");
}
function ec_admin_console_page_callback() {
	include("admin_console.php");
}
function ec_demos_callback() {
	include("demos.php");
}
function ec_users_guide_callback() {
	include("users_guide.php");
}

//store design menu
function ec_base_design_page_callback(){
	include("base_design.php");
}

// Admin per theme function is in wpeasycart.php

//store checklist menu
function ec_checklist_page_callback(){
	include("checklist.php");
}

//store v2 admin menu item
function ec_adminv2_page_callback( ){
	include( "admin_v2.php" );
}

function ec_databasedump( ){
	global $wpdb;
	$return_string = "";
	$return_string .= "/*MySQL Dump File*/\n";
	$sql = "show tables";
	$results = $wpdb->get_results( $sql, ARRAY_N );
	
	if( !empty( $results ) ){
		foreach( $results as $row ){
			if( $row[0] != ec_tempcart_data && ( substr( $row[0], 0, 3 ) == "ec_" || substr( $row[0], 0, 11 ) == "quickbooks_" ) ){
				$return_string .= ec_databasedump_table_data( $row[0] );
			}
		}
		$wpoptions = new ec_wpoptionset();
		$return_string .= $wpoptions->get_db_dump_options( );
	}else{
		$return_string .= "/* no tables in $database */\n";
	}
	return $return_string;
}

function ec_databasedump_table_structure( $table ){
	global $wpdb;
	$return_string = "";
	$return_string .= "/* Table structure for table `$table` */\n";
	$return_string .= "DROP TABLE IF EXISTS `$table`;\n\n";
	$sql = "show create table `$table`; ";
	$results = $wpdb->get_results( $sql, ARRAY_A );
	if( !empty( $results ) ){
		foreach( $results as $result ){
			$return_string .= $row['Create Table'].";\n\n";
		}
	}
	return $return_string;
}

function ec_databasedump_table_data( $table ){
	global $wpdb;
	$return_string = "";
	$sql = "select * from `$table`;";
	$results = $wpdb->get_results( $sql, ARRAY_N );
	$keys = $wpdb->get_results( "SHOW COLUMNS FROM `$table`;", ARRAY_N );
	if( !empty( $results ) ){
		$return_string .= "/* dumping data for table `$table` */\n";
		$return_string .= "TRUNCATE `$table`;\n";
		$insert_query = "INSERT INTO `$table`(";
		$return_string .= "INSERT INTO `$table`(";
		$index_keys = 0;
		foreach( $keys as $key ){
			$insert_query .= "`" . $key[0] . "`";
			$return_string .= "`" . $key[0] . "`";
			if( $index_keys < count( $keys ) - 1 ){
				$insert_query .= ",";
				$return_string .= ",";
			}
			$index_keys++;
		}
		$insert_query .= ") VALUES\n";
		$return_string .= ") VALUES\n";
		$index = 0;
		
		foreach( $results as $row ){
			$return_string .= "(";
			for( $i = 0; $i < count( $row ); $i++ ){
				if( is_null( $row[$i] ) )
					$return_string .= "null";
				else{
					$return_string .= "'" . str_replace( "'", "\\'", str_replace( '\\', '\\\\', stripslashes( $row[$i] ) ) ) . "'";
				}

				if( $i < count( $row ) - 1 )
					$return_string .= ",";
			}
			$return_string .= ")";
			
			if( $index != 0 && $index%100 == 0 && $index < ( count( $results ) - 1 ) )
				$return_string .= ";\n" . $insert_query;
			else if( $index < count( $results ) - 1 )
				$return_string .= ",\n";
			else
				$return_string .= ";\n";

			$index++;
		}
	}
	$return_string .= "\n";
	return $return_string;
}

function ec_post_save_match_store_meta( $post_id ) {
	//If we are matching post meta, lets do it here for store page only!
	$selected_store_id = get_option( 'ec_option_storepage' );
	$using_meta_match = get_option( 'ec_option_match_store_meta' );
	if( $using_meta_match && $selected_store_id == $post_id ){
		//Get the store page meta
		$store_meta = get_post_meta( $post_id );
		//Get the posts for the store
		$args = array( 'post_type' => 'ec_store' );
		$my_query = new WP_Query( $args );
		foreach( $my_query->posts as $post ){
			//Get the post meta for deletion if needed
			$post_meta = get_post_meta( $post->ID );
			//Delete each meta for this post
			foreach( $post_meta as $key => $meta ){
				delete_post_meta( $post->ID, $key );
			}
			
			//Add each store meta to this post
			foreach( $store_meta as $key => $meta ){
				//We need to check if unseriablizable and deal with it accordingly
				$meta_arr = @unserialize( $meta[0] );
				if( $meta_arr !== false ){
					add_post_meta( $post->ID, $key, $meta_arr );
				}else{
					add_post_meta( $post->ID, $key, $meta[0] );
				}
			}
		}
	}
}

function ec_intuit_connect( ){
	
	if( current_user_can( 'manage_options' ) ){
		if( isset( $_GET['ec_wpeasycart_intuit_authroize'] ) ){
			wpeasycart_intuit_oauth_init( );
		
		}else if( isset( $_GET['ec_wpeasycart_intuit_reauthroize'] ) ){
			wpeasycart_intuit_oauth_reauthorize( );
		
		}else if( isset( $_GET['ec_wpeasycart_intuit_disconnect'] ) ){
			wpeasycart_intuit_oauth_disconnect( );
		
		}
	}
	
}

function wpeasycart_intuit_oauth_init( ){
	
	require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/admin/assets/qbsdk/config.php" );
	define('OAUTH_REQUEST_URL', 'https://oauth.intuit.com/oauth/v1/get_request_token');
	define('OAUTH_ACCESS_URL', 'https://oauth.intuit.com/oauth/v1/get_access_token');
	define('OAUTH_AUTHORISE_URL', 'https://appcenter.intuit.com/Connect/Begin');
	define('OAUTH_CONSUMER_KEY', get_option( 'ec_option_intuit_consumer_key' ) );
	define('OAUTH_CONSUMER_SECRET', get_option( 'ec_option_intuit_consumer_secret' ) );
	
	// The url to this page. it needs to be dynamic to handle runnable's dynamic urls
	define( 'CALLBACK_URL', get_admin_url( ) . 'admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings&ec_wpeasycart_intuit_authroize=true' );
	
	// cleans out the token variable if comming from
	// connect to QuickBooks button
	if( isset( $_GET['start'] ) ){
		update_option( 'ec_option_intuit_access_token', '' );
	}
	 
	try{
		if( !class_exists( 'OAuth' ) ){
			echo "OAuth is not available for PHP on your server, which is a requirement for using Intuit. Please contact your hosting provider and ask them to install the PHP extension 'OAuth'.";
			die( );
		}
		$oauth = new OAuth( OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
		$oauth->enableDebug();
		$oauth->disableSSLChecks(); //To avoid the error: (Peer certificate cannot be authenticated with given CA certificates)
		if( !isset( $_GET['oauth_token'] ) && get_option( 'ec_option_intuit_access_token' ) == '' ){
			
			// step 1: get request token from Intuit
			$request_token = $oauth->getRequestToken( OAUTH_REQUEST_URL, CALLBACK_URL );
			update_option( 'ec_option_intuit_access_token_secret', $request_token['oauth_token_secret'] );
			
			// step 2: send user to intuit to authorize 
			header( 'Location: '. OAUTH_AUTHORISE_URL . '?oauth_token=' . $request_token['oauth_token'] );
	
		}
		
		if( isset( $_GET['oauth_token'] ) && isset( $_GET['oauth_verifier'] ) ){
		
			// step 3: request a access token from Intuit
			$oauth->setToken( $_GET['oauth_token'], get_option( 'ec_option_intuit_access_token_secret' ) );
			$access_token = $oauth->getAccessToken( OAUTH_ACCESS_URL );
			
			$token = $access_token['oauth_token'];
			$token_secret = $access_token['oauth_token_secret'];
			$realmId = $_REQUEST['realmId'];
			$dataSource = $_REQUEST['dataSource'];
			
			update_option( 'ec_option_intuit_realm_id', $realmId );
			update_option( 'ec_option_intuit_access_token', $token );
			update_option( 'ec_option_intuit_access_token_secret', $token_secret );
			update_option( 'ec_option_intuit_last_authorized', time( ) );
			
			// write JS to pup up to refresh parent and close popup
			echo '<script type="text/javascript">
				window.opener.location.href = window.opener.location.href;
				window.close();
			  </script>';
		}
	 
	}catch( OAuthException $e ){
		echo "Got auth exception";
		echo '<pre>';
		print_r($e);
	}
}

function wpeasycart_intuit_oauth_reauthorize( ){
	
	$gateway = new ec_intuit( );
	$disconnect_result = $gateway->reauthorize( );
	
	if( $disconnect_result == "success" ){
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings&intuit_reauthorize=true" );
			
	}else{ 
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings&intuit_reauthorize=" . $disconnect_result );
		
	}
	
}

function wpeasycart_intuit_oauth_disconnect( ){
	
	$gateway = new ec_intuit( );
	$disconnect_result = $gateway->disconnect( );
		
	update_option( 'ec_option_intuit_realm_id', "" );
	update_option( 'ec_option_intuit_access_token', "" );
	update_option( 'ec_option_intuit_access_token_secret', "" );
	update_option( 'ec_option_intuit_last_authorized', 0 );
	
	if( $disconnect_result == "success" ){
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings&intuit_disconnected=true" );
			
	}else{ 
		header( "location:admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings&intuit_disconnected=" . $disconnect_result );
		
	}
	
}


/***********************************************************************************
* BEGIN FUNCTIONS FOR THE SHORTCODE EDITOR
************************************************************************************/

/***********************************************************************************
* BASIC SHORTCODE EDITOR FUNCTIONS
************************************************************************************/
function ec_add_editor_buttons( ){
	if( current_user_can( 'manage_options' ) ){
 		add_filter( "mce_external_plugins", "ec_add_buttons" );
    	add_filter( 'mce_buttons', 'ec_register_buttons' );
	}
}
function ec_add_buttons( $plugin_array ) {
    $plugin_array['wpeasycart'] = plugins_url() . '/wp-easycart/inc/admin/assets/js/editor.js';
    return $plugin_array;
}
function ec_register_buttons( $buttons ) {
    array_push( $buttons, 'ec_show_editor' );
    return $buttons;
}

function ec_print_editor( ){
	if( current_user_can( 'manage_options' ) ){
		echo "<div class=\"ec_editor_box_container\" id=\"ec_editor_window\">";
		echo "<a href=\"#\" class=\"ec_editor_close\" onclick=\"return ec_close_editor( );\"><span>x</span></a>";
		echo "<h3 class=\"ec_editor_heading\">Insert EasyCart Shortcodes</h3>";
		echo "<div class=\"ec_editor_inner_container\">";
		// Start Container Inner
		ec_print_editor_shortcode_menu( ); // Shortcode Menu
		// Store shortcode, no options, nothing needed
		ec_print_editor_categories( );// Store Table Shortcode Panel
		ec_print_editor_category_view( );// Store Table Shortcode Panel
		ec_print_editor_store_table( );// Store Table Shortcode Panel
		ec_print_editor_product_menu( );// Product Menu Store Shortcode Panel
		ec_print_editor_product_category( );// Product Category Store Shortcode Panel
		ec_print_editor_manufacturer_group( );// Manufacturer Group Store Shortcode Panel
		ec_print_editor_product_details( );// Product Details Store Shortcode Panel
		// Cart shortcode, no options, nothing needed
		// Account shortcode, no options, nothing needed
		ec_print_editor_single_product( );// Single Product Shortcode Panel
		ec_print_editor_multiple_products( );// Multiple Products Shortcode Panel
		ec_print_editor_add_to_cart( );// Add to Cart Shortcode Panel
		// Cart Display shortcode, no options, nothing needed
		ec_print_editor_membership_content( );// Add to Cart Shortcode Panel
		// End Container Inner
		echo "</div>";
		echo "</div>";
		echo "<div class=\"ec_editor_overlay\" id=\"ec_editor_bg\"></div>";
		echo "<script>jQuery( document.getElementById( 'ec_editor_window' ) ).appendTo( document.body );</script>";
		echo "<script>jQuery( document.getElementById( 'ec_editor_bg' ) ).appendTo( document.body );</script>";
	}
}

// Shortcode Menu
function ec_print_editor_shortcode_menu( ){
	echo "<ul class=\"ec_column_holder\" id=\"ec_shortcode_menu\">";
		echo "<li data-ecshortcode=\"ec_store\"><div>STORE</div></li>";
		echo "<li data-ecshortcode=\"ec_categories\"><div>CATEGORIES</div></li>";
		echo "<li data-ecshortcode=\"ec_category_view\"><div>CATEGORY DISPLAY</div></li>";
		echo "<li data-ecshortcode=\"ec_store_table\"><div>STORE TABLE</div></li>";
		echo "<li data-ecshortcode=\"ec_menu\"><div>PRODUCT MENU</div></li>";
		echo "<li data-ecshortcode=\"ec_category\"><div>PRODUCT CATEGORY</div></li>";
		echo "<li data-ecshortcode=\"ec_manufacturer\"><div>MANUFACTURER GROUP</div></li>";
		echo "<li data-ecshortcode=\"ec_productdetails\"><div>PRODUCT DETAILS</div></li>";
		echo "<li data-ecshortcode=\"ec_cart\"><div>CART</div></li>";
		echo "<li data-ecshortcode=\"ec_account\"><div>ACCOUNT</div></li>";
		echo "<li data-ecshortcode=\"ec_singleitem\"><div>SINGLE ITEM</div></li>";
		echo "<li data-ecshortcode=\"ec_selecteditems\"><div>SELECT ITEMS</div></li>";
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){
		echo "<li data-ecshortcode=\"ec_addtocart\"><div>ADD TO CART BUTTON</div></li>";
		echo "<li data-ecshortcode=\"ec_cartdisplay\"><div>CART DISPLAY</div></li>";
		}
		echo "<li data-ecshortcode=\"ec_membership\"><div>MEMBERSHIP CONTENT</div></li>";
	echo "</ul>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE CATEGORIES PANEL
************************************************************************************/
// Product Menu Shortcode Creator Panel
function ec_print_editor_categories( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_categories\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_help_text\">Select a category if you would like to display a categories children, otherwise no selection will show all categories with no parent.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Category:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_category_select_none_optional( 'ec_editor_categories_category_select' );
		echo "</span></div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_categories\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE CATEGORIES PANEL
************************************************************************************/
// Product Menu Shortcode Creator Panel
function ec_print_editor_category_view( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_category_view\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_help_text\">You may select a category if you would like to show a category's children or leave with no selection to show all categories with no parent.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Category:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_category_select_none_optional( 'ec_editor_category_view_category_select' );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Columns:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_columns( 'ec_editor_category_view_columns', 3 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_category_view\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

function ec_print_category_select_none_optional( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$category_items = $db->get_category_list( );
	if( count( $category_items ) > 0 ){
		echo "<option value=\"0\">Show Featured Categories</option>";
		echo "<option value=\"-1\">Show Top Level Categories</option>";
		foreach( $category_items as $category ){
			echo "<option value=\"" . $category->category_id . "\">" . $category->category_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Category Items Exist</option>";
	}
	echo "</select>";
}

function ec_print_columns( $id, $val ){
	echo "<input type=\"text\" id=\"" . $id . "\" value=\"" . $val . "\" class=\"ec_editor_input_box\" />";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE STORE TABLE PANEL
************************************************************************************/
// Product Menu Shortcode Creator Panel
function ec_print_editor_store_table( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_store_table\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_product_menu_error\"><span>Please select a menu item at the minimum</span></div>";
		echo "<div class=\"ec_editor_help_text\">If you select nothing, all products will be shown in alphabetical order. You may select products, menus (3 levels) and/or categories to display in a table list view. You may also customize the columns that are displayed. All products are ordered by title from A-Z.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Products:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_multiple_select( 'ec_editor_table_product_select' );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Menu:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_menu_multiple_select( 'ec_editor_table_menu_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Sub Menu:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_submenu_multiple_select( 'ec_editor_table_submenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">SubSub Menu:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_subsubmenu_multiple_select( 'ec_editor_table_subsubmenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Category:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_category_multiple_select( 'ec_editor_table_category_select' );
		echo "</span></div>";
		$default_fields = array( 'model_number', 'title', 'price', 'details_link' );
		$default_labels = array( 'SKU', 'Product Name', 'Price', 'More' );
		for( $j=0; $j<count( $default_fields ); $j++ ){
			echo "<div class=\"ec_editor_select_row\" id=\"ec_editor_table_column_" . $j . "\"><span class=\"ec_editor_select_row_label\">Column " . ($j+1) . "</span><span class=\"ec_editor_select_row_input\">";
			ec_print_product_label_input( 'ec_editor_table_label_' . $j, $default_labels[$j] );
			echo " ";
			ec_print_product_field_list_box( 'ec_editor_table_field_' . $j, $default_fields[$j] );
			echo "</span></div>";
		}
		echo "<div class=\"ec_editor_select_row\" id=\"ec_editor_table_column_" . $j . "\"><span class=\"ec_editor_select_row_label\">Link Label (optional)</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_label_input( 'ec_editor_table_view_details_text', "view more" );
		echo "</span></div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_store_table\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

function ec_print_product_label_input( $id, $val ){
	echo "<input type=\"text\" id=\"" . $id . "\" value=\"" . $val . "\" class=\"ec_editor_input_box\" />";
}

function ec_print_product_field_list_box( $id, $selected ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$items = array( 'product_id', 'model_number', 'title', 'price', 'details_link', 'description', 'specifications', 'stock_quantity', 'weight', 'width', 'height', 'length' );
	echo "<option value=\"0\">Select a Product Field</option>";
	foreach( $items as $item ){
		echo "<option value=\"" . $item. "\"";
		if( $item == $selected )
			echo " selected=\"selected\"";
		echo ">" . $item . "</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT MENU PANEL
************************************************************************************/
// Product Menu Shortcode Creator Panel
function ec_print_editor_product_menu( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_product_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_product_menu_error\"><span>Please select a menu item at the minimum</span></div>";
		echo "<div class=\"ec_editor_help_text\">To display a product menu item page, select a menu item below. If you want to display a sub menu or a subsub menu, then select the menu, followed by the submenu and/or the subsubmenu.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Menu:</span><span id=\"ec_editor_menu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_menu_select( 'ec_editor_menu_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Sub Menu:</span><span id=\"ec_editor_submenu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_submenu_select( 'ec_editor_submenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">SubSub Menu:</span><span id=\"ec_editor_subsubmenu_holder\" class=\"ec_editor_select_row_input\">";
		ec_print_subsubmenu_select( 'ec_editor_subsubmenu_select', 0 );
		echo "</span></div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_product_menu\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_menu_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\" onchange=\"ec_editor_select_menu_change( );\">";
	$db = new ec_db( );
	$menu_items = $db->get_menulevel1_items( );
	if( count( $menu_items ) > 0 ){
		echo "<option value=\"0\">Select a Menu Item</option>";
		foreach( $menu_items as $menu ){
			echo "<option value=\"" . $menu->menulevel1_id . "\">" . $menu->menu1_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Menu Items Exist</option>";
	}
	echo "</select>";
}

// Print all main menu items in a select box
function ec_print_menu_multiple_select( $id ){
	echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$menu_items = $db->get_menulevel1_items( );
	if( count( $menu_items ) > 0 ){
		echo "<option value=\"0\">Select a Menu Item</option>";
		foreach( $menu_items as $menu ){
			echo "<option value=\"" . $menu->menulevel1_id . "\">" . $menu->menu1_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Menu Items Exist</option>";
	}
	echo "</select>";
}

// Print all sub menu items for a particular menu item in a select box
function ec_print_submenu_select( $id, $menuid ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\" onchange=\"ec_editor_select_submenu_change( );\">";
	if( $menuid > 0 ){
		$db = new ec_db( );
		$menu_items = $db->get_menulevel2_items( );
		if( count( $menu_items ) > 0 ){
			echo "<option value=\"0\">Select a Menu Item (optional)</option>";
			foreach( $menu_items as $menu ){
				if( $menu->menulevel1_id == $menuid ){
					echo "<option value=\"" . $menu->menulevel2_id . "\">" . $menu->menu2_name . "</option>";
				}
			}
		}else{
			echo "<option value=\"0\">No SubMenu Items Exist</option>";
		}
	}else{
		echo "<option value=\"0\">No Menu Item Selected</option>";
	}
	echo "</select>";
}

// Print all sub menu items for a particular menu item in a multi select box
function ec_print_submenu_multiple_select( $id, $menuid ){
	echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$menu_items = $db->get_menulevel2_items( );
	if( count( $menu_items ) > 0 ){
		echo "<option value=\"0\">Select a Menu Item (optional)</option>";
		foreach( $menu_items as $menu ){
			echo "<option value=\"" . $menu->menulevel2_id . "\">" . $menu->menu2_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No SubMenu Items Exist</option>";
	}
	echo "</select>";
}

// Print all sub sub menu items for a particular menu item in a select box
function ec_print_subsubmenu_select( $id, $submenuid ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	if( $submenuid > 0 ){
		$db = new ec_db( );
		$menu_items = $db->get_menulevel3_items( );
		if( count( $menu_items ) > 0 ){
			echo "<option value=\"0\">Select a SubSub Menu Item (optional)</option>";
			foreach( $menu_items as $menu ){
				if( $menu->menulevel2_id == $submenuid ){
					echo "<option value=\"" . $menu->menulevel3_id . "\">" . $menu->menu3_name . "</option>";
				}
			}
		}else{
			echo "<option value=\"0\">No SubSubMenu Items Exist</option>";
		}
	}else{
		echo "<option value=\"0\">No Sub Menu Item Selected</option>";
	}
	echo "</select>";
}

// Print all sub sub menu items for a particular menu item in a multiple select box
function ec_print_subsubmenu_multiple_select( $id, $submenuid ){
	echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$menu_items = $db->get_menulevel3_items( );
	if( count( $menu_items ) > 0 ){
		echo "<option value=\"0\">Select a SubSub Menu Item (optional)</option>";
		foreach( $menu_items as $menu ){
			echo "<option value=\"" . $menu->menulevel3_id . "\">" . $menu->menu3_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No SubSubMenu Items Exist</option>";
	}
	echo "</select>";
}

// Ajax calls
function ec_editor_update_sub_menu( ){
	if( current_user_can( 'manage_options' ) ){
		$id = $_POST['id'];
		$menuid = $_POST['menuid'];
		
		ec_print_submenu_select( $id, $menuid );
		die( );
	}
}

function ec_editor_update_subsub_menu( ){
	if( current_user_can( 'manage_options' ) ){
		$id = $_POST['id'];
		$submenuid = $_POST['submenuid'];
		
		ec_print_subsubmenu_select( $id, $submenuid );
		die( );
	}
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT CATEGORY PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_product_category( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_product_category\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_product_category_error\"><span>Please select a category item</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a category group which can be created in the store admin in the submenu of the products section.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Category:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_category_select( 'ec_editor_category_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_product_category\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main category items in a select box
function ec_print_category_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$category_items = $db->get_category_list( );
	if( count( $category_items ) > 0 ){
		echo "<option value=\"0\">Select a Category Item</option>";
		foreach( $category_items as $category ){
			echo "<option value=\"" . $category->category_id . "\">" . $category->category_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Category Items Exist</option>";
	}
	echo "</select>";
}

// Print all main categirt items in a multi select box
function ec_print_category_multiple_select( $id ){
	echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$category_items = $db->get_category_list( );
	if( count( $category_items ) > 0 ){
		echo "<option value=\"0\">Select a Category Item</option>";
		foreach( $category_items as $category ){
			echo "<option value=\"" . $category->category_id . "\">" . $category->category_name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Category Items Exist</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MANUFACTURER GROUP PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_manufacturer_group( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_manufacturer_group\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_manufacturer_group_error\"><span>Please select a manufacturer</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a manufacturer group, which consists of all products assigned to the selected manufacturer (think of it as a product filter by manufacturer).</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Manufacturer:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_manufacturer_select( 'ec_editor_manufacturer_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_manufacturer_group\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_manufacturer_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
	$db = new ec_db( );
	$manufacturers = $db->get_manufacturer_list( );
	if( count( $manufacturers ) > 0 ){
		echo "<option value=\"0\">Select a Manufacturer</option>";
		foreach( $manufacturers as $manufacturer ){
			echo "<option value=\"" . $manufacturer->manufacturer_id . "\">" . $manufacturer->name . "</option>";
		}
	}else{
		echo "<option value=\"0\">No Manufacturers Exist</option>";
	}
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE PRODUCT DETAILS PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_product_details( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_productdetails_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_productdetails_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a single product's details on the specified page.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product Model Number:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_productdetails_select( 'ec_editor_productdetails_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_productdetails\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}



// Print all main menu items in a select box
function ec_print_productdetails_select( $id ){
	
	global $wpdb;
	$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product" );
	
	if( $total > 500 ){
		
		echo "<input type=\"text\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		
	}else{
		
		echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		$products = $wpdb->get_results( "SELECT ec_product.title, ec_product.model_number FROM ec_product ORDER BY ec_product.title" );
		if( count( $products ) > 0 ){
			echo "<option value=\"0\">Select a Product</option>";
			for( $i=0; $i<count( $products ); $i++ ){
				echo "<option value=\"" . $products[$i]->model_number . "\">" . $products[$i]->title . "</option>";
			}
		}else{
			echo "<option value=\"0\">No Products Exist</option>";
		}
		echo "</select>";
		
	}
	
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE SINGLE PRODUCT PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_single_product( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_single_product\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_single_product_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays a single product with a view details button.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product ID:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_select( 'ec_editor_single_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Display Type:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_display_type_select( 'ec_editor_single_product_display_type' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_single_product\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_product_select( $id ){
	
	global $wpdb;
	$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product" );
	
	if( $total > 500 ){
		
		echo "<input type=\"text\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		
	}else{
		
		echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.title, ec_product.model_number FROM ec_product ORDER BY ec_product.title" );
		if( count( $products ) > 0 ){
			echo "<option value=\"0\">Select a Product</option>";
			for( $i=0; $i<count( $products ); $i++ ){
				echo "<option value=\"" . $products[$i]->product_id . "\">" . $products[$i]->title . "</option>";
			}
		}else{
			echo "<option value=\"0\">No Products Exist</option>";
		}
		echo "</select>";
		
	}
	
}

// Print the display types available for the product display
function ec_print_product_display_type_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		echo "<option value=\"1\" selected=\"selected\">Default Product Display Type</option>";
		echo "<option value=\"2\">Same as Product Widget Display</option>";
		echo "<option value=\"3\">Custom Display Type 1</option>";
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MULTIPLE PRODUCTS PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_multiple_products( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_multiple_products\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_multiple_products_error\"><span>Please Select at Least One Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays multiple products that can be selected one at a time. Each is displayed with a view details button.</div>";
		echo "<div class=\"ec_editor_multiple_select_row\"><span class=\"ec_editor_select_row_label\">Product:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_multiple_select( 'ec_editor_multiple_products_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Display Type:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_display_type_select( 'ec_editor_multiple_products_display_type' );
		echo "</div>";
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
			echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Columns:</span><span class=\"ec_editor_select_row_input\">";
			ec_print_product_columns_select( 'ec_editor_multiple_products_columns' );
			echo "</div>";
		}
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_multiple_products\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

// Print all main menu items in a select box
function ec_print_product_multiple_select( $id ){
	global $wpdb;
	$total = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) as total FROM ec_product" );
	
	if( $total > 500 ){
		
		echo "<input type=\"text\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		
	}else{
		
		echo "<select multiple=\"multiple\" class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		global $wpdb;
		$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.title, ec_product.model_number FROM ec_product ORDER BY ec_product.title" );
		if( count( $products ) > 0 ){
			for( $i=0; $i<count( $products ); $i++ ){
				echo "<option value=\"" . $products[$i]->product_id . "\">" . $products[$i]->title . "</option>";
			}
		}else{
			echo "<option value=\"0\">No Products Exist</option>";
		}
		echo "</select>";
		
	}
}

function ec_print_product_columns_select( $id ){
	echo "<select class=\"ec_editor_select_box\" id=\"" . $id . "\">";
		echo "<option value=\"1\">1</option>";
		echo "<option value=\"2\">2</option>";
		echo "<option value=\"3\" selected=\"selected\">3</option>";
		echo "<option value=\"4\">4</option>";
		echo "<option value=\"5\">5</option>";
	echo "</select>";
}

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE ADD TO CART PANEL
************************************************************************************/
// Product Category Shortcode Creator Panel
function ec_print_editor_add_to_cart( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_add_to_cart\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_add_to_cart_error\"><span>Please Select a Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode displays an add to cart button (with options if attached) of a single product.</div>";
		echo "<div class=\"ec_editor_select_row\"><span class=\"ec_editor_select_row_label\">Product ID:</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_select( 'ec_editor_add_to_cart_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_add_to_cart\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}
// Reusing the print product select option

/***********************************************************************************
* BEGIN FUNCTIONS FOR THE MEMBERSHIP CONTENT PANEL
************************************************************************************/
// Membership Content Creator Panel
function ec_print_editor_membership_content( ){
	echo "<div class=\"ec_editor_panel\" id=\"ec_membership_menu\">";
		echo "<div class=\"ec_editor_select_row\"><input type=\"button\" value=\"BACK\" class=\"ec_editor_button backlink\"></div>";
		echo "<div class=\"ec_editor_error\" id=\"ec_membership_error\"><span>Please Select at Least One Product</span></div>";
		echo "<div class=\"ec_editor_help_text\">This shortcode allows you to require a user to be subscribed to a product or one product in a group of products. For example, you could create a single content page that has a bronze, silver, and gold membership level with content for all three, just silver and gold, and just gold. In addition, it gives you an alternate content area</div>";
		echo "<div class=\"ec_editor_multiple_select_row\"><span class=\"ec_editor_select_row_label\">Product(s):</span><span class=\"ec_editor_select_row_input\">";
		ec_print_product_multiple_select( 'ec_editor_membership_multiple_product_select' );
		echo "</div>";
		echo "<div class=\"ec_editor_submit_row\"><span class=\"ec_editor_select_row_input\"><input type=\"button\" value=\"ADD SHORTCODE\" id=\"ec_add_membership\" class=\"ec_editor_button\"></span></div>";
		
	echo "</div>";
}

?>