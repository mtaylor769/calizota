<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "sagepay_paynow_za" ){ echo '_inactive'; } ?>" id="sagepay_paynow_za">
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Service Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_sagepay_paynow_za_service_key" id="ec_option_sagepay_paynow_za_service_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_sagepay_paynow_za_service_key' ) ); ?>" style="width:250px;" /></span></div>
    
</div>