<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "square" ){ echo '_inactive'; } ?>" id="square">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Application ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_square_application_id" id="ec_option_square_application_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_square_application_id' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Personal Access Token:</span><span class="ec_payment_type_row_input"><input name="ec_option_square_access_token" id="ec_option_square_access_token" type="text" value="<?php echo stripslashes( get_option( 'ec_option_square_access_token' ) ); ?>" style="width:250px;" /></span></div>
    
</div>