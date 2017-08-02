<?php

class ec_cart_data{
	
	protected $mysqli;										// ec_db structure
	
	public $ec_cart_id;										// VARCHAR 255
	public $cart_data;										// Object from DB
	public $advanced_cart_options;							// Array of Cart Option Rows
	public $product_quantities;								// Array of Cart Product Quantities
	
	function __construct( $ec_cart_id ){
		
		$this->mysqli = new ec_db( );
		$this->ec_cart_id = $ec_cart_id;
		
		if( get_option( 'ec_option_cart_use_session_support' ) && isset( $_SESSION['ec_cart_data_stored'] ) && $GLOBALS['ec_cart_id'] == $_SESSION['ec_cart_data_stored']->session_id )
			$this->cart_data = $_SESSION['ec_cart_data_stored'];
		else{
			$this->cart_data = $this->mysqli->get_cart_data( $ec_cart_id );
			$_SESSION['ec_cart_data_stored'] = $this->cart_data;
		}
		
		$this->advanced_cart_options = $this->mysqli->get_advanced_cart_options( $this->ec_cart_id );
		$this->product_quantities = $this->mysqli->get_tempcart_product_quantities( $this->ec_cart_id );
		if( !$this->product_quantities )
			$this->product_quantities = array( );
			
		add_action( 'wpeasycart_config_loaded', array( $this, 'init_advanced_cart_options' ) );
		
	}
	
	public function save_session_to_db( ){
			
		/* RUN SQL */
		unset( $_SESSION['ec_cart_data_stored'] );
		$this->mysqli->save_cart_data( $this->ec_cart_id, $this->cart_data );
		
	}
	
	public function restore_session_from_db( ){
		
		if( isset( $_SESSION['ec_cart_data_stored'] ) )
			$this->cart_data = $_SESSION['ec_cart_data_stored'];
		else{
			$this->cart_data = $this->mysqli->get_cart_data( $this->ec_cart_id );
			$_SESSION['ec_cart_data_stored'] = $this->cart_data;
		}
		
		if( $this->cart_data->estimate_shipping_zip != "" )
			$_SESSION['ec_temp_zipcode'] = $this->cart_data->estimate_shipping_zip;
		else if( isset( $_SESSION['ec_temp_zipcode'] ) )
			unset( $_SESSION['ec_temp_zipcode'] );
		
		if( $this->cart_data->is_guest != "" )
			$_SESSION['ec_is_guest'] = $this->cart_data->is_guest;
		else if( isset( $_SESSION['ec_is_guest'] ) )
			unset( $_SESSION['ec_is_guest'] );
		
		if( $this->cart_data->guest_key != "" )
			$_SESSION['ec_guest_key'] = $this->cart_data->guest_key;
		else if( isset( $_SESSION['ec_guest_key'] ) )
			unset( $_SESSION['ec_guest_key'] );
		
		if( $this->cart_data->shipping_method != "" )
			$_SESSION['ec_shipping_method'] = $this->cart_data->shipping_method;
		else if( isset( $_SESSION['ec_shipping_method'] ) )
			unset( $_SESSION['ec_shipping_method'] );
		
		if( $this->cart_data->expedited_shipping != "" )
			$_SESSION['ec_ship_express'] = $this->cart_data->expedited_shipping;
		else if( isset( $_SESSION['ec_ship_express'] ) )
			unset( $_SESSION['ec_ship_express'] );
		
		if( $this->cart_data->shipping_selector != "" )
			$_SESSION['ec_shipping_selector'] = $this->cart_data->shipping_selector;
		else if( isset( $_SESSION['ec_shipping_selector'] ) )
			unset( $_SESSION['ec_shipping_selector'] );
		
		if( $this->cart_data->order_notes != "" )
			$_SESSION['ec_order_notes'] = $this->cart_data->order_notes;
		else if( isset( $_SESSION['ec_order_notes'] ) )
			unset( $_SESSION['ec_order_notes'] );
		
		if( $this->cart_data->user_id != "" )
			$_SESSION['ec_user_id'] = $this->cart_data->user_id;
		else if( isset( $_SESSION['ec_user_id'] ) )
			unset( $_SESSION['ec_user_id'] );
			
		if( $this->cart_data->email != "" )
			$_SESSION['ec_email'] = $this->cart_data->email;
		else if( isset( $_SESSION['ec_email'] ) )
			unset( $_SESSION['ec_email'] );
		
		// V2 Design Backwards Compatibility
		if( $this->cart_data->email == "guest" )
			$_SESSION['ec_password'] = "guest";
		else if( isset( $_SESSION['ec_password'] ) )
			unset( $_SESSION['ec_password'] );
		
	}
	
	public function clear_db_session( ){
		
		$this->mysqli->remove_cart_data( $ec_cart_id );
		
	}
	
	public function checkout_session_complete( ){
		
		// Save carry over variables
		$is_guest = $this->cart_data->is_guest;
		$guest_key = $this->cart_data->guest_key;
		$user_id = $this->cart_data->user_id;
		$email = $this->cart_data->email;
		
		// Remove this cart data
		$this->mysqli->remove_cart_data( $this->ec_cart_id );
		unset( $this->ec_cart_id );
		unset( $_SESSION['ec_shipping_selector'] );
		unset( $_SESSION['ec_selected_payment_method'] );
		
		// Reset this class
		unset( $this->cart_data );
		$this->generate_new_cart_id( );
		
		$this->cart_data = new stdClass( );
		$this->cart_data->session_id = $this->ec_cart_id;
		$this->cart_data->is_guest = $is_guest;
		$this->cart_data->guest_key = $guest_key;
		$this->cart_data->user_id = $user_id;
		$this->cart_data->email = $email;
		
		// Save back to DB
		$this->save_session_to_db( );
		
	}
	
	public function generate_new_cart_id( ){
		
		global $wpdb;
		
		setcookie('ec_cart_id', "", time( ) - 3600 ); 
		setcookie('ec_cart_id', "", time( ) - 3600, "/" );
		unset( $GLOBALS['ec_cart_id'] );
		unset( $_SESSION['ec_cart_id'] );
		unset( $_SESSION['ec_cart_data_stored'] );
		
		$vals = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
		$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
		
		$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
		$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
		while( $check_tempcart_id || $check_tempcart_data_id ){ // If we get a result, create new and go until we get a unique tempcart id...
			$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
			$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
			$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
		}
		
		$this->ec_cart_id = $session_cart_id;
		$GLOBALS['ec_cart_id'] = $this->ec_cart_id;
		$_SESSION['ec_cart_id'] = $this->ec_cart_id;
		setcookie( 'ec_cart_id', $this->ec_cart_id, time( ) + ( 3600 * 24 * 1 ), "/" );
		
	}
	
	public function get_tempcart_product_quantity( $product_id ){
		
		for( $i=0; $i<count( $this->product_quantities ); $i++ ){
			
			if( $this->product_quantities[$i]->product_id == $product_id )
				return $this->product_quantities[$i]->quantity;
			
		}
		
	}
	
	public function init_advanced_cart_options( ){
		
		for( $i=0; $i<count( $this->advanced_cart_options ); $i++ ){
			
			$option = $GLOBALS['ec_advanced_optionsets']->get_advanced_option( $this->advanced_cart_options[$i]->option_id );
			
			$this->advanced_cart_options[$i]->option_name = $option->option_name;
			$this->advanced_cart_options[$i]->option_label = $option->option_label;
			$this->advanced_cart_options[$i]->option_type = $option->option_type;
			
			for( $j=0; $j<count( $option->option_items ); $j++ ){
				if( $option->option_items[$j]->optionitem_id == $this->advanced_cart_options[$i]->optionitem_id ){
					foreach( $option->option_items[$j] as $key=>$value ){
						$this->advanced_cart_options[$i]->{$key} = $value;
					}
				}
			}
			
		}
		
	}
	
	public function get_advanced_cart_options( $tempcart_id ){
		
		$cartitem_optionitems = array( );
		
		for( $i=0; $i<count( $this->advanced_cart_options ); $i++ ){
			
			if( $this->advanced_cart_options[$i]->tempcart_id == $tempcart_id ){
				
				$cartitem_optionitems[] = $this->advanced_cart_options[$i];
			
			}
			
		}
		
		return $cartitem_optionitems;
		
	}
	
}

?>