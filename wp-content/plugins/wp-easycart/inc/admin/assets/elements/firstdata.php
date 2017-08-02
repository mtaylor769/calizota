<div class="ec_payment_type_holder<?php if( get_option( 'ec_option_payment_process_method' ) != "firstdata" ){ echo '_inactive'; } ?>" id="firstdata">

	<div class="ec_payment_type_row"><a href="http://v3docs.wpeasycart.com/3.0.0/settings/payment_information.php#firstdata" target="_blank">Gateway Setup Documentation</a></div>
    
    <div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Gateway ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_firstdatae4_exact_id"  id="ec_option_firstdatae4_exact_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_firstdatae4_exact_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Gateway Password:</span><span class="ec_payment_type_row_input"><input name="ec_option_firstdatae4_password"  id="ec_option_firstdatae4_password" type="text" value="<?php echo stripslashes( get_option( 'ec_option_firstdatae4_password' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Key ID:</span><span class="ec_payment_type_row_input"><input name="ec_option_firstdatae4_key_id"  id="ec_option_firstdatae4_key_id" type="text" value="<?php echo stripslashes( get_option( 'ec_option_firstdatae4_key_id' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Hmac Key:</span><span class="ec_payment_type_row_input"><input name="ec_option_firstdatae4_key"  id="ec_option_firstdatae4_key" type="text" value="<?php echo stripslashes( get_option( 'ec_option_firstdatae4_key' ) ); ?>" style="width:250px;" /></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Language:</span><span class="ec_payment_type_row_input"><select name="ec_option_firstdatae4_language" id="ec_option_firstdatae4_language">
                        <option value="EN" <?php if (get_option('ec_option_firstdatae4_language') == "EN") echo ' selected'; ?>>EN</option>
                        <option value="FR" <?php if (get_option('ec_option_firstdatae4_language') == "FR") echo ' selected'; ?>>FR</option>
                        <option value="ES" <?php if (get_option('ec_option_firstdatae4_language') == "ES") echo ' selected'; ?>>ES</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Currency:</span><span class="ec_payment_type_row_input"><select name="ec_option_firstdatae4_currency" id="ec_option_firstdatae4_currency">
                        <option value="USD" <?php if (get_option('ec_option_firstdatae4_currency') == "USD") echo ' selected'; ?>>U.S. Dollar</option>
                        <option value="CAD" <?php if (get_option('ec_option_firstdatae4_currency') == "CAD") echo ' selected'; ?>>Canadian Dollar</option>
                        <option value="DEM" <?php if (get_option('ec_option_firstdatae4_currency') == "DEM") echo ' selected'; ?>>German Mark</option>
                        <option value="CHF" <?php if (get_option('ec_option_firstdatae4_currency') == "CHF") echo ' selected'; ?>>Swiss Franc</option>
                        <option value="GBP" <?php if (get_option('ec_option_firstdatae4_currency') == "GBP") echo ' selected'; ?>>British Pound</option>
                        <option value="JPY" <?php if (get_option('ec_option_firstdatae4_currency') == "JPY") echo ' selected'; ?>>Japanese Yen</option>
                        <option value="AFA" <?php if (get_option('ec_option_firstdatae4_currency') == "AFA") echo ' selected'; ?>>Afghanistan Afghani</option>
                        <option value="ALL" <?php if (get_option('ec_option_firstdatae4_currency') == "ALL") echo ' selected'; ?>>Albanian Lek</option>
                        <option value="DZD" <?php if (get_option('ec_option_firstdatae4_currency') == "DZD") echo ' selected'; ?>>Algerian Dinar</option>
                        <option value="ADF" <?php if (get_option('ec_option_firstdatae4_currency') == "ADF") echo ' selected'; ?>>Andorran Franc</option>
                        <option value="ADP" <?php if (get_option('ec_option_firstdatae4_currency') == "ADP") echo ' selected'; ?>>Andorran Peseta</option>
                        <option value="AON" <?php if (get_option('ec_option_firstdatae4_currency') == "AON") echo ' selected'; ?>>Angolan New Kwanza</option>
                        <option value="ARS" <?php if (get_option('ec_option_firstdatae4_currency') == "ARS") echo ' selected'; ?>>Argentine Peso</option>
                        <option value="AWG" <?php if (get_option('ec_option_firstdatae4_currency') == "AWG") echo ' selected'; ?>>Aruban Florin</option>
                        <option value="AUD" <?php if (get_option('ec_option_firstdatae4_currency') == "AUD") echo ' selected'; ?>>Australian Dollar</option>
                        <option value="ATS" <?php if (get_option('ec_option_firstdatae4_currency') == "ATS") echo ' selected'; ?>>Austrian Schilling</option>
                        <option value="BSD" <?php if (get_option('ec_option_firstdatae4_currency') == "BSD") echo ' selected'; ?>>Bahamanian Dollar</option>
                        <option value="BHD" <?php if (get_option('ec_option_firstdatae4_currency') == "BHD") echo ' selected'; ?>>Bahraini Dinar</option>
                        <option value="BDT" <?php if (get_option('ec_option_firstdatae4_currency') == "BDT") echo ' selected'; ?>>Bangladeshi Taka</option>
                        <option value="BBD" <?php if (get_option('ec_option_firstdatae4_currency') == "BBD") echo ' selected'; ?>>Barbados Dollar</option>
                        <option value="BEF" <?php if (get_option('ec_option_firstdatae4_currency') == "BEF") echo ' selected'; ?>>Belgian Franc</option>
                        <option value="BZD" <?php if (get_option('ec_option_firstdatae4_currency') == "BZD") echo ' selected'; ?>>Belize Dollar</option>
                        <option value="BMD" <?php if (get_option('ec_option_firstdatae4_currency') == "BMD") echo ' selected'; ?>>Bermudian Dollar</option>
                        <option value="BTN" <?php if (get_option('ec_option_firstdatae4_currency') == "BTN") echo ' selected'; ?>>Bhutan Ngultrum</option>
                        <option value="BOB" <?php if (get_option('ec_option_firstdatae4_currency') == "BOB") echo ' selected'; ?>>Bolivian Boliviano</option>
                        <option value="BWP" <?php if (get_option('ec_option_firstdatae4_currency') == "BWP") echo ' selected'; ?>>Botswana Pula</option>
                        <option value="BRL" <?php if (get_option('ec_option_firstdatae4_currency') == "BRL") echo ' selected'; ?>>Brazilian Real</option>
                        <option value="BND" <?php if (get_option('ec_option_firstdatae4_currency') == "BND") echo ' selected'; ?>>Brunei Dollar</option>
                        <option value="BGL" <?php if (get_option('ec_option_firstdatae4_currency') == "BGL") echo ' selected'; ?>>Bulgarian Lev</option>
                        <option value="BIF" <?php if (get_option('ec_option_firstdatae4_currency') == "BIF") echo ' selected'; ?>>Burundi Franc</option>
                        <option value="XOF" <?php if (get_option('ec_option_firstdatae4_currency') == "XOF") echo ' selected'; ?>>CFA Franc BCEAO</option>
                        <option value="XAF" <?php if (get_option('ec_option_firstdatae4_currency') == "XAF") echo ' selected'; ?>>CFA Franc BEAC</option>
                        <option value="KHR" <?php if (get_option('ec_option_firstdatae4_currency') == "KHR") echo ' selected'; ?>>Cambodian Riel</option>
                        <option value="CVE" <?php if (get_option('ec_option_firstdatae4_currency') == "CVE") echo ' selected'; ?>>Cape Verde Escudo</option>
                        <option value="KYD" <?php if (get_option('ec_option_firstdatae4_currency') == "KYD") echo ' selected'; ?>>Cayman Islands Dollar</option>
                        <option value="CLP" <?php if (get_option('ec_option_firstdatae4_currency') == "CLP") echo ' selected'; ?>>Chilean Peso</option>
                        <option value="CNY" <?php if (get_option('ec_option_firstdatae4_currency') == "CNY") echo ' selected'; ?>>Chinese Yuan Renminbi</option>
                        <option value="COP" <?php if (get_option('ec_option_firstdatae4_currency') == "COP") echo ' selected'; ?>>Colombian Peso</option>
                        <option value="KMF" <?php if (get_option('ec_option_firstdatae4_currency') == "KMF") echo ' selected'; ?>>Comoros Franc</option>
                        <option value="CRC" <?php if (get_option('ec_option_firstdatae4_currency') == "CRC") echo ' selected'; ?>>Costa Rican Colon</option>
                        <option value="HRK" <?php if (get_option('ec_option_firstdatae4_currency') == "HRK") echo ' selected'; ?>>Croatian Kuna</option>
                        <option value="CYP" <?php if (get_option('ec_option_firstdatae4_currency') == "CYP") echo ' selected'; ?>>Cyprus Pound</option>
                        <option value="CSK" <?php if (get_option('ec_option_firstdatae4_currency') == "CSK") echo ' selected'; ?>>Czech Koruna</option>
                        <option value="DKK" <?php if (get_option('ec_option_firstdatae4_currency') == "DKK") echo ' selected'; ?>>Danish Krone</option>
                        <option value="DJF" <?php if (get_option('ec_option_firstdatae4_currency') == "DJF") echo ' selected'; ?>>Djibouti Franc</option>
                        <option value="DOP" <?php if (get_option('ec_option_firstdatae4_currency') == "DOP") echo ' selected'; ?>>Dominican Peso</option>
                        <option value="NLG" <?php if (get_option('ec_option_firstdatae4_currency') == "NLG") echo ' selected'; ?>>Dutch Guilder</option>
                        <option value="XEU" <?php if (get_option('ec_option_firstdatae4_currency') == "XEU") echo ' selected'; ?>>ECU</option>
                        <option value="ECS" <?php if (get_option('ec_option_firstdatae4_currency') == "ECE") echo ' selected'; ?>>Ecuador Sucre</option>
                        <option value="EGP" <?php if (get_option('ec_option_firstdatae4_currency') == "EGP") echo ' selected'; ?>>Egyptian Pound</option>
                        <option value="SVC" <?php if (get_option('ec_option_firstdatae4_currency') == "SVC") echo ' selected'; ?>>El Salvador Colon</option>
                        <option value="EEK" <?php if (get_option('ec_option_firstdatae4_currency') == "EEK") echo ' selected'; ?>>Estonian Kroon</option>
                        <option value="ETB" <?php if (get_option('ec_option_firstdatae4_currency') == "ETB") echo ' selected'; ?>>Ethiopian Birr</option>
                        <option value="EUR" <?php if (get_option('ec_option_firstdatae4_currency') == "EUR") echo ' selected'; ?>>Euro</option>
                        <option value="FKP" <?php if (get_option('ec_option_firstdatae4_currency') == "FKP") echo ' selected'; ?>>Falkland Islands Pound</option>
                        <option value="FJD" <?php if (get_option('ec_option_firstdatae4_currency') == "FJD") echo ' selected'; ?>>Fiji Dollar</option>
                        <option value="FIM" <?php if (get_option('ec_option_firstdatae4_currency') == "FTM") echo ' selected'; ?>>Finnish Markka</option>
                        <option value="FRF" <?php if (get_option('ec_option_firstdatae4_currency') == "FRF") echo ' selected'; ?>>French Franc</option>
                        <option value="GMD" <?php if (get_option('ec_option_firstdatae4_currency') == "GMD") echo ' selected'; ?>>Gambian Dalasi</option>
                        <option value="GHC" <?php if (get_option('ec_option_firstdatae4_currency') == "GHC") echo ' selected'; ?>>Ghanaian Cedi</option>
                        <option value="GIP" <?php if (get_option('ec_option_firstdatae4_currency') == "GIP") echo ' selected'; ?>>Gibraltar Pound</option>
                        <option value="XAU" <?php if (get_option('ec_option_firstdatae4_currency') == "XAU") echo ' selected'; ?>>Gold (oz.)</option>
                        <option value="GRD" <?php if (get_option('ec_option_firstdatae4_currency') == "GRD") echo ' selected'; ?>>Greek Drachma</option>
                        <option value="GTQ" <?php if (get_option('ec_option_firstdatae4_currency') == "GTQ") echo ' selected'; ?>>Guatemalan Quetzal</option>
                        <option value="GNF" <?php if (get_option('ec_option_firstdatae4_currency') == "GNF") echo ' selected'; ?>>Guinea Franc</option>
                        <option value="GYD" <?php if (get_option('ec_option_firstdatae4_currency') == "GYD") echo ' selected'; ?>>Guyanan Dollar</option>
                        <option value="HTG" <?php if (get_option('ec_option_firstdatae4_currency') == "HTG") echo ' selected'; ?>>Haitian Gourde</option>
                        <option value="HNL" <?php if (get_option('ec_option_firstdatae4_currency') == "HNL") echo ' selected'; ?>>Honduran Lempira</option>
                        <option value="HKD" <?php if (get_option('ec_option_firstdatae4_currency') == "HKD") echo ' selected'; ?>>Hong Kong Dollar</option>
                        <option value="HUF" <?php if (get_option('ec_option_firstdatae4_currency') == "HUF") echo ' selected'; ?>>Hungarian Forint</option>
                        <option value="ISK" <?php if (get_option('ec_option_firstdatae4_currency') == "ISK") echo ' selected'; ?>>Iceland Krona</option>
                        <option value="INR" <?php if (get_option('ec_option_firstdatae4_currency') == "INR") echo ' selected'; ?>>Indian Rupee</option>
                        <option value="IDR" <?php if (get_option('ec_option_firstdatae4_currency') == "IDR") echo ' selected'; ?>>Indonesian Rupiah</option>
                        <option value="IEP" <?php if (get_option('ec_option_firstdatae4_currency') == "IEP") echo ' selected'; ?>>Irish Punt</option>
                        <option value="ILS" <?php if (get_option('ec_option_firstdatae4_currency') == "ILS") echo ' selected'; ?>>Israeli New Shekel</option>
                        <option value="ITL" <?php if (get_option('ec_option_firstdatae4_currency') == "ITL") echo ' selected'; ?>>Italian Lira</option>
                        <option value="JMD" <?php if (get_option('ec_option_firstdatae4_currency') == "JMD") echo ' selected'; ?>>Jamaican Dollar</option>
                        <option value="JOD" <?php if (get_option('ec_option_firstdatae4_currency') == "JOD") echo ' selected'; ?>>Jordanian Dinar</option>
                        <option value="KZT" <?php if (get_option('ec_option_firstdatae4_currency') == "KZT") echo ' selected'; ?>>Kazakhstan Tenge</option>
                        <option value="KES" <?php if (get_option('ec_option_firstdatae4_currency') == "KES") echo ' selected'; ?>>Kenyan Shilling</option>
                        <option value="KWD" <?php if (get_option('ec_option_firstdatae4_currency') == "KWD") echo ' selected'; ?>>Kuwaiti Dinar</option>
                        <option value="LAK" <?php if (get_option('ec_option_firstdatae4_currency') == "LAK") echo ' selected'; ?>>Lao Kip</option>
                        <option value="LVL" <?php if (get_option('ec_option_firstdatae4_currency') == "LVL") echo ' selected'; ?>>Latvian Lats</option>
                        <option value="LSL" <?php if (get_option('ec_option_firstdatae4_currency') == "LSL") echo ' selected'; ?>>Lesotho Loti</option>
                        <option value="LRD" <?php if (get_option('ec_option_firstdatae4_currency') == "LRD") echo ' selected'; ?>>Liberian Dollar</option>
                        <option value="LTL" <?php if (get_option('ec_option_firstdatae4_currency') == "LTL") echo ' selected'; ?>>Lithuanian Litas</option>
                        <option value="LUF" <?php if (get_option('ec_option_firstdatae4_currency') == "LUF") echo ' selected'; ?>>Luxembourg Franc</option>
                        <option value="MOP" <?php if (get_option('ec_option_firstdatae4_currency') == "MOP") echo ' selected'; ?>>Macau Pataca</option>
                        <option value="MGF" <?php if (get_option('ec_option_firstdatae4_currency') == "MGF") echo ' selected'; ?>>Malagasy Franc</option>
                        <option value="MWK" <?php if (get_option('ec_option_firstdatae4_currency') == "MWK") echo ' selected'; ?>>Malawi Kwacha</option>
                        <option value="MYR" <?php if (get_option('ec_option_firstdatae4_currency') == "MYR") echo ' selected'; ?>>Malaysian Ringgit</option>
                        <option value="MVR" <?php if (get_option('ec_option_firstdatae4_currency') == "MVR") echo ' selected'; ?>>Maldive Rufiyaa</option>
                        <option value="MTL" <?php if (get_option('ec_option_firstdatae4_currency') == "MRL") echo ' selected'; ?>>Maltese Lira</option>
                        <option value="MRO" <?php if (get_option('ec_option_firstdatae4_currency') == "MRO") echo ' selected'; ?>>Mauritanian Ouguiya</option>
                        <option value="MUR" <?php if (get_option('ec_option_firstdatae4_currency') == "MUR") echo ' selected'; ?>>Mauritius Rupee</option>
                        <option value="MXN" <?php if (get_option('ec_option_firstdatae4_currency') == "MXN") echo ' selected'; ?>>Mexican Peso</option>
                        <option value="MNT" <?php if (get_option('ec_option_firstdatae4_currency') == "MNT") echo ' selected'; ?>>Mongolian Tugrik</option>
                        <option value="MAD" <?php if (get_option('ec_option_firstdatae4_currency') == "MAD") echo ' selected'; ?>>Moroccan Dirham</option>
                        <option value="MZM" <?php if (get_option('ec_option_firstdatae4_currency') == "MZM") echo ' selected'; ?>>Mozambique Metical</option>
                        <option value="MMK" <?php if (get_option('ec_option_firstdatae4_currency') == "MMK") echo ' selected'; ?>>Myanmar Kyat</option>
                        <option value="ANG" <?php if (get_option('ec_option_firstdatae4_currency') == "ANG") echo ' selected'; ?>>NL Antillian Guilder</option>
                        <option value="NAD" <?php if (get_option('ec_option_firstdatae4_currency') == "NAD") echo ' selected'; ?>>Namibia Dollar</option>
                        <option value="NPR" <?php if (get_option('ec_option_firstdatae4_currency') == "NPR") echo ' selected'; ?>>Nepalese Rupee</option>
                        <option value="NZD" <?php if (get_option('ec_option_firstdatae4_currency') == "NZD") echo ' selected'; ?>>New Zealand Dollar</option>
                        <option value="NIO" <?php if (get_option('ec_option_firstdatae4_currency') == "NIO") echo ' selected'; ?>>Nicaraguan Cordoba Oro</option>
                        <option value="NGN" <?php if (get_option('ec_option_firstdatae4_currency') == "NGN") echo ' selected'; ?>>Nigerian Naira</option>
                        <option value="NOK" <?php if (get_option('ec_option_firstdatae4_currency') == "NOK") echo ' selected'; ?>>Norwegian Kroner</option>
                        <option value="OMR" <?php if (get_option('ec_option_firstdatae4_currency') == "OMR") echo ' selected'; ?>>Omani Rial</option>
                        <option value="PKR" <?php if (get_option('ec_option_firstdatae4_currency') == "PKR") echo ' selected'; ?>>Pakistan Rupee</option>
                        <option value="XPD" <?php if (get_option('ec_option_firstdatae4_currency') == "XPD") echo ' selected'; ?>>Palladium (oz.)</option>
                        <option value="PAB" <?php if (get_option('ec_option_firstdatae4_currency') == "PAB") echo ' selected'; ?>>Panamanian Balboa</option>
                        <option value="PGK" <?php if (get_option('ec_option_firstdatae4_currency') == "PGK") echo ' selected'; ?>>Papua New Guinea Kina</option>
                        <option value="PYG" <?php if (get_option('ec_option_firstdatae4_currency') == "PYG") echo ' selected'; ?>>Paraguay Guarani</option>
                        <option value="PEN" <?php if (get_option('ec_option_firstdatae4_currency') == "PEN") echo ' selected'; ?>>Peruvian Nuevo Sol</option>
                        <option value="PHP" <?php if (get_option('ec_option_firstdatae4_currency') == "PHP") echo ' selected'; ?>>Philippine Peso</option>
                        <option value="XPT" <?php if (get_option('ec_option_firstdatae4_currency') == "XPT") echo ' selected'; ?>>Platinum (oz.)</option>
                        <option value="PLN" <?php if (get_option('ec_option_firstdatae4_currency') == "PLN") echo ' selected'; ?>>Polish Zloty</option>
                        <option value="PTE" <?php if (get_option('ec_option_firstdatae4_currency') == "PTE") echo ' selected'; ?>>Portuguese Escudo</option>
                        <option value="QAR" <?php if (get_option('ec_option_firstdatae4_currency') == "QAR") echo ' selected'; ?>>Qatari Rial</option>
                        <option value="ROL" <?php if (get_option('ec_option_firstdatae4_currency') == "ROL") echo ' selected'; ?>>Romanian Leu</option>
                        <option value="RUB" <?php if (get_option('ec_option_firstdatae4_currency') == "RUB") echo ' selected'; ?>>Russian Rouble</option>
                        <option value="WST" <?php if (get_option('ec_option_firstdatae4_currency') == "WST") echo ' selected'; ?>>Samoan Tala</option>
                        <option value="STD" <?php if (get_option('ec_option_firstdatae4_currency') == "STD") echo ' selected'; ?>>Sao Tome/Principe Dobra</option>
                        <option value="SAR" <?php if (get_option('ec_option_firstdatae4_currency') == "SAR") echo ' selected'; ?>>Saudi Riyal</option>
                        <option value="SCR" <?php if (get_option('ec_option_firstdatae4_currency') == "SCR") echo ' selected'; ?>>Seychelles Rupee</option>
                        <option value="SLL" <?php if (get_option('ec_option_firstdatae4_currency') == "SLL") echo ' selected'; ?>>Sierra Leone Leone</option>
                        <option value="XAG" <?php if (get_option('ec_option_firstdatae4_currency') == "XAG") echo ' selected'; ?>>Silver (oz.)</option>
                        <option value="SGD" <?php if (get_option('ec_option_firstdatae4_currency') == "SGD") echo ' selected'; ?>>Singapore Dollar</option>
                        <option value="SKK" <?php if (get_option('ec_option_firstdatae4_currency') == "SKK") echo ' selected'; ?>>Slovak Koruna</option>
                        <option value="SIT" <?php if (get_option('ec_option_firstdatae4_currency') == "SIT") echo ' selected'; ?>>Slovenian Tolar</option>
                        <option value="SBD" <?php if (get_option('ec_option_firstdatae4_currency') == "SBD") echo ' selected'; ?>>Solomon Islands Dollar</option>
                        <option value="ZAR" <?php if (get_option('ec_option_firstdatae4_currency') == "ZAR") echo ' selected'; ?>>South African Rand</option>
                        <option value="KRW" <?php if (get_option('ec_option_firstdatae4_currency') == "KRW") echo ' selected'; ?>>South-Korean Won</option>
                        <option value="ESP" <?php if (get_option('ec_option_firstdatae4_currency') == "ESP") echo ' selected'; ?>>Spanish Peseta</option>
                        <option value="LKR" <?php if (get_option('ec_option_firstdatae4_currency') == "LKR") echo ' selected'; ?>>Sri Lanka Rupee</option>
                        <option value="SHP" <?php if (get_option('ec_option_firstdatae4_currency') == "SHP") echo ' selected'; ?>>St. Helena Pound</option>
                        <option value="SRG" <?php if (get_option('ec_option_firstdatae4_currency') == "SRG") echo ' selected'; ?>>Suriname Guilder</option>
                        <option value="SZL" <?php if (get_option('ec_option_firstdatae4_currency') == "SZL") echo ' selected'; ?>>Swaziland Lilangeni</option>
                        <option value="SEK" <?php if (get_option('ec_option_firstdatae4_currency') == "SEK") echo ' selected'; ?>>Swedish Krona</option>
                        <option value="TWD" <?php if (get_option('ec_option_firstdatae4_currency') == "TWS") echo ' selected'; ?>>Taiwan Dollar</option>
                        <option value="TZS" <?php if (get_option('ec_option_firstdatae4_currency') == "TZS") echo ' selected'; ?>>Tanzanian Shilling</option>
                        <option value="THB" <?php if (get_option('ec_option_firstdatae4_currency') == "THB") echo ' selected'; ?>>Thai Baht</option>
                        <option value="TOP" <?php if (get_option('ec_option_firstdatae4_currency') == "TOP") echo ' selected'; ?>>Tonga Pa'anga</option>
                        <option value="TTD" <?php if (get_option('ec_option_firstdatae4_currency') == "TTD") echo ' selected'; ?>>Trinidad/Tobago Dollar</option>
                        <option value="TND" <?php if (get_option('ec_option_firstdatae4_currency') == "TND") echo ' selected'; ?>>Tunisian Dinar</option>
                        <option value="TRL" <?php if (get_option('ec_option_firstdatae4_currency') == "TRL") echo ' selected'; ?>>Turkish Lira</option>
                        <option value="UGS" <?php if (get_option('ec_option_firstdatae4_currency') == "UGS") echo ' selected'; ?>>Uganda Shilling</option>
                        <option value="UAH" <?php if (get_option('ec_option_firstdatae4_currency') == "UAH") echo ' selected'; ?>>Ukraine Hryvnia</option>
                        <option value="UYP" <?php if (get_option('ec_option_firstdatae4_currency') == "UYP") echo ' selected'; ?>>Uruguayan Peso</option>
                        <option value="AED" <?php if (get_option('ec_option_firstdatae4_currency') == "AED") echo ' selected'; ?>>Utd. Arab Emir. Dirham</option>
                        <option value="VUV" <?php if (get_option('ec_option_firstdatae4_currency') == "VUV") echo ' selected'; ?>>Vanuatu Vatu</option>
                        <option value="VEB" <?php if (get_option('ec_option_firstdatae4_currency') == "VEB") echo ' selected'; ?>>Venezuelan Bolivar</option>
                        <option value="VND" <?php if (get_option('ec_option_firstdatae4_currency') == "VND") echo ' selected'; ?>>Vietnamese Dong</option>
                        <option value="YUN" <?php if (get_option('ec_option_firstdatae4_currency') == "YUN") echo ' selected'; ?>>Yugoslav Dinar</option>
                        <option value="ZMK" <?php if (get_option('ec_option_firstdatae4_currency') == "ZMK") echo ' selected'; ?>>Zambian Kwacha</option>
                      </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Test/Demo Mode:</span><span class="ec_payment_type_row_input"><select name="ec_option_firstdatae4_test_mode" id="ec_option_firstdatae4_test_mode">
                        <option value="1" <?php if (get_option('ec_option_firstdatae4_test_mode') == 1) echo ' selected'; ?>>Yes</option>
                        <option value="0" <?php if (get_option('ec_option_firstdatae4_test_mode') == 0) echo ' selected'; ?>>No</option>
                      </select></span></div>
	    
</div>