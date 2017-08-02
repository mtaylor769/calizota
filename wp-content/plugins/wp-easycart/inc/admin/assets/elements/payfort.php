<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "payfort" ){ echo '_inactive'; } ?>" id="payfort">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Merchant Identifier:</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_merchant_id"  id="ec_option_payfort_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payfort_merchant_id' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Access Code:</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_access_code"  id="ec_option_payfort_access_code" type="text" value="<?php echo stripslashes( get_option('ec_option_payfort_access_code' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Encryption Type:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_sha_type" id="ec_option_payfort_sha_type">
                <option value="sha1" <?php if( get_option( 'ec_option_payfort_sha_type' ) == "sha1" ) echo ' selected'; ?>>SHA-128</option>
                <option value="sha256" <?php if( get_option( 'ec_option_payfort_sha_type' ) == "sha256" ) echo ' selected'; ?>>SHA-256</option>
                <option value="sha512" <?php if( get_option( 'ec_option_payfort_sha_type' ) == "sha512" ) echo ' selected'; ?>>SHA-512</option>
              </select>
        </span>
    </div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SHA Request Phrase:</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_request_phrase"  id="ec_option_payfort_request_phrase" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payfort_request_phrase' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">SHA Response Phrase:</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_response_phrase"  id="ec_option_payfort_response_phrase" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payfort_response_phrase' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Language:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_language" id="ec_option_payfort_language">
                <option value="en" <?php if( get_option( 'ec_option_payfort_language' ) == "en" ) echo ' selected'; ?>>English</option>
                <option value="ar" <?php if( get_option( 'ec_option_payfort_language' ) == "ar" ) echo ' selected'; ?>>Arabic</option>
              </select>
        </span>
    </div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Use Currency Exchange Service:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_use_currency_service" id="ec_option_payfort_use_currency_service">
                <option value="1" <?php if (get_option('ec_option_payfort_use_currency_service') == 1) echo ' selected'; ?>>Yes</option>
                <option value="0" <?php if (get_option('ec_option_payfort_use_currency_service') == 0) echo ' selected'; ?>>No</option>
              </select>
        </span>
    </div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Currency Code (e.g. USD):</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_currency_code"  id="ec_option_payfort_currency_code" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payfort_currency_code' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Allow Sadad Checkout Option:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_use_sadad" id="ec_option_payfort_use_sadad">
                <option value="1" <?php if (get_option('ec_option_payfort_use_sadad') == 1) echo ' selected'; ?>>Sadad On</option>
                <option value="0" <?php if (get_option('ec_option_payfort_use_sadad') == 0) echo ' selected'; ?>>Sadad Off</option>
              </select>
        </span>
    </div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Allow NAPS Checkout Option:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_use_naps" id="ec_option_payfort_use_naps">
                <option value="1" <?php if (get_option('ec_option_payfort_use_naps') == 1) echo ' selected'; ?>>NAPS On</option>
                <option value="0" <?php if (get_option('ec_option_payfort_use_naps') == 0) echo ' selected'; ?>>NAPS Off</option>
              </select>
        </span>
    </div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sadad Payment ID (optional Sadad only):</span><span class="ec_payment_type_row_input"><input name="ec_option_payfort_sadad_olp"  id="ec_option_payfort_sadad_olp" type="text" value="<?php echo stripslashes( get_option( 'ec_option_payfort_sadad_olp' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Test Mode:</span>
        <span class="ec_payment_type_row_input"><select name="ec_option_payfort_test_mode" id="ec_option_payfort_test_mode">
                <option value="1" <?php if (get_option('ec_option_payfort_test_mode') == 1) echo ' selected'; ?>>Test Mode</option>
                <option value="0" <?php if (get_option('ec_option_payfort_test_mode') == 0) echo ' selected'; ?>>Production Mode</option>
              </select>
        </span>
    </div>
    
</div>