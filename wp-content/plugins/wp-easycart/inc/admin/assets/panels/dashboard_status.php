<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "store-status" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "send_test_email" ){
	$result = ec_send_test_email( );
	if( $result )
		$isupdate = "1";
	else
		$isupdate = "2";
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "store-status" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "reset_store_permalinks" ){
	ec_reset_store_permalinks( );
	$isupdate = "3";
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "store-status" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "fix_database" ){
	ec_fix_database_errors( );
	$isupdate = "4";
}
?>

<?php if( $isupdate && $isupdate == "1" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>The receipt has been sent to the customer's email address and the admin.</strong></p></div>
<?php }else if( $isupdate && $isupdate == "2" ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>The order row was not found from the entered order id.</strong></p></div> 
<?php
}else if( $isupdate && $isupdate == "3" ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Your store permalinks have been reset.</strong></p></div> 
<?php
}else if( $isupdate && $isupdate == "4" ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Your database issues should be resolved now.</strong></p></div> 
<?php
}
///////////////////////////////////////////////
// Server Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Server Settings Status</div></div>

<?php 
////////////////////////////
// PHP Versoin Check
////////////////////////////
if( ec_get_php_version( ) < 5.3 ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">PHP 5.3 is the mimimal version accepted. We do not guarantee functionality for PHP versions below 5.3 at this time.</span></div>
<?php }else{ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Your PHP Version is <?php echo ec_get_php_version( ); ?>, meeting the PHP 5.3 minimal setup.</span></div>
<?php } ?>

<?php
///////////////////////////////////////////////
// EasyCart Status Section
///////////////////////////////////////////////
?>
<div class="ec_status_header"><div class="ec_status_header_text">EasyCart Setup Status</div></div>
<?php
////////////////////////////
// Data Folder Check
////////////////////////////
if( wpeasycart_is_data_folder_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Data Folders Setup Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=store-status&ec_action=fix_data_folders">Fix Errors</a> <?php echo ec_get_data_folders_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// DB Check
////////////////////////////
if( wpeasycart_is_database_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Database Setup Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=store-status&ec_action=fix_database">Fix Errors</a> <?php echo ec_get_database_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Store Page Setup Check
////////////////////////////
if( ec_is_store_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Store Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_store_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Cart Page Setup Check
////////////////////////////
if( ec_is_cart_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Cart Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_cart_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Account Page Setup Check
////////////////////////////
if( ec_is_account_page_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Account Page Setup &amp; Connected Correctly</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label"><?php echo ec_get_account_page_error( ); ?></span></div>
<?php } ?>

<?php
////////////////////////////
// Demo Data Addable Check
////////////////////////////
if( ec_is_demo_data_writable( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">Your server is configured correctly for automatic demo data installation.</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">The setup of your server does not allow for us to copy the demo data and write it to your store. Manually add products to test functionality.</span></div>
<?php } ?>

<?php
////////////////////////////
// Demo Data Addable Check
////////////////////////////
if( ec_basic_settings_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have added the required basic settings.</span></div>
<?php }else{ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have not added a <?php echo ec_get_basic_missing_settings( ); ?>.</span></div>
<?php } 
///////////////////////////////////////////////
// Shipping Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Shipping Status</div></div>

<?php
////////////////////////////
// Price Based Shipping Check
////////////////////////////
if( ec_using_price_shipping( ) && ec_price_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup price based shipping.</span></div>
<?php }else if( ec_using_price_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have chosen to use price based shipping, but there doesn't appear to be any price triggers setup.</span></div>
<?php }

////////////////////////////
// Weight Based Shipping Check
////////////////////////////
if( ec_using_weight_shipping( ) && ec_weight_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup weight based shipping.</span></div>
<?php }else if( ec_using_weight_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have chosen to use weight based shipping, but there doesn't appear to be any weight triggers setup.</span></div>
<?php }

////////////////////////////
// Quantity Based Shipping Check
////////////////////////////
if( ec_using_quantity_shipping( ) && ec_quantity_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup quantity based shipping.</span></div>
<?php }else if( ec_using_quantity_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have chosen to use quantity based shipping, but there doesn't appear to be any quantity triggers setup.</span></div>
<?php }

////////////////////////////
// Percentage Based Shipping Check
////////////////////////////
if( ec_using_percentage_shipping( ) && ec_percentage_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup percentage based shipping.</span></div>
<?php }else if( ec_using_percentage_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have chosen to use percentage based shipping, but there doesn't appear to be any percentage triggers setup.</span></div>
<?php }

////////////////////////////
// Method Based Shipping Check
////////////////////////////
if( ec_using_method_shipping( ) && ec_method_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup method based shipping.</span></div>
<?php }else if( ec_using_method_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have chosen to use method based shipping, but there doesn't appear to be any method triggers setup.</span></div>
<?php }

////////////////////////////
// Live Based Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && !ec_live_shipping_setup( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have live shipping selected, but no rates are setup.</span></div>
<?php }

////////////////////////////
// UPS Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_ups_shipping( ) && ec_ups_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup UPS live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_ups_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">UPS live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// USPS Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_usps_shipping( ) && ec_usps_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup USPS live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_usps_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">USPS live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// FEDEX Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_fedex_shipping( ) && ec_fedex_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup FedEx live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_fedex_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">FedEx live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// DHL Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_dhl_shipping( ) && ec_dhl_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup DHL live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_dhl_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">DHL live shipping setup incorrectly.</span></div>
<?php }

////////////////////////////
// AUSPOST Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_auspost_shipping( ) && ec_auspost_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup Australia Post live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_auspost_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">Australia Post live shipping setup incorrectly.</span></div>
<?php } 

////////////////////////////
// Canada Post Shipping Check
////////////////////////////
if( ec_using_live_shipping( ) && ec_using_canadapost_shipping( ) && ec_canadapost_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup Canada Post live shipping.</span></div>
<?php }else if( ec_using_live_shipping( ) && ec_using_canadapost_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">Canada Post live shipping setup incorrectly.</span></div>
<?php } 

////////////////////////////
// Fraktjakt Shipping Check
////////////////////////////
if( ec_using_fraktjakt_shipping( ) && ec_fraktjakt_shipping_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully setup Fraktjakt live shipping.</span></div>
<?php }else if( ec_using_fraktjakt_shipping( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">Fraktjakt live shipping is setup incorrectly.</span></div>
<?php } 

///////////////////////////////////////////////
// Tax Status Section
///////////////////////////////////////////////
?>

<div class="ec_status_header"><div class="ec_status_header_text">Tax Status</div></div>

<?php 
////////////////////////////
// No Tax Check
////////////////////////////
if( ec_using_no_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You are setup to use no tax structure, this can be changed in the Store Admin -> Rates -> Tax Rates panel.</span></div>
<?php }

////////////////////////////
// State Tax Check
////////////////////////////
if( ec_using_state_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured state/province taxes.</span></div>
<?php }

////////////////////////////
// Country Tax Check
////////////////////////////
if( ec_using_country_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured country taxes.</span></div>
<?php }

////////////////////////////
// Gloabl Tax Check
////////////////////////////
if( ec_using_global_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured global taxes.</span></div>
<?php }

////////////////////////////
// Duty Tax Check
////////////////////////////
if( ec_using_duty_tax( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured customs duty or export taxes.</span></div>
<?php }

////////////////////////////
// VAT Tax Check
////////////////////////////
if( ec_using_vat_tax( ) && ec_global_vat_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have successfully configured VAT.</span></div>
<?php }else if( ec_using_vat_tax( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected to use VAT, but have not entered a rate and/or have not set any individual country rates.</span></div>
<?php } ?>

<div class="ec_status_header"><div class="ec_status_header_text">Payment Status</div></div>
<?php
///////////////////////////////////////////////
// Payment Status Section
///////////////////////////////////////////////

////////////////////////////
// No Payment Type Selected Check
////////////////////////////
if( ec_no_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have not selected a payment method, the checkout process cannot be completed by your customers at this time.</span></div>
<?php } 

////////////////////////////
// Manual Payment Type Selected Check
////////////////////////////
if( ec_manual_payment_selected( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have setup your store to use manual payment. This method requires your customer to send a check or direct deposit before shipping.</span></div>
<?php } 

////////////////////////////
// Third Party Payment Type Selected Check
////////////////////////////
if( ec_third_party_payment_selected( ) && ec_third_party_payment_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have selected to use <?php echo ec_get_third_party_method( ); ?> as a third party payment method and you have entered all necessary info.</span></div>
<?php }else if( ec_third_party_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected <?php echo ec_get_third_party_method( ); ?> , but have missed some necessary info. Go to Store Setup -> Payment Setup to resolve this.</span></div>
<?php } 

////////////////////////////
// Live Payment Type Selected Check
////////////////////////////
if( ec_live_payment_selected( ) && ec_live_payment_setup( ) ){ ?>
<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">You have selected to use <?php echo ec_get_live_payment_method( ); ?> as a live payment method and you have entered all necessary info.</span></div>
<?php }else if( ec_live_payment_selected( ) ){ ?>
<div class="ec_status_error"><span class="ec_status_error_light"></span><span class="ec_status_label">You have selected <?php echo ec_get_live_payment_method( ); ?> , but have missed some necessary info. Go to Store Setup -> Payment Setup to resolve this.</span></div>
<?php } ?>

<div class="ec_status_header"><div class="ec_status_header_text">Miscellaneous</div></div>

<?php
////////////////////////////
// Provide fix for custom post type links
////////////////////////////
?>

<div class="ec_status_success"><span class="ec_status_success_light"></span><span class="ec_status_label">If you are having problems with store links, <a href="admin.php?page=ec_adminv2&amp;ec_page=dashboard&amp;ec_panel=store-status&amp;ec_action=reset_store_permalinks">reset permalinks</a> | <a href="admin.php?page=ec_adminv2&amp;ec_page=dashboard&amp;ec_panel=store-status&amp;ec_action=reset_store_permalinks&ec_reset_phase2=true">rebuild permalinks</a></span></div>

<form action="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=store-status&ec_action=send_test_email" method="POST">
<div class="ec_status_header"><div class="ec_status_header_text">Receipt Email Test</div></div>
<div class="ec_adin_page_intro">This section is intended to troubleshoot the EasyCart emailer system. First place an order, then you can change the status of the order in the admin to a completed payment status (this allows you to test without actually completing the checkout payment process). Once you have a completed order, get the order id, enter it below, and hit the send email button.</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Send Receipt Test Emails</em> go out to customers once an order is placed and successfully processed.  This email address represents who that email comes from and if a customer hits reply, this email is where they will respond to. If you would like a name to be displayed in the 'FROM' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Order ID:</span>
    <span class="ec_setting_row_input">
    <input type="text" name="ec_order_id" value="1700" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SEND EMAIL" class="ec_save_changes_button" /></div>
</form>