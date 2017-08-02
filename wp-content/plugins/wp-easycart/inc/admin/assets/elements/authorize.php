<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "authorize" ){ echo '_inactive'; } ?>" id="authorize">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Authorize.net Login ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_authorize_login_id" id="ec_option_authorize_login_id" type="text" value="<?php echo stripslashes( get_option('ec_option_authorize_login_id' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Authorize.net Transaction Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_authorize_trans_key" id="ec_option_authorize_trans_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_authorize_trans_key' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Authorize.net Currency Code:</span><span class="ec_payment_type_row_input"><select name="ec_option_authorize_currency_code" id="ec_option_authorize_currency_code">
                        <option value="USD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "USD" ){ echo " selected=\"selected\""; } ?>>USD</option>
                        <option value="CAD" <?php if ( get_option( 'ec_option_authorize_currency_code') == "CAD" ){ echo " selected=\"selected\""; } ?>>CAD</option>
                        <option value="EUR" <?php if ( get_option( 'ec_option_authorize_currency_code') == "EUR" ){ echo " selected=\"selected\""; } ?>>EUR</option>
                        <option value="GBP" <?php if ( get_option( 'ec_option_authorize_currency_code') == "GBP" ){ echo " selected=\"selected\""; } ?>>GBP</option>
                      </select></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Authorize.net Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_authorize_test_mode" id="ec_option_authorize_test_mode">
                        <option value="1" <?php if (get_option('ec_option_authorize_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_authorize_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Authorize.net Developer Account:</span><span class="ec_payment_type_row_input"><select name="ec_option_authorize_developer_account" id="ec_option_authorize_developer_account">
                        <option value="1" <?php if (get_option('ec_option_authorize_developer_account') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_authorize_developer_account') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Use Legacy URL (Most No):</span><span class="ec_payment_type_row_input"><select name="ec_option_authorize_use_legacy_url" id="ec_option_authorize_use_legacy_url">
                        <option value="1" <?php if (get_option('ec_option_authorize_use_legacy_url') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_authorize_use_legacy_url') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>