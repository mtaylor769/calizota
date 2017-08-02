<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "moneris_ca" ){ echo '_inactive'; } ?>" id="moneris_ca">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Moneris CA Store ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_moneris_ca_store_id" id="ec_option_moneris_ca_store_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_moneris_ca_store_id' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Moneris CA API Token:</span><span class="ec_payment_type_row_input"><input name="ec_option_moneris_ca_api_token" id="ec_option_moneris_ca_api_token" type="text" value="<?php echo stripslashes( get_option( 'ec_option_moneris_ca_api_token' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Moneris CA Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_moneris_ca_test_mode" id="ec_option_moneris_ca_test_mode">
                        <option value="1" <?php if (get_option('ec_option_moneris_ca_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_moneris_ca_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>

</div>