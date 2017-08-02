<?php

class ec_tax{
	
	protected $mysqli;										// ec_db structure
	
	public $state_tax;										// FLOAT 15,3
	public $country_tax;									// FLOAT 15,3
	public $all_tax;										// FLOAT 15,3
	
	public $tax_total;										// FLOAT 15,3
	public $tax_shipping;									// BOOL
	
	public $duty_total;										// FLOAT 15,3
	public $vat_total;										// FLOAT 15,3
	public $shipping_total;									// FLOAT 15,3
	
	// State Tax
	public $state_tax_enabled;								// BOOL
	public $state_tax_match;								// BOOL
	public $state_tax_rate;									// FLOAT 11,2
	
	// Country Tax
	public $country_tax_enabled;							// BOOL
	public $country_tax_match;								// BOOL
	public $country_tax_rate;								// FLOAT 11,2
	
	// All Tax
	public $all_tax_enabled;								// BOOL
	public $all_tax_rate;									// FLOAT 11,2
	
	// Duty
	public $duty_enabled;									// BOOL
	public $duty_country_match;								// BOOL
	public $duty_rate;										// FLOAT 11,2
	
	// VAT
	public $vat_enabled;									// BOOL
	public $vat_country_match;								// BOOL
	public $vat_rate_default;								// FLOAT 11,2
	public $vat_rate;										// FLOAT 11,2
	public $vat_added;										// BOOL
	public $vat_included;									// BOOL
	
	// Canada Tax
	public $easy_canada_tax_enabled;						// BOOL
	public $collect_alberta;								// BOOL
	public $collect_british_columbia;						// BOOL
	public $collect_manitoba;								// BOOL
	public $collect_new_brunswick;							// BOOL
	public $collect_newfoundland;							// BOOL
	public $collect_northwest_territories;					// BOOL
	public $collect_nova_scotia;							// BOOL
	public $collect_nunavut;								// BOOL
	public $collect_ontario;								// BOOL
	public $collect_prince_edward_island;					// BOOL
	public $collect_quebec;									// BOOL
	public $collect_saskatchewan;							// BOOL
	public $collect_yukon;									// BOOL
	public $gst;											// FLOAT 15,3
	public $gst_rate;										// FLOAT 15,3
	public $pst;											// FLOAT 15,3
	public $pst_rate;										// FLOAT 15,3
	public $hst;											// FLOAT 15,3
	public $hst_rate;										// FLOAT 15,3
	
	// Tax Cloud
	public $tax_cloud_enabled;								// BOOL
	
	// List of Countries for VAT
	public $country_list;									// Array( 'name_cnt'=>'United States', 
															//		  'iso2_cnt'=>'US', 
															//		  'vat_rate_cnt'=>'20' )
	
	// Passed in Values
	private $cart_subtotal;		// Used for Duty			// FLOAT 7,2
	private $taxable_subtotal;	// Used for Tax				// FLOAT 7,2
	private $vatable_total;		// Used for VAT				// FLOAT 15,3
	
	private $shipping_state;								// VARCHAR 255
	private $shipping_country;								// VARCHAR 255
	
	private $taxfree;										// BOOLEAN
	
	function __construct( $cart_subtotal, $taxable_subtotal, $vatable_total, $shipping_state, $shipping_country, $taxfree = false, $shipping_total = 0.00 ){
		
		// Initialize Structures and Lists
		$this->mysqli 							= 			new ec_db();
		$this->country_list						=			$GLOBALS['ec_countries']->countries;
		$taxrates								= 			$this->mysqli->get_taxrates( );
		
		// Save the Subtotals
		$this->cart_subtotal 					= 			$cart_subtotal;
		if( $this->cart_subtotal < 0 )
			$this->cart_subtotal				=			0;
			
		$this->taxable_subtotal 				= 			$taxable_subtotal;
		if( $this->taxable_subtotal < 0 )
			$this->taxable_subtotal				=			0;
		
		$this->vatable_total 					= 			$vatable_total;
		if( $this->vatable_total < 0 )
			$this->vatable_total				=			0;
			
		$this->shipping_total					=			$shipping_total;
		
		// Save the User Entered Data
		$this->shipping_state 					= 			strtoupper( $shipping_state );
		$this->shipping_country 				= 			strtoupper( $shipping_country );
		
		$this->taxfree							=			$taxfree;
		
		// Initialize the Values to Zero/False
		$this->initialize_tax_values( );
		
		// Setup the Values from DB
		$this->setup_tax_info( $taxrates );
		
		// Calculate Actual Values
		$this->calculate_taxes( );
	}
	
	private function initialize_tax_values( ){
		// Overall Options
		$this->tax_shipping = get_option( 'ec_option_collect_tax_on_shipping' );
		
		// State Tax
		$this->state_tax_enabled 		= false;
		$this->state_tax_match 			= false;
		$this->state_tax_rate			= 0;
		
		// Country Tax
		$this->country_tax_enabled		= false;
		$this->country_tax_match		= false;
		$this->country_tax_rate			= 0;
		
		// All Tax
		$this->all_tax_enabled			= false;
		$this->all_tax_rate				= 0;
		
		// Duty
		$this->duty_enabled				= false;
		$this->duty_country_match		= false;
		$this->duty_rate				= 0;
		
		// VAT
		$this->vat_enabled				= false;
		$this->vat_country_match		= false;
		$this->vat_rate_default			= 0;
		$this->vat_rate					= 0;
		
		// Canada Tax
		$this->easy_canada_tax_enabled = get_option( 'ec_option_enable_easy_canada_tax' );
		$this->collect_alberta = get_option( 'ec_option_collect_alberta_tax' );
		$this->collect_british_columbia = get_option( 'ec_option_collect_british_columbia_tax' );
		$this->collect_manitoba = get_option( 'ec_option_collect_manitoba_tax' );
		$this->collect_new_brunswick = get_option( 'ec_option_collect_new_brunswick_tax' );
		$this->collect_newfoundland = get_option( 'ec_option_collect_newfoundland_tax' );
		$this->collect_northwest_territories = get_option( 'ec_option_collect_northwest_territories_tax' );
		$this->collect_nova_scotia = get_option( 'ec_option_collect_nova_scotia_tax' );
		$this->collect_nunavut = get_option( 'ec_option_collect_nunavut_tax' );
		$this->collect_ontario = get_option( 'ec_option_collect_ontario_tax' );
		$this->collect_prince_edward_island = get_option( 'ec_option_collect_prince_edward_island_tax' );
		$this->collect_quebec = get_option( 'ec_option_collect_quebec_tax' );
		$this->collect_saskatchewan = get_option( 'ec_option_collect_saskatchewan_tax' );
		$this->collect_yukon = get_option( 'ec_option_collect_yukon_tax' );
		$this->gst = 0;
		$this->gst_rate = 0;
		$this->pst = 0;
		$this->pst_rate = 0;
		$this->hst = 0;
		$this->hst_rate = 0;
		
		// Tax Cloud
		if( get_option( 'ec_option_tax_cloud_api_id' ) != "" && get_option( 'ec_option_tax_cloud_api_key' ) != "" )
			$this->tax_cloud_enabled = true;
		else
			$this->tax_cloud_enabled = false;
		
	}
	
	private function setup_tax_info( $taxrates ){
		foreach( $taxrates as $taxrate ){
			if( !$this->state_tax_match && $taxrate->tax_by_state ){
				$this->state_tax_enabled = true;
				if(	$this->shipping_state == $taxrate->state_code && ( $taxrate->country_code == "" || $this->shipping_country == $taxrate->country_code ) ){
					$this->state_tax_match = true;
					$this->state_tax_rate = $taxrate->state_rate;
				}
			}else if( $taxrate->tax_by_country ){
				$this->country_tax_enabled = true;
				if( $this->shipping_country == $taxrate->country_code ){
					$this->country_tax_match = true;
					$this->country_tax_rate = $taxrate->country_rate;	
				}
			}else if( $taxrate->tax_by_all ){
				$this->all_tax_enabled = true;
				$this->all_tax_rate = $taxrate->all_rate;
			}else if( $taxrate->tax_by_duty ){
				$this->duty_enabled = true;
				if( $this->shipping_country != $taxrate->duty_exempt_country_code ){
					$this->duty_country_match = true;
					$this->duty_rate = $taxrate->duty_rate;
				}
			}else if( $taxrate->tax_by_vat ){
				$this->vat_enabled = true;
				$vat_row = $taxrate;
				$this->vat_rate_default = $taxrate->vat_rate;
				$this->vat_added = $taxrate->vat_added;
				$this->vat_included = $taxrate->vat_included;
			}else if( $taxrate->tax_by_single_vat ){
				$this->vat_enabled = true;
				$this->vat_rate_default = $taxrate->vat_rate;
				$this->vat_rate = $taxrate->vat_rate;
				$this->vat_added = $taxrate->vat_added;
				$this->vat_included = $taxrate->vat_included;
			}
		}
		
		if( $this->vat_enabled && $this->vat_rate <= 0 ){
			for( $i=0; $i<count($this->country_list); $i++){
				if( $this->shipping_country == $this->country_list[$i]->iso2_cnt ){
					$this->vat_country_match = true;
					$this->vat_rate = $this->country_list[$i]->vat_rate_cnt;
				}
			}
			if( !$this->vat_country_match ){
				$this->vat_rate = $vat_row->vat_rate;
			}
		}
	}
	
	private function calculate_taxes( ){
		$this->state_tax 						= 			0;
		$this->country_tax 						= 			0;
		$this->all_tax 							= 			0;
		$this->duty_total 						= 			0;
		$this->vat_total 						= 			0;
		
		if( $this->taxfree ){
			// Tax free order, lets not charge the customer
			$this->tax_total = 0;
			
		}else if( $this->tax_cloud_enabled && $this->shipping_country == 'US' ){
			$this->tax_total = wpeasycart_taxcloud( )->tax_amount;
			$this->state_tax_rate = ( $this->tax_total / $this->cart_subtotal ) * 100;
			
		}else{
			// Add Shipping to Taxable Total
			if( $this->tax_shipping ){
				$this->taxable_subtotal = $this->taxable_subtotal + $this->shipping_total;
			}
			
			// Calculate State Tax
			if( $this->state_tax_enabled && $this->state_tax_match )
				$this->state_tax = $this->taxable_subtotal * $this->state_tax_rate / 100;
			
			// Calculate Country Tax
			if( $this->country_tax_enabled && $this->country_tax_match )
				$this->country_tax = $this->taxable_subtotal * $this->country_tax_rate / 100;
			
			// Calculate All Tax
			if( $this->all_tax_enabled )
				$this->all_tax = $this->taxable_subtotal * $this->all_tax_rate / 100;	
			
			//Calculate Sales Tax Total
			$this->tax_total = $this->state_tax + $this->country_tax + $this->all_tax;
			
			// Calculate Duty
			if( $this->duty_enabled && $this->duty_country_match )
				$this->duty_total = $this->cart_subtotal * $this->duty_rate / 100;
			
			// Calculate VAT Values
			if( $this->vat_enabled ){
				if( get_option( 'ec_option_collect_vat_registration_number' ) && $GLOBALS['ec_user']->vat_registration_number != "" ){
					$this->vat_rate = get_option( 'ec_option_vat_custom_rate' );
				}
				$GLOBALS['ec_vat_rate'] = $this->vat_rate;
				if( $this->vat_included ){
					$this->vat_total = ( $this->vatable_total / ( ( $this->vat_rate / 100 ) + 1 ) ) * ( $this->vat_rate / 100 );
				}else{
					$this->vat_total = $this->vatable_total * $this->vat_rate / 100;
				}
			}
			
			// Calculate Canada Tax
			if( $this->easy_canada_tax_enabled && $this->shipping_country == "CA" ){
				
				$canada_tax_options = get_option( 'ec_option_canada_tax_options' );
				$user_level = $GLOBALS['ec_user']->user_level;
				if( $user_level == 'admin' || $GLOBALS['ec_user']->user_level == "" )
					$user_level = 'shopper';
				
				if( $canada_tax_options ){ // New Version of Canada Tax
				
					$this->gst_rate = 0;
					$this->pst_rate = 0;
					$this->hst_rate = 0;
				
					if( isset( $canada_tax_options['ec_option_collect_alberta_tax_' . $user_level] ) && $this->shipping_state == "AB" ){
						$this->gst_rate = $canada_tax_options['ec_option_alberta_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_alberta_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_alberta_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_british_columbia_tax_' . $user_level] ) && $this->shipping_state == "BC" ){
						$this->gst_rate = $canada_tax_options['ec_option_british_columbia_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_british_columbia_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_british_columbia_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_manitoba_tax_' . $user_level] ) && $this->shipping_state == "MB" ){
						$this->gst_rate = $canada_tax_options['ec_option_manitoba_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_manitoba_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_manitoba_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_new_brunswick_tax_' . $user_level] ) && $this->shipping_state == "NF" ){
						$this->gst_rate = $canada_tax_options['ec_option_new_brunswick_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_new_brunswick_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_new_brunswick_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_newfoundland_tax_' . $user_level] ) && $this->shipping_state == "NB" ){
						$this->gst_rate = $canada_tax_options['ec_option_newfoundland_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_newfoundland_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_newfoundland_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_northwest_territories_tax_' . $user_level] ) && $this->shipping_state == "NT" ){
						$this->gst_rate = $canada_tax_options['ec_option_northwest_territories_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_northwest_territories_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_northwest_territories_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_nova_scotia_tax_' . $user_level] ) && $this->shipping_state == "NS" ){
						$this->gst_rate = $canada_tax_options['ec_option_nova_scotia_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_nova_scotia_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_nova_scotia_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_nunavut_tax_' . $user_level] ) && $this->shipping_state == "NU" ){
						$this->gst_rate = $canada_tax_options['ec_option_nunavut_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_nunavut_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_nunavut_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_ontario_tax_' . $user_level] ) && $this->shipping_state == "ON" ){
						$this->gst_rate = $canada_tax_options['ec_option_ontario_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_ontario_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_ontario_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_prince_edward_island_tax_' . $user_level] ) && $this->shipping_state == "PE" ){
						$this->gst_rate = $canada_tax_options['ec_option_prince_edward_island_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_prince_edward_island_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_prince_edward_island_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_quebec_tax_' . $user_level] ) && $this->shipping_state == "QC" ){
						$this->gst_rate = $canada_tax_options['ec_option_quebec_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_quebec_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_quebec_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_saskatchewan_tax_' . $user_level] ) && $this->shipping_state == "SK" ){
						$this->gst_rate = $canada_tax_options['ec_option_saskatchewan_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_saskatchewan_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_saskatchewan_tax_' . $user_level . '_hst'] * 100;
						
					}else if( isset( $canada_tax_options['ec_option_collect_yukon_tax_' . $user_level] ) && $this->shipping_state == "YT" ){
						$this->gst_rate = $canada_tax_options['ec_option_yukon_tax_' . $user_level . '_gst'] * 100;
						$this->pst_rate = $canada_tax_options['ec_option_yukon_tax_' . $user_level . '_pst'] * 100;
						$this->hst_rate = $canada_tax_options['ec_option_yukon_tax_' . $user_level . '_hst'] * 100;
						
					}
					
					$this->gst = $this->taxable_subtotal * ( $this->gst_rate / 100 );
					$this->pst = $this->taxable_subtotal * ( $this->pst_rate / 100 );
					$this->hst = $this->taxable_subtotal * ( $this->hst_rate / 100 );
					
				}else{ // old canada tax
				
					if( $this->collect_alberta && $this->shipping_state == "AB" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						
					}else if( $this->collect_british_columbia && $this->shipping_state == "BC" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						$this->pst = $this->taxable_subtotal * .07;
						$this->pst_rate = 7;
						
					}else if( $this->collect_manitoba && $this->shipping_state == "MB" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						$this->pst = $this->taxable_subtotal * .08;
						$this->pst_rate = 8;
						
					}else if( $this->collect_newfoundland && $this->shipping_state == "NF" ){
						$this->hst = $this->taxable_subtotal * .13;
						$this->hst_rate = 13;
						
					}else if( $this->collect_new_brunswick && $this->shipping_state == "NB" ){
						$this->hst = $this->taxable_subtotal * .13;
						$this->hst_rate = 13;
						
					}else if( $this->collect_nova_scotia && $this->shipping_state == "NS" ){
						$this->hst = $this->taxable_subtotal * .15;
						$this->hst_rate = 15;
						
					}else if( $this->collect_northwest_territories && $this->shipping_state == "NT" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						
					}else if( $this->collect_nunavut && $this->shipping_state == "NU" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						
					}else if( $this->collect_ontario && $this->shipping_state == "ON" ){
						$this->hst = $this->taxable_subtotal * .13;
						$this->hst_rate = 13;
						
					}else if( $this->collect_prince_edward_island && $this->shipping_state == "PE" ){
						$this->hst = $this->taxable_subtotal * .14;
						$this->hst_rate = 14;
						
					}else if( $this->collect_quebec && $this->shipping_state == "QC" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						$this->pst = $this->taxable_subtotal * .09975;
						$this->pst_rate = 9.975;
						
					}else if( $this->collect_saskatchewan && $this->shipping_state == "SK" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						$this->pst = $this->taxable_subtotal * .05;
						$this->pst_rate = 5;
						
					}else if( $this->collect_yukon && $this->shipping_state == "YT" ){
						$this->gst = $this->taxable_subtotal * .05;
						$this->gst_rate = 5;
						
					}
					
				}// Close different types of canada tax
				
			} // Close Canada Taxation Check
			
		}
		
	}
	
	public function get_tax_rate( ){
		return $this->state_tax_rate + $this->all_tax_rate + $this->country_tax_rate + $this->gst_rate + $this->hst_rate + $this->pst_rate + $this->vat_rate;
	}
	
	public function is_tax_enabled( ){
		if( $this->state_tax_enabled || $this->country_tax_enabled || $this->all_tax_enabled || $this->tax_cloud_enabled )
			return true;
		else
			return false;
	}
	
	public function is_duty_enabled( ){
		if( $this->duty_enabled && $this->duty_country_match )
			return true;
		else
			return false;
	}
	
	public function is_vat_enabled( ){
		if( $this->vat_enabled )
			return true;
		else
			return false;
	}
	
}

?>