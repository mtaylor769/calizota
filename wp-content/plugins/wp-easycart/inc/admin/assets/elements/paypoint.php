<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "paypoint" ){ echo '_inactive'; } ?>" id="paypoint">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Paypoint Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypoint_merchant_id"  id="ec_option_paypoint_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypoint_merchant_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Paypoint VPN Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_paypoint_vpn_password" id="ec_option_paypoint_vpn_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_paypoint_vpn_password' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Paypoint Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_paypoint_test_mode" id="ec_option_paypoint_test_mode">
                        <option value="1" <?php if (get_option('ec_option_paypoint_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_paypoint_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>