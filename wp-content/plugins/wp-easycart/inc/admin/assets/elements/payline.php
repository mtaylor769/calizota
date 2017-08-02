<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "payline" ){ echo '_inactive'; } ?>" id="payline">

	<div class="ec_payment_type_row">
    	<span class="ec_payment_type_row_label">User Name:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_payline_username" id="ec_option_payline_username" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payline_username' ) ); ?>" style="width:250px;" />
        </span>
    </div>
	
    <div class="ec_payment_type_row">
    	<span class="ec_payment_type_row_label">Password:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_payline_password" id="ec_option_payline_password" type="password" value="<?php echo stripslashes( get_option( 'ec_option_payline_password' ) ); ?>" style="width:250px;" />
        </span>
    </div>
	
    <div class="ec_payment_type_row">
    	<span class="ec_payment_type_row_label">Currency Code:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_payline_currency" id="ec_option_payline_currency" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payline_currency' ) ); ?>" style="width:250px;" />
        </span>
    </div>
	    
</div>