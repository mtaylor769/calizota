<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "paypal_pro" ){ echo '_inactive'; } ?>" id="paypal_pro">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro Partner:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_pro_partner"  id="ec_option_paypal_pro_partner" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_pro_partner' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro User:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_pro_user"  id="ec_option_paypal_pro_user" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_pro_user' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro Vendor:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_pro_vendor" id="ec_option_paypal_pro_vendor"  type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_pro_vendor' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_pro_password"  id="ec_option_paypal_pro_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_pro_password' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_pro_currency" id="ec_option_paypal_pro_currency">
                        <option value="USD" <?php if (get_option('ec_option_paypal_pro_currency') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="AUD" <?php if (get_option('ec_option_paypal_pro_currency') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                        <option value="BRL" <?php if (get_option('ec_option_paypal_pro_currency') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
                        <option value="CAD" <?php if (get_option('ec_option_paypal_pro_currency') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                        <option value="CZK" <?php if (get_option('ec_option_paypal_pro_currency') == 'CZK') echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_paypal_pro_currency') == 'EUR') echo ' selected'; ?>>Euro</option>
                        <option value="HKD" <?php if (get_option('ec_option_paypal_pro_currency') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_paypal_pro_currency') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="ILS" <?php if (get_option('ec_option_paypal_pro_currency') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
                        <option value="JPY" <?php if (get_option('ec_option_paypal_pro_currency') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                        <option value="MYR" <?php if (get_option('ec_option_paypal_pro_currency') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MXN" <?php if (get_option('ec_option_paypal_pro_currency') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
                        <option value="NOK" <?php if (get_option('ec_option_paypal_pro_currency') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="NZD" <?php if (get_option('ec_option_paypal_pro_currency') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="PHP" <?php if (get_option('ec_option_paypal_pro_currency') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
                        <option value="PLN" <?php if (get_option('ec_option_paypal_pro_currency') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                        <option value="GBP" <?php if (get_option('ec_option_paypal_pro_currency') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                        <option value="SGD" <?php if (get_option('ec_option_paypal_pro_currency') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SEK" <?php if (get_option('ec_option_paypal_pro_currency') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                        <option value="CHF" <?php if (get_option('ec_option_paypal_pro_currency') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                        <option value="TWD" <?php if (get_option('ec_option_paypal_pro_currency') == 'TWD') echo ' selected'; ?>>Taiwan New Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_paypal_pro_currency') == 'THB') echo ' selected'; ?>>Thai Baht</option>
                        <option value="TRY" <?php if (get_option('ec_option_paypal_pro_currency') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
                      </select></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal PayFlow Pro Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_pro_test_mode" id="ec_option_paypal_pro_test_mode">
                        <option value="1" <?php if (get_option('ec_option_paypal_pro_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_paypal_pro_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
                      
	<div><strong>NOTE: You must enter the same URL you use for your store in your PayPal Manager -> Contact Information -> Web URL. If you enter the wrong URL, you will end up causing a user not authenicated error.</strong></div>
	    
</div>