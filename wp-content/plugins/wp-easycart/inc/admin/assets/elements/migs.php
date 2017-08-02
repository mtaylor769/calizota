<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "migs" ){ echo '_inactive'; } ?>" id="migs">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Secure Secret (Signature):</span><span class="ec_payment_type_row_input"><input name="ec_option_migs_signature" id="ec_option_migs_signature" type="text" value="<?php echo stripslashes( get_option( 'ec_option_migs_signature' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Access Code:</span><span class="ec_payment_type_row_input"><input name="ec_option_migs_access_code" id="ec_option_migs_access_code" type="text" value="<?php echo stripslashes( get_option( 'ec_option_migs_access_code' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_migs_merchant_id" id="ec_option_migs_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_migs_merchant_id' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>