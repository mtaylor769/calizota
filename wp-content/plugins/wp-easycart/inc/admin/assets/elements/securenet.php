<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "securenet" ){ echo '_inactive'; } ?>" id="securenet">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecureNet ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_securenet_id" id="ec_option_securenet_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_securenet_id' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SecureNet Secure Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_securenet_secure_key" id="ec_option_securenet_secure_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_securenet_secure_key' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sandbox Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_securenet_use_sandbox" id="ec_option_securenet_use_sandbox">
                        <option value="0" <?php if (get_option('ec_option_securenet_use_sandbox') == 0) echo ' selected'; ?>>No</option>
                        <option value="1" <?php if (get_option('ec_option_securenet_use_sandbox') == 1) echo ' selected'; ?>>Yes</option>
                      </select></span></div>
    
    <div class="ec_payment_type_row"><strong>Note: </strong>Your Securenet ID is not your log in user name, but instead the ID listed in your Merchant Profile.</div>
	    
</div>