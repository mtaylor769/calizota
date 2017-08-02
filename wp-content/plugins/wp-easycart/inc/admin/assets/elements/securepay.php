<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "securepay" ){ echo '_inactive'; } ?>" id="securepay">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecurePay Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_securepay_merchant_id"  id="ec_option_securepay_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_securepay_merchant_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecurePay Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_securepay_password"  id="ec_option_securepay_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_securepay_password' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecurePay Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_securepay_currency" id="ec_option_securepay_currency">
                        <option value="AUD" <?php if (get_option('ec_option_securepay_test_mode') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_securepay_test_mode') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CHF" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="EUR" <?php if (get_option('ec_option_securepay_test_mode') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="GBP" <?php if (get_option('ec_option_securepay_test_mode') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="HKD" <?php if (get_option('ec_option_securepay_test_mode') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="JPY" <?php if (get_option('ec_option_securepay_test_mode') == "CHF") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_securepay_test_mode') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="SGD" <?php if (get_option('ec_option_securepay_test_mode') == "SGD") echo ' selected'; ?>>SGD</option>
                        <option value="USD" <?php if (get_option('ec_option_securepay_test_mode') == "USD") echo ' selected'; ?>>USD</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecurePay Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_securepay_test_mode" id="ec_option_securepay_test_mode">
                        <option value="1" <?php if (get_option('ec_option_securepay_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_securepay_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>