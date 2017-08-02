<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "redsys" ){ echo '_inactive'; } ?>" id="redsys">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Merchant Code:</span><span class="ec_payment_type_row_input"><input name="ec_option_redsys_merchant_code"  id="ec_option_redsys_merchant_code" type="text" value="<?php echo stripslashes( get_option('ec_option_redsys_merchant_code' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Terminal:</span><span class="ec_payment_type_row_input"><input name="ec_option_redsys_terminal"  id="ec_option_redsys_terminal" type="text" value="<?php echo stripslashes( get_option( 'ec_option_redsys_terminal' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_redsys_currency" id="ec_option_redsys_currency">
                        <option value="978" <?php if (get_option('ec_option_redsys_currency') == "GBP") echo ' selected'; ?>>Euros</option>
                        <option value="840" <?php if (get_option('ec_option_redsys_currency') == "EUR") echo ' selected'; ?>>Dollars</option>
                        <option value="826" <?php if (get_option('ec_option_redsys_currency') == "USD") echo ' selected'; ?>>Pounds</option>
                        <option value="392" <?php if (get_option('ec_option_redsys_currency') == "DKK") echo ' selected'; ?>>Yen</option>
                      </select></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Secret Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_redsys_key"  id="ec_option_redsys_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_redsys_key' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Test Mode:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_redsys_test_mode" id="ec_option_redsys_test_mode">
                <option value="1" <?php if (get_option('ec_option_redsys_test_mode') == 1) echo ' selected'; ?>>Test Mode</option>
                <option value="0" <?php if (get_option('ec_option_redsys_test_mode') == 0) echo ' selected'; ?>>Production Mode</option>
              </select>
        </span>
    </div>
    
</div>