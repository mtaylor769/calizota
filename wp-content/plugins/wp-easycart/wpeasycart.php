<?php
/**
 * Plugin Name: WP EasyCart
 * Plugin URI: http://www.wpeasycart.com
 * Description: The WordPress Shopping Cart by WP EasyCart is a simple ecommerce solution that installs into new or existing WordPress blogs. Customers purchase directly from your store! Get a full ecommerce platform in WordPress! Sell products, downloadable goods, gift cards, clothing and more! Now with WordPress, the powerful features are still very easy to administrate! If you have any questions, please view our website at <a href="http://www.wpeasycart.com" target="_blank">WP EasyCart</a>.  <br /><br /><strong>*** UPGRADING? Please be sure to backup your plugin, or follow our upgrade instructions at <a href="http://v3docs.wpeasycart.com/3.0.0/index/upgrading.php" target="_blank">WP EasyCart Upgrading</a> ***</strong>
 
 * Version: 3.3.19
 * Author: Level Four Development, llc
 * Author URI: http://www.wpeasycart.com
 *
 * This program is free to download and install, but requires the purchase of our ecommerce shopping cart admin plugin to use live payment gateways, coupons, promotions, and more.
 * Each site requires a license for live use and must be purchased through the WP EasyCart website.
 *
 * @package wpeasycart
 * @version 3.3.19
 * @author WP EasyCart <sales@wpeasycart.com>
 * @copyright Copyright (c) 2012, WP EasyCart
 * @link http://www.wpeasycart.com
 */
 
define( 'EC_PUGIN_NAME', 'WP EasyCart');
define( 'EC_PLUGIN_DIRECTORY', 'wp-easycart');
define( 'EC_CURRENT_VERSION', '3_3_19' );
define( 'EC_CURRENT_DB', '1_30' );/* Backwards Compatibility */
define( 'EC_UPGRADE_DB', '52' );

require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/ec_config.php' );

add_action( 'init', 'wpeasycart_load_startup', 1 );
add_action( 'wp_logout', 'wpeasycart_end_session' );
add_action( 'wp_login', 'wpeasycart_end_session' );
add_action( 'widgets_init', 'wpeasycart_register_widgets' );

function wpeasycart_load_startup( ){
	
	// Setup Hook Structure
	ec_setup_hooks( );
	
	// Check and add hooks
	if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/ec_hooks.php" ) )
		include( WP_PLUGIN_DIR . "/wp-easycart-data/ec_hooks.php" );
}

function wpeasycart_end_session( ){
	wpeasycart_start_session( );
    session_destroy( );
}

function wpeasycart_register_widgets( ) {
	register_widget( 'ec_categorywidget' );
	register_widget( 'ec_cartwidget' );
	register_widget( 'ec_colorwidget' );
	register_widget( 'ec_currencywidget' );
	register_widget( 'ec_donationwidget' );
	register_widget( 'ec_groupwidget' );
	register_widget( 'ec_languagewidget' );
	register_widget( 'ec_loginwidget' );
	register_widget( 'ec_manufacturerwidget' );
	register_widget( 'ec_menuwidget' );
	register_widget( 'ec_newsletterwidget' );
	register_widget( 'ec_pricepointwidget' );
	register_widget( 'ec_productwidget' );
	register_widget( 'ec_searchwidget' );
	register_widget( 'ec_specialswidget' );
}

function ec_activate(){
	
	// ADD WORDPRESS OPTIONS
	$wpoptions = new ec_wpoptionset();
	$wpoptions->add_options();
	update_option( 'ec_option_wpoptions_version', EC_CURRENT_VERSION );
	
	
	// ATTEMPT TO INSTALL OR UPDATE THE DB.
	if( !get_option( 'ec_option_db_new_version' ) || EC_UPGRADE_DB != get_option( 'ec_option_db_new_version' ) ){
		$db_manager = new ec_db_manager( );
		$db_manager->install_db( );
		update_option( 'ec_option_is_installed', '1' );
	}
	
	//INITIALIZE DATABASE
	$mysqli = new ec_db();
	
	// UPDATE SITE URL
	$site = explode( "://", ec_get_url( ) );
	$site = $site[1];
	$mysqli->update_url( $site );
	// END UPDATE SITE URL 
	
	//SETUP BASIC LANGUAGE SETTINGS
	$GLOBALS['ec_cart_data'] = new ec_cart_data( $_SESSION['ec_cart_id'] );
	$GLOBALS['ec_cart_data']->restore_session_from_db( );
	$language = new ec_language( );
	$language->update_language_data( ); //Do this to update the database if a new language is added
	
	//WE BLOCK THIS FROM THE ec_config.php TO PREVENT OUTPUT ON ACTIVATION, INCLUDE HERE...
	update_option( 'ec_option_is_installed', '1' );
	
	// FIX FOR CURRENCY ISSUES
	if( get_option( 'ec_option_currency' ) == '&#36;' ){
		update_option( 'ec_option_currency', '$' );	
	}
	// END FIX FOR CURRENCY ISSUES
	
	// CREATE DATA FOLDER IF IT DOESN'T EXIST
	if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
		
		$to = WP_PLUGIN_DIR . "/wp-easycart-data/";
		$from = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
		
		if( !is_writable( WP_PLUGIN_DIR ) ){
			
			// We really can't do anything now about the data folder. Lets try and get people to do this in the install page.
			
		}else{
			mkdir( $to, 0755 );
			
			// Now backup
			wpeasycart_copyr( $from . "products", $to . "products" );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/", 0751 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/", 0751 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/", 0755 );
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/", 0751 );
			
		}
	}
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/", 0751 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/", 0751 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/", 0755 );
	
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) )
		mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/", 0751 );
	// END CREATE DATA FOLDER IF IT DOESN'T EXIST
	
}

function ec_uninstall(){
	
	// Uninstall DB
	$db_manager = new ec_db_manager( );
	$db_manager->uninstall_db( );
	
	//delete options
	$wpoptions = new ec_wpoptionset();
	$wpoptions->delete_options();
	
	$data_dir = WP_PLUGIN_DIR . "/wp-easycart-data/";
	if( is_dir( $data_dir ) && !is_writable( $data_dir ) ){
		// Could not open the file, lets write it via ftp!
		$ftp_server = $_POST['hostname'];
		$ftp_user_name = $_POST['username'];
		$ftp_user_pass = $_POST['password'];
		
		// set up basic connection
		$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
		
		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		if( !$login_result ){
			
			die( "Could not connect to your server via FTP to uninstall your wp-easycart. Please remove the files manually." );
			
		}else{
			ec_delete_directory_ftp( $conn_id, $data_dir );
		}
	}else{
		ec_recursive_remove_directory( $data_dir );
	}
	
	// Clean up linking structure
	$store_posts = get_posts( array( 'post_type' => 'ec_store', 'posts_per_page' => 10000 ) );
	foreach( $store_posts as $store_post ) {
		wp_delete_post( $store_post->ID, true);
	}
}

function wpeasycart_update_check( ){
	// UPDATE OPTIONS IF NEEDED
	if( !get_option( 'ec_option_wpoptions_version' ) || get_option( 'ec_option_wpoptions_version' ) != EC_CURRENT_VERSION ){	
		$wpoptions = new ec_wpoptionset();
		$wpoptions->add_options();
		update_option( 'ec_option_wpoptions_version', EC_CURRENT_VERSION );
	}
	
	// UPGRADE THE DB IF NEEDED
	if( !get_option( 'ec_option_db_new_version' ) || EC_UPGRADE_DB != get_option( 'ec_option_db_new_version' ) ){
		$db_manager = new ec_db_manager( );
		$db_manager->install_db( );
		update_option( 'ec_option_is_installed', '1' );
	}
	
	// CHECK FOLDER SETUP EACH VERSION
	if( !get_option( 'ec_option_data_folders_installed' ) || EC_CURRENT_VERSION != get_option( 'ec_option_data_folders_installed' ) ){
		
		// CREATE DATA FOLDER IF IT DOESN'T EXIST
		if( !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
			
			$to = WP_PLUGIN_DIR . "/wp-easycart-data/";
			$from = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
			
			if( !is_writable( WP_PLUGIN_DIR ) ){
				// We really can't do anything now about the data folder. Lets try and get people to do this in the install page.
				
			}else{
				mkdir( $to, 0755 );
				
				// Now backup
				wpeasycart_copyr( $from . "products", $to . "products" );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/", 0751 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/", 0751 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/", 0755 );
				mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/", 0751 );
				
			}
		}
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/", 0751 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/", 0751 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/", 0755 );
		
		if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) && !is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) )
			mkdir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/", 0751 );
		// END CREATE DATA FOLDER IF IT DOESN'T EXIST
		update_option( 'ec_option_data_folders_installed', EC_CURRENT_VERSION );
		
	}

}
add_action( 'plugins_loaded', 'wpeasycart_update_check' );
register_activation_hook( __FILE__, 'ec_activate' );
register_uninstall_hook( __FILE__, 'ec_uninstall' );

function load_ec_pre(){
	
	// START STATS AND FORM PROCESSING
	$storepageid = get_option('ec_option_storepage');
	$cartpageid = get_option('ec_option_cartpage');
	$accountpageid = get_option('ec_option_accountpage');
	
	if( function_exists( 'icl_object_id' ) ){
		$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
		$cartpageid = icl_object_id( $cartpageid, 'page', true, ICL_LANGUAGE_CODE );
		$accountpageid = icl_object_id( $accountpageid, 'page', true, ICL_LANGUAGE_CODE );
	}
	
	$storepage = get_permalink( $storepageid );
	$cartpage = get_permalink( $cartpageid );
	$accountpage = get_permalink( $accountpageid );
			
	if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
		$https_class = new WordPressHTTPS( );
		$storepage = $https_class->makeUrlHttps( $storepage );
		$cartpage = $https_class->makeUrlHttps( $cartpage );
		$accountpage = $https_class->makeUrlHttps( $accountpage );
	}
	
	if(substr_count($storepage, '?'))							$permalinkdivider = "&";
	else														$permalinkdivider = "?";
	
	if( isset( $_SERVER['HTTPS'] ) )							$currentpageid = url_to_postid( "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	else														$currentpageid = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	
	if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_GET['error_description'] ) && get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" ){
		$db = new ec_db( );
		$db->insert_response( $_GET['order_id'], 1, "Dwolla Third Party", print_r( $_GET, true ) );
		header( "location: " . $accountpage . $permalinkdivider . "ec_page=order_details&order_id=" . $_GET['order_id'] . "&ec_error=dwolla_error" );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" && isset( $_GET['signature'] ) && isset( $_GET['checkoutId'] ) && isset( $_GET['amount'] ) ){
		
		$dwolla_verification = ec_dwolla_verify_signature( $_GET['signature'], $_GET['checkoutId'], $_GET['amount'] );
		if( $dwolla_verification ){
			global $wpdb;
			$db = new ec_db_admin( );
			$db->update_order_status( $_GET['order_id'], "10" );
				
			// send email
			$order_row = $db->get_order_row_admin( $_GET['order_id'] );
			$orderdetails = $db->get_order_details_admin( $_GET['order_id'] );
			
			/* Update Stock Quantity */
			foreach( $orderdetails as $orderdetail ){
				$product = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.* FROM ec_product WHERE ec_product.product_id = %d", $orderdetail->product_id ) );
				if( $product ){
					if( $product->use_optionitem_quantity_tracking )	
						$db->update_quantity_value( $orderdetail->quantity, $orderdetail->product_id, $orderdetail->optionitem_id_1, $orderdetail->optionitem_id_2, $orderdetail->optionitem_id_3, $orderdetail->optionitem_id_4, $orderdetail->optionitem_id_5 );
					$db->update_product_stock( $orderdetail->product_id, $orderdetail->quantity );
				}
			}
			
			$order_display = new ec_orderdisplay( $order_row, true );
			$order_display->send_email_receipt( );
			$order_display->send_gift_cards( );
						
			do_action( 'wpeasycart_order_paid', $this->order_id );
			
			header( "location: " . $cartpage . $permalinkdivider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
			
		}else{
			$db = new ec_db( );
			$db->insert_response( $_GET['order_id'], 1, "Dwolla Third Party", print_r( $_GET, true ) );
			header( "location: " . $accountpage . $permalinkdivider . "ec_page=order_details&order_id=" . $_GET['order_id'] . "&ec_error=dwolla_error" );
	
		}
	}
	
	/* Update the Menu and Product Statistics */
	if( isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$db->update_product_views( $_GET['model_number'] );
	}else if( isset( $_GET['menuid'] ) ){
		$db = new ec_db( );
		$db->update_menu_views( $_GET['menuid'] );	
	}else if( isset( $_GET['submenuid'] ) ){
		$db = new ec_db( );
		$db->update_submenu_views( $_GET['submenuid'] );	
	}else if( isset( $_GET['subsubmenuid'] ) ){
		$db = new ec_db( );
		$db->update_subsubmenu_views( $_GET['subsubmenuid'] );	
	}
	
	/* Cart Form Actions, Process Prior to WP Loading */
	if( isset( $_POST['ec_cart_form_action'] ) ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( $_POST['ec_cart_form_action'] );
	}else if( isset( $_GET['ec_cart_action'] ) ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( $_GET['ec_cart_action'] );	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "3dsecure" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "3dsecure" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "3ds" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "3ds" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "3dsprocess" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "3dsprocess" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "third_party" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "third_party_forward" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "realex_redirect" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "realex_redirect" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "realex_response" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "realex_response" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "process_affirm" ){
		$ec_cartpage = new ec_cartpage( true );
		$ec_cartpage->process_form_action( "submit_order" );
	}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "deconetwork_add_to_cart" ){
		$ec_cartpage = new ec_cartpage( true );
		$ec_cartpage->process_form_action( "deconetwork_add_to_cart" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "paymentexpress" ){
		$ec_cartpage = new ec_cartpage();
		$ec_cartpage->process_form_action( "paymentexpress_thirdparty_response" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "nets_return" && isset( $_GET['transactionId'] ) ){
		global $wpdb;
		$order_id = $wpdb->get_var( $wpdb->prepare( "SELECT ec_order.order_id FROM ec_order WHERE ec_order.nets_transaction_id = %s", $_GET['transactionId'] ) );
		
		$nets = new ec_nets( );
		$nets->process_payment_final( $order_id, $_GET['transactionId'], $_GET['responseCode'] );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "wp-easycart-sagepay-za" ){
		$sagepay_za = new ec_sagepay_paynow_za( );
		$sagepay_za->process_response( );
	}
	
	/* Account Form Actions, Process Prior to WP Loading */
	if( isset( $_POST['ec_account_form_action'] ) ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( $_POST['ec_account_form_action'] );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "logout" ){
		$ec_accountpage = new ec_accountpage();
		$ec_accountpage->process_form_action( "logout" );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "print_receipt" ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/scripts/print_receipt.php" );
		die( );
	
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "activate_account" && isset( $_GET['email'] ) && isset( $_GET['key'] ) ){
		$db = new ec_db( );
		$is_activated = $db->activate_user( $_GET['email'], $_GET['key'] );
		if( $is_activated ){
			header( "location: " . $account_page . $permalinkdivider . "ec_page=login&account_success=activation_success" );
		}else{
			header( "location: " . $account_page . $permalinkdivider . "ec_page=login&account_error=activation_error" );
		}
	}
	
	if( isset( $_GET['ec_add_to_cart'] ) ){
		$db = new ec_db( );
		$added_successfully = $db->quick_add_to_cart( $_GET['ec_add_to_cart'] );
		if( $added_successfully ){
			header( "location: " . $cartpage );
		}else{
			header( "location: " . $storepage . "?model_number=" . htmlspecialchars( $_GET['ec_add_to_cart'], ENT_QUOTES ) );
		}
	}else if( isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "addtocart" && isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$added_successfully = $db->quick_add_to_cart( $_GET['model_number'] );
		if( $added_successfully ){
			header( "location: " . $cartpage );
		}else{
			header( "location: " . $storepage . "?model_number=" . htmlspecialchars( $_GET['model_number'], ENT_QUOTES ) );
		}
	}
	
	/* Load abandoned cart */
	if( isset( $_GET['ec_load_tempcart'] ) && isset( $_GET['ec_load_email'] ) ){
		global $wpdb;
		$tempcart_row = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.session_id FROM ec_tempcart, ec_tempcart_data WHERE ec_tempcart.session_id = %s AND ec_tempcart_data.session_id = ec_tempcart.session_id AND ec_tempcart_data.email = %s", $_GET['ec_load_tempcart'], $_GET['ec_load_email'] ) );
		if( $tempcart_row ){
			$GLOBALS['ec_cart_id'] = $tempcart_row->session_id;
			$_SESSION['ec_cart_id'] = $GLOBALS['ec_cart_id'];
			setcookie( "ec_cart_id", "", time( ) - 3600 );
			setcookie( "ec_cart_id", "", time( ) - 3600, "/" );
			setcookie( 'ec_cart_id', $GLOBALS['ec_cart_id'], time( ) + ( 3600 * 24 * 1 ), "/" );
			$cart_page_id = get_option('ec_option_cartpage');
			if( function_exists( 'icl_object_id' ) )
				$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$cart_page = get_permalink( $cart_page_id );
			if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
				$https_class = new WordPressHTTPS( );
				$cart_page = $https_class->makeUrlHttps( $cart_page );
			}
			wp_redirect( $cart_page );
		}
	}
	
	/* Newsletter Form Actions */
	if( isset( $_POST['ec_newsletter_email'] ) ){
		
		if( isset( $_POST['ec_newsletter_name'] ) )
			$newsletter_name = $_POST['ec_newsletter_name'];
		else
			$newsletter_name = "";
		
		$ec_db = new ec_db();
		$ec_db->insert_subscriber( $_POST['ec_newsletter_email'], $newsletter_name, "" );
			
		// MyMail Hook
		if( function_exists( 'mymail' ) ){
			$subscriber_id = mymail('subscribers')->add( array(
				'email' => $_POST['ec_newsletter_email'],
				'name' => $newsletter_name,
				'status' => 1,
			), false );
		}
		
		do_action( 'wpeasycart_subscriber_added', $_POST['ec_newsletter_email'], $newsletter_name );
		
		setcookie( 'ec_newsletter_popup', 'hide', time( ) + ( 10 * 365 * 24 * 60 * 60 ), "/" );
	}
	
	/* Manual Hide Video */
	if( current_user_can( 'manage_options' ) && isset( $_GET['ec_admin_action'] ) && $_GET['ec_admin_action'] == "hide-video" ){
		update_option( 'ec_option_hide_design_help_video', '1' );
	}
	
	// END STATS AND FORM PROCESSING
	
	// FIX FOR PRODUCT LIST DROP DOWN
	if( !get_option( 'ec_option_product_filter_1' ) && !get_option( 'ec_option_product_filter_2' ) && !get_option( 'ec_option_product_filter_3' ) && !get_option( 'ec_option_product_filter_4' ) && !get_option( 'ec_option_product_filter_5') && !get_option( 'ec_option_product_filter_6') && !get_option( 'ec_option_product_filter_7' ) ){
		update_option( 'ec_option_product_filter_1', '1' );
		update_option( 'ec_option_product_filter_2', '1' );
		update_option( 'ec_option_product_filter_3', '1' );
		update_option( 'ec_option_product_filter_4', '1' );
		update_option( 'ec_option_product_filter_5', '1' );
		update_option( 'ec_option_product_filter_6', '1' );
		update_option( 'ec_option_product_filter_7', '1' );
	}
	// END FIX FOR PRODUCT LIST DROP DOWN
	
} // CLOSE PRE FUNCTION

function ec_custom_headers( ){
	if( isset( $_GET['order_id'] ) && isset( $_GET['orderdetail_id'] ) && isset( $_GET['download_id'] ) && $GLOBALS['ec_cart_data']->cart_data->user_id != "" ){
		$mysqli = new ec_db( );
		$orderdetail_row = $mysqli->get_orderdetail_row( $_GET['order_id'], $_GET['orderdetail_id'], $GLOBALS['ec_cart_data']->cart_data->user_id );
		$ec_orderdetail = new ec_orderdetail( $orderdetail_row, 1 );
	}
	
	if( isset( $_GET['ec_page'] ) && ( $_GET['ec_page'] == "checkout_payment" || $_GET['ec_page'] == "checkout_shipping" || $_GET['ec_page'] == "checkout_info" ) ){
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
	}
}

function ec_cache_management( ){
	if( get_option( 'ec_option_caching_on' ) ){
		// File does not exist at all
		if( !file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) ){
			ec_regenerate_css( );
			ec_regenerate_js( );
			update_option( 'ec_option_cached_date', time( ) );
		}
		
		// Use cache management system
		else if( get_option( 'ec_option_cache_update_period' ) ){
			
			$update_time = true;
			$new_time = time( );
			
			// Use a automatic cache builder and the last update has not been set
			if( get_option( 'ec_option_cache_update_period' ) && !get_option( 'ec_option_cached_date' ) ){
				ec_regenerate_css( );
				ec_regenerate_js( );
			}
			
			// Cache update daily
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 day") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update weekly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 week") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update monthly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 month") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Cache update yearly
			else if( get_option( 'ec_option_cache_update_period' ) == '1' && get_option( 'ec_option_cached_date' ) < strtotime("-1 year") ){
				ec_regenerate_css( );
				ec_regenerate_js( );				
			}
			
			// Do not update
			else{
				$update_time = false;
			}
			
			if( $update_time ){
				update_option( 'ec_option_cached_date', $new_time );
			}
		}
	}else{
		ec_regenerate_css( );
		ec_regenerate_js( );
		update_option( 'ec_option_cached_date', time( ) );
	}
}

function ec_css_loader_v3( ){
	
	$pageURL = 'http';
	if( isset( $_SERVER["HTTPS"] ) )
		$pageURL .= "s";
		
	if( current_user_can( 'manage_options' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.css' ) ){
			wp_register_style( 'wpeasycart_admin_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.css' ) );
		}else{
			wp_register_style( 'wpeasycart_admin_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/live-editor.css' ) );
		}
		wp_enqueue_style( 'wpeasycart_admin_css' );
	}
	
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.css' ) ){
		wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.css' ), array( ), EC_CURRENT_VERSION );
	}else{
		wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/ec-store.css' ), array( ), EC_CURRENT_VERSION );
	}
	wp_enqueue_style( 'wpeasycart_css' );
	
	wp_register_style( "wpeasycart_gfont", $pageURL . "://fonts.googleapis.com/css?family=Lato|Monda|Open+Sans|Droid+Serif" );
	wp_enqueue_style( 'wpeasycart_gfont' );
	
	if( get_option( 'ec_option_use_rtl' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' ) ){
			wp_register_style( 'wpeasycart_rtl_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/rtl_support.css' ) );
		}else{
			wp_register_style( 'wpeasycart_rtl_css', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/rtl_support.css' ) );
		}
		wp_enqueue_style( 'wpeasycart_rtl_css' );
	}

}

function ec_js_loader_v3( ){
		
	if( current_user_can( 'manage_options' ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.js' ) ){
			wp_enqueue_script( 'wpeasycart_admin_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/live-editor.js' ), array( 'jquery', 'jquery-ui-core' ), EC_CURRENT_VERSION );
		}else{
			wp_enqueue_script( 'wpeasycart_admin_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/live-editor.js' ), array( 'jquery', 'jquery-ui-core' ), EC_CURRENT_VERSION );
		}
	}
	
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/jquery.payment.min.js' ) ){
		wp_enqueue_script( 'payment_jquery_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/jquery.payment.min.js' ), array( 'jquery' ), EC_CURRENT_VERSION, false );
	}else{
		wp_enqueue_script( 'payment_jquery_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/jquery.payment.min.js' ), array( 'jquery' ), EC_CURRENT_VERSION, false );
	}
	
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.js' ) ){
		wp_enqueue_script( 'wpeasycart_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion' ), EC_CURRENT_VERSION, false );
	}else{
		wp_enqueue_script( 'wpeasycart_js', plugins_url( 'wp-easycart/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/ec-store.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion' ), EC_CURRENT_VERSION, false );
	}

}

function ec_regenerate_css( ){
	ob_start( "ec_save_css_file" );
	include( ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_css_generator.php' );
	ob_end_flush();
}

function ec_save_css_file( $buffer ){
	file_put_contents( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css", $buffer );
}

function ec_regenerate_js( ){
	if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_account_billing_information/" ) ){ //check to see if any of the old folders exist
		ob_start( "ec_save_js_file" );
		include( ABSPATH . "wp-content/plugins/" . EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_js_generator.php' );
		ob_end_flush();
	}
}

function ec_save_js_file( $buffer ){
	file_put_contents( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js", $buffer );
}

function ec_load_css( ){
	
	if( !get_option( 'ec_option_base_theme' ) || file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) || !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" ) ){
		ec_css_loader_v3( );
	
	}else{
		ec_cache_management( );
	
		if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) && filesize( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-css.css" ) ){
			// Load the cached file because it exists
			wp_register_style( 'wpeasycart_css', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-css.css' ) );
			wp_enqueue_style( 'wpeasycart_css' );
		
		}else{
			// File did not exist, revert back to the development mode loader
			wp_register_style( 'wpeasycart_css', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_css_loader.php' ) );
			wp_enqueue_style( 'wpeasycart_css' );
		}
		
		$gfont_list = "";
		$font_list = explode( ":::", get_option( 'ec_option_font_replacements' ) );
		$fonts_added = 0;
		
		for( $i=0; $i<count( $font_list ); $i++ ){
			$temp = explode( "=", $font_list[$i] );
			if(  	$temp[1] != "Verdana, Geneva, sans-serif" && 
					$temp[1] != "Georgia, Times New Roman, Times, serif" && 
					$temp[1] != "Courier New, Courier, monospace" && 
					$temp[1] != "Arial, Helvetica, sans-serif" && 
					$temp[1] != "Tahoma, Geneva, sans-serif" && 
					$temp[1] != "Trebuchet MS, Arial, Helvetica, sans-serif" && 
					$temp[1] != "Arial Black, Gadget, sans-serif" && 
					$temp[1] != "Times New Roman, Times, serif" && 
					$temp[1] != "Palatino Linotype, Book Antiqua, Palatino, serif" && 
					$temp[1] != "Lucida Sans Unicode, Lucida Grande, sans-serif" && 
					$temp[1] != "MS Serif, New York, serif" && 
					$temp[1] != "Lucida Console, Monaco, monospace" && 
					$temp[1] != "Comic Sans MS, cursive" &&
					$temp[1] != ""
			){
				if( $fonts_added > 0 )
					$gfont_list .= "|";
				
				$gfont_list .= $temp[1];
				$fonts_added++;
				
			}
		}
		
		if( $fonts_added > 0 ){
			$pageURL = 'http';
			if( isset( $_SERVER["HTTPS"] ) )
				$pageURL .= "s";
			
			wp_register_style( "wpeasycart_gfont", $pageURL . "://fonts.googleapis.com/css?family=" . $gfont_list );
			wp_enqueue_style( 'wpeasycart_gfont' );
		}
		
	}
	
}	

function ec_load_js( ){
	
	if( !get_option( 'ec_option_base_theme' ) || file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) || !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_image_not_found.jpg" ) ){
		ec_js_loader_v3( );
	
	}else{
		
		if( file_exists( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js" ) && filesize( ABSPATH . "wp-content/plugins/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec-store-js.js" ) ){
			// Load the cached file because it exists
			wp_register_script( 'wpeasycart_js', plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/ec-store-js.js' ), array( 'jquery' ) );
			wp_enqueue_script( 'wpeasycart_js' );
		
		}else{
			// File did not exist, revert back to the development mode loader
			wp_register_script( 'wpeasycart_js', plugins_url( EC_PLUGIN_DIRECTORY . '/inc/scripts/ec_js_loader.php' ), array( 'jquery' ) );
			wp_enqueue_script( 'wpeasycart_js' );
		}
		
	}
	
	$ajax_subfolder = "";
	if( file_exists( plugins_url( 'wp-easycart-data/ajax-subfolder.txt' ) ) ){
		$ajax_subfolder = file_get_contents( plugins_url( 'wp-easycart-data/ajax-subfolder.txt' ) );
	}
	
	$https_link = "";
	if( class_exists( "WordPressHTTPS" ) ){
		$https_class = new WordPressHTTPS( );
		if( $ajax_subfolder != "" ){
			$https_link = $https_class->getHttpsUrl() . $ajax_subfolder . '/wp-admin/admin-ajax.php';
		}else{
			$https_link = $https_class->makeUrlHttps( admin_url( 'admin-ajax.php' ) );
		}
	}else{
		$https_link = str_replace( "http://", "https://", str_replace( "/wp-admin", $ajax_subfolder . "/wp-admin", admin_url( 'admin-ajax.php' ) ) );
	}
	
	if( isset( $_SERVER['HTTPS'] ) && $_SERVER["HTTPS"] == "on" )
		wp_localize_script( 'wpeasycart_js', 'wpeasycart_ajax_object', array( 'ajax_url' => $https_link ) );
	else
		wp_localize_script( 'wpeasycart_js', 'wpeasycart_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	
}

function wpeasycart_seo_tags( ){
	
	global $wp_query;
	global $wpdb;
	
	/* Check for Post Content Shortcodes */
	$post_obj = $wp_query->get_queried_object();
	if( $post_obj && isset( $post_obj->post_content ) ){
		
		if( strstr( $post_obj->post_content, "[ec_store" ) && strstr( $post_obj->post_content, "modelnumber" ) ){
			$matches = array( );
			preg_match( '/\[ec_store modelnumber=\"(.*)?\"\]/', $post_obj->post_content, $matches );
			if( count( $matches ) >= 2 ){
				$model_number = $matches[1];
				$product_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.seo_keywords, ec_product.seo_description FROM ec_product WHERE ec_product.model_number = %s", $model_number ) );
				if( $product_seo->seo_description != "" )
					echo "<meta name=\"description\" content=\"" . $product_seo->seo_description . "\">\n";
				if( $product_seo->seo_keywords != "" )
					echo "<meta name=\"keywords\" content=\"" . $product_seo->seo_keywords . "\">\n";
			}
			ec_show_facebook_meta( $model_number );
		
		}else if( strstr( $post_obj->post_content, "[ec_store" ) && strstr( $post_obj->post_content, "menuid" ) ){
			$matches = array( );
			preg_match( '/\[ec_store menuid=\"(.*)?\"\]/', $post_obj->post_content, $matches );
			if( count( $matches ) >= 2 ){
				$menu_id = $matches[1];
				$menu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel1.seo_keywords, ec_menulevel1.seo_description FROM ec_menulevel1 WHERE ec_menulevel1.menulevel1_id = %d", $menu_id ) );
				if( $menu_seo->seo_description != "" )
					echo "<meta name=\"description\" content=\"" . $menu_seo->seo_description . "\">\n";
				if( $menu_seo->seo_keywords != "" )
					echo "<meta name=\"keywords\" content=\"" . $menu_seo->seo_keywords . "\">\n";
			}
		
		}else if( strstr( $post_obj->post_content, "[ec_store" ) && strstr( $post_obj->post_content, "submenuid" ) ){
			$matches = array( );
			preg_match( '/\[ec_store submenuid=\"(.*)?\"\]/', $post_obj->post_content, $matches );
			if( count( $matches ) >= 2 ){
				$submenu_id = $matches[1];
				$submenu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel2.seo_keywords, ec_menulevel2.seo_description FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = %d", $submenu_id ) );
				if( $submenu_seo->seo_description != "" )
					echo "<meta name=\"description\" content=\"" . $submenu_seo->seo_description . "\">\n";
				if( $submenu_seo->seo_keywords != "" )
					echo "<meta name=\"keywords\" content=\"" . $submenu_seo->seo_keywords . "\">\n";
			}
		
		}else if( strstr( $post_obj->post_content, "[ec_store" ) && strstr( $post_obj->post_content, "subsubmenuid" ) ){
			$matches = array( );
			preg_match( '/\[ec_store menuid=\"(.*)?\"\]/', $post_obj->post_content, $matches );
			if( count( $matches ) >= 2 ){
				$subsubmenu_id = $matches[1];
				$subsubmenu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel3.seo_keywords, ec_menulevel3.seo_description FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = %d", $subsubmenu_id ) );
				if( $subsubmenu_seo->seo_description != "" )
					echo "<meta name=\"description\" content=\"" . $subsubmenu_seo->seo_description . "\">\n";
				if( $subsubmenu_seo->seo_keywords != "" )
					echo "<meta name=\"keywords\" content=\"" . $subsubmenu_seo->seo_keywords . "\">\n";
			}
		}
	
	}
	
	/* Check for GET VARS */
	if( isset( $_GET['model_number'] ) ){
		$matches = array( );
		$model_number = $_GET['model_number'];
		$product_seo = wp_cache_get( 'wpeasycart-product-seo-'.$model_number, 'wpeasycart-product-seo' );
		if( !$product_seo ){
			$product_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.seo_keywords, ec_product.seo_description FROM ec_product WHERE ec_product.model_number = %s", $model_number ) );
			wp_cache_set( 'wpeasycart-product-seo-'.$model_number, $product_seo, 'wpeasycart-product-seo' );
		}
		if( $product_seo->seo_description != "" )
			echo "<meta name=\"description\" content=\"" . $product_seo->seo_description . "\">\n";
		if( $product_seo->seo_keywords != "" )
			echo "<meta name=\"keywords\" content=\"" . $product_seo->seo_keywords . "\">\n";
		ec_show_facebook_meta( $model_number );
		
	}else if( isset( $_GET['menuid'] ) ){
		$menu_id = $_GET['menuid'];
		$menu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel1.seo_keywords, ec_menulevel1.seo_description FROM ec_menulevel1 WHERE ec_menulevel1.menulevel1_id = %d", $menu_id ) );
		if( $menu_seo->seo_description != "" )
			echo "<meta name=\"description\" content=\"" . $menu_seo->seo_description . "\">\n";
		if( $menu_seo->seo_keywords != "" )
			echo "<meta name=\"keywords\" content=\"" . $menu_seo->seo_keywords . "\">\n";
	
	}else if( isset( $_GET['submenuid'] ) ){
		$submenu_id = $_GET['submenuid'];
		$submenu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel2.seo_keywords, ec_menulevel2.seo_description FROM ec_menulevel2 WHERE ec_menulevel2.menulevel2_id = %d", $submenu_id ) );
		if( $submenu_seo->seo_description != "" )
			echo "<meta name=\"description\" content=\"" . $submenu_seo->seo_description . "\">\n";
		if( $submenu_seo->seo_keywords != "" )
			echo "<meta name=\"keywords\" content=\"" . $submenu_seo->seo_keywords . "\">\n";
	
	}else if( isset( $_GET['subsubmenuid'] ) ){
		$subsubmenu_id = $_GET['subsubmenuid'];
		$subsubmenu_seo = $wpdb->get_row( $wpdb->prepare( "SELECT ec_menulevel3.seo_keywords, ec_menulevel3.seo_description FROM ec_menulevel3 WHERE ec_menulevel3.menulevel3_id = %d", $subsubmenu_id ) );
		if( $subsubmenu_seo->seo_description != "" )
			echo "<meta name=\"description\" content=\"" . $subsubmenu_seo->seo_description . "\">\n";
		if( $subsubmenu_seo->seo_keywords != "" )
			echo "<meta name=\"keywords\" content=\"" . $subsubmenu_seo->seo_keywords . "\">\n";
	
	}
	
	if( get_option( 'ec_option_use_affirm' ) && get_option( 'ec_option_affirm_public_key' ) != "" ){
		
		if( get_option( 'ec_option_affirm_sandbox_account' ) ){
			echo '<script>
			  var _affirm_config = {
				public_api_key:  "' . get_option( 'ec_option_affirm_public_key' ) . '",
				script:          "https://cdn1-sandbox.affirm.com/js/v2/affirm.js"
			  };
			  (function(l,g,m,e,a,f,b){var d,c=l[m]||{},h=document.createElement(f),n=document.getElementsByTagName(f)[0],k=function(a,b,c){return function(){a[b]._.push([c,arguments])}};c[e]=k(c,e,"set");d=c[e];c[a]={};c[a]._=[];d._=[];c[a][b]=k(c,a,b);a=0;for(b="set add save post open empty reset on off trigger ready setProduct".split(" ");a<b.length;a++)d[b[a]]=k(c,e,b[a]);a=0;for(b=["get","token","url","items"];a<b.length;a++)d[b[a]]=function(){};h.async=!0;h.src=g[f];n.parentNode.insertBefore(h,n);delete g[f];d(g);l[m]=c})(window,_affirm_config,"affirm","checkout","ui","script","ready");
			</script>';
		}else{
			echo '<script>
			  var _affirm_config = {
				public_api_key:  "' . get_option( 'ec_option_affirm_public_key' ) . '",
				script:          "https://cdn1.affirm.com/js/v2/affirm.js"
			  };
			  (function(l,g,m,e,a,f,b){var d,c=l[m]||{},h=document.createElement(f),n=document.getElementsByTagName(f)[0],k=function(a,b,c){return function(){a[b]._.push([c,arguments])}};c[e]=k(c,e,"set");d=c[e];c[a]={};c[a]._=[];d._=[];c[a][b]=k(c,a,b);a=0;for(b="set add save post open empty reset on off trigger ready setProduct".split(" ");a<b.length;a++)d[b[a]]=k(c,e,b[a]);a=0;for(b=["get","token","url","items"];a<b.length;a++)d[b[a]]=function(){};h.async=!0;h.src=g[f];n.parentNode.insertBefore(h,n);delete g[f];d(g);l[m]=c})(window,_affirm_config,"affirm","checkout","ui","script","ready");
			</script>';
		}
	}
	
}
	
function ec_show_facebook_meta( $model_number ){
	
	global $wpdb;
	$ec_db = new ec_db( );
	$product = wp_cache_get( 'wpeasycart-product-only-'.$model_number, 'wpeasycart-product-list' );
	if( !$product ){
		$product = $ec_db->get_product_list( $wpdb->prepare( " WHERE product.model_number = %s AND product.activate_in_store = 1", $model_number ), "", "", "", "wpeasycart-product-only-".$model_number );	
		wp_cache_set( "wpeasycart-product-only-".$model_number, $product, 'wpeasycart-product-list' );
	}
	if( count( $product ) > 0 )
		$product = $product[0];
	$product_id = $product['product_id'];
	$prod_title = $product['title'];
	$prod_model_number = $product['model_number'];
	$prod_description = $product['seo_description'];
	if( $prod_description == "" ){
		$prod_description = htmlspecialchars( $product['short_description'], ENT_QUOTES );
	}
	if( $prod_description == "" ){
		$prod_description = htmlspecialchars( $product['description'], ENT_QUOTES );
	}
	$prod_use_optionitem_images = $product['use_optionitem_images'];
	$prod_image = $product['image1'];
		
	if( $prod_use_optionitem_images ){
		$optimgs = $wpdb->get_results( $wpdb->prepare( "SELECT 
				optionitemimage.optionitemimage_id,
				optionitemimage.optionitem_id, 
				optionitemimage.product_id, 
				optionitemimage.image1, 
				optionitemimage.image2, 
				optionitemimage.image3, 
				optionitemimage.image4, 
				optionitemimage.image5,
				optionitem.optionitem_order
				
				FROM ec_optionitemimage as optionitemimage, ec_optionitem as optionitem

				WHERE 
				optionitemimage.product_id = %d AND
				optionitem.optionitem_id = optionitemimage.optionitem_id
				
                GROUP BY optionitemimage.optionitemimage_id
				
				ORDER BY
				optionitemimage.product_id,
				optionitem.optionitem_order", $product_id ) );
		if( count( $optimgs ) > 0 )
			$prod_image = $optimgs[0]->image1;
	}	
	
	remove_action('wp_head', 'rel_canonical');
	
	//this method places to early, before html tags open
	echo "\n";
	echo "<meta property=\"og:title\" content=\"" . $prod_title . "\" />\n"; 
	echo "<meta property=\"og:type\" content=\"product\" />\n";
	echo "<meta property=\"og:description\" content=\"" . ec_short_string($prod_description, 300) . "\" />\n";
	echo "<meta property=\"og:image\" content=\"" .  plugin_dir_url( "" ) . "wp-easycart-data/products/pics1/" . $prod_image . "\" />\n"; 
	list( $width, $height ) = getimagesize( WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/" . $prod_image );
	echo "<meta property=\"og:image:width\" content=\"" . $width . "\" />\n";
	echo "<meta property=\"og:image:height\" content=\"" . $height . "\" />\n";
	echo "<meta property=\"og:url\" content=\"" . ec_curPageURL() . "\" /> \n";
	
}

function ec_theme_head_data( ){
	$GLOBALS['ec_page_options'] = new ec_page_options( );
	
	if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){
		include( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" );

	}else if( file_exists( WP_PLUGIN_DIR . "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/head_content.php" ) ){
		include( WP_PLUGIN_DIR . "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/head_content.php" );
		
	}
}
	
function ec_curPageURL() {
	$pageURL = 'http';
	if( isset( $_SERVER["HTTPS"] ) )
		$pageURL .= "s";

	$pageURL .= "://";
	if( $_SERVER["SERVER_PORT"] != "80" )
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].htmlspecialchars ( $_SERVER["REQUEST_URI"], ENT_QUOTES );
	else
		$pageURL .= $_SERVER["SERVER_NAME"].htmlspecialchars ( $_SERVER["REQUEST_URI"], ENT_QUOTES );

	return $pageURL;
}

function ec_short_string($text, $length){
	$text = strip_tags( $text );
	if( strlen( $text ) > $length )
		$text = substr($text, 0, strpos($text, ' ', $length));
	
	return $text;
}

//[ecstore]
function load_ec_store( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'menuid' => 'NOMENU',
		'submenuid' => 'NOSUBMENU',
		'subsubmenuid' => 'NOSUBSUBMENU',
		'manufacturerid' => 'NOMANUFACTURER',
		'groupid' => 'NOGROUP',
		'modelnumber' => 'NOMODELNUMBER',
		'language' => 'NONE'
	), $atts ) );
	
	if( $language != 'NONE' ){
		$GLOBALS['language'] = new ec_language( $language );
	}
	
	$GLOBALS['ec_store_shortcode_options'] = array( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	
	ob_start();
    $store_page = new ec_storepage( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	$store_page->display_store_page();
    return ob_get_clean();

}

//[eccart]
function load_ec_cart( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'language' => 'NONE'
	), $atts ) );
	
	if( $language != 'NONE' ){
		$GLOBALS['language'] = new ec_language( $language );
	}
	
	ob_start( );
	$cart_page = new ec_cartpage( );
	$cart_page->display_cart_page( );
	return ob_get_clean( );
}

//[ecaccount]
function load_ec_account( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'language' => 'NONE',
		'redirect' => false
	), $atts ) );
	
	if( $language != 'NONE' ){
		$GLOBALS['language'] = new ec_language( $language );
	}
	
	ob_start( );
    $account_page = new ec_accountpage( $redirect );
	if( isset( $_POST['ec_form_action'] ) )
		$account_page->process_form_action( $_POST['ec_form_action'] );	
	else
		$account_page->display_account_page( );
    return ob_get_clean();
}

//[ec_product]
function load_ec_product( $atts ){
	extract( shortcode_atts( array(
		'model_number' => 'NOPRODUCT',
		'productid' => 'NOPRODUCTID',
		'columns' => '3',
		'margin' => '45px',
		'width' => '175px',
		'minheight' => '375px',
		'imagew' => '140px',
		'imageh' => '140px',
		'style' => '1'
	), $atts ) );
	$simp_product_id = $model_number;
	ob_start( );
    $mysqli = new ec_db( );
	if( $model_number != "NOPRODUCT" ){
		$products = $mysqli->get_product_list( " WHERE product.model_number = '" . $model_number . "'", "", "", "" );
	}else{
		$product_ids = explode( ',', $productid );
		$product_where = " WHERE ";
		$product_order = " ORDER BY ";
		$ids = 0;
		foreach( $product_ids as $product_id ){
			if( $ids > 0 ){
				$product_where .= " OR ";
				$product_order .= ", ";
			}
			$product_where .= "product.product_id = " . $product_id;
			$product_order .= "product.product_id = " . $product_id . " DESC";
			$ids++;
		}
		$products = $mysqli->get_product_list( $product_where, $product_order, "", "" );
	}
	if( count( $products ) > 0 ){
		
		$cart_page_id = get_option('ec_option_cartpage');
		if( function_exists( 'icl_object_id' ) ){
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		$cart_page = get_permalink( $cart_page_id );
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$cart_page = $https_class->makeUrlHttps( $cart_page );
		}
		
		echo "<div class=\"ec_product_shortcode\" style=\"float:left; width:100%;\"><div class=\"ec_product_added_to_cart\"><div class=\"ec_product_added_icon\"></div><a href=\"" . $cart_page . "\" title=\"View Cart\">" . $GLOBALS['language']->get_text( "product_page", "product_view_cart" ) . "</a> " . $GLOBALS['language']->get_text( "product_page", "product_product_added_note" ) . "</div><div id=\"ec_current_media_size\"></div><ul class=\"ec_productlist_ul\" style=\"list-style:none; margin: 0px; float:left; width:100%; min-height:" . $minheight . ";\">";
		
		for( $prod_index=0; $prod_index<count( $products ); $prod_index++ ){
			$product = new ec_product( $products[$prod_index], 0, 0, 1 );
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
				if( $prod_index%$columns == $columns-1 ){
					echo "<li style=\"float:right;\">";
				}else{
					echo "<li style=\"float:left; margin-right:" . $margin . ";\">";
				}
			}
			
			if( $style == '1' ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' ) )
					include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product.php' );
				else
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_product.php' );
			
			}else if( $style == '2' ){
				if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_widget.php' ) )
					include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_product_widget.php' );
				else
					include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_product_widget.php' );
				
			}else{
				echo "<a href=\"" . $product->get_product_link( ) . "\">";
				echo "<img src=\"" . $product->get_product_single_image( ) . "\" alt=\"" . $product->title . "\" width=\"" . $imagew . "\" height=\"" . $imageh . "\">";
				echo "</a>";
				echo "<h3><a href=\"" . $product->get_product_link( ) . "\">" . $product->title . "</a></h3>";
				echo "<span class=\"ec_price_button\" style=\"width:" . $width . "\">";
				if( $product->has_sale_price( ) ){
					echo "<span class=\"ec_price_before\"><del>" . $product->get_formatted_before_price( ) . "</del></span>";
					echo "<span class=\"ec_price_sale\">" . $product->get_formatted_price( ) . "</span>";
				}else{
					echo "<span class=\"ec_price\">" . $product->get_formatted_price( ) . "</span>";
				}
				echo "</span>";
			}
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
				echo "</li>";
			}
		}
		echo "</ul><div style=\"clear:both;\"></div></div>";
	}
    return ob_get_clean( );
}

//[ec_addtocart]
function load_ec_addtocart( $atts ){
	extract( shortcode_atts( array(
		'productid' => 'NOPRODUCTID'
	), $atts ) );
	ob_start( );
	$mysqli = new ec_db( );
	$products = $mysqli->get_product_list( " WHERE product.product_id = " . $productid, "", "", "" );
	if( count( $products ) > 0 ){
		$product = new ec_product( $products[0], 0, 1, 1 );
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_add_to_cart_shortcode.php' ) )
			include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_add_to_cart_shortcode.php' );
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_add_to_cart_shortcode.php' );
	}
    return ob_get_clean( );
}

//[ec_cartdisplay]
function load_ec_cartdisplay( $atts ){
	
	ob_start( );
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cartdisplay_shortcode.php' ) )
		include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cartdisplay_shortcode.php' );
	else
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cartdisplay_shortcode.php' );
	
    return ob_get_clean( );
}

//[ec_membership productid=''][/ec_membership]
function load_ec_membership( $atts, $content = NULL ){
	extract( shortcode_atts( array(
		'productid' => '',
		'userroles' => ''
	), $atts ) );
	
	if( current_user_can( 'manage_options' ) ){
		
		return "<h4>MEMBER AND NON MEMBER CONTENT SHOWN TO ADMIN USER</h4><hr />" . do_shortcode( $content ) . "<hr />";
		
	}else if( $GLOBALS['ec_user']->user_id ){
		
		$db = new ec_db( );
		$is_member = false;
		
		if( $productid != '' ){
			$is_member = $db->has_membership_product_ids( $productid );
			
		}
		
		if( $userroles != '' ){
			$user_role_array = explode( ',', $userroles );
			
			if( in_array( $GLOBALS['ec_user']->user_level, $user_role_array ) )
				$is_member = true;
			
		}
		
		if( $is_member )
			return do_shortcode( $content );
			
		else
			return "";
		
	}
	
}

//[ec_membership_alt productid=''][/ec_membership_alt]
function load_ec_membership_alt( $atts, $content = NULL ){
	extract( shortcode_atts( array(
		'productid' => '',
		'userroles' => ''
	), $atts ) );
	
	if( current_user_can( 'manage_options' ) ){
		
		return "<h4>NON-MEMBER CONTENT (WORDPRESS ADMIN DISPLAY ONLY)</h4><hr />" . do_shortcode( $content ) . "<hr />";
		
	}else if( $GLOBALS['ec_user']->user_id ){
	
		$db = new ec_db( );
		$is_member = false;
		
		if( $productid != '' ){
			$is_member = $db->has_membership_product_ids( $productid );
			
		}
		
		if( $userroles != '' ){
			$user_role_array = explode( ',', $userroles );
			
			if( in_array( $GLOBALS['ec_user']->user_level, $user_role_array ) )
				$is_member = true;
			
		}
		
	
		if( !$is_member )
			return do_shortcode( $content );
			
		else
			return "";
		
	}else{
	
		return do_shortcode( "[ec_account redirect='" . get_the_ID( ) . "']" ) . do_shortcode( $content );
	
	}
	
}

//[ec_store_table]
function load_ec_store_table_display( $atts ){
	
	global $wpdb;
	
	extract( shortcode_atts( array(
		'productid' => '',
		'menuid' => '',
		'submenuid' => '',
		'subsubmenuid' => '',
		'categoryid' => '',
		'labels' => 'Model Number,Product Name,Price,',
		'columns' => 'model_number,title,price,details_link',
		'view_details' => 'VIEW DETAILS'
	), $atts ) );
	
	$label_start = explode( ",", $labels );
	$columns_start = explode( ",", $columns );
	
	$columns = array( );
	$labels = array( );
	
	for( $k=0; $k<count($columns_start); $k++ ){
		if( $columns_start[$k] != '0' ){
			$columns[] = $columns_start[$k];
			$labels[] = $label_start[$k];
		}
	}
	
	$storepageid = get_option('ec_option_storepage');
	
	if( function_exists( 'icl_object_id' ) ){
		$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
	}
	
	$storepage = get_permalink( $storepageid );
			
	if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
		$https_class = new WordPressHTTPS( );
		$storepage = $https_class->makeUrlHttps( $storepage );
	}
	
	if(substr_count($storepage, '?'))							$permalink_divider = "&";
	else														$permalink_divider = "?";
	
	$product_ids = array( );
	$menu_ids = array( );
	$submenu_ids = array( );
	$subsubmenu_ids = array( );
	$category_ids = array( );
	
	if( $productid != '' ){
		$product_ids = explode( ",", $productid );
	}
	
	if( $menuid != '' ){
		$menu_ids = explode( ",", $menuid );
	}
	
	if( $submenuid != '' ){
		$submenu_ids = explode( ",", $submenuid );
	}
	
	if( $subsubmenuid != '' ){
		$subsubmenu_ids = explode( ",", $subsubmenuid );
	}
	
	if( $categoryid != '' ){
		$category_ids = explode( ",", $categoryid );
	}
	
	$has_added_to_where = false;
	$where_query = "";
	if( count( $product_ids ) > 0 || 
		count( $menu_ids ) > 0 || 
		count( $submenu_ids ) > 0 || 
		count( $subsubmenu_ids ) > 0 || 
		count( $category_ids ) > 0 ){
		
		$where_query = " WHERE";
				
	}
	
	if( count( $product_ids ) > 0 ){
		if( !$has_added_to_where )
			$where_query .= " (";
		else
			$where_query .= " OR (";
		
		for( $i=0; $i<count( $product_ids ); $i++ ){
			if( $i > 0 )
				$where_query .= " OR";
			$where_query .= $wpdb->prepare( " product.product_id = %d", $product_ids[$i] );
		}
		$where_query .= ")";
		$has_added_to_where = true;
	}
	
	if( count( $menu_ids ) > 0 ){
		if( !$has_added_to_where )
			$where_query .= " (";
		else
			$where_query .= " OR (";
		
		for( $i=0; $i<count( $menu_ids ); $i++ ){
			if( $i > 0 )
				$where_query .= " OR";
			
			$where_query .= $wpdb->prepare( " ( product.menulevel1_id_1 = %d OR product.menulevel2_id_1 = %d OR product.menulevel3_id_1 = %d )", $menu_ids[$i], $menu_ids[$i], $menu_ids[$i] );
		}
		$where_query .= ")";
		$has_added_to_where = true;
	}
	
	if( count( $submenu_ids ) > 0 ){
		if( !$has_added_to_where )
			$where_query .= " (";
		else
			$where_query .= " OR (";
		
		for( $i=0; $i<count( $submenu_ids ); $i++ ){
			if( $i > 0 )
				$where_query .= " OR";
			
			$where_query .= $wpdb->prepare( " ( product.menulevel1_id_2 = %d OR product.menulevel2_id_2 = %d OR product.menulevel3_id_2 = %d )", $submenu_ids[$i], $submenu_ids[$i], $submenu_ids[$i] );
		}
		$where_query .= ")";
		$has_added_to_where = true;
	}
	
	if( count( $subsubmenu_ids ) > 0 ){
		if( !$has_added_to_where )
			$where_query .= " (";
		else
			$where_query .= " OR (";
		
		for( $i=0; $i<count( $subsubmenu_ids ); $i++ ){
			if( $i > 0 )
				$where_query .= " OR";
			
			$where_query .= $wpdb->prepare( " ( product.menulevel1_id_3 = %d OR product.menulevel2_id_3 = %d OR product.menulevel3_id_3 = %d )", $subsubmenu_ids[$i], $subsubmenu_ids[$i], $subsubmenu_ids[$i] );
		}
		$where_query .= ")";
		$has_added_to_where = true;
	}
	
	if( count( $category_ids ) > 0 ){
		if( !$has_added_to_where )
			$where_query .= " (";
		else
			$where_query .= " OR (";
		
		for( $i=0; $i<count( $category_ids ); $i++ ){
			if( $i > 0 )
				$where_query .= " OR";
			
			$where_query .= $wpdb->prepare( " ec_categoryitem.category_id = %d", $category_ids[$i] );
		}
		$where_query .= ")";
		$has_added_to_where = true;
	}
	$order_query = " ORDER BY product.title ASC";
	$limit_query = "";
	$session_id = $GLOBALS['ec_cart_id'];
	
	$db = new ec_db( );
	$products = $db->get_product_list( $where_query, $order_query, $limit_query, $session_id  );
	
	ob_start( );
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_store_table_display.php' ) )
		include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_store_table_display.php' );
	else
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_store_table_display.php' );
	
    return ob_get_clean( );
}

//[ec_category_view]
function load_ec_category_view( $atts ){
	
	extract( shortcode_atts( array(
		'parentid' => '0',
		'columns' => 2
	), $atts ) );
	
	ob_start( );
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_category_view.php' ) )
		include( WP_PLUGIN_DIR . "/" . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_category_view.php' );
	else
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_category_view.php' );
	
    return ob_get_clean( );
	
}

//[ec_categories]
function load_ec_categories( $atts ){
	
	if( !defined( 'DONOTCACHEPAGE' ) )
		define( "DONOTCACHEPAGE", true );
	
	if( !defined( 'DONOTCDN' ) )
		define('DONOTCDN', true);
	
	extract( shortcode_atts( array(
		'menuid' => 'NOMENU',
		'submenuid' => 'NOSUBMENU',
		'subsubmenuid' => 'NOSUBSUBMENU',
		'manufacturerid' => 'NOMANUFACTURER',
		'groupid' => 'NOGROUP',
		'modelnumber' => 'NOMODELNUMBER',
		'language' => 'NONE'
	), $atts ) );
	
	if( $language != 'NONE' ){
		$GLOBALS['language'] = new ec_language( $language );
	}
	
	$GLOBALS['ec_store_shortcode_options'] = array( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	
	ob_start();
    $store_page = new ec_storepage( $menuid, $submenuid, $subsubmenuid, $manufacturerid, $groupid, $modelnumber );
	$store_page->display_category_page();
    return ob_get_clean();
	
}

function ec_plugins_loaded( ){
	/* Admin Form Actions */
	if( current_user_can('manage_options') && isset( $_GET['ec_action'] ) && isset( $_GET['ec_language'] ) && $_GET['ec_action'] == "export-language" ){
		$language = new ec_language( );
		$language->export_language( $_GET['ec_language'] );
		die( );
	}
}

function ec_footer_load( ){
	if( get_option( 'ec_option_enable_newsletter_popup' ) && !isset( $_COOKIE['ec_newsletter_popup'] ) ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_newsletter_popup.php' ) )	
			include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_newsletter_popup.php' );
		else
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_newsletter_popup.php' );
		
	}
}

add_action( 'wp', 'load_ec_pre' );
add_action( 'wp_enqueue_scripts', 'ec_load_css' );
add_action( 'wp_enqueue_scripts', 'ec_load_js' );
add_action( 'send_headers', 'ec_custom_headers' );
add_action( 'plugins_loaded', 'ec_plugins_loaded' );
add_action( 'wp_footer', 'ec_footer_load' );

add_shortcode( 'ec_store', 'load_ec_store' );
add_shortcode( 'ec_cart', 'load_ec_cart' );
add_shortcode( 'ec_account', 'load_ec_account' );
add_shortcode( 'ec_product', 'load_ec_product' );
add_shortcode( 'ec_addtocart', 'load_ec_addtocart' );
add_shortcode( 'ec_cartdisplay', 'load_ec_cartdisplay' );
add_shortcode( 'ec_membership', 'load_ec_membership' );
add_shortcode( 'ec_membership_alt', 'load_ec_membership_alt' );
add_shortcode( 'ec_store_table', 'load_ec_store_table_display' );
add_shortcode( 'ec_category_view', 'load_ec_category_view' );
add_shortcode( 'ec_categories', 'load_ec_categories' );

add_filter( 'widget_text', 'do_shortcode');

add_action( 'wp_head', 'wpeasycart_seo_tags' );
add_action('wp_head', 'ec_theme_head_data');
add_action( 'wp_head', 'wpeasycart_order_completed' );
function wpeasycart_order_completed( ){
	// Checkout Success Check.
	if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" && isset( $_GET['order_id'] ) ){
		// Try and get order and run action
		$ec_db = new ec_db_admin( );
		$order_id = $_GET['order_id'];
		if( $GLOBALS['ec_cart_data']->cart_data->is_guest ){
			$order_row = $ec_db->get_guest_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->guest_key );
		}else{
			$order_row = $ec_db->get_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
		}
		if( $order_row ){ // order found and valid for user
			$order = new ec_orderdisplay( $order_row, true );
			do_action( 'wpeasycart_order_success_pre', $order_id, $order_row, $order->orderdetails );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'ec_load_dashicons' );
function ec_load_dashicons() {
    wp_enqueue_style( 'dashicons' );
}

//////////////////////////////////////////////
//UPDATE FUNCTIONS
//////////////////////////////////////////////

function wpeasycart_copyr( $source, $dest ){
    
	// Check for symlinks
    if( is_link( $source ) ){
        return symlink( readlink( $source ), $dest );
    }

    // Simple copy for a file
    if( is_file( $source ) ){
		$success = copy( $source, $dest );
		if( $success ){
 	       return true;
		}else{
			$err_message = "wpeasycart - error backing up " . $source . ". Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
	}

    // Make destination directory
    if ( !is_dir( $dest ) ){
        $success = mkdir( $dest, 0755 );
		if( !$success ){
			$err_message = "wpeasycart - error creating backup directory: " . $dest . ". Updated halted.";
			error_log( $err_message );
			exit( $err_message );
		}
    }

    // Loop through the folder
    $dir = dir( $source );
    while( false !== $entry = $dir->read( ) ){
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        wpeasycart_copyr( "$source/$entry", "$dest/$entry" ); // <------- defines wpeasycart copy action
    }

    // Clean up
    $dir->close( );
    return true;
}

function wpeasycart_backup( ){
	// Test for data folder
	if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/" ) ){
		echo "YOU DO NOT HAVE A WP EASYCART DATA FOLDER, PLEASE <a href=\"http://www.wpeasycart.com/plugin-update-help/\" target=\"_blank\">CLICK HERE TO READ HOW TO PREVENT DATA LOSS DURING THE UPDATE</a>";
		die( );
	}
}

function ec_recursive_remove_directory( $directory, $empty=FALSE ) {
     // if the path has a slash at the end we remove it here
     if( substr( $directory, -1 ) == '/' )
         $directory = substr( $directory, 0, -1);
  
     // if the path is not valid or is not a directory ...
     if( !file_exists( $directory ) || !is_dir( $directory ) )
         return FALSE;
  
     // ... if the path is not readable
     elseif(!is_readable($directory))
         return FALSE;
  
     // ... else if the path is readable
     else{
  
         // we open the directory
         $handle = opendir( $directory );
  
         // and scan through the items inside
         while( FALSE !== ( $item = readdir( $handle ) ) ){
             // if the filepointer is not the current directory
             // or the parent directory
             if( $item != '.' && $item != '..' ){
                 // we build the new path to delete
                 $path = $directory . '/' . $item;
  
                 // if the new path is a directory
                 if( is_dir( $path ) ){
                     // we call this function with the new path
                    ec_recursive_remove_directory( $path );

                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink( $path );
                 }
             }
         }
         // close the directory
         closedir( $handle );
		  
         // if the option to empty is not set to true
         if( $empty == FALSE ){
             // try to delete the now empty directory
             if( !rmdir( $directory ) ){
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
    }
}
 
function ec_delete_directory_ftp( $resource, $path ) {
    $result_message = "";
    $list = ftp_nlist( $resource, $path );
	
	if ( empty($list) ) {
        $list = ec_ran_list_n( ftp_rawlist($resource, $path), $path . ( substr($path, strlen($path) - 1, 1) == "/" ? "" : "/" ) );
    }
    if ($list[0] != $path) {
        $path .= ( substr($path, strlen($path)-1, 1) == "/" ? "" : "/" );
        foreach ($list as $item) {
			if ($item != $path.".." && $item != $path.".") {
				$result_message .= ec_delete_directory_ftp($resource, $item);
			}
        }
        if (ftp_rmdir ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    else {
		$res = ftp_site( $resource, 'CHMOD 0777 ' . $path );
        if (ftp_delete ($resource, $path)) {
            $result_message .= "Successfully deleted $path <br />\n";
        } else {
            $result_message .= "There was a problem while deleting $path <br />\n";
        }
    }
    return $result_message;
}

function ec_ran_list_n($rawlist, $path) {
    $array = array();
    foreach ($rawlist as $item) {
        $filename = trim(substr($item, 55, strlen($item) - 55));
        if ($filename != "." || $filename != "..") {
        $array[] = $path . $filename;
        }
    }
    return $array;
}

add_filter( 'upgrader_pre_install', 'wpeasycart_backup', 10, 2 );

//////////////////////////////////////////////
//END UPDATE FUNCTIONS
//////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
//AJAX SETUP FUNCTIONS
/////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_ec_ajax_get_optionitem_quantities', 'ec_ajax_get_optionitem_quantities' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_optionitem_quantities', 'ec_ajax_get_optionitem_quantities' );
function ec_ajax_get_optionitem_quantities( ){
	
	$db = new ec_db( );
	
	$product_id = $_POST['product_id'];
	$optionitem_id_1 = $_POST['optionitem_id_1'];
	
	if( isset( $_POST['optionitem_id_2'] ) )
		$optionitem_id_2 = $_POST['optionitem_id_2'];
	else{
		$quantity_values = $db->get_option2_quantity_values( $product_id, $optionitem_id_1 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	if( isset( $_POST['optionitem_id_3'] ) )
		$optionitem_id_3 = $_POST['optionitem_id_3'];
	else{
		$quantity_values = $db->get_option3_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	if( isset( $_POST['optionitem_id_4'] ) )
		$optionitem_id_4 = $_POST['optionitem_id_4'];
	else{
		$quantity_values = $db->get_option4_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3 );
		echo json_encode( $quantity_values );
		
		die( );
	}
	
	
	$quantity_values = $db->get_option5_quantity_values( $product_id, $optionitem_id_1, $optionitem_id_2, $optionitem_id_3, $optionitem_id_4 );
	echo json_encode( $quantity_values );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_add_to_cart', 'ec_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_ec_ajax_add_to_cart', 'ec_ajax_add_to_cart' );
function ec_ajax_add_to_cart( ){
	
	$product_id = $_POST['product_id'];
	$model_number = $_POST['model_number'];
	$quantity = $_POST['quantity'];
	$db = new ec_db( );
	
	$tempcart = $db->add_to_cart( $product_id, $GLOBALS['ec_cart_data']->ec_cart_id, $quantity, 0, 0, 0, 0, 0, "", "", "", 0.00, false, 1 );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	$cart_arr = array( );
	$total_items = 0;
	$total_cost = 0;
	
	foreach( $tempcart as $item ){
		$cart_arr[] = array( 'title' => $item->title, 'price' => $GLOBALS['currency']->get_currency_display( $item->unit_price ), 'quantity' => $item->quantity );
		$total_items = $total_items + $item->quantity;
		$total_cost = $total_cost + ( $item->quantity * $item->unit_price );
	}
	$cart_arr[0]['total_items'] = $total_items;
	$cart_arr[0]['total_price'] = $GLOBALS['currency']->get_currency_display( $total_cost );
	echo json_encode( $cart_arr );
	
	die( );
}

add_action( 'wp_ajax_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_update', 'ec_ajax_cartitem_update' );
function ec_ajax_cartitem_update( ){
	
	// UPDATE CART ITEM
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $GLOBALS['ec_cart_data']->ec_cart_id;
	$quantity = $_POST['quantity'];
	
	if( is_numeric( $quantity ) ){
		$db = new ec_db();
		$db->update_cartitem( $tempcart_id, $session_id, $quantity );
		wp_cache_flush( );
		do_action( 'wpeasycart_cart_updated' );
	}
	// UPDATE CART ITEM
	
	// GET NEW CART ITEM INFO
	if( isset( $_POST['ec_v3_24'] ) ){
		$return_array = ec_get_cart_data( );
								
		echo json_encode( $return_array );
	}else{
		$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
		
		$unit_price = 0;
		$total_price = 0;
		$new_quantity = 0;
		for( $i=0; $i<count( $cart->cart ); $i++ ){
			if( $cart->cart[$i]->cartitem_id == $tempcart_id ){
				$unit_price = $cart->cart[$i]->unit_price;
				$total_price = $cart->cart[$i]->total_price;
				$new_quantity = $cart->cart[$i]->quantity;
			}
		}
		// GET NEW CART ITEM INFO
		$order_totals = ec_get_order_totals( $cart );
		
		echo $GLOBALS['currency']->get_currency_display( $unit_price ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $total_price ) . "***" . 
				$new_quantity . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" .  
				$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" .
				$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
				
		if( $cart->total_items > 0 ){
			
			if( $cart->total_items != 1 ){
				$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
			}else{
				$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
			}
			
			echo "***" . $cart->total_items . ' ' . $items_label . ' ' . $GLOBALS['currency']->get_currency_display( $cart->subtotal );
		}else{
			echo "***" . $cart->total_items . ' ' . $items_label;
		}
		echo "***" . $cart->total_items;
	}
	
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
add_action( 'wp_ajax_nopriv_ec_ajax_cartitem_delete', 'ec_ajax_cartitem_delete' );
function ec_ajax_cartitem_delete( ){
	
	//Get the variables from the AJAX call
	$tempcart_id = $_POST['cartitem_id'];
	$session_id = $GLOBALS['ec_cart_data']->ec_cart_id;
	
	// DELTE CART ITEM
	$db = new ec_db();
	$ret_data = $db->delete_cartitem( $tempcart_id, $session_id );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	// GET NEW CART ITEM INFO
	if( isset( $_POST['ec_v3_24'] ) ){
		$return_array = ec_get_cart_data( );
								
		echo json_encode( $return_array );
	}else{
		$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
		$order_totals = ec_get_order_totals( $cart );
		
		echo $cart->total_items . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" .  
				$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
				$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" .
				$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
			
		if( $cart->total_items != 1 ){
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
		}else{
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
		}
		
		if( $cart->total_items > 0 ){
			echo "***" . $cart->total_items . ' ' . $items_label . ' ' . $GLOBALS['currency']->get_currency_display( $cart->subtotal );
		
		}else{
			echo "***" . $cart->total_items . ' ' . $items_label;
		
		}
		echo "***" . $cart->total_items;
	}
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_coupon_code', 'ec_ajax_redeem_coupon_code' );
function ec_ajax_redeem_coupon_code( ){
	
	//UPDATE COUPON CODE
	$coupon_code = "";
	if( isset( $_POST['couponcode'] ) ){
		$coupon_code = $_POST['couponcode'];
		$GLOBALS['ec_cart_data']->cart_data->coupon_code = $coupon_code;
	}
	
	$GLOBALS['ec_cart_data']->save_session_to_db( );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	$coupon = $GLOBALS['ec_coupons']->redeem_coupon_code( $coupon_code );
	
	// UPDATE COUPON CODE
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$order_totals = ec_get_order_totals( $cart );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $coupon ){
		if( $coupon && !$coupon->coupon_expired && ( $coupon->max_redemptions == 999 || $coupon->times_redeemed < $coupon->max_redemptions ) ){
			echo "***" . $coupon->message . "***" . "valid";
			$GLOBALS['ec_cart_data']->cart_data->coupon_code = $coupon_code;
		
		}else if( $coupon && $coupon->times_redeemed >= $coupon->max_redemptions ){
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_max_exceeded_coupon' ) . "***" . "invalid";
			$GLOBALS['ec_cart_data']->cart_data->coupon_code = "";
		
		}else if( $coupon->coupon_expired ){
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_expired' ) . "***" . "invalid";
			$GLOBALS['ec_cart_data']->cart_data->coupon_code;
			
		}else{
			echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' ) . "***" . "invalid";
			$GLOBALS['ec_cart_data']->cart_data->coupon_code;
		}
	}else{
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' ) . "***" . "invalid";
		$GLOBALS['ec_cart_data']->cart_data->coupon_code;
	}
		
	if( $order_totals->discount_total == 0 )
		echo "***0";
	else
		echo "***1";
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_subscription_coupon_code', 'ec_ajax_redeem_subscription_coupon_code' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_subscription_coupon_code', 'ec_ajax_redeem_subscription_coupon_code' );
function ec_ajax_redeem_subscription_coupon_code( ){
	
	// Get Coupon Code Info
	$product_id = "";
	$manufacturer_id = "";
	$coupon_code = "";
	if( isset( $_POST['couponcode'] ) ){
		$coupon_code = $_POST['couponcode'];
	}
	if( isset( $_POST['product_id'] ) ){
		$product_id = $_POST['product_id'];
	}
	if( isset( $_POST['manufacturer_id'] ) ){
		$manufacturer_id = $_POST['manufacturer_id'];
	}
	
	// Get the Coupon and Check Validity
	$coupon = $GLOBALS['ec_coupons']->redeem_coupon_code( $coupon_code );
	$coupon_code_invalid = true;
	$coupon_applicable = true;
	$coupon_exceeded_redemptions = false;
	$coupon_expired = false;
	
	if( !$coupon ){ // Invalid Coupon
		$coupon_code_invalid = false;
	}else if( $coupon->by_product_id && $coupon->product_id != $product_id ){ // Product does not match
		$coupon_applicable = false;
	}else if( $coupon->by_manufacturer_id && $coupon->manufacturer_id != $manufacturer_id  ){ // Manufacturer Does not Match
		$coupon_applicable = false;
	}else if( $coupon->max_redemptions != 999 && $coupon->times_redeemed >= $coupon->max_redemptions ){
		$coupon_exceeded_redemptions = true;
	}else if( $coupon->coupon_expired ){
		$coupon_expired = true;
	}
	
	// If valid and applicable, set to cache.
	if( $coupon_applicable && !$coupon_exceeded_redemptions && !$coupon_expired ){
		$GLOBALS['ec_cart_data']->cart_data->coupon_code = $coupon_code;
	}else{
		$GLOBALS['ec_cart_data']->cart_data->coupon_code = "";
	}
	
	$GLOBALS['ec_cart_data']->save_session_to_db( );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	// Get and Print Order Totals
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$order_totals = ec_get_order_totals( $cart );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	// Print appropriate success or error message
	if( !$coupon_code_invalid ){
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' ) . "***" . "invalid";
	
	}else if( !$coupon_applicable ){
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_not_applicable_coupon' ) . "***" . "invalid";
	
	}else if( $coupon_exceeded_redemptions ){
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_max_exceeded_coupon' ) . "***" . "invalid";
		
	}else if( $coupon_expired ){
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_coupon_expired' ) . "***" . "invalid";
		
	}else{
		echo "***" . $coupon->message . "***" . "valid";
				
	}
	
	if( $order_totals->discount_total == 0 )
		echo "***0";
	else
		echo "***1";
	
	die( ); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_redeem_gift_card', 'ec_ajax_redeem_gift_card' );
add_action( 'wp_ajax_nopriv_ec_ajax_redeem_gift_card', 'ec_ajax_redeem_gift_card' );
function ec_ajax_redeem_gift_card( ){
	
	// UPDATE GIFT CARD
	$gift_card = "";
	if( isset( $_POST['giftcard'] ) )
		$gift_card = $_POST['giftcard'];
		
	$GLOBALS['ec_cart_data']->cart_data->giftcard = $gift_card;
	
	$GLOBALS['ec_cart_data']->save_session_to_db( );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	$db = new ec_db();
	$giftcard = $db->redeem_gift_card( $gift_card );
	
	// UPDATE GIFT CARD
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$order_totals = ec_get_order_totals( $cart );
	
	echo $cart->total_items . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->sub_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->tax_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->duty_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->vat_total ) . "***" . 
			$GLOBALS['currency']->get_currency_display( $order_totals->grand_total );
	
	if( $giftcard )
		echo "***" . $giftcard->message . "***" . "valid";
	else{
		$GLOBALS['ec_cart_data']->cart_data->giftcard = "";
		echo "***" . $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_giftcard' ) . "***" . "invalid";
	}
		
	if( $order_totals->discount_total == 0 )
		echo "***0";
	else
		echo "***1";
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
add_action( 'wp_ajax_nopriv_ec_ajax_estimate_shipping', 'ec_ajax_estimate_shipping' );
function ec_ajax_estimate_shipping( ){
	//Get the variables from the AJAX call
	if( isset( $_POST['zipcode'] ) ){
		$GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip = $_POST['zipcode'];
		$GLOBALS['ec_cart_data']->cart_data->shipping_zip = $_POST['zipcode'];
	}
	if( isset( $_POST['country'] ) && $_POST['country'] != "0" ){
		$GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country = $_POST['country'];
		$GLOBALS['ec_cart_data']->cart_data->shipping_country = $_POST['country'];
	}
	
	$GLOBALS['ec_cart_data']->save_session_to_db( );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$order_totals = ec_get_order_totals( $cart );
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $GLOBALS['ec_user']->freeshipping );
	
	$shipping_options = $shipping->get_shipping_options( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" );
	
	if( $GLOBALS['ec_setting']->get_shipping_method() == "live" && $shipping_options )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->vat_total );
	else if( $GLOBALS['ec_setting']->get_shipping_method() == "live" )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	else
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options;
		
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
add_action( 'wp_ajax_nopriv_ec_ajax_update_shipping_method', 'ec_ajax_update_shipping_method' );
function ec_ajax_update_shipping_method( ){
	
	//Get the variables from the AJAX call
	$shipping_method = $_POST['shipping_method'];
	
	//Create a new db and submit review
	$GLOBALS['ec_cart_data']->cart_data->shipping_method = $shipping_method;
	
	$GLOBALS['ec_cart_data']->save_session_to_db( );
	wp_cache_flush( );
	do_action( 'wpeasycart_cart_updated' );
	
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$order_totals = ec_get_order_totals( $cart );
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$shipping = new ec_shipping( $cart->subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $GLOBALS['ec_user']->freeshipping );
	
	$shipping_options = $shipping->get_shipping_options( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" );
	
	if( $GLOBALS['ec_setting']->get_shipping_method() == "live" && $shipping_options )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->vat_total );
	else if( $GLOBALS['ec_setting']->get_shipping_method() == "live" )
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	else
		echo $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ) . "***" . $GLOBALS['currency']->get_currency_display( $order_totals->grand_total ) . "***" . $shipping_options;
		
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_update_payment_method', 'ec_ajax_update_payment_method' );
add_action( 'wp_ajax_nopriv_ec_ajax_update_payment_method', 'ec_ajax_update_payment_method' );
function ec_ajax_update_payment_method( ){
	
	//Get the variables from the AJAX call
	$payment_method = $_POST['payment_method'];
	$_SESSION['ec_selected_payment_method'] = $payment_method;
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
add_action( 'wp_ajax_nopriv_ec_ajax_insert_customer_review', 'ec_ajax_insert_customer_review' );
function ec_ajax_insert_customer_review( ){
	
	//Get the variables from the AJAX call
	$product_id = $_POST['product_id'];
	$rating = $_POST['review_score'];
	$title = $_POST['review_title'];
	$description = $_POST['review_message'];
	
	//Create a new db and submit review
	$db = new ec_db();
	echo $db->submit_customer_review( $product_id, $rating, $title, $description, $GLOBALS['ec_user']->user_id );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_live_search', 'ec_ajax_live_search' );
add_action( 'wp_ajax_nopriv_ec_ajax_live_search', 'ec_ajax_live_search' );
function ec_ajax_live_search( ){
	
	//Get the variables from the AJAX call
	$search_val = $_POST['search_val'];
	
	//Create a new db and submit review
	$db = new ec_db();
	$results = $db->get_live_search_options( $search_val );
	echo json_encode( $results );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_close_newsletter', 'ec_ajax_close_newsletter' );
add_action( 'wp_ajax_nopriv_ec_ajax_close_newsletter', 'ec_ajax_close_newsletter' );
function ec_ajax_close_newsletter( ){
	
	setcookie( 'ec_newsletter_popup', 'hide', time( ) + ( 10 * 365 * 24 * 60 * 60 ), "/" );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_submit_newsletter_signup', 'ec_ajax_submit_newsletter_signup' );
add_action( 'wp_ajax_nopriv_ec_ajax_submit_newsletter_signup', 'ec_ajax_submit_newsletter_signup' );
function ec_ajax_submit_newsletter_signup( ){
	
	$newsletter_name = "";
	if( isset( $_POST['newsletter_name'] ) ){
		$newsletter_name = $_POST['newsletter_name'];
	}
	
	$ec_db = new ec_db();
	$ec_db->insert_subscriber( $_POST['email_address'], $newsletter_name, "" );
			
	// MyMail Hook
	if( function_exists( 'mymail' ) ){
		$subscriber_id = mymail('subscribers')->add(array(
			'email' => $_POST['email_address'],
			'name' => $newsletter_name,
			'status' => 1,
		), false );
	}
		
	do_action( 'wpeasycart_subscriber_added', $_POST['email_address'], $_POST['newsletter_name'] );
	
	setcookie( 'ec_newsletter_popup', 'hide', time( ) + ( 10 * 365 * 24 * 60 * 60 ), "/" );
	
	die(); // this is required to return a proper result
	
}

add_action( 'wp_ajax_ec_ajax_save_page_options', 'ec_ajax_save_page_options' );
function ec_ajax_save_page_options( ){
	
	update_option( 'ec_option_design_saved', 1 );
	$db = new ec_db( );
	$post_id = $_POST['post_id'];
	foreach( $_POST as $key => $var ){
		
		if( $key == 'ec_option_details_main_color' ){
			update_option( 'ec_option_details_main_color', $_POST['ec_option_details_main_color'] );
		}else if( $key == 'ec_option_details_second_color' ){
			update_option( 'ec_option_details_second_color', $_POST['ec_option_details_second_color'] );
		}else if( $key != 'post_id' ){
			$db->update_page_option( $post_id, $key, $var );
		}
		
	}
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_page_default_options', 'ec_ajax_save_page_default_options' );
function ec_ajax_save_page_default_options( ){
	
	update_option( 'ec_option_design_saved', 1 );
	$db = new ec_db( );
	$post_id = $_POST['post_id'];
	foreach( $_POST as $key => $var ){
		
		if( $key != 'post_id' ){
			update_option( $key, $var );
		}
		
	}
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_hide_video_option', 'ec_ajax_save_hide_video_option' );
function ec_ajax_save_hide_video_option( ){
	
	update_option( 'ec_option_hide_design_help_video', '1' );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_options', 'ec_ajax_save_product_options' );
function ec_ajax_save_product_options( ){
	
	$model_number = $_POST['model_number'];
	
	$product_options = new stdClass( );
	$product_options->image_hover_type = $_POST['image_hover_type'];
	$product_options->image_effect_type = $_POST['image_effect_type'];
	$product_options->tag_type = $_POST['tag_type'];
	$product_options->tag_text = stripslashes( $_POST['tag_text'] );
	$product_options->tag_bg_color = $_POST['tag_bg_color'];
	$product_options->tag_text_color = $_POST['tag_text_color'];
	
	$db = new ec_db( );
	$db->update_product_options( $model_number, $product_options );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_mass_save_product_options', 'ec_ajax_mass_save_product_options' );
function ec_ajax_mass_save_product_options( ){
	
	$product_list = $_POST['products'];
	
	$product_options = new stdClass( );
	$product_options->image_hover_type = $_POST['image_hover_type'];
	$product_options->image_effect_type = $_POST['image_effect_type'];
	
	$db = new ec_db( );
	foreach( $product_list as $model_number ){
		$db->update_product_options( $model_number, $product_options );
	}
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_order', 'ec_ajax_save_product_order' );
function ec_ajax_save_product_order( ){
	
	$post_id = $_POST['post_id'];
	$product_order = $_POST['product_order'];
	
	$db = new ec_db( );
	$db->update_page_option( $post_id, 'product_order', $product_order );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_ec_update_product_description', 'ec_ajax_ec_update_product_description' );
function ec_ajax_ec_update_product_description( ){
	
	$description = $_POST['description'];
	$product_id = $_POST['product_id'];
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.description = %s WHERE ec_product.product_id = %d", $description, $product_id ) );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_ec_update_product_specifications', 'ec_ajax_ec_update_product_specifications' );
function ec_ajax_ec_update_product_specifications( ){
	
	$specifications = $_POST['specifications'];
	$product_id = $_POST['product_id'];
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE ec_product SET ec_product.specifications = %s WHERE ec_product.product_id = %d", $specifications, $product_id ) );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_product_details_options', 'ec_ajax_save_product_details_options' );
function ec_ajax_save_product_details_options( ){
	
	update_option( 'ec_option_details_main_color', $_POST['ec_option_details_main_color'] );
	update_option( 'ec_option_details_columns_desktop', $_POST['ec_option_details_columns_desktop'] );
	update_option( 'ec_option_details_columns_laptop', $_POST['ec_option_details_columns_laptop'] );
	update_option( 'ec_option_details_columns_tablet_wide', $_POST['ec_option_details_columns_tablet_wide'] );
	update_option( 'ec_option_details_columns_tablet', $_POST['ec_option_details_columns_tablet'] );
	update_option( 'ec_option_details_columns_smartphone', $_POST['ec_option_details_columns_smartphone'] );
	update_option( 'ec_option_use_dark_bg', $_POST['ec_option_use_dark_bg'] );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_save_cart_options', 'ec_ajax_save_cart_options' );
function ec_ajax_save_cart_options( ){
	
	update_option( 'ec_option_cart_columns_desktop', $_POST['ec_option_cart_columns_desktop'] );
	update_option( 'ec_option_cart_columns_laptop', $_POST['ec_option_cart_columns_laptop'] );
	update_option( 'ec_option_cart_columns_tablet_wide', $_POST['ec_option_cart_columns_tablet_wide'] );
	update_option( 'ec_option_cart_columns_tablet', $_POST['ec_option_cart_columns_tablet'] );
	update_option( 'ec_option_cart_columns_smartphone', $_POST['ec_option_cart_columns_smartphone'] );
	update_option( 'ec_option_use_dark_bg', $_POST['ec_option_use_dark_bg'] );
	do_action( 'wpeasycart_page_options_updated' );
	
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_hide_js_error_message', 'ec_ajax_hide_js_error_message' );
function ec_ajax_hide_js_error_message( ){
	
	$_SESSION['ec_admin_js_error_bypass'] = true;
	die( );
	
}

add_action( 'wp_ajax_ec_ajax_get_dynamic_cart_menu', 'ec_ajax_get_dynamic_cart_menu' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_dynamic_cart_menu', 'ec_ajax_get_dynamic_cart_menu' );
function ec_ajax_get_dynamic_cart_menu( ){
	
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	if( !get_option( 'ec_option_hide_cart_icon_on_empty' ) || $cart->total_items > 0 ){
	
		// Get Cart Page Link
		$cartpageid = get_option('ec_option_cartpage');
		if( function_exists( 'icl_object_id' ) ){
			$cartpageid = icl_object_id( $cartpageid, 'page', true, ICL_LANGUAGE_CODE );
		}
		$cartpage = get_permalink( $cartpageid );
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$cartpage = $https_class->makeUrlHttps( $cartpage );
		}
		
		// Check for correct Label
		if( $cart->total_items != 1 ){
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label_plural' );
		}else{
			$items_label = $GLOBALS['language']->get_text( 'cart', 'cart_menu_icon_label' );
		}
		
		// Then display to user
		if( $cart->total_items > 0 ){
			$items = '<a href="' . $cartpage . '"><span class="dashicons dashicons-cart" style="vertical-align:middle; margin-top:-5px; margin-right:5px;"></span> ' . ' ( <span class="ec_menu_cart_text"><span class="ec_cart_items_total">' . $cart->total_items . '</span> ' . $items_label . ' <span class="ec_cart_price_total">' . $GLOBALS['currency']->get_currency_display( $cart->subtotal ) . '</span></span> )</a>';
		
		}else{
			$items = '<a href="' . $cartpage . '"><span class="dashicons dashicons-cart" style="vertical-align:middle; margin-top:-5px; margin-right:5px;"></span> ' . ' ( <span class="ec_menu_cart_text"><span class="ec_cart_items_total">' . $cart->total_items . '</span> ' . $items_label . ' <span class="ec_cart_price_total"></span></span> )</a>';
		}
		
		echo $items;
		
	}
	
	die( );
	
}

// Helper function for AJAX calls in cart.
function ec_get_order_totals( $cart = false ){
	
	if( !$cart )
		$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$user =& $GLOBALS['ec_user'];
	
	$coupon_code = "";
	if( $GLOBALS['ec_cart_data']->cart_data->coupon_code != "" )
		$coupon_code = $GLOBALS['ec_cart_data']->cart_data->coupon_code;
		
	$gift_card = "";
	if( $GLOBALS['ec_cart_data']->cart_data->giftcard != "" )
		$gift_card = $GLOBALS['ec_cart_data']->cart_data->giftcard;
	
	// Shipping
	$sales_tax_discount = new ec_discount( $cart, $cart->discountable_subtotal, 0.00, $coupon_code, "", 0 );
	$GLOBALS['wpeasycart_current_coupon_discount'] = $sales_tax_discount->coupon_discount;
	$shipping = new ec_shipping( $cart->shipping_subtotal, $cart->weight, $cart->shippable_total_items, 'RADIO', $GLOBALS['ec_user']->freeshipping, $cart->length, $cart->width, $cart->height, $cart->cart );
	// Tax (no VAT here)
	$sales_tax_discount = new ec_discount( $cart, $cart->discountable_subtotal, 0.00, $coupon_code, "", 0 );
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal - $sales_tax_discount->coupon_discount, 0, $GLOBALS['ec_cart_data']->cart_data->shipping_state, $GLOBALS['ec_cart_data']->cart_data->shipping_country, $GLOBALS['ec_user']->taxfree, $shipping->get_shipping_price( ) + $cart->get_handling_total( ) );
	// Duty (Based on Product Price) - already calculated in tax
	// Get Total Without VAT, used only breifly
	if( get_option( 'ec_option_no_vat_on_shipping' ) ){
		$total_without_vat_or_discount = $cart->vat_subtotal + $tax->tax_total + $tax->duty_total;
	}else{
		$total_without_vat_or_discount = $cart->vat_subtotal + $shipping->get_shipping_price( ) + $tax->tax_total + $tax->duty_total;
	}
	//If a discount used, and no vatable subtotal, we need to set to 0
	if( $total_without_vat_or_discount < 0 )
		$total_without_vat_or_discount = 0;
	// Discount for Coupon
	$discount = new ec_discount( $cart, $cart->discountable_subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $total_without_vat_or_discount );
	// Amount to Apply VAT on
	$promotion = new ec_promotion( );
	$vatable_subtotal = $total_without_vat_or_discount - $discount->coupon_discount - $promotion->get_discount_total( $cart->subtotal );
	// If for some reason this is less than zero, we should correct
	if( $vatable_subtotal < 0 )
		$vatable_subtotal = 0;
	// Get Tax Again For VAT
	$tax = new ec_tax( $cart->subtotal, $cart->taxable_subtotal - $sales_tax_discount->coupon_discount, $vatable_subtotal, $GLOBALS['ec_cart_data']->cart_data->shipping_state, $GLOBALS['ec_cart_data']->cart_data->shipping_country, $GLOBALS['ec_user']->taxfree, $shipping->get_shipping_price( ) + $cart->get_handling_total( ) );
	// Discount for Gift Card
	$grand_total = ( $cart->subtotal + $tax->tax_total + $shipping->get_shipping_price( ) + $tax->duty_total );
	$discount = new ec_discount( $cart, $cart->discountable_subtotal, $shipping->get_shipping_price( ), $coupon_code, $gift_card, $grand_total );
	// Order Totals
	$order_totals = new ec_order_totals( $cart, $GLOBALS['ec_user'], $shipping, $tax, $discount );
	return $order_totals;
}

function ec_get_cart_data( ){
	// GET NEW CART ITEM INFO
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$cart_array = array( );
	
	for( $i=0; $i<count( $cart->cart ); $i++ ){
		$cart_item = array( 
				"id" 								=> $cart->cart[$i]->cartitem_id,
				"unit_price" 						=> $GLOBALS['currency']->get_currency_display( $cart->cart[$i]->unit_price ),
				"total_price" 						=> $GLOBALS['currency']->get_currency_display( $cart->cart[$i]->total_price ),
				"quantity" 							=> $cart->cart[$i]->quantity,
				"stock_quantity"					=> $cart->cart[$i]->stock_quantity,
				"allow_backorders"					=> $cart->cart[$i]->allow_backorders,
				"use_optionitem_quantity_tracking"	=> $cart->cart[$i]->use_optionitem_quantity_tracking,
				"optionitem_stock_quantity"			=> $cart->cart[$i]->optionitem_stock_quantity
		);
		$cart_array[] = $cart_item;
	}
	// GET NEW CART ITEM INFO
	$order_totals = ec_get_order_totals( $cart );
	
	if( $order_totals->discount_total != 0 )
		$has_discount = 1;
	else
		$has_discount = 0;
	
	$order_totals_array = array( 
			"sub_total" 							=> $GLOBALS['currency']->get_currency_display( $order_totals->sub_total ), 
			"tax_total" 							=> $GLOBALS['currency']->get_currency_display( $order_totals->tax_total ),
			"shipping_total" 						=> $GLOBALS['currency']->get_currency_display( $order_totals->shipping_total ),
			"duty_total" 							=> $GLOBALS['currency']->get_currency_display( $order_totals->duty_total ),
			"vat_total" 							=> $GLOBALS['currency']->get_currency_display( $order_totals->vat_total ),
			"discount_total" 						=> $GLOBALS['currency']->get_currency_display( (-1) * $order_totals->discount_total ),
			"grand_total" 							=> $GLOBALS['currency']->get_currency_display( $order_totals->grand_total )
			);
	
	$final_array = array( 	
			"cart" 									=> $cart_array,
			"order_totals"							=> $order_totals_array,
			"items_total"							=> $cart->total_items,
			"weight_total"							=> $cart->weight,
			"has_discount"							=> $has_discount,
			"has_backorder"							=> $cart->has_backordered_item( )
	);
							
	return $final_array;
}

add_action( 'wp_ajax_ec_ajax_get_cart', 'ec_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_cart', 'ec_ajax_get_cart' );
function ec_ajax_get_cart( ){
	
	//Get the variables from the AJAX call
	$cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
	$retarray = array( );
	
	foreach( $cart->cart as $cartitem ){
		$retarray[] = array( "cartitem_id"	=> $cartitem->cartitem_id, 
							 "title"		=> $cartitem->title,
							 "quantity"		=> $cartitem->quantity, 
							 "unit_price"	=> $GLOBALS['currency']->get_currency_display( $cartitem->unit_price ) );
	}
	
	echo json_encode( $retarray );
	
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_ec_ajax_get_cart_totals', 'ec_ajax_get_cart_totals' );
add_action( 'wp_ajax_nopriv_ec_ajax_get_cart_totals', 'ec_ajax_get_cart_totals' );
function ec_ajax_get_cart_totals( ){
	
	//Get the variables from the AJAX call
	$cartpage = new ec_cartpage( );
	
	$retarray = array( 	"sub_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->sub_total ), 
						"tax_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->tax_total ), 
						"shipping_total"	=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->shipping_total ), 
						"duty_total"		=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->duty_total ), 
						"vat_total"			=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->vat_total ), 
						"discount_total"	=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->discount_total ), 
						"grand_total"		=> $GLOBALS['currency']->get_currency_display( $cartpage->order_totals->grand_total ) );
	
	echo json_encode( $retarray );
	
	die(); // this is required to return a proper result
}
// End AJAX helper function for cart.

add_filter( 'wp_title', 'ec_custom_title', 20 );

function ec_custom_title( $title ) {
	
	$page_id = get_the_ID();
	$store_id = get_option( 'ec_option_storepage' );
	
	if( $page_id == $store_id && isset( $_GET['model_number'] ) ){
		$db = new ec_db( );
		$products = $db->get_product_list( " WHERE product.model_number = '" . $_GET['model_number'] . "'", "", "", "" );
		if( count( $products ) > 0 ){
			$custom_title = $products[0]['title'] . " |" . $title;
			return $custom_title;
		}else{
			return $title;
		}
	}else if( $page_id == $store_id ){
		
		$additional_title = "";
		
		if( isset( $_GET['manufacturer'] ) ){
			$db = new ec_db( );
			$manufacturer = $db->get_manufacturer_row( $_GET['manufacturer'] );
			
			$additional_title .= $manufacturer->name . " |";
		}
		
		if( isset( $_GET['menu'] ) ){
			$custom_title = $_GET['menu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else if( isset( $_GET['submenu'] ) ){
			$custom_title = $_GET['submenu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else if( isset( $_GET['subsubmenu'] ) ){
			$custom_title = $_GET['subsubmenu'] . " |" . $additional_title . $title;
			return $custom_title;
		}else{
			return $additional_title . $title;
		}	
	}else{
		return $title;
	}
	
}

function ec_theme_options_page_callback( ){
	if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option('ec_option_base_theme') . "/" ) )
		include( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option('ec_option_base_theme') . "/admin_panel.php");
	else
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option('ec_option_latest_theme') . "/admin_panel.php");
}

/////////////////////////////////////////////////////////////////////
//CUSTOM POST TYPES
/////////////////////////////////////////////////////////////////////
add_action( 'init', 'ec_create_post_type_menu' );
function ec_create_post_type_menu() {
	
	// Fix, V3 upgrades missed the ec_tempcart_optionitem.session_id upgrade!
	if( !get_option( 'ec_option_v3_fix' ) ){
		global $wpdb;
		$wpdb->query( "INSERT INTO ec_tempcart_optionitem( tempcart_id, option_id, optionitem_id, optionitem_value ) VALUES( '999999999', '3', '3', 'test' )" );
		$tempcart_optionitem_row = $wpdb->get_row( "SELECT * FROM ec_tempcart_optionitem WHERE tempcart_id = '999999999'" );
		if( !isset( $tempcart_optionitem_row->session_id ) ){
			$wpdb->query( "ALTER TABLE ec_tempcart_optionitem ADD `session_id` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'The ec_cart_id that determines the user who entered this value.'" );
		}
		update_option( 'ec_option_v3_fix', 1 );
	}
	
	// Update store item posts, set to private if inactive in store
	if( !get_option( 'ec_option_published_check' ) || get_option( 'ec_option_published_check' ) != EC_CURRENT_VERSION ){	
		global $wpdb;
		$language = new ec_language( );
		$inactive_products = $wpdb->get_results( "SELECT ec_product.post_id, ec_product.model_number, ec_product.title FROM ec_product WHERE ec_product.activate_in_store = 0" );
		foreach( $inactive_products as $product ){
			$post = array(	'ID'			=> $product->post_id,
							'post_content'	=> "[ec_store modelnumber=\"" . $product->model_number . "\"]",
							'post_status'	=> "private",
							'post_title'	=> $language->convert_text( $product->title ),
							'post_type'		=> "ec_store",
							'post_name'		=> str_replace(' ', '-', $language->convert_text( $product->title ) ),
					  );
			wp_update_post( $post );
		}
		update_option( 'ec_option_published_check', EC_CURRENT_VERSION );
	}
	
	$store_id = get_option( 'ec_option_storepage' );
	if( $store_id ){
		$store_slug = ec_get_the_slug( $store_id );
		
		$labels = array(
			'name'               => _x( 'Store Items', 'post type general name' ),
			'singular_name'      => _x( 'Store Item', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'ec_store' ),
			'add_new_item'       => __( 'Add New Store Item' ),
			'edit_item'          => __( 'Edit Store Item' ),
			'new_item'           => __( 'New Store Item' ),
			'all_items'          => __( 'All Store Items' ),
			'view_item'          => __( 'View Store Item' ),
			'search_items'       => __( 'Search Store Items' ),
			'not_found'          => __( 'No store items found' ),
			'not_found_in_trash' => __( 'No store items found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Store Items'
		);
		$args = array(
			'labels'        	=> $labels,
			'description' 		=> 'Used for the EasyCart Store',
			'public' 			=> true,
			'has_archive' 		=> false,
			'show_ui' 			=> true,
			'show_in_nav_menus' => true,
			'show_in_menu' 		=> false,
			'supports'			=> array( 'title', 'page-attributes', 'author', 'editor', 'post-formats' ),
			'rewrite'			=> array( 'slug' => $store_slug, 'with_front' => false, 'page' => false ),
		);
		register_post_type( 'ec_store', $args );
		
		global $wp_rewrite;
		$wp_rewrite->add_permastruct( 'ec_store', $store_slug . '/%ec_store%/', true, 1 );
    	add_rewrite_rule( '^' . $store_slug . '/([^/]*)/?$', 'index.php?ec_store=$matches[1]', 'top');
		
		// Only Flush Once!
		if( get_option( 'ec_option_added_custom_post_type' ) < 2 ){	
			$wp_rewrite->flush_rules();
			update_option( 'ec_option_added_custom_post_type', 2 );
		}
	}
}

function ec_get_the_slug( $id=null ){
	if( empty($id) ) : 
		global $post;
    	if( empty($post) )
			return '';
		$id = $post->ID;
	endif;
	$slug = basename( get_permalink($id) );
	return $slug;
}

add_action( 'wp', 'ec_force_page_type' );
function ec_force_page_type() {
	global $wp_query, $post_type;
	
	if( $post_type == 'ec_store' && !get_option( 'ec_option_use_custom_post_theme_template' ) ){
		$wp_query->is_page = true;
		$wp_query->is_single = false;
		$wp_query->query_vars['post_type'] = "page";
		if( isset( $wp_query->post ) )
			$wp_query->post->post_type = "page";
	}
}

add_filter( 'template_redirect', 'ec_fix_store_template', 1 );
function ec_fix_store_template( ){
	global $wp;
	$custom_post_types = array("ec_store");
	
	if( isset( $wp->query_vars["post_type"] ) && in_array( $wp->query_vars["post_type"], $custom_post_types ) ){
		$store_template = get_post_meta( get_option( 'ec_option_storepage' ), "_wp_page_template", true );
		if( isset( $store_template ) && $store_template != "" && $store_template != "default"  ){
			if( file_exists( get_template_directory( ) . "/" . $store_template ) ){
				include( get_template_directory( ) . "/" . $store_template );
				exit( );
			}
		}
	}
}

/////////////////////////////////////////////////////////////////////
//HELPER FUNCTIONS
/////////////////////////////////////////////////////////////////////
//Helper Function, Get URL
function ec_get_url(){
  if( isset( $_SERVER['HTTPS'] ) )
  	$protocol =  "https";
  else
	$protocol =  "http";
	
  $baseurl = "://" . $_SERVER['HTTP_HOST'];
  $strip = explode("/wp-admin", $_SERVER['REQUEST_URI']);
  $folder = $strip[0];
  return $protocol .  $baseurl . $folder;
}

function ec_setup_hooks( ){
	$GLOBALS['ec_hooks'] = array( );
}

function ec_add_hook( $call_location, $function_name, $args = array(), $priority = 1 ){
	if( !isset( $GLOBALS['ec_hooks'][$call_location] ) )
		$GLOBALS['ec_hooks'][$call_location] = array( );
	
	$GLOBALS['ec_hooks'][$call_location][] = array( $function_name, $args, $priority );
}

function ec_call_hook( $hook_array, $class_args ){
	$hook_array[0]( $hook_array[1], $class_args );
}

function ec_dwolla_verify_signature( $proposedSignature, $checkoutId, $amount ){
    $apiSecret = get_option( 'ec_option_dwolla_thirdparty_secret' );
	$amount = number_format( $amount, 2 );
    $signature = hash_hmac("sha1", "{$checkoutId}&{$amount}", $apiSecret);

    return $signature == $proposedSignature;
}

add_filter( 'wp_nav_menu_items', 'ec_custom_cart_in_menu', 10, 2 );
function ec_custom_cart_in_menu ( $items, $args ) {
	
	$ids = explode( '***', get_option( 'ec_option_cart_menu_id' ) );
	if( get_option( 'ec_option_show_menu_cart_icon' ) && ( in_array( substr( $args->menu_id, 0, -5 ), $ids ) || in_array( $args->theme_location, $ids ) ) ){
	
		$items .= '<li class="ec_menu_mini_cart"></li>';
		
	}
	
	return $items;
}

function wpeasycart_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup' ) ) );
    }
}
add_action( 'activated_plugin', 'wpeasycart_activation_redirect' );

add_action( 'wpeasycart_abandoned_cart_automation', 'wpeasycart_send_abandoned_cart_emails' );
function wpeasycart_send_abandoned_cart_emails( ){
	global $wpdb;
	$abandoned_carts = $wpdb->get_results( "SELECT ec_tempcart.tempcart_id FROM ec_tempcart, ec_tempcart_data WHERE ec_tempcart.abandoned_cart_email_sent = 0 AND ec_tempcart.session_id = ec_tempcart_data.session_id AND ec_tempcart_data.email != '' AND ec_tempcart.last_changed_date < DATE_SUB( NOW( ), INTERVAL 3 DAY ) GROUP BY ec_tempcart.session_id" );
	foreach( $abandoned_carts as $abandoned_cart ){
		wpeasycart_send_abandoned_cart_email( $abandoned_cart->tempcart_id );
	}
}

function wpeasycart_send_abandoned_cart_email( $tempcart_id ){
	global $wpdb;
	$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
	
	$cart_page_id = get_option('ec_option_cartpage');
	if( function_exists( 'icl_object_id' ) )
		$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
	$cart_page = get_permalink( $cart_page_id );
	if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
		$https_class = new WordPressHTTPS( );
		$cart_page = $https_class->makeUrlHttps( $cart_page );
	}
	if( substr_count( $cart_page, '?' ) )						$permalink_divider = "&";
	else														$permalink_divider = "?";
	
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-Type: text/html; charset=utf-8";
	$headers[] = "From: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
	$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	$tempcart_item = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.session_id, ec_tempcart.tempcart_id, ec_tempcart.product_id, ec_tempcart.quantity, ec_tempcart_data.billing_first_name, ec_tempcart_data.billing_last_name, ec_tempcart_data.email, ec_product.title FROM ec_tempcart LEFT JOIN ec_tempcart_data ON ec_tempcart_data.session_id = ec_tempcart.session_id LEFT JOIN ec_product ON ec_product.product_id = ec_tempcart.product_id WHERE ec_tempcart.tempcart_id = %d ORDER BY ec_tempcart.session_id, last_changed_date", $tempcart_id ) );
	$tempcart_rows = $wpdb->get_results( $wpdb->prepare( "SELECT ec_product.*, ec_tempcart.quantity AS tempcart_quantity, ec_tempcart.optionitem_id_1, ec_tempcart.optionitem_id_2, ec_tempcart.optionitem_id_3, ec_tempcart.optionitem_id_4, ec_tempcart.optionitem_id_5 FROM ec_tempcart, ec_product WHERE ec_product.product_id = ec_tempcart.product_id AND ec_tempcart.session_id = %s", $tempcart_item->session_id ) );
	
	error_log( print_r( $tempcart_item, true ) );
	error_log( print_r( $tempcart_rows, true ) );
	
	$to = $tempcart_item->email;
	$subject = "You Left Items in Your Cart";
	
	ob_start();
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_abandoned_cart_email.php' ) )	
		include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_abandoned_cart_email.php';	
	else
		include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_abandoned_cart_email.php';
	$message = ob_get_clean( );
	
	$email_send_method = get_option( 'ec_option_use_wp_mail' );
	$email_send_method = apply_filters( 'wpeasycart_email_method', $email_send_method );
	
	if( $email_send_method == "1" ){
		wp_mail( $to, $subject, $message, implode("\r\n", $headers), $attachments );
	}else if( $email_send_method == "0" ){
		$mailer = new wpeasycart_mailer( );
		$mailer->send_order_email( $to, $subject, $message );
	}else{
		do_action( 'wpeasycart_custom_order_email', stripslashes( get_option( 'ec_option_order_from_email' ) ), $to, stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), $subject, $message );
	}
	$wpdb->query( $wpdb->prepare( "UPDATE ec_tempcart SET abandoned_cart_email_sent = 1 WHERE ec_tempcart.session_id = %s", $tempcart_item->session_id ) );
	
}

function wp_easycart_check_for_shortcode( $posts ){
    if( empty( $posts ) )
        return $posts;
    
	$found = false;
 
    foreach( $posts as $post ){
        if( $post->ID == get_option( 'ec_option_storepage' ) || $post->post_type == "ec_store" ){
            $found = true;
            break;
        }
	}
 
    if( $found ){
        add_filter( 'jetpack_enable_open_graph', '__return_false' ); 
    }
    return $posts;
}
add_action( 'the_posts', 'wp_easycart_check_for_shortcode' );

///////////////////HAVING ISSUES WITH OUT DURING ACTIVATION?? PRINT ERRORS!//////////////////
/*
add_action( 'activated_plugin','ec_save_error' );
function ec_save_error(){
	file_put_contents( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY. '/error_activation.html', ob_get_contents( ) );
}
*/
?>