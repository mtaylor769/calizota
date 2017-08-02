<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "paymentexpress" ){ echo '_inactive'; } ?>" id="paymentexpress">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Payment Express User Name:</span><span class="ec_payment_type_row_input"><input name="ec_option_payment_express_username"  id="ec_option_payment_express_username" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payment_express_username' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Payment Express Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_payment_express_password"  id="ec_option_payment_express_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payment_express_password' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Payment Express Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_payment_express_currency" id="ec_option_payment_express_currency">
                        <option value="USD" <?php if (get_option('ec_option_payment_express_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_payment_express_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="CHF" <?php if (get_option('ec_option_payment_express_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="DKK" <?php if (get_option('ec_option_payment_express_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="EUR" <?php if (get_option('ec_option_payment_express_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="FRF" <?php if (get_option('ec_option_payment_express_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                        <option value="GBP" <?php if (get_option('ec_option_payment_express_currency') == "GBP") echo ' selected'; ?>>United Kingdom Pound</option>
                        <option value="HKD" <?php if (get_option('ec_option_payment_express_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_payment_express_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="NZD" <?php if (get_option('ec_option_payment_express_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="SGD" <?php if (get_option('ec_option_payment_express_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="THB" <?php if (get_option('ec_option_payment_express_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="ZAR" <?php if (get_option('ec_option_payment_express_currency') == "ZAR") echo ' selected'; ?>>Rand</option>
                        <option value="AUD" <?php if (get_option('ec_option_payment_express_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="WST" <?php if (get_option('ec_option_payment_express_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                        <option value="VUV" <?php if (get_option('ec_option_payment_express_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                        <option value="TOP" <?php if (get_option('ec_option_payment_express_currency') == "TOP") echo ' selected'; ?>>Tongan Pa'anga</option>
                        <option value="SBD" <?php if (get_option('ec_option_payment_express_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                        <option value="PGK" <?php if (get_option('ec_option_payment_express_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                        <option value="MYR" <?php if (get_option('ec_option_payment_express_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="KWD" <?php if (get_option('ec_option_payment_express_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        <option value="FJD" <?php if (get_option('ec_option_payment_express_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        
                      </select></span></div>
                      
      

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Developer Account:</span><span class="ec_payment_type_row_input"><select name="ec_option_payment_express_developer_account" id="ec_option_payment_express_developer_account">
                        <option value="1" <?php if (get_option('ec_option_payment_express_developer_account') == "1") echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_payment_express_developer_account') == "0") echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>