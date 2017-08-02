<?php
$validate = new ec_validation; 
$license = new ec_license;
$language = new ec_language( );
$language->update_language_data( ); //Do this to update the database if a new language is added

$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" && isset( $_POST['ec_option_use_wp_mail'] ) ){
	ec_save_email_settings( );
	$language->update_language_data( );
	$isupdate = "1";
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "smtp-test1" ){
	$smtp_errors = wpeasycart_smtp_test1( );
	if( !$smtp_errors )
		$isupdate = "2";
	else
		$isupdate = "3";
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "smtp-test2" ){
	$smtp_errors = wpeasycart_smtp_test2( );
	if( !$smtp_errors )
		$isupdate = "2";
	else
		$isupdate = "3";
}
?>

<?php if( $isupdate && $isupdate == "1" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Settings saved.</strong></p></div>
<?php }else if( $isupdate && $isupdate == "2" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Email Test Sent Successfully! Give 10 minutes and check your junk mail if you do not see the test right away!</strong></p></div>
<?php }else if( $isupdate && $isupdate == "3" ) { ?>
	<div id='setting-error-settings_updated' class='notice notice-error'><p><strong>Email Test Failed! Errors: <?php echo $smtp_errors; ?></strong></p></div>
<?php } ?> 

<div class="ec_admin_page_title">EMAIL SETTINGS</div>
<div class="ec_adin_page_intro">The options here apply to your email receipt and email sending method.</div>

<br />

<hr />
<div class="ec_status_header"><div class="ec_status_header_text">Select Your Email Method</div></div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=email-settings&ec_action=save_options" method="POST">

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Email Method</em>EasyCart offers a built in system using PhP's Mail System. You may also choose to use WordPress's Mail System if you are having difficulties.</span></a></span>
    <span class="ec_setting_row_label">Email Method</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_use_wp_mail" id="ec_option_use_wp_mail" style="width:200px;" onchange="wpeasycart_update_use_wp_mail( );">
        	<option value="0"<?php if( get_option('ec_option_use_wp_mail') == "0" ){ echo " selected=\"selected\""; }?>>EasyCart Mail System</option>
            <option value="1"<?php if( get_option('ec_option_use_wp_mail') == "1" ){ echo " selected=\"selected\""; }?>>WordPress's Mail System</option>
        </select>
    </span>
</div>

<hr />
<div class="ec_status_header"><div class="ec_status_header_text">Order Receipt Emails - From Address Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order From Email</em>Emails go out to customers once an order is placed and successfully processed.  This email address represents who that email comes from and if a customer hits reply, this email is where they will respond to. If you would like a name to be displayed in the 'From' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Order Receipt From Email Address:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_email" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_email' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_order_use_smtp_choice"<?php if( get_option('ec_option_use_wp_mail') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use SMTP</em>This feature works with EasyCart's built in email system to allow you to send emails for the store through SMTP, which allows for more reliable email delivery.</span></a></span>
    <span class="ec_setting_row_label">Use SMTP</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_order_use_smtp" id="ec_option_order_use_smtp" onchange="wpeasycart_update_order_use_smtp( );" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_order_use_smtp') == "0" ){ echo " selected=\"selected\""; }?>>No SMTP Needed</option>
            <option value="1"<?php if( get_option('ec_option_order_use_smtp') == "1" ){ echo " selected=\"selected\""; }?>>Yes, Use SMTP</option>
        </select>
    </span>
</div>

<div class="ec_setting_row" id="ec_option_order_from_smtp_host_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order Receipt SMTP Host</em>Your mail server url for your order receipt email address.</span></a></span>
    <span class="ec_setting_row_label">Order Receipt SMTP Host:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_smtp_host" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_host' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_order_from_smtp_encryption_type_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order Receipt SMTP Encryption Type</em>For most servers SSL is the recommended option, but choose the best option for your order receipt email address.</span></a></span>
    <span class="ec_setting_row_label">Order Receipt SMTP Encryption Type</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_order_from_smtp_encryption_type" style="width:200px;">
        	<option value="none"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "none" ){ echo " selected=\"selected\""; }?>>None</option>
            <option value="ssl"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "ssl" ){ echo " selected=\"selected\""; }?>>SSL</option>
            <option value="tls"<?php if( get_option('ec_option_order_from_smtp_encryption_type') == "tls" ){ echo " selected=\"selected\""; }?>>TLS</option>
        </select>
    </span>
</div>

<div class="ec_setting_row" id="ec_option_order_from_smtp_port_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order Receipt SMTP Port</em>This is the port to your mail server for your order receipt email address.</span></a></span>
    <span class="ec_setting_row_label">Order Receipt SMTP Port:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_smtp_port" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_port' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_order_from_smtp_username_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order Receipt SMTP User Name</em>This is the username to log into your mail server for your order receipt email address.</span></a></span>
    <span class="ec_setting_row_label">Order Receipt SMTP User Name:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_smtp_username" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_username' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_order_from_smtp_password_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_order_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Order Receipt SMTP Password</em>This is the SMTP password for the order receipt email address.</span></a></span>
    <span class="ec_setting_row_label">Order Receipt SMTP Password:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_order_from_smtp_password" type="password" value="<?php echo stripslashes( get_option( 'ec_option_order_from_smtp_password' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" style="text-align:center;">
	<span class="ec_setting_row_input" style="float:none;">
    	<a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=email-settings&ec_action=smtp-test1">Send Test to Admin Email Address(es)</a>
    </span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<hr />
<div class="ec_status_header"><div class="ec_status_header_text">Customer Account Emails - From Address Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account From Email Address</em>This email is the from address for all customer related emails.</span></a></span>
	<span class="ec_setting_row_label">Customer Account From Email Address:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_email" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_email' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_password_use_smtp_choice"<?php if( get_option('ec_option_use_wp_mail') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use SMTP</em>This feature works with EasyCart's built in email system to allow you to send emails for the store through SMTP, which allows for more reliable email delivery.</span></a></span>
    <span class="ec_setting_row_label">Use SMTP</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_password_use_smtp" id="ec_option_password_use_smtp" onchange="wpeasycart_update_password_use_smtp( );" style="width:200px;">
        	<option value="0"<?php if( get_option('ec_option_password_use_smtp') == "0" ){ echo " selected=\"selected\""; }?>>No SMTP Needed</option>
            <option value="1"<?php if( get_option('ec_option_password_use_smtp') == "1" ){ echo " selected=\"selected\""; }?>>Yes, Use SMTP</option>
        </select>
    </span>
</div>

<div class="ec_setting_row" id="ec_option_password_from_smtp_host_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account SMTP Host</em>Your mail server url for your customer account email address.</span></a></span>
    <span class="ec_setting_row_label">Customer Account SMTP Host:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_smtp_host" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_host' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_password_from_smtp_encryption_type_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account SMTP Encryption Type</em>For most servers SSL is the recommended option, but choose the best option for your customer account email address.</span></a></span>
    <span class="ec_setting_row_label">Customer Account SMTP Encryption Type</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_password_from_smtp_encryption_type" style="width:200px;">
        	<option value="none"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "none" ){ echo " selected=\"selected\""; }?>>None</option>
            <option value="ssl"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "ssl" ){ echo " selected=\"selected\""; }?>>SSL</option>
            <option value="tls"<?php if( get_option('ec_option_password_from_smtp_encryption_type') == "tls" ){ echo " selected=\"selected\""; }?>>TLS</option>
        </select>
    </span>
</div>

<div class="ec_setting_row" id="ec_option_password_from_smtp_port_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account SMTP Port</em>This is the port to your mail server for your customer account email address.</span></a></span>
    <span class="ec_setting_row_label">Customer Account SMTP Port:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_smtp_port" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_port' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_password_from_smtp_username_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account SMTP User Name</em>This is the username to log into your mail server for your customer account email address.</span></a></span>
    <span class="ec_setting_row_label">Customer Account SMTP User Name:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_smtp_username" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_username' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" id="ec_option_password_from_smtp_password_display"<?php if( get_option('ec_option_use_wp_mail') || !get_option('ec_option_password_use_smtp') ){ ?> style="display:none;"<?php }?>>
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Customer Account SMTP Password</em>This is the SMTP password for the customer account email address.</span></a></span>
    <span class="ec_setting_row_label">Customer Account SMTP Password:</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_password_from_smtp_password" type="password" value="<?php echo stripslashes( get_option( 'ec_option_password_from_smtp_password' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row" style="text-align:center;">
	<span class="ec_setting_row_input" style="float:none;">
    	<a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=email-settings&ec_action=smtp-test2">Send Test to Admin Email Address(es)</a>
    </span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<hr />
<div class="ec_status_header"><div class="ec_status_header_text">Email Receipt Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Admin Order Email Addresses</em>Copies of every order will be sent to these email addresses as a second email, meaning the customer will not see these email addresses. You can add multiple addresses seperated by commas. If you would like a name to be displayed in the 'From' line, enter an email address as follows: My Name&lt;myemail@mysite.com&gt;</span></a></span>
    <span class="ec_setting_row_label">Admin Email Address(es):</span>
    <span class="ec_setting_row_input">
    <input name="ec_option_bcc_email_addresses" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Email on Receipt</em>If enabled, your email receipts will include the email address of the customer on the receipt.</span></a></span>
    <span class="ec_setting_row_label">Show Email Address on Receipt:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_email_on_receipt" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_email_on_receipt') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_email_on_receipt') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Image on Receipt</em>If enabled, your email receipts will include the image of the product on the receipt.</span></a></span>
    <span class="ec_setting_row_label">Show Product Images on Receipt:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_image_on_receipt" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_image_on_receipt') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_image_on_receipt') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<?php $min_order_id = wpeasycart_get_current_order_id( ); ?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Next Order ID</em>You may choose an order id to start with to autoincrement as long as that order number has not yet been used.</span></a></span>
    <span class="ec_setting_row_label">Next Order ID (min allowed is <?php echo $min_order_id; ?>)</span>
    <span class="ec_setting_row_input"><input type="number" min="<?php echo $min_order_id; ?>" name="ec_option_current_order_id" id="ec_option_current_order_id" value="<?php echo $min_order_id; ?>" style="width:200px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Receipt Logo</em>You may upload the logo for your email receipt here.</span></a></span>
    <span class="ec_setting_row_label">Receipt Logo</span>
    <?php // Logo Uploader ?>
    <span class="ec_colorizer_row_input">
        <input id="upload_logo_button" type="button" class="button" value="Upload Receipt Logo" style="margin-top:9px;" />
        <input id="ec_option_email_logo" type="hidden" size="36" name="ec_option_email_logo" value="<?php echo get_option( 'ec_option_email_logo' ); ?>" />
    </span>
</div>

<div class="ec_colorizer_row" style="float:none; height:auto;">
    <img src="<?php echo get_option( 'ec_option_email_logo' ); ?>" id="email_logo_image" style="max-height:250px; margin:10px 0; padding:10px; border:1px solid #a2ab9f;" />
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<?php
$file_name = get_option( 'ec_option_language' );
$key_section = 'cart_success';
$language_section = $language->language_data->{$file_name}->options->{$key_section};
$section_label = $language_section->label;
?>
    
<input type="hidden" name="file_name" value="<?php echo $file_name; ?>" />
<input type="hidden" name="key_section" value="<?php echo $key_section; ?>" />
<input type="hidden" name="isupdate" value="1" />
    
<div class="ec_language_section_title"><div class="ec_language_section_title_padding"><?php echo $section_label; ?> - Edit Content --- If you need to edit multiple languages, go to the advanced language setup page and expand the order details section for each language.</div></div>
<div class="ec_language_section_holder" id="<?php echo $file_name . "_" . $key_section; ?>" style="display:block !important;">
    <?php
    foreach( $language_section->options as $key => $language_item ){
    $title = $language_item->title;
    $value = $language_item->value;
    ?>
    <div class="ec_language_row_holder"><span class="ec_language_row_label"><?php echo $title; ?>: </span><span class="ec_language_row_input"><input name="ec_language_field[<?php echo $key; ?>]" type="text" value="<?php echo htmlspecialchars( stripslashes( $value ), ENT_QUOTES, "UTF-8" ); ?>" style="width:250px;" /></span></div>
    <?php }?>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>

<script>

function ec_show_language_section( section ){
	jQuery( '#' + section ).slideDown( "slow" );
	jQuery( '#' + section + "_expand" ).hide( );
	jQuery( '#' + section + "_contract" ).show( );
}

function ec_hide_language_section( section ){
	jQuery( '#' + section ).slideUp( "slow" );
	jQuery( '#' + section + "_expand" ).show( );
	jQuery( '#' + section + "_contract" ).hide( );
}

function wpeasycart_update_use_wp_mail( ){
	if( jQuery( document.getElementById( 'ec_option_use_wp_mail' ) ).val( ) == "0" ){
		
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_order_use_smtp( );
		
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_password_use_smtp( );
	
	}else{
		
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_order_use_smtp( );
		
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_use_smtp_choice' ) ).val( 0 );
		wpeasycart_update_password_use_smtp( );
	
	}
}

function wpeasycart_update_order_use_smtp( ){
	if( jQuery( document.getElementById( 'ec_option_order_use_smtp' ) ).val( ) == "0" ){
		jQuery( document.getElementById( 'ec_option_order_from_smtp_host_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_encryption_type_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_port_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_username_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_password_display' ) ).hide( );
	}else{
		jQuery( document.getElementById( 'ec_option_order_from_smtp_host_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_encryption_type_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_port_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_username_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_order_from_smtp_password_display' ) ).show( );
	}
}

function wpeasycart_update_password_use_smtp( ){
	if( jQuery( document.getElementById( 'ec_option_password_use_smtp' ) ).val( ) == "0" ){
		jQuery( document.getElementById( 'ec_option_password_from_smtp_host_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_encryption_type_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_port_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_username_display' ) ).hide( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_password_display' ) ).hide( );
	}else{
		jQuery( document.getElementById( 'ec_option_password_from_smtp_host_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_encryption_type_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_port_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_username_display' ) ).show( );
		jQuery( document.getElementById( 'ec_option_password_from_smtp_password_display' ) ).show( );
	}
}

jQuery( document ).ready( function( $ ){
	
	var custom_uploader;
	
	jQuery( '#upload_logo_button' ).click( function( e ){
 
		e.preventDefault( );
		
		if( custom_uploader ){
			custom_uploader.open( );
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
 
		custom_uploader.on( 'select', function( ){
			attachment = custom_uploader.state( ).get( 'selection' ).first( ).toJSON( );
			jQuery( '#email_logo_image' ).attr( "src", attachment.url );
			jQuery( '#ec_option_email_logo' ).val( attachment.url );
		} );
 
		custom_uploader.open( );
 
	});
} );

</script>