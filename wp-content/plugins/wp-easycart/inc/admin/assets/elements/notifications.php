<?php
if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

$ec_license = new ec_license( );
if( !$ec_license->is_registered( ) ){ ?>
	<div class="ec_license_notification"><div class="ec_license_notification_inner">You are running the WP EasyCart FREE version. To purchase the LITE or STANDARD version and unlock the full selling potential visit <a href="http://www.wpeasycart.com/wordpress-shopping-cart-pricing/?ecid=admin_console" target="_blank">www.wpeasycart.com</a> and purchase a license.</div></div>
<?php 
}else if( $ec_license->is_registered( ) && $ec_license->is_lite_version(  ) && get_option( 'ec_option_show_lite_message' ) ){ ?>
	<div class="ec_license_notification"><div class="ec_license_notification_inner">You are running the WP EasyCart LITE version. The LITE version does not include Live Payment Gateways, Promotions, Coupons, Live Shipping, or Unlimited Products. If you would like to unlock all features of the WP EasyCart, purchase the Standard upgrade <a href="http://www.wpeasycart.com/products/wp-easycart-standard-version/?ecid=admin_console" target="_blank">here</a>. You can dismiss this banner by clicking <a href="admin.php?page=ec_adminv2&dismiss_lite_banner=dismiss">here</a>.</div></div>
<?php } ?>