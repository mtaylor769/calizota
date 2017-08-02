////////////////////////////////////////////
// Initialization of the Tax System
////////////////////////////////////////////

function ec_selected_tax_structure_change( ){
	var selected_tax = document.getElementById( 'ec_option_checklist_tax_choice' ).value;
	
	var data = {
		action: 'ec_ajax_clear_all_taxrates',
		option_name: 'ec_option_checklist_tax_choice',
		option_value: selected_tax
	};
	
	ec_checklist_loader_show( );	
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_tax_structure( data ); } } );
	
	ec_setup_selected_tax_structure( );
}

function ec_setup_selected_tax_structure( ){
	var selected_tax = document.getElementById( 'ec_option_checklist_tax_choice' ).value;
	
	ec_hide_all_tax_types( );
	
	if( selected_tax == "state_tax" )
		jQuery( '#ec_state_tax' ).show( );
	if( selected_tax == "country_tax" )
		jQuery( '#ec_country_tax' ).show( );
	if( selected_tax == "global_tax" )
		jQuery( '#ec_all_tax' ).show( );
	if( selected_tax == "vat" )
		jQuery( '#ec_vat_tax' ).show( );
}

function ec_update_tax_structure( data ){
	ec_update_state_tax_list( data );
	ec_update_country_tax_data( data );
	ec_update_all_tax_data( data );
	ec_update_vat_tax_data( data );
	
	ec_checklist_loader_hide( );
}

function ec_hide_all_tax_types( ){
	jQuery( '#ec_state_tax' ).hide( );
	jQuery( '#ec_country_tax' ).hide( );
	jQuery( '#ec_all_tax' ).hide( );
	jQuery( '#ec_vat_tax' ).hide( );
}

////////////////////////////////////////////
// State Tax Specific Functions
////////////////////////////////////////////

function ec_add_state_tax( ){
	var state = document.getElementById( 'ec_new_state' ).value;
	var rate = document.getElementById( 'ec_new_state_rate' ).value;
	var data = {
			action: 'ec_ajax_add_taxrate',
			state: state,
			rate: rate
	};
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_state_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_state_tax( taxrate_id ){
	var state = document.getElementById( 'ec_tax_state_' + taxrate_id ).value;
	var rate = document.getElementById( 'ec_tax_state_rate_' + taxrate_id ).value;
	var data = {
			action: 'ec_ajax_update_taxrate',
			taxrate_id: taxrate_id,
			state: state,
			rate: rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_state_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_delete_state_tax( taxrate_id ){
	var data = {
			action: 'ec_ajax_delete_taxrate',
			taxrate_id: taxrate_id
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_state_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_state_tax_list( data ){
	data = JSON.parse(data);
	var innerhtml = "";
	var newrow = ""
	var j=0;
	for( var i=0; i<data.length; i++ ){
		if( data[i]["tax_by_state"] ){
			j++;
			newrow = "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div>"
			newrow = newrow + "<input type=\"hidden\" id=\"ec_tax_state_" + data[i]["taxrate_id"] + "\" value=\"" + data[i]["state_code"] + "\" />";
			newrow = newrow + "<span class=\"ec_state_column\">" + data[i]["state_code"] + "</span>";
			newrow = newrow + "<span class=\"ec_state_rate_column\"><input type=\"number\" id=\"ec_tax_state_rate_" + data[i]["taxrate_id"] + "\" value=\"" + data[i]["state_rate"] + "\"  />%</span>";
			newrow = newrow + "<span class=\"ec_state_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete Rate\" onclick=\"ec_delete_state_tax( '" + data[i]["taxrate_id"] + "' );\" /><input type=\"button\" class=\"button-primary\" value=\"Update Rate\" onclick=\"ec_update_state_tax( '" + data[i]["taxrate_id"] + "' );\" /> ";
			newrow = newrow + "</span></div></div>";
			innerhtml = innerhtml + newrow;
		}
	}
	document.getElementById('ec_states_tax_list').innerHTML = innerhtml;
}

////////////////////////////////////////////
// Country Tax Specific Functions
////////////////////////////////////////////

function ec_set_country_tax_rate( data ){
	var taxrate_id = document.getElementById( 'ec_tax_country_id' ).value;
	var country = document.getElementById( 'ec_tax_country' ).value;
	var rate = document.getElementById( 'ec_tax_country_rate' ).value;
	var data = {
			action: 'ec_ajax_update_country_taxrate',
			taxrate_id: taxrate_id,
			country: country,
			rate: rate
	};
	
	ec_checklist_loader_show( );	
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_country_tax_data( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_country_tax_data( data ){
	data = JSON.parse(data);
	
	document.getElementById( 'ec_tax_country' ).value = 0;
	document.getElementById( 'ec_tax_country_rate' ).value = "0";
	for( var i=0; i<data.length; i++ ){
		if( data[i]["tax_by_country"] ){
			jQuery( '#ec_tax_country' ).val( data[i]["country_code"] );
			document.getElementById( 'ec_tax_country_rate' ).value = data[i]["country_rate"];
		}
	}
}

////////////////////////////////////////////
// Global Tax Specific Functions
////////////////////////////////////////////

function ec_set_all_tax_rate( data ){
	var taxrate_id = document.getElementById( 'ec_tax_all_id' ).value;
	var rate = document.getElementById( 'ec_tax_all_rate' ).value;
	var data = {
			action: 'ec_ajax_update_all_taxrate',
			taxrate_id: taxrate_id,
			rate: rate
	};
	
	ec_checklist_loader_show( );	
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_all_tax_data( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_all_tax_data( data ){
	data = JSON.parse(data);
	
	document.getElementById( 'ec_tax_all_rate' ).value = "0";
	for( var i=0; i<data.length; i++ ){
		if( data[i]["tax_by_all"] ){
			document.getElementById( 'ec_tax_all_rate' ).value = data[i]["all_rate"];
		}
	}
}

////////////////////////////////////////////
// VAT Tax Specific Functions
////////////////////////////////////////////

function ec_set_vat_tax_rate( data ){
	var taxrate_id = document.getElementById( 'ec_tax_vat_id' ).value;
	var rate = document.getElementById( 'ec_tax_vat_rate' ).value;
	var data = {
			action: 'ec_ajax_update_vat_taxrate',
			taxrate_id: taxrate_id,
			rate: rate
	};
	
	ec_checklist_loader_show( );	
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_vat_tax_data( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_vat_tax_data( data ){
	data = JSON.parse(data);
	
	document.getElementById( 'ec_tax_vat_rate' ).value = "0";
	for( var i=0; i<data.length; i++ ){
		if( data[i]["tax_by_vat"] ){
			document.getElementById( 'ec_tax_vat_rate' ).value = data[i]["vat_rate"];
		}
	}
}

function ec_new_vat_tax( ){
	var iso2_cnt = document.getElementById( 'ec_new_vat_country' ).value;
	var rate = document.getElementById( 'ec_new_vat_rate' ).value;
	var data = {
		action: 'ec_ajax_update_country',
		iso2_cnt: iso2_cnt,
		rate: rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_vat_country_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_vat_tax( iso2_cnt ){
	var iso2_cnt = iso2_cnt;
	var rate = document.getElementById( 'ec_tax_country_rate_' + iso2_cnt ).value;
	var data = {
		action: 'ec_ajax_update_country',
		iso2_cnt: iso2_cnt,
		rate: rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_vat_country_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_zero_vat_tax( iso2_cnt ){
	var iso2_cnt = iso2_cnt;
	var rate = 0;
	var data = {
		action: 'ec_ajax_update_country',
		iso2_cnt: iso2_cnt,
		rate: rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_vat_country_tax_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_vat_country_tax_list( data ){
	data = JSON.parse(data);
	var innerhtml = "";
	var newrow = ""
	var j=0;
	for( var i=0; i<data.length; i++ ){
		if( data[i]["vat_rate_cnt"] > 0 ){
			j++;
			newrow = "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div>";
			newrow = newrow + "<input type=\"hidden\" id=\"ec_tax_country_" + data[i]["iso2_cnt"] + "\" value=\"" + data[i]["iso2_cnt"] + "\" /><span class=\"ec_country_name_column\">" + data[i]["name_cnt"] + "</span>";
			newrow = newrow + "<span class=\"ec_country_rate_column\"><input type=\"number\" value=\"" + data[i]["vat_rate_cnt"] + "\" id=\"ec_tax_country_rate_" + data[i]["iso2_cnt"] + "\" />%</span>";
			newrow = newrow + "<span class=\"ec_country_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete VAT Rate\" onclick=\"ec_zero_vat_tax( '" + data[i]["iso2_cnt"] + "' );\" /> ";
			newrow = newrow + "<input type=\"button\" class=\"button-primary\" value=\"Update VAT Rate\" onclick=\"ec_update_vat_tax( '" + data[i]["iso2_cnt"] + "' );\" /></span></div></div>";
			innerhtml = innerhtml + newrow;
		}
	}
	document.getElementById('ec_vat_countries').innerHTML = innerhtml;
}


////////////////////////////////////////////
// Shipping Rate Initialization Stuff
////////////////////////////////////////////

function ec_selected_shipping_type_change( ){
	var selected_shipping = document.getElementById( 'ec_option_checklist_shipping_choice' ).value;
	var shipping_method = "price";
	if( selected_shipping == "weight_based" )
		shipping_method = "weight";
	else if( selected_shipping == "method_based" )
		shipping_method = "method";
	else if( selected_shipping == "live_based" )
		shipping_method = "live";
	
	var use_shipping = 1;
	if( selected_shipping == "none" || selected_shipping == "0" ){
		use_shipping = 0;
	}
	
	// Show the loader
	ec_checklist_loader_show( );
	
	// Update the use shipping option
	var data = {
		action: 'ec_ajax_update_option',
		option_name: 'ec_option_use_shipping',
		option_value: use_shipping
	};
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data } );
	
	// Update Selected Shipping Type
	var data = {
		action: 'ec_ajax_update_setting',
		option_name: 'shipping_method',
		option_value: shipping_method
	};
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_checklist_loader_hide( ); } } );
	
	// Update the checklist value, make things easier...
	var data = {
		action: 'ec_ajax_update_option',
		option_name: 'ec_option_checklist_shipping_choice',
		option_value: selected_shipping
	};

	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_checklist_loader_hide( ); } } );
	
	ec_setup_selected_shipping_structure( );
}

function ec_setup_selected_shipping_structure( ){
	var selected_shipping = document.getElementById( 'ec_option_checklist_shipping_choice' ).value;
	
	ec_hide_all_shipping_types( );
	
	if( selected_shipping == "price_based" )
		jQuery( '#ec_price_based' ).show( );
	if( selected_shipping == "weight_based" )
		jQuery( '#ec_weight_based' ).show( );
	if( selected_shipping == "method_based" )
		jQuery( '#ec_method_based' ).show( );
	if( selected_shipping == "live_based" )
		jQuery( '#ec_live_based' ).show( );
}

function ec_update_shipping_structure( data ){
	ec_update_shipping_price_list( data );
	ec_update_shipping_weight_list( data );
	ec_update_shipping_method_list( data );
	ec_update_shipping_live_list( data );
	
	ec_checklist_loader_hide( );
}

function ec_hide_all_shipping_types( ){
	jQuery( '#ec_price_based' ).hide( );
	jQuery( '#ec_weight_based' ).hide( );
	jQuery( '#ec_method_based' ).hide( );
	jQuery( '#ec_live_based' ).hide( );
}

////////////////////////////////////////////
// Shipping Rate Functions
////////////////////////////////////////////
function ec_add_shipping_rate( type ){
	var is_price_based = 0;
	var is_weight_based = 0;
	var is_method_based = 0;
	var is_ups_based = 0;
	var is_usps_based = 0;
	var is_fedex_based = 0;
	var is_auspost_based = 0;
	var is_dhl_based = 0;
	var trigger_rate = "";
	var shipping_rate = "";
	var shipping_label = "";
	var shipping_order = "";
	var shipping_code = "";
	var shipping_override_rate = "";
	
	if( type == "price_based" ){
		trigger_rate = document.getElementById( 'ec_new_price_trigger' ).value;
		shipping_rate = document.getElementById( 'ec_new_price_rate' ).value;
		is_price_based = 1;
	}else if( type == "weight_based" ){
		trigger_rate = document.getElementById( 'ec_new_weight_trigger' ).value;
		shipping_rate = document.getElementById( 'ec_new_weight_rate' ).value;
		is_weight_based = 1;
	}else if( type == "method_based" ){
		shipping_label = document.getElementById( 'ec_new_method_label' ).value;
		shipping_rate = document.getElementById( 'ec_new_method_rate' ).value;
		shipping_order = document.getElementById( 'ec_new_method_order' ).value;
		is_method_based = 1;
	}else if( type == "live_based" ){
		shipping_label = document.getElementById( 'ec_new_live_label' ).value;
		shipping_code = document.getElementById( 'ec_new_live_code' ).value;
		shipping_order = document.getElementById( 'ec_new_live_order' ).value;
		
		var ship_method_type = jQuery( "#ec_new_live_code option:selected" ).attr("data-shiptype");
		
		if( ship_method_type == "ups" )
			is_ups_based = 1;
		else if( ship_method_type == "usps" )
			is_usps_based = 1;
		else if( ship_method_type == "fedex" )
			is_fedex_based = 1;
		else if( ship_method_type == "auspost" )
			is_auspost_based = 1;
		else if( ship_method_type == "dhl" )
			is_dhl_based = 1;
	}
	
	var data = {
		action: 'ec_ajax_add_shippingrate',
		type: type,
		is_price_based: is_price_based,
		is_weight_based: is_weight_based,
		is_method_based: is_method_based,
		is_ups_based: is_ups_based,
		is_usps_based: is_usps_based,
		is_fedex_based: is_fedex_based,
		is_auspost_based: is_auspost_based,
		is_dhl_based: is_dhl_based,
		trigger_rate: trigger_rate,
		shipping_rate: shipping_rate,
		shipping_label: shipping_label,
		shipping_order: shipping_order,
		shipping_code: shipping_code,
		shipping_override_rate: shipping_override_rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_shipping_price_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_shipping_rate( type, shippingrate_id ){
	var is_price_based = 0;
	var is_weight_based = 0;
	var is_method_based = 0;
	var is_ups_based = 0;
	var is_usps_based = 0;
	var is_fedex_based = 0;
	var is_auspost_based = 0;
	var is_dhl_based = 0;
	var trigger_rate = "";
	var shipping_rate = "";
	var shipping_label = "";
	var shipping_order = "";
	var shipping_code = "";
	var shipping_override_rate = "";
	
	if( type == "price_based" ){
		trigger_rate = document.getElementById( 'ec_price_trigger_rate_' + shippingrate_id ).value;
		shipping_rate = document.getElementById( 'ec_price_shipping_rate_' + shippingrate_id ).value;
		is_price_based = 1;
	}else if( type == "weight_based" ){
		trigger_rate = document.getElementById( 'ec_weight_trigger_rate_' + shippingrate_id ).value;
		shipping_rate = document.getElementById( 'ec_weight_shipping_rate_' + shippingrate_id ).value;
		is_weight_based = 1;
	}else if( type == "method_based" ){
		shipping_label = document.getElementById( 'ec_method_label_' + shippingrate_id ).value;
		shipping_rate = document.getElementById( 'ec_method_shipping_rate_' + shippingrate_id ).value;
		shipping_order = document.getElementById( 'ec_method_order_' + shippingrate_id ).value;
		is_method_based = 1;
	}else if( type == "live_based" ){
		shipping_label = document.getElementById( 'ec_live_label_' + shippingrate_id ).value;
		shipping_code = document.getElementById( 'ec_live_code_' + shippingrate_id ).value;
		shipping_order = document.getElementById( 'ec_live_order_' + shippingrate_id ).value;
		
		var ship_method_type = document.getElementById( 'ec_live_type_' + shippingrate_id ).value;
		
		if( ship_method_type == "UPS" )
			is_ups_based = 1;
		else if( ship_method_type == "USPS" )
			is_usps_based = 1;
		else if( ship_method_type == "FedEx" )
			is_fedex_based = 1;
		else if( ship_method_type == "AU Post" )
			is_auspost_based = 1;
		else if( ship_method_type == "DHL" )
			is_dhl_based = 1;
	}
	
	var data = {
		action: 'ec_ajax_update_shippingrate',
		type: type,
		shippingrate_id: shippingrate_id,
		trigger_rate: trigger_rate,
		is_price_based: is_price_based,
		is_weight_based: is_weight_based,
		is_method_based: is_method_based,
		is_ups_based: is_ups_based,
		is_usps_based: is_usps_based,
		is_fedex_based: is_fedex_based,
		is_auspost_based: is_auspost_based,
		is_dhl_based: is_dhl_based,
		shipping_rate: shipping_rate,
		shipping_label: shipping_label,
		shipping_order: shipping_order,
		shipping_code: shipping_code,
		shipping_override_rate: shipping_override_rate
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_shipping_price_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_delete_shipping_rate( shippingrate_id ){
	var data = {
			action: 'ec_ajax_delete_shippingrate',
			shippingrate_id: shippingrate_id
	};
	
	ec_checklist_loader_show( );
	jQuery.ajax( {url: wpeasycart_ajax_object.ajax_url, type: 'post', data: data, success: function( data ){ ec_update_shipping_price_list( data ); ec_checklist_loader_hide( ); } } );
}

function ec_update_shipping_price_list( data ){
	data = JSON.parse(data);
	var price_innerhtml = "";
	var weight_innerhtml = "";
	var method_innerhtml = "";
	var live_innerhtml = "";
	var newrow = ""
	var j=0;
	var type = "ups";
	for( var i=0; i<data.length; i++ ){
		if( data[i]["is_price_based"] == "1" ){
			j++;
			price_innerhtml += "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div><span class=\"ec_price_trigger_rate_column\">Trigger Rate: <input type=\"number\" value=\"" + data[i]["trigger_rate"] + "\" id=\"ec_price_trigger_rate_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_price_rate_column\">Shipping Rate: <input type=\"number\" value=\"" + data[i]["shipping_rate"] + "\" id=\"ec_price_shipping_rate_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_country_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete Rate\" onclick=\"ec_delete_shipping_rate( '" + data[i]["shippingrate_id"] + "' );\" /> <input type=\"button\" class=\"button-primary\" value=\"Update Rate\" onclick=\"ec_update_shipping_rate( 'price_based', '" + data[i]["shippingrate_id"] + "' );\" /></span></div></div>";
		}else if( data[i]["is_weight_based"] == "1" ){
			j++;
			weight_innerhtml += "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div><span class=\"ec_price_trigger_rate_column\">Trigger Rate: <input type=\"number\" value=\"" + data[i]["trigger_rate"] + "\" id=\"ec_weight_trigger_rate_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_price_rate_column\">Shipping Rate: <input type=\"number\" value=\"" + data[i]["shipping_rate"] + "\" id=\"ec_weight_shipping_rate_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_country_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete Rate\" onclick=\"ec_delete_shipping_rate( '" + data[i]["shippingrate_id"] + "' );\" /> <input type=\"button\" class=\"button-primary\" value=\"Update Rate\" onclick=\"ec_update_shipping_rate( 'weight_based', '" + data[i]["shippingrate_id"] + "' );\" /></span></div></div>";
		}else if( data[i]["is_method_based"] == "1" ){
			j++;
			method_innerhtml += "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div><span class=\"ec_method_label_column\">Rate Label: <input type=\"text\" value=\"" + data[i]["shipping_label"] + "\" id=\"ec_method_label_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_method_rate_column\">Shipping Rate: <input type=\"number\" value=\"" + data[i]["shipping_rate"] + "\" id=\"ec_method_shipping_rate_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_method_order_column\">Rate Order: <input type=\"number\" value=\"" + data[i]["shipping_order"] + "\" id=\"ec_method_order_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_method_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete Rate\" onclick=\"ec_delete_shipping_rate( '" + data[i]["shippingrate_id"] + "' );\" /> <input type=\"button\" class=\"button-primary\" value=\"Update Rate\" onclick=\"ec_update_shipping_rate( 'method_based', '" + data[i]["shippingrate_id"] + "' );\" /></span></div></div>";
		}else if( data[i]["is_ups_based"] == "1" || data[i]["is_usps_based"] == "1" || data[i]["is_fedex_based"] == "1" || data[i]["is_auspost_based"] == "1" || data[i]["is_dhl_based"] == "1" ){
			if( data[i]["is_ups_based"] == "1" ){ type = "UPS"; }else if( data[i]["is_usps_based"] == "1" ){ type = "USPS"; }else if( data[i]["is_fedex_based"] == "1" ){ type = "FedEx"; }else if( data[i]["is_auspost_based"] == "1" ){ type = "AU Post"; }else if( data[i]["is_dhl_based"] == "1" ){ type = "DHL"; }
			j++;
			live_innerhtml += "<div class=\"ec_failed_row ec_list_style_" + (j%2) + "\"><div><span class=\"ec_live_type_column\"><input type=\"hidden\" name=\"ec_live_code_" + data[i]["shippingrate_id"] + "\" id=\"ec_live_code_" + data[i]["shippingrate_id"] + "\" value=\"" + data[i]["shipping_code"] + "\" /><input type=\"hidden\" name=\"ec_live_type_" + data[i]["shippingrate_id"] + "\" id=\"ec_live_type_" + data[i]["shippingrate_id"] + "\" value=\"" + type + "\" />" + type + "</span><span class=\"ec_live_label_column\">Rate Label: <input type=\"text\" value=\"" + data[i]["shipping_label"] + "\" id=\"ec_live_label_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_live_order_column\">Rate Order: <input type=\"number\" value=\"" + data[i]["shipping_order"] + "\" id=\"ec_live_order_" + data[i]["shippingrate_id"] + "\" /></span><span class=\"ec_live_buttons_column\"><input type=\"button\" class=\"button-primary\" value=\"Delete Rate\" onclick=\"ec_delete_shipping_rate( '" + data[i]["shippingrate_id"] + "' );\" /> <input type=\"button\" class=\"button-primary\" value=\"Update Rate\" onclick=\"ec_update_shipping_rate( 'live_based', '" + data[i]["shippingrate_id"] + "' );\" /></span></div></div>";
		}
	}
	document.getElementById('ec_price_rates').innerHTML = price_innerhtml;
	document.getElementById('ec_weight_rates').innerHTML = weight_innerhtml;
	document.getElementById('ec_method_rates').innerHTML = method_innerhtml;
	if( document.getElementById('ec_live_rates') )
		document.getElementById('ec_live_rates').innerHTML = live_innerhtml;
}

////////////////////////////////////////////
// Loader Functions
////////////////////////////////////////////

function ec_checklist_loader_show( ){
	jQuery( '#ec_checklist_loader' ).fadeIn( 250 );
}

function ec_checklist_loader_hide( ){
	jQuery( '#ec_checklist_loader' ).fadeOut( 250 );
}