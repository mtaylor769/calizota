<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "sagepayus" ){ echo '_inactive'; } ?>" id="sagepayus">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay US ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_sagepayus_mid" id="ec_option_sagepayus_mid" type="text" value="<?php echo stripslashes( get_option( 'ec_option_sagepayus_mid' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay US Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_sagepayus_mkey" id="ec_option_sagepayus_mkey" type="text" value="<?php echo stripslashes( get_option('ec_option_sagepayus_mkey' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sagepay US Application ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_sagepayus_application_id" id="ec_option_sagepayus_application_id" type="text" value="<?php echo stripslashes( get_option('ec_option_sagepayus_application_id' ) ); ?>" style="width:250px;" /></span></div>
	    
</div>