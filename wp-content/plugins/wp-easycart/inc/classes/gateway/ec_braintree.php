<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.
require_once( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/inc/classes/gateway/braintree_lib/Braintree.php' );

class ec_braintree extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$braintree_merchant_id = get_option( 'ec_option_braintree_merchant_id' );
		$braintree_public_key = get_option( 'ec_option_braintree_public_key' );
		$braintree_private_key = get_option( 'ec_option_braintree_private_key' );
		$braintree_currency = get_option( 'ec_option_braintree_currency' );
		$braintree_environment = get_option( 'ec_option_braintree_environment' );
		
		Braintree_Configuration::environment( $braintree_environment );
		Braintree_Configuration::merchantId( $braintree_merchant_id );
		Braintree_Configuration::publicKey( $braintree_public_key );
		Braintree_Configuration::privateKey( $braintree_private_key );
		
		$braintree_array = array(
			'amount' => number_format( $this->order_totals->grand_total, 2, ".", "" ),
			'orderId' => $this->order_id,
			'creditCard' => array(
				'number' => $this->credit_card->card_number,
				'expirationDate' => $this->credit_card->expiration_month . "/" . $this->credit_card->get_expiration_year( 4 ),
				'cardholderName' => $this->credit_card->card_holder_name,
				'cvv' => $this->credit_card->security_code
			),
			'customer' => array(
				'firstName' => $this->user->billing->first_name,
				'lastName' => $this->user->billing->last_name,
				'phone' => $this->user->billing->phone,
				'email' => $this->user->email
			),
			'billing' => array(
				'firstName' => $this->user->billing->first_name,
				'lastName' => $this->user->billing->last_name,
				'streetAddress' => $this->user->billing->address_line_1,
				'locality' => $this->user->billing->city,
				'region' => $this->user->billing->state,
				'postalCode' => $this->user->billing->zip,
				'countryCodeAlpha2' => $this->user->billing->country
			),
			'shipping' => array(
				'firstName' => $this->user->shipping->first_name,
				'lastName' => $this->user->shipping->last_name,
				'streetAddress' => $this->user->shipping->address_line_1,
				'locality' => $this->user->shipping->city,
				'region' => $this->user->shipping->state,
				'postalCode' => $this->user->shipping->zip,
				'countryCodeAlpha2' => $this->user->shipping->country
			),
			'options' => array(
				'submitForSettlement' => true
			)
		);
			  
		return $braintree_array;
	}
	
	function get_gateway_url( ){
		
		return "";

	}
	
	protected function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		$braintree_merchant_id = get_option( 'ec_option_braintree_merchant_id' );
		$braintree_public_key = get_option( 'ec_option_braintree_public_key' );
		$braintree_private_key = get_option( 'ec_option_braintree_private_key' );
		$braintree_currency = get_option( 'ec_option_braintree_currency' );
		$braintree_environment = get_option( 'ec_option_braintree_environment' );
		
		Braintree_Configuration::environment( $braintree_environment );
		Braintree_Configuration::merchantId( $braintree_merchant_id );
		Braintree_Configuration::publicKey( $braintree_public_key );
		Braintree_Configuration::privateKey( $braintree_private_key );
		
		$result = Braintree_Transaction::sale( $gateway_data );
		
		return $result;	
	}
	
	function handle_gateway_response( $result ){
		
		if ($result->success) {
			$this->is_success = 1;
		} else if ($result->transaction) {
			$this->is_success = 0;
			$response_text = print_r( "Error processing transaction:", true ) . print_r( "\n  message: " . $result->message, true ) . print_r( "\n  code: " . $result->transaction->processorResponseCode, true ) . print_r( "\n  text: " . $result->transaction->processorResponseText, true );
			$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Braintree", $response_text );
			$this->error_message = $result->message;
		} else {
			$this->is_success = 0;
			$response_text = print_r( "Message: " . $result->message, true ) . print_r( "\nValidation errors: \n", true ) . print_r( $result->errors->deepAll(), true );
			$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Braintree", $response_text );
			$this->error_message = $result->message;
		}	
			
	}
	
}

?>