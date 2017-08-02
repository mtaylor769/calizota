<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "eway" ){ echo '_inactive'; } ?>" id="eway">
	
    <div id="eway_api_info"><p><strong>eWay Rapid API Setup: Copy your API key and API password from your eWay account, My Account Tab and sub category API Key. Generate a password here and copy and paste it into the box provided.</strong></p></div>
    
	<div class="ec_payment_type_row">
    	<span class="ec_payment_type_row_label">Payment Method:</span>
    	<span class="ec_payment_type_row_input">
    		<select name="ec_option_eway_use_rapid_pay" id="ec_option_eway_use_rapid_pay" onchange="ec_eway_payment_type_change( );">
				<option value="1" <?php if (get_option('ec_option_eway_use_rapid_pay') == 1) echo ' selected'; ?>>Rapid Pay</option>
				<option value="0" <?php if (get_option('ec_option_eway_use_rapid_pay') == 0) echo ' selected'; ?>>Direct Payment (outdated)</option>
			</select>
		</span>
    </div>

    <div class="ec_payment_type_row" id="eway_customer_id">
    	<span class="ec_payment_type_row_label">Customer ID:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_eway_customer_id"  id="ec_option_eway_customer_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_eway_customer_id' ) ); ?>" style="width:250px;" />
		</span>
    </div>

    <div class="ec_payment_type_row" id="eway_api_key">
    	<span class="ec_payment_type_row_label">API Key:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_eway_api_key"  id="ec_option_eway_api_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_eway_api_key' ) ); ?>" style="width:250px;" />
		</span>
    </div>

    <div class="ec_payment_type_row" id="eway_api_password">
    	<span class="ec_payment_type_row_label">API Password:</span>
        <span class="ec_payment_type_row_input">
        	<input name="ec_option_eway_api_password"  id="ec_option_eway_api_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_eway_api_password' ) ); ?>" style="width:250px;" />
		</span>
    </div>

    <div class="ec_payment_type_row" id="eway_client_key">
    	<span class="ec_payment_type_row_label">Client Key:</span>
        <span class="ec_payment_type_row_input">
        	<textarea name="ec_option_eway_client_key"  id="ec_option_eway_client_key" style="width:550px; height:125px"><?php echo stripslashes( get_option( 'ec_option_eway_client_key' ) ); ?></textarea>
		</span>
    </div>

	<div class="ec_payment_type_row">
    	<span class="ec_payment_type_row_label">Sandbox Mode:</span>
        <span class="ec_payment_type_row_input">
        	<select name="ec_option_eway_test_mode" id="ec_option_eway_test_mode">
                <option value="1" <?php if (get_option('ec_option_eway_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_eway_test_mode') == 0) echo ' selected'; ?>>No</option>
			</select>
        </span>
    </div>

	<div class="ec_payment_type_row" id="eway_process_transaction">
    	<span class="ec_payment_type_row_label">Eway Test Mode Process Successful Transaction:</span>
        <span class="ec_payment_type_row_input">
        	<select name="ec_option_eway_test_mode_success" id="ec_option_eway_test_mode_success">
                <option value="1" <?php if (get_option('ec_option_eway_test_mode_success') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_eway_test_mode_success') == 0) echo ' selected'; ?>>No</option>
			</select>
        </span>
    </div>
	    
</div>
<script>
function ec_eway_payment_type_change( ){
	if( jQuery( document.getElementById( 'ec_option_eway_use_rapid_pay' ) ).val( ) == "1" ){
		jQuery( document.getElementById( 'eway_api_info' ) ).show( );
		jQuery( document.getElementById( 'eway_customer_id' ) ).hide( );
		jQuery( document.getElementById( 'eway_process_transaction' ) ).hide( );
		jQuery( document.getElementById( 'eway_api_key' ) ).show( );
		jQuery( document.getElementById( 'eway_api_password' ) ).show( );
		jQuery( document.getElementById( 'eway_client_key' ) ).show( );
	}else{
		jQuery( document.getElementById( 'eway_api_info' ) ).hide( );
		jQuery( document.getElementById( 'eway_customer_id' ) ).show( );
		jQuery( document.getElementById( 'eway_process_transaction' ) ).show( );
		jQuery( document.getElementById( 'eway_api_key' ) ).hide( );
		jQuery( document.getElementById( 'eway_api_password' ) ).hide( );
		jQuery( document.getElementById( 'eway_client_key' ) ).hide( );
	}
}
ec_eway_payment_type_change( );
</script>