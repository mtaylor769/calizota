<?php
$cart_page_id = get_option('ec_option_cartpage');

if( function_exists( 'icl_object_id' ) ){
	$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
}

$cart_page = get_permalink( $cart_page_id );

if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
	$https_class = new WordPressHTTPS( );
	$cart_page = $https_class->makeUrlHttps( $cart_page );
}

if( substr_count( $cart_page, '?' ) )						$permalink_divider = "&";
else														$permalink_divider = "?";
?>

<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "dwolla_thirdparty" ){ echo '_inactive'; } ?>" id="dwolla_thirdparty">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Account ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_account_id"  id="ec_option_dwolla_thirdparty_account_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_dwolla_thirdparty_account_id' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_key"  id="ec_option_dwolla_thirdparty_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_dwolla_thirdparty_key' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Secret:</span><span class="ec_payment_type_row_input"><input name="ec_option_dwolla_thirdparty_secret"  id="ec_option_dwolla_thirdparty_secret" type="text" value="<?php echo stripslashes( get_option( 'ec_option_dwolla_thirdparty_secret' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Dwolla Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_dwolla_thirdparty_test_mode" id="ec_option_dwolla_thirdparty_test_mode">
                        <option value="1" <?php if (get_option('ec_option_dwolla_thirdparty_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_dwolla_thirdparty_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
                      
    <div><strong>When registering your application to get the key and secret needed to process the checkout, you should enter an application name, add the call back URL listed below, and give the application the permission to request money.</strong><br /><br /></div>
    
    <div class="ec_payment_type_row"><strong>Dwolla Payment Callback URL:</strong> <?php echo $cart_page . $permalink_divider . "ec_page=checkout_success"; ?><br /><br /></div>
    
</div>