<?php
class ec_paypal extends ec_third_party{
	
	public function display_form_start( ){
		$paypal_use_sandbox = get_option( 'ec_option_paypal_use_sandbox' );
		$paypal_email = get_option( 'ec_option_paypal_email' );
		$paypal_currency_code = get_option( 'ec_option_paypal_currency_code' );
		$paypal_charset = get_option( 'ec_option_paypal_charset' );
		$paypal_lc = get_option( 'ec_option_paypal_lc' );
		$paypal_weight_unit = get_option( 'ec_option_paypal_weight_unit' );
		
		//this is actionscript version in flash
		if( $paypal_use_sandbox )			$paypal_request = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else								$paypal_request = "https://www.paypal.com/cgi-bin/webscr";
		
		$tax = new ec_tax( 0.00, 0.00, 0.00, $this->order->billing_state, $this->order->billing_country );
		$tax_total = number_format( $this->order->tax_total + $this->order->duty_total + $this->order->gst_total + $this->order->pst_total + $this->order->hst_total, 2 );
		if( !$tax->vat_included )
			$tax_total = number_format( $tax_total + $this->order->vat_total, 2 );
		
		echo "<form action=\"" . $paypal_request . "\" method=\"post\">";
		echo "<input name=\"cmd\" id=\"cmd\" type=\"hidden\" value=\"_cart\" />";
		echo "<input name=\"upload\" id=\"upload\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"" . $this->order_id . "\" />";
		echo "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourDevelopmentLLC_Cart\" />";
		echo "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $paypal_email ) . "\" />";
		if( get_option( 'ec_option_paypal_use_selected_currency' ) ){
			$selected_currency = $paypal_currency_code;
			if( isset( $_COOKIE['ec_convert_to'] ) ){
				$selected_currency = $_COOKIE['ec_convert_to'];
			}
			echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $selected_currency . "\" />";
			if( $this->order->discount_total < $this->order->sub_total ){
				echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->shipping_total ) . "\" />";
			}
			echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->discount_total ) . "\" />";
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $tax_total ) . "\" />";
			echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->sub_total ) . "\" />";
		}else{
			echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $paypal_currency_code . "\" />";
			if( $this->order->discount_total < $this->order->sub_total ){
				echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . number_format($this->order->shipping_total, 2, '.', '') . "\" />";
			}
			echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . number_format($this->order->discount_total, 2, '.', '') . "\" />";
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . $tax_total . "\" />";
			echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . number_format($this->order->sub_total, 2, '.', '') . "\" />";
		}
		echo "<input name=\"weight_cart\" id=\"weight_cart\" type=\"hidden\" value=\"" . $this->order->order_weight . "\" />";
		echo "<input name=\"weight_unit\" id=\"weight_unit\" type=\"hidden\" value=\"" . $paypal_weight_unit . "\" />";
		if( get_option( 'ec_option_paypal_collect_shipping' ) ){
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"2\" />";
		}else{
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"1\" />";
		}
		echo "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"" . $paypal_lc . "\" />";
		echo "<input name=\"charset\" id=\"charset\" type=\"hidden\" value=\"" . $paypal_charset . "\" />";
		echo "<input name=\"rm\" id=\"rm\" type=\"hidden\" value=\"2\" />";
		echo "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ) ."\" />";
		echo "<input type=\"hidden\" name=\"return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order_id . "\" />";
		echo "<input type=\"hidden\" name=\"cancel_return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" />";
		
		//customer billing information and address info
		if( get_option( 'ec_option_paypal_send_shipping_address' ) ){
			echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_first_name, ENT_QUOTES ) . "\" />";	
			echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_last_name, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_address_line_1, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address2\" id=\"address2\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_address_line_2, ENT_QUOTES ) . "\" />";
			echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_city, ENT_QUOTES ) . "\" />";
			echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . htmlspecialchars( strtoupper($this->order->shipping_state ), ENT_QUOTES ) . "\" />";
			echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_zip, ENT_QUOTES ) . "\" />";
			echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_country, ENT_QUOTES ) . "\" />";
			echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->user_email, ENT_QUOTES ) . "\" />";
		}else{
			echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_first_name, ENT_QUOTES ) . "\" />";	
			echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_last_name, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_address_line_1, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address2\" id=\"address12\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_address_line_2, ENT_QUOTES ) . "\" />";
			echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_city, ENT_QUOTES ) . "\" />";
			echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . htmlspecialchars( strtoupper($this->order->billing_state ), ENT_QUOTES ) . "\" />";
			echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_zip, ENT_QUOTES ) . "\" />";
			echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_country, ENT_QUOTES ) . "\" />";
			echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->user_email, ENT_QUOTES ) . "\" />";
		}
		//add the cart contents to paypal
		for( $i = 0; $i<count( $this->order_details ); $i++ ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order_details[$i]->title ) . "\" />";
			echo "<input name=\"item_number_" . $paypal_counter . "\" id=\"item_number_" . $paypal_counter . "\" type=\"hidden\" value=\"" . substr( str_replace( '"', '&quot;', $this->order_details[$i]->model_number ), 0, 127 ) . "\" />";
			if( get_option( 'ec_option_paypal_use_selected_currency' ) ){

				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price(  ( $this->order_details[$i]->total_price/$this->order_details[$i]->quantity ) ) . "\" />";
			}else{
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format( ( $this->order_details[$i]->total_price/$this->order_details[$i]->quantity ), 2, '.', '' ) . "\" />";
			}
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $this->order_details[$i]->quantity . "\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
		if( $this->order->discount_total >= $this->order->sub_total ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' ) ) . "\" />";
			echo "<input name=\"item_number_" . $paypal_counter . "\" id=\"item_number_" . $paypal_counter . "\" type=\"hidden\" value=\"" . substr( str_replace( '"', '&quot;', strtolower( $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' ) ) ), 0, 127 ) . "\" />";
			if( get_option( 'ec_option_paypal_use_selected_currency' ) ){
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->shipping_total ) . "\" />";
			}else{
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format( $this->order->shipping_total, 2, '.', '' ) . "\" />";
			}
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"1\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
		
	}
	
	public function display_auto_forwarding_form( ){
		$paypal_use_sandbox = get_option( 'ec_option_paypal_use_sandbox' );
		$paypal_email = get_option( 'ec_option_paypal_email' );
		$paypal_currency_code = get_option( 'ec_option_paypal_currency_code' );
		$paypal_charset = get_option( 'ec_option_paypal_charset' );
		$paypal_lc = get_option( 'ec_option_paypal_lc' );
		$paypal_weight_unit = get_option( 'ec_option_paypal_weight_unit' );
		
		//this is actionscript version in flash
		if( $paypal_use_sandbox )			$paypal_request = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else								$paypal_request = "https://www.paypal.com/cgi-bin/webscr";
		
		$tax = new ec_tax( 0.00, 0.00, 0.00, $this->order->billing_state, $this->order->billing_country );
		$tax_total = number_format( $this->order->tax_total + $this->order->duty_total + $this->order->gst_total + $this->order->pst_total + $this->order->hst_total, 2 );
		if( !$tax->vat_included )
			$tax_total = number_format( $tax_total + $this->order->vat_total, 2 );
		
		echo "<style>
		.ec_third_party_submit_button{ width:100%; text-align:center; }
		.ec_third_party_submit_button > input{ margin-top:150px; width:300px; height:45px; background-color:#38E; color:#FFF; font-weight:bold; text-transform:uppercase; border:1px solid #A2C0D8; cursor:pointer; }
		.ec_third_party_submit_button > input:hover{ background-color:#7A99BF; }
		.ec_third_party_loader{ display:block !important; position:absolute; top:50%; left:50%; }
		@-webkit-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);

			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@-moz-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@-o-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		/* Styles for old versions of IE */
		.ec_third_party_loader {
		  font-family: sans-serif;
		  font-weight: 100;
		}
		
		/* :not(:required) hides this rule from IE9 and below */
		.ec_third_party_loader:not(:required) {
		  -webkit-animation: ec_third_party_loader 1250ms infinite linear;
		  -moz-animation: ec_third_party_loader 1250ms infinite linear;
		  -ms-animation: ec_third_party_loader 1250ms infinite linear;
		  -o-animation: ec_third_party_loader 1250ms infinite linear;
		  animation: ec_third_party_loader 1250ms infinite linear;
		  border: 8px solid #3388ee;
		  border-right-color: transparent;
		  border-radius: 16px;
		  box-sizing: border-box;
		  display: inline-block;
		  position: relative;
		  overflow: hidden;
		  text-indent: -9999px;
		  width: 32px;
		  height: 32px;
		}
		</style>";
		
		echo "<div style=\"display:none;\" class=\"ec_third_party_loader\">Loading...</div>";
		
		echo "<form name=\"ec_paypal_standard_auto_form\" action=\"" . $paypal_request . "\" method=\"post\">";
		echo "<input name=\"cmd\" id=\"cmd\" type=\"hidden\" value=\"_cart\" />";
		echo "<input name=\"upload\" id=\"upload\" type=\"hidden\" value=\"1\" />";
		echo "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"" . $this->order_id . "\" />";
		echo "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourDevelopmentLLC_Cart\" />";
		echo "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $paypal_email ) . "\" />";
		if( get_option( 'ec_option_paypal_use_selected_currency' ) ){
			$selected_currency = $paypal_currency_code;
			if( isset( $_COOKIE['ec_convert_to'] ) ){
				$selected_currency = $_COOKIE['ec_convert_to'];
			}
			echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $selected_currency . "\" />";
			if( $this->order->discount_total < $this->order->sub_total ){
				echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->shipping_total ) . "\" />";
			}
			echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->discount_total ) . "\" />";
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $tax_total ) . "\" />";
			echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->sub_total ) . "\" />";
		}else{
			echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $paypal_currency_code . "\" />";
			if( $this->order->discount_total < $this->order->sub_total ){
				echo "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"" . number_format($this->order->shipping_total, 2, '.', '') . "\" />";
			}
			echo "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"" . number_format($this->order->discount_total, 2, '.', '') . "\" />";
			echo "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"" . $tax_total . "\" />";
			echo "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"" . number_format($this->order->sub_total, 2, '.', '') . "\" />";
		}
		echo "<input name=\"weight_cart\" id=\"weight_cart\" type=\"hidden\" value=\"" . $this->order->order_weight . "\" />";
		echo "<input name=\"weight_unit\" id=\"weight_unit\" type=\"hidden\" value=\"" . $paypal_weight_unit . "\" />";
		if( get_option( 'ec_option_paypal_collect_shipping' ) ){
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"2\" />";
		}else{
			echo "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"1\" />";
		}
		echo "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"" . $paypal_lc . "\" />";
		echo "<input name=\"charset\" id=\"charset\" type=\"hidden\" value=\"" . $paypal_charset . "\" />";
		echo "<input name=\"rm\" id=\"rm\" type=\"hidden\" value=\"2\" />";
		echo "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ) ."\" />";
		echo "<input type=\"hidden\" name=\"return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order_id . "\" />";
		echo "<input type=\"hidden\" name=\"cancel_return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" />";
		
		//customer billing information and address info
		if( get_option( 'ec_option_paypal_send_shipping_address' ) ){
			echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_first_name, ENT_QUOTES ) . "\" />";	
			echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_last_name, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_address_line_1, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address2\" id=\"address2\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_address_line_2, ENT_QUOTES ) . "\" />";
			echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_city, ENT_QUOTES ) . "\" />";
			echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . htmlspecialchars( strtoupper($this->order->shipping_state ), ENT_QUOTES ) . "\" />";
			echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_zip, ENT_QUOTES ) . "\" />";
			echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->shipping_country, ENT_QUOTES ) . "\" />";
			echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->user_email, ENT_QUOTES ) . "\" />";
		}else{
			echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_first_name, ENT_QUOTES ) . "\" />";	
			echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_last_name, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_address_line_1, ENT_QUOTES ) . "\" />";
			echo "<input name=\"address2\" id=\"address2\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_address_line_2, ENT_QUOTES ) . "\" />";
			echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_city, ENT_QUOTES ) . "\" />";
			echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . htmlspecialchars( strtoupper($this->order->billing_state ), ENT_QUOTES ) . "\" />";
			echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_zip, ENT_QUOTES ) . "\" />";
			echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->billing_country, ENT_QUOTES ) . "\" />";
			echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . htmlspecialchars( $this->order->user_email, ENT_QUOTES ) . "\" />";
		}
		
		//add the cart contents to paypal
		for( $i = 0; $i<count( $this->order_details ); $i++ ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order_details[$i]->title ) . "\" />";
			echo "<input name=\"item_number_" . $paypal_counter . "\" id=\"item_number_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $this->order_details[$i]->model_number ) . "\" />";
			if( get_option( 'ec_option_paypal_use_selected_currency' ) ){
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price(  ( $this->order_details[$i]->total_price/$this->order_details[$i]->quantity ) ) . "\" />";
			}else{
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format( ( $this->order_details[$i]->total_price/$this->order_details[$i]->quantity ), 2, '.', '' ) . "\" />";
			}
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $this->order_details[$i]->quantity . "\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
		if( $this->order->discount_total >= $this->order->sub_total ){
			$paypal_counter = $i+1;
			echo "<input name=\"item_name_" . $paypal_counter . "\" id=\"item_name_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' ) ) . "\" />";
			echo "<input name=\"item_number_" . $paypal_counter . "\" id=\"item_number_" . $paypal_counter . "\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', strtolower( $GLOBALS['language']->get_text( 'cart_totals', 'cart_totals_shipping' ) ) ) . "\" />";
			if( get_option( 'ec_option_paypal_use_selected_currency' ) ){
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . $GLOBALS['currency']->convert_price( $this->order->shipping_total ) . "\" />";
			}else{
				echo "<input name=\"amount_" . $paypal_counter . "\" id=\"amount_" . $paypal_counter . "\" type=\"hidden\" value=\"" . number_format( $this->order->shipping_total, 2, '.', '' ) . "\" />";
			}
			echo "<input name=\"quantity_".$paypal_counter . "\" id=\"quantity_" . $paypal_counter . "\" type=\"hidden\" value=\"1\" />";
			echo "<input name=\"shipping_" . $paypal_counter . "\" id=\"shipping_" . $paypal_counter."\" type=\"hidden\" value=\"0.00\" />";
			echo "<input name=\"shipping2_" . $paypal_counter . "\" id=\"shipping2_" . $paypal_counter . "\" type=\"hidden\" value=\"0.00\" />";
		}
		echo "<div class=\"ec_third_party_submit_button\"><input type=\"submit\" value=\"" . $GLOBALS['language']->get_text( "cart_payment_information", "cart_payment_information_third_party" ) . " PayPal\" id=\"ec_third_party_submit_payment\" /></div>";
		echo "</form>";
		echo "<SCRIPT>document.getElementById( 'ec_third_party_submit_payment' ).style.display = 'none';</SCRIPT>";
		echo "<SCRIPT data-cfasync=\"false\" LANGUAGE=\"Javascript\">document.ec_paypal_standard_auto_form.submit();</SCRIPT>";
	}
	
	public function display_subscription_form( $order_id, $user, $product, $quantity = 1 ){
		$paypal_use_sandbox = get_option( 'ec_option_paypal_use_sandbox' );
		$paypal_email = get_option( 'ec_option_paypal_email' );
		$paypal_currency_code = get_option( 'ec_option_paypal_currency_code' );
		$paypal_lc = get_option( 'ec_option_paypal_lc' );
		$paypal_weight_unit = get_option( 'ec_option_paypal_weight_unit' );
		
		//this is actionscript version in flash
		if( $paypal_use_sandbox )			$paypal_request = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else								$paypal_request = "https://www.paypal.com/cgi-bin/webscr";
		
		echo "<style>
		.ec_third_party_submit_button{ width:100%; text-align:center; }
		.ec_third_party_submit_button > input{ margin-top:150px; width:300px; height:45px; background-color:#38E; color:#FFF; font-weight:bold; text-transform:uppercase; border:1px solid #A2C0D8; cursor:pointer; }
		.ec_third_party_submit_button > input:hover{ background-color:#7A99BF; }
		.ec_third_party_loader{ display:block !important; position:absolute; top:50%; left:50%; }
		@-webkit-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@-moz-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@-o-keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		@keyframes ec_third_party_loader {
		  0% {
			-webkit-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		  }
		
		  100% {
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		  }
		}
		
		/* Styles for old versions of IE */
		.ec_third_party_loader {
		  font-family: sans-serif;
		  font-weight: 100;
		}
		
		/* :not(:required) hides this rule from IE9 and below */
		.ec_third_party_loader:not(:required) {
		  -webkit-animation: ec_third_party_loader 1250ms infinite linear;
		  -moz-animation: ec_third_party_loader 1250ms infinite linear;
		  -ms-animation: ec_third_party_loader 1250ms infinite linear;
		  -o-animation: ec_third_party_loader 1250ms infinite linear;
		  animation: ec_third_party_loader 1250ms infinite linear;
		  border: 8px solid #3388ee;
		  border-right-color: transparent;
		  border-radius: 16px;
		  box-sizing: border-box;
		  display: inline-block;
		  position: relative;
		  overflow: hidden;
		  text-indent: -9999px;
		  width: 32px;
		  height: 32px;
		}
		</style>";
		
		echo "<div style=\"display:none;\" class=\"ec_third_party_loader\">Loading...</div>";
		
		echo "<form name=\"ec_paypal_standard_auto_form\" action=\"" . $paypal_request . "\" method=\"post\">";
		echo "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourDevelopmentLLC_Cart\" />";
		echo "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"" . str_replace( '"', '&quot;', $paypal_email ) . "\" />";
		echo "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"" . $paypal_currency_code . "\" />";
		echo "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"" . $paypal_lc . "\" />";
		echo "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  plugins_url( EC_PLUGIN_DIRECTORY . "/inc/scripts/paypal_payment_complete.php" ) ."\" />";
		echo "<input type=\"hidden\" name=\"return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order_id . "\" />";
		echo "<input type=\"hidden\" name=\"cancel_return\" value=\"". $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" />";
		echo "<input type=\"hidden\" name=\"cmd\" value=\"_xclick-subscriptions\" />";
		
		//customer billing information and address info
		echo "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->first_name, ENT_QUOTES ) . "\" />";
		echo "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->last_name, ENT_QUOTES ) . "\" />";
		echo "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->address_line_1, ENT_QUOTES ) . "\" />";
		echo "<input name=\"address2\" id=\"address2\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->address_line_2, ENT_QUOTES ) . "\" />";
		echo "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->city, ENT_QUOTES ) . "\" />";
		echo "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"" . htmlspecialchars( strtoupper($user->billing->state ), ENT_QUOTES ) . "\" />";
		echo "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->zip, ENT_QUOTES ) . "\" />";
		echo "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"" . htmlspecialchars( $user->billing->country, ENT_QUOTES ) . "\" />";
		echo "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"" . htmlspecialchars( $user->email, ENT_QUOTES ) . "\" />";
		
		echo "<input name=\"item_name\" id=\"item_name\" type=\"hidden\" value=\"" . htmlspecialchars( $product->title, ENT_QUOTES ) . "\" />";
		echo "<input name=\"item_number\" id=\"item_number\" type=\"hidden\" value=\"" . htmlspecialchars( $product->model_number, ENT_QUOTES ) . "\" />";
		
		if( $product->subscription_signup_fee > 0 ){
			echo "<input name=\"a1\" id=\"a1\" type=\"hidden\" value=\"" . number_format( $product->subscription_signup_fee + $product->price * $quantity, 2 ) . "\" />";
			echo "<input name=\"p1\" id=\"p1\" type=\"hidden\" value=\"" . htmlspecialchars( $product->subscription_bill_length, ENT_QUOTES ) . "\" />";
			echo "<input name=\"t1\" id=\"t1\" type=\"hidden\" value=\"" . htmlspecialchars( $product->subscription_bill_period, ENT_QUOTES ) . "\" />";
		}
		
		echo "<input name=\"a3\" id=\"a3\" type=\"hidden\" value=\"" . number_format( $product->price * $quantity, 2 ) . "\" />";
		echo "<input name=\"p3\" id=\"p3\" type=\"hidden\" value=\"" . htmlspecialchars( $product->subscription_bill_length, ENT_QUOTES ) . "\" />";
		echo "<input name=\"t3\" id=\"t3\" type=\"hidden\" value=\"" . htmlspecialchars( $product->subscription_bill_period, ENT_QUOTES ) . "\" />";
		echo "<input name=\"src\" id=\"src\" type=\"hidden\" value=\"1\" />";
		if( $product->subscription_bill_duration > 1 )
			echo "<input name=\"srt\" id=\"srt\" type=\"hidden\" value=\"" . $product->subscription_bill_duration . "\" />";
		
		echo "<input name=\"no_note\" id=\"no_note\" type=\"hidden\" value=\"1\" />";
		
		echo "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"" . $order_id . "\" />";
		echo "<input name=\"invoice\" id=\"invoice\" type=\"hidden\" value=\"" . $order_id . "\" />";
		
		echo "<input name=\"modify\" id=\"modify\" type=\"hidden\" value=\"0\" />";
		echo "<input name=\"usr_manage\" id=\"usr_manage\" type=\"hidden\" value=\"1\" />";
		
		echo "<div class=\"ec_third_party_submit_button\"><input type=\"submit\" value=\"" . $GLOBALS['language']->get_text( "cart_payment_information", "cart_payment_information_third_party" ) . " PayPal\" id=\"ec_third_party_submit_payment\" /></div>";
		
		echo "</form>";
		echo "<SCRIPT>document.getElementById( 'ec_third_party_submit_payment' ).style.display = 'none';</SCRIPT>";
		echo "<SCRIPT data-cfasync=\"false\" LANGUAGE=\"Javascript\">document.ec_paypal_standard_auto_form.submit();</SCRIPT>";
	}
	
}
?>