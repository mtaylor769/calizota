<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "chronopay" ){ echo '_inactive'; } ?>" id="chronopay">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Chronopay Currency:</span><span class="ec_payment_type_row_input"><input name="ec_option_chronopay_currency"  id="ec_option_chronopay_currency"  type="text" value="<?php echo stripslashes( get_option( 'ec_option_chronopay_currency' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Chronopay Product ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_chronopay_product_id"  id="ec_option_chronopay_product_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_chronopay_product_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Chronopay Shared Secret:</span><span class="ec_payment_type_row_input"><input name="ec_option_chronopay_shared_secret"  id="ec_option_chronopay_shared_secret" type="text" value="<?php echo stripslashes( get_option( 'ec_option_chronopay_shared_secret' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>