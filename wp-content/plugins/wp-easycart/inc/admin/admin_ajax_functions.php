<?php
////////////////////////////////////////////
// ADMIN AJAX Functions
////////////////////////////////////////////
add_action( 'wp_ajax_ec_ajax_add_taxrate', 'ec_ajax_add_taxrate' );
add_action( 'wp_ajax_ec_ajax_update_taxrate', 'ec_ajax_update_taxrate' );
add_action( 'wp_ajax_ec_ajax_delete_taxrate', 'ec_ajax_delete_taxrate' );
add_action( 'wp_ajax_ec_ajax_update_option', 'ec_ajax_update_option' );
add_action( 'wp_ajax_ec_ajax_clear_all_taxrates', 'ec_ajax_clear_all_taxrates' );
add_action( 'wp_ajax_ec_ajax_update_country_taxrate', 'ec_ajax_update_country_taxrate' );
add_action( 'wp_ajax_ec_ajax_update_all_taxrate', 'ec_ajax_update_all_taxrate' );
add_action( 'wp_ajax_ec_ajax_update_vat_taxrate', 'ec_ajax_update_vat_taxrate' );
add_action( 'wp_ajax_ec_ajax_update_country', 'ec_ajax_update_country' );
add_action( 'wp_ajax_ec_ajax_add_shippingrate', 'ec_ajax_add_shippingrate' );
add_action( 'wp_ajax_ec_ajax_update_shippingrate', 'ec_ajax_update_shippingrate' );
add_action( 'wp_ajax_ec_ajax_delete_shippingrate', 'ec_ajax_delete_shippingrate' );
add_action( 'wp_ajax_ec_ajax_update_setting', 'ec_ajax_update_setting' );

////////////////////////////////////////////
// ADMIN TAXRATE FUNCTIONS
////////////////////////////////////////////
function ec_ajax_add_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$tax_state = $_POST['state'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin( );
		//tax_by_state, tax_by_country, tax_by_duty, tax_by_vat, tax_by_all, state_rate, country_rate, duty_rate, vat_rate, all_rate, state_code, country_code,vat_country_code, duty_exempt_country_code
		$db->add_taxrate( 1, 0, 0, 0, 0, $rate, 0, 0, 0, 0, $tax_state, "", "", "" );
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$taxrate_id = $_POST['taxrate_id'];
		$tax_state = $_POST['state'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin();
		//taxrate_id, tax_by_state, tax_by_country, tax_by_duty, tax_by_vat, tax_by_all, state_rate, country_rate, duty_rate, vat_rate, all_rate, state_code, country_code,vat_country_code, duty_exempt_country_code
		$db->update_taxrate( $taxrate_id, 1, 0, 0, 0, 0, $rate, "0.000", "0.000", "0.000", "0.000", $tax_state, "", "", "" );
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_delete_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$taxrate_id = $_POST['taxrate_id'];
		
		$db = new ec_db_admin();
		$db->delete_taxrate( $taxrate_id );
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_option( ){
	
	if( current_user_can( 'manage_options' ) ){
		$option_name = $_POST['option_name'];
		$option_value = $_POST['option_value'];
		
		update_option( $option_name, $option_value );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_clear_all_taxrates( ){
	
	if( current_user_can( 'manage_options' ) ){
		$exception = $_POST['option_value'];
		$option_name = $_POST['option_name'];
		$option_value = $_POST['option_value'];
		update_option( $option_name, $option_value );
		
		$db = new ec_db_admin();
		$tax_rates = $db->get_taxrates( );
		foreach( $tax_rates as $rate ){
			if( $exception == "0" || $exception == "none" ){
				$db->delete_taxrate( $rate->taxrate_id );
			}else if( $exception == "state_tax" && !$rate->tax_by_state ){
				$db->delete_taxrate( $rate->taxrate_id );
			}else if( $exception == "country_tax" && !$rate->tax_by_country ){
				$db->delete_taxrate( $rate->taxrate_id );
			}else if( $exception == "global_tax" && !$rate->tax_by_all ){
				$db->delete_taxrate( $rate->taxrate_id );
			}else if( $exception == "vat" && !$rate->tax_by_vat ){
				$db->delete_taxrate( $rate->taxrate_id );
			}
		}
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_country_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$taxrate_id = $_POST['taxrate_id'];
		$country = $_POST['country'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin();
		if( $taxrate_id != "0" )	
			$db->update_taxrate( $taxrate_id, 0, 1, 0, 0, 0, 0, $rate, "0.000", "0.000", "0.000", "", $country, "", "" );
		else	
			$db->add_taxrate( 0, 1, 0, 0, 0, 0, $rate, 0, 0, 0, "", $country, "", "" );
		
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_all_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$taxrate_id = $_POST['taxrate_id'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin();
		if( $taxrate_id != "0" )	
			$db->update_taxrate( $taxrate_id, 0, 0, 0, 0, 1, 0, 0, 0, 0, $rate, "", "", "", "" );
		else	
			$db->add_taxrate( 0, 0, 0, 0, 1, 0, 0, 0, 0, $rate, "", "", "", "" );
		
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_vat_taxrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$taxrate_id = $_POST['taxrate_id'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin();
		if( $taxrate_id != "0" )	
			$db->update_taxrate( $taxrate_id, 0, 0, 0, 1, 0, 0, 0, 0, $rate, 0, "", "", "", "" );
		else	
			$db->add_taxrate( 0, 0, 0, 1, 0, 0, 0, 0, $rate, 0, "", "", "", "" );
		
		$tax_rates = $db->get_taxrates( );
		echo json_encode( $tax_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_country( ){
	
	if( current_user_can( 'manage_options' ) ){
		$iso2_cnt = $_POST['iso2_cnt'];
		$rate = $_POST['rate'];
		
		$db = new ec_db_admin();
		$db->update_country( $iso2_cnt, $rate );
		
		$countries = $GLOBALS['ec_countries']->countries;
		echo json_encode( $countries );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_add_shippingrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$is_price_based = $_POST['is_price_based'];
		$is_weight_based = $_POST['is_weight_based'];
		$is_method_based = $_POST['is_method_based'];
		$is_ups_based = $_POST['is_ups_based'];
		$is_usps_based = $_POST['is_usps_based'];
		$is_fedex_based = $_POST['is_fedex_based'];
		$is_auspost_based = $_POST['is_auspost_based'];
		$is_dhl_based = $_POST['is_dhl_based'];
		$trigger_rate = $_POST['trigger_rate'];
		$shipping_rate = $_POST['shipping_rate'];
		$shipping_label = $_POST['shipping_label'];
		$shipping_order = $_POST['shipping_order'];
		$shipping_code = $_POST['shipping_code'];
		$shipping_override_rate = $_POST['shipping_override_rate'];
		
		$db = new ec_db_admin();
		$db->add_shippingrate( $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $is_auspost_based, $is_dhl_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate );
		
		$shipping_rates = $db->get_shipping_data( );
		echo json_encode( $shipping_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_update_shippingrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$shippingrate_id = $_POST['shippingrate_id'];
		$is_price_based = $_POST['is_price_based'];
		$is_weight_based = $_POST['is_weight_based'];
		$is_method_based = $_POST['is_method_based'];
		$is_ups_based = $_POST['is_ups_based'];
		$is_usps_based = $_POST['is_usps_based'];
		$is_fedex_based = $_POST['is_fedex_based'];
		$is_auspost_based = $_POST['is_auspost_based'];
		$is_dhl_based = $_POST['is_dhl_based'];
		$trigger_rate = $_POST['trigger_rate'];
		$shipping_rate = $_POST['shipping_rate'];
		$shipping_label = $_POST['shipping_label'];
		$shipping_order = $_POST['shipping_order'];
		$shipping_code = $_POST['shipping_code'];
		$shipping_override_rate = $_POST['shipping_override_rate'];
		
		$db = new ec_db_admin();
		$db->update_shippingrate( $shippingrate_id, $is_price_based, $is_weight_based, $is_method_based, $is_ups_based, $is_usps_based, $is_fedex_based, $is_auspost_based, $is_dhl_based, $trigger_rate, $shipping_rate, $shipping_label, $shipping_order, $shipping_code, $shipping_override_rate );
		
		$shipping_rates = $db->get_shipping_data( );
		echo json_encode( $shipping_rates );
	}
	die(); // this is required to return a proper result

}

function ec_ajax_delete_shippingrate( ){
	
	if( current_user_can( 'manage_options' ) ){
		$shippingrate_id = $_POST['shippingrate_id'];
		
		$db = new ec_db_admin();
		$db->delete_shippingrate( $shippingrate_id );
		
		$shipping_rates = $db->get_shipping_data( );
		echo json_encode( $shipping_rates );
	}
	die(); // this is required to return a proper result
	
}

function ec_ajax_update_setting( ){
	
	if( current_user_can( 'manage_options' ) ){
		$option_name = $_POST['option_name'];
		$option_value = $_POST['option_value'];
		
		$db->update_setting( $option_name, $option_value );
	}
	die(); // this is required to return a proper result

}
?>