<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "beanstream" ){ echo '_inactive'; } ?>" id="beanstream">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Beanstream Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_beanstream_merchant_id" id="ec_option_beanstream_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_beanstream_merchant_id' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Beanstream API Passcode:</span><span class="ec_payment_type_row_input"><input name="ec_option_beanstream_api_passcode" id="ec_option_beanstream_api_passcode" type="text" value="<?php echo stripslashes( get_option( 'ec_option_beanstream_api_passcode' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>