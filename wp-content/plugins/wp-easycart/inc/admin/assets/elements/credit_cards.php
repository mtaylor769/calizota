<div class="ec_payment_type_holder" id="ec_credit_cards_section">
	<div class="ec_adin_page_intro">Please notice, not all credit cards are available for all payment gateways and/or all accounts. Please check your payment gateway account or payment gateway company to find what credit cards you can accept. In addition, this section only applies to the "Live Payment Gateway" option.</div>
    
	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Visa:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_visa" id="ec_option_use_visa" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_visa') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_visa') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Visa Debit/Delta:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_delta" id="ec_option_use_delta" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_delta') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_delta') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Visa Electron:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_uke" id="ec_option_use_uke" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_uke') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_uke') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Discover:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_discover" id="ec_option_use_discover" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_discover') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_discover') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept MasterCard:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_mastercard" id="ec_option_use_mastercard" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_mastercard') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_mastercard') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept MasterCard Debit:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_mcdebit" id="ec_option_use_mcdebit" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_mcdebit') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_mcdebit') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept American Express:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_amex" id="ec_option_use_amex" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_amex') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_amex') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept JCB:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_jcb" id="ec_option_use_jcb" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_jcb') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_jcb') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Diners:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_diners" id="ec_option_use_diners" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_diners') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_diners') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Laser:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_laser" id="ec_option_use_laser" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_laser') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_laser') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>

	<div class="ec_payment_type_row"><span class="ec_payment_type_row_label">Accept Maestro:</span><span class="ec_payment_type_row_input"><select name="ec_option_use_maestro" id="ec_option_use_maestro" onchange="toggle_live_cards();">
    <option value="1" <?php if (get_option('ec_option_use_maestro') == 1) echo ' selected'; ?>>Yes</option>
    <option value="0" <?php if (get_option('ec_option_use_maestro') == 0) echo ' selected'; ?>>No</option>
  </select></span></div>
</div>