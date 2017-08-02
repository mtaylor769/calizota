<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "realex" ){ echo '_inactive'; } ?>" id="realex">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_realex_merchant_id"  id="ec_option_realex_merchant_id" type="text" value="<?php echo stripslashes( get_option('ec_option_realex_merchant_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Secret:</span><span class="ec_payment_type_row_input"><input name="ec_option_realex_secret"  id="ec_option_realex_secret" type="text" value="<?php echo stripslashes( get_option( 'ec_option_realex_secret' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_realex_currency" id="ec_option_realex_currency">
                        <option value="GBP" <?php if (get_option('ec_option_realex_currency') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="EUR" <?php if (get_option('ec_option_realex_currency') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="USD" <?php if (get_option('ec_option_realex_currency') == "USD") echo ' selected'; ?>>USD</option>
                        <option value="DKK" <?php if (get_option('ec_option_realex_currency') == "DKK") echo ' selected'; ?>>DKK</option>
                        <option value="NOK" <?php if (get_option('ec_option_realex_currency') == "NOK") echo ' selected'; ?>>NOK</option>
                        <option value="CHF" <?php if (get_option('ec_option_realex_currency') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="AUD" <?php if (get_option('ec_option_realex_currency') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_realex_currency') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CZK" <?php if (get_option('ec_option_realex_currency') == "CZK") echo ' selected'; ?>>CZK</option>
                        <option value="JPY" <?php if (get_option('ec_option_realex_currency') == "JPY") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_realex_currency') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="HKD" <?php if (get_option('ec_option_realex_currency') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="ZAR" <?php if (get_option('ec_option_realex_currency') == "ZAR") echo ' selected'; ?>>ZAR</option>
                        <option value="SEK" <?php if (get_option('ec_option_realex_currency') == "SEK") echo ' selected'; ?>>SEK</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Use 3D Secure (when possible):</span><span class="ec_payment_type_row_input"><select name="ec_option_realex_3dsecure" id="ec_option_realex_3dsecure">
                        <option value="1" <?php if (get_option('ec_option_realex_3dsecure') == 1) echo ' selected'; ?>>Yes, All 3D Secure</option>
                        <option value="2" <?php if (get_option('ec_option_realex_3dsecure') == 2) echo ' selected'; ?>>Yes, But Only When Liability Shifts to Merchant</option>
                        <option value="0" <?php if (get_option('ec_option_realex_3dsecure') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>