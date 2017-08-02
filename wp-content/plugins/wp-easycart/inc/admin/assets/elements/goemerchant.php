<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "goemerchant" ){ echo '_inactive'; } ?>" id="goemerchant">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">GoeMerchant Transaction Center ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_goemerchant_trans_center_id"  id="ec_option_goemerchant_trans_center_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_goemerchant_trans_center_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">GoeMerchant Gateway ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_goemerchant_gateway_id"  id="ec_option_goemerchant_gateway_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_goemerchant_gateway_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">GoeMerchant Processor ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_goemerchant_processor_id"  id="ec_option_goemerchant_processor_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_goemerchant_processor_id' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>