<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "sagepay" ){ echo '_inactive'; } ?>" id="sagepay">

	<div class="ec_payment_type_row">3D Secure can be enabled in your Sagepay account. Once enabled, if the customer uses Visa or MasterCard AND their bank uses the Verified by Visa or MasterCard SecureCode systems, the customer will be redirected to their bank to complete the verification process. If this part fails, order will still be visible in their account and in your EasyCart Admin Console, but will say "Card Denied". If this happens you will need to follow up with your customer to process their payment again.</div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay Vendor:</span><span class="ec_payment_type_row_input"><input name="ec_option_sagepay_vendor" id="ec_option_sagepay_vendor" type="text" value="<?php echo stripslashes( get_option( 'ec_option_sagepay_vendor' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_sagepay_currency" id="ec_option_sagepay_currency">
                        <option value="AUD" <?php if (get_option('ec_option_sagepay_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_sagepay_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_sagepay_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_sagepay_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_sagepay_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="GBP" <?php if (get_option('ec_option_sagepay_currency') == "GBP") echo ' selected'; ?>>Pound Sterling</option>
                        <option value="HKD" <?php if (get_option('ec_option_sagepay_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="IDR" <?php if (get_option('ec_option_sagepay_currency') == "IDR") echo ' selected'; ?>>Rupiah</option>
                        <option value="JPY" <?php if (get_option('ec_option_sagepay_currency') == "JPY") echo ' selected'; ?>>Yen</option>
                        <option value="LUF" <?php if (get_option('ec_option_sagepay_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                        <option value="NOK" <?php if (get_option('ec_option_sagepay_currency') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                        <option value="NZD" <?php if (get_option('ec_option_sagepay_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="SEK" <?php if (get_option('ec_option_sagepay_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="SGD" <?php if (get_option('ec_option_sagepay_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="TRL" <?php if (get_option('ec_option_sagepay_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                        <option value="USD" <?php if (get_option('ec_option_sagepay_currency') == "USD") echo ' selected'; ?>>US Dollar</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay Simulator Only:</span><span class="ec_payment_type_row_input"><select name="ec_option_sagepay_simulator" id="ec_option_sagepay_simulator">
                        <option value="1" <?php if (get_option('ec_option_sagepay_simulator') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_sagepay_simulator') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_sagepay_testmode" id="ec_option_sagepay_testmode">
                        <option value="1" <?php if (get_option('ec_option_sagepay_testmode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_sagepay_testmode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>