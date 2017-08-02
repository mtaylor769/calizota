<div class="ec_payment_type_holder" id="ec_proxy_section">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Use Proxy:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_proxy" id="ec_option_use_proxy"> 
                  <option value="1" <?php if (get_option('ec_option_use_proxy') == 1) echo ' selected'; ?>>Yes</option>
                  <option value="0" <?php if (get_option('ec_option_use_proxy') == 0) echo ' selected'; ?>>No</option>
              	</select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Proxy Address:</span><span class="ec_payment_type_row_input"><input name="ec_option_proxy_address"  id="ec_option_proxy_address" type="text" value="<?php echo stripslashes( get_option( 'ec_option_proxy_address' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>