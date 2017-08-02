<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "virtualmerchant" ){ echo '_inactive'; } ?>" id="virtualmerchant">

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Converge ID (ssl_merchant_id):</span><span class="ec_payment_type_row_input"><input name="ec_option_virtualmerchant_ssl_merchant_id" id="ec_option_virtualmerchant_ssl_merchant_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_virtualmerchant_ssl_merchant_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Converge User ID (ssl_user_id):</span><span class="ec_payment_type_row_input"><input name="ec_option_virtualmerchant_ssl_user_id" id="ec_option_virtualmerchant_ssl_user_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_virtualmerchant_ssl_user_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Converge PIN (ssl_pin):</span><span class="ec_payment_type_row_input"><input name="ec_option_virtualmerchant_ssl_pin" id="ec_option_virtualmerchant_ssl_pin" type="text" value="<?php echo stripslashes( get_option( 'ec_option_virtualmerchant_ssl_pin' ) ); ?>" style="width:250px;" /></span></div>
    
    <?php /* Virtual Merchant tends to prefer you to setup your currency in your account, not from the programming level.
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Currency Type:</span><span class="ec_payment_type_row_input"><select name="ec_option_virtualmerchant_currency" id="ec_option_virtualmerchant_currency">
                        <option value="USD" <?php if (get_option('ec_option_virtualmerchant_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_virtualmerchant_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="GBP" <?php if (get_option('ec_option_virtualmerchant_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                        
                        <option value="DZD" <?php if (get_option('ec_option_virtualmerchant_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                        <option value="ARS" <?php if (get_option('ec_option_virtualmerchant_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                        <option value="AWG" <?php if (get_option('ec_option_virtualmerchant_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                        <option value="AUS" <?php if (get_option('ec_option_virtualmerchant_currency') == "AUS") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="AZN" <?php if (get_option('ec_option_virtualmerchant_currency') == "AZN") echo ' selected'; ?>>Azerbaijani an Manat</option>
                        
                        <option value="BSD" <?php if (get_option('ec_option_virtualmerchant_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                        <option value="BHD" <?php if (get_option('ec_option_virtualmerchant_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                        <option value="BDT" <?php if (get_option('ec_option_virtualmerchant_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                        <option value="BBD" <?php if (get_option('ec_option_virtualmerchant_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                        <option value="BMD" <?php if (get_option('ec_option_virtualmerchant_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                        <option value="BWP" <?php if (get_option('ec_option_virtualmerchant_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                        <option value="BRL" <?php if (get_option('ec_option_virtualmerchant_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                        <option value="BGN" <?php if (get_option('ec_option_virtualmerchant_currency') == "BGN") echo ' selected'; ?>>Bulgarian Lev</option>
                        
                        <option value="CLP" <?php if (get_option('ec_option_virtualmerchant_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                        <option value="CNY" <?php if (get_option('ec_option_virtualmerchant_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                        <option value="COP" <?php if (get_option('ec_option_virtualmerchant_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                        <option value="CDF" <?php if (get_option('ec_option_virtualmerchant_currency') == "CDF") echo ' selected'; ?>>Congolese Franc</option>
                        <option value="CRC" <?php if (get_option('ec_option_virtualmerchant_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                        <option value="HRK" <?php if (get_option('ec_option_virtualmerchant_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="CZK" <?php if (get_option('ec_option_virtualmerchant_currency') == "CZK") echo ' selected'; ?>>Czech Koruna</option>
                        
                        <option value="DKK" <?php if (get_option('ec_option_virtualmerchant_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="DOP" <?php if (get_option('ec_option_virtualmerchant_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                        
                        <option value="XCD" <?php if (get_option('ec_option_virtualmerchant_currency') == "XCD") echo ' selected'; ?>>East Caribbean Dollar</option>
                        <option value="EGP" <?php if (get_option('ec_option_virtualmerchant_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                        <option value="EEK" <?php if (get_option('ec_option_virtualmerchant_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="ETB" <?php if (get_option('ec_option_virtualmerchant_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                        <option value="EUR" <?php if (get_option('ec_option_virtualmerchant_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        
                        <option value="FJD" <?php if (get_option('ec_option_virtualmerchant_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        <option value="XPF" <?php if (get_option('ec_option_virtualmerchant_currency') == "XPF") echo ' selected'; ?>>Fr. Polynesia Franc</option>
                        
                        <option value="XAF" <?php if (get_option('ec_option_virtualmerchant_currency') == "XAF") echo ' selected'; ?>>Gabon Franc</option>
                        <option value="GTQ" <?php if (get_option('ec_option_virtualmerchant_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                        
                        <option value="HTG" <?php if (get_option('ec_option_virtualmerchant_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                        <option value="HKD" <?php if (get_option('ec_option_virtualmerchant_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_virtualmerchant_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        
                        <option value="ISK" <?php if (get_option('ec_option_virtualmerchant_currency') == "ISK") echo ' selected'; ?>>Icelandic Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_virtualmerchant_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="IDR" <?php if (get_option('ec_option_virtualmerchant_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                        <option value="IRR" <?php if (get_option('ec_option_virtualmerchant_currency') == "IRR") echo ' selected'; ?>>Iranian Rial</option>
                        <option value="ILS" <?php if (get_option('ec_option_virtualmerchant_currency') == "ILS") echo ' selected'; ?>>Israeli Shekel</option>
                        <option value="XOF" <?php if (get_option('ec_option_virtualmerchant_currency') == "XOF") echo ' selected'; ?>>Ivory Coast Franc</option>
                        
                        <option value="JMD" <?php if (get_option('ec_option_virtualmerchant_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                        <option value="JPY" <?php if (get_option('ec_option_virtualmerchant_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="JOD" <?php if (get_option('ec_option_virtualmerchant_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        
                        <option value="KZT" <?php if (get_option('ec_option_virtualmerchant_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                        <option value="KES" <?php if (get_option('ec_option_virtualmerchant_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                        <option value="KWD" <?php if (get_option('ec_option_virtualmerchant_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        
                        <option value="LVL" <?php if (get_option('ec_option_virtualmerchant_currency') == "LVL") echo ' selected'; ?>>Latvian Lats</option>
                        <option value="LBP" <?php if (get_option('ec_option_virtualmerchant_currency') == "LBP") echo ' selected'; ?>>Lebanese Pound</option>
                        <option value="LYD" <?php if (get_option('ec_option_virtualmerchant_currency') == "LYD") echo ' selected'; ?>>Libyan Dinar</option>
                        <option value="LTL" <?php if (get_option('ec_option_virtualmerchant_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        
                        <option value="MKD" <?php if (get_option('ec_option_virtualmerchant_currency') == "MKD") echo ' selected'; ?>>Macedonian Denar</option>
                        <option value="MWK" <?php if (get_option('ec_option_virtualmerchant_currency') == "MWK") echo ' selected'; ?>>Malawian Kwacha</option>
                        <option value="MYR" <?php if (get_option('ec_option_virtualmerchant_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MUR" <?php if (get_option('ec_option_virtualmerchant_currency') == "MUR") echo ' selected'; ?>>Mauritian Rupee</option>
                        <option value="MXN" <?php if (get_option('ec_option_virtualmerchant_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                        <option value="MAD" <?php if (get_option('ec_option_virtualmerchant_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        
                        <option value="NAD" <?php if (get_option('ec_option_virtualmerchant_currency') == "NAD") echo ' selected'; ?>>Namibian Dollar</option>
                        <option value="NPR" <?php if (get_option('ec_option_virtualmerchant_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                        <option value="ANG" <?php if (get_option('ec_option_virtualmerchant_currency') == "ANG") echo ' selected'; ?>>Netherlands Antillean Guilder</option>
                        <option value="TWD" <?php if (get_option('ec_option_virtualmerchant_currency') == "TWD") echo ' selected'; ?>>New Taiwan Dollar</option>
                        <option value="TRY" <?php if (get_option('ec_option_virtualmerchant_currency') == "TRY") echo ' selected'; ?>>New Turkish Lira</option>
                        <option value="NZD" <?php if (get_option('ec_option_virtualmerchant_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="NGN" <?php if (get_option('ec_option_virtualmerchant_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                        <option value="NOK" <?php if (get_option('ec_option_virtualmerchant_currency') == "NOK") echo ' selected'; ?>>Norwegian Krone</option>
                        
                        <option value="OMR" <?php if (get_option('ec_option_virtualmerchant_currency') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                        
                        <option value="PKR" <?php if (get_option('ec_option_virtualmerchant_currency') == "PKR") echo ' selected'; ?>>Pakistani Rupee</option>
                        <option value="PEN" <?php if (get_option('ec_option_virtualmerchant_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                        <option value="PHP" <?php if (get_option('ec_option_virtualmerchant_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                        <option value="PLN" <?php if (get_option('ec_option_virtualmerchant_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        
                        <option value="QAR" <?php if (get_option('ec_option_virtualmerchant_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        
                        <option value="RON" <?php if (get_option('ec_option_virtualmerchant_currency') == "RON") echo ' selected'; ?>>Romanian New Leu</option>
                        <option value="RUB" <?php if (get_option('ec_option_virtualmerchant_currency') == "RUB") echo ' selected'; ?>>Russian Ruble</option>
                        
                        <option value="SAR" <?php if (get_option('ec_option_virtualmerchant_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="RSD" <?php if (get_option('ec_option_virtualmerchant_currency') == "RSD") echo ' selected'; ?>>Serbian Dinar</option>
                        <option value="SGD" <?php if (get_option('ec_option_virtualmerchant_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="ZAR" <?php if (get_option('ec_option_virtualmerchant_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                        <option value="KRW" <?php if (get_option('ec_option_virtualmerchant_currency') == "KRW") echo ' selected'; ?>>South Korean Won</option>
                        <option value="LKR" <?php if (get_option('ec_option_virtualmerchant_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                        <option value="SEK" <?php if (get_option('ec_option_virtualmerchant_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="CHF" <?php if (get_option('ec_option_virtualmerchant_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="SYP" <?php if (get_option('ec_option_virtualmerchant_currency') == "SYP") echo ' selected'; ?>>Syrian Pound</option>
                        
                        <option value="THB" <?php if (get_option('ec_option_virtualmerchant_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="TTD" <?php if (get_option('ec_option_virtualmerchant_currency') == "TTD") echo ' selected'; ?>>Trinidad and Tobago Dollar</option>
                        <option value="TND" <?php if (get_option('ec_option_virtualmerchant_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                        
                        <option value="UAH" <?php if (get_option('ec_option_virtualmerchant_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                        <option value="AED" <?php if (get_option('ec_option_virtualmerchant_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        
                        <option value="VEF" <?php if (get_option('ec_option_virtualmerchant_currency') == "VEF") echo ' selected'; ?>>Venezuelan Bolivar Fuerte</option>
                        <option value="VND" <?php if (get_option('ec_option_virtualmerchant_currency') == "VND") echo ' selected'; ?>>Vietnamese Kong</option>
                        
                        <option value="ZMK" <?php if (get_option('ec_option_virtualmerchant_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                        <option value="ZWL" <?php if (get_option('ec_option_virtualmerchant_currency') == "ZWL") echo ' selected'; ?>>Zimbabwean Dollar</option>
                      </select></span></div>
	*/ ?>
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Demo Account:</span><span class="ec_payment_type_row_input"><select name="ec_option_virtualmerchant_demo_account" id="ec_option_virtualmerchant_demo_account">
                        <option value="1" <?php if (get_option('ec_option_virtualmerchant_demo_account') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_virtualmerchant_demo_account') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>