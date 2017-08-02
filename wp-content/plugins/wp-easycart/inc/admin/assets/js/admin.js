// JavaScript Document
function ec_check_add_product( ){
	var title = jQuery( '#ec_product_title' ).val( );
	var model_number = jQuery( '#ec_product_model_number' ).val( );
	var weight = jQuery( '#ec_product_weight' ).val( );
	var manufacturer = jQuery( '#ec_product_manufacturer' ).val( );
	var price = jQuery( '#ec_product_price' ).val( );
	var description = jQuery( '#ec_product_description' ).val( );
	var image = jQuery( '#ec_product_image' ).val( );
	var model_numbers_json = jQuery( '#ec_product_model_number_list' ).val( );
	var model_numbers = jQuery.parseJSON( model_numbers_json );
	
	var errors = 0;
	var model_exists = 0;
	
	if( title.length > 0 ){
		jQuery( '#ec_product_title_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_title_error' ).show( );
	}
	
	if( model_number.length > 0 ){
		jQuery( '#ec_product_model_number_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_model_number_error' ).show( );
	}
	
	for( var i=0; i<model_numbers.length; i++ ){
		if( model_number == model_numbers[i]['model_number'] && model_number != "" ){
			errors++;
			model_exists++;
			jQuery( '#ec_product_model_number_exists_error' ).show( );
		}
	}
	
	if( !model_exists ){
		jQuery( '#ec_product_model_number_exists_error' ).hide( );
	}
	
	if( weight.length > 0 ){
		jQuery( '#ec_product_weight_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_weight_error' ).show( );
	}
	
	if( manufacturer.length > 0 ){
		jQuery( '#ec_product_manufacturer_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_manufacturer_error' ).show( );
	}
	
	if( price.length > 0 ){
		jQuery( '#ec_product_price_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_price_error' ).show( );
	}
	
	if( description.length > 0 ){
		jQuery( '#ec_product_description_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_description_error' ).show( );
	}
	
	if( image.length > 0 ){
		jQuery( '#ec_product_image_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_image_error' ).show( );
	}
	
	if( errors > 0 ){
		return false;
	}else{
		return true;
	}
}

function ec_check_edit_product( ){
	var title = jQuery( '#ec_product_title' ).val( );
	var model_number = jQuery( '#ec_product_model_number' ).val( );
	var weight = jQuery( '#ec_product_weight' ).val( );
	var manufacturer = jQuery( '#ec_product_manufacturer' ).val( );
	var price = jQuery( '#ec_product_price' ).val( );
	var description = jQuery( '#ec_product_description' ).val( );
	var model_numbers_json = jQuery( '#ec_product_model_number_list' ).val( );
	var model_numbers = jQuery.parseJSON( model_numbers_json );
	var old_model_number = jQuery( '#ec_product_old_model_number' ).val( );
	
	var errors = 0;
	var model_exists = 0;
	
	if( title.length > 0 ){
		jQuery( '#ec_product_title_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_title_error' ).show( );
	}
	
	if( model_number.length > 0 ){
		jQuery( '#ec_product_model_number_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_model_number_error' ).show( );
	}
	
	if( model_number != old_model_number ){
		for( var i=0; i<model_numbers.length; i++ ){
			if( model_number == model_numbers[i]['model_number'] && model_number != "" ){
				errors++;
				model_exists++;
				jQuery( '#ec_product_model_number_exists_error' ).show( );
			}
		}
	}
	
	if( !model_exists ){
		jQuery( '#ec_product_model_number_exists_error' ).hide( );
	}
	
	if( weight.length > 0 ){
		jQuery( '#ec_product_weight_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_weight_error' ).show( );
	}
	
	if( manufacturer.length > 0 ){
		jQuery( '#ec_product_manufacturer_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_manufacturer_error' ).show( );
	}
	
	if( price.length > 0 ){
		jQuery( '#ec_product_price_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_price_error' ).show( );
	}
	
	if( description.length > 0 ){
		jQuery( '#ec_product_description_error' ).hide( );
	}else{
		errors++;
		jQuery( '#ec_product_description_error' ).show( );
	}
	
	if( errors > 0 ){
		return false;
	}else{
		return true;
	}
}