<div class="ec_payment_type_holder">
	
    <h3>Affirm - Pay over time, on your terms</h3>
    <p>WP EasyCart is proud to now offer Affirm as a payment option for all customers. Affirm provides flexible financing for your customers at the time of checkout, enabling increased sales and conversion. Your customers will be instantly approved for a loan with Affirm during checkout and will use it as their form of payment. They can pay off their balance in easy monthly payments with a low interest rate. Affirm assumes all credit risk and will settle full payment with you right away. You will need an Affirm account to use this on your site. For more information and to sign up for an Affirm account, please visit <a href="https://www.affirm.com/merchants/ " target="_blank">https://www.Affirm.com/merchants/</a></p>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Offer Affirm During Checkout:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_affirm" id="ec_option_use_affirm">
                        <option value="1" <?php if (get_option('ec_option_use_affirm') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_use_affirm') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Affirm Public Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_affirm_public_key" id="ec_option_affirm_public_key" type="text" value="<?php echo stripslashes( get_option('ec_option_affirm_public_key' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Affirm Private Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_affirm_private_key" id="ec_option_affirm_private_key" type="text" value="<?php echo stripslashes( get_option('ec_option_affirm_private_key' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Affirm Financial Product:</span><span class="ec_payment_type_row_input"><input name="ec_option_affirm_financial_product" id="ec_option_affirm_financial_product" type="text" value="<?php echo stripslashes( get_option( 'ec_option_affirm_financial_product' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Use Sandbox Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_affirm_sandbox_account" id="ec_option_affirm_sandbox_account">
                        <option value="1" <?php if (get_option('ec_option_affirm_sandbox_account') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_affirm_sandbox_account') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>