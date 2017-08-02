<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "paypal_payments_pro" ){ echo '_inactive'; } ?>" id="paypal_payments_pro">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Payments Pro User:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_payments_pro_user"  id="ec_option_paypal_payments_pro_user" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_payments_pro_user' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Payments Pro Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_payments_pro_password"  id="ec_option_paypal_payments_pro_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_payments_pro_password' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Payments Pro Signature:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypal_payments_pro_signature" id="ec_option_paypal_payments_pro_signature"  type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypal_payments_pro_signature' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Payments Pro Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_payments_pro_currency" id="ec_option_paypal_payments_pro_currency">
                        <option value="USD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="AUD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CZK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
                        <option value="DKK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'DKK') echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'EUR') echo ' selected'; ?>>Euro</option>
                        <option value="HKD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="JPY" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
                        <option value="NOK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="NZD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="PLN" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
                        <option value="GBP" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
                        <option value="SGD" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SEK" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
                        <option value="CHF" <?php if (get_option('ec_option_paypal_payments_pro_currency') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
                      </select></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">PayPal Payments Pro Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypal_payments_pro_test_mode" id="ec_option_paypal_payments_pro_test_mode">
                        <option value="1" <?php if (get_option('ec_option_paypal_payments_pro_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_paypal_payments_pro_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>