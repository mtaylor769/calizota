<?php
$validate = new ec_validation; 
$license = new ec_license;
$language = new ec_language( );
$language->update_language_data( ); //Do this to update the database if a new language is added

$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-test" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "send_test_email" ){
	$result = ec_send_test_email( );
	if( $result )
		$isupdate = "1";
	else
		$isupdate = "2";
}
?>

<?php if( $isupdate && $isupdate == "1" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>The receipt has been resent to the customer and admin.</strong></p></div>
<?php }else if( $isupdate && $isupdate == "2" ){ ?>
	<div id='setting-error-settings_updated' class='notice notice-error'><p><strong>The order row was not found from the entered order id.</strong></p></div> 
<?php } ?> 

<div class="ec_admin_page_title">EMAIL SETTINGS</div>
<div class="ec_adin_page_intro">The options here apply to your email receipt and email sending method.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=email-test&ec_action=send_test_email" method="POST">
<div class="ec_status_header"><div class="ec_status_header_text">Receipt Email Test</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Send Receipt Test Emails</em> go out to customers once an order is placed and successfully processed.  This email address represents who that email comes from and if a customer hits reply, this email is where they will respond to. If you would like a name to be displayed in the 'From' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Order ID:</span>
    <span class="ec_setting_row_input">
    <input type="text" name="ec_order_id" value="1700" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="Send Order Receipt Email To Admin Email Address(es)" class="ec_save_changes_button" /></div>
</form>
