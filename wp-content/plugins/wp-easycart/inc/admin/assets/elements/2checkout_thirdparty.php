<?php
$cart_page_id = get_option('ec_option_cartpage');

if( function_exists( 'icl_object_id' ) ){
	$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
}

$cart_page = get_permalink( $cart_page_id );

if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
	$https_class = new WordPressHTTPS( );
	$cart_page = $https_class->makeUrlHttps( $cart_page );
}

if( substr_count( $cart_page, '?' ) )						$permalink_divider = "&";
else														$permalink_divider = "?";
?>

<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_third_party' ) != "2checkout_thirdparty" ){ echo '_inactive'; } ?>" id="2checkout_thirdparty">
	
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Account Number:</span><span class="ec_payment_type_row_input">
    	<input name="ec_option_2checkout_thirdparty_sid" type="text" value="<?php echo stripslashes( get_option( 'ec_option_2checkout_thirdparty_sid' ) ); ?>" style="width:250px;" />
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Secret Word:</span><span class="ec_payment_type_row_input">
    	<input name="ec_option_2checkout_thirdparty_secret_word" type="text" value="<?php echo stripslashes( get_option( 'ec_option_2checkout_thirdparty_secret_word' ) ); ?>" style="width:250px;" />
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Currency Code:</span><span class="ec_payment_type_row_input">
    	<select name="ec_option_2checkout_thirdparty_currency_code" id="ec_option_2checkout_thirdparty_currency_code">
            <option value="USD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'USD') echo ' selected'; ?>>U.S. Dollar</option>
            <option value="AFN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'AFN') echo ' selected'; ?>>Afghani</option>
            <option value="ALL" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'ALL') echo ' selected'; ?>>Lek</option>
            <option value="DZD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'DZD') echo ' selected'; ?>>Algerian Dinar</option>
            <option value="ARS" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'ARS') echo ' selected'; ?>>Argentine Peso</option>
            <option value="AUD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'AUD') echo ' selected'; ?>>Australian Dollar</option>
            <option value="AZN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'AZN') echo ' selected'; ?>>Azerbaijan Manat</option>
            <option value="BSD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BSD') echo ' selected'; ?>>Bahamian Dollar</option>
            <option value="BDT" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BDT') echo ' selected'; ?>>Taka</option>
            <option value="BBD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BBD') echo ' selected'; ?>>Barbados Dollar</option>
            <option value="BZD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BZD') echo ' selected'; ?>>Belize Dollar</option>
            <option value="BMD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BMD') echo ' selected'; ?>>Bermudian Dollar</option>
            <option value="BOB" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BOB') echo ' selected'; ?>>Boliviano</option>
            <option value="BWP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BWP') echo ' selected'; ?>>Pula</option>
            <option value="BRL" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BRL') echo ' selected'; ?>>Brazilian Real</option>
            <option value="GBP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'GBP') echo ' selected'; ?>>Pound Sterling</option>
            <option value="BND" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BND') echo ' selected'; ?>>Brunei Dollar</option>
            <option value="BGN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'BGN') echo ' selected'; ?>>Bulgarian Lev</option>
            <option value="CAD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CAD') echo ' selected'; ?>>Canadian Dollar</option>
            <option value="CLP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CLP') echo ' selected'; ?>>Chilean Peso</option>
            <option value="CNY" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CNY') echo ' selected'; ?>>Renminbi (Yuan)</option>
            <option value="COP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'COP') echo ' selected'; ?>>Colombian Peso</option>
            <option value="CRC" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CRC') echo ' selected'; ?>>Costa Rican Colón</option>
            <option value="HRK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'HRK') echo ' selected'; ?>>Croatian Kuna</option>
            <option value="CZK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CZK') echo ' selected'; ?>>Czech Koruna</option>
            <option value="DKK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'DKK') echo ' selected'; ?>>Danish Krone</option>
            <option value="DOP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'DOP') echo ' selected'; ?>>Dominican Peso</option>
            <option value="XCD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'XCD') echo ' selected'; ?>>East Caribbean Dollar</option>
            <option value="EGP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'EGP') echo ' selected'; ?>>Egyptian Pound</option>
            <option value="EUR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'EUR') echo ' selected'; ?>>Euro</option>
            <option value="FJD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'FJD') echo ' selected'; ?>>Fiji Dollar</option>
            <option value="GTQ" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'GTQ') echo ' selected'; ?>>Quetzal</option>
            <option value="HKD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'HKD') echo ' selected'; ?>>Hong Kong Dollar</option>
            <option value="HNL" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'HNL') echo ' selected'; ?>>Lempira</option>
            <option value="HUF" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'HUF') echo ' selected'; ?>>Hungarian Forint</option>
            <option value="INR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'INR') echo ' selected'; ?>>Indian Rupee</option>
            <option value="IDR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'IDR') echo ' selected'; ?>>Rupiah</option>
            <option value="ILS" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'ILS') echo ' selected'; ?>>Israeli New Sheqel</option>
            <option value="JMD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'JMD') echo ' selected'; ?>>Jamaican Dollar</option>
            <option value="JPY" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'JPY') echo ' selected'; ?>>Japanese Yen</option>
            <option value="KZT" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'KZT') echo ' selected'; ?>>Tenge</option>
            <option value="KES" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'KES') echo ' selected'; ?>>Kenyan Shilling</option>
            <option value="LAK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'LAK') echo ' selected'; ?>>Kip</option>
            <option value="MMK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MMK') echo ' selected'; ?>>Kyat</option>
            <option value="LBP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'LBP') echo ' selected'; ?>>Lebanese Pound</option>
            <option value="LRD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'LRD') echo ' selected'; ?>>Liberian Dollar</option>
            <option value="MOP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MOP') echo ' selected'; ?>>Macanese Pataca</option>
            <option value="MYR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MYR') echo ' selected'; ?>>Malaysian Ringgit</option>
            <option value="MVR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MVR') echo ' selected'; ?>>Rufiyaa</option>
            <option value="MRO" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MRO') echo ' selected'; ?>>Ouguiya</option>
            <option value="MUR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MUR') echo ' selected'; ?>>Mauritius Rupee</option>
            <option value="MXN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MXN') echo ' selected'; ?>>Mexican Peso</option>
            <option value="MAD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'MAD') echo ' selected'; ?>>Moroccan Dirham</option>
            <option value="NPR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'NPR') echo ' selected'; ?>>Nepalese Rupee</option>
            <option value="TWD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'TWD') echo ' selected'; ?>>New Taiwan Dollar</option>
            <option value="NZD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'NZD') echo ' selected'; ?>>New Zealand Dollar</option>
            <option value="NIO" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'NIO') echo ' selected'; ?>>Cordoba Oro</option>
            <option value="NOK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'NOK') echo ' selected'; ?>>Norwegian Krone</option>
            <option value="PKR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'PKR') echo ' selected'; ?>>Pakistan Rupee</option>
            <option value="PGK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'PGK') echo ' selected'; ?>>Kina</option>
            <option value="PEN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'PEN') echo ' selected'; ?>>Nuevo Sol</option>
            <option value="PHP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'PHP') echo ' selected'; ?>>Philippine Peso</option>
            <option value="PLN" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'PLN') echo ' selected'; ?>>Polish Zloty</option>
            <option value="QAR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'QAR') echo ' selected'; ?>>Qatari Rial</option>
            <option value="RON" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'RON') echo ' selected'; ?>>RON</option>
            <option value="RUB" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'RUB') echo ' selected'; ?>>Russian Ruble</option>
            <option value="WST" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'WST') echo ' selected'; ?>>Tala</option>
            <option value="SAR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SAR') echo ' selected'; ?>>Saudi Riyal</option>
            <option value="SCR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SCR') echo ' selected'; ?>>Seychelles Rupee</option>
            <option value="SGD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SGD') echo ' selected'; ?>>Singapore Dollar</option>
            <option value="SBD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SBD') echo ' selected'; ?>>Solomon Islands Dollar</option>
            <option value="ZAR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'ZAR') echo ' selected'; ?>>Rand</option>
            <option value="KRW" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'KRW') echo ' selected'; ?>>Won</option>
            <option value="LKR" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'LKR') echo ' selected'; ?>>Sri Lanka Rupee</option>
            <option value="SEK" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SEK') echo ' selected'; ?>>Swedish Krona</option>
            <option value="CHF" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'CHF') echo ' selected'; ?>>Swiss Franc</option>
            <option value="SYP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'SYP') echo ' selected'; ?>>Syrian Pound</option>
            <option value="THB" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'THB') echo ' selected'; ?>>Thai Baht</option>
            <option value="TOP" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'TOP') echo ' selected'; ?>>Paʻanga</option>
            <option value="TTD" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'TTD') echo ' selected'; ?>>Trinidad and Tobago Dollar</option>
            <option value="TRY" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'TRY') echo ' selected'; ?>>Turkish Lira</option>
        	<option value="UAH" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'UAH') echo ' selected'; ?>>Hryvnia</option>
            <option value="AED" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'AED') echo ' selected'; ?>>UAE Dirham</option>
            <option value="VUV" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'VUV') echo ' selected'; ?>>Vatu</option>
            <option value="VND" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'VND') echo ' selected'; ?>>Vietnamese Dong</option>
            <option value="XOF" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'XOF') echo ' selected'; ?>>CFA Franc BCEAO</option>
            <option value="YER" <?php if( get_option( 'ec_option_2checkout_thirdparty_currency_code') == 'YER') echo ' selected'; ?>>Yemeni Rial</option>
        </select>
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Language:</span><span class="ec_payment_type_row_input">
    	<select name="ec_option_2checkout_thirdparty_lang" id="ec_option_2checkout_thirdparty_lang">
            <option value="zh" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'zh') echo ' selected'; ?>>Chinese</option>
            <option value="da" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'da') echo ' selected'; ?>>Danish</option>
            <option value="nl" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'nl') echo ' selected'; ?>>Dutch</option>
            <option value="en" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'en') echo ' selected'; ?>>Englsh</option>
            <option value="fr" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'fr') echo ' selected'; ?>>French</option>
            <option value="gr" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'gr') echo ' selected'; ?>>German</option>
            <option value="el" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'el') echo ' selected'; ?>>Greek</option>
            <option value="it" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'it') echo ' selected'; ?>>Italian</option>
            <option value="jp" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'jp') echo ' selected'; ?>>Japanese</option>
            <option value="no" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'no') echo ' selected'; ?>>Norwegian</option>
            <option value="pt" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'pt') echo ' selected'; ?>>Portugese</option>
            <option value="sl" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'sl') echo ' selected'; ?>>Slovenian</option>
            <option value="es" <?php if( get_option( 'ec_option_2checkout_thirdparty_lang') == 'es') echo ' selected'; ?>>Spanish</option>
        </select>
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Checkout Purchase Step:</span><span class="ec_payment_type_row_input">
    	<select name="ec_option_2checkout_thirdparty_purchase_step" id="ec_option_2checkout_thirdparty_purchase_step">
        	<option value="review-cart" <?php if( get_option('ec_option_2checkout_thirdparty_purchase_step' ) == 'review-cart' ) echo ' selected'; ?>>Review Cart</option>
        	<option value="shipping-information" <?php if( get_option('ec_option_2checkout_thirdparty_purchase_step' ) == 'shipping-information' ) echo ' selected'; ?>>Shipping Information</option>
        	<option value="billing-information" <?php if( get_option('ec_option_2checkout_thirdparty_purchase_step' ) == 'billing-information' ) echo ' selected'; ?>>Billing Information</option>
        	<option value="payment-method" <?php if( get_option('ec_option_2checkout_thirdparty_purchase_step' ) == 'payment-method' ) echo ' selected'; ?>>Payment Method</option>
       	</select>
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Sandbox Account:</span><span class="ec_payment_type_row_input">
    	<select name="ec_option_2checkout_thirdparty_sandbox_mode" id="ec_option_2checkout_thirdparty_sandbox_mode">
        	<option value="1" <?php if( get_option('ec_option_2checkout_thirdparty_sandbox_mode' ) == 1 ) echo ' selected'; ?>>Yes</option>
        	<option value="0" <?php if( get_option('ec_option_2checkout_thirdparty_sandbox_mode' ) == 0 ) echo ' selected'; ?>>No</option>
       	</select>
    </span></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Demo Mode:</span><span class="ec_payment_type_row_input">
    	<select name="ec_option_2checkout_thirdparty_demo_mode" id="ec_option_2checkout_thirdparty_demo_mode">
        	<option value="1" <?php if( get_option('ec_option_2checkout_thirdparty_demo_mode' ) == 1 ) echo ' selected'; ?>>Yes</option>
        	<option value="0" <?php if( get_option('ec_option_2checkout_thirdparty_demo_mode' ) == 0 ) echo ' selected'; ?>>No</option>
       	</select>
    </span></div>
    
    <div class="ec_payment_type_row">
    	<br /><br />
    	<strong>To complete setup you must complete the following steps:</strong>
        <ol>
        	<li>Go to your Account Settings -> Site Management and setup the Direct Return option shown in the image below.
    			<br /><br />
            	<img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/2checkout-setup.jpg' ); ?>" />
            </li>
            <li>Go to your Account Settings -> Site Management and enter the Approved URL with: <?php echo site_url( ); ?>.</li>
            <li>Click the Notifications icon in the top right corner of your account, just left of the help and account icons.
            	<br /><br />
                <img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/2checkout-notifications.jpg' ); ?>" />
            	<br /><br />
                Then enter your site URL in all of the URL boxes and check the enable box for all of the notification options. The URL to enter is: <?php echo site_url( ); ?>.
            	<br /><br />
                <img src="<?php echo plugins_url( 'wp-easycart/inc/admin/assets/images/2checkout-notification-url.jpg' ); ?>" />
            	<br /><br />
            </li>
        </ol>
        <br /><br />
    </div>
    
</div>