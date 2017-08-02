<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "realex_thirdparty" ){ echo '_inactive'; } ?>" id="realex_thirdparty">
	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Merchant ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_realex_thirdparty_merchant_id"  id="ec_option_realex_thirdparty_merchant_id" type="text" value="<?php echo stripslashes( get_option('ec_option_realex_thirdparty_merchant_id' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Secret:</span><span class="ec_payment_type_row_input"><input name="ec_option_realex_thirdparty_secret"  id="ec_option_realex_thirdparty_secret" type="text" value="<?php echo stripslashes( get_option( 'ec_option_realex_thirdparty_secret' ) ); ?>" style="width:250px;" /></span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Realex Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_realex_thirdparty_currency" id="ec_option_realex_thirdparty_currency">
                        <option value="GBP" <?php if (get_option('ec_option_realex_thirdparty_currency') == "GBP") echo ' selected'; ?>>GBP</option>
                        <option value="EUR" <?php if (get_option('ec_option_realex_thirdparty_currency') == "EUR") echo ' selected'; ?>>EUR</option>
                        <option value="USD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "USD") echo ' selected'; ?>>USD</option>
                        <option value="DKK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "DKK") echo ' selected'; ?>>DKK</option>
                        <option value="NOK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "NOK") echo ' selected'; ?>>NOK</option>
                        <option value="CHF" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CHF") echo ' selected'; ?>>CHF</option>
                        <option value="AUD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "AUD") echo ' selected'; ?>>AUD</option>
                        <option value="CAD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CAD") echo ' selected'; ?>>CAD</option>
                        <option value="CZK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "CZK") echo ' selected'; ?>>CZK</option>
                        <option value="JPY" <?php if (get_option('ec_option_realex_thirdparty_currency') == "JPY") echo ' selected'; ?>>JPY</option>
                        <option value="NZD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "NZD") echo ' selected'; ?>>NZD</option>
                        <option value="HKD" <?php if (get_option('ec_option_realex_thirdparty_currency') == "HKD") echo ' selected'; ?>>HKD</option>
                        <option value="ZAR" <?php if (get_option('ec_option_realex_thirdparty_currency') == "ZAR") echo ' selected'; ?>>ZAR</option>
                        <option value="SEK" <?php if (get_option('ec_option_realex_thirdparty_currency') == "SEK") echo ' selected'; ?>>SEK</option>
                      </select></span></div>
    
    <div class="ec_payment_type_row"><strong>To Do:</strong> You must submit the following URLs to Realex before the redirect method can work completely. You should also add information to your account for your customers to see on the payment page, successful payment page, and the failed payment page.</div>
    
    <div class="ec_payment_type_row"><strong>Realex Referring URL:</strong> <?php $cart_page_id = get_option( 'ec_option_cartpage' ); $cart_page = get_permalink( $cart_page_id ); if( substr_count( $cart_page, '?' ) ){$permalink_divider = "&"; }else{ $permalink_divider = "?"; } echo $cart_page . $permalink_divider . "ec_page=realex_redirect"; ?></div>
    
    <div class="ec_payment_type_row"><strong>Realex Response URL:</strong> <?php echo $cart_page . $permalink_divider . "ec_page=realex_response"; ?></div>
</div>