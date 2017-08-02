<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "nmi" ){ echo '_inactive'; } ?>" id="nmi">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Processing Method:</span><span class="ec_payment_type_row_input"><select name="ec_option_nmi_3ds" id="ec_option_nmi_3ds" onchange="wpeasycart_update_nmi_cardinal( );">
                        <option value="0" <?php if ( get_option( 'ec_option_nmi_3ds') == "0" ){ echo " selected=\"selected\""; } ?>>Use Standard Direct Post</option>
                        <option value="2" <?php if ( get_option( 'ec_option_nmi_3ds') == "2" ){ echo " selected=\"selected\""; } ?>>Use Cardinal Centinel with NMI</option>
                      </select></span></div>
    
    <div id="nmi_3ds_settings"<?php if( get_option( 'ec_option_nmi_3ds') != "2" ){?> style="display:none;"<?php }?>>
    
    	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">NMI API Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_api_key" id="ec_option_nmi_api_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_api_key' ) ); ?>" style="width:250px;" /></span></div>
    
    </div>
    
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">NMI Username:</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_username" id="ec_option_nmi_username" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_username' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">NMI Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_password" id="ec_option_nmi_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_password' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Your Shipping Postal:</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_ship_from_zip" id="ec_option_nmi_ship_from_zip" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_ship_from_zip' ) ); ?>" style="width:250px;" /></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">NMI Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_nmi_currency" id="ec_option_nmi_currency">
                        <option value="USD" <?php if ( get_option( 'ec_option_nmi_currency') == "USD" ){ echo " selected=\"selected\""; } ?>>USD</option>
                        <option value="CAD" <?php if ( get_option( 'ec_option_nmi_currency') == "CAD" ){ echo " selected=\"selected\""; } ?>>CAD</option>
                        <option value="EUR" <?php if ( get_option( 'ec_option_nmi_currency') == "EUR" ){ echo " selected=\"selected\""; } ?>>EUR</option>
                        <option value="GBP" <?php if ( get_option( 'ec_option_nmi_currency') == "GBP" ){ echo " selected=\"selected\""; } ?>>GBP</option>
                      </select></span></div>
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">NMI Processor ID (optional):</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_processor_id" id="ec_option_nmi_processor_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_processor_id' ) ); ?>" style="width:250px;" /></span></div>
	
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Summary Commodity Code:</span><span class="ec_payment_type_row_input"><input name="ec_option_nmi_commodity_code" id="ec_option_nmi_commodity_code" type="text" value="<?php echo stripslashes( get_option( 'ec_option_nmi_commodity_code' ) ); ?>" style="width:250px;" /></span></div>
	
    
	<div id="nmi_cardinal_settings"<?php if( get_option( 'ec_option_nmi_3ds') != "2" ){?> style="display:none;"<?php }?>>
    
        <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Cardinal Processor ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_cardinal_processor_id" id="ec_option_cardinal_processor_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_cardinal_processor_id' ) ); ?>" style="width:250px;" /></span></div>
        
        <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Cardinal Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_cardinal_merchant_id" id="ec_option_cardinal_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_cardinal_merchant_id' ) ); ?>" style="width:250px;" /></span></div>
        
        <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Cardinal Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_cardinal_password" id="ec_option_cardinal_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_cardinal_password' ) ); ?>" style="width:250px;" /></span></div>
        
        <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Cardinal Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_cardinal_currency" id="ec_option_cardinal_currency">
                            <option value="840" <?php if ( get_option( 'ec_option_cardinal_currency') == "840" ){ echo " selected=\"selected\""; } ?>>USD</option>
                            <option value="124" <?php if ( get_option( 'ec_option_cardinal_currency') == "124" ){ echo " selected=\"selected\""; } ?>>CAD</option>
                            <option value="978" <?php if ( get_option( 'ec_option_cardinal_currency') == "978" ){ echo " selected=\"selected\""; } ?>>EUR</option>
                            <option value="826" <?php if ( get_option( 'ec_option_cardinal_currency') == "826" ){ echo " selected=\"selected\""; } ?>>GBP</option>
                          </select></span></div>
                          
        <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Cardinal Test Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_cardinal_test_mode" id="ec_option_cardinal_test_mode">
                            <option value="0" <?php if ( get_option( 'ec_option_cardinal_test_mode') == "0" ){ echo " selected=\"selected\""; } ?>>No, Live Mode</option>
                            <option value="1" <?php if ( get_option( 'ec_option_cardinal_test_mode') == "1" ){ echo " selected=\"selected\""; } ?>>Yes, Test Mode</option>
                          </select></span></div>
                          
	</div>
    
</div>

<script>
function wpeasycart_update_nmi_cardinal( ){
	if( jQuery( document.getElementById( 'ec_option_nmi_3ds' ) ).val( ) == '2' ){ 
		jQuery( document.getElementById( 'nmi_cardinal_settings' ) ).show( ); 
	}else{ 
		jQuery( document.getElementById( 'nmi_cardinal_settings' ) ).hide( ); 
	}
	
	if( jQuery( document.getElementById( 'ec_option_nmi_3ds' ) ).val( ) == '2' ){ 
		jQuery( document.getElementById( 'nmi_3ds_settings' ) ).show( ); 
	}else{ 
		jQuery( document.getElementById( 'nmi_3ds_settings' ) ).hide( ); 
	}
}
</script>