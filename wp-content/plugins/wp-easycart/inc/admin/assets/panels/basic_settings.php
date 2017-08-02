<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_options" && isset( $_POST['ec_option_terms_link'] ) ){
	ec_save_basic_settings( );
	$GLOBALS['currency'] = new ec_currency( );
	$isupdate = "1";
}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-settings" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "clear_gateway_log" ){
	ec_clear_gateway_log( );
	$isupdate = "2";
}
?>

<?php if( $isupdate && $isupdate == "1" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Settings saved.</strong></p></div>
<?php }else if( $isupdate && $isupdate == "2" ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Your gateway log has been cleared.</strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">BASIC SETTINGS</div>
<div class="ec_adin_page_intro">The options displayed on this page are those that can be changed without unintended consequences. For advanced options, visit the advanced setup page.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-settings&ec_action=save_options" method="POST">

<div class="ec_status_header"><div class="ec_status_header_text">Basic Settings</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Site Terms and Conditions Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [terms]Terms and Conditions[/terms] which will be replaced with an a link around the word between [terms] and [/terms]. It will also open into a new window.</span></a></span>
    <span class="ec_setting_row_label">Site Terms and Conditions Link:</span>
    <span class="ec_setting_row_input"><input name="ec_option_terms_link" type="text" value="<?php echo stripslashes( get_option( 'ec_option_terms_link' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Site Privacy Policy Link</em>This will only work on the final checkout page. The Cart, Payment Information, Checkout Text item in the advanced language editor allows for [privacy]Privacy Policy[/privacy] which will be replaced with an a link around the word between [privacy] and [/privacy]. It will also open into a new window.</span></a></span>
    <span class="ec_setting_row_label">Site Privacy Policy Link:</span>
    <span class="ec_setting_row_input"><input name="ec_option_privacy_link" type="text"  value="<?php echo stripslashes( get_option( 'ec_option_privacy_link' ) ); ?>" size="10" style="width:300px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Weight Unit</em>Weight unit is displayed for weight adjustment of an order and to display.  Please note that all live shipping options use their own weight choice and should be selected when live shipping is setup.</span></a></span>
    <span class="ec_setting_row_label">Weight Unit:</span>
    <span class="ec_setting_row_input"><select name="ec_option_weight">
              <option value="0"<?php if(get_option('ec_option_weight') == '0') echo ' selected'; ?>>Select a Weight Unit</option>
              <option value="lbs"<?php if(get_option('ec_option_weight') == 'lbs') echo ' selected'; ?>>LBS</option>
              <option value="kgs"<?php if(get_option('ec_option_weight') == 'kgs') echo ' selected'; ?>>KGS</option>
          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Dimension Unit</em>Dimension unit is displayed with the advanced dimensions advanced option set.</span></a></span>
    <span class="ec_setting_row_label">Dimension Unit:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_metric_unit_display" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_metric_unit_display') == "0" ){ echo " selected=\"selected\""; }?>>Standard</option><option value="1"<?php if( get_option('ec_option_enable_metric_unit_display') == "1" ){ echo " selected=\"selected\""; }?>>Metric</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Cart Icon Link in Menu</em>If you turn this on and select a menu to display this item in, a cart icon with total and number of items in cart is displayed in your menu.</span></a></span>
    <span class="ec_setting_row_label">Show Cart Icon Link in Menu:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_menu_cart_icon" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_menu_cart_icon') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_menu_cart_icon') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row" style="height:auto">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Cart Icon Menu</em>If you turn on the option to show cart icon link in the menu, then you can select the menu in which you want the icon to appear for this option.</span></a></span>
    <span class="ec_setting_row_label">Cart Icon Menu:</span>
    <span class="ec_setting_row_input">
    <select multiple name="ec_option_cart_menu_id[]" style="width:auto; max-width:350px;">
    	<option value="0"<?php if( get_option('ec_option_cart_menu_id') == "0" ){ echo " selected=\"selected\""; }?>>No Menu</option>
        <?php 
		$ids = explode( '***', get_option('ec_option_cart_menu_id') );
		
		$menus = get_registered_nav_menus( );
		$keys = array_keys( $menus );
		foreach ( $keys as $key ) {
			echo '<option value="' . $key . '"';
			if( in_array( $key, $ids ) ){ 
				echo " selected=\"selected\""; 
			}
			echo '>' . $menus[$key] . '</option>';
		}
		?>
    </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Cart Icon for Empty Cart</em>If you use the cart icon in your menu, this option allows you to hide the icon when nothing is in the cart.</span></a></span>
    <span class="ec_setting_row_label">Hide Cart Icon for Empty Cart:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_cart_icon_on_empty" style="width:100px;"><option value="0"<?php if( get_option('ec_option_hide_cart_icon_on_empty') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_hide_cart_icon_on_empty') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>


<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Newsletter Popup on Site</em>If you turn this on, a user will be prompted to sign up for your newsletter subscription list when they visit your site. Their sign up is tracked by session and cookie through their browser, so once they sign up or hide the box, they will not be shown it again.</span></a></span>
    <span class="ec_setting_row_label">Show Newsletter Popup on Site:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_newsletter_popup" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_newsletter_popup') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_newsletter_popup') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Live Design Editor from Admin</em>If you turn this on, you will not be able to edit the design of your site from page to page. This is great to turn on if you want to lock in your store design or if you are having difficulties with the browser displaying the high number of elements required for the live editor.</span></a></span>
    <span class="ec_setting_row_label">Hide Live Design Editor from Admin:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_live_editor" style="width:100px;"><option value="0"<?php if( get_option('ec_option_hide_live_editor') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_hide_live_editor') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Gateway Log</em>This option is meant as a way to allow you or the EasyCart support staff to quickly troublshoot API calls by logging all call responses to the database and making them available for download in your Store Admin -> Settings -> Gateway Log.</span></a></span>
    <span class="ec_setting_row_label">Enable Gateway Log (<a href="admin.php?page=ec_adminv2&amp;ec_page=store-setup&amp;ec_panel=basic-settings&amp;ec_action=clear_gateway_log">click to clear log</a>):</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_gateway_log" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_gateway_log') == "0" ){ echo " selected=\"selected\""; }?>>Disabled</option><option value="1"<?php if( get_option('ec_option_enable_gateway_log') == "1" ){ echo " selected=\"selected\""; }?>>Enabled</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Currency Display: <?php echo $GLOBALS['currency']->get_currency_display( 1999.990 ); ?></div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Base Currency Code</em>This is the currency your store is based in. If you choose to use the currency conversion option to allow customers to see the store in alternate currencies, the store will convert from this to another currency for display, but final checkout must be in the currency setup for your payment gateway.</span></a></span>
    <span class="ec_setting_row_label">Base Currency Code:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_base_currency" value="<?php echo stripslashes( get_option( 'ec_option_base_currency' ) ); ?>"></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Currency Symbol</em>All currency symbols can easily be changed here.  Please note that all payment processors determine the actual payment currency, not this symbol.  Check with your payment processor to ensure you are processing in the proper currency that you need, then apply the currency symbol here to align your store.</span></a></span>
    <span class="ec_setting_row_label">Currency Symbol:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_currency" value="<?php echo stripslashes( get_option( 'ec_option_currency' ) ); ?>"></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Currency Location</em>You can choose to have currency symbols in front of the numbers, or trailing the numbers.  This is usually country specific.</span></a></span>
    <span class="ec_setting_row_label">Currency Symbol Location:</span>
    <span class="ec_setting_row_input"><select name="ec_option_currency_symbol_location" id="ec_option_currency_symbol_location">
            <option value="1" <?php if (get_option('ec_option_currency_symbol_location') == 1) echo ' selected'; ?>>Left</option>
            <option value="0" <?php if (get_option('ec_option_currency_symbol_location') == 0) echo ' selected'; ?>>Right</option>
          </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Negative Symbol Location</em>You can choose to have the negative symbol in front of the currency symbol or behind.  This is usually country specific</span></a></span>
    <span class="ec_setting_row_label">Negative Location:</span>
    <span class="ec_setting_row_input"><select name="ec_option_currency_negative_location" id="ec_option_currency_negative_location">
                <option value="1" <?php if (get_option('ec_option_currency_negative_location') == 1) echo ' selected'; ?>>Before</option>
                <option value="0" <?php if (get_option('ec_option_currency_negative_location') == 0) echo ' selected'; ?>>After</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Decimal Symbol</em>You can choose to have a decimal symbol represented by something besides the standard period. Some countries represent the decimal with a comma.</span></a></span>
    <span class="ec_setting_row_label">Currency Decimal Symbol:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_currency_decimal_symbol">
            <option value=""<?php if( stripslashes( get_option( 'ec_option_currency_decimal_symbol' ) ) == '' ){ ?> selected="selected"<?php }?>>none</option>
        	<option value="."<?php if( stripslashes( get_option( 'ec_option_currency_decimal_symbol' ) ) == '.' ){ ?> selected="selected"<?php }?>>.</option>
            <option value=","<?php if( stripslashes( get_option( 'ec_option_currency_decimal_symbol' ) ) == ',' ){ ?> selected="selected"<?php }?>>,</option>
            <option value="·"<?php if( stripslashes( get_option( 'ec_option_currency_decimal_symbol' ) ) == '·' ){ ?> selected="selected"<?php }?>>·</option>
            <option value="’"<?php if( stripslashes( get_option( 'ec_option_currency_decimal_symbol' ) ) == '’' ){ ?> selected="selected"<?php }?>>’</option>
        </select>
    </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Decimal Length</em>Choose how many decimals are to be represented after the decimal symbol.  Most countries are 2 decimal places, some countries are 3 decimal places.</span></a></span>
    <span class="ec_setting_row_label">Currency Decimal Length:</span>
    <span class="ec_setting_row_input"><input name="ec_option_currency_decimal_places" type="number" min="0" nax="5" value="<?php echo stripslashes( get_option( 'ec_option_currency_decimal_places' ) ); ?>" size="1" style="width:40px;" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Grouping Symbol</em>You may choose what symbol reprsents your thousands seperator.  Most countries represent this with a comma, but you can enter another value depending on your countries typical format.</span></a></span>
    <span class="ec_setting_row_label">Currency Grouping Symbol:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_currency_thousands_seperator">
        	<option value=","<?php if( stripslashes( get_option( 'ec_option_currency_thousands_seperator' ) ) == ',' ){ ?> selected="selected"<?php }?>>,</option>
        	<option value="."<?php if( stripslashes( get_option( 'ec_option_currency_thousands_seperator' ) ) == '.' ){ ?> selected="selected"<?php }?>>.</option>
        	<option value=" "<?php if( stripslashes( get_option( 'ec_option_currency_thousands_seperator' ) ) == ' ' ){ ?> selected="selected"<?php }?>>space</option>
        	<option value="˙"<?php if( stripslashes( get_option( 'ec_option_currency_thousands_seperator' ) ) == '˙' ){ ?> selected="selected"<?php }?>>˙</option>
        	<option value="'"<?php if( stripslashes( get_option( 'ec_option_currency_thousands_seperator' ) ) == "'" ){ ?> selected="selected"<?php }?>>'</option>
        </select>     
        </span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Currency Code in Display</em>This option will make the display in the format of USD $19.99 or EUR $29.99, which will switch with the currency conversion widget.</span></a></span>
    <span class="ec_setting_row_label">Show Currency Code in Display:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_currency_code" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_currency_code') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_currency_code') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<a name="product"></a>
<div class="ec_status_header"><div class="ec_status_header_text">Store Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Layout Format (V2 ONLY)</em>This will display the products in either a grid or list view. Some product types are best displayed in a grid view, others in a list view, choose what makes the most sense for you. For V3 users, you can choose the list type 6 from the product display types in the live editor on the store page and set your columns to 1.</span></a></span>
    <span class="ec_setting_row_label">Product Layout Format (V2 ONLY):</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_layout_type" id="ec_option_product_layout_type">
                <option value="grid_only" <?php if (get_option('ec_option_product_layout_type') == 'grid_only') echo ' selected'; ?>>Grid Layout</option>
                <option value="list_only" <?php if (get_option('ec_option_product_layout_type') == 'list_only') echo ' selected'; ?>>List Layout</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Featured Categories</em>This option allows you to show featured categories at the top of the store page as well as sub categories on top of category pages.</span></a></span>
    <span class="ec_setting_row_label">Show Featured Categories:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_featured_categories" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_featured_categories') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_featured_categories') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Product Sort</em>This will set the default sort technique for the products page. For example, changing to Title A-Z will have the products sorted this way by default.</span></a></span>
    <span class="ec_setting_row_label">Default Product Sort:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_store_filter" id="ec_option_default_store_filter">
                <option value="0" <?php if (get_option('ec_option_default_store_filter') == '0') echo ' selected'; ?>>Default Sorting</option>
                <option value="1" <?php if (get_option('ec_option_default_store_filter') == '1') echo ' selected'; ?>>Price Low-High</option>
                <option value="2" <?php if (get_option('ec_option_default_store_filter') == '2') echo ' selected'; ?>>Price High-Low</option>
                <option value="3" <?php if (get_option('ec_option_default_store_filter') == '3') echo ' selected'; ?>>Title A-Z</option>
                <option value="4" <?php if (get_option('ec_option_default_store_filter') == '4') echo ' selected'; ?>>Title Z-A</option>
                <option value="5" <?php if (get_option('ec_option_default_store_filter') == '5') echo ' selected'; ?>>Newest</option>
                <option value="6" <?php if (get_option('ec_option_default_store_filter') == '6') echo ' selected'; ?>>Best Rating</option>
                <option value="7" <?php if (get_option('ec_option_default_store_filter') == '7') echo ' selected'; ?>>Most Viewed</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Price Low-High" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_1" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_1') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_1') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Price High-Low" Sort Option:</span><span class="ec_setting_row_input"><select name="ec_option_product_filter_2" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_2') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_2') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Title A-Z" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_3" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_3') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_3') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Title Z-A" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_4" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_4') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_4') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Newest" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_5" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_5') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_5') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Best Rating" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_6" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_6') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_6') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Product Filter Option On/Off</em>This option is to turn the sort option on/off for the product sort/filter.</span></a></span>
    <span class="ec_setting_row_label">Show "Most Viewed" Sort Option:</span>
    <span class="ec_setting_row_input"><select name="ec_option_product_filter_7" style="width:100px;"><option value="0"<?php if( get_option('ec_option_product_filter_7') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_product_filter_7') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Paged Product List</em>By turning this on/off you can enable/disable the ability to limit the products per page and show the paging information on the store.</span></a></span>
    <span class="ec_setting_row_label">Paged Product List:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_product_paging" id="select">
                  <option value="1" <?php if (get_option('ec_option_enable_product_paging') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_enable_product_paging') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Sorting Box</em>By turning this on/off you can show/hide the sorting box on the products page.</span></a></span>
    <span class="ec_setting_row_label">Show Sorting Box:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_sort_box" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_sort_box') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_sort_box') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Live Search</em>By turning this on the store search widget will return live results to the customer.</span></a></span>
    <span class="ec_setting_row_label">Use Live Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_live_search" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_live_search') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_live_search') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Title in Search</em>By turning this on the store search widget will return results by comparing the search to the title.</span></a></span>
    <span class="ec_setting_row_label">Include Title in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_title" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_title') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_title') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Model Number in Search</em>By turning this on the store search widget will return results by comparing the search to the model number.</span></a></span>
    <span class="ec_setting_row_label">Include Model Number in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_model_number" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_model_number') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_model_number') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Manufacturer in Search</em>By turning this on the store search widget will return results by comparing the search to the manufacturer.</span></a></span>
    <span class="ec_setting_row_label">Include Manufacturer in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_manufacturer" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_manufacturer') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_manufacturer') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Description in Search</em>By turning this on the store search widget will return results by comparing the search to the full product description.</span></a></span>
    <span class="ec_setting_row_label">Include Description in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_description" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_description') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_description') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Short Description in Search</em>By turning this on the store search widget will return results by comparing the search to the product short description.</span></a></span>
    <span class="ec_setting_row_label">Include Short Description in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_short_description" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_short_description') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_short_description') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Include Menu Items in Search</em>By turning this on the store search widget will return results by comparing the search to the store menu names.</span></a></span>
    <span class="ec_setting_row_label">Include Menu Items in Search:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_menu" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_menu') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_search_menu') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Search Format</em>Searching by OR will return more results and searching by AND requires all words in the search to be included in the results.</span></a></span>
    <span class="ec_setting_row_label">Search Format:</span>
    <span class="ec_setting_row_input"><select name="ec_option_search_by_or" id="select">
                  <option value="1" <?php if (get_option('ec_option_search_by_or') == 1) echo ' selected'; ?>>OR keywords (most)</option>
                  <option value="0" <?php if (get_option('ec_option_search_by_or') == 0) echo ' selected'; ?>>AND keywords (limits results)</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Tiered Price Format</em>As low as format will display as: As Low As $4.99 and retail price format will show the price entered in the product main price.</span></a></span>
    <span class="ec_setting_row_label">Tiered Price Format:</span>
    <span class="ec_setting_row_input"><select name="ec_option_tiered_price_format" id="select">
                  <option value="1" <?php if (get_option('ec_option_tiered_price_format') == 1) echo ' selected'; ?>>Show as low as price</option>
                  <option value="0" <?php if (get_option('ec_option_tiered_price_format') == 0) echo ' selected'; ?>>Show retail price</option>
              	</select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<a name="product-details"></a>
<div class="ec_status_header"><div class="ec_status_header_text">Product Details Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Facebook Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_facebook_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_facebook_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_facebook_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Twitter Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_twitter_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_twitter_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_twitter_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Delicious Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_delicious_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_delicious_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_delicious_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show MySpace Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_myspace_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_myspace_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_myspace_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show LinkedIn Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_linkedin_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_linkedin_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_linkedin_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
	<span class="ec_setting_row_label">Show Email Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_email_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_email_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_email_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Digg Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_digg_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_digg_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_digg_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Google+ Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_googleplus_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_googleplus_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_googleplus_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Social Media Icon On/Off</em>By turning this option on, your customers will be able to quickly click and post, tweet, email, etc... About the product they are viewing. When on, the store will display the cooresponding icon on each product detail page.</span></a></span>
    <span class="ec_setting_row_label">Show Pinterest Icon:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_pinterest_icon" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_pinterest_icon') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_pinterest_icon') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Breadcrumbs</em>By turning this option on/off you are showing and hiding the breadcrumbs display within the product details page (only applies to the store not your theme).</span></a></span>
    <span class="ec_setting_row_label">Show Breadcrumbs:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_breadcrumbs" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_breadcrumbs') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_breadcrumbs') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Model Number</em>By turning this option on/off you are showing and hiding the model number display within the product details page.</span></a></span>
    <span class="ec_setting_row_label">Show Model Number:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_model_number" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_model_number') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_model_number') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Stock Quantity</em>By turning this option on/off you are showing and hiding the stock quantity display within the product details page.</span></a></span>
    <span class="ec_setting_row_label">Show Stock Quantity:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_stock_quantity" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_stock_quantity') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_stock_quantity') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Categories</em>By turning this option on/off you are showing and hiding the categories display within the product details page if the product is attached to categories.</span></a></span>
    <span class="ec_setting_row_label">Show Categories:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_categories" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_categories') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_categories') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Manufacturer</em>By turning this option on/off you are showing and hiding the manufacturer link display within the product details page if the product.</span></a></span>
    <span class="ec_setting_row_label">Show Manufacturer:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_manufacturer" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_manufacturer') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_manufacturer') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Image Magnification Box</em>By turning this option on/off you are showing or hiding the hover magnification box on the product details page.</span></a></span>
    <span class="ec_setting_row_label">Use Image Magnification Box:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_magnification" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_magnification') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_magnification') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Popup Large Image View</em>By turning this option on/off you are allowing or disallowing the popup box with a large image view.</span></a></span>
    <span class="ec_setting_row_label">Show Popup Large Image View:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_large_popup" id="select">
                  <option value="1" <?php if (get_option('ec_option_show_large_popup') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_show_large_popup') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require User Logged in to Review</em>By turning this option on/off are allowing anonymous custom reviews or requiring the user to sign in first to review.</span></a></span>
    <span class="ec_setting_row_label">Require User Logged in to Review:</span>
    <span class="ec_setting_row_input"><select name="ec_option_customer_review_require_login" id="select">
                  <option value="1" <?php if (get_option('ec_option_customer_review_require_login') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_customer_review_require_login') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show User's Name on Customer Review (if available)</em>By turning this option on/off are showing the review user's name. This applies only to users that are logged into their EasyCart account during submission.</span></a></span>
    <span class="ec_setting_row_label">Show User's Name on Customer Review:</span>
    <span class="ec_setting_row_input"><select name="ec_option_customer_review_show_user_name" id="select">
                  <option value="1" <?php if (get_option('ec_option_customer_review_show_user_name') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_customer_review_show_user_name') == 0) echo ' selected'; ?>>No</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Price for Seasonal Mode Products</em>By turning this on, you can hide the price for any seasonal mode products.</span></a></span>
    <span class="ec_setting_row_label">Hide Price for Seasonal Mode Products:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_price_seasonal" id="select">
                  <option value="0" <?php if (get_option('ec_option_hide_price_seasonal') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_hide_price_seasonal') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Hide Price for Inquiry Mode Products</em>By turning this on, you can hide the price for any inquiry mode products.</span></a></span>
    <span class="ec_setting_row_label">Hide Price for Inquiry Mode Products:</span>
    <span class="ec_setting_row_input"><select name="ec_option_hide_price_inquiry" id="select">
                  <option value="0" <?php if (get_option('ec_option_hide_price_inquiry') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_hide_price_inquiry') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Vat Included and Excluded Prices</em>By turning this on, if you are using VAT, the user will see the price of the product with and without VAT.</span></a></span>
    <span class="ec_setting_row_label">Show Vat Included and Excluded Prices:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_multiple_vat_pricing" id="select">
                  <option value="0" <?php if (get_option('ec_option_show_multiple_vat_pricing') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_show_multiple_vat_pricing') == 1) echo ' selected'; ?>>Yes, Show Both</option>
                  <option value="2" <?php if (get_option('ec_option_show_multiple_vat_pricing') == 2) echo ' selected'; ?>>Yes, Show Included Only</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Deconetwork Allow Blank Item Purchase</em>By turning this on, a customer can purchase a Deconetwork product without custom designing it.</span></a></span>
    <span class="ec_setting_row_label">Deconetwork Allow Blank Item Purchase:</span>
    <span class="ec_setting_row_input"><select name="ec_option_deconetwork_allow_blank_products" id="select">
                  <option value="0" <?php if (get_option('ec_option_deconetwork_allow_blank_products') == 0) echo ' selected'; ?>>No</option>
                  <option value="1" <?php if (get_option('ec_option_deconetwork_allow_blank_products') == 1) echo ' selected'; ?>>Yes</option>
              	</select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Form Submission for Inquiry Link</em>By turning this on, your inquiry button with outside link with send as a form submission in which the model number is included in the URL. Turning off means the button is a simple link.</span></a></span>
    <span class="ec_setting_row_label">Form Submission for Inquiry Button:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_inquiry_form" id="select">
                  <option value="1" <?php if (get_option('ec_option_use_inquiry_form') == 1) echo ' selected'; ?>>Show Inquiry URL as Form Action</option>
                  <option value="0" <?php if (get_option('ec_option_use_inquiry_form') == 0) echo ' selected'; ?>>Show Inquiry URL as Link</option>
              	</select></span>
</div>

<a id="cart-settings"></a>
<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<a name="cart"></a>
<div class="ec_status_header"><div class="ec_status_header_text">Cart Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Selected Payment Type</em>This will select the default payment type that will be displayed to the customer as the main payment type.</span></a></span>
    <span class="ec_setting_row_label">Default Selected Payment Type:</span>
    <span class="ec_setting_row_input"><select name="ec_option_default_payment_type" id="ec_option_default_payment_type">
                <option value="manual_bill" <?php if (get_option('ec_option_default_payment_type') == 'manual_bill') echo ' selected'; ?>>Manual Billing</option>
                <option value="third_party" <?php if (get_option('ec_option_default_payment_type') == 'third_party') echo ' selected'; ?>>Third Party</option>
                <option value="credit_card" <?php if (get_option('ec_option_default_payment_type') == 'credit_card') echo ' selected'; ?>>Credit Card</option>
              </select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Default Country Selected</em>This will be the default country selected when none selected for the user during checkout and account creation.</span></a></span>
    <span class="ec_setting_row_label">Default Country Selected:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_default_country" id="ec_option_default_country">
            <option value="0" <?php if( get_option( 'ec_option_default_country' ) == '0' ){ ?> "selected"<?php }?>>No Default Country</option>
            <?php 
			$countries = $GLOBALS['ec_countries']->countries;
			foreach( $countries as $country ){ ?>
            <option value="<?php echo $country->iso2_cnt; ?>"<?php if( get_option( 'ec_option_default_country' ) == $country->iso2_cnt ){ ?> selected="selected"<?php }?>><?php echo $country->name_cnt; ?></option>
            <?php }?>
          </select>
	</span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>International Country Box Position</em>If you expect international orders, it is best to display the country drop down box before the rest of the form. This allows the form to change based on the country selected and helps with compatibility for user inputs. This requires you have the latest design files.</span></a></span>
    <span class="ec_setting_row_label">International Country Box Position:</span>
    <span class="ec_setting_row_input"><select name="ec_option_display_country_top" style="width:123px;"><option value="0"<?php if( get_option('ec_option_display_country_top') == "0" ){ echo " selected=\"selected\""; }?>>Below Zip</option><option value="1"<?php if( get_option('ec_option_display_country_top') == "1" ){ echo " selected=\"selected\""; }?>>Top of Form</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Use Second Address Line</em>Display two address lines for input on checkout form and account.</span></a></span>
    <span class="ec_setting_row_label">Use Second Address Line:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_address2" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_address2') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_address2') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Collect User Phone Number</em>If enabled, the system will collect the phone number from the user.</span></a></span>
    <span class="ec_setting_row_label">Collect User Phone Number:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_user_phone" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_user_phone') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_user_phone') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Company Name in Address</em>If enabled, the system will offer a place for an optional company name for a user's address.</span></a></span>
    <span class="ec_setting_row_label">Enable Company Name in Address:</span>
    <span class="ec_setting_row_input">
    <select name="ec_option_enable_company_name" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_company_name') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_company_name') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Guest Checkout</em>When guest checkout is enabled a user has the option complete the checkout process without entering a password for an account. All the same information is recorded when a user checks out as a guest, but no user is created for that order. In addition, the customer cannot return to the site to see their past orders.</span></a></span>
    <span class="ec_setting_row_label">Enable Guest Checkout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_allow_guest" style="width:100px;"><option value="0"<?php if( get_option('ec_option_allow_guest') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_allow_guest') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Minimum Order Total</em>If you wish to require your customers to spend a minimum amount before checkout out, enter that value here.</span></a></span>
    <span class="ec_setting_row_label">Minimum Order Total:</span>
    <span class="ec_setting_row_input"><input type="number" min="0.00" step=".01" name="ec_option_minimum_order_total" style="width:123px;" value="<?php echo get_option( 'ec_option_minimum_order_total' ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Shipping in Store</em>Disabling this option will hide shipping on checkout, addres review, receipts, and in the account from the user. It will also override any shipping options you may have setup previously. The customer will only be able to enter billing information on checkout if this is disabled. NOTE: users who had first install prior to 1.1.18 will need to upgrade their layout files in order to leverage this option.</span></a></span>
    <span class="ec_setting_row_label">Enable Shipping in Store:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Customer Notes on Checkout</em>Enabling this option will allow customers to enter custom notes on the last step of checkout. NOTE: users for had a first install prior to 1.1.18 will need to update their layout and theme fiiles manually in order to use this option.</span></a></span>
    <span class="ec_setting_row_label">Enable Customer Notes on Checkout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_user_order_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_user_order_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_user_order_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Gift Cards</em>Enabling/Disabling will essentially show or hide the gift card box during checkout.</span></a></span>
    <span class="ec_setting_row_label">Enable Gift Cards:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_giftcards" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_giftcards') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_giftcards') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Coupon Codes</em>Enabling/Disabling will essentially show or hide the coupon code box during checkout.</span></a></span>
    <span class="ec_setting_row_label">Enable Coupon Codes:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_coupons" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_coupons') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_coupons') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Return To Previous Page after Add to Cart Success</em>If enabled, the user will be returned to the store page or previous product page with a notice about add to cart success. This option actually returns to the previous page on the server, so if you use a widget or shortcode you may see a different result. If you leave this off the customer is still forwarded to the cart.</span></a></span>
    <span class="ec_setting_row_label">Return To Previous Page after Add to Cart:</span>
    <span class="ec_setting_row_input"><select name="ec_option_addtocart_return_to_product" style="width:100px;"><option value="0"<?php if( get_option('ec_option_addtocart_return_to_product') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_addtocart_return_to_product') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){ 
/* V2 ONLY */
?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Login Screen in Cart</em>If enabled, the system will skip the screen to log into your account first. This option will speed up checkout for new users and, if you have the latest design files, will still display the log in screen at the top.</span></a></span>
    <span class="ec_setting_row_label">Skip Login Screen in Cart:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_cart_login" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_cart_login') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_cart_login') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>
<?php }?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Shipping Cart Panel</em>If enabled, the system will skip the panel in the cart where the user is asked to select their shipping method. This data is instead collected on the final checkout page if needed.</span></a></span>
    <span class="ec_setting_row_label">Skip Shipping Cart Panel:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_shipping_page" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_shipping_page') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_shipping_page') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<?php if( !file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/head_content.php" ) ){ 
/* V2 ONLY */
?>
<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Skip Review Order Screen</em>If enabled, the system will submit the order directly after they enter their payment information. The review screen is useful for orders that require shipping and often have multiple items.</span></a></span>
    <span class="ec_setting_row_label">Skip Review Order Screen:</span>
    <span class="ec_setting_row_input"><select name="ec_option_skip_reivew_screen" style="width:100px;"><option value="0"<?php if( get_option('ec_option_skip_reivew_screen') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_skip_reivew_screen') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>
<?php }?>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Terms Agreement</em>If enabled, the system requires the users to agree to the terms and conditions of the website.</span></a></span>
    <span class="ec_setting_row_label">Require Terms Agreement:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_terms_agreement" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_terms_agreement') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_terms_agreement') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Name for Contact Information</em>If enabled, the checkout will require a user to input their first and last name during the creation of an account (this is separate from the billing and shipping information).</span></a></span>
    <span class="ec_setting_row_label">Require Name for Contact Information:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_contact_name" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_contact_name') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_contact_name') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Enable Estimate Shipping</em>If enabled, your customer will see an estimate shipping area during the checkout process.</span></a></span>
    <span class="ec_setting_row_label">Enable Estimate Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_use_estimate_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_use_estimate_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_use_estimate_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Tax Shipping</em>If enabled, tax will be collected for shipping (does not apply to tax cloud, which automatically determines if shipping should be taxed on a stated to state basis).</span></a></span>
    <span class="ec_setting_row_label">Tax Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_tax_on_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_tax_on_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_tax_on_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Card Holder Name Field</em>If enabled, the customer can enter a different name than their billing name, but if disabled the card holder name will be the billing first and last by default.</span></a></span>
    <span class="ec_setting_row_label">Show Card Holder Name Field:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_card_holder_name" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_card_holder_name') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_card_holder_name') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Send Low Stock Admin Emails</em>If enabled, and the product purchased tracks stock quantity, the admin will be notified after an order has been placed that puts the stock quantity of a product below the low stock quantity amount. The low quantity trigger amount can be entered below.</span></a></span>
    <span class="ec_setting_row_label">Send Low Stock Admin Emails:</span>
    <span class="ec_setting_row_input"><select name="ec_option_send_low_stock_emails" style="width:100px;"><option value="0"<?php if( get_option('ec_option_send_low_stock_emails') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_send_low_stock_emails') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Low Stock Emails Trigger Amount</em>This is the number in stock that will trigger the low stock email, if enabled above.</span></a></span>
    <span class="ec_setting_row_label">Low Stock Emails Trigger Amount:</span>
    <span class="ec_setting_row_input"><input type="number" name="ec_option_low_stock_trigger_total" style="width:50px; height:28px; line-height:28px; padding:0px; margin-top:8px; text-align:center;" value="<?php echo get_option( 'ec_option_low_stock_trigger_total' ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Send Out of Stock Admin Emails</em>If enabled, and the product purchased tracks stock quantity, the admin will be notified after an order has been placed that puts the stock quantity of a product equal to zero.</span></a></span>
    <span class="ec_setting_row_label">Send Out of Stock Admin Emails:</span>
    <span class="ec_setting_row_input"><select name="ec_option_send_out_of_stock_emails" style="width:100px;"><option value="0"<?php if( get_option('ec_option_send_out_of_stock_emails') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_send_out_of_stock_emails') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Display Delivery Days on Live Shipping</em>If enabled and you are using live shipping and delivery days are offered back from the live shipping api the user will see the esimtated delivery time next to the shipping rate label.</span></a></span>
    <span class="ec_setting_row_label">Display Delivery Days on Live Shipping:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_delivery_days_live_shipping" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_delivery_days_live_shipping') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_delivery_days_live_shipping') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Model Number Extension</em>This is the divider used when using option item model number extensions. Example of this being modelnumber-a-2-3-d where each character after a dash is added by the option set and the dash determined by this option.</span></a></span>
    <span class="ec_setting_row_label">Model Number Extension:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_model_number_extension" style="width:50px; height:28px; line-height:28px; padding:0px; margin-top:8px; text-align:center;" value="<?php echo get_option( 'ec_option_model_number_extension' ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show VAT Registration Number on Checkout</em>If enabled the user may enter an optional VAT registration number on checkout.</span></a></span>
    <span class="ec_setting_row_label">Show VAT Registration Number on Checkout:</span>
    <span class="ec_setting_row_input"><select name="ec_option_collect_vat_registration_number" style="width:100px;"><option value="0"<?php if( get_option('ec_option_collect_vat_registration_number') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_collect_vat_registration_number') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Custom Rate for VAT Registration Entry</em>This is the rate that will be charged a user if they enter their VAT registration number. If the option to validate their VAT registration number is also enabled, this rate will not apply unless the number is validated first.</span></a></span>
    <span class="ec_setting_row_label">Custom Rate for VAT Registration Entry:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_vat_custom_rate" style="width:50px; height:28px; line-height:28px; padding:0px; margin-top:8px; text-align:center;" value="<?php echo get_option( 'ec_option_vat_custom_rate' ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Validate VAT Registration Number</em>If enabled you will also need to enable VAT registration collection and enter your Vatlayer API Key to complete setup.</span></a></span>
    <span class="ec_setting_row_label">Validate VAT Registration Number:</span>
    <span class="ec_setting_row_input"><select name="ec_option_validate_vat_registration_number" style="width:100px;"><option value="0"<?php if( get_option('ec_option_validate_vat_registration_number') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_validate_vat_registration_number') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Vatlayer API Key</em>You can get your free API access key at vatlayer.com. Adding this option will allow you to validate the user VAT registration number entry before processing their order.</span></a></span>
    <span class="ec_setting_row_label">Vatlayer API Key:</span>
    <span class="ec_setting_row_input"><input type="text" name="ec_option_vatlayer_api_key" style="width:350px; height:28px; line-height:28px;" value="<?php echo get_option( 'ec_option_vatlayer_api_key' ); ?>" /></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Account Page Display Options</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Add Billing Address Input on Account Registration Page</em>Enabling this option adds and requires the user to enter a billing address when creating a new account through the account page.</span></a></span>
    <span class="ec_setting_row_label">Require Billing Input on Account Registration Page:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_account_address" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_account_address') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_account_address') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Email Validation on Registration</em>Enabling this option will require a user to click a link in an email sent to their registered email account before they can use their account. This option only applies to creating an account through the account page. The act of creating an account during checkout will count as validation of the account.</span></a></span>
    <span class="ec_setting_row_label">Require Email Validation on Registration:</span>
    <span class="ec_setting_row_input"><select name="ec_option_require_email_validation" style="width:100px;"><option value="0"<?php if( get_option('ec_option_require_email_validation') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_require_email_validation') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Show Manage Subscriptions Link</em>You should only leave this enabled if you are using subscriptions or memberships with the store, otherwise it will not apply to you. Additionally, since subscriptions and memberships are only available with the Stripe payment processor, you must have this selected for your credit card processor to display.</span></a></span>
    <span class="ec_setting_row_label">Show Manage Subscriptions Link:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_account_subscriptions_link" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_account_subscriptions_link') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_account_subscriptions_link') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Require Custom User Notes on Registration</em>You can require a user registering for your site through the account area to enter some kind of user notes. This is commonly used when a user is required to validate themselves in some way. You can customize the instructions for this field through the advanced language area of the site.</span></a></span>
    <span class="ec_setting_row_label">Require Custom User Notes on Registration:</span>
    <span class="ec_setting_row_input"><select name="ec_option_enable_user_notes" style="width:100px;"><option value="0"<?php if( get_option('ec_option_enable_user_notes') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_enable_user_notes') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Display Subscriber Feature</em>you can show or hide the checkbox and message asking the user to subscribe during checkout and account creation.</span></a></span>
    <span class="ec_setting_row_label">Display Subscriber Feature:</span>
    <span class="ec_setting_row_input"><select name="ec_option_show_subscriber_feature" style="width:100px;"><option value="0"<?php if( get_option('ec_option_show_subscriber_feature') == "0" ){ echo " selected=\"selected\""; }?>>Off</option><option value="1"<?php if( get_option('ec_option_show_subscriber_feature') == "1" ){ echo " selected=\"selected\""; }?>>On</option></select></span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>

<div class="ec_status_header"><div class="ec_status_header_text">Google Analytics Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Analytics</em>This is your google analytics code that will collect eCommerce transaction data.  EasyCart analytics will not track your page data, please use a third party plugin such as Yoast or your theme for that data. This only represents the eCommerce transaction collection process so as not to overlap with another plugin.</span></a></span>
    <span class="ec_setting_row_label">Google Analytics ID for Order Tracking:</span>
    <span class="ec_setting_row_input"><input name="ec_option_googleanalyticsid" type="text" value="<?php echo stripslashes( get_option( 'ec_option_googleanalyticsid' ) ); ?>" /></span>
</div>

<div class="ec_status_header"><div class="ec_status_header_text">Google Adwords Setup</div></div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion ID</em>This is your adwords conversion id; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion ID (Conversion Tracking):</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_conversion_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_conversion_id' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion Language</em>This is your adwords conversion language; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion Language:</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_language" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_language' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion Format</em>This is your adwords conversion format; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion Format:</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_format" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_format' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion Color</em>This is your adwords conversion color; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion Color:</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_color" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_color' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion Label</em>This is your adwords conversion label; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion Label:</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_label" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_label' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Conversion Currency</em>This is your adwords conversion currency; setup in the tools, conversions section.</span></a></span>
    <span class="ec_setting_row_label">Google Conversion Currency:</span>
    <span class="ec_setting_row_input"><input name="ec_option_google_adwords_currency" type="text" value="<?php echo stripslashes( get_option( 'ec_option_google_adwords_currency' ) ); ?>" /></span>
</div>

<div class="ec_setting_row">
	<span class="ec_setting_row_help"><a href="#" class="ec_tooltip"><img src="<?php echo plugins_url('wp-easycart/inc/admin/assets/images/help_icon.png' ); ?>" alt="" width="25" height="25" /><span class="ec_custom ec_help"><img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/help.png' ); ?>" alt="Help" height="48" width="48" /><em>Google Remarketing Only</em>Use Google adwords for remarketing only.</span></a></span>
    <span class="ec_setting_row_label">Google Remarketing Only:</span>
    <span class="ec_setting_row_input">
    	<select name="ec_option_google_adwords_remarketing_only">
        	<option value="false"<?php if( get_option( 'ec_option_google_adwords_remarketing_only' ) == "false" ){ ?> selected="selected"<?php }?>>false</option>
            <option value="true"<?php if( get_option( 'ec_option_google_adwords_remarketing_only' ) == "true" ){ ?> selected="selected"<?php }?>>true</option>
        </select>
    </span>
</div>

<div class="ec_save_changes_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>