<?php
function ec_get_php_version( ){
	return phpversion( );
}

function ec_is_session_writable( ){
	return is_writable( session_save_path( ) );
}

function ec_open_basedir() {
	if(ini_get("open_basedir")) return true;
}

function wpeasycart_smtp_test1( ){
	
	$to = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
	$subject = "WP EasyCart Order Receipt Email Test";
	$message = "This is a simple test from WP EasyCart to make sure your email setup is correct. If you receive this your order type emails should be working properly!";
	
	if( get_option( 'ec_option_use_wp_mail' ) == "0" ){
		$mailer = new wpeasycart_mailer( );
		return $mailer->send_order_email( $to, $subject, $message );
	}else{
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
		$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		wp_mail( $to, $subject, $message, implode("\r\n", $headers) );
		return false;
	}

}

function wpeasycart_smtp_test2( ){
	
	$to = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
	$subject = "WP EasyCart Account Test Email";
	$message = "This is a simple test from WP EasyCart to make sure your email setup is correct. If you receive this your account type emails should be working properly!";
	
	if( get_option( 'ec_option_use_wp_mail' ) == "0" ){
		$mailer = new wpeasycart_mailer( );
		return $mailer->send_customer_email( $to, $subject, $message );
	}else{
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
		$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		wp_mail( $to, $subject, $message, implode("\r\n", $headers) );
		return false;
	}
	
}

function wpeasycart_send_email_reminder( $tempcart_id ){
	
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
	
	$tempcart_item = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.session_id, ec_tempcart.tempcart_id, ec_tempcart.product_id, ec_tempcart.quantity, ec_tempcart_data.billing_first_name, ec_tempcart_data.billing_last_name, ec_tempcart_data.email, ec_product.title FROM ec_tempcart LEFT JOIN ec_tempcart_data ON ec_tempcart_data.session_id = ec_tempcart.session_id LEFT JOIN ec_product ON ec_product.product_id = ec_tempcart.product_id WHERE ec_tempcart.tempcart_id = %d ORDER BY ec_tempcart.session_id, last_changed_date DESC", $tempcart_id ) );
	$tempcart_rows = $wpdb->get_results( $wpdb->prepare( "SELECT ec_product.*, ec_tempcart.quantity AS tempcart_quantity, ec_tempcart.optionitem_id_1, ec_tempcart.optionitem_id_2, ec_tempcart.optionitem_id_3, ec_tempcart.optionitem_id_4, ec_tempcart.optionitem_id_5 FROM ec_tempcart, ec_product WHERE ec_product.product_id = ec_tempcart.product_id AND ec_tempcart.session_id = %s", $tempcart_item->session_id ) );
	$to = $tempcart_item->email;
	$subject = "You Left Items in Your Cart";
	
	ob_start();
	if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_abandoned_cart_email.php' ) )	
		include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_abandoned_cart_email.php';	
	else
		include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_abandoned_cart_email.php';
	$message = ob_get_clean();
	
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
	
	$wpdb->query( $wpdb->prepare( "UPDATE ec_tempcart SET ec_tempcart.abandoned_cart_email_sent = ec_tempcart.abandoned_cart_email_sent + 1 WHERE ec_tempcart.session_id = %s", $tempcart_item->session_id ) );
}

function wpeasycart_get_current_order_id( ){
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare( "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s AND TABLE_NAME = 'ec_order'", $wpdb->dbname ) );
}

function ec_save_email_settings( ){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	global $wpdb;
	update_option( 'ec_option_use_wp_mail', $_POST['ec_option_use_wp_mail'] );
	
	update_option( 'ec_option_order_from_email', $_POST['ec_option_order_from_email'] );
	update_option( 'ec_option_order_use_smtp', $_POST['ec_option_order_use_smtp'] );
	update_option( 'ec_option_order_from_smtp_host', $_POST['ec_option_order_from_smtp_host'] );
	update_option( 'ec_option_order_from_smtp_encryption_type', $_POST['ec_option_order_from_smtp_encryption_type'] );
	update_option( 'ec_option_order_from_smtp_port', $_POST['ec_option_order_from_smtp_port'] );
	update_option( 'ec_option_order_from_smtp_username', $_POST['ec_option_order_from_smtp_username'] );
	update_option( 'ec_option_order_from_smtp_password', $_POST['ec_option_order_from_smtp_password'] );
	
	update_option( 'ec_option_password_from_email', $_POST['ec_option_password_from_email'] );
	update_option( 'ec_option_password_use_smtp', $_POST['ec_option_password_use_smtp'] );
	update_option( 'ec_option_password_from_smtp_host', $_POST['ec_option_password_from_smtp_host'] );
	update_option( 'ec_option_password_from_smtp_encryption_type', $_POST['ec_option_password_from_smtp_encryption_type'] );
	update_option( 'ec_option_password_from_smtp_port', $_POST['ec_option_password_from_smtp_port'] );
	update_option( 'ec_option_password_from_smtp_username', $_POST['ec_option_password_from_smtp_username'] );
	update_option( 'ec_option_password_from_smtp_password', $_POST['ec_option_password_from_smtp_password'] );
	
	update_option( 'ec_option_bcc_email_addresses', $_POST['ec_option_bcc_email_addresses'] );
	update_option( 'ec_option_show_email_on_receipt', $_POST['ec_option_show_email_on_receipt'] );
	update_option( 'ec_option_show_image_on_receipt', $_POST['ec_option_show_image_on_receipt'] );
	$wpdb->query( $wpdb->prepare( "ALTER TABLE ec_order AUTO_INCREMENT = %d", $_POST['ec_option_current_order_id'] ) );
	
	$ec_option_email_logo = strip_tags( stripslashes( $_POST["ec_option_email_logo"] ) );
	if( $ec_option_email_logo != "" ){
		update_option( 'ec_option_email_logo', $ec_option_email_logo );
	}
}

function wpeasycart_is_data_folder_setup( ){
	$folders = wpeasycart_get_data_folder_list( );
	foreach( $folders as $dir ){
		if( !file_exists( $dir[0] ) || !is_dir( $dir[0] ) ){
			return false;
		}
	}
	return true;
}

function ec_get_data_folders_error( ){
	$error = "You are missing the following wp-easycart-data folders: ";
	$folders = wpeasycart_get_data_folder_list( );
	$first = true;
	foreach( $folders as $dir ){
		if( !file_exists( $dir[0] ) || !is_dir( $dir[0] ) ){
			if( !$first )
				$error .= ", ";
			$dir_split = explode( "wp-easycart-data/", $dir[0] );
			$error .= $dir_split[1];
			$first = false;
		}
	}
	return $error;
}

function ec_fix_data_folders( ){
	$folders = wpeasycart_get_data_folder_list( );
	foreach( $folders as $dir ){
		if( !file_exists( $dir[0] ) || !is_dir( $dir[0] ) ){
			mkdir( $dir[0], $dir[1] );
		}
	}
}

function wpeasycart_get_data_folder_list( ){
	$folders = array(
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/design/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/custom-theme/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/custom-layout/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/banners/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/categories/",
			"0751"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/downloads/",
			"0751"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/pics1/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/pics2/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/pics3/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/pics4/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/pics5/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/swatches/",
			"0755"
		),
		array( 
			WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/",
			"0751"
		)
	);
	return $folders;
}

function wpeasycart_is_database_setup( ){
	$db_manager = new ec_db_manager( );
	return $db_manager->check_db( );
}

function ec_get_database_error( ){
	$db_manager = new ec_db_manager( );
	return $db_manager->get_db_errors( );
}

function ec_fix_database_errors( ){
	$db_manager = new ec_db_manager( );
	return $db_manager->install_db( );
}

function ec_is_store_page_setup( ){
	$store_page_found = false;
	$store_is_match = false;
	$store_page_ids = array( );
	$selected_store_id = get_option( 'ec_option_storepage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_store' ) ){
			$store_page_ids[] = $page->ID;
			$store_page_found = true;
		}
	}
	if( in_array( $selected_store_id, $store_page_ids ) )
		$store_is_match = true;
		
	return ( $store_page_found && $store_is_match );
}

function ec_get_store_page_error( ){
	$store_page_found = false;
	$store_is_match = false;
	$selected_store_id = get_option( 'ec_option_storepage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_store' ) ){
			$store_page_ids[] = $page->ID;
			$store_page_found = true;
		}
	}
	if( in_array( $selected_store_id, $store_page_ids ) )
		$store_is_match = true;
	
	if( !$store_page_found )
		return "The shortcode [ec_store] was not found on any page. Please add [ec_store] to a WordPress page to correct this.";
	else if( !$store_is_match )
		return "You have not connected your store page with the EasyCart system. Please go to the setup page and select the correct page from the dropdown menu.";
	else
		return "Something went wrong, there may not be an error.";
}

function ec_is_cart_page_setup( ){
	$cart_page_found = false;
	$cart_is_match = false;
	$cart_page_ids = array( );
	$selected_cart_id = get_option( 'ec_option_cartpage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_cart' ) ){
			$cart_page_ids[] = $page->ID;
			$cart_page_found = true;
		}
	}
	if( in_array( $selected_cart_id, $cart_page_ids ) )
		$cart_is_match = true;
		
	return ( $cart_page_found && $cart_is_match );
}

function ec_get_cart_page_error( ){
	$cart_page_found = false;
	$cart_is_match = false;
	$selected_cart_id = get_option( 'ec_option_cartpage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_cart' ) ){
			$cart_page_ids[] = $page->ID;
			$cart_page_found = true;
		}
	}
	if( in_array( $selected_cart_id, $cart_page_ids ) )
		$cart_is_match = true;
	
	if( !$cart_page_found )
		return "The shortcode [ec_cart] was not found on any page. Please add [ec_cart] to a WordPress page to correct this.";
	else if( !$cart_is_match )
		return "You have not connected your cart page with the EasyCart system. Please go to the setup page and select the correct page from the dropdown menu.";
	else
		return "Something went wrong, there may not be an error.";
}

function ec_is_account_page_setup( ){
	$account_page_found = false;
	$account_is_match = false;
	$account_page_ids = array( );
	$selected_account_id = get_option( 'ec_option_accountpage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_account' ) ){
			$account_page_ids[] = $page->ID;
			$account_page_found = true;
		}
	}
	if( in_array( $selected_account_id, $account_page_ids ) )
		$account_is_match = true;
		
	return ( $account_page_found && $account_is_match );
}

function ec_get_account_page_error( ){
	$account_page_found = false;
	$account_is_match = false;
	$selected_account_id = get_option( 'ec_option_accountpage' );
	$pages = get_pages( );
	foreach( $pages as $page ){
		if( strstr( $page->post_content, '[ec_account' ) ){
			$account_page_ids[] = $page->ID;
			$account_page_found = true;
		}
	}
	if( in_array( $selected_account_id, $account_page_ids ) )
		$account_is_match = true;
	
	if( !$account_page_found )
		return "The shortcode [ec_account] was not found on any page. Please add [ec_account] to a WordPress page to correct this.";
	else if( !$account_is_match )
		return "You have not connected your account page with the EasyCart system. Please go to the setup page and select the correct page from the dropdown menu.";
	else
		return "Something went wrong, there may not be an error.";
}

function ec_is_demo_data_writable( ){
	$has_zip_class = false;
	$can_write_zip = false;
	$can_write_sql = false;
	$can_write_folder = false;
	$can_copy_file = false;
	$can_remove_file = false;
	$can_recursive_remove_dir = false;
	$can_unzip_folder = false;
	
	// Test zip
	if( class_exists( "ZipArchive" ) )
		$has_zip_class = true;
	
	// Test copy of zip
	$zip_download_url = 'http://support.wpeasycart.com/sampledata/standard_demo/standard_clean_assets_V2.zip';	
	$sql_download_url = 'http://support.wpeasycart.com/sampledata/standard_demo/standard_demo_install_V2.sql';	
	$zip_copy_to_url = WP_PLUGIN_DIR . '/wp-easycart-data/standard_clean_assets_V2.zip';
	$sql_copy_to_url = WP_PLUGIN_DIR . '/wp-easycart-data/standard_demo_install_V2.sql'; 
	
	copy( $zip_download_url, $zip_copy_to_url );
	copy( $sql_download_url, $sql_copy_to_url );
	
	// Test writing
	$ec_dir_location = WP_PLUGIN_DIR . '/wp-easycart-data/products-test-dir/';
	$ec_file_start_location = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/admin/assets/images/apple.png";
	$ec_file_dest_location = $ec_dir_location . "/test-product-image.png";
	mkdir( $ec_dir_location );
	if( is_dir( $ec_dir_location ) )
		$can_write_folder = true;
	
	copy( $ec_file_start_location, $ec_file_dest_location );
	if( file_exists( $ec_file_dest_location ) )
		$can_copy_file = true;
		
	unlink( $ec_file_dest_location );
	if( !file_exists( $ec_file_dest_location ) )
		$can_remove_file = true;
		
	if( $has_zip_class ){
		$zip = new ZipArchive();
		$zip->open( $zip_copy_to_url );
		// Now finish extracting
		$zip->extractTo( $ec_dir_location );
		$zip->close();
		
		if( is_dir( $ec_dir_location . "/products" ) )
			$can_unzip_folder = true;
	}
	
	if( file_exists( $zip_copy_to_url ) ){
		$can_write_zip = true;
		unlink( $zip_copy_to_url );
	}
	
	if( file_exists( $sql_copy_to_url ) ){
		$can_write_sql = true;
		unlink( $sql_copy_to_url );
	}
	
	ec_recursive_remove_dir( $ec_dir_location );
	if( !is_dir( $ec_dir_location ) )
		$can_recursive_remove_dir = true;
		
	if( $has_zip_class && $can_write_zip && $can_write_sql && $can_write_folder && $can_copy_file && $can_remove_file && $can_recursive_remove_dir && $can_unzip_folder )
		return true;
	else
		return false;
}

function ec_recursive_remove_dir( $dir ) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) { 
			if ($object != "." && $object != "..") { 
				if (filetype($dir."/".$object) == "dir") ec_recursive_remove_dir($dir."/".$object); 
				else unlink($dir."/".$object); 
			} 
		} 
		reset($objects); 
		rmdir($dir); 
	} 
}

function ec_basic_settings_setup( ){
	$order_email_set = false;
	$password_email_set = false;
	$admin_email_set = false;
	$terms_set = false;
	$privacy_set = false;
	
	if( get_option( 'ec_option_order_from_email' ) != "youremail@url.com" && get_option( 'ec_option_order_from_email' ) != "" )
		$order_email_set = true;
	
	if( get_option( 'ec_option_password_from_email' ) != "youremail@url.com" && get_option( 'ec_option_password_from_email' ) != "" )
		$password_email_set = true;
	
	if( get_option( 'ec_option_bcc_email_addresses' ) != "youremail@url.com" && get_option( 'ec_option_bcc_email_addresses' ) != "" )
		$admin_email_set = true;
	
	if( get_option( 'ec_option_terms_link' ) != "http://yoursite.com/termsandconditions" && get_option( 'ec_option_terms_link' ) != "" )
		$terms_set = true;
	
	if( get_option( 'ec_option_privacy_link' ) != "http://yoursite.com/privacypolicy" && get_option( 'ec_option_privacy_link' ) != "" )
		$privacy_set = true;
		
	if( $order_email_set && $password_email_set && $admin_email_set && $terms_set && $privacy_set )
		return true;
	else
		return false;
}

function ec_get_basic_missing_settings( ){
	$return_text = array( );
	
	if( get_option( 'ec_option_order_from_email' ) == "youremail@url.com" || get_option( 'ec_option_order_from_email' ) == "" )
		$return_text[] = "order from email address";
	
	if( get_option( 'ec_option_password_from_email' ) == "youremail@url.com" || get_option( 'ec_option_password_from_email' ) == "" )
		$return_text[] = "password from email address";
	
	if( get_option( 'ec_option_bcc_email_addresses' ) == "youremail@url.com" || get_option( 'ec_option_bcc_email_addresses' ) == "" )
		$return_text[] = "receipt copy admin email address";
	
	if( get_option( 'ec_option_terms_link' ) == "http://yoursite.com/termsandconditions" || get_option( 'ec_option_terms_link' ) == "" )
		$return_text[] = "terms and conditions page link";
	
	if( get_option( 'ec_option_privacy_link' ) == "http://yoursite.com/privacypolicy" || get_option( 'ec_option_privacy_link' ) == "" )
		$return_text[] = "privacy policy page link";
		
	return implode( ", ", $return_text );
}

function ec_using_price_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "price" )
		return true;
	else
		return false;
}

function ec_price_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_price_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_price_based ){
			$has_price_shipping = true;
			break;
		}
	}
	return $has_price_shipping;
}

function ec_using_weight_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "weight" )
		return true;
	else
		return false;
}

function ec_weight_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_weight_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_weight_based ){
			$has_weight_shipping = true;
			break;
		}
	}
	return $has_weight_shipping;
}

function ec_using_quantity_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "quantity" )
		return true;
	else
		return false;
}

function ec_quantity_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_quantity_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_quantity_based ){
			$has_quantity_shipping = true;
			break;
		}
	}
	return $has_quantity_shipping;
}

function ec_using_percentage_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "percentage" )
		return true;
	else
		return false;
}

function ec_percentage_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_percentage_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_percentage_based ){
			$has_percentage_shipping = true;
			break;
		}
	}
	return $has_percentage_shipping;
}

function ec_using_method_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "method" )
		return true;
	else
		return false;
}

function ec_method_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_method_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_method_based ){
			$has_method_shipping = true;
			break;
		}
	}
	return $has_method_shipping;
}

function ec_using_live_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "live" )
		return true;
	else
		return false;
}

function ec_live_shipping_setup( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_live_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_ups_based || $shiprate->is_usps_based || $shiprate->is_fedex_based || $shiprate->is_dhl_based || $shiprate->is_auspost_based || $shiprate->is_canadapost_based ){
			$has_live_shipping = true;
			break;
		}
	}
	return $has_live_shipping;
}

function ec_using_ups_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_ups_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_ups_based ){
			$has_ups_shipping = true;
			break;
		}
	}
	return $has_ups_shipping;
}

function ec_ups_shipping_setup( ){
	$ups_has_settings = false;
	$ups_setup = false;
	$ups_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->ups_access_license_number && $setting_row->ups_user_id && $setting_row->ups_password && $setting_row->ups_ship_from_zip && $setting_row->ups_shipper_number && $setting_row->ups_country_code && $setting_row->ups_weight_type ){
		$ups_has_settings = true;
	
		// Run test of the settings
		$ups_class = new ec_ups( $settings );
		$ups_response = $ups_class->get_rate_test( "01", $setting_row->ups_ship_from_zip, $setting_row->ups_country_code, "1" );
		$ups_xml = new SimpleXMLElement($ups_response);
		
		if( $ups_xml->Response->ResponseStatusCode == "1" ){
			$ups_setup = true;
		}else{
			$ups_error_reason = $ups_xml->Response->Error->ErrorCode;
		}
	}
	
	return ( $ups_has_settings && $ups_setup );
}

function ec_using_usps_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_usps_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_usps_based ){
			$has_usps_shipping = true;
			break;
		}
	}
	return $has_usps_shipping;
}

function ec_usps_shipping_setup( ){
	$usps_has_settings = false;
	$usps_setup = false;
	$usps_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->usps_user_name && $setting_row->usps_ship_from_zip ){
		$usps_has_settings = true;
		// Run test of the settings
		$usps_class = new ec_usps( $settings );
		$usps_response = $usps_class->get_rate_test( "PRIORITY", $setting_row->usps_ship_from_zip, "US", "1" );
		$usps_xml = new SimpleXMLElement( $usps_response );
		
		if( $usps_xml->Number )
			$usps_error_reason = 1;
		else if( $usps_xml->Package[0]->Error )
			$usps_error_reason = 2;
		else
			$usps_setup = true;
	}
	
	return ( $usps_has_settings && $usps_setup );
}

function ec_using_fedex_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_fedex_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_fedex_based ){
			$has_fedex_shipping = true;
			break;
		}
	}
	return $has_fedex_shipping;
}

function ec_fedex_shipping_setup( ){
	$fedex_has_settings = false;
	$fedex_setup = false;
	$fedex_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->fedex_key && $setting_row->fedex_account_number && $setting_row->fedex_meter_number && $setting_row->fedex_password && $setting_row->fedex_ship_from_zip && $setting_row->fedex_weight_units && $setting_row->fedex_country_code ){
		$fedex_has_settings = true;
		// Run test of the settings
		
		if( $setting_row->fedex_weight_units != "LB" && $setting_row->fedex_weight_units != "KG" ){
			$fedex_error_reason = 2;
		}else{
			$fedex_class = new ec_fedex( $settings );
			$fedex_response = $fedex_class->get_rate_test( "FEDEX_GROUND", $setting_row->fedex_ship_from_zip, $setting_row->fedex_country_code, "1" );
			
			if( $fedex_response->HighestSeverity == 'FAILURE' || $fedex_response->HighestSeverity == 'ERROR' )
				if( isset( $fedex_response->Notifications->Code ) )
					$fedex_error_reason = $fedex_response->Notifications->Code;
				else
					$fedex_error_reason = $fedex_response->Notifications[0]->Code;
			else
				$fedex_setup = true;
		}
	}
	
	return ( $fedex_has_settings && $fedex_setup );
}

function ec_using_dhl_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_dhl_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_dhl_based ){
			$has_dhl_shipping = true;
			break;
		}
	}
	return $has_dhl_shipping;
}

function ec_dhl_shipping_setup( ){
	$dhl_has_settings = false;
	$dhl_setup = false;
	$dhl_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->dhl_site_id && $setting_row->dhl_password && $setting_row->dhl_ship_from_country && $setting_row->dhl_ship_from_zip && $setting_row->dhl_weight_unit ){
		$dhl_has_settings = true;
		
		// Run test of the settings
		$dhl_class = new ec_dhl( $settings );
		$dhl_response = $dhl_class->get_rate_test( "N", $setting_row->dhl_ship_from_zip, $setting_row->dhl_ship_from_country, "1" );
		$dhl_xml = new SimpleXMLElement( $dhl_response );
		
		if( $dhl_xml && $dhl_xml->Response && $dhl_xml->Response->Status && $dhl_xml->Response->Status->ActionStatus && $dhl_xml->Response->Status->ActionStatus == "Error" ){
			$dhl_error_code = $dhl_xml->Response->Status->Condition->ConditionCode;
			$dhl_error_reason = $dhl_xml->Response->Status->Condition->ConditionData;
		}else if( $dhl_xml && $dhl_xml->Response && $dhl_xml->Response->Note && count( $dhl_xml->Response->Note ) > 0 && $dhl_xml->Response->Note[0]->Status && $dhl_xml->Response->Note[0]->Status->Condition && $dhl_xml->Response->Note[0]->Status->Condition->ConditionData ){
			$dhl_error_reason = $dhl_xml->Response->Note[0]->Status->Condition->ConditionData;
		}else
			$dhl_setup = true;
	}
	
	return ( $dhl_has_settings && $dhl_setup );
}

function ec_using_auspost_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_auspost_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_auspost_based ){
			$has_auspost_shipping = true;
			break;
		}
	}
	return $has_auspost_shipping;
}

function ec_auspost_shipping_setup( ){
	$auspost_has_settings = false;
	$auspost_setup = false;
	$auspost_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->auspost_api_key && $setting_row->auspost_ship_from_zip ){
		$auspost_has_settings = true;
		
		// Run test of the settings
		$auspost_class = new ec_auspost( $settings );
		$auspost_response = $auspost_class->get_rate_test( "AUS_PARCEL_EXPRESS", $setting_row->auspost_ship_from_zip, "AU", "1" );
		
		if( !$auspost_response )
			$auspost_error_reason = "1";
		else
			$auspost_setup = true;
	}
	
	return ( $auspost_has_settings && $auspost_setup );
}

function ec_using_canadapost_shipping( ){
	$db = new ec_db_admin( );
	$shippingrates = $db->get_shipping_data( );
	$has_canadapost_shipping = false;
	foreach( $shippingrates as $shiprate ){
		if( $shiprate->is_canadapost_based ){
			$has_canadapost_shipping = true;
			break;
		}
	}
	return $has_canadapost_shipping;
}

function ec_canadapost_shipping_setup( ){
	$canadapost_has_settings = false;
	$canadapost_setup = false;
	$canadapost_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->canadapost_username && $setting_row->canadapost_password && $setting_row->canadapost_customer_number && $setting_row->canadapost_ship_from_zip ){
		$canadapost_has_settings = true;
		
		// Run test of the settings
		$canadapost_class = new ec_canadapost( $settings );
		$canadapost_response = $canadapost_class->get_rate_test( "DOM.RP", $setting_row->canadapost_ship_from_zip, "CA", "1" );
		
		if( !$canadapost_response )
			$canadapost_error_reason = "1";
		else
			$canadapost_setup = true;
	}
	
	return ( $canadapost_has_settings && $canadapost_setup );
}

function ec_using_fraktjakt_shipping( ){
	$shipping_method = ec_get_shipping_method( );
	if( $shipping_method == "fraktjakt" )
		return true;
	else
		return false;
}

function ec_fraktjakt_shipping_setup( ){
	$fraktjakt_has_settings = false;
	$fraktjakt_setup = false;
	$fraktjakt_error_reason = 0;
	
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );

	if( $setting_row->fraktjakt_customer_id != "" && $setting_row->fraktjakt_login_key != "" ){
		$fraktjakt_has_settings = true;
		
		// Run test of the settings
		$fraktjakt_class = new ec_fraktjakt( $settings );
		$test_user = new ec_user( "" );
		$test_user->setup_shipping_info_data( "", "", "152-153 Fleet St", "", "London", "", "GB", "EC4A2DQ", "" );
		
		$fraktjakt_response = $fraktjakt_class->get_shipping_options_test( $test_user );
		$xml = new SimpleXMLElement( $fraktjakt_response );
		
		if( isset( $xml->shipping_products ) && isset( $xml->shipping_products->shipping_product ) && count( $xml->shipping_products->shipping_product ) > 0 )
			$fraktjakt_setup = true;
		else
			$fraktjakt_error_reason = "1";
			
	}
	
	return ( $fraktjakt_has_settings && $fraktjakt_setup );
}

function ec_get_shipping_method( ){
	$db = new ec_db_admin( );
	$setting_row = $db->get_settings( );
	$settings = new ec_setting( $setting_row );
	$shipping_method = $settings->get_shipping_method( );
	return $shipping_method;
}

function ec_using_no_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	if( count( $taxrates ) > 0 )
		return false;
	else
		return true;
}

function ec_using_state_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	foreach( $taxrates as $taxrate ){
		if( $taxrate->tax_by_state ){
			return true;
		}
	}
	return false;
}

function ec_using_country_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	foreach( $taxrates as $taxrate ){
		if( $taxrate->tax_by_country ){
			return true;
		}
	}
	return false;
}

function ec_using_global_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	foreach( $taxrates as $taxrate ){
		if( $taxrate->tax_by_all ){
			return true;
		}
	}
	return false;
}

function ec_using_duty_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	foreach( $taxrates as $taxrate ){
		if( $taxrate->tax_by_duty ){
			return true;
		}
	}
	return false;
}

function ec_using_vat_tax( ){
	$db = new ec_db_admin( );
	$taxrates = $db->get_taxrates( );
	foreach( $taxrates as $taxrate ){
		if( $taxrate->tax_by_vat ){
			return true;
		}
	}
	return false;
}

function ec_global_vat_setup( ){
	$db = new ec_db_admin( );
	$countries = $GLOBALS['ec_countries']->countries;;
	foreach( $countries as $country ){
		if( $country->vat_rate_cnt > 0 ){
			return true;
		}
	}
	return false;
}

function ec_no_payment_selected( ){
	$manual_payment = get_option( 'ec_option_use_direct_deposit' );
	$affirm = get_option( 'ec_option_use_affirm' );
	$third_party = get_option( 'ec_option_payment_third_party' );
	$live_payment = get_option( 'ec_option_payment_process_method' );
	
	if( $manual_payment || $affirm || $third_party || $live_payment )
		return false;
	else
		return true;
}

function ec_manual_payment_selected( ){
	$manual_payment = get_option( 'ec_option_use_direct_deposit' );
	if( $manual_payment )
		return true;
	else
		return false;
}

function ec_affirm_payment_selected( ){
	$affirm = get_option( 'ec_option_use_affirm' );
	if( $affirm )
		return true;
	else
		return false;
}

function ec_third_party_payment_selected( ){
	$third_party = get_option( 'ec_option_payment_third_party' );
	if( $third_party && $third_party != "0" )
		return true;
	else
		return false;
}

function ec_third_party_payment_setup( ){
	$third_party = get_option( 'ec_option_payment_third_party' );
	if( $third_party == "2checkout_thirdparty" ){
		if( get_option( 'ec_option_2checkout_thirdparty_sid' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "dwolla_thirdparty" ){
		if( get_option( 'ec_option_dwolla_thirdparty_key' ) != "" && get_option( 'ec_option_dwolla_thirdparty_secret' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "nets" ){
		if( get_option( 'ec_option_nets_merchant_id' ) != "" && get_option( 'ec_option_nets_token' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "payfort" ){
		if( get_option( 'ec_option_payfort_access_code' ) != "" && get_option( 'ec_option_payfort_merchant_id' ) != "" && get_option( 'ec_option_payfort_request_phrase' ) != "" && get_option( 'ec_option_payfort_currency_code' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "paypal" ){
		if( get_option( 'ec_option_paypal_email' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "sagepay_paynow_za" ){
		if( get_option( 'ec_option_sagepay_paynow_za_service_key' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "paypal_advanced" ){
		if( get_option( 'ec_option_paypal_advanced_partner' ) != "" && get_option( 'ec_option_paypal_advanced_user' ) != "" && get_option( 'ec_option_paypal_advanced_vendor' ) != "" && get_option( 'ec_option_paypal_advanced_password' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "skrill" ){
		if( get_option( 'ec_option_skrill_merchant_id' ) != "" && get_option( 'ec_option_skrill_company_name' ) != "" && get_option( 'ec_option_skrill_email' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "realex" ){
		if( get_option( 'ec_option_realex_thirdparty_merchant_id' ) != "" && get_option( 'ec_option_realex_thirdparty_secret' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "redsys" ){
		if( get_option( 'ec_option_redsys_merchant_code' ) != "" && get_option( 'ec_option_redsys_terminal' ) != "" && get_option( 'ec_option_redsys_currency' ) != "" && get_option( 'ec_option_redsys_key' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "paymentexpress_thirdparty" ){
		if( get_option( 'ec_option_payment_express_thirdparty_username' ) != "" && get_option( 'ec_option_payment_express_thirdparty_key' ) != "" )
			return true;
		else
			return false;
	}else if( $third_party == "custom_thirdparty" ){
		return true;
	}
}

function ec_get_third_party_method( ){
	$third_party = get_option( 'ec_option_payment_third_party' );
	if( $third_party == "2checkout_thirdparty" )
		return "2Checkout";
	else if( $third_party == "dwolla_thirdparty" )
		return "Dwolla";
	else if( $third_party == "nets" )
		return "Nets Netaxept";
	else if( $third_party == "payfort" )
		return "Payfort";
	else if( $third_party == "paypal" )
		return "PayPal Standard";
	else if( $third_party == "sagepay_paynow_za" )
		return "SagePay Pay Now South Africa";
	else if( $third_party == "paypal_advanced" )
		return "PayPal Advanced";
	else if( $third_party == "skrill" )
		return "Skrill";
	else if( $third_party == "realex" )
		return "RealEx";
	else if( $third_party == "redsys" )
		return "Redsys";
	else if( $third_party == "paymentexpress_thirdparty" )
		return "Payment Express PxPay 2.0";
	else if( $third_party == "custom_thirdparty" )
		return "Custom Gateway";
}

function ec_live_payment_selected( ){
	$live_payment = get_option( 'ec_option_payment_process_method' );
	if( $live_payment && $live_payment != "0" )
		return true;
	else
		return false;
}

function ec_live_payment_setup( ){
	$live_payment = get_option( 'ec_option_payment_process_method' );
	if( $live_payment == "authorize" ){
		if( get_option( 'ec_option_authorize_login_id' ) != "" && get_option( 'ec_option_authorize_trans_key' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "beanstream" ){
		if( get_option( 'ec_option_beanstream_merchant_id' ) != "" && get_option( 'ec_option_beanstream_api_passcode' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "braintree" ){
		if( get_option( 'ec_option_braintree_merchant_id' ) != "" && get_option( 'ec_option_braintree_public_key' ) != "" &&  get_option( 'ec_option_braintree_private_key' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "chronopay" ){
		if( get_option( 'ec_option_chronopay_currency' ) != "" && get_option( 'ec_option_chronopay_product_id' ) != "" &&  get_option( 'ec_option_chronopay_shared_secret' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "eway" ){
		if( get_option( 'ec_option_eway_customer_id' ) != "" || ( get_option( 'ec_option_eway_customer_id' ) != "" && get_option( 'ec_option_eway_api_key' ) != "" ) )
			return true;
		else
			return false;
	}else if( $live_payment == "firstdata" ){
		if( get_option( 'ec_option_firstdatae4_exact_id' ) != "" && get_option( 'ec_option_firstdatae4_password' ) != "" && get_option( 'ec_option_firstdatae4_key_id' ) != "" && get_option( 'ec_option_firstdatae4_key' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "goemerchant" ){
		if( get_option( 'ec_option_goemerchant_trans_center_id' ) != "" && get_option( 'ec_option_goemerchant_gateway_id' ) != "" &&  get_option( 'ec_option_goemerchant_processor_id' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "intuit" ){
		if( get_option( 'ec_option_intuit_app_token' ) != "" && get_option( 'ec_option_intuit_consumer_key' ) != "" && get_option( 'ec_option_intuit_consumer_secret' ) != "" && get_option( 'ec_option_intuit_realm_id' ) != "" && get_option( 'ec_option_intuit_access_token_secret' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "migs" ){
		if( get_option( 'ec_option_migs_signature' ) != "" && get_option( 'ec_option_migs_access_code' ) != "" && get_option( 'ec_option_migs_merchant_id' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "moneris_ca" ){
		if( get_option( 'ec_option_moneris_ca_store_id' ) != "" && get_option( 'ec_option_moneris_ca_api_token' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "moneris_us" ){
		if( get_option( 'ec_option_moneris_us_store_id' ) != "" && get_option( 'ec_option_moneris_us_api_token' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "nmi" ){
		if( get_option( 'ec_option_nmi_username' ) != "" && get_option( 'ec_option_nmi_password' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "payline" ){
		if( get_option( 'ec_option_payline_username' ) != "" && get_option( 'ec_option_payline_password' ) != "" && get_option( 'ec_option_payline_processor_id' ) != "" && get_option( 'ec_option_payline_currency' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "paymentexpress" ){
		if( get_option( 'ec_option_payment_express_username' ) != "" && get_option( 'ec_option_payment_express_password' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "paypal_pro" ){
		if( get_option( 'ec_option_paypal_pro_partner' ) != "" && get_option( 'ec_option_paypal_pro_user' ) != "" &&  get_option( 'ec_option_paypal_pro_vendor' ) != "" &&  get_option( 'ec_option_paypal_pro_password' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "paypal_payments_pro" ){
		if( get_option( 'ec_option_paypal_payments_pro_user' ) != "" && get_option( 'ec_option_paypal_payments_pro_password' ) != "" &&  get_option( 'ec_option_paypal_payments_pro_signature' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "paypoint" ){
		if( get_option( 'ec_option_paypoint_merchant_id' ) != "" && get_option( 'ec_option_paypoint_vpn_password' ) != "" &&  get_option( 'ec_option_paypoint_vpn_password' ) != "0" )
			return true;
		else
			return false;
	}else if( $live_payment == "realex" ){
		if( get_option( 'ec_option_realex_merchant_id' ) != "" && get_option( 'ec_option_realex_secret' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "sagepay" ){
		if( get_option( 'ec_option_sagepay_vendor' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "sagepayus" ){
		if( get_option( 'ec_option_sagepayus_mid' ) != "" && get_option( 'ec_option_sagepayus_mkey' ) != "" && get_option( 'ec_option_sagepayus_application_id' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "securenet" ){
		if( get_option( 'ec_option_securenet_id' ) != "" && get_option( 'ec_option_securenet_secure_key' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "securepay" ){
		if( get_option( 'ec_option_securepay_merchant_id' ) != "" && get_option( 'ec_option_securepay_password' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "stripe" ){
		if( get_option( 'ec_option_stripe_api_key' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "square" ){
		if( get_option( 'ec_option_square_application_id' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "virtualmerchant" ){
		if( get_option( 'ec_option_virtualmerchant_ssl_merchant_id' ) != "" && get_option( 'ec_option_virtualmerchant_ssl_user_id' ) != "" && get_option( 'ec_option_virtualmerchant_ssl_pin' ) != "" )
			return true;
		else
			return false;
	}else if( $live_payment == "custom" ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/ec_customgateway.php' ) )
			return true;
		else
			return false;
	}
}

function ec_get_live_payment_method( ){
	$live_payment = get_option( 'ec_option_payment_process_method' );
	if( $live_payment == "authorize" )
		return "Authorize.Net";
	else if( $live_payment == "beanstream" )
		return "Beanstream";
	else if( $live_payment == "braintree" )
		return "Braintree S2S";
	else if( $live_payment == "chronopay" )
		return "Chronopay";
	else if( $live_payment == "eway" )
		return "Eway";
	else if( $live_payment == "firstdata" )
		return "First Data Global Gateway e4";
	else if( $live_payment == "goemerchant" )
		return "GoeMerchant";
	else if( $live_payment == "intuit" )
		return "Intuit Payments";
	else if( $live_payment == "migs" )
		return "MasterCard Internet Gateway Service (MIGS)";
	else if( $live_payment == "moneris_ca" )
		return "Moneris Canada";
	else if( $live_payment == "moneris_us" )
		return "Moneris US";
	else if( $live_payment == "nmi" )
		return "Network Merchants (NMI)";
	else if( $live_payment == "payline" )
		return "Payline";
	else if( $live_payment == "paymentexpress" )
		return "Payment Express PxPost";
	else if( $live_payment == "paypal_pro" )
		return "PayPal PayFlow Pro";
	else if( $live_payment == "paypal_payments_pro" )
		return "PayPal Payments Pro";
	else if( $live_payment == "paypoint" )
		return "PayPoint";
	else if( $live_payment == "realex" )
		return "Realex";
	else if( $live_payment == "sagepay" )
		return "Sagepay";
	else if( $live_payment == "sagepayus" )
		return "Sagepay US";
	else if( $live_payment == "securenet" )
		return "SecureNet";
	else if( $live_payment == "securepay" )
		return "SecurePay";
	else if( $live_payment == "stripe" )
		return "Stripe";
	else if( $live_payment == "square" )
		return "Square";
	else if( $live_payment == "virtualmerchant" )
		return "Converge (Virtual Merchant)";
	else if( $live_payment == "custom" )
		return "Custom Payment Gateway";
}

function ec_update_pages( $store_id, $account_id, $cart_id ){
	update_option( 'ec_option_storepage', $store_id );
	update_option( 'ec_option_accountpage', $account_id );
	update_option( 'ec_option_cartpage', $cart_id );
}

function ec_add_store_shortcode( $store_id ){
	$the_page = get_page( $store_id );
	
	if( !strstr( $the_page->post_content, '[ec_store' ) ){
		$the_page->post_content = "[ec_store]" . $the_page->post_content;
		wp_update_post( $the_page );
	}
}

function ec_add_account_shortcode( $account_id ){
	$the_page = get_page( $account_id );
	if( !strstr( $the_page->post_content, '[ec_account' ) ){
		$the_page->post_content = "[ec_account]" . $the_page->post_content;
		wp_update_post( $the_page );
	}
}

function ec_add_cart_shortcode( $cart_id ){
	$the_page = get_page( $cart_id );
	if( !strstr( $the_page->post_content, '[ec_cart' ) ){
		$the_page->post_content = "[ec_cart]" . $the_page->post_content;
		wp_update_post( $the_page );
	}
}

function ec_add_store_page( ){
	$post = array( 'post_content' 	=> "[ec_store]",
				   'post_title' 	=> "Store",
				   'post_type'		=> "page",
				   'post_status'	=> "publish"
				 );
	$post_id = wp_insert_post( $post );
	update_option( 'ec_option_storepage', $post_id );
}

function ec_add_account_page( ){
	$post = array( 'post_content' 	=> "[ec_account]",
				   'post_title' 	=> "Account",
				   'post_type'		=> "page",
				   'post_status'	=> "publish"
				 );
	$post_id = wp_insert_post( $post );
	update_option( 'ec_option_accountpage', $post_id );
}

function ec_add_cart_page( ){
	$post = array( 'post_content' 	=> "[ec_cart]",
				   'post_title' 	=> "Cart",
				   'post_type'		=> "page",
				   'post_status'	=> "publish"
				 );
	$post_id = wp_insert_post( $post );
	update_option( 'ec_option_cartpage', $post_id );
}

function ec_install_demo_data( ){
	$datapack_url = 'http://support.wpeasycart.com/sampledata/standard_demo';	
	$install_dir = WP_PLUGIN_DIR . "/wp-easycart-data/";
	copy( $datapack_url . "/standard_demo_assets_V2.zip",  $install_dir . "standard_demo_assets_V2.zip" );
	copy( $datapack_url . "/standard_demo_install_V2.sql",  $install_dir . "standard_demo_install_V2.sql" );
	
	$url = $install_dir . "standard_demo_install_V2.sql";
	
	// Load and explode the sql file
	$f = fopen( $url, "r" );
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	
	//Process the sql file by statements
	global $wpdb;
	foreach( $sqlArray as $stmt ){
		if( strlen($stmt) > 3 ){
			$results = $wpdb->query( $stmt );
		} 
	}
	
	// Unzip Products
	$zip = new ZipArchive();
	$zip->open( $install_dir . "standard_demo_assets_V2.zip" );
	
	// Now that the zip is open sucessfully, we should remove the products folder
	ec_recursive_remove_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products" );
	
	// Now finish extracting
	$zip->extractTo( $install_dir );
	$zip->close();
	unlink( $install_dir . "standard_demo_assets_V2.zip" );
	unlink( $install_dir . "standard_demo_install_V2.sql" );
	
	// NOW LETS UPDATE THE LINKING STRUCTURE
	$db = new ec_db();
	$menulevel1_items = $db->get_menulevel1_items( );
	$menulevel2_items = $db->get_menulevel2_items( );
	$menulevel3_items = $db->get_menulevel3_items( );
	$product_list = $db->get_product_list( "", "", "", "" );
	$manufacturer_list = $db->get_manufacturer_list( );
	$category_list = $db->get_category_list( );
	
	foreach( $menulevel1_items as $menu_item ){
		if( $menu_item->menulevel1_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store menuid=\"" . $menu_item->menulevel1_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu1_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_menu_post_id( $menu_item->menulevel1_id, $post_id );
		}
	}
	
	foreach( $menulevel2_items as $menu_item ){
		if( $menu_item->menulevel2_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store submenuid=\"" . $menu_item->menulevel2_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu2_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_submenu_post_id( $menu_item->menulevel2_id, $post_id );
		}
	}
	
	foreach( $menulevel3_items as $menu_item ){
		if( $menu_item->menulevel3_post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store subsubmenuid=\"" . $menu_item->menulevel3_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->menu3_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_subsubmenu_post_id( $menu_item->menulevel3_id, $post_id );
		}
	}
	
	foreach( $product_list as $product_single ){
		if( $product_single['post_id'] == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product_single['model_number'] . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product_single['title'],
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_product_post_id( $product_single['product_id'], $post_id );
		}
	}
	
	foreach( $manufacturer_list as $manufacturer_single ){
		if( $manufacturer_single->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturer_single->manufacturer_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $manufacturer_single->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_manufacturer_post_id( $manufacturer_single->manufacturer_id, $post_id );
		}
	}

	foreach( $category_list as $category_single ){
		// Add a post id
		$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_single->category_id . "\"]",
						'post_status'	=> "publish",
						'post_title'	=> $category_single->category_name,
						'post_type'		=> "ec_store"
					  );
		$post_id = wp_insert_post( $post );
		$db->update_category_post_id( $category_single->category_id, $post_id );
	}
	
}

function ec_uninstall_demo_data( ){
	$store_posts = get_posts( array( 'post_type' => 'ec_store', 'posts_per_page' => 5000 ) );
	foreach( $store_posts as $store_post ) {
		wp_delete_post( $store_post->ID, true);
	}
	
	$datapack_url = 'http://support.wpeasycart.com/sampledata';
	$install_dir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/";
	copy( $datapack_url . "/demo_uninstall_V2.sql",  $install_dir . "demo_uninstall_V2.sql" );
	$url = $install_dir . "demo_uninstall_V2.sql";
	
	// Load and explode the sql file
	$f = fopen( $url, "r" );
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	
	//Process the sql file by statements
	global $wpdb;
	foreach( $sqlArray as $stmt ){
		if( strlen($stmt) > 3 ){
			$results = $wpdb->query( $stmt );
		} 
	}
	unlink( $install_dir . "demo_uninstall_V2.sql" );
	
	// Now that the zip is open sucessfully, we should remove the products folder
	ec_recursive_remove_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products" );
	ec_fix_data_folders( );
}

function ec_save_basic_settings( ){
	// Basic Settings
	update_option( 'ec_option_terms_link', $_POST['ec_option_terms_link'] );
	update_option( 'ec_option_privacy_link', $_POST['ec_option_privacy_link'] );
	update_option( 'ec_option_weight', $_POST['ec_option_weight'] );
	update_option( 'ec_option_enable_metric_unit_display', $_POST['ec_option_enable_metric_unit_display'] );
	update_option( 'ec_option_show_menu_cart_icon', $_POST['ec_option_show_menu_cart_icon'] );
	if( isset( $_POST['ec_option_cart_menu_id'] ) )
	update_option( 'ec_option_cart_menu_id', implode( '***', $_POST['ec_option_cart_menu_id'] ) );
	update_option( 'ec_option_hide_cart_icon_on_empty', $_POST['ec_option_hide_cart_icon_on_empty'] );
	update_option( 'ec_option_enable_newsletter_popup', $_POST['ec_option_enable_newsletter_popup'] );
	update_option( 'ec_option_hide_live_editor', $_POST['ec_option_hide_live_editor'] );
	update_option( 'ec_option_enable_gateway_log', $_POST['ec_option_enable_gateway_log'] );
	
	// Currency Display
	update_option( 'ec_option_base_currency', $_POST['ec_option_base_currency'] );
	update_option( 'ec_option_currency', $_POST['ec_option_currency'] );
	update_option( 'ec_option_currency_symbol_location', $_POST['ec_option_currency_symbol_location'] );
	update_option( 'ec_option_currency_negative_location', $_POST['ec_option_currency_negative_location'] );
	update_option( 'ec_option_currency_decimal_symbol', $_POST['ec_option_currency_decimal_symbol'] );
	update_option( 'ec_option_currency_decimal_places', $_POST['ec_option_currency_decimal_places'] );
	update_option( 'ec_option_currency_thousands_seperator', $_POST['ec_option_currency_thousands_seperator'] );
	update_option( 'ec_option_show_currency_code', $_POST['ec_option_show_currency_code'] );
	
	// Store Page Display Options
	update_option( 'ec_option_product_layout_type', $_POST['ec_option_product_layout_type'] );
	update_option( 'ec_option_show_featured_categories', $_POST['ec_option_show_featured_categories'] );
	update_option( 'ec_option_default_store_filter', $_POST['ec_option_default_store_filter'] );
	update_option( 'ec_option_product_filter_1', $_POST['ec_option_product_filter_1'] );
	update_option( 'ec_option_product_filter_2', $_POST['ec_option_product_filter_2'] );
	update_option( 'ec_option_product_filter_3', $_POST['ec_option_product_filter_3'] );
	update_option( 'ec_option_product_filter_4', $_POST['ec_option_product_filter_4'] );
	update_option( 'ec_option_product_filter_5', $_POST['ec_option_product_filter_5'] );
	update_option( 'ec_option_product_filter_6', $_POST['ec_option_product_filter_6'] );
	update_option( 'ec_option_product_filter_7', $_POST['ec_option_product_filter_7'] );
	update_option( 'ec_option_enable_product_paging', $_POST['ec_option_enable_product_paging'] );
	update_option( 'ec_option_show_sort_box', $_POST['ec_option_show_sort_box'] );
	update_option( 'ec_option_use_live_search', $_POST['ec_option_use_live_search'] );
	update_option( 'ec_option_search_title', $_POST['ec_option_search_title'] );
	update_option( 'ec_option_search_model_number', $_POST['ec_option_search_model_number'] );
	update_option( 'ec_option_search_manufacturer', $_POST['ec_option_search_manufacturer'] );
	update_option( 'ec_option_search_description', $_POST['ec_option_search_description'] );
	update_option( 'ec_option_search_short_description', $_POST['ec_option_search_short_description'] );
	update_option( 'ec_option_search_menu', $_POST['ec_option_search_menu'] );
	update_option( 'ec_option_search_by_or', $_POST['ec_option_search_by_or'] );
	update_option( 'ec_option_tiered_price_format', $_POST['ec_option_tiered_price_format'] );
	
	// Product Details Page Dispaly Options
	update_option( 'ec_option_use_facebook_icon', $_POST['ec_option_use_facebook_icon'] );
	update_option( 'ec_option_use_twitter_icon', $_POST['ec_option_use_twitter_icon'] );
	update_option( 'ec_option_use_delicious_icon', $_POST['ec_option_use_delicious_icon'] );
	update_option( 'ec_option_use_myspace_icon', $_POST['ec_option_use_myspace_icon'] );
	update_option( 'ec_option_use_linkedin_icon', $_POST['ec_option_use_linkedin_icon'] );
	update_option( 'ec_option_use_email_icon', $_POST['ec_option_use_email_icon'] );
	update_option( 'ec_option_use_digg_icon', $_POST['ec_option_use_digg_icon'] );
	update_option( 'ec_option_use_googleplus_icon', $_POST['ec_option_use_googleplus_icon'] );
	update_option( 'ec_option_use_pinterest_icon', $_POST['ec_option_use_pinterest_icon'] );
	
	// Cart Page Display Options
	update_option( 'ec_option_default_payment_type', $_POST['ec_option_default_payment_type'] );
	update_option( 'ec_option_default_country', $_POST['ec_option_default_country'] );
	update_option( 'ec_option_display_country_top', $_POST['ec_option_display_country_top'] );
	update_option( 'ec_option_minimum_order_total', $_POST['ec_option_minimum_order_total'] );
	update_option( 'ec_option_use_address2', $_POST['ec_option_use_address2'] );
	update_option( 'ec_option_allow_guest', $_POST['ec_option_allow_guest'] );
	update_option( 'ec_option_use_shipping', $_POST['ec_option_use_shipping'] );
	update_option( 'ec_option_user_order_notes', $_POST['ec_option_user_order_notes'] );
	update_option( 'ec_option_show_giftcards', $_POST['ec_option_show_giftcards'] );
	update_option( 'ec_option_show_coupons', $_POST['ec_option_show_coupons'] );
	update_option( 'ec_option_addtocart_return_to_product', $_POST['ec_option_addtocart_return_to_product'] );
	update_option( 'ec_option_skip_cart_login', $_POST['ec_option_skip_cart_login'] );
	update_option( 'ec_option_use_contact_name', $_POST['ec_option_use_contact_name'] );
	update_option( 'ec_option_use_estimate_shipping', $_POST['ec_option_use_estimate_shipping'] );
	update_option( 'ec_option_collect_user_phone', $_POST['ec_option_collect_user_phone'] );
	update_option( 'ec_option_enable_company_name', $_POST['ec_option_enable_company_name'] );
	update_option( 'ec_option_skip_shipping_page', $_POST['ec_option_skip_shipping_page'] );
	update_option( 'ec_option_skip_reivew_screen', $_POST['ec_option_skip_reivew_screen'] );
	update_option( 'ec_option_require_terms_agreement', $_POST['ec_option_require_terms_agreement'] );
	update_option( 'ec_option_collect_tax_on_shipping', $_POST['ec_option_collect_tax_on_shipping'] );
	update_option( 'ec_option_show_card_holder_name', $_POST['ec_option_show_card_holder_name'] );
	update_option( 'ec_option_send_low_stock_emails', $_POST['ec_option_send_low_stock_emails'] );
	update_option( 'ec_option_low_stock_trigger_total', $_POST['ec_option_low_stock_trigger_total'] );
	update_option( 'ec_option_send_out_of_stock_emails', $_POST['ec_option_send_out_of_stock_emails'] );
	update_option( 'ec_option_show_delivery_days_live_shipping', $_POST['ec_option_show_delivery_days_live_shipping'] );
	update_option( 'ec_option_model_number_extension', $_POST['ec_option_model_number_extension'] );
	update_option( 'ec_option_collect_vat_registration_number', $_POST['ec_option_collect_vat_registration_number'] );
	update_option( 'ec_option_validate_vat_registration_number', $_POST['ec_option_validate_vat_registration_number'] );
	update_option( 'ec_option_vatlayer_api_key', $_POST['ec_option_vatlayer_api_key'] );
	update_option( 'ec_option_vat_custom_rate', $_POST['ec_option_vat_custom_rate'] );
	
	update_option( 'ec_option_show_breadcrumbs', $_POST['ec_option_show_breadcrumbs'] );
	update_option( 'ec_option_show_model_number', $_POST['ec_option_show_model_number'] );
	update_option( 'ec_option_show_stock_quantity', $_POST['ec_option_show_stock_quantity'] );
	update_option( 'ec_option_show_categories', $_POST['ec_option_show_categories'] );
	update_option( 'ec_option_show_manufacturer', $_POST['ec_option_show_manufacturer'] );
	update_option( 'ec_option_show_magnification', $_POST['ec_option_show_magnification'] );
	update_option( 'ec_option_show_large_popup', $_POST['ec_option_show_large_popup'] );
	update_option( 'ec_option_customer_review_require_login', $_POST['ec_option_customer_review_require_login'] );
	update_option( 'ec_option_customer_review_show_user_name', $_POST['ec_option_customer_review_show_user_name'] );
	update_option( 'ec_option_hide_price_seasonal', $_POST['ec_option_hide_price_seasonal'] );
	update_option( 'ec_option_hide_price_inquiry', $_POST['ec_option_hide_price_inquiry'] );
	update_option( 'ec_option_show_multiple_vat_pricing', $_POST['ec_option_show_multiple_vat_pricing'] );
	update_option( 'ec_option_deconetwork_allow_blank_products', $_POST['ec_option_deconetwork_allow_blank_products'] );
	update_option( 'ec_option_use_inquiry_form', $_POST['ec_option_use_inquiry_form'] );
	
	// Account Page Display Options
	update_option( 'ec_option_require_account_address', $_POST['ec_option_require_account_address'] );
	update_option( 'ec_option_require_email_validation', $_POST['ec_option_require_email_validation'] );
	update_option( 'ec_option_show_account_subscriptions_link', $_POST['ec_option_show_account_subscriptions_link'] );
	update_option( 'ec_option_enable_user_notes', $_POST['ec_option_enable_user_notes'] );
	update_option( 'ec_option_show_subscriber_feature', $_POST['ec_option_show_subscriber_feature'] );
	
	// Google Analytics Setup
	update_option( 'ec_option_googleanalyticsid', $_POST['ec_option_googleanalyticsid'] );
	
	// Google Adwords Setup
	update_option( 'ec_option_google_adwords_conversion_id', $_POST['ec_option_google_adwords_conversion_id'] );
	update_option( 'ec_option_google_adwords_language', $_POST['ec_option_google_adwords_language'] );
	update_option( 'ec_option_google_adwords_format', $_POST['ec_option_google_adwords_format'] );
	update_option( 'ec_option_google_adwords_color', $_POST['ec_option_google_adwords_color'] );
	update_option( 'ec_option_google_adwords_label', $_POST['ec_option_google_adwords_label'] );
	update_option( 'ec_option_google_adwords_currency', $_POST['ec_option_google_adwords_currency'] );
	update_option( 'ec_option_google_adwords_remarketing_only', $_POST['ec_option_google_adwords_remarketing_only'] );
}

function ec_update_advanced_setup( ){
	update_option( 'ec_option_use_smart_states', $_POST['ec_option_use_smart_states'] );
	update_option( 'ec_option_use_state_dropdown', $_POST['ec_option_use_state_dropdown'] );
	update_option( 'ec_option_use_country_dropdown', $_POST['ec_option_use_country_dropdown'] );
	update_option( 'ec_option_estimate_shipping_zip', $_POST['ec_option_estimate_shipping_zip'] );
	update_option( 'ec_option_estimate_shipping_country', $_POST['ec_option_estimate_shipping_country'] );
	update_option( 'ec_option_use_rtl', $_POST['ec_option_use_rtl'] );
	update_option( 'ec_option_custom_css', $_POST['ec_option_custom_css'] );
	update_option( 'ec_option_match_store_meta', $_POST['ec_option_match_store_meta'] );
	update_option( 'ec_option_use_old_linking_style', $_POST['ec_option_use_old_linking_style'] );
	update_option( 'ec_option_no_vat_on_shipping', $_POST['ec_option_no_vat_on_shipping'] );
	update_option( 'ec_option_display_as_catalog', $_POST['ec_option_display_as_catalog'] );
	update_option( 'ec_option_exchange_rates', $_POST['ec_option_exchange_rates'] );
	update_option( 'ec_option_gift_card_shipping_allowed', $_POST['ec_option_gift_card_shipping_allowed'] );
	update_option( 'ec_option_collect_shipping_for_subscriptions', $_POST['ec_option_collect_shipping_for_subscriptions'] );
	update_option( 'ec_option_restrict_store', implode( '***', $_POST['ec_option_restrict_store'] ) );
	update_option( 'ec_option_use_custom_post_theme_template', $_POST['ec_option_use_custom_post_theme_template'] );
	update_option( 'ec_option_send_signup_email', $_POST['ec_option_send_signup_email'] );
	update_option( 'ec_option_ship_items_seperately', $_POST['ec_option_ship_items_seperately'] );
	update_option( 'ec_option_static_ship_items_seperately', $_POST['ec_option_static_ship_items_seperately'] );
	update_option( 'ec_option_subscription_one_only', $_POST['ec_option_subscription_one_only'] );
	update_option( 'ec_option_fedex_use_net_charge', $_POST['ec_option_fedex_use_net_charge'] );
	update_option( 'ec_option_cart_use_session_support', $_POST['ec_option_cart_use_session_support'] );
	update_option( 'ec_option_amazon_key', $_POST['ec_option_amazon_key'] );
	update_option( 'ec_option_amazon_secret', $_POST['ec_option_amazon_secret'] );
	update_option( 'ec_option_amazon_bucket', $_POST['ec_option_amazon_bucket'] );
	update_option( 'ec_option_amazon_bucket_region', $_POST['ec_option_amazon_bucket_region'] );
	update_option( 'ec_option_deconetwork_url', $_POST['ec_option_deconetwork_url'] );
	update_option( 'ec_option_deconetwork_password', $_POST['ec_option_deconetwork_password'] );
	update_option( 'ec_option_tax_cloud_api_id', $_POST['ec_option_tax_cloud_api_id'] );
	update_option( 'ec_option_tax_cloud_api_key', $_POST['ec_option_tax_cloud_api_key'] );
	update_option( 'ec_option_tax_cloud_address', $_POST['ec_option_tax_cloud_address'] );
	update_option( 'ec_option_tax_cloud_city', $_POST['ec_option_tax_cloud_city'] );
	update_option( 'ec_option_tax_cloud_state', $_POST['ec_option_tax_cloud_state'] );
	update_option( 'ec_option_tax_cloud_zip', $_POST['ec_option_tax_cloud_zip'] );
	
	$canada_tax_options = $_POST['ec_canada_tax'];
	
	update_option( 'ec_option_enable_easy_canada_tax', $_POST['ec_option_enable_easy_canada_tax'] );
	update_option( 'ec_option_canada_tax_options', $canada_tax_options );
	
	if( isset( $canada_tax_options['ec_option_collect_alberta_tax_shopper'] ) )
		update_option( 'ec_option_collect_alberta_tax', 1 );
	else
		update_option( 'ec_option_collect_alberta_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_british_columbia_tax_shopper'] ) )
		update_option( 'ec_option_collect_british_columbia_tax', 1 );
	else
		update_option( 'ec_option_collect_british_columbia_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_manitoba_tax_shopper'] ) )
		update_option( 'ec_option_collect_manitoba_tax', 1 );
	else
		update_option( 'ec_option_collect_manitoba_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_new_brunswick_tax_shopper'] ) )
		update_option( 'ec_option_collect_new_brunswick_tax', 1 );
	else
		update_option( 'ec_option_collect_new_brunswick_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_newfoundland_tax_shopper'] ) )
		update_option( 'ec_option_collect_newfoundland_tax', 1 );
	else
		update_option( 'ec_option_collect_newfoundland_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_northwest_territories_tax_shopper'] ) )
		update_option( 'ec_option_collect_northwest_territories_tax', 1 );
	else
		update_option( 'ec_option_collect_northwest_territories_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_nova_scotia_tax_shopper'] ) )
		update_option( 'ec_option_collect_nova_scotia_tax', 1 );
	else
		update_option( 'ec_option_collect_nova_scotia_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_nunavut_tax_shopper'] ) )
		update_option( 'ec_option_collect_nunavut_tax', 1 );
	else
		update_option( 'ec_option_collect_nunavut_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_ontario_tax_shopper'] ) )
		update_option( 'ec_option_collect_ontario_tax', 1 );
	else
		update_option( 'ec_option_collect_ontario_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_prince_edward_island_tax_shopper'] ) )
		update_option( 'ec_option_collect_prince_edward_island_tax', 1 );
	else
		update_option( 'ec_option_collect_prince_edward_island_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_quebec_tax_shopper'] ) )
		update_option( 'ec_option_collect_quebec_tax', 1 );
	else
		update_option( 'ec_option_collect_quebec_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_saskatchewan_tax_shopper'] ) )
		update_option( 'ec_option_collect_saskatchewan_tax', 1 );
	else
		update_option( 'ec_option_collect_saskatchewan_tax', 0 );
	
	if( isset( $canada_tax_options['ec_option_collect_yukon_tax_shopper'] ) )
		update_option( 'ec_option_collect_yukon_tax', 1 );
	else
		update_option( 'ec_option_collect_yukon_tax', 0 );
	
	do_action( 'wpeasycart_admin_process_advanced_options' );
	
	//update sizes
	$responsive_sizes = get_option( 'ec_option_responsive_sizes' ); 
	$sizes_split = explode( ":::", $responsive_sizes );
	
	$responsive_sizes = "";
	
	for( $i=0; $i<count($sizes_split); $i++ ){
		$temp_split = explode( "=", $sizes_split[$i] );
		$key = $temp_split[0];
		if( isset( $_POST[$key] ) )
			$val = $_POST[$key];
		else
			$val = "";
		if( $i>0 )
			$responsive_sizes .= ":::";
		$responsive_sizes .= $key . "=" . $val;
	}
	
	update_option( 'ec_option_responsive_sizes', $responsive_sizes );
	
	//update colors
	$css_options = get_option( 'ec_option_css_replacements' ); 
	$css_split = explode( ",", $css_options );
	
	$css_options = "";
	
	for( $i=0; $i<count($css_split); $i++ ){
		$temp_split = explode( "=", $css_split[$i] );
		$key = $temp_split[0];
		if( isset( $_POST[$key] ) )
			$val = $_POST[$key];
		else
			$val = "";
		if( $i>0 )
			$css_options .= ",";
		$css_options .= $key . "=" . $val;
	}
	update_option( 'ec_option_css_replacements', $css_options );
	
	//update fonts
	$font_options = get_option( 'ec_option_font_replacements' ); 
	$font_split = explode( ":::", $font_options );
	
	$font_options = "";
	
	for( $i=0; $i<count($font_split); $i++ ){
		$temp_split = explode( "=", $font_split[$i] );
		$key = $temp_split[0];
		if( isset( $_POST[$key] ) )
			$val = $_POST[$key];
		else
			$val = "";
		if( $i>0 )
			$font_options .= ":::";
		$font_options .= $key . "=" . $val;
	}
	update_option( 'ec_option_font_replacements', $font_options );
	
	// CSS may have been updated, regenerate this file...
	ec_regenerate_css( );
	ec_regenerate_js( );
	update_option( 'ec_option_cached_date', time( ) );
}

function ec_update_colors( ){
	
	// V2
	if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){ 
		
		//update options
		$css_options = get_option( 'ec_option_css_replacements' ); 
		$css_split = explode( ",", $css_options );
		
		$css_options = "";
		
		for( $i=0; $i<count($css_split); $i++ ){
			$temp_split = explode( "=", $css_split[$i] );
			$key = $temp_split[0];
			$val = $_POST[$key];
			if( $i>0 )
				$css_options .= ",";
			$css_options .= $key . "=" . $val;
		}
		update_option( 'ec_option_css_replacements', $css_options );
		
		// CSS may have been updated, regenerate this file...
		ec_regenerate_css( );
		ec_regenerate_js( );
		update_option( 'ec_option_cached_date', time( ) );
		
	//V3
	}else{
		// Colors
		update_option( 'ec_option_details_main_color', $_POST['ec_option_details_main_color'] );
		update_option( 'ec_option_details_second_color', $_POST['ec_option_details_second_color'] );
		update_option( 'ec_option_use_dark_bg', $_POST['ec_option_use_dark_bg'] );
		
		// Product Options
		update_option( 'ec_option_default_product_type', $_POST['ec_option_default_product_type'] );
		update_option( 'ec_option_default_product_image_hover_type', $_POST['ec_option_default_product_image_hover_type'] );
		update_option( 'ec_option_default_product_image_effect_type', $_POST['ec_option_default_product_image_effect_type'] );
		update_option( 'ec_option_default_quick_view', $_POST['ec_option_default_quick_view'] );
		update_option( 'ec_option_default_dynamic_sizing', $_POST['ec_option_default_dynamic_sizing'] );
		
		// Product Columns and Image Height
		update_option( 'ec_option_default_desktop_columns', $_POST['ec_option_default_desktop_columns'] );
		update_option( 'ec_option_default_desktop_image_height', $_POST['ec_option_default_desktop_image_height'] );
		
		update_option( 'ec_option_default_laptop_columns', $_POST['ec_option_default_laptop_columns'] );
		update_option( 'ec_option_default_laptop_image_height', $_POST['ec_option_default_laptop_image_height'] );
		
		update_option( 'ec_option_default_tablet_wide_columns', $_POST['ec_option_default_tablet_wide_columns'] );
		update_option( 'ec_option_default_tablet_wide_image_height', $_POST['ec_option_default_tablet_wide_image_height'] );
		
		update_option( 'ec_option_default_tablet_columns', $_POST['ec_option_default_tablet_columns'] );
		update_option( 'ec_option_default_tablet_image_height', $_POST['ec_option_default_tablet_image_height'] );
		
		update_option( 'ec_option_default_smartphone_columns', $_POST['ec_option_default_smartphone_columns'] );
		update_option( 'ec_option_default_smartphone_image_height', $_POST['ec_option_default_smartphone_image_height'] );
		
		// Product Details Columns
		update_option( 'ec_option_details_columns_desktop', $_POST['ec_option_details_columns_desktop'] );
		update_option( 'ec_option_details_columns_laptop', $_POST['ec_option_details_columns_laptop'] );
		update_option( 'ec_option_details_columns_tablet_wide', $_POST['ec_option_details_columns_tablet_wide'] );
		update_option( 'ec_option_details_columns_tablet', $_POST['ec_option_details_columns_tablet'] );
		update_option( 'ec_option_details_columns_smartphone', $_POST['ec_option_details_columns_smartphone'] );
		
		// Cart Columns
		update_option( 'ec_option_cart_columns_desktop', $_POST['ec_option_cart_columns_desktop'] );
		update_option( 'ec_option_cart_columns_laptop', $_POST['ec_option_cart_columns_laptop'] );
		update_option( 'ec_option_cart_columns_tablet_wide', $_POST['ec_option_cart_columns_tablet_wide'] );
		update_option( 'ec_option_cart_columns_tablet', $_POST['ec_option_cart_columns_tablet'] );
		update_option( 'ec_option_cart_columns_smartphone', $_POST['ec_option_cart_columns_smartphone'] );
		
	}

}

function ec_update_payment_info( ){
	//manual payment message
	update_option( 'ec_option_use_direct_deposit', $_POST['ec_option_use_direct_deposit'] );
	update_option( 'ec_option_direct_deposit_message', $_POST['ec_option_direct_deposit_message'] );
	
	//Affirm payment options
	update_option( 'ec_option_use_affirm', $_POST['ec_option_use_affirm'] );
	update_option( 'ec_option_affirm_public_key', $_POST['ec_option_affirm_public_key'] );
	update_option( 'ec_option_affirm_private_key', $_POST['ec_option_affirm_private_key'] );
	update_option( 'ec_option_affirm_financial_product', $_POST['ec_option_affirm_financial_product'] );
	update_option( 'ec_option_affirm_sandbox_account', $_POST['ec_option_affirm_sandbox_account'] );
		
	//proxy settings
	update_option( 'ec_option_use_proxy', $_POST['ec_option_use_proxy'] );
	update_option( 'ec_option_proxy_address', $_POST['ec_option_proxy_address'] );
	
	if( isset( $_POST['ec_option_payment_third_party'] ) ){
		update_option( 'ec_option_payment_third_party', $_POST['ec_option_payment_third_party'] );
		//2checkout third party
		update_option( 'ec_option_2checkout_thirdparty_sid', $_POST['ec_option_2checkout_thirdparty_sid'] );
		update_option( 'ec_option_2checkout_thirdparty_secret_word', $_POST['ec_option_2checkout_thirdparty_secret_word'] );
		update_option( 'ec_option_2checkout_thirdparty_currency_code', $_POST['ec_option_2checkout_thirdparty_currency_code'] );
		update_option( 'ec_option_2checkout_thirdparty_lang', $_POST['ec_option_2checkout_thirdparty_lang'] );
		update_option( 'ec_option_2checkout_thirdparty_purchase_step', $_POST['ec_option_2checkout_thirdparty_purchase_step'] );
		update_option( 'ec_option_2checkout_thirdparty_sandbox_mode', $_POST['ec_option_2checkout_thirdparty_sandbox_mode'] );
		update_option( 'ec_option_2checkout_thirdparty_demo_mode', $_POST['ec_option_2checkout_thirdparty_demo_mode'] );
		//dwolla third party
		update_option( 'ec_option_dwolla_thirdparty_account_id', $_POST['ec_option_dwolla_thirdparty_account_id'] );
		update_option( 'ec_option_dwolla_thirdparty_key', $_POST['ec_option_dwolla_thirdparty_key'] );
		update_option( 'ec_option_dwolla_thirdparty_secret', $_POST['ec_option_dwolla_thirdparty_secret'] ); 
		update_option( 'ec_option_dwolla_thirdparty_test_mode', $_POST['ec_option_dwolla_thirdparty_test_mode'] );            
		//Nets
		update_option( 'ec_option_nets_merchant_id', $_POST['ec_option_nets_merchant_id'] );
		update_option( 'ec_option_nets_token', $_POST['ec_option_nets_token'] );
		update_option( 'ec_option_nets_currency', $_POST['ec_option_nets_currency'] );
		update_option( 'ec_option_nets_test_mode', $_POST['ec_option_nets_test_mode'] );
		//Payfort
		update_option( 'ec_option_payfort_merchant_id', $_POST['ec_option_payfort_merchant_id'] );
		update_option( 'ec_option_payfort_access_code', $_POST['ec_option_payfort_access_code'] );
		update_option( 'ec_option_payfort_sha_type', $_POST['ec_option_payfort_sha_type'] );
		update_option( 'ec_option_payfort_request_phrase', $_POST['ec_option_payfort_request_phrase'] );
		update_option( 'ec_option_payfort_response_phrase', $_POST['ec_option_payfort_response_phrase'] );
		update_option( 'ec_option_payfort_language', $_POST['ec_option_payfort_language'] );
		update_option( 'ec_option_payfort_currency_code', $_POST['ec_option_payfort_currency_code'] );
		update_option( 'ec_option_payfort_use_currency_service', $_POST['ec_option_payfort_use_currency_service'] );
		update_option( 'ec_option_payfort_use_sadad', $_POST['ec_option_payfort_use_sadad'] );
		update_option( 'ec_option_payfort_use_naps', $_POST['ec_option_payfort_use_naps'] );
		update_option( 'ec_option_payfort_sadad_olp', $_POST['ec_option_payfort_sadad_olp'] );
		update_option( 'ec_option_payfort_test_mode', $_POST['ec_option_payfort_test_mode'] );
		//PayPal Standard
		update_option( 'ec_option_paypal_email', $_POST['ec_option_paypal_email'] );
		update_option( 'ec_option_paypal_currency_code', $_POST['ec_option_paypal_currency_code'] );
		update_option( 'ec_option_paypal_use_selected_currency', $_POST['ec_option_paypal_use_selected_currency'] );
		update_option( 'ec_option_paypal_lc', $_POST['ec_option_paypal_lc'] );
		update_option( 'ec_option_paypal_charset', $_POST['ec_option_paypal_charset'] );
		update_option( 'ec_option_paypal_use_sandbox', $_POST['ec_option_paypal_use_sandbox'] );
		update_option( 'ec_option_paypal_weight_unit', $_POST['ec_option_paypal_weight_unit'] );
		update_option( 'ec_option_paypal_collect_shipping', $_POST['ec_option_paypal_collect_shipping'] );
		update_option( 'ec_option_paypal_send_shipping_address', $_POST['ec_option_paypal_send_shipping_address'] );
		// SagePay PayNow South Africa
		update_option( 'ec_option_sagepay_paynow_za_service_key', $_POST['ec_option_sagepay_paynow_za_service_key'] );	
		//PaymentExpress Third Party
		update_option( 'ec_option_payment_express_thirdparty_username', $_POST['ec_option_payment_express_thirdparty_username'] );
		update_option( 'ec_option_payment_express_thirdparty_key', $_POST['ec_option_payment_express_thirdparty_key'] );
		update_option( 'ec_option_payment_express_thirdparty_currency', $_POST['ec_option_payment_express_thirdparty_currency'] );
		//Realex Third Party
		update_option( 'ec_option_realex_thirdparty_merchant_id', $_POST['ec_option_realex_thirdparty_merchant_id'] );
		update_option( 'ec_option_realex_thirdparty_secret', $_POST['ec_option_realex_thirdparty_secret'] );
		update_option( 'ec_option_realex_thirdparty_currency', $_POST['ec_option_realex_thirdparty_currency'] );
		//Redsys
		update_option( 'ec_option_redsys_merchant_code', $_POST['ec_option_redsys_merchant_code'] );
		update_option( 'ec_option_redsys_terminal', $_POST['ec_option_redsys_terminal'] );
		update_option( 'ec_option_redsys_currency', $_POST['ec_option_redsys_currency'] );
		update_option( 'ec_option_redsys_key', $_POST['ec_option_redsys_key'] );
		update_option( 'ec_option_redsys_test_mode', $_POST['ec_option_redsys_test_mode'] );
		//Skrill
		update_option( 'ec_option_skrill_merchant_id', $_POST['ec_option_skrill_merchant_id'] );
		update_option( 'ec_option_skrill_company_name', $_POST['ec_option_skrill_company_name'] );
		update_option( 'ec_option_skrill_email', $_POST['ec_option_skrill_email'] );
		update_option( 'ec_option_skrill_language', $_POST['ec_option_skrill_language'] );
		update_option( 'ec_option_skrill_currency_code', $_POST['ec_option_skrill_currency_code'] );
		// Custom Third Party
		update_option( 'ec_option_custom_third_party', $_POST['ec_option_custom_third_party'] );
	}
	
	if( isset( $_POST['ec_option_payment_process_method'] ) ){
		//payment choices
		update_option( 'ec_option_use_visa', $_POST['ec_option_use_visa'] );
		update_option( 'ec_option_use_delta', $_POST['ec_option_use_delta'] );
		update_option( 'ec_option_use_uke', $_POST['ec_option_use_uke'] );
		update_option( 'ec_option_use_discover', $_POST['ec_option_use_discover'] );
		update_option( 'ec_option_use_mastercard', $_POST['ec_option_use_mastercard'] );
		update_option( 'ec_option_use_mcdebit', $_POST['ec_option_use_mcdebit'] );
		update_option( 'ec_option_use_amex', $_POST['ec_option_use_amex'] );
		update_option( 'ec_option_use_jcb', $_POST['ec_option_use_jcb'] );
		update_option( 'ec_option_use_diners', $_POST['ec_option_use_diners'] );
		update_option( 'ec_option_use_laser', $_POST['ec_option_use_laser'] );
		update_option( 'ec_option_use_maestro', $_POST['ec_option_use_maestro'] );
		//payment method
		update_option( 'ec_option_payment_process_method', $_POST['ec_option_payment_process_method'] );
		//authorize.net
		update_option( 'ec_option_authorize_login_id', $_POST['ec_option_authorize_login_id'] );
		update_option( 'ec_option_authorize_trans_key', $_POST['ec_option_authorize_trans_key'] );
		update_option( 'ec_option_authorize_test_mode', $_POST['ec_option_authorize_test_mode'] );
		update_option( 'ec_option_authorize_developer_account', $_POST['ec_option_authorize_developer_account'] );
		update_option( 'ec_option_authorize_use_legacy_url', $_POST['ec_option_authorize_use_legacy_url'] );
		update_option( 'ec_option_authorize_currency_code', $_POST['ec_option_authorize_currency_code'] );
		//Beanstream
		update_option( 'ec_option_beanstream_merchant_id', $_POST['ec_option_beanstream_merchant_id'] );
		update_option( 'ec_option_beanstream_api_passcode', $_POST['ec_option_beanstream_api_passcode'] );
		//Braintree
		update_option( 'ec_option_braintree_merchant_id', $_POST['ec_option_braintree_merchant_id'] );
		update_option( 'ec_option_braintree_public_key', $_POST['ec_option_braintree_public_key'] );
		update_option( 'ec_option_braintree_private_key', $_POST['ec_option_braintree_private_key'] );
		update_option( 'ec_option_braintree_currency', $_POST['ec_option_braintree_currency'] );
		update_option( 'ec_option_braintree_environment', $_POST['ec_option_braintree_environment'] );
		//Centinal Cardinal
		update_option( 'ec_option_cardinal_processor_id', $_POST['ec_option_cardinal_processor_id'] );
		update_option( 'ec_option_cardinal_merchant_id', $_POST['ec_option_cardinal_merchant_id'] );
		update_option( 'ec_option_cardinal_password', $_POST['ec_option_cardinal_password'] );
		update_option( 'ec_option_cardinal_currency', $_POST['ec_option_cardinal_currency'] );
		update_option( 'ec_option_cardinal_test_mode', $_POST['ec_option_cardinal_test_mode'] );
		//chronopay
		update_option( 'ec_option_chronopay_currency', $_POST['ec_option_chronopay_currency'] );
		update_option( 'ec_option_chronopay_product_id', $_POST['ec_option_chronopay_product_id'] );
		update_option( 'ec_option_chronopay_shared_secret', $_POST['ec_option_chronopay_shared_secret'] );          
		//eway
		update_option( 'ec_option_eway_use_rapid_pay', $_POST['ec_option_eway_use_rapid_pay'] );
		update_option( 'ec_option_eway_customer_id', $_POST['ec_option_eway_customer_id'] );
		update_option( 'ec_option_eway_api_key', $_POST['ec_option_eway_api_key'] );
		update_option( 'ec_option_eway_api_password', $_POST['ec_option_eway_api_password'] );
		update_option( 'ec_option_eway_client_key', $_POST['ec_option_eway_client_key'] );
		update_option( 'ec_option_eway_test_mode', $_POST['ec_option_eway_test_mode'] );  
		update_option( 'ec_option_eway_test_mode_success', $_POST['ec_option_eway_test_mode_success'] );           
		//firstdatae4
		update_option( 'ec_option_firstdatae4_exact_id', $_POST['ec_option_firstdatae4_exact_id'] );
		update_option( 'ec_option_firstdatae4_password', $_POST['ec_option_firstdatae4_password'] );
		update_option( 'ec_option_firstdatae4_key_id', $_POST['ec_option_firstdatae4_key_id'] );
		update_option( 'ec_option_firstdatae4_key', $_POST['ec_option_firstdatae4_key'] );
		update_option( 'ec_option_firstdatae4_language', $_POST['ec_option_firstdatae4_language'] );
		update_option( 'ec_option_firstdatae4_currency', $_POST['ec_option_firstdatae4_currency'] ); 
		update_option( 'ec_option_firstdatae4_test_mode', $_POST['ec_option_firstdatae4_test_mode'] ); 
		//goEmerchant
		update_option( 'ec_option_goemerchant_gateway_id', $_POST['ec_option_goemerchant_gateway_id'] ); 
		update_option( 'ec_option_goemerchant_processor_id', $_POST['ec_option_goemerchant_processor_id'] ); 
		update_option( 'ec_option_goemerchant_trans_center_id', $_POST['ec_option_goemerchant_trans_center_id'] );          
		//Intuit Payments
		update_option( 'ec_option_intuit_app_token', $_POST['ec_option_intuit_app_token'] );
		update_option( 'ec_option_intuit_consumer_key', $_POST['ec_option_intuit_consumer_key'] );
		update_option( 'ec_option_intuit_consumer_secret', $_POST['ec_option_intuit_consumer_secret'] );
		update_option( 'ec_option_intuit_currency', $_POST['ec_option_intuit_currency'] );
		update_option( 'ec_option_intuit_test_mode', $_POST['ec_option_intuit_test_mode'] );
		//MIGS
		update_option( 'ec_option_migs_signature', $_POST['ec_option_migs_signature'] );
		update_option( 'ec_option_migs_access_code', $_POST['ec_option_migs_access_code'] );
		update_option( 'ec_option_migs_merchant_id', $_POST['ec_option_migs_merchant_id'] );
		//Moneris CA
		update_option( 'ec_option_moneris_ca_store_id', $_POST['ec_option_moneris_ca_store_id'] );
		update_option( 'ec_option_moneris_ca_api_token', $_POST['ec_option_moneris_ca_api_token'] );
		update_option( 'ec_option_moneris_ca_test_mode', $_POST['ec_option_moneris_ca_test_mode'] );
		//Moneris US
		update_option( 'ec_option_moneris_us_store_id', $_POST['ec_option_moneris_us_store_id'] );
		update_option( 'ec_option_moneris_us_api_token', $_POST['ec_option_moneris_us_api_token'] );
		update_option( 'ec_option_moneris_us_test_mode', $_POST['ec_option_moneris_us_test_mode'] );
		//NMI
		update_option( 'ec_option_nmi_3ds', $_POST['ec_option_nmi_3ds'] );
		update_option( 'ec_option_nmi_api_key', $_POST['ec_option_nmi_api_key'] );
		update_option( 'ec_option_nmi_username', $_POST['ec_option_nmi_username'] );
		update_option( 'ec_option_nmi_password', $_POST['ec_option_nmi_password'] );
		update_option( 'ec_option_nmi_currency', $_POST['ec_option_nmi_currency'] );
		update_option( 'ec_option_nmi_processor_id', $_POST['ec_option_nmi_processor_id'] );
		update_option( 'ec_option_nmi_ship_from_zip', $_POST['ec_option_nmi_ship_from_zip'] );
		update_option( 'ec_option_nmi_commodity_code', $_POST['ec_option_nmi_commodity_code'] );
		//Payline
		update_option( 'ec_option_payline_username', $_POST['ec_option_payline_username'] );
		update_option( 'ec_option_payline_password', $_POST['ec_option_payline_password'] );
		update_option( 'ec_option_payline_currency', $_POST['ec_option_payline_currency'] );
		//PaymentExpress
		update_option( 'ec_option_payment_express_username', $_POST['ec_option_payment_express_username'] );
		update_option( 'ec_option_payment_express_password', $_POST['ec_option_payment_express_password'] );
		update_option( 'ec_option_payment_express_currency', $_POST['ec_option_payment_express_currency'] );
		update_option( 'ec_option_payment_express_developer_account', $_POST['ec_option_payment_express_developer_account'] );
		//PayPal PayFlow Pro
		update_option( 'ec_option_paypal_pro_test_mode', $_POST['ec_option_paypal_pro_test_mode'] );
		update_option( 'ec_option_paypal_pro_vendor', $_POST['ec_option_paypal_pro_vendor'] );
		update_option( 'ec_option_paypal_pro_partner', $_POST['ec_option_paypal_pro_partner'] );
		update_option( 'ec_option_paypal_pro_user', $_POST['ec_option_paypal_pro_user'] );
		update_option( 'ec_option_paypal_pro_password', $_POST['ec_option_paypal_pro_password'] );
		update_option( 'ec_option_paypal_pro_currency', $_POST['ec_option_paypal_pro_currency'] );
		//PayPal Payments Pro
		update_option( 'ec_option_paypal_payments_pro_test_mode', $_POST['ec_option_paypal_payments_pro_test_mode'] );
		update_option( 'ec_option_paypal_payments_pro_user', $_POST['ec_option_paypal_payments_pro_user'] );
		update_option( 'ec_option_paypal_payments_pro_password', $_POST['ec_option_paypal_payments_pro_password'] );
		update_option( 'ec_option_paypal_payments_pro_signature', $_POST['ec_option_paypal_payments_pro_signature'] );
		update_option( 'ec_option_paypal_payments_pro_currency', $_POST['ec_option_paypal_payments_pro_currency'] );	
		//PayPoint
		update_option( 'ec_option_paypoint_merchant_id', $_POST['ec_option_paypoint_merchant_id'] );
		update_option( 'ec_option_paypoint_vpn_password', $_POST['ec_option_paypoint_vpn_password'] );
		update_option( 'ec_option_paypoint_test_mode', $_POST['ec_option_paypoint_test_mode'] );
		//Realex
		update_option( 'ec_option_realex_merchant_id', $_POST['ec_option_realex_merchant_id'] );
		update_option( 'ec_option_realex_secret', $_POST['ec_option_realex_secret'] );
		update_option( 'ec_option_realex_currency', $_POST['ec_option_realex_currency'] );
		update_option( 'ec_option_realex_3dsecure', $_POST['ec_option_realex_3dsecure'] );
		//Sagepay
		update_option( 'ec_option_sagepay_vendor', $_POST['ec_option_sagepay_vendor'] );
		update_option( 'ec_option_sagepay_currency', $_POST['ec_option_sagepay_currency'] );
		update_option( 'ec_option_sagepay_testmode', $_POST['ec_option_sagepay_testmode'] );
		//Sagepay US
		update_option( 'ec_option_sagepayus_mid', $_POST['ec_option_sagepayus_mid'] );
		update_option( 'ec_option_sagepayus_mkey', $_POST['ec_option_sagepayus_mkey'] );
		update_option( 'ec_option_sagepayus_application_id', $_POST['ec_option_sagepayus_application_id'] );
		//SecureNet
		update_option( 'ec_option_securenet_id', $_POST['ec_option_securenet_id'] );
		update_option( 'ec_option_securenet_secure_key', $_POST['ec_option_securenet_secure_key'] );
		update_option( 'ec_option_securenet_use_sandbox', $_POST['ec_option_securenet_use_sandbox'] );
		//Securepay
		update_option( 'ec_option_securepay_merchant_id', $_POST['ec_option_securepay_merchant_id'] );
		update_option( 'ec_option_securepay_password', $_POST['ec_option_securepay_password'] );
		update_option( 'ec_option_securepay_currency', $_POST['ec_option_securepay_currency'] );
		update_option( 'ec_option_securepay_test_mode', $_POST['ec_option_securepay_test_mode'] );
		//Stripe
		update_option( 'ec_option_stripe_api_key', $_POST['ec_option_stripe_api_key'] );
		update_option( 'ec_option_stripe_currency', $_POST['ec_option_stripe_currency'] );
		if( isset( $_POST['ec_option_stripe_order_create_customer'] ) )
			update_option( 'ec_option_stripe_order_create_customer', 1 );
		else
			update_option( 'ec_option_stripe_order_create_customer', 0 );
		//Square
		update_option( 'ec_option_square_application_id', $_POST['ec_option_square_application_id'] );
		update_option( 'ec_option_square_access_token', $_POST['ec_option_square_access_token'] );
		//Converge (Virtual Merchant)
		update_option( 'ec_option_virtualmerchant_ssl_merchant_id', $_POST['ec_option_virtualmerchant_ssl_merchant_id'] );
		update_option( 'ec_option_virtualmerchant_ssl_user_id', $_POST['ec_option_virtualmerchant_ssl_user_id'] );
		update_option( 'ec_option_virtualmerchant_ssl_pin', $_POST['ec_option_virtualmerchant_ssl_pin'] );
		update_option( 'ec_option_virtualmerchant_demo_account', $_POST['ec_option_virtualmerchant_demo_account'] );
	}
}

function ec_update_language_file( $language ){
	update_option( 'ec_option_language', $_POST['ec_option_language'] );
	$language->save_language_data( );
}

function ec_update_selected_design( ){
	update_option( 'ec_option_base_theme', $_POST['ec_option_base_theme'] );
	update_option( 'ec_option_base_layout', $_POST['ec_option_base_layout'] );
}

function ec_design_management_update( ){
	//////////////////////////////////////////////////////
	//Theme Uploader
	//////////////////////////////////////////////////////
	if( $_FILES && $_FILES["theme_file"]["name"] ) {
		
		$filename = $_FILES["theme_file"]["name"];
		$source = $_FILES["theme_file"]["tmp_name"];
		$type = $_FILES["theme_file"]["type"];
		
		$theme_message = "";
		
		$name = explode(".", $filename);
		$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
		foreach($accepted_types as $mime_type) {
			if($mime_type == $type) {
				$okay = true;
				break;
			} 
		}
		
		$continue = strtolower($name[1]) == 'zip' ? true : false;
		if(!$continue) {
			$theme_message .= " The theme file you are trying to upload is not a .zip file. Please try again.<br>";
		}
		/* PHP current path */
		$path = dirname(__FILE__).'/';
		$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
		$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
		$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/". $filenoext; // target directory
		$targetdir2 = WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/". $filenoext; // target directory
		$targetzip = $path . $filename; // target zip file
		
		if( is_writable( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/" ) ){ // If we can create the dir, do it, otherwise ftp it.
			if (is_dir($targetdir))  wpeasycart_rmdir_recursive ( $targetdir);
			mkdir($targetdir, 0777);
			if (is_dir($targetdir2))  wpeasycart_rmdir_recursive ( $targetdir2);
			mkdir($targetdir2, 0777);
			
			if( is_dir( $targetdir2 ) )
				$theme_message .= " The theme directory was created successfully.<br>";
			else
				$theme_message .= " The theme directory was NOT created, please try again.<br>";
		  
		}else{
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user1'];
			$ftp_user_pass = $_POST['ec_ftp_pass1'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				$theme_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
			}else{
				ftp_mkdir( $conn_id, $targetdir );
				ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
				
				ftp_mkdir( $conn_id, $targetdir2 );
				ftp_site( $conn_id, "CHMOD 0777 " . $targetdir2 );
				
				if( is_dir( $targetdir ) )
					$theme_message .= " The theme directory was created successfully via FTP.<br>";
				else
					$theme_message .= " The theme directory was NOT created, failed via FTP, please try again.<br>";
			}
		}
		
		if( !is_dir( $targetdir2 ) ){
			// Already added message about the dir.
		}else{
			$zip = new ZipArchive();
			$x = $zip->open( $_FILES["theme_file"]["tmp_name"] );  // open the zip file to extract 
			if( $x === true ) {
				$zip->extractTo( $targetdir ); // place in the directory with same name  
				$zip->extractTo( $targetdir2 ); // place in the directory with same name  
				$zip->close();
				$theme_message .= "Your EasyCart theme file was uploaded and unpacked. You may select from the Base Design above.";
				update_option( 'ec_option_base_theme', $filenoext );
			}else{
				$theme_message .= "Could not open the uploaded zip file. Please try again.";
			}
		}
	}
		
	//////////////////////////////////////////////////////
	//layout uploader
	//////////////////////////////////////////////////////
	if( $_FILES && $_FILES["layout_file"]["name"] ) {
		
		$filename = $_FILES["layout_file"]["name"];
		$source = $_FILES["layout_file"]["tmp_name"];
		$type = $_FILES["layout_file"]["type"];
		
		$layout_message = "";
		
		$name = explode(".", $filename);
		$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
		foreach($accepted_types as $mime_type) {
			if($mime_type == $type) {
				$okay = true;
				break;
			} 
		}
		
		$continue = strtolower($name[1]) == 'zip' ? true : false;
		if(!$continue) {
			$layout_message .= " The layout file you are trying to upload is not a .zip file. Please try again.<br>";
		}
		/* PHP current path */
		$path = dirname(__FILE__).'/';
		$filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
		$filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
		$targetdir = WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/". $filenoext; // target directory
		$targetdir2 = WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/". $filenoext; // target directory
		$targetzip = $path . $filename; // target zip file
		
		if( is_writable(  WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/layout/" ) ){ // If we can create the dir, do it, otherwise ftp it.
			if (is_dir($targetdir))  wpeasycart_rmdir_recursive ( $targetdir);
			mkdir($targetdir, 0777);
			if (is_dir($targetdir2))  wpeasycart_rmdir_recursive ( $targetdir2 );
			mkdir($targetdir2, 0777);
			if( is_dir( $targetdir ) )
				$layout_message .= " The layout directory was created successfully.<br>";
			else
				$layout_message .= " The layout directory was NOT created, please try again.<br>";
		  
		}else{
			// Could not open the file, lets write it via ftp!
			$ftp_server = $_SERVER['HTTP_HOST'];
			$ftp_user_name = $_POST['ec_ftp_user2'];
			$ftp_user_pass = $_POST['ec_ftp_pass2'];
			
			// set up basic connection
			$conn_id = ftp_connect( $ftp_server ) or die("Couldn't connect to $ftp_server");
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			
			if( !$login_result ){
				$layout_message .= "The plugin could not connect to your server via FTP. Please enter your FTP info and try again.<br>";
			}else{
				ftp_mkdir( $conn_id, $targetdir );
				ftp_site( $conn_id, "CHMOD 0777 " . $targetdir );
				ftp_mkdir( $conn_id, $targetdir2 );
				ftp_site( $conn_id, "CHMOD 0777 " . $targetdir2 );
				if( is_dir( $targetdir2 ) )
					$layout_message .= " The layout directory was created successfully via FTP.<br>";
				else
					$layout_message .= " The layout directory was NOT created, failed via FTP, please try again.<br>";
			}
		}
		
		if( !is_dir( $targetdir2 ) ){
			// Already added message about the dir.
		}else{
			$zip = new ZipArchive();
			$x = $zip->open( $_FILES["layout_file"]["tmp_name"] );  // open the zip file to extract 
			if( $x === true ) {
				$zip->extractTo( $targetdir ); // place in the directory with same name  
				$zip->extractTo( $targetdir2 ); // place in the directory with same name  
				$zip->close();
				$layout_message .= "Your EasyCart layout file was uploaded and unpacked. You may select from the Base Design above.";
				update_option( 'ec_option_base_layout', $filenoext );
			}else{
				$layout_message .= "Could not open the uploaded zip file. Please try again.";
			}
		}
	}
	
	// Copy the latest theme
	if( isset( $_POST['ec_option_copy_theme']) && $_POST['ec_option_copy_theme'] != "0" ){
		$to = "../wp-content/plugins/wp-easycart-data/design/theme/";
		$from = "../wp-content/plugins/wp-easycart-data/latest-design/theme/" . $_POST['ec_option_copy_theme'] . "/";
		
		if( is_dir( $to ) && !is_dir( $to . $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION . "/" ) && is_dir( $from ) ){
			// Recursive copy the selected theme
			wpeasycart_copyr( $from, $to . $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION . "/" );
			update_option( 'ec_option_base_theme', $_POST['ec_option_copy_theme'] . "-" . EC_CURRENT_VERSION );
		}
	}
	
	// Copy the latest layout
	if( isset( $_POST['ec_option_copy_layout']) && $_POST['ec_option_copy_layout'] != "0" ){
		$to = "../wp-content/plugins/wp-easycart-data/design/layout/";
		$from = "../wp-content/plugins/wp-easycart-data/latest-design/layout/" . $_POST['ec_option_copy_layout'] . "/";
		
		if( is_dir( $to ) && !is_dir( $to . $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION . "/" ) && is_dir( $from ) ){
			// Recursive copy the selected theme
			wpeasycart_copyr( $from, $to . $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION . "/" );
			update_option( 'ec_option_base_layout', $_POST['ec_option_copy_layout'] . "-" . EC_CURRENT_VERSION );
		}
	}
}

function ec_send_test_email( ){
	$order_id = $_POST['ec_order_id'];
	$mysqli = new ec_db_admin( );
				
	// send email
	$order_row = $mysqli->get_order_row_admin( $order_id );
	if( $order_row ){
		$order_display = new ec_orderdisplay( $order_row, true, true );
		$order_display->send_email_receipt( );
		return true;
	}else{
		return false;
	}
}

function ec_update_cache_rules( ){
	update_option( 'ec_option_caching_on', $_POST['ec_option_caching_on'] );
	update_option( 'ec_option_cache_update_period', $_POST['ec_option_cache_update_period'] );
}

function wpeasycart_rmdir_recursive( $path ){ 
	if( is_dir( $path ) ){
		if( $handle = opendir( $path ) ){
			while( false !== ( $file = readdir( $handle ) ) ){
				if( $file != '.' && $file != '..' )
					unlink( $path."/".$file );
			}
			closedir( $handle );
			rmdir( $path );
			return 1;
		}
	}
	return; 
}

function ec_is_admin_installed( ){
	$plugins = get_plugins( );
	$has_admin = false;
	foreach( $plugins as $plugin ){
		if( $plugin['Name'] == "WP EasyCart Administration" )
			$has_admin = true;
	}
	return $has_admin;
}

function ec_has_manufacturer( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT manufacturer_id FROM ec_manufacturer" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_menu( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT menulevel1_id FROM ec_menulevel1" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_category( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT category_id FROM ec_category" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_product( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT product_id FROM ec_product" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_custom_store_design( ){
	if( get_option( 'ec_option_hide_design_help_video' ) || get_option( 'ec_option_design_saved' ) )
		return true;
	else
		return false;
}

function ec_has_receipt_logo( ){
	if( get_option( 'ec_option_email_logo' ) && get_option( 'ec_option_email_logo' ) != "" )
		return true;
	else
		return false;
}

function ec_has_payment_methods( ){
	if( get_option( 'ec_option_use_affirm' ) || get_option( 'ec_option_payment_third_party' ) || get_option( 'ec_option_payment_process_method' ) )
		return true;
	else
		return false;
}

function ec_has_tax( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT taxrate_id FROM ec_taxrate" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_shipping( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT shippingrate_id FROM ec_shippingrate" );
	if( count( $results ) <= 0 && get_option( 'ec_option_use_shipping' ) )
		return false;
	else
		return true;
}

function ec_has_order( ){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT order_id FROM ec_order WHERE order_id != 1774" );
	if( empty( $results ) )
		return false;
	else
		return true;
}

function ec_has_demouser( ){
	global $wpdb;
	$user = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ec_user WHERE ec_user.email = 'demouser@demo.com' AND ec_user.password = %s AND ec_user.user_level = 'admin'", md5( "demouser" ) ) );
	if( count( $user ) > 0 ){
		return true;
	}else{
		return false;
	}
}

function ec_easycart_add_pages( ){
	if( !ec_is_store_page_setup( ) ){
		ec_add_store_page( );
	}
	
	if( !ec_is_cart_page_setup( ) ){
		ec_add_cart_page( );
	}
	
	if( !ec_is_account_page_setup( ) ){
		ec_add_account_page( );
	}
}

function ec_reset_store_permalinks( ){
	
	global $wpdb;
	$db = new ec_db( );
	if( !isset( $_GET['ec_reset_phase2'] ) ){
		
		$args = array(
			'posts_per_page'   => 1000000,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'ec_store',
			'post_status'      => 'any'
		);
		$posts_array = get_posts( $args );
		
		foreach( $posts_array as $post ){
			wp_delete_post( $post->ID, true );
		}
		$wpdb->query( "UPDATE ec_product SET ec_product.post_id = 0" );
		$wpdb->query( "UPDATE ec_menulevel1 SET ec_menulevel1.post_id = 0" );
		$wpdb->query( "UPDATE ec_menulevel2 SET ec_menulevel2.post_id = 0" );
		$wpdb->query( "UPDATE ec_menulevel3 SET ec_menulevel3.post_id = 0" );
		$wpdb->query( "UPDATE ec_category SET ec_category.post_id = 0" );
		$wpdb->query( "UPDATE ec_manufacturer SET ec_manufacturer.post_id = 0" );
	
	}
	
	$menulevel1_items = $wpdb->get_results( "SELECT * FROM ec_menulevel1 WHERE ec_menulevel1.post_id = 0" );
	$menulevel2_items = $wpdb->get_results( "SELECT * FROM ec_menulevel2 WHERE ec_menulevel2.post_id = 0" );
	$menulevel3_items = $wpdb->get_results( "SELECT * FROM ec_menulevel3 WHERE ec_menulevel3.post_id = 0" );
	$product_list = $wpdb->get_results( "SELECT ec_product.model_number, ec_product.post_id, ec_product.title, ec_product.product_id, ec_product.description FROM ec_product WHERE ec_product.post_id = 0" );
	$category_list = $wpdb->get_results( "SELECT * FROM ec_category WHERE ec_category.post_id = 0" );
	$manufacturer_list = $wpdb->get_results( "SELECT * FROM ec_manufacturer WHERE ec_manufacturer.post_id = 0" );
	
	echo "Rebuilding Menu 1: ";
	foreach( $menulevel1_items as $menu_item ){
		
		if( $menu_item->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store menuid=\"" . $menu_item->menulevel1_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_menu_post_id( $menu_item->menulevel1_id, $post_id );
		}
		
		echo "Item " . $menu_item->menulevel1_id . " Done... ";
		
	}
	
	echo "<br>Rebuilding Menu 2: ";
	foreach( $menulevel2_items as $menu_item ){
		
		if( $menu_item->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store submenuid=\"" . $menu_item->menulevel2_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_submenu_post_id( $menu_item->menulevel2_id, $post_id );
		}
		echo "Item " . $menu_item->menulevel2_id . " Done... ";
		
	}
	
	echo "<br>Rebuilding Menu 3: ";
	foreach( $menulevel3_items as $menu_item ){
		
		if( $menu_item->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store subsubmenuid=\"" . $menu_item->menulevel3_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $menu_item->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_subsubmenu_post_id( $menu_item->menulevel3_id, $post_id );
		}
		echo "Item " . $menu_item->menulevel3_id . " Done... ";
		
	}

	echo "<br>Rebuilding Products: ";
	foreach( $product_list as $product_single ){
		
		if( $product_single->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store modelnumber=\"" . $product_single->model_number . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $product_single->title,
							'post_type'		=> "ec_store",
							'post_excerpt'	=> $product_single->description
						  );
			$post_id = wp_insert_post( $post );
			$db->update_product_post_id( $product_single->product_id, $post_id );
		}
		echo "Item " . $product_single->model_number . " Done... ";
		
	}

	echo "<br>Rebuilding Manufacturers: ";
	foreach( $manufacturer_list as $manufacturer_single ){
		
		if( $manufacturer_single->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturer_single->manufacturer_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $manufacturer_single->name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_manufacturer_post_id( $manufacturer_single->manufacturer_id, $post_id );
		}
		echo "Item " . $manufacturer_single->manufacturer_id . " Done... ";
		
	}

	echo "<br>Rebuilding Categories: ";
	foreach( $category_list as $category_single ){
		
		if( $category_single->post_id == 0 ){
			// Add a post id
			$post = array(	'post_content'	=> "[ec_store groupid=\"" . $category_single->category_id . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $category_single->category_name,
							'post_type'		=> "ec_store"
						  );
			$post_id = wp_insert_post( $post );
			$db->update_category_post_id( $category_single->category_id, $post_id );
		}
		echo "Item " . $category_single->category_id . " Done... ";
		
	}

}

function ec_clear_gateway_log( ){
	global $wpdb;
	$wpdb->query( "DELETE FROM ec_webhook" );
	$wpdb->query( "DELETE FROM ec_response" );
}
?>