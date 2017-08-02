<?php

class ec_cartpage{
	protected $mysqli;							// ec_db structure
	public $cart;								// ec_cart structure
	public $user;								// ec_user
	public $tax;								// ec_tax structure
	public $shipping;							// ec_shipping structure
	public $discount;							// ec_discount structure
	public $order_totals;						// ec_order_totals structure
	public $payment;							// ec_payment structure
	public $order;								// ec_order structure
	public $coupon;								// ec_coupon structure
	public $giftcard;							// ec_giftcard structure
	
	public $coupon_code;						// VARCHAR
	public $gift_card;							// VARCHAR
	
	public $subscription_option1;				// Option Item ID
	public $subscription_option2;				// Option Item ID
	public $subscription_option3;				// Option Item ID
	public $subscription_option4;				// Option Item ID
	public $subscription_option5;				// Option Item ID
	
	public $subscription_option1_name;			// Option Item Name
	public $subscription_option2_name;			// Option Item Name
	public $subscription_option3_name;			// Option Item Name
	public $subscription_option4_name;			// Option Item Name
	public $subscription_option5_name;			// Option Item Name
	
	public $subscription_option1_label;			// Option Item Label
	public $subscription_option2_label;			// Option Item Label
	public $subscription_option3_label;			// Option Item Label
	public $subscription_option4_label;			// Option Item Label
	public $subscription_option5_label;			// Option Item Label
	
	public $subscription_advanced_options;		// Array
	
	public $has_downloads;						// BOOL
	
	public $store_page;							// VARCHAR
	public $cart_page;							// VARCHAR
	public $account_page;						// VARCHAR
	public $permalink_divider;					// CHAR
	
	private $analytics;							// ec_googleanalytics class
	private $is_affirm;
	
	////////////////////////////////////////////////////////
	// CONSTUCTOR FUNCTION
	////////////////////////////////////////////////////////
	function __construct( $is_affirm = false ){
		
		$this->is_affirm = $is_affirm;
		
		$this->mysqli = new ec_db();
		$this->cart = new ec_cart( $GLOBALS['ec_cart_data']->ec_cart_id );
		$this->user =& $GLOBALS['ec_user'];
		// For the cart, alter the user to use the saved data only.
		if( $GLOBALS['ec_cart_data']->cart_data->is_guest == "" ){
		
			if( isset( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip ) )
				$estimate_shipping_zip = $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip;
			else
				$estimate_shipping_zip = "";
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country ) )
				$estimate_shipping_country = $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country;
			else
				$estimate_shipping_country = "";
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_zip ) )
				$billing_zip = $GLOBALS['ec_cart_data']->cart_data->billing_zip;
			else
				$billing_zip = "";
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_zip ) )
				$shipping_zip = $GLOBALS['ec_cart_data']->cart_data->shipping_zip;
			else
				$shipping_zip = "";
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_country ) )
				$billing_country = $GLOBALS['ec_cart_data']->cart_data->billing_country;
			else
				$billing_country = "";
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_country ) )
				$shipping_country = $GLOBALS['ec_cart_data']->cart_data->shipping_country;
			else
				$shipping_country = "";
				
			if( $billing_zip == "" )
				$billing_zip = $estimate_shipping_zip;
			if( $shipping_zip == "" )
				$shipping_zip = $estimate_shipping_zip;
			if( $billing_country == "" )
				$billing_country = $estimate_shipping_country;
			if( $shipping_country == "" )
				$shipping_country = $estimate_shipping_country;
				
		}else if( $GLOBALS['ec_cart_data']->cart_data->is_guest != "" && $GLOBALS['ec_cart_data']->cart_data->is_guest ){
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_zip ) )
				$billing_zip = $GLOBALS['ec_cart_data']->cart_data->billing_zip;
			else
				$billing_zip = "";
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_zip ) )
				$shipping_zip = $GLOBALS['ec_cart_data']->cart_data->shipping_zip;
			else
				$shipping_zip = "";
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_country ) )
				$billing_country = $GLOBALS['ec_cart_data']->cart_data->billing_country;
			else
				$billing_country = "";
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_country ) )
				$shipping_country = $GLOBALS['ec_cart_data']->cart_data->shipping_country;
			else
				$shipping_country = "";
		}
			
		if( $GLOBALS['ec_cart_data']->cart_data->is_guest != "" && $GLOBALS['ec_cart_data']->cart_data->is_guest ){
			
			$billing_first_name = $billing_last_name = $billing_company = $billing_address_line_1 = $billing_address_line_2 = $billing_city = $billing_state = $billing_phone = "";
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_first_name ) )
				$billing_first_name = $GLOBALS['ec_cart_data']->cart_data->billing_first_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_last_name ) )
				$billing_last_name = $GLOBALS['ec_cart_data']->cart_data->billing_last_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_company_name ) )
				$billing_company = $GLOBALS['ec_cart_data']->cart_data->billing_company_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 ) )
				$billing_address_line_1 = $GLOBALS['ec_cart_data']->cart_data->billing_address_line_1;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 ) )
				$billing_address_line_2 = $GLOBALS['ec_cart_data']->cart_data->billing_address_line_2;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_city ) )
				$billing_city = $GLOBALS['ec_cart_data']->cart_data->billing_city;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_state ) )
				$billing_state = $GLOBALS['ec_cart_data']->cart_data->billing_state;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->billing_phone ) )
				$billing_phone = $GLOBALS['ec_cart_data']->cart_data->billing_phone;
			$this->user->setup_billing_info_data( $billing_first_name, $billing_last_name, $billing_address_line_1, $billing_address_line_2, $billing_city, $billing_state, $billing_country, $billing_zip, $billing_phone, $billing_company );
			
			$shipping_first_name = $shipping_last_name = $shipping_company = $shipping_address_line_1 = $shipping_address_line_2 = $shipping_city = $shipping_state = $shipping_phone = "";
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_first_name ) )
				$shipping_first_name = $GLOBALS['ec_cart_data']->cart_data->shipping_first_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_last_name ) )
				$shipping_last_name = $GLOBALS['ec_cart_data']->cart_data->shipping_last_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_company_name ) )
				$shipping_company = $GLOBALS['ec_cart_data']->cart_data->shipping_company_name;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 ) )
				$shipping_address_line_1 = $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 ) )
				$shipping_address_line_2 = $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_city ) )
				$shipping_city = $GLOBALS['ec_cart_data']->cart_data->shipping_city;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_state ) )
				$shipping_state = $GLOBALS['ec_cart_data']->cart_data->shipping_state;
			if( isset( $GLOBALS['ec_cart_data']->cart_data->shipping_phone ) )
				$shipping_phone = $GLOBALS['ec_cart_data']->cart_data->shipping_phone;
			$this->user->setup_shipping_info_data( $shipping_first_name, $shipping_last_name, $shipping_address_line_1, $shipping_address_line_2, $shipping_city, $shipping_state, $shipping_country, $shipping_zip, $shipping_phone, $shipping_company );
			
		}
		
		if( isset( $GLOBALS['ec_cart_data']->cart_data->coupon_code ) && $GLOBALS['ec_cart_data']->cart_data->coupon_code != "" ){
			$this->coupon_code = $GLOBALS['ec_cart_data']->cart_data->coupon_code;
			$this->coupon = $GLOBALS['ec_coupons']->redeem_coupon_code( $this->coupon_code );
		}else{
			$this->coupon_code = "";
		}
		
		if( isset( $GLOBALS['ec_cart_data']->cart_data->giftcard ) && $GLOBALS['ec_cart_data']->cart_data->giftcard != "" ){
			$this->gift_card = $GLOBALS['ec_cart_data']->cart_data->giftcard;
			$this->giftcard = $this->mysqli->redeem_gift_card( $this->gift_card );
			if( !$this->giftcard )
				$this->gift_card = "";
		}else{
			$this->gift_card = "";
		}
		// Shipping
		$sales_tax_discount = new ec_discount( $this->cart, $this->cart->discountable_subtotal, 0.00, $this->coupon_code, "", 0 );
		$GLOBALS['wpeasycart_current_coupon_discount'] = $sales_tax_discount->coupon_discount;
		$this->shipping = new ec_shipping( $this->cart->shipping_subtotal, $this->cart->weight, $this->cart->shippable_total_items, 'RADIO', $GLOBALS['ec_user']->freeshipping, $this->cart->length, $this->cart->width, $this->cart->height, $this->cart->cart );
		// Tax (no VAT here)
		$sales_tax_discount = new ec_discount( $this->cart, $this->cart->discountable_subtotal, 0.00, $this->coupon_code, "", 0 );
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal - $sales_tax_discount->coupon_discount, 0, $GLOBALS['ec_user']->shipping->state, $GLOBALS['ec_user']->shipping->country, $GLOBALS['ec_user']->taxfree, $this->shipping->get_shipping_price( ) + $this->cart->get_handling_total( ) );
		// Duty (Based on Product Price) - already calculated in tax
		// Get Total Without VAT, used only breifly
		if( get_option( 'ec_option_no_vat_on_shipping' ) ){
			$total_without_vat_or_discount = $this->cart->vat_subtotal + $this->tax->tax_total + $this->tax->duty_total;
		}else{
			$total_without_vat_or_discount = $this->cart->vat_subtotal + $this->shipping->get_shipping_price( ) + $this->tax->tax_total + $this->tax->duty_total;
		}
		//If a discount used, and no vatable subtotal, we need to set to 0
		if( $total_without_vat_or_discount < 0 )
			$total_without_vat_or_discount = 0;
		// Discount for Coupon
		$this->discount = new ec_discount( $this->cart, $this->cart->discountable_subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $total_without_vat_or_discount );
		// Amount to Apply VAT on
		$promotion = new ec_promotion( );
		$vatable_subtotal = $total_without_vat_or_discount - $this->discount->coupon_discount - $promotion->get_discount_total( $this->cart->subtotal );
		// If for some reason this is less than zero, we should correct
		if( $vatable_subtotal < 0 )
			$vatable_subtotal = 0;
		// Get Tax Again For VAT
		$this->tax = new ec_tax( $this->cart->subtotal, $this->cart->taxable_subtotal - $sales_tax_discount->coupon_discount, $vatable_subtotal, $GLOBALS['ec_user']->shipping->state, $GLOBALS['ec_user']->shipping->country, $GLOBALS['ec_user']->taxfree, $this->shipping->get_shipping_price( ) + $this->cart->get_handling_total( ) );
		// Discount for Gift Card
		$grand_total = ( $this->cart->subtotal + $this->tax->tax_total + $this->shipping->get_shipping_price( ) + $this->tax->duty_total );
		$this->discount = new ec_discount( $this->cart, $this->cart->discountable_subtotal, $this->shipping->get_shipping_price( ), $this->coupon_code, $this->gift_card, $grand_total );
		// Order Totals
		$this->order_totals = new ec_order_totals( $this->cart, $GLOBALS['ec_user'], $this->shipping, $this->tax, $this->discount );
		
		// Credit Card
		if( isset( $_POST['ec_expiration_month'] ) && isset( $_POST['ec_expiration_year'] ) ){
			$exp_month = $_POST['ec_expiration_month'];
			$exp_year = $_POST['ec_expiration_year'];
		
		}else if( isset( $_POST['ec_cc_expiration'] ) ){
			$exp_date = $_POST['ec_cc_expiration'];
			$exp_month = substr( $exp_date, 0, 2 );
			$exp_year = substr( $exp_date, 5 );
			if( strlen( $exp_year ) == 2 ){
				$exp_year = "20" . $exp_year;
			}
		}
		if( isset( $_POST['ec_cart_payment_type'] ) )
			$credit_card = new ec_credit_card( $_POST['ec_cart_payment_type'], stripslashes( $_POST['ec_card_holder_name'] ), $this->sanatize_card_number( $_POST['ec_card_number'] ), $exp_month, $exp_year, $_POST['ec_security_code'] );
		else if( isset( $_POST['ec_card_number'] ) )
			$credit_card = new ec_credit_card( $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) ), stripslashes( $_POST['ec_card_holder_name'] ),  $this->sanatize_card_number( $_POST['ec_card_number'] ), $exp_month, $exp_year, $_POST['ec_security_code'] );
		else
			$credit_card = new ec_credit_card( "", "", "", "", "", "" );
		
		// Payment
		if( isset( $_POST['ec_cart_payment_selection'] ) )
			$this->payment = new ec_payment( $credit_card, $_POST['ec_cart_payment_selection'] );
		else if( $is_affirm )
			$this->payment = new ec_payment( $credit_card, "affirm" );
		else
			$this->payment = new ec_payment( $credit_card, "" );
		
		// Order
		$this->order = new ec_order( $this->cart, $GLOBALS['ec_user'], $this->shipping, $this->tax, $this->discount, $this->order_totals, $this->payment );
		
		$store_page_id = get_option('ec_option_storepage');
		$cart_page_id = get_option('ec_option_cartpage');
		$account_page_id = get_option('ec_option_accountpage');
		
		if( function_exists( 'icl_object_id' ) ){
			$store_page_id = icl_object_id( $store_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$cart_page_id = icl_object_id( $cart_page_id, 'page', true, ICL_LANGUAGE_CODE );
			$account_page_id = icl_object_id( $account_page_id, 'page', true, ICL_LANGUAGE_CODE );
		}
		
		$this->store_page = get_permalink( $store_page_id );
		$this->cart_page = get_permalink( $cart_page_id );
		$this->account_page = get_permalink( $account_page_id );
		
		if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
			$https_class = new WordPressHTTPS( );
			$this->store_page = $https_class->makeUrlHttps( $this->store_page );
			$this->cart_page = $https_class->makeUrlHttps( $this->cart_page );
			$this->account_page = $https_class->makeUrlHttps( $this->account_page );
		}
		
		if( substr_count( $this->cart_page, '?' ) )					$this->permalink_divider = "&";
		else														$this->permalink_divider = "?";
		
		// Subscription Options
		$this->subscription_option1 = $this->subscription_option2 = $this->subscription_option3 = $this->subscription_option4 = $this->subscription_option5 = 0;
			
		if( ( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option1 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option1 != "" ) || 
			( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option2 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option2 != "" ) || 
			( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option3 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option3 != "" ) || 
			( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option4 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option4 != "" ) || 
			( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option5 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option5 != "" ) ){
			
			$optionitem_list = $GLOBALS['ec_options']->get_all_optionitems( );
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option1 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option1 != "" ){
				$this->subscription_option1 = $GLOBALS['ec_cart_data']->cart_data->subscription_option1;
			}
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option2 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option2 != "" ){
				$this->subscription_option2 = $GLOBALS['ec_cart_data']->cart_data->subscription_option2;
			}
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option3 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option3 != "" ){
				$this->subscription_option3 = $GLOBALS['ec_cart_data']->cart_data->subscription_option3;
			}
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option4 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option4 != "" ){
				$this->subscription_option4 = $GLOBALS['ec_cart_data']->cart_data->subscription_option4;
			}
			
			if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_option5 ) && $GLOBALS['ec_cart_data']->cart_data->subscription_option5 != "" ){
				$this->subscription_option5 = $GLOBALS['ec_cart_data']->cart_data->subscription_option5;
			}
			
			foreach( $optionitem_list as $option_item ){
				if( $option_item->optionitem_id == $this->subscription_option1 ){
					$this->subscription_option1_name = $option_item->optionitem_name;
					$this->subscription_option1_label = $option_item->option_label;
				
				}else if( $option_item->optionitem_id == $this->subscription_option2 ){
					$this->subscription_option2_name = $option_item->optionitem_name;
					$this->subscription_option2_label = $option_item->option_label;
				
				}else if( $option_item->optionitem_id == $this->subscription_option3 ){
					$this->subscription_option3_name = $option_item->optionitem_name;
					$this->subscription_option3_label = $option_item->option_label;
				
				}else if( $option_item->optionitem_id == $this->subscription_option4 ){
					$this->subscription_option4_name = $option_item->optionitem_name;
					$this->subscription_option4_label = $option_item->option_label;
				
				}else if( $option_item->optionitem_id == $this->subscription_option5 ){
					$this->subscription_option5_name = $option_item->optionitem_name;
					$this->subscription_option5_label = $option_item->option_label;
				}
			}
			
		}
		
		// Subscription Advanced Options
		if( isset( $GLOBALS['ec_cart_data']->cart_data->subscription_advanced_option ) && $GLOBALS['ec_cart_data']->cart_data->subscription_advanced_option != "" )
			$this->subscription_advanced_options = maybe_unserialize( $GLOBALS['ec_cart_data']->cart_data->subscription_advanced_option );
		else
			$this->subscription_advanced_options = "";
		
		// Check for downloads in cart
		$this->has_downloads = false;
		foreach( $this->cart->cart as $cart_item ){
			if( $cart_item->is_download ){
				$this->has_downloads = true;
				break;
			}
		}
		
	}
	
	public function display_cart_success(){
		$success_notes = array(	"account_created" => $GLOBALS['language']->get_text( "ec_success", "cart_account_created" ) );
		
		if( isset( $_GET['ec_cart_success'] ) ){
			echo "<div class=\"ec_cart_success\"><div>" . $success_notes[ $_GET['ec_cart_success'] ] . "</div></div>";
		}
	}
	
	public function display_cart_error(){
		$error_notes = array( "email_exists" => $GLOBALS['language']->get_text( "ec_errors", "email_exists_error" ),
							  "login_failed" => $GLOBALS['language']->get_text( "ec_errors", "login_failed" ),
							  "3dsecure_failed" => $GLOBALS['language']->get_text( "ec_errors", "3dsecure_failed" ),
							  "manualbill_failed" => $GLOBALS['language']->get_text( "ec_errors", "manualbill_failed" ),
							  "thirdparty_failed" => $GLOBALS['language']->get_text( "ec_errors", "thirdparty_failed" ),
							  "payment_failed" => $GLOBALS['language']->get_text( "ec_errors", "payment_failed" ),
							  "card_error" => $GLOBALS['language']->get_text( "ec_errors", "payment_failed" ),
							  "already_subscribed" => $GLOBALS['language']->get_text( "ec_errors", "already_subscribed" ),
							  "not_activated" => $GLOBALS['language']->get_text( "ec_errors", "not_activated" ),
							  "subscription_not_found" => $GLOBALS['language']->get_text( "ec_errors", "subscription_not_found" ),
							  "user_insert_error" => $GLOBALS['language']->get_text( "ec_errors", "user_insert_error" ),
							  "subscription_added_failed" => $GLOBALS['language']->get_text( "ec_errors", "subscription_added_failed" ),
							  "subscription_failed" => $GLOBALS['language']->get_text( "ec_errors", "subscription_failed" ),
							  "invalid_address" => $GLOBALS['language']->get_text( "ec_errors", "invalid_address" ),
							  "session_expired" => $GLOBALS['language']->get_text( "ec_errors", "session_expired" ),
							  "invalid_vat_number" => $GLOBALS['language']->get_text( "ec_errors", "invalid_vat_number" )   
							);
		if( isset( $_GET['ec_cart_error'] ) ){
			echo "<div class=\"ec_cart_error\"><div>" . $error_notes[ $_GET['ec_cart_error'] ] . "</div></div>";
		}
	}
	
	public function display_cart_page(){
		
		if( get_option( 'ec_option_googleanalyticsid' ) != "UA-XXXXXXX-X" && get_option( 'ec_option_googleanalyticsid' ) != "" ){
			echo "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', '" . get_option( 'ec_option_googleanalyticsid' ) . "', 'auto');
			ga('send', 'pageview');
			ga('require', 'ec');
			
			function ec_google_removeFromCart( model_number, title, quantity, price ){
			  ga('ec:addProduct', {
				'id': model_number,
				'name': title,
				'price': price,
				'quantity': quantity
			  });
			  ga('ec:setAction', 'remove');
			  ga('send', 'event', 'UX', 'click', 'remove from cart');     // Send data using an event.
			}";
			
			// Setup Cart
			for( $i=0; $i < count( $this->cart->cart ); $i++ ){
				echo "
				ga( 'ec:addProduct', {
				  'id': '" . $this->cart->cart[$i]->model_number . "',
				  'name': '" . str_replace( "'", "\'", $this->cart->cart[$i]->title ) . "',
				  'price': '" . $this->cart->cart[$i]->unit_price . "',
				  'quantity': '" . $this->cart->cart[$i]->quantity . "'
				});";
			}
			
			// View of Cart
			if( !isset( $_GET['ec_page'] )  ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 1,
					'option': 'Cart View'
				});
				ga('send', 'pageview');";
			
			// View of Checkout Info
			}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 2,
					'option': 'Checkout Info'
				});
				ga('send', 'pageview');";
			
			// View of Payment Method
			}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 3,
					'option': 'Checkout Payment'
				});
				ga('send', 'pageview');";
			
			// View of thankyou page
			}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
				echo "
				ga('ec:setAction','checkout', {
					'step': 4,
					'option': 'Checkout Success'
				});
				ga('send', 'pageview');";
			
			}
			
			echo "</script>";
		}
		
		echo "<div class=\"ec_cart_page\">";
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			do_action( 'wpeasycart_order_success' );
			$order_id = $_GET['order_id'];
			if( $GLOBALS['ec_cart_data']->cart_data->is_guest ){
				$order_row = $this->mysqli->get_guest_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->guest_key );
			}else{
				$order_row = $this->mysqli->get_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
			}
			$order = new ec_orderdisplay( $order_row, true );
			
			if( $GLOBALS['ec_cart_data']->cart_data->guest_key != "" ){
				$order_details = $this->mysqli->get_guest_order_details( $order_id, $GLOBALS['ec_cart_data']->cart_data->guest_key );
				
			}else{
				$order_details = $this->mysqli->get_order_details( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
			}
			
			$GLOBALS['ec_user']->setup_billing_info_data( $order->billing_first_name, $order->billing_last_name, $order->billing_address_line_1, $order->billing_address_line_2, $order->billing_city, $order->billing_state, $order->billing_country, $order->billing_zip, $order->billing_phone, $order->billing_company_name );
			
			$GLOBALS['ec_user']->setup_shipping_info_data( $order->shipping_first_name, $order->shipping_last_name, $order->shipping_address_line_1, $order->shipping_address_line_2, $order->shipping_city, $order->shipping_state, $order->shipping_country, $order->shipping_zip, $order->shipping_phone, $order->shipping_company_name );
			
			$tax_struct = $this->tax;
			
			$total = $GLOBALS['currency']->get_currency_display( $order->grand_total );
			$subtotal = $GLOBALS['currency']->get_currency_display( $order->sub_total );
			$tax = $GLOBALS['currency']->get_currency_display( $order->tax_total );
			$duty = $GLOBALS['currency']->get_currency_display( $order->duty_total );
			$vat = $GLOBALS['currency']->get_currency_display( $order->vat_total );
			if( ( $order->grand_total - $order->vat_total ) > 0 )
				$vat_rate = number_format( $this->tax->vat_rate, 0, '', '' );
			else
				$vat_rate = number_format( 0, 0, '', '' );
			$shipping = $GLOBALS['currency']->get_currency_display( $order->shipping_total );
			$discount = $GLOBALS['currency']->get_currency_display( $order->discount_total );
			
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg" ) ){
				$email_logo_url = plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg");
				$email_footer_url = plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emailfooter.jpg");
			}else{
				$email_logo_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emaillogo.jpg");
				$email_footer_url = plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_email_receipt/emailfooter.jpg");
			}
			
			//google analytics
			$this->analytics = new ec_googleanalytics($order_details, $order->shipping_total, $order->tax_total , $order->grand_total, $order_id);
			$google_urchin_code = get_option('ec_option_googleanalyticsid');
			$google_wp_url = $_SERVER['SERVER_NAME'];
			$google_transaction = $this->analytics->get_transaction_js();
			$google_items = $this->analytics->get_item_js();
			//end google analytics
			$this->display_cart_error();
			
			//Backwards compatibility for an error... Don't want the button showing if user didn't create an account.
			if( $GLOBALS['ec_cart_data']->cart_data->is_guest != "" && $GLOBALS['ec_cart_data']->cart_data->is_guest )
				$GLOBALS['ec_cart_data']->cart_data->email = "guest";
			
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_success.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_success.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_success.php' );
			
		}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "third_party" ){
			$order_id = $_GET['order_id'];
			
			if( $GLOBALS['ec_cart_data']->cart_data->is_guest != "" && $GLOBALS['ec_cart_data']->cart_data->is_guest ){
				$order = $this->mysqli->get_guest_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->guest_key );
				$order_details = $this->mysqli->get_guest_order_details( $this->order_id, $GLOBALS['ec_cart_data']->cart_data->guest_key );
			}else{
				$order = $this->mysqli->get_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
				$order_details = $this->mysqli->get_order_details( $this->order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
			}
			
			//google analytics
			$this->analytics = new ec_googleanalytics($order_details, $order->shipping_total, $order->tax_total , $order->grand_total, $order_id);
			$google_urchin_code = get_option('ec_option_googleanalyticsid');
			$google_wp_url = $_SERVER['SERVER_NAME'];
			$google_transaction = $this->analytics->get_transaction_js();
			$google_items = $this->analytics->get_item_js();
			//end google analytics
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_third_party.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_third_party.php' );
			
		}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "subscription_info" ){
			
			$this->display_cart_error( );
			
			$subscription_found = false;
			
			if( isset( $_GET['subscription'] ) ){
				
				global $wpdb;
				$model_number = $_GET['subscription'];
				$products = $this->mysqli->get_product_list( $wpdb->prepare( " WHERE product.model_number = %s", $model_number ), "", "", "" );
				if( count( $products ) > 0 ){
					$subscription_found = true;
					$product = new ec_product( $products[0], 0, 1, 0 );
					
					if( !get_option( 'ec_option_subscription_one_only' ) && $GLOBALS['ec_cart_data']->cart_data->subscription_quantity != "" ){ 
						$subscription_quantity = $GLOBALS['ec_cart_data']->cart_data->subscription_quantity;
					}else{ 
						$subscription_quantity = 1; 
					}
					
					// Subscription
					if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription.php' ) )	
						include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_subscription.php' );
					else
						include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_subscription.php' );
				}
				
			}
			
			if( !$subscription_found ){
				echo "No subscription was found to match the model number provided.";
			}
				
		}else{
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_page.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_page.php' );
		}
		echo "</div>";
	}
	
	public function display_cart_process( ){
		if(	$this->cart->total_items > 0 || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ) ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_process.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_process.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_process.php' );
		}
	}
	
	public function display_cart_process_cart_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else{
			echo "<a href=\"" . $this->cart_page . "\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}
	}
	
	public function display_cart_process_shipping_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else{
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}
	}
	
	public function display_cart_process_review_link( $link_text ){
		if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_success" ){
			echo $link_text;
		}else if( $GLOBALS['ec_cart_data']->cart_data->billing_first_name != "" ){
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" class=\"ec_process_bar_link\">" . $link_text . "</a>";
		}else{
			echo $link_text;
		}
	}
	
	public function display_cart( $empty_cart_string ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart.php' );
			
			echo "<input type=\"hidden\" name=\"ec_cart_page\" id=\"ec_cart_page\" value=\"" . $this->cart_page . "\" />";
			echo "<input type=\"hidden\" name=\"ec_cart_base_path\" id=\"ec_cart_base_path\" value=\"" . plugins_url( ) . "\" />";
		}else
			echo $empty_cart_string;
	}
	
	public function display_login(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_login.php' );
		}
	}
	
	public function display_login_complete(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_login_complete.php' );
		}
	}
	
	public function display_subscription_login_complete( ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' ) )	
			include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_login_complete.php' );
		else if( file_exists( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_login_complete.php' ) )
			include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_login_complete.php' );
	}
	
	public function should_display_cart( ){
		// Check minimum order amount
		if( (float) get_option( 'ec_option_minimum_order_total' ) > 0 && (float) get_option( 'ec_option_minimum_order_total' ) > $this->cart->subtotal ){
			return true;
		}else if( apply_filters( 'wpeasycart_restrict_cart_only', false ) ){
			return true;
		}
		
		if( !$this->should_display_login( ) )
			return true;
		else
			return false;
	}
	
	public function should_display_login( ){
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_login" && ( $GLOBALS['ec_cart_data']->cart_data->email == "" || $GLOBALS['ec_cart_data']->cart_data->is_guest == "" || $GLOBALS['ec_cart_data']->cart_data->is_guest ) );
	}
	
	public function payment_processor_requires_billing( ){
		if( get_option( 'ec_option_payment_process_method' ) == "skrill" ){
			return false;	
		}
	}
	
	public function should_hide_shipping_panel(){
		return ( $GLOBALS['ec_cart_data']->cart_data->shipping_selector == "" || ( $GLOBALS['ec_cart_data']->cart_data->shipping_selector != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_selector == "false" ) );
	}
	
	public function should_display_page_one( ){
		// Check minimum order amount
		if( (float) get_option( 'ec_option_minimum_order_total' ) > 0 && (float) get_option( 'ec_option_minimum_order_total' ) > $this->cart->subtotal ){
			return false;
		}else if( apply_filters( 'wpeasycart_restrict_cart_only', false ) ){
			return false;
		}
		
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_info" );
	}
	
	public function display_page_one_form_start(){
		$next_page = "checkout_shipping";
		if( !get_option( 'ec_option_use_shipping' ) || $this->order_totals->shipping_total <= 0 )
			$next_page = "checkout_payment";
		
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page . "\" method=\"POST\" id=\"wpeasycart_checkout_details_form\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"save_checkout_info\" />";
	}
	
	public function display_page_one_form_end(){
		echo "</form>";
	}
	
	public function should_display_page_two( ){
		// Check minimum order amount
		if( (float) get_option( 'ec_option_minimum_order_total' ) > 0 && (float) get_option( 'ec_option_minimum_order_total' ) > $this->cart->subtotal ){
			return false;
		}
		
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_shipping" && $GLOBALS['ec_cart_data']->cart_data->email != "" );
	}
	
	public function display_page_two_form_start(){
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"save_checkout_shipping\" />";
	}
	
	public function display_page_two_form_end(){
		echo "</form>";
		if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){
			echo '<script src="https://secure.ewaypayments.com/scripts/eCrypt.min.js"></script>';
		}
	}
	
	public function should_display_page_three( ){
		// Check minimum order amount
		if( (float) get_option( 'ec_option_minimum_order_total' ) > 0 && (float) get_option( 'ec_option_minimum_order_total' ) > $this->cart->subtotal ){
			return false;
		}
		
		return ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" && $GLOBALS['ec_cart_data']->cart_data->email != "" );
	}
	
	public function display_page_three_form_start(){
		if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){
			echo "<form data-eway-encrypt-key=\"" . get_option( 'ec_option_eway_client_key' ) . "\" action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\" id=\"ec_submit_order_form\">";
		}else{
			echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\" id=\"ec_submit_order_form\">";
		}
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"submit_order\" />";
	}
	
	public function display_page_three_form_end(){
		echo "</form>";
		if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){
			echo "<script src=\"https://secure.ewaypayments.com/scripts/eCrypt.min.js\"></script>";
		}
	}
	
	public function display_subscription_form_start( $model_number ){
		echo "<form action=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_submit_order\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"insert_subscription\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_model_number\" value=\"" . $model_number . "\" />";
	}
	
	public function display_subscription_form_end(){
		echo "</form>";
	}
	
	/* START CART FUNCTIONS */
	public function is_cart_type_one( ){
		return ( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $GLOBALS['ec_cart_data']->cart_data->email == "" ) );
	}
	
	public function is_cart_type_two( ){
		return ( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "checkout_payment" ) || $GLOBALS['ec_cart_data']->cart_data->email == "" );
	}
	
	public function is_cart_type_three( ){
		return ( ( $this->shipping->shipping_method == "live" ) && $this->cart->weight > 0 && ( !isset( $_GET['ec_page'] ) || $GLOBALS['ec_cart_data']->cart_data->email == "" ) );
	}
	
	public function display_total_items( ){
		echo "<span id=\"ec_cart_total_items\">" . $this->cart->get_total_items() . "</span>";
	}
	
	public function display_cart_items( ){
		$this->cart->display_cart_items( $this->tax->vat_enabled, $this->tax->vat_country_match );	
	}
	
	public function has_cart_total_promotion( ){
		if( $this->cart->cart_total_promotion )
			return true;
		else
			return false;
	}
	
	public function display_cart_total_promotion( ){
		echo $this->cart->cart_total_promotion;
	}
	
	public function has_cart_shipping_promotion( ){
		if( $this->shipping->get_shipping_promotion_text( ) )
			return true;
		else
			return false;
	}
	
	public function display_cart_shipping_promotion( ){
		echo $this->shipping->get_shipping_promotion_text();
	}
	
	public function display_shipping_costs_input( $label, $button_text, $label2 = 'Country:', $select_label = 'Select One' ){
		
		if( get_option( 'ec_option_estimate_shipping_country' ) ){
			
			$countries = $GLOBALS['ec_countries']->countries;
			
			if( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country != "" )
				$selected_country = $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country;
			else if( count( $countries ) == 1 )
				$selected_country = $countries[0]->iso2_cnt;
			else if( get_option( 'ec_option_default_country' ) )
				$selected_country = get_option( 'ec_option_default_country' );
			else
				$selected_country = "0";
			
			echo "<div class=\"ec_estimate_shipping_country\"><span>" . $label2 . "</span><select name=\"ec_cart_country\" id=\"ec_cart_country\">";
			echo "<option value=\"0\"";
			if( $selected_country == "0" )
				echo " selected=\"selected\"";
			echo ">" . $select_label . "</option>";
			foreach( $countries as $country ){
				echo "<option value=\"" . $country->iso2_cnt . "\"";
				if( $country->iso2_cnt == $selected_country )
					echo " selected=\"selected\"";
				echo ">" . $country->name_cnt . "</option>";
			}
			echo "</select></div>";
		}else{
			echo "<input type=\"hidden\" name=\"ec_cart_country\" id=\"ec_cart_country\" value=\"0\" />";
		}
		echo "<div class=\"ec_estimate_shipping_zip\"><span>" . $label . "</span><input type=\"text\" name=\"ec_cart_zip_code\" id=\"ec_cart_zip_code\" value=\"";
		if( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip != "" )
			echo $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip;
		echo "\" /><a href=\"#\" onclick=\"return ec_estimate_shipping_click();\">" . $button_text . "</a></div>";
	}
	
	public function display_estimate_shipping_country_select( ){
		
		$countries = $GLOBALS['ec_countries']->countries;
			
		if( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country != "" )
			$selected_country = $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country;
		else if( count( $countries ) == 1 )
			$selected_country = $countries[0]->iso2_cnt;
		else if( get_option( 'ec_option_default_country' ) )
			$selected_country = get_option( 'ec_option_default_country' );
		else
			$selected_country = "0";
		
		echo "<select name=\"ec_estimate_country\" id=\"ec_estimate_country\">";
		echo "<option value=\"0\""; if( $selected_country == "0" ){ echo " selected=\"selected\""; } echo ">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_select_one' ) . "</option>";
		foreach( $countries as $country ){
			echo "<option value=\"" . $country->iso2_cnt . "\"";
			if( $country->iso2_cnt == $selected_country )
				echo " selected=\"selected\"";
			echo ">" . $country->name_cnt . "</option>";
		}
		echo "</select>";
	}
	
	public function display_shipping_costs_input_text( $label ){
		echo "<span>" . $label . "</span><input type=\"text\" name=\"ec_cart_zip_code\" id=\"ec_cart_zip_code\" value=\"";
		if( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip != "" )
			echo $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip;
		echo "\" />";
	}
	
	public function display_shipping_costs_input_button( $button_text ){
		echo "<a href=\"#\" onclick=\"return ec_estimate_shipping_click();\">" . $button_text . "</a>";
	}
	
	public function display_estimate_shipping_loader( ){
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_estimate_shipping_loader\" id=\"ec_estimate_shipping_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
		else
			echo "<div class=\"ec_estimate_shipping_loader\" id=\"ec_estimate_shipping_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
	}
	
	public function display_subtotal( ){
		echo "<span id=\"ec_cart_subtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total ) . "</span>";	
	}
	
	public function get_subtotal( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->sub_total );
	}
	
	public function display_tax_total( ){
		echo "<span id=\"ec_cart_tax\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total ) . "</span>";	
	}
	
	public function get_tax_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->tax_total );	
	}
	
	public function has_duty( ){
		if ( $this->tax->duty_total > 0 )			return true;
		else										return false;	
	}
	
	public function display_duty_total( ){
		echo "<span id=\"ec_cart_duty\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total ) . "</span>";	
	}
	
	public function get_duty_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->duty_total );	
	}
	
	public function get_vat_total( ){
		return $this->tax->vat_total;
	}
	
	public function get_vat_total_formatted( ){
		return $GLOBALS['currency']->get_currency_display( $this->tax->vat_total );
	}
	
	public function display_vat_total( ){
		echo "<span id=\"ec_cart_vat\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->vat_total ) . "</span>";	
	}
	
	public function display_shipping_total( ){
		echo "<span id=\"ec_cart_shipping\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total ) . "</span>";
	}
	
	public function get_shipping_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->shipping_total );
	}
	
	public function display_discount_total( ){
		echo "<span id=\"ec_cart_discount\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->discount_total ) . "</span>";
	}
	
	public function get_discount_total( ){
		return $GLOBALS['currency']->get_currency_display( (-1) * $this->order_totals->discount_total );
	}
	
	public function get_gst_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->gst_total );	
	}
	
	public function get_pst_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->pst_total );	
	}
	
	public function get_hst_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->hst_total );	
	}
	
	public function display_grand_total( ){
		echo "<span id=\"ec_cart_grandtotal\">" . $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ) . "</span>"; 	
	}
	
	public function get_grand_total( ){
		return $GLOBALS['currency']->get_currency_display( $this->order_totals->grand_total ); 	
	}
	
	public function display_continue_shopping_button( $button_text ){
		echo "<a href=\"" . $this->store_page;
		
		echo "\" class=\"ec_cart_continue_shopping_link\">" . $button_text . "</a>";
	}
	
	public function display_checkout_button( $button_text ){
		$checkout_page = "checkout_login";
		if( $GLOBALS['ec_cart_data']->cart_data->email != "" ){
			$checkout_page = "checkout_info";
			
		}else if( get_option( 'ec_option_skip_cart_login' ) ){
			$checkout_page = "checkout_info";
			$GLOBALS['ec_cart_data']->cart_data->email = "guest";
			$GLOBALS['ec_cart_data']->cart_data->username = "guest";
		}
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) )
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=" . $checkout_page . "\" class=\"ec_cart_checkout_link\">" . $button_text . "</a>";
		else
			echo "<a href=\"" . $this->cart_page . "\" class=\"ec_cart_checkout_link\">" . $button_text . "</a>";
	}
	/* END CART FUNCTIONS */

	// Forward the page to the cart page minus form submission with success note
	private function forward_cart_success(){
		
	}
	
	// Forward the page to the last product page, plus a failed note
	private function forward_product_failed(){
		
	}
	
	/* Login Form Functions */
	public function display_cart_login_form_start(){
		echo "<form action=\"". $this->cart_page . "\" method=\"post\">";	
	}
	
	public function display_cart_login_form_start_subscription( ){
		echo "<form action=\"". $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_GET['subscription'] . "\" method=\"post\">";
	}
	
	public function display_cart_login_form_end(){
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"hidden\" name=\"ec_cart_subscription\" value=\"" . $_GET['subscription'] . "\" />";
		}
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"login_user\" />";
		echo "</form>";
	}
	
	public function display_cart_login_form_guest_start(){
		echo "<form action=\"". $this->cart_page . "\" method=\"post\">";
	}
	
	public function display_cart_login_form_guest_end(){
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"hidden\" name=\"ec_cart_subscription\" value=\"" . $_GET['subscription'] . "\" />";
		}
		echo "<input type=\"hidden\" name=\"ec_cart_form_action\" value=\"login_user\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_login_email\" value=\"guest\" />";
		echo "<input type=\"hidden\" name=\"ec_cart_login_password\" value=\"guest\" />";
		echo "</form>";
	}
	
	public function display_cart_login_email_input(){
		echo "<input type=\"email\" id=\"ec_cart_login_email\" name=\"ec_cart_login_email\" class=\"ec_cart_login_input\" autocorrect=\"off\" autocapitalize=\"off\" />";
	}
	
	public function display_cart_login_password_input(){
		echo "<input type=\"password\" id=\"ec_cart_login_password\" name=\"ec_cart_login_password\" class=\"ec_cart_login_input\" />";
	}
	
	public function display_cart_login_login_button( $input ){
		echo "<input type=\"submit\" id=\"ec_cart_login_login_button\" name=\"ec_cart_login_login_button\" class=\"ec_cart_login_button\" value=\"" . $input . "\" />";
	}
	
	public function display_cart_login_forgot_password_link( $link_text ){
		echo "<a href=\"" . $this->account_page . $this->permalink_divider . "ec_page=forgot_password\" class=\"ec_cart_login_complete_logout_link\">" . $link_text . "</a>";
	}
	
	public function display_cart_login_guest_button( $input ){
		echo "<input type=\"submit\" id=\"ec_cart_login_guest_button\" name=\"ec_cart_login_guest_button\" class=\"ec_cart_login_button\" value=\"" . $input . "\" />";
	}
	
	public function display_cart_login_complete_user_name( $input ){
		echo "<input type=\"hidden\" id=\"ec_cart_login_guest_text\" value=\"" . $input . "\" /><span id=\"ec_cart_login_complete_username\">";
		if( $GLOBALS['ec_cart_data']->cart_data->username != "guest" )			echo $GLOBALS['ec_cart_data']->cart_data->username;
		else														echo $input;
		echo "</span>";
	}
	
	public function display_cart_login_complete_signout_link( $input ){
		if( isset( $_GET['subscription'] ) ){
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_cart_action=logout&subscription=" . $_GET['subscription'] . "\" class=\"ec_cart_login_complete_logout_link\">" . $input . "</a>";
		}else{
			echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_cart_action=logout\" class=\"ec_cart_login_complete_logout_link\">" . $input . "</a>";
		}
	}
	
	/* END LOGIN/LOGOUT FUNCTIONS */
	
	/* START BILLING FUNCTIONS */
	public function display_checkout_details( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_checkout_details.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_checkout_details.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_checkout_details.php' );
		}
	}
	
	public function display_billing(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_billing.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_billing.php' );
		}
	}
	
	public function display_billing_input( $name ){
		
		if( $name == "country" ){
			
			if( get_option( 'ec_option_use_country_dropdown' ) ){
				
				// DISPLAY COUNTRY DROP DOWN MENU
				$countries = $GLOBALS['ec_countries']->countries;
				if( $GLOBALS['ec_cart_data']->cart_data->billing_country != "" && $GLOBALS['ec_cart_data']->cart_data->billing_country != "" && $GLOBALS['ec_cart_data']->cart_data->billing_country != "0"  )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->billing_country;
				else if( $GLOBALS['ec_user']->billing->get_value( "country2" ) != 0 )
					$selected_country = $GLOBALS['ec_user']->billing->get_value( "country2" );
				else if( count( $countries ) == 1 )
					$selected_country = $countries[0]->iso2_cnt;
				else if( get_option( 'ec_option_default_country' ) )
					$selected_country = get_option( 'ec_option_default_country' );
				else
					$selected_country = $GLOBALS['ec_user']->billing->get_value( "country2" );
				
				echo "<select name=\"ec_cart_billing_country\" id=\"ec_cart_billing_country\" class=\"ec_cart_billing_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_country" ) . "</option>";
				foreach($countries as $country){
					echo "<option value=\"" . $country->iso2_cnt . "\"";
					if( $country->iso2_cnt == $selected_country )
						echo " selected=\"selected\"";
					echo ">" . $country->name_cnt . "</option>";
				}
				echo "</select>";
			}else{
				// DISPLAY COUNTRY TEXT INPUT
				if( $GLOBALS['ec_cart_data']->cart_data->billing_country && $GLOBALS['ec_cart_data']->cart_data->billing_country != "" && $GLOBALS['ec_cart_data']->cart_data->billing_country != "0"  )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->billing_country;
				else
					$selected_country = $GLOBALS['ec_user']->billing->get_value( "country" );
					
				echo "<input type=\"text\" name=\"ec_cart_billing_country\" id=\"ec_cart_billing_country\" class=\"ec_cart_billing_input_text\" value=\"" . htmlspecialchars( $selected_country, ENT_QUOTES ) . "\" />";
			}
		}else if( $name == "state" ){
			
			if( get_option( 'ec_option_use_smart_states' ) ){
			
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "0"  )
					$selected_state = $GLOBALS['ec_cart_data']->cart_data->billing_state;
				else
					$selected_state = $GLOBALS['ec_user']->billing->get_value( "state" );
					
				if( $GLOBALS['ec_cart_data']->cart_data->billing_country != "" && $GLOBALS['ec_cart_data']->cart_data->billing_country != "" && $GLOBALS['ec_cart_data']->cart_data->billing_country != "0"  )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->billing_country;
				else
					$selected_country = $GLOBALS['ec_user']->billing->get_value( "country2" );
				
				$current_country = "";
				$close_last_state = false;
				$state_found = false;
				$current_state_group = "";
				$close_last_state_group = false;
				
				foreach($states as $state){ if( $state->iso2_cnt ){
					if( $current_country != $state->iso2_cnt ){
						if( $close_last_state ){
							echo "</select>";
						}
						echo "<select name=\"ec_cart_billing_state_" . $state->iso2_cnt . "\" id=\"ec_cart_billing_state_" . $state->iso2_cnt . "\" class=\"ec_cart_billing_input_text ec_billing_state_dropdown\"";
						if( $state->iso2_cnt != $selected_country ){
							echo " style=\"display:none;\"";
						}else{
							$state_found = true;
						}
						echo ">";
						
						if( $state->iso2_cnt == "CA" ){ // Canada
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_province" ) . "</option>";
						}else if( $state->iso2_cnt == "GB" ){ // United Kingdom
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_county" ) . "</option>";
						}else if( $state->iso2_cnt == "US" ){ //USA 
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_state" ) . "</option>";
						}else{
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_other" ) . "</option>";
						}
						
						$current_country = $state->iso2_cnt;
						$close_last_state = true;
					}
					
					if( $current_state_group != $state->group_sta && $state->group_sta != "" ){
						if( $close_last_state_group ){
							echo "</optgroup>";
						}
						echo "<optgroup label=\"" . $state->group_sta . "\">";
						$current_state_group = $state->group_sta;
						$close_last_state_group = true;
					}
					
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				} }
				
				if( $close_last_state_group ){
					echo "</optgroup>";
				}
				
				echo "</select>";
				
				// DISPLAY STATE TEXT INPUT	
				echo "<input type=\"text\" name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\" value=\"" . htmlspecialchars( $selected_state, ENT_QUOTES ) . "\"";
				if( $state_found ){
					echo " style=\"display:none;\"";
				}
				echo " />";
				
			}else{
				// Use the basic method of old
				if( get_option( 'ec_option_use_state_dropdown' ) ){
					// DISPLAY STATE DROP DOWN MENU
					$states = $this->mysqli->get_states( );
					if( $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "0"  )
						$selected_state = $GLOBALS['ec_cart_data']->cart_data->billing_state;
					else
						$selected_state = $GLOBALS['ec_user']->billing->get_value( "state" );
					
					echo "<select name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\">";
					echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_billing_information", "cart_billing_information_select_state" ) . "</option>";
					foreach($states as $state){
						echo "<option value=\"" . $state->code_sta . "\"";
						if( $state->code_sta == $selected_state )
							echo " selected=\"selected\"";
						echo ">" . $state->name_sta . "</option>";
					}
					echo "</select>";
				}else{
					// DISPLAY STATE TEXT INPUT
					if( $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "" && $GLOBALS['ec_cart_data']->cart_data->billing_state != "0"  )
						$selected_state = $GLOBALS['ec_cart_data']->cart_data->billing_state;
					else
						$selected_state = $GLOBALS['ec_user']->billing->get_value( "state" );
						
					echo "<input type=\"text\" name=\"ec_cart_billing_state\" id=\"ec_cart_billing_state\" class=\"ec_cart_billing_input_text\" value=\"" . htmlspecialchars( $selected_state, ENT_QUOTES ) . "\" />";
				}
			}// Close if/else for state display type
			
		}else{
		
			$value = $GLOBALS['ec_user']->billing->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_billing_" . $name . "\" id=\"ec_cart_billing_" . $name . "\" class=\"ec_cart_billing_input_text\" value=\"" . htmlspecialchars( $value, ENT_QUOTES ) . "\" />";
			
		}
	}
	
	public function display_vat_registration_number_input( ){
		$name = "vat_registration_number";
		$value = $GLOBALS['ec_user']->vat_registration_number;
		echo "<input type=\"text\" name=\"ec_cart_billing_" . $name . "\" id=\"ec_cart_billing_" . $name . "\" class=\"ec_cart_billing_input_text\" value=\"" . htmlspecialchars( $value, ENT_QUOTES ) . "\" />";
	}
	/* END BILLING FUNCTIONS */
	
	/* START SHIPPING FUNCTIONS */
	public function display_shipping(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_shipping.php' );
		}
	}
	
	public function display_shipping_selector( $first_opt, $second_opt ){
		if( $this->cart->shipping_subtotal > 0 )
			echo "<div class=\"ec_cart_shipping_selector_row\">";
		else
			echo "<div class=\"ec_cart_shipping_selector_row_hidden\">";
			
		echo "<input type=\"radio\" name=\"ec_shipping_selector\" id=\"ec_cart_use_billing_for_shipping\" value=\"false\"";
		if( $GLOBALS['ec_cart_data']->cart_data->shipping_selector == "" || ( $GLOBALS['ec_cart_data']->cart_data->shipping_selector != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_selector == "false" ) )
		echo " checked=\"checked\"";
		echo " onchange=\"ec_cart_use_billing_for_shipping_change(); return false;\" />" . $first_opt;
		echo "</div>";
		
		if( get_option( 'ec_option_use_shipping' ) ){
			if( $this->cart->shipping_subtotal > 0 )
				echo "<div class=\"ec_cart_shipping_selector_row\">";
			else
				echo "<div class=\"ec_cart_shipping_selector_row_hidden\">";
			
			echo "<input type=\"radio\" name=\"ec_shipping_selector\" id=\"ec_cart_use_shipping_for_shipping\" value=\"true\"";
			if( $GLOBALS['ec_cart_data']->cart_data->shipping_selector != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_selector == "true" )
			echo " checked=\"checked\"";
			echo " onchange=\"ec_cart_use_shipping_for_shipping_change(); return false;\" />" . $second_opt;
			echo "</div>";
		}else{
			echo "<script>jQuery('.ec_cart_shipping_selector_row').hide();</script>";	
		}
	}
	
	public function display_shipping_input( $name ){
		
		if( $name == "country" ){
			
			if( get_option( 'ec_option_use_country_dropdown' ) ){
				
				// DISPLAY COUNTRY DROP DOWN MENU
				$countries = $GLOBALS['ec_countries']->countries;
				if( $GLOBALS['ec_cart_data']->cart_data->shipping_country != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_country != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_country != 0 )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->shipping_country;
				else if( $GLOBALS['ec_user']->shipping->get_value( "country2" ) != 0 )
					$selected_country = $GLOBALS['ec_user']->shipping->get_value( "country2" );
				else if( count( $countries ) == 1 )
					$select_label = $countries[0]->iso2_cnt;
				else if( get_option( 'ec_option_default_country' ) )
					$selected_country = get_option( 'ec_option_default_country' );
				else
					$selected_country = $GLOBALS['ec_user']->shipping->get_value( "country2" );
				
				echo "<select name=\"ec_cart_shipping_country\" id=\"ec_cart_shipping_country\" class=\"ec_cart_shipping_input_text\">";
				echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_country" ) . "</option>";
				foreach($countries as $country){
					echo "<option value=\"" . $country->iso2_cnt . "\"";
					if( $country->iso2_cnt == $selected_country )
					echo " selected=\"selected\"";
					echo ">" . $country->name_cnt . "</option>";	
				}
				echo "</select>";
			}else{
				// DISPLAY STATE TEXT INPUT
				if( $GLOBALS['ec_cart_data']->cart_data->shipping_country != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_country != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_country != 0 )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->shipping_country;
				else
					$selected_country = $GLOBALS['ec_user']->shipping->get_value( "country" );
					
				echo "<input type=\"text\" name=\"ec_cart_shipping_country\" id=\"ec_cart_shipping_country\" class=\"ec_cart_shipping_input_text\" value=\"" . htmlspecialchars( $selected_country, ENT_QUOTES ) . "\" />";
			}
		}else if( $name == "state" ){
			
			if( get_option( 'ec_option_use_smart_states' ) ){ // Use new method
				// DISPLAY STATE DROP DOWN MENU
				$states = $this->mysqli->get_states( );
				if( $GLOBALS['ec_cart_data']->cart_data->shipping_state != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_state != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_state != 0 )
					$selected_state = $GLOBALS['ec_cart_data']->cart_data->shipping_state;
				else
					$selected_state = $GLOBALS['ec_user']->shipping->get_value( "state" );
					
				if( $GLOBALS['ec_cart_data']->cart_data->shipping_country != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_country != 0 )
					$selected_country = $GLOBALS['ec_cart_data']->cart_data->shipping_country;
				else
					$selected_country = $GLOBALS['ec_user']->shipping->get_value( "country2" );
				
				$current_country = "";
				$close_last_state = false;
				$state_found = false;
				$current_state_group = "";
				$close_last_state_group = false;
				
				foreach($states as $state){
					if( $current_country != $state->iso2_cnt ){
						if( $close_last_state ){
							echo "</select>";
						}
						echo "<select name=\"ec_cart_shipping_state_" . $state->iso2_cnt . "\" id=\"ec_cart_shipping_state_" . $state->iso2_cnt . "\" class=\"ec_cart_shipping_input_text ec_shipping_state_dropdown\"";
						if( $state->iso2_cnt != $selected_country ){
							echo " style=\"display:none;\"";
						}else{
							$state_found = true;
						}
						echo ">";
						
						if( $state->iso2_cnt == "CA" ){ // Canada
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_province" ) . "</option>";
						}else if( $state->iso2_cnt == "GB" ){ // United Kingdom
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_county" ) . "</option>";
						}else if( $state->iso2_cnt == "US" ){ //USA 
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_state" ) . "</option>";
						}else{
							echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_other" ) . "</option>";
						}
						
						$current_country = $state->iso2_cnt;
						$close_last_state = true;
					}
					
					if( $current_state_group != $state->group_sta && $state->group_sta != "" ){
						if( $close_last_state_group ){
							echo "</optgroup>";
						}
						echo "<optgroup label=\"" . $state->group_sta . "\">";
						$current_state_group = $state->group_sta;
						$close_last_state_group = true;
					}
					
					echo "<option value=\"" . $state->code_sta . "\"";
					if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
					echo ">" . $state->name_sta . "</option>";
				}
				
				if( $close_last_state_group ){
					echo "</optgroup>";
				}
				
				echo "</select>";
				
				// DISPLAY STATE TEXT INPUT	
				echo "<input type=\"text\" name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\" value=\"" . htmlspecialchars( $selected_state, ENT_QUOTES ) . "\"";
				if( $state_found ){
					echo " style=\"display:none;\"";
				}
				echo " />";
				
			}else{// Use old method
				
				if( get_option( 'ec_option_use_state_dropdown' ) ){
					// DISPLAY STATE DROP DOWN MENU
					$states = $this->mysqli->get_states( );
					if( $GLOBALS['ec_cart_data']->cart_data->shipping_state != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_state != 0 )
						$selected_state = $GLOBALS['ec_cart_data']->cart_data->shipping_state;
					else
						$selected_state = $GLOBALS['ec_user']->shipping->get_value( "state" );
					
					echo "<select name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\">";
					echo "<option value=\"0\">" . $GLOBALS['language']->get_text( "cart_shipping_information", "cart_shipping_information_select_state" ) . "</option>";
					foreach($states as $state){
						echo "<option value=\"" . $state->code_sta . "\"";
						if( $state->code_sta == $selected_state )
						echo " selected=\"selected\"";
						echo ">" . $state->name_sta . "</option>";
					}
					echo "</select>";
				}else{
					// DISPLAY STATE TEXT INPUT
					if( $GLOBALS['ec_cart_data']->cart_data->shipping_state != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_state != 0 )
						$selected_state = $GLOBALS['ec_cart_data']->cart_data->shipping_state;
					else
						$selected_state = $GLOBALS['ec_user']->shipping->get_value( "state" );
						
					echo "<input type=\"text\" name=\"ec_cart_shipping_state\" id=\"ec_cart_shipping_state\" class=\"ec_cart_shipping_input_text\" value=\"" . htmlspecialchars( $selected_state, ENT_QUOTES ) . "\" />";
				}
				
			}// Close if/else for state display type
			
		}else{
			$value = $GLOBALS['ec_user']->shipping->get_value( $name );
			
			echo "<input type=\"text\" name=\"ec_cart_shipping_" . $name . "\" id=\"ec_cart_shipping_" . $name . "\" class=\"ec_cart_shipping_input_text\" value=\"" . htmlspecialchars( $value, ENT_QUOTES ) . "\" />";
		}
	}
	/* END SHIPPING FUNCTIONS */
	
	/* START SHIPPING METHOD FUNCTIONS */
	public function display_shipping_method( ){
		if(	$this->cart->total_items > 0 ){
			
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_shipping_method.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_shipping_method.php' );
		}
	}
	
	public function ec_cart_display_shipping_methods( $standard_text, $express_text, $ship_method ){
		$shipping_options = $this->shipping->get_shipping_options( $standard_text, $express_text );	
		if( $shipping_options )
			echo $shipping_options;
		else if( $GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip != "" )
			echo "<div class=\"ec_cart_shipping_method_row\">" . $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_error' ) . "</div>";
	}
	/* END SHIPPING METHOD FUNCTIONS */
	
	/* START COUPON FUNCTIONS */
	public function display_coupon( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_coupon.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_coupon.php' );
		}
	}
	
	public function display_coupon_input( $redeem_text ){
		echo "<input type=\"text\" name=\"ec_cart_coupon_code\" id=\"ec_cart_coupon_code\" class=\"ec_cart_coupon_input_text\" value=\"";
		if( $this->coupon_code != "" )
			echo $this->coupon_code;
		echo "\" /><div class=\"ec_cart_coupon_code_redeem_button\"><a href=\"#\" onclick=\"ec_cart_coupon_code_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_coupon_input_text( ){
		echo "<input type=\"text\" name=\"ec_cart_coupon_code\" id=\"ec_cart_coupon_code\" class=\"ec_cart_coupon_input_text\" value=\"";
		if( $this->coupon_code != "" )
			echo $this->coupon_code;
		
		echo "\" />";
	}
	
	public function display_coupon_input_button( $redeem_text ){
		echo "<div class=\"ec_cart_coupon_code_redeem_button\"><a href=\"#\" onclick=\"ec_cart_coupon_code_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_coupon_loader( ){
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_cart_coupon_loader\" id=\"ec_cart_coupon_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";	
		else
			echo "<div class=\"ec_cart_coupon_loader\" id=\"ec_cart_coupon_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
	}
	
	public function display_coupon_message( ){
		if( isset( $this->coupon ) )
			echo $this->coupon->message;
		else if( $this->coupon_code != "" )
			echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_coupon' );
	}
	/* END COUPON FUNCTIONS */
	
	/* START GIFT CARD FUNCTIONS */
	public function display_gift_card( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_gift_card.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_gift_card.php' );
		}
	}
	
	public function display_gift_card_input( $redeem_text ){
		echo "<input type=\"text\" name=\"ec_cart_gift_card\" id=\"ec_cart_gift_card\" class=\"ec_cart_gift_card_input_text\" value=\"";
		if( $this->gift_card != "" )
			echo $this->gift_card;
		echo "\" /><div class=\"ec_cart_gift_card_redeem_button\"><a href=\"#\" onclick=\"ec_cart_gift_card_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_gift_card_input_text( ){
		echo "<input type=\"text\" name=\"ec_cart_gift_card\" id=\"ec_cart_gift_card\" class=\"ec_cart_gift_card_input_text\" value=\"";
		if( $this->gift_card != "" )
			echo $this->gift_card;
			
		echo "\" />";
	}
	
	public function display_gift_card_input_button( $redeem_text ){
		echo "<div class=\"ec_cart_gift_card_redeem_button\"><a href=\"#\" onclick=\"ec_cart_gift_card_redeem(); return false;\">" . $redeem_text . "</a></div>";
	}
	
	public function display_gift_card_loader( ){
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) )	
			echo "<div class=\"ec_cart_gift_card_loader\" id=\"ec_cart_gift_card_loader\"><img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
		else
			echo "<div class=\"ec_cart_gift_card_loader\" id=\"ec_cart_gift_card_loader\"><img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_page/loader.gif" ) . "\" /></div>";
		
	}
	
	public function display_gift_card_message( ){
		if( isset( $this->giftcard ) )
			echo $this->giftcard->message;
		else if( $this->gift_card != "" )
			echo $GLOBALS['language']->get_text( 'cart_coupons', 'cart_invalid_giftcard' );
	}
	/* END GIFT CARD FUNCTIONS */
	
	public function display_continue_to_shipping_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_continue_to_shipping_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_info( );\" />";
	}
	
	/* START CONTINUE TO PAYMENT FUNCTIONS */
	public function display_continue_to_payment_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_continue_to_payment_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_shipping( );\" />";
	}
	/* END CONTINUE TO PAYMENT FUNCTIONS */
	
	public function display_submit_order_button( $button_text ){
		
		if( isset( $_GET['subscription'] ) ){
			echo "<input type=\"submit\" id=\"ec_submit_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_subscription_order();\" />";
		}else{
			echo "<input type=\"submit\" id=\"ec_submit_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_validate_checkout_submit_order();\" />";
		}
		
	}
	
	public function display_cancel_order_button( $button_text ){
		echo "<input type=\"button\" id=\"ec_cancel_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"return ec_cart_cancel_order();\" />";
	}
	
	public function display_order_review_button( $button_text ){
		echo "<input type=\"button\" id=\"ec_review_payment_button\" class=\"ec_cart_submit_order_button\" value=\"" . $button_text . "\" onclick=\"if( ec_cart_validate_checkout_submit_order( ) ){ ec_cart_show_review_panel( ); } return false;\" />";
	}
	
	/* START ADDRESS REVIEW FUNCTIONS */
	public function display_address_review(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_address_review.php' );
			else	
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_address_review.php' );
		}
		
		if( !get_option( 'ec_option_use_shipping' ) )
			echo "<script>jQuery('.ec_cart_address_review_middle').html('');</script>";
	}
	
	public function display_edit_address_link( $link_text ){
		echo "<a href=\"" . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info\">" . $link_text . "</a>";	
	}
	
	public function display_review_billing( $name ){
		if( $name == "first_name" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_first_name, ENT_QUOTES );
		else if( $name == "last_name" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_last_name, ENT_QUOTES );
		else if( $name == "address" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_address_line_1, ENT_QUOTES );
		else if( $name == "address2" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_address_line_2, ENT_QUOTES );
		else if( $name == "city" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_city, ENT_QUOTES );
		else if( $name == "state" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_state, ENT_QUOTES );
		else if( $name == "zip" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_zip, ENT_QUOTES );
		else if( $name == "country" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_country, ENT_QUOTES );
		else if( $name == "phone" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->billing_phone, ENT_QUOTES );
		
	}
	
	public function has_billing_address_line2( ){
		if( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	public function display_review_shipping( $name ){
		if( $name == "first_name" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_first_name, ENT_QUOTES );
		else if( $name == "last_name" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_last_name, ENT_QUOTES );
		else if( $name == "address" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1, ENT_QUOTES );
		else if( $name == "address2" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2, ENT_QUOTES );
		else if( $name == "city" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_city, ENT_QUOTES );
		else if( $name == "state" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_state, ENT_QUOTES );
		else if( $name == "zip" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_zip, ENT_QUOTES );
		else if( $name == "country" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_country, ENT_QUOTES );
		else if( $name == "phone" )
			echo htmlspecialchars( $GLOBALS['ec_cart_data']->cart_data->shipping_phone, ENT_QUOTES );
	}
	
	public function has_shipping_address_line2( ){
		if( $GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	public function display_selected_shipping_method( ){
		echo $this->shipping->get_selected_shipping_method();
	}
	/* END ADDRESS REVIEW FUNCTIONS */
	
	/* START PAYMENT INFORMATION FUNCTIONS */
    public function display_payment( ){
		if(	$this->cart->total_items > 0 ){
			if( get_option( 'ec_option_payment_third_party' ) == "paypal_advanced" ){ 
				$this->payment->show_paypal_iframe( $this->order_totals->grand_total );
			}else if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_payment.php' );
		}
	}
	
    public function display_payment_information( ){
    	if(	$this->cart->total_items > 0 && $this->order_totals->grand_total > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_payment_information.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_payment_information.php' );
			
			echo "<script>jQuery(\"input[name=ec_cart_payment_selection][value='" . get_option( 'ec_option_default_payment_type' ) . "']\").attr('checked', 'checked');";
			if( get_option( 'ec_option_default_payment_type' ) == "manual_bill" ){
				echo "jQuery('#ec_cart_pay_by_manual_payment').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "affirm" ){
				echo "jQuery('#ec_cart_pay_by_affirm').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "third_party" ){
				echo "jQuery('#ec_cart_pay_by_third_party').show();";
			}else if( get_option( 'ec_option_default_payment_type' ) == "credit_card" ){
				echo "jQuery('#ec_cart_pay_by_credit_card_holder').show();";
			}
			echo "</script>";
		}
	}
	
	public function use_manual_payment( ){
		if( get_option( 'ec_option_use_direct_deposit' ) )
			return true;
		else
			return false;
	}
	
	public function display_manual_payment_text( ){
		echo nl2br( $GLOBALS['language']->convert_text( get_option( 'ec_option_direct_deposit_message' ) ) );
	}
	
	public function use_third_party( ){
		if( get_option( 'ec_option_payment_third_party' ) )
			return true;
		else
			return false;
	}
	
	public function ec_cart_display_third_party_form_start( ){
		$this->payment->third_party->initialize( $_GET['order_id'] );
		$this->payment->third_party->display_form_start( );
	}
	
	public function ec_cart_display_third_party_form_end( ){
		echo "</form>";
	}
	
	public function display_third_party_submit_button( $button_text ){
		echo "<input type=\"submit\" class=\"ec_cart_submit_third_party\" value=\"" . $button_text . "\" />";
	}
	
	public function ec_cart_display_current_third_party_name( ){
		if( get_option( 'ec_option_payment_third_party' ) == "2checkout_thirdparty" )
			echo "2Checkout";
		else if( get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" )
			echo "Dwolla";
		else if( get_option( 'ec_option_payment_third_party' ) == "nets" )
			echo "Nets Netaxept";
		else if( get_option( 'ec_option_payment_third_party' ) == "payfort" )
			echo "Payfort";
		else if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			echo "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "sagepay_paynow_za" )
			echo "SagePay Pay Now";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			echo "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			echo "Realex Payments";
		else if( get_option( 'ec_option_payment_third_party' ) == "redsys" )
			echo "Redsys";
		else if( get_option( 'ec_option_payment_third_party' ) == "paymentexpress_thirdparty" )
			echo "Payment Express";
		else
			echo get_option( 'ec_option_custom_third_party' );
	}
	
	public function ec_cart_get_current_third_party_name( ){
		if( get_option( 'ec_option_payment_third_party' ) == "dwolla_thirdparty" )
			return "Dwolla";
		else if( get_option( 'ec_option_payment_third_party' ) == "nets" )
			return "Nets Netaxept";
		else if( get_option( 'ec_option_payment_third_party' ) == "paypal" )
			return "PayPal";
		else if( get_option( 'ec_option_payment_third_party' ) == "sagepay_paynow_za" )
			echo "SagePay Pay Now";
		else if( get_option( 'ec_option_payment_third_party' ) == "skrill" )
			return "Skrill";
		else if( get_option( 'ec_option_payment_third_party' ) == "realex_thirdparty" )
			return "Realex Payments";
		else if( get_option( 'ec_option_payment_third_party' ) == "redsys" )
			return "Redsys";
		else if( get_option( 'ec_option_payment_third_party' ) == "paymentexpress_thirdparty" )
			return "Payment Express";
		else
			return get_option( 'ec_option_custom_third_party' );
	}
	
	public function ec_cart_display_third_party_logo( ){
		if( get_option( 'ec_option_payment_third_party' ) == "paypal" ){
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg" ) )	
				echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg" ) . "\" alt=\"PayPal\" />";
			else
				echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/paypal.jpg") . "\" alt=\"PayPal\" />";
		}else if( get_option( 'ec_option_payment_third_party' ) == "skrill" ){
			if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/layout/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif" ) )	
				echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif" ) . "\" alt=\"Skrill\" />";
			else
				echo "<img src=\"" . plugins_url( EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/skrill-logo.gif") . "\" alt=\"Skrill\" />";
		}
	}
	
	public function use_payment_gateway( ){
		if( get_option( 'ec_option_payment_process_method' ) )
			return true;
		else
			return false;
	}
	
	public function ec_cart_display_credit_card_images(){
		//display credit card icons
		if( get_option('ec_option_use_visa') || get_option('ec_option_use_delta') || get_option('ec_option_use_uke') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visa.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_visa\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visa_inactive.png") . "\" alt=\"Visa\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_visa_inactive\" />";
		
		/*
		if( get_option('ec_option_use_delta') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visadebit.png") . "\" alt=\"Visa Debit\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_delta\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visadebit_inactive.png") . "\" alt=\"Visa Debit\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_delta_inactive\" />";
			
		if( get_option('ec_option_use_uke') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visaelectron.png") . "\" alt=\"Visa Electron\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_uke\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/visaelectron_inactive.png") . "\" alt=\"Visa Electron\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_uke_inactive\" />";
		*/
		
		if( get_option('ec_option_use_discover') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/discover.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_discover\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/discover_inactive.png") . "\" alt=\"Discover\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_discover_inactive\" />";
		
		if( get_option('ec_option_use_mastercard') || get_option('ec_option_use_mcdebit') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/mastercard.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_mastercard\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/mastercard_inactive.png") . "\" alt=\"Mastercard\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_mastercard_inactive\" />";
		
		if( get_option('ec_option_use_amex') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/american_express.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_amex\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/american_express_inactive.png") . "\" alt=\"AMEX\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_amex_inactive\" />";
		
		if( get_option('ec_option_use_jcb') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/jcb.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_jcb\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/jcb_inactive.png") . "\" alt=\"JCB\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_jcb_inactive\" />";
		
		if( get_option('ec_option_use_diners') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/diners.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_diners\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/diners_inactive.png") . "\" alt=\"Diners\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_diners_inactive\" />";
		
		/*
		if( get_option('ec_option_use_laser') )
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/laser.png") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_laser\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/laser_inactive.png") . "\" alt=\"Laser\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_laser_inactive\" />";
		*/
		
		if( get_option('ec_option_use_maestro') || get_option('ec_option_use_laser'))
			echo "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/maestro.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_active\" id=\"ec_cart_payment_credit_card_icon_maestro\" />" . "<img src=\"" . plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ec_cart_payment_information/maestro_inactive.png") . "\" alt=\"Maestro\" class=\"ec_cart_payment_information_credit_card_inactive\" id=\"ec_cart_payment_credit_card_icon_maestro_inactive\" />";
		
		
	}
	
	public function ec_cart_display_payment_method_input( $select_one_text ){
		echo "<select name=\"ec_cart_payment_type\" id=\"ec_cart_payment_type\" class=\"ec_cart_payment_information_input_select\">";
		
		echo "<option value=\"0\">" . $select_one_text . "</option>";
		
		if( get_option('ec_option_use_visa') )
		echo "<option value=\"visa\">Visa</option>";
		
		if( get_option('ec_option_use_delta') )
		echo "<option value=\"delta\">Visa Debit/Delta</option>";
		
		if( get_option('ec_option_use_uke') )
		echo "<option value=\"uke\">Visa Electron</option>";
		
		if( get_option('ec_option_use_discover') )
		echo "<option value=\"discover\">Discover</option>";
		
		if( get_option('ec_option_use_mastercard') )
		echo "<option value=\"mastercard\">Mastercard</option>";
		
		if( get_option('ec_option_use_mcdebit') )
		echo "<option value=\"mcdebit\">Debit Mastercard</option>";
		
		if( get_option('ec_option_use_amex') )
		echo "<option value=\"amex\">American Express</option>";
		
		if( get_option('ec_option_use_jcb') )
		echo "<option value=\"jcb\">JCB</option>";
		
		if( get_option('ec_option_use_diners') )
		echo "<option value=\"diners\">Diners</option>";
		
		if( get_option('ec_option_use_laser') )
		echo "<option value=\"laser\">Laser</option>";
		
		if( get_option('ec_option_use_maestro') )
		echo "<option value=\"maestro\">Maestro</option>";
		
		echo "</select>";
	}
	
	public function ec_cart_display_card_holder_name_input(){
		echo "<input type=\"text\" name=\"ec_card_holder_name\" id=\"ec_card_holder_name\" class=\"ec_cart_payment_information_input_text\" value=\"\" />";
	}
	
	public function ec_cart_display_card_holder_name_hidden_input(){
		echo "<input type=\"hidden\" name=\"ec_card_holder_name\" id=\"ec_card_holder_name\" class=\"ec_cart_payment_information_input_text\" value=\"" . htmlspecialchars( $GLOBALS['ec_user']->billing->first_name, ENT_QUOTES ) . " " . htmlspecialchars( $GLOBALS['ec_user']->billing->last_name, ENT_QUOTES ) . "\" />";
	}
	
	public function ec_cart_display_card_number_input(){
		if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){
			echo "<input type=\"text\" name=\"ec_card_number\" data-eway-encrypt-name=\"ec_card_number\" id=\"ec_card_number\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
		}else{
			echo "<input type=\"text\" name=\"ec_card_number\" id=\"ec_card_number\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
		}
	}
	
	public function ec_cart_display_card_expiration_month_input( $select_text ){
		echo "<select name=\"ec_expiration_month\" id=\"ec_expiration_month\" class=\"ec_cart_payment_information_input_select\" autocomplete=\"off\">";
		echo "<option value=\"0\">" . $select_text . "</option>";
		for( $i=1; $i<=12; $i++ ){
			echo "<option value=\"";
			if( $i<10 )										$month = "0" . $i;
			else											$month = $i;
			echo $month . "\">" . $month . "</option>";
		}
		echo "</select>";
	}
	
	public function ec_cart_display_card_expiration_year_input( $select_text ){
		echo "<select name=\"ec_expiration_year\" id=\"ec_expiration_year\" class=\"ec_cart_payment_information_input_select\" autocomplete=\"off\">";
		echo "<option value=\"0\">" . $select_text . "</option>";
		for( $i=date( 'Y' ); $i < date( 'Y' ) + 15; $i++ ){
			echo "<option value=\"" . $i . "\">" . $i . "</option>";	
		}
		echo "</select>";
	}
	
	public function ec_cart_display_card_security_code_input(){
		if( get_option( 'ec_option_payment_process_method' ) == "eway" && get_option( 'ec_option_eway_use_rapid_pay' ) ){
			echo "<input type=\"text\" name=\"ec_security_code\" data-eway-encrypt-name=\"ec_security_code\" id=\"ec_security_code\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
		}else{
			echo "<input type=\"text\" name=\"ec_security_code\" id=\"ec_security_code\" class=\"ec_cart_payment_information_input_text\" value=\"\" autocomplete=\"off\" />";
		}
	}
	/* END PAYMENT INFORMATION FUNCTIONS */
    
	/* START CONTACT INFORMATION FUNCTIONS */
    public function display_contact_information(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' ) )	
				include( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_contact_information.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_contact_information.php' );
		}
	}
	
	public function ec_cart_display_contact_first_name_input(){
		if( $GLOBALS['ec_cart_data']->cart_data->first_name != "" )
			$first_name = $GLOBALS['ec_cart_data']->cart_data->first_name;
		else
			$first_name = $GLOBALS['ec_user']->first_name;
			
		if( $first_name == "guest" )
			$first_name = "";
			
		echo "<input type=\"text\" name=\"ec_contact_first_name\" id=\"ec_contact_first_name\" class=\"ec_cart_contact_information_input_text\" value=\"" . htmlspecialchars( $first_name, ENT_QUOTES ) . "\" />";
	}
	
	public function ec_cart_display_contact_last_name_input(){
		if( $GLOBALS['ec_cart_data']->cart_data->last_name != "" )
			$last_name = $GLOBALS['ec_cart_data']->cart_data->last_name;
		else
			$last_name = $GLOBALS['ec_user']->last_name;
			
		if( $last_name == "guest" )
			$last_name = "";
			
		echo "<input type=\"text\" name=\"ec_contact_last_name\" id=\"ec_contact_last_name\" class=\"ec_cart_contact_information_input_text\" value=\"" . htmlspecialchars( $last_name, ENT_QUOTES ) . "\" />";
	}
	
	public function ec_cart_display_contact_email_input(){
		if( $GLOBALS['ec_cart_data']->cart_data->email != "" )
			$email = $GLOBALS['ec_cart_data']->cart_data->email;
		else
			$email = $GLOBALS['ec_user']->email;
			
		if( $email == "guest" )
			$email = "";
			
		echo "<input type=\"text\" name=\"ec_contact_email\" id=\"ec_contact_email\" class=\"ec_cart_contact_information_input_text\" value=\"" . htmlspecialchars( $email, ENT_QUOTES ) . "\" />";
	}
	
	public function ec_cart_display_contact_email_retype_input(){
		if( $GLOBALS['ec_cart_data']->cart_data->email != "" )
			$email = $GLOBALS['ec_cart_data']->cart_data->email;
		else
			$email = $GLOBALS['ec_user']->email;
			
		if( $email == "guest" )
			$email = "";
			
		echo "<input type=\"text\" name=\"ec_contact_email_retype\" id=\"ec_contact_email_retype\" class=\"ec_cart_contact_information_input_text\" value=\"" . htmlspecialchars( $email, ENT_QUOTES ) . "\" />";
	}
	
	public function ec_cart_display_contact_create_account_box( ){
		echo "<input type=\"checkbox\" name=\"ec_contact_create_account\" id=\"ec_contact_create_account\" onchange=\"ec_contact_create_account_change( );\"";
		if( $GLOBALS['ec_cart_data']->cart_data->create_account != "" )
			echo " checked=\checked\"";
		echo " />";
		
		if( !get_option( 'ec_option_allow_guest' ) ){
			echo "<script>jQuery('#ec_contact_create_account').hide(); jQuery('#ec_contact_create_account').attr('checked', true);
</script>";
		}
	}
	
	public function ec_cart_display_contact_password_input( ){
		echo "<input type=\"password\" name=\"ec_contact_password\" id=\"ec_contact_password\" class=\"ec_cart_contact_information_input_text\" />";
	}
	
	public function ec_cart_display_contact_password_retype_input( ){
		echo "<input type=\"password\" name=\"ec_contact_password_retype\" id=\"ec_contact_password_retype\" class=\"ec_cart_contact_information_input_text\" />";
	}
	
	public function ec_cart_display_contact_is_subscriber_input( ){
		echo "<input type=\"checkbox\" name=\"ec_contact_is_subscriber\" id=\"ec_contact_is_subscriber\" />";
	}
	/* END CONTACT INFORMATION FUNCTIONS */
	
	/* START SUBMIT ORDER DISPLAY FUNCTIONS */
    public function display_submit_order(){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' ) )	
				include( WP_PLUGIN_DIR . "/" . 'wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_submit_order.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_submit_order.php' );
		}
	}
	
	public function display_customer_order_notes( ){
		if( get_option( 'ec_option_user_order_notes' ) ){
			echo "<div class=\"ec_cart_payment_information_title\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_title' ) . "</div>";
			echo "<div class=\"ec_cart_submit_order_message\">" . $GLOBALS['language']->get_text( 'cart_payment_information', 'cart_payment_information_order_notes_message' ) . "</div>";	
			echo "<div class=\"ec_cart_payment_information_row\"><textarea name=\"ec_order_notes\" id=\"ec_order_notes\">";
			if( $GLOBALS['ec_cart_data']->cart_data->order_notes != "" )
				echo $GLOBALS['ec_cart_data']->cart_data->order_notes;
			
			echo "</textarea></div><hr />";
		}
	}
	
	public function display_order_finalize_panel( ){
		if(	$this->cart->total_items > 0 ){
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_finalize_order.php' ) )	
				include( WP_PLUGIN_DIR . "/" . 'wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_cart_finalize_order.php' );
			else
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_cart_finalize_order.php' );
		}
	}
	
	public function display_ajax_loader( $img ){
		echo "<img src=\"" .  plugins_url( "wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/ajax-loader.gif" ) . "\" class=\"ec_cart_final_loader\" />";
	}
	/* END SUBMIT ORDER DISPLAY FUNCTIONS */
	
	/* START SUCCESS PAGE FUNCTIONS */
	public function display_print_receipt_link( $link_text, $order_id ){
		if( substr_count( $this->account_page, '?' ) )				$permalink_divider = "&";
		else														$permalink_divider = "?";
		
		if( $GLOBALS['ec_cart_data']->cart_data->is_guest == "" ){
			echo "<a href=\"" . $this->account_page . $permalink_divider . "ec_page=print_receipt&order_id=" . $order_id . "\" target=\"_blank\">" . $link_text . "</a>";
		}else{
			echo "<a href=\"" . $this->account_page . $permalink_divider . "ec_page=print_receipt&order_id=" . $order_id . "&guest_key=" . $GLOBALS['ec_cart_data']->cart_data->guest_key . "\" target=\"_blank\">" . $link_text . "</a>";
		}
	}
	
	public function get_printer_icon( $image_name ){
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/theme/' . get_option( 'ec_option_base_theme' ) . '/images/' . $image_name ) )	
			return plugins_url( 'wp-easycart-data/design/theme/' . get_option( 'ec_option_base_themet' ) . '/images/' . $image_name );
		else
			return plugins_url( EC_PLUGIN_DIRECTORY . '/design/theme/' . get_option( 'ec_option_latest_theme' ) . '/images/' . $image_name );
	}
	
	public function display_success_account_create_form_start( $order_id, $email ){
		echo "<form action=\"" . $this->account_page . $this->permalink_divider . "ec_page=order_details&order_id=" . $order_id . "\" method=\"POST\">";
		echo "<input type=\"hidden\" value=\"order_create_account\" name=\"ec_account_form_action\" />";
		echo "<input type=\"hidden\" value=\"" . $order_id . "\" name=\"order_id\" />";
		echo "<input type=\"hidden\" value=\"" . $email . "\" name=\"email_address\" />";
	}
	
	public function display_success_create_password( ){
		echo "<input type=\"password\" name=\"ec_password\" id=\"ec_password\" />";
	}
	
	public function display_success_verify_password( ){
		echo "<input type=\"password\" name=\"ec_verify_password\" id=\"ec_verify_password\" />";
	}
	
	public function display_success_account_create_submit_button( $button_text ){
		echo "<input type=\"submit\" value=\"" . $button_text . "\" onclick=\"return ec_check_success_passwords( );\" />";
	}
	
	public function display_success_account_create_form_end( ){
		echo "</form>";
	}
	/* END SUCCESS PAGE FUNCTIONS */
	
	/* START FORM PROCESSING FUNCTIONS */
	// Process the cart page form action
	public function process_form_action( $action ){
		if( $action == "add_to_cart" )								$this->process_add_to_cart();
		else if( $action == "add_to_cart_v3" )						$this->process_add_to_cart_v3( );
		else if( $action == "ec_update_action" )					$this->process_update_cartitem( $_POST['ec_update_cartitem_id'], $_POST['ec_cartitem_quantity_' . $_POST['ec_update_cartitem_id'] ] );
		else if( $action == "ec_delete_action" )					$this->process_delete_cartitem( $_POST['ec_delete_cartitem_id'] );
		else if( $action == "submit_order" )						$this->process_submit_order();
		else if( $action == "3dsecure" )							$this->process_3dsecure_response();
		else if( $action == "3ds" )									$this->process_3ds_response();
		else if( $action == "3dsprocess" )							$this->process_3ds_final();
		else if( $action == "third_party_forward" )					$this->process_third_party_forward();
		else if( $action == "login_user" )							$this->process_login_user();
		else if( $action == "save_checkout_info" )					$this->process_save_checkout_info();
		else if( $action == "save_checkout_shipping" )				$this->process_save_checkout_shipping();
		else if( $action == "logout" )								$this->process_logout_user();
		else if( $action == "realex_redirect" )						$this->process_realex_redirect( );
		else if( $action == "realex_response" )						$this->process_realex_response( );
		else if( $action == "paymentexpress_thirdparty_response" )	$this->process_paymentexpress_thirdparty_response( );
		else if( $action == "purchase_subscription" )				$this->process_purchase_subscription( );
		else if( $action == "insert_subscription" )					$this->process_insert_subscription( );
		else if( $action == "send_inquiry" )						$this->process_send_inquiry( );
		else if( $action == "deconetwork_add_to_cart" )				$this->process_deconetwork_add_to_cart( );
		else if( $action == "subscribe_v3" )						$this->process_subscribe_v3( );
		else if( $action == "process_update_subscription_quantity" )$this->process_update_subscription_quantity( );
	}
	
	// Process the add to cart form submission
	private function process_add_to_cart(){
		
		if( !$this->check_quantity( $_POST['product_id'], $_POST['product_quantity'] ) ){
			header( "location: " . $this->store_page . $this->permalink_divider . "model_number=" . $_POST['model_number'] . "&ec_store_error=minquantity" );
			
		}else{
			
			//add_to_cart_replace Hook
			if( isset( $GLOBALS['ec_hooks']['add_to_cart_replace'] ) ){
				$class_args = array( "cart_page" => $this->cart_page, "permalink_divider" => $this->permalink_divider );
				for( $i=0; $i<count( $GLOBALS['ec_hooks']['add_to_cart_replace'] ); $i++ ){
					ec_call_hook( $GLOBALS['ec_hooks']['add_to_cart_replace'][$i], $class_args );
				}
			}else{
				//Product Info
				$session_id = $GLOBALS['ec_cart_data']->ec_cart_id;
				$product_id = $_POST['product_id'];
				if( isset( $_POST['product_quantity'] ) )
					$quantity = $_POST['product_quantity'];
				else
					$quantity = 1;
				
				$model_number = stripslashes( $_POST['model_number'] );
				
				//Optional Gift Card Info
				$gift_card_message = "";
				if( isset( $_POST['ec_gift_card_message'] ) )
					$gift_card_message = stripslashes( $_POST['ec_gift_card_message'] );
				
				$gift_card_to_name = "";
				if( isset( $_POST['ec_gift_card_to_name'] ) )
					$gift_card_to_name = stripslashes( $_POST['ec_gift_card_to_name'] );
				
				$gift_card_from_name = "";
				if( isset( $_POST['ec_gift_card_from_name'] ) )
					$gift_card_from_name = stripslashes( $_POST['ec_gift_card_from_name'] );
				
				// Optional Donation Price
				$donation_price = 0.000;
				if( isset( $_POST['ec_product_input_price'] ) )
					$donation_price = $_POST['ec_product_input_price'];
				
				$use_advanced_optionset = false;
				//Product Options
				if( isset( $_POST['ec_use_advanced_optionset'] ) && $_POST['ec_use_advanced_optionset'] ){
					$option1 = "";
					$option2 = "";
					$option3 = "";
					$option4 = "";
					$option5 = "";
					$use_advanced_optionset = true;
				}else{
					$option1 = "";
					if( isset( $_POST['ec_option1'] ) )
						$option1 = $_POST['ec_option1'];
					
					$option2 = "";
					if( isset( $_POST['ec_option2'] ) )
						$option2 = $_POST['ec_option2'];
					
					$option3 = "";
					if( isset( $_POST['ec_option3'] ) )
						$option3 = $_POST['ec_option3'];
					
					$option4 = "";
					if( isset( $_POST['ec_option4'] ) )
						$option4 = $_POST['ec_option4'];
					
					$option5 = "";
					if( isset( $_POST['ec_option5'] ) )
						$option5 = $_POST['ec_option5'];
						
				}
				
				$tempcart_id = $this->mysqli->add_to_cart( $product_id, $session_id, $quantity, $option1, $option2, $option3, $option4, $option5, $gift_card_message, $gift_card_to_name, $gift_card_from_name, $donation_price, $use_advanced_optionset, false );
				
				$option_vals = array( );
				// Now insert the advanced option set tempcart table if needed
				if( $use_advanced_optionset ){
					
					$optionsets = $GLOBALS['ec_advanced_optionsets']->get_advanced_optionsets( $product_id );
					$grid_quantity = 0;
					
					foreach( $optionsets as $optionset ){
						if( $optionset->option_type == "checkbox" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) ){
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "grid" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
									$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id], "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "combo" || $optionset->option_type == "swatch" || $optionset->option_type == "radio" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								if( $optionitem->optionitem_id == $_POST['ec_option_' . $optionset->option_id] ){
									$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $optionitem->optionitem_name, "optionitem_model_number" => $optionitem->optionitem_model_number );
								}
							}
						}else if( $optionset->option_type == "file" ){
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => $_FILES['ec_option_' . $optionset->option_id]['name'], "optionitem_model_number" => $optionitem->optionitem_model_number );
							}
						}else{
							$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
							foreach( $optionitems as $optionitem ){
								$option_vals[] = array( "option_id" => $optionset->option_id, "optionitem_id" => $optionitem->optionitem_id, "option_name" => $optionitem->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionitem->option_type, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
							}
						}
						
						if( $optionset->option_type == "file" ){
							//upload the file
							$this->upload_customer_file( $tempcart_id, 'ec_option_' . $optionset->option_id );
						}
					}
				}
				
				for( $i=0; $i<count( $option_vals ); $i++ ){
					$this->mysqli->add_option_to_cart( $tempcart_id, $GLOBALS['ec_cart_data']->ec_cart_id, $option_vals[$i] );
				}
				
				if( $grid_quantity > 0 ){
					$this->mysqli->update_tempcart_grid_quantity( $tempcart_id, $grid_quantity );
				}
				
				if( get_option( 'ec_option_addtocart_return_to_product' ) ){
					$return_url = $_SERVER['HTTP_REFERER'];
					$return_url = str_replace( "ec_store_success=addtocart", "", $return_url );
					$divider = "?";
					if( substr_count( $return_url, '?' ) )
						$divider = "&";
					
					do_action( 'wpeasycart_cart_updated' );
					
					
					header( "location: " . $return_url . $divider . "ec_store_success=addtocart&model=" . $_POST['model_number'] );
				}else{
					header( "location: " . $this->cart_page );
				}
			}
		}
	}
	
	private function send_inquiry( $product ){
			
		$inquiry_name = "";
		$inquiry_email = "";
		$inquiry_message = "";
		$send_copy = false;
		$has_product_options = false;
		
		if( isset( $_POST['ec_inquiry_name'] ) )			$inquiry_name = stripslashes( $_POST['ec_inquiry_name'] );
		if( isset( $_POST['ec_inquiry_email'] ) )			$inquiry_email = filter_var( stripslashes( $_POST['ec_inquiry_email'] ), FILTER_SANITIZE_EMAIL );
		if( isset( $_POST['ec_inquiry_message'] ) )			$inquiry_message = stripslashes( $_POST['ec_inquiry_message'] );
		if( isset( $_POST['ec_inquiry_send_copy'] ) )		$send_copy = true;
		
		//Product Options
		$option1 = $option2 = $option3 = $option4 = $option5 = "";
		$optionitem_list = $GLOBALS['ec_options']->optionitems;
		
		if( !$product->use_advanced_optionset ){
			
			if( isset( $_POST['ec_option1'] ) )				$option1 = $_POST['ec_option1'];
			if( isset( $_POST['ec_option2'] ) )				$option2 = $_POST['ec_option2'];
			if( isset( $_POST['ec_option3'] ) )				$option3 = $_POST['ec_option3'];
			if( isset( $_POST['ec_option4'] ) )				$option4 = $_POST['ec_option4'];
			if( isset( $_POST['ec_option5'] ) )				$option5 = $_POST['ec_option5'];
			
			if( isset( $_POST['ec_option1'] ) || isset( $_POST['ec_option2'] ) || isset( $_POST['ec_option3'] ) || isset( $_POST['ec_option4'] ) || isset( $_POST['ec_option5'] ) ){
				$has_product_options = true;
			}
			
		}
		
		foreach( $optionitem_list as $optionitem ){
			if( $option1 == $optionitem->optionitem_id ){
				$option1 = $optionitem->optionitem_name;
			}else if( $option2 == $optionitem->optionitem_id ){
				$option2 = $optionitem->optionitem_name;
			}else if( $option3 == $optionitem->optionitem_id ){
				$option3 = $optionitem->optionitem_name;
			}else if( $option4 == $optionitem->optionitem_id ){
				$option4 = $optionitem->optionitem_name;
			}else if( $option5 == $optionitem->optionitem_id ){
				$option5 = $optionitem->optionitem_name;
			}
		}
		
		if( $product->use_advanced_optionset ){
			$tempcart_id = rand( 0, 99999999 );
			$option_vals = $this->get_advanced_option_vals( $product->product_id, $tempcart_id );
		}
		
		// send inquiry
		// Create mail script
		$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
		
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=utf-8";
		$headers[] = "From: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
		$headers[] = "Reply-To: " . $inquiry_email;
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		ob_start();
		if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php' ) )	
			include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';	
		else
			include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_inquiry_email.php';
		$message = ob_get_clean();
		
		if( get_option( 'ec_option_use_wp_mail' ) ){
			if( $send_copy )
				wp_mail( $inquiry_email, "New Product Inquiry", $message, implode("\r\n", $headers) );
			
			wp_mail( stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), "New Product Inquiry", $message, implode("\r\n", $headers) );
		}else{
			$admin_email = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
			$to = $inquiry_email;
			$subject = "New Product Inquiry";
			$mailer = new wpeasycart_mailer( );
			if( $send_copy )
				$mailer->send_order_email( $to, $subject, $message );
			$mailer->send_order_email( $admin_email, $subject, $message );
		}
		
		header( "location: " . $this->store_page . $this->permalink_divider . "model_number=" . $product->model_number . "&ec_store_success=inquiry_sent" );
		// return to previous url with success message.
			
	}
	
	private function get_advanced_option_vals( $product_id, $tempcart_id ){
		
		$option_vals = array( );
		$optionsets = $GLOBALS['ec_advanced_optionsets']->get_advanced_optionsets( $product_id );
		$grid_quantity = 0;
		
		foreach( $optionsets as $optionset ){
			
			$optionitems = $optionset->option_items;
			
			if( $optionset->option_type == "checkbox" ){
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) ){
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "grid" ){
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
						$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id], "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "combo" || $optionset->option_type == "swatch" || $optionset->option_type == "radio" ){
				foreach( $optionitems as $optionitem ){
					if( $optionitem->optionitem_id == $_POST['ec_option_' . $optionset->option_id] ){
						$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $optionitem->optionitem_name, "optionitem_model_number" => $optionitem->optionitem_model_number );
					}
				}
			
			}else if( $optionset->option_type == "file" ){
				foreach( $optionitems as $optionitem ){
					$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $_FILES['ec_option_' . $optionset->option_id]['name'], "optionitem_model_number" => $optionitem->optionitem_model_number );
				}
			
			}else if( $optionset->option_type == "dimensions1" || $optionset->option_type == "dimensions2" ){
				foreach( $optionitems as $optionitem ){
					
					$vals = array( );
					$vals[] = $_POST['ec_option_' . $optionset->option_id . '_width'];
					
					if( isset( $_POST['ec_option_' . $optionset->option_id . '_sub_width'] ) ){
						$vals[] = $_POST['ec_option_' . $optionset->option_id . '_sub_width'];
						
					}
					
					$vals[] = $_POST['ec_option_' . $optionset->option_id . '_height'];
					
					if( isset( $_POST['ec_option_' . $optionset->option_id . '_sub_height'] ) ){
						$vals[] = $_POST['ec_option_' . $optionset->option_id . '_sub_height'];
						
					}
					
					$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => $vals, "optionitem_model_number" => $optionitem->optionitem_model_number );
					
				}
				
			}else{
				foreach( $optionitems as $optionitem ){
					$option_vals[] = array( "option_id" => $optionset->option_id, "option_label" => $optionset->option_label, "option_name" => $optionset->option_name, "optionitem_name" => $optionitem->optionitem_name, "option_type" => $optionset->option_type, "optionitem_id" => $optionitem->optionitem_id, "optionitem_value" => stripslashes( $_POST['ec_option_' . $optionset->option_id] ), "optionitem_model_number" => $optionitem->optionitem_model_number );
				}
			}
			
			if( $optionset->option_type == "file" ){
				//upload the file
				$this->upload_customer_file( $tempcart_id, 'ec_option_' . $optionset->option_id );
			}
		}
		return $option_vals;
		
	}
	
	private function get_grid_quantity( $product_id, $tempcart_id ){
		
		$optionsets = $GLOBALS['ec_advanced_optionsets']->get_advanced_optionsets( $product_id );
		$grid_quantity = 0;
		foreach( $optionsets as $optionset ){
			
			if( $optionset->option_type == "grid" ){
				$optionitems = $this->mysqli->get_advanced_optionitems( $optionset->option_id );
				foreach( $optionitems as $optionitem ){
					if( isset( $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] ) && $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id] > 0 ){
						$grid_quantity = $grid_quantity + $_POST['ec_option_' . $optionset->option_id . "_" . $optionitem->optionitem_id];
					}
				}
			}
		}
		return $grid_quantity;
		
	}
	
	private function process_add_to_cart_v3( ){
		
		$cart_id = $GLOBALS['ec_cart_data']->ec_cart_id;
		$product_id = $_POST['product_id'];
		
		$product = $this->mysqli->get_product( "", $product_id );
		
		if( $product->inquiry_mode ){
			
			$this->send_inquiry( $product );
			
		}else if( $product->is_subscription_item ){ // && !class_exists( "ec_stripe" ) ){
			
		}else{
		
			if( isset( $_POST['ec_quantity'] ) )				$quantity = $_POST['ec_quantity'];
			else												$quantity = 1;
			
			//Optional Gift Card Info
			$gift_card_message = "";
			if( isset( $_POST['ec_giftcard_message'] ) )		$gift_card_message = stripslashes( $_POST['ec_giftcard_message'] );
			
			$gift_card_to_name = "";
			if( isset( $_POST['ec_giftcard_to_name'] ) )		$gift_card_to_name = stripslashes( $_POST['ec_giftcard_to_name'] );
			
			$gift_card_from_name = "";
			if( isset( $_POST['ec_giftcard_from_name'] ) )		$gift_card_from_name = stripslashes( $_POST['ec_giftcard_from_name'] );
			
			$gift_card_email = "";
			if( isset( $_POST['ec_giftcard_to_email'] ) )		$gift_card_email = stripslashes( $_POST['ec_giftcard_to_email'] );
			
			// Optional Donation Price
			$donation_price = 0.000;
			if( isset( $_POST['ec_donation_amount'] ) )			$donation_price = $_POST['ec_donation_amount'];
			
			$use_advanced_optionset = 							$product->use_advanced_optionset;
			
			//Product Options
			$option1 = $option2 = $option3 = $option4 = $option5 = "";
			if( !$use_advanced_optionset ){
				
				if( isset( $_POST['ec_option1'] ) )				$option1 = $_POST['ec_option1'];
				if( isset( $_POST['ec_option2'] ) )				$option2 = $_POST['ec_option2'];
				if( isset( $_POST['ec_option3'] ) )				$option3 = $_POST['ec_option3'];
				if( isset( $_POST['ec_option4'] ) )				$option4 = $_POST['ec_option4'];
				if( isset( $_POST['ec_option5'] ) )				$option5 = $_POST['ec_option5'];
				
			}
			
			$tempcart_id = $this->mysqli->add_to_cart( $product_id, $cart_id, $quantity, $option1, $option2, $option3, $option4, $option5, $gift_card_message, $gift_card_to_name, $gift_card_from_name, $donation_price, $use_advanced_optionset, false, $gift_card_email );
			
			// Now insert the advanced option set tempcart table if needed
			if( $use_advanced_optionset ){
				
				$option_vals = $this->get_advanced_option_vals( $product_id, $tempcart_id );
				$grid_quantity = $this->get_grid_quantity( $product_id, $tempcart_id );
			
				for( $i=0; $i<count( $option_vals ); $i++ ){
					$this->mysqli->add_option_to_cart( $tempcart_id, $cart_id, $option_vals[$i] );
				}
				
				if( $grid_quantity > 0 ){
					$this->mysqli->update_tempcart_grid_quantity( $tempcart_id, $grid_quantity );
				}
				
			}
				
			do_action( 'wpeasycart_cart_updated' );
			
			if( get_option( 'ec_option_addtocart_return_to_product' ) ){
				$return_url = $_SERVER['HTTP_REFERER'];
				$return_url = str_replace( "ec_store_success=addtocart", "", $return_url );
				$divider = "?";
				if( substr_count( $return_url, '?' ) )
					$divider = "&";
				
				header( "location: " . $return_url . $divider . "ec_store_success=addtocart&model=" . $product->model_number );
			
			}else{
				header( "location: " . $this->cart_page );
			
			}
			
		}
		
	}
	
	private function check_quantity( $product_id, $quantity ){
		
		global $wpdb;
		$min_quantity = $wpdb->get_var( $wpdb->prepare( "SELECT ec_product.min_purchase_quantity FROM ec_product WHERE ec_product.product_id = %d", $product_id ) );
		
		if( $min_quantity > 0 ){
			$current_amount = $quantity;
			foreach( $this->cart->cart as $cartitem ){
				if( $cartitem->product_id == $product_id ){
					$current_amount = $current_amount + $cartitem->quantity;
				}
			}
			
			if( $min_quantity <= $current_amount ){
				return true;
				
			}else{
				return false;
				
			}
		
		
		}else{
			return true;
		}
		
	}
	
	private function process_update_cartitem( $cartitem_id, $new_quantity ){
		$this->mysqli->update_cartitem( $cartitem_id, $GLOBALS['ec_cart_data']->ec_cart_id, $new_quantity );
		
		do_action( 'wpeasycart_cart_updated' );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . htmlspecialchars( $_GET['ec_page'], ENT_QUOTES ) );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function process_delete_cartitem( $cartitem_id ){
		$this->mysqli->delete_cartitem( $cartitem_id, $GLOBALS['ec_cart_data']->ec_cart_id );
		
		do_action( 'wpeasycart_cart_updated' );
		
		if( isset( $_GET['ec_page'] ) )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . htmlspecialchars( $_GET['ec_page'], ENT_QUOTES ) );	
		else
			header( "location: " . $this->cart_page );
	}
	
	private function validate_submit_order_data( ){
		
		$data_validated = true;
		
		// Basic Validation
		if( $GLOBALS['ec_cart_data']->cart_data->billing_country == "0" || $GLOBALS['ec_cart_data']->cart_data->billing_first_name == "" || $GLOBALS['ec_cart_data']->cart_data->billing_last_name == "" || $GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 == "" || $GLOBALS['ec_cart_data']->cart_data->billing_city == "" || $GLOBALS['ec_cart_data']->cart_data->email == "" ){
			$data_validated =  false;
			
		}
		
		$data_validated = apply_filters( 'wpeasycart_validate_submit_order_data', $data_validated, $GLOBALS['ec_user'] );
		
		return $data_validated;
		
	}
	
	private function validate_checkout_data( ){
		
		$data_validated = true;
		
		// Basic Validation
		if( $GLOBALS['ec_cart_data']->cart_data->billing_country == "0" || $GLOBALS['ec_cart_data']->cart_data->billing_first_name == "" || $GLOBALS['ec_cart_data']->cart_data->billing_last_name == "" || $GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 == "" || $GLOBALS['ec_cart_data']->cart_data->billing_city == "" || $GLOBALS['ec_cart_data']->cart_data->email == "" ){
			$data_validated =  false;
			
		}
		
		$data_validated = apply_filters( 'wpeasycart_validate_checkout_data', $data_validated, $GLOBALS['ec_user'] );
		
		return $data_validated;
		
	}
	
	private function validate_tax_cloud( ){
		
		if( $GLOBALS['ec_cart_data']->cart_data->shipping_country == "US" && get_option( 'ec_option_tax_cloud_api_id' ) != "" && get_option( 'ec_option_tax_cloud_api_key' ) != "" ){
			
			return $GLOBALS['ec_cart_data']->cart_data->taxcloud_address_verified;
			
		}else{
		
			return true;
		}
		
	}
	
	private function validate_vat_registration_number( $vat_number ){
		
		// Validate with vatlayer
		if( $vat_number != "" && get_option( 'ec_option_collect_vat_registration_number' ) && get_option( 'ec_option_validate_vat_registration_number' ) && get_option( 'ec_option_vatlayer_api_key' ) != "" ){
			// set API Endpoint and Access Key
			$endpoint = 'validate';
			$access_key = get_option( 'ec_option_vatlayer_api_key' );
			
			// Initialize CURL:
			$ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'&vat_number='.$vat_number.'');  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Store the data:
			$json = curl_exec($ch);
			curl_close($ch);
			
			// Decode JSON response:
			$validationResult = json_decode($json, true);
			
			// Access and use your preferred validation result objects
			$validationResult['valid'];
			$validationResult['query'];
			$validationResult['company_name'];
			$validationResult['company_address'];
			
			if( $validationResult['valid'] == "true" ){
				return true;
			}else{
				return false;
			}
			
		// No validation required
		}else{
			return true;
		}
		
	}
	
	private function process_submit_order(){
		
		if( $GLOBALS['ec_cart_data']->cart_data->email == "" ){
			
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=session_expired" );
			
		}else if( !$this->validate_submit_order_data( ) ){
			
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address" );
			
		}else{
			
			if( get_option( 'ec_option_skip_shipping_page' ) ){
				$this->shipping->skip_shipping_selection_page( );
			}
		
			if( isset( $_POST['ec_cart_payment_selection'] ) )
				$payment_type = $_POST['ec_cart_payment_selection'];
			else if( $this->is_affirm )
				$payment_type = "affirm";
			else
				$payment_type = $GLOBALS['language']->get_text( "ec_success", "cart_account_free_order" );
				
			if( isset( $_POST['ec_order_notes'] ) )
				$GLOBALS['ec_cart_data']->cart_data->order_notes = stripslashes( $_POST['ec_order_notes'] );
			
			/************************************** 
			Place 3Ds Payment Processing HERE
			***************************************/
			if( get_option( 'ec_option_payment_process_method' ) == "nmi" && get_option( 'ec_option_nmi_3ds' ) == "2" ){ // 3D Secure
				
				$response = $this->order->submit_order( $payment_type );
				
				if( $response ){
					
					$gateway = new ec_cardinal( );
					$gateway->initialize( $this->cart, $this->user, $this->shipping, $this->tax, 
										  $this->discount, $this->payment->credit_card, $this->order_totals, $this->order->order_id );
					
					$response = $gateway->secure_3d_lookup( );
					
					if( $response == "ERROR" ){ // Failed to Process CC at Cardinal
						$this->mysqli->remove_order( $this->order->order_id );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
						
					}else if( $response == "NO3DS" ){
						$this->process_nmi_no_3ds( );
						
					}else{ // NO 3DS for User, Process Normally
						$submit_return_val = $this->order->submit_order( $payment_type );
						if( $submit_return_val == "1" ){
							$GLOBALS['ec_cart_data']->save_session_to_db( );
							header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
						}else{
							$this->mysqli->remove_order( $order_id );
							header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
						}
					
					}
				
				}else{ // order failed to insert
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
					
				}
				
			/************************************** 
			Place Standard Payment Processing HERE
			***************************************/
			}else{ // Process Non-3D Secure (V3.2.4 and higher 3Ds)
				
				$submit_return_val = $this->order->submit_order( $payment_type );
				do_action( 'wpeasycart_submit_order_complete' );
				
				if( $this->order_totals->grand_total <= 0 ){
					$GLOBALS['ec_cart_data']->save_session_to_db( );
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
					
				}else if( $payment_type == "manual_bill" ){ // Show fail message or the success landing page (including the manual bill notice).
					if( $submit_return_val == "1" ){
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );
					}else{
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&cart_error=manualbill_failed" );
					}
					
				}else if( $payment_type == "affirm" ){
					if( $submit_return_val == "1" ){
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );
					}else{
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
					}
					
				}else if( $payment_type == "third_party" ){ // Show the third party landing page
					if( $submit_return_val == "1" ){
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=third_party&order_id=" . $this->order->order_id );
					}else{
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=thirdparty_failed" );
					}
					
				}else{ // Either show the success landing page
					
					if( $submit_return_val == "1" ){
						if( $this->order->payment->is_3d_auth )
							$this->auth_3d_form();
						else{
							$GLOBALS['ec_cart_data']->save_session_to_db( );
							header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $this->order->order_id );	
						}
						
					}else{
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=payment_failed" );
					}
					
				}
				
			}
			
		}
		
	}
	
	public function auth_3d_form( ){
		echo "<form name=\"ec_cart_3dauth_form\" method=\"POST\" action=\"" . $this->order->payment->post_url . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_id_input_name . "\" value=\"" . $this->order->payment->post_id . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_message_input_name . "\" value=\"" . $this->order->payment->post_message . "\">";
		echo "<input type=\"hidden\" name=\"" . $this->order->payment->post_return_url_input_name . "\" value=\"" . $this->cart_page . $this->permalink_divider . "ec_page=3dsecure&order_id=" . $this->order->order_id . "\">";
		echo "</form>";
		echo "<SCRIPT LANGUAGE=\"Javascript\">document.ec_cart_3dauth_form.submit();</SCRIPT>";
	}
	
	public function process_nmi_no_3ds( ){
		
		$gateway = new ec_nmi( );
		if( isset( $_POST['ec_expiration_month'] ) && isset( $_POST['ec_expiration_year'] ) ){
			$exp_month = $_POST['ec_expiration_month'];
			$exp_year = $_POST['ec_expiration_year'];
		}else{
			$exp_date = $_POST['ec_cc_expiration'];
			$exp_month = substr( $exp_date, 0, 2 );
			$exp_year = substr( $exp_date, 5 );
			if( strlen( $exp_year ) == 2 ){
				$exp_year = "20" . $exp_year;
			}
		}
		$credit_card = new ec_credit_card( $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) ), stripslashes( $GLOBALS['ec_cart_data']->cart_data->billing_first_name . " " . $GLOBALS['ec_cart_data']->cart_data->billing_last_name ),  $this->sanatize_card_number( $_POST['ec_card_number'] ), $exp_month, $exp_year, $_POST['ec_security_code'] );
		$gateway->initialize( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount, $credit_card, $this->order_totals, $_POST['order_id'] );
		$result = $gateway->process_credit_card( );
		
		if( $result ){
			
			$this->mysqli->update_order_status( $_POST['order_id'], "6" );
			
			do_action( 'wpeasycart_order_paid', $_POST['order_id'] );
			
			$db_admin = new ec_db_admin( );
			$order_row = $db_admin->get_order_row_admin( $_POST['order_id'] );
			$order_display = new ec_orderdisplay( $order_row, true, true );
			$order_display->send_email_receipt( );
			
			$this->mysqli->clear_tempcart( $GLOBALS['ec_cart_data']->ec_cart_id );
			$GLOBALS['ec_cart_data']->checkout_session_complete( );
				
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_POST['order_id'] );
			
		}else{
			$this->mysqli->remove_order( $_POST['order_id'] );
			$GLOBALS['ec_cart_data']->save_session_to_db( );	
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );	
		}
		
	}
	
	public function process_3ds_final( ){
		
		$gateway = new ec_nmi( );
		if( isset( $_POST['ec_expiration_month'] ) && isset( $_POST['ec_expiration_year'] ) ){
			$exp_month = $_POST['ec_expiration_month'];
			$exp_year = $_POST['ec_expiration_year'];
		}else{
			$exp_date = $_POST['ec_cc_expiration'];
			$exp_month = substr( $exp_date, 0, 2 );
			$exp_year = substr( $exp_date, 5 );
			if( strlen( $exp_year ) == 2 ){
				$exp_year = "20" . $exp_year;
			}
		}
		$credit_card = new ec_credit_card( $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) ), stripslashes( $GLOBALS['ec_cart_data']->cart_data->billing_first_name . " " . $GLOBALS['ec_cart_data']->cart_data->billing_last_name ),  $this->sanatize_card_number( $_POST['ec_card_number'] ), $exp_month, $exp_year, $_POST['ec_security_code'] );
		$gateway->initialize( $this->cart, $this->user, $this->shipping, $this->tax, $this->discount, $credit_card, $this->order_totals, $_POST['order_id'] );
		$result = $gateway->process_3ds( );
		
		if( $result ){
			
			$this->mysqli->update_order_status( $_POST['order_id'], "6" );
			
			do_action( 'wpeasycart_order_paid', $_POST['order_id'] );
			
			$db_admin = new ec_db_admin( );
			$order_row = $db_admin->get_order_row_admin( $_POST['order_id'] );
			$order_display = new ec_orderdisplay( $order_row, true, true );
			$order_display->send_email_receipt( );
			
			$this->mysqli->clear_tempcart( $GLOBALS['ec_cart_data']->ec_cart_id );
			$GLOBALS['ec_cart_data']->checkout_session_complete( );
				
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_POST['order_id'] );
			
		}else{
			$this->mysqli->remove_order( $_POST['order_id'] );
			$GLOBALS['ec_cart_data']->save_session_to_db( );	
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );	
		}
		
	}
	
	public function process_3dsecure_response( ){
		
		$success = false;
		
		if( get_option( 'ec_option_payment_process_method' ) == "sagepay" ){
			$gateway = new ec_sagepay( );
		}else if( get_option( 'ec_option_payment_process_method' ) == "realex" ){
			$gateway = new ec_realex( );
		}
		
		if( isset( $gateway ) ){
			$success = $gateway->secure_3d_auth( );
			if( $success ){
				
				do_action( 'wpeasycart_order_paid', $this->order_id );
				
				$this->order->clear_session();
				if( $this->discount->giftcard_code )
					$this->mysqli->update_giftcard_total( $this->discount->giftcard_code, $this->discount->giftcard_discount );
					
				$GLOBALS['ec_cart_data']->save_session_to_db( );		
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
			}
		}
		
		if( !$success ){
			$this->mysqli->remove_order( $_GET['order_id'] );
			$GLOBALS['ec_cart_data']->save_session_to_db( );	
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );
		}	
	}
	
	public function process_3ds_response( ){
		
		if( isset( $_GET['order_id'] ) ){
			$order_id = $_GET['order_id'];
			$db = new ec_db_admin( );
			$order = $db->get_order_row_admin( $order_id );
			if( $order ){
				$gateway = new ec_cardinal( );
				$response = $gateway->secure_3d_auth( $order_id, $order, $_POST );
				
				if( !$response ){
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );
				}
			
			}else{// No VALID Order ID Returned, Likely Fraud
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );
				
			}
		}else{// No Order ID Returned, Likely Fraud
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=3dsecure_failed" );
		}
		
	}
	
	private function process_realex_redirect( ){
		// Check response, if success, send to success page. If failed, return to last page of cart
		if( isset( $_POST['AUTHCODE'] ) && isset( $_POST['ORDER_ID'] ) && $_POST['AUTHCODE'] == "00" )
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_POST['ORDER_ID'] );
		else
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment&ec_cart_error=thirdparty_failed" );
	}
	
	private function process_realex_response( ){
		include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/inc/scripts/realex_payment_complete.php" );
	}
	
	private function process_paymentexpress_thirdparty_response( ){
		$gateway = new ec_paymentexpress_thirdparty( );
		$gateway->update_order_status( );
		$db = new ec_db( );
		$db->clear_tempcart( $GLOBALS['ec_cart_data']->ec_cart_id );
		$GLOBALS['ec_cart_data']->save_session_to_db( );	
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $_GET['order_id'] );
	}
	
	private function process_third_party_forward( ){
		$this->payment->third_party->initialize( $_GET['order_id'] );
		$this->payment->third_party->display_auto_forwarding_form( );
		die( );
	}
	
	private function process_login_user( ){
		
		$email = $_POST['ec_cart_login_email'];
		$password = $_POST['ec_cart_login_password'];
		$password_hash = md5( $password );
		$password_hash = apply_filters( 'wpeasycart_password_hash', $password_hash, $password );
		
		do_action( 'wpeasycart_pre_login_attempt', $email );
		$user = $this->mysqli->get_user_login( $email, $password, $password_hash );
		
		if( $user && $user->user_level == "pending" ){
			
			$GLOBALS['ec_cart_data']->save_session_to_db( );
			do_action( 'wpeasycart_cart_updated' );
			if( isset( $_POST['ec_cart_subscription'] ) ){	
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&ec_cart_error=not_activated&subscription=" . $_POST['ec_cart_subscription'] );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=not_activated");
			}
			
		}else if( $email == "guest"){
			$GLOBALS['ec_cart_data']->cart_data->email = "guest";
			$GLOBALS['ec_cart_data']->cart_data->username = "guest";
			$GLOBALS['ec_cart_data']->save_session_to_db( );	
			do_action( 'wpeasycart_cart_updated' );
			if( isset( $_POST['ec_cart_subscription'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
			}
		}else if( $user ){
			do_action( 'wpeasycart_login_success', $email );
			$GLOBALS['ec_cart_data']->cart_data->billing_first_name = $user->billing_first_name;
			$GLOBALS['ec_cart_data']->cart_data->billing_last_name = $user->billing_last_name;
			$GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 = $user->billing_address_line_1;
			$GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 = $user->billing_address_line_2;
			$GLOBALS['ec_cart_data']->cart_data->billing_city = $user->billing_city;
			$GLOBALS['ec_cart_data']->cart_data->billing_state = $user->billing_state;
			$GLOBALS['ec_cart_data']->cart_data->billing_zip = $user->billing_zip;
			$GLOBALS['ec_cart_data']->cart_data->billing_country = $user->billing_country;
			$GLOBALS['ec_cart_data']->cart_data->billing_phone = $user->billing_phone;
			
			$GLOBALS['ec_cart_data']->cart_data->shipping_selector = "";
			$GLOBALS['ec_cart_data']->cart_data->shipping_first_name = $user->shipping_first_name;
			$GLOBALS['ec_cart_data']->cart_data->shipping_last_name = $user->shipping_last_name;
			$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 = $user->shipping_address_line_1;
			$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 = $user->shipping_address_line_2;
			$GLOBALS['ec_cart_data']->cart_data->shipping_city = $user->shipping_city;
			$GLOBALS['ec_cart_data']->cart_data->shipping_state = $user->shipping_state;
			$GLOBALS['ec_cart_data']->cart_data->shipping_zip = $user->shipping_zip;
			$GLOBALS['ec_cart_data']->cart_data->shipping_country = $user->shipping_country;
			$GLOBALS['ec_cart_data']->cart_data->shipping_phone = $user->shipping_phone;
			$GLOBALS['ec_cart_data']->cart_data->is_guest = "";
			$GLOBALS['ec_cart_data']->cart_data->guest_key = "";
			
			$GLOBALS['ec_cart_data']->cart_data->user_id = $user->user_id;
			$GLOBALS['ec_cart_data']->cart_data->email = $email;
			$GLOBALS['ec_cart_data']->cart_data->username = $user->first_name . " " . $user->last_name;
			$GLOBALS['ec_cart_data']->cart_data->first_name = $user->first_name;
			$GLOBALS['ec_cart_data']->cart_data->last_name = $user->last_name;
			
			$GLOBALS['ec_cart_data']->save_session_to_db( );
			do_action( 'wpeasycart_cart_updated' );
			if( $GLOBALS['ec_cart_data']->cart_data->cart_subscription != "" ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] );
			}else if( isset( $_POST['ec_cart_model_number'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_model_number'] );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
			}
		
		}else{
			do_action( 'wpeasycart_login_failed', $email );
			$GLOBALS['ec_cart_data']->save_session_to_db( );
			if( isset( $_POST['ec_cart_subscription'] ) ){
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_POST['ec_cart_subscription'] . "&ec_cart_error=login_failed" );
			}else{
				header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=login_failed");
			}
		}
	}
	
	private function process_logout_user( ){
	
		$GLOBALS['ec_cart_data']->cart_data->user_id = "";
		$GLOBALS['ec_cart_data']->cart_data->email = "";
		$GLOBALS['ec_cart_data']->cart_data->username = "";
		$GLOBALS['ec_cart_data']->cart_data->first_name = "";
		$GLOBALS['ec_cart_data']->cart_data->last_name = "";
		
		$GLOBALS['ec_cart_data']->cart_data->is_guest = "";
		$GLOBALS['ec_cart_data']->cart_data->guest_key = "";
		
		$GLOBALS['ec_cart_data']->cart_data->billing_first_name = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_last_name = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_city = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_state = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_zip = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_country = "";
		$GLOBALS['ec_cart_data']->cart_data->billing_phone = "";
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_selector = "";
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_first_name = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_last_name = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_city = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_state = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_zip = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_country = "";
		$GLOBALS['ec_cart_data']->cart_data->shipping_phone = "";
		
		$GLOBALS['ec_cart_data']->cart_data->first_name = "";
		$GLOBALS['ec_cart_data']->cart_data->last_name = "";
		
		$GLOBALS['ec_cart_data']->cart_data->create_account = "";
		
		$GLOBALS['ec_cart_data']->cart_data->order_notes = "";
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_method = "";
		$GLOBALS['ec_cart_data']->cart_data->estimate_shipping_zip = "";
		$GLOBALS['ec_cart_data']->cart_data->estimate_shipping_country = "";
		
		$GLOBALS['ec_cart_data']->save_session_to_db( );
				
		wp_cache_flush( );
		
		if( isset( $_GET['subscription'] ) ){
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $_GET['subscription'] );
		}else if( !get_option( 'ec_option_skip_cart_login' ) && file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/admin_panel.php" ) ){
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_login");
		}else{
			header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info");
		}
	}
	
	private function process_save_checkout_info( ){
		
		if( isset( $_POST['ec_login_selector'] ) ){
			$this->process_login_user( );
			
		}else{
			$this->process_save_checkout_info_helper( );
		}
		
		do_action( 'wpeasycart_user_updated' );
		
	}
	
	private function process_save_checkout_info_helper( ){
		
		$billing_country = $shipping_country = stripslashes( $_POST['ec_cart_billing_country'] );
		
		$billing_first_name = $shipping_first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
		$billing_last_name = $shipping_last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
			
		if( isset( $_POST['ec_cart_billing_company_name'] ) ){
			$billing_company_name = $shipping_company_name = stripslashes( $_POST['ec_cart_billing_company_name'] );
		}else{
			$billing_company_name = $shipping_company_name = "";
		}
		
		if( isset( $_POST['ec_cart_billing_vat_registration_number'] ) ){
			$vat_registration_number = stripslashes( $_POST['ec_cart_billing_vat_registration_number'] );
		}else{
			$vat_registration_number = "";
		}
		
		$billing_address = $shipping_address = stripslashes( $_POST['ec_cart_billing_address'] );
		if( isset( $_POST['ec_cart_billing_address2'] ) ){
			$billing_address2 = $shipping_address2 = stripslashes( $_POST['ec_cart_billing_address2'] );
		}else{
			$billing_address2 = $shipping_address2 = "";
		}
		
		$billing_city = $shipping_city = stripslashes( $_POST['ec_cart_billing_city'] );
		if( isset( $_POST['ec_cart_billing_state_' . $billing_country] ) ){
			$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state_' . $billing_country] );
		}else{
			$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state'] );
		}
		
		$billing_zip = $shipping_zip = trim( stripslashes( $_POST['ec_cart_billing_zip'] ) );
		if( isset( $_POST['ec_cart_billing_phone'] ) ){
			$billing_phone = $shipping_phone = stripslashes( $_POST['ec_cart_billing_phone'] );
		}else{
			$billing_phone = "";
		}
		
		if( isset( $_POST['ec_shipping_selector'] ) )
			$shipping_selector = $_POST['ec_shipping_selector'];
		else
			$shipping_selector = "false";
		
		if( $shipping_selector == "true" ){
			$shipping_country = stripslashes( $_POST['ec_cart_shipping_country'] );
			
			$shipping_first_name = stripslashes( $_POST['ec_cart_shipping_first_name'] );
			$shipping_last_name = stripslashes( $_POST['ec_cart_shipping_last_name'] );
			
			if( isset( $_POST['ec_cart_shipping_company_name'] ) ){
				$shipping_company_name = stripslashes( $_POST['ec_cart_shipping_company_name'] );
			}else{
				$shipping_company_name = "";
			}
			
			$shipping_address = stripslashes( $_POST['ec_cart_shipping_address'] );
			if( isset( $_POST['ec_cart_shipping_address2'] ) ){
				$shipping_address2 = stripslashes( $_POST['ec_cart_shipping_address2'] );
			}else{
				$shipping_address2 = "";
			}
			
			$shipping_city = stripslashes( $_POST['ec_cart_shipping_city'] );
			
			if( isset( $_POST['ec_cart_shipping_state_' . $shipping_country] ) ){
				$shipping_state = stripslashes( $_POST['ec_cart_shipping_state_' . $shipping_country] );
			}else{
				$shipping_state = stripslashes( $_POST['ec_cart_shipping_state'] );
			}
			
			$shipping_zip = trim( stripslashes( $_POST['ec_cart_shipping_zip'] ) );
			if( isset( $_POST['ec_cart_shipping_phone'] ) ){
				$shipping_phone = stripslashes( $_POST['ec_cart_shipping_phone'] );
			}else{
				$shipping_phone = "";
			}
		}
		
		if( isset( $_POST['ec_order_notes'] ) ){
			$order_notes = stripslashes( $_POST['ec_order_notes'] );
		}else if( $GLOBALS['ec_cart_data']->cart_data->order_notes != "" ){
			$order_notes = $GLOBALS['ec_cart_data']->cart_data->order_notes;
		}else{
			$order_notes = "";
		}
		
		if( isset( $_POST['ec_contact_first_name'] ) ){
			$first_name = stripslashes( $_POST['ec_contact_first_name'] );
		}else if( isset( $_POST['ec_cart_billing_first_name'] ) ){
			$first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
		}else{
			$first_name = "";
		}
		if( isset( $_POST['ec_contact_last_name'] ) ){
			$last_name = stripslashes( $_POST['ec_contact_last_name'] );
		}else if( isset( $_POST['ec_cart_billing_last_name'] ) ){
			$last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
		}else{
			$last_name = "";
		}
		
		if( isset( $_POST['ec_contact_create_account'] ) )
			$create_account = $_POST['ec_contact_create_account'];
		else if( isset( $_POST['ec_create_account_selector'] ) )
			$create_account = true;
		else
			$create_account = false;
		
		$GLOBALS['ec_cart_data']->cart_data->billing_first_name = $billing_first_name;
		$GLOBALS['ec_cart_data']->cart_data->billing_last_name = $billing_last_name;
		$GLOBALS['ec_cart_data']->cart_data->billing_company_name = $billing_company_name;
		$GLOBALS['ec_cart_data']->cart_data->vat_registration_number = $vat_registration_number;
		$GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 = $billing_address;
		$GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 = $billing_address2;
		$GLOBALS['ec_cart_data']->cart_data->billing_city = $billing_city;
		$GLOBALS['ec_cart_data']->cart_data->billing_state = $billing_state;
		$GLOBALS['ec_cart_data']->cart_data->billing_zip = $billing_zip;
		$GLOBALS['ec_cart_data']->cart_data->billing_country = $billing_country;
		$GLOBALS['ec_cart_data']->cart_data->billing_phone = $billing_phone;
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_selector = $shipping_selector;
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_first_name = $shipping_first_name;
		$GLOBALS['ec_cart_data']->cart_data->shipping_last_name = $shipping_last_name;
		$GLOBALS['ec_cart_data']->cart_data->shipping_company_name = $shipping_company_name;
		$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 = $shipping_address;
		$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 = $shipping_address2;
		$GLOBALS['ec_cart_data']->cart_data->shipping_city = $shipping_city;
		$GLOBALS['ec_cart_data']->cart_data->shipping_state = $shipping_state;
		$GLOBALS['ec_cart_data']->cart_data->shipping_zip = $shipping_zip;
		$GLOBALS['ec_cart_data']->cart_data->shipping_country = $shipping_country;
		$GLOBALS['ec_cart_data']->cart_data->shipping_phone = $shipping_phone;
		
		$GLOBALS['ec_cart_data']->cart_data->first_name = $first_name;
		$GLOBALS['ec_cart_data']->cart_data->last_name = $last_name;
		
		$GLOBALS['ec_cart_data']->cart_data->order_notes = $order_notes;
		
		$next_page = "checkout_shipping";
		if( !get_option( 'ec_option_use_shipping' ) || $this->cart->weight == 0 )
			$next_page = "checkout_payment";
			
		if( get_option( 'ec_option_skip_shipping_page' ) || $GLOBALS['ec_user']->freeshipping )//|| $this->discount->shipping_discount == $this->discount->shipping_subtotal )
			$next_page = "checkout_payment";
		
		if( isset( $_POST['ec_contact_email'] ) ){
			$email = $_POST['ec_contact_email'];
			$GLOBALS['ec_cart_data']->cart_data->email = $email;
		}
		
		if( isset( $_POST['ec_contact_email'] ) && !$create_account ){
			$GLOBALS['ec_cart_data']->cart_data->is_guest = true;
			$GLOBALS['ec_cart_data']->cart_data->guest_key = $GLOBALS['ec_cart_data']->ec_cart_id;
		}else if( isset( $_POST['ec_contact_email'] ) ){
			$GLOBALS['ec_cart_data']->cart_data->is_guest = true;
			$GLOBALS['ec_cart_data']->cart_data->guest_key = $GLOBALS['ec_cart_data']->ec_cart_id;
		}else{
			$GLOBALS['ec_cart_data']->cart_data->is_guest = false;
			$GLOBALS['ec_cart_data']->cart_data->guest_key = "";
		}
		
		$GLOBALS['ec_cart_data']->save_session_to_db( );	
		
		if( !$this->validate_checkout_data( ) ){
			
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address" );
			
		}else{
		
			if( $create_account ){
				
				if( $this->mysqli->does_user_exist( $_POST['ec_contact_email'] ) ){
					do_action( 'wpeasycart_cart_updated' );	
					$GLOBALS['ec_cart_data']->save_session_to_db( );
					header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=email_exists");
				
				}else{
					$email = $_POST['ec_contact_email'];
					$password = md5( $_POST['ec_contact_password'] );
					$password = apply_filters( 'wpeasycart_password_hash', $password, $_POST['ec_contact_password'] );
					
					// INSERT USER
					$billing_id = $this->mysqli->insert_address( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
					
					$shipping_id = $this->mysqli->insert_address( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $shipping_company_name );
					
					$user_level = "shopper";
					if( isset( $_POST['ec_cart_is_subscriber'] ) )
						$is_subscriber = true;
					else
						$is_subscriber = false;
					
					$user_id = $this->mysqli->insert_user( $email, $password, $first_name, $last_name, $billing_id, $shipping_id, $user_level, $is_subscriber, "", $vat_registration_number );
					$this->mysqli->update_address_user_id( $billing_id, $user_id );
					$this->mysqli->update_address_user_id( $shipping_id, $user_id );
					
					// MyMail Hook
					if( function_exists( 'mymail' ) ){
						$subscriber_id = mymail('subscribers')->add(array(
							'firstname' => $first_name,
							'lastname' => $last_name,
							'email' => $email,
							'status' => 1,
						), false );
					}
					
					do_action( 'wpeasycart_account_added', $user_id );
					
					// Send registration email if needed
					if( get_option( 'ec_option_send_signup_email' ) ){
						
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-Type: text/html; charset=utf-8";
						$headers[] = "From: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
						$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_order_from_email' ) );
						$headers[] = "X-Mailer: PHP/" . phpversion( );
						
						$message = $GLOBALS['language']->get_text( "account_register", "account_register_email_message" ) . " " . $email;
						
						if( get_option( 'ec_option_use_wp_mail' ) ){
							wp_mail( stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), $GLOBALS['language']->get_text( "account_register", "account_register_email_title" ), $message, implode("\r\n", $headers) );
						}else{
							$admin_email = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
							$subject = $GLOBALS['language']->get_text( "account_register", "account_register_email_title" );
							$mailer = new wpeasycart_mailer( );
							$mailer->send_order_email( $admin_email, $subject, $message );
						}
						
					}
					
					if( $user_id != 0 ){
						$GLOBALS['ec_cart_data']->cart_data->is_guest = false;
						$GLOBALS['ec_cart_data']->cart_data->user_id = $user_id;
						$GLOBALS['ec_cart_data']->cart_data->email = $email;
						$GLOBALS['ec_cart_data']->cart_data->username = $first_name . " " . $last_name;
						$GLOBALS['ec_cart_data']->cart_data->first_name = $first_name;
						$GLOBALS['ec_cart_data']->cart_data->last_name = $last_name;
						
						if( $this->shipping->validate_address( $shipping_address, $shipping_city, $shipping_state, $shipping_zip, $shipping_country ) ){
							$GLOBALS['ec_cart_data']->cart_data->is_guest = "";
							$GLOBALS['ec_cart_data']->cart_data->guest_key = "";
							
							$GLOBALS['ec_cart_data']->save_session_to_db( );
							do_action( 'wpeasycart_cart_updated' );	
							if( !$this->validate_tax_cloud( ) ){
								header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address" );
								
							}else if( !$this->validate_vat_registration_number( $vat_registration_number ) ){
								header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_vat_number" );
								
							}else{
								header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page . "&ec_cart_success=account_created");
							
							}
							
						}else{
							$GLOBALS['ec_cart_data']->save_session_to_db( );
							do_action( 'wpeasycart_cart_updated' );	
							header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_success=account_created&ec_cart_error=invalid_address");
						}
						
					}else{
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=email_exists");
					}
					
				}
			
			}else{
				
				$this->mysqli->update_user( $GLOBALS['ec_user']->user_id, $vat_registration_number );
				
				if( $this->shipping->validate_address( $shipping_address, $shipping_city, $shipping_state, $shipping_zip, $shipping_country ) ){
					
					if( $GLOBALS['ec_user']->billing_id ){
						$this->mysqli->update_address( $GLOBALS['ec_user']->billing_id, $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
					
					}else{
						$this->mysqli->insert_user_address( $billing_first_name, $billing_last_name, $billing_company_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $GLOBALS['ec_user']->user_id, "billing" );
					}
				
					if( $GLOBALS['ec_user']->shipping_id ){
							$this->mysqli->update_address( $GLOBALS['ec_user']->shipping_id, $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $shipping_company_name );
					
					}else{
						$this->mysqli->insert_user_address( $shipping_first_name, $shipping_last_name, $shipping_company_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $GLOBALS['ec_user']->user_id, "shipping" );
						
					}
					
					$GLOBALS['ec_cart_data']->save_session_to_db( );
				
					do_action( 'wpeasycart_cart_updated' );
				
					do_action( 'wpeasycart_account_updated', $GLOBALS['ec_user']->user_id );
					
					if( !$this->validate_tax_cloud( ) ){
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address" );
							
					}else if( !$this->validate_vat_registration_number( $vat_registration_number ) ){
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_vat_number" );
							
					}else{
						header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=" . $next_page);
					
					}
				
				}else{
					$GLOBALS['ec_cart_data']->save_session_to_db( );
					do_action( 'wpeasycart_cart_updated' );
					header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_info&ec_cart_error=invalid_address");
				}
				
			}
			
		}
		
	}
	
	private function process_save_checkout_shipping( ){
		if( isset( $_POST['ec_cart_shipping_method'] ) )
			$shipping_method = $_POST['ec_cart_shipping_method'];
		else
			$shipping_method = "";
		if( isset( $_POST['ec_cart_ship_express'] ) )
			$ship_express = $_POST['ec_cart_ship_express'];
		else
			$ship_express = "";
		
		$GLOBALS['ec_cart_data']->cart_data->shipping_method = $shipping_method;
		$GLOBALS['ec_cart_data']->cart_data->expedited_shipping = $ship_express;
		
		$GLOBALS['ec_cart_data']->save_session_to_db( );
		
		do_action( 'wpeasycart_cart_updated' );
		header("location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_payment");
	}
	
	private function process_purchase_subscription( ){
		
		$model_number = 0;
		if( isset( $_POST['model_number'] ) )
			$model_number = $_POST['model_number'];
		
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number );
		
	}
	
	private function process_insert_subscription( ){
		
		if( isset( $_POST['ec_login_selector'] ) ){
			$this->process_login_user( );
			
		}else{
			$this->process_insert_subscription_helper( );
		}
		
	}
	
	private function process_insert_subscription_helper( ){
		
		global $wpdb;
		$model_number = $_POST['ec_cart_model_number'];
		$products = $this->mysqli->get_product_list( $wpdb->prepare( " WHERE product.model_number = %s", $model_number ), "", "", "" );
		
		$user_error = false;
		if( isset( $_POST['ec_contact_email'] ) ){
			$user_error = $this->mysqli->does_user_exist( $_POST['ec_contact_email'] );
		}
		
		// If checkout out as new user and the email already exists, this is an error.
		if( !$user_error ){
		
			if( count( $products > 0 ) ){
				
				// Try to get a subscription for this product and email address!
				if( isset( $_POST['ec_contact_email'] ) )	$email_test = $_POST['ec_contact_email'];
				else										$email_test = $GLOBALS['ec_cart_data']->cart_data->email;
				
				$subscription_list = $this->mysqli->find_subscription_match( $email_test, $products[0]['product_id'] );
				
				// Coupon Information
				$coupon = NULL;
				$discount_total = 0;
				$is_match = false;
				if( isset( $_POST['ec_cart_coupon_code'] ) && $_POST['ec_cart_coupon_code'] != "" ){
					$coupon_row = $GLOBALS['ec_coupons']->redeem_coupon_code( $_POST['ec_cart_coupon_code'] );
					$is_match = false;
					if( $coupon_row->by_product_id ){
						if( $products[0]['product_id'] == $coupon_row->product_id ){
							$is_match = true;
						}
					}else if( $coupon_row->by_manufacturer_id ){
						if( $products[0]['manufacturer_id'] == $coupon_row->manufacturer_id ){
							$is_match = true;
						}
					}else{
						$is_match = true;
					}
					
					if( $is_match ){
						$coupon = $coupon_row->promocode_id;
					}
				}else if( isset( $_POST['ec_coupon_code'] ) && $_POST['ec_coupon_code'] != "" ){
					$coupon_row = $GLOBALS['ec_coupons']->redeem_coupon_code( $_POST['ec_coupon_code'] );
					$is_match = false;
					if( $coupon_row->by_product_id ){
						if( $products[0]['product_id'] == $coupon_row->product_id ){
							$is_match = true;
						}
					}else if( $coupon_row->by_manufacturer_id ){
						if( $products[0]['manufacturer_id'] == $coupon_row->manufacturer_id ){
							$is_match = true;
						}
					}else{
						$is_match = true;
					}
					
					if( $is_match ){
						$coupon = $coupon_row->promocode_id;
					}
				
				}
				// END COUPON FIND SECTION
				
				// IF MATCH FOUND, APPLY TO PRODUCT
				if( $is_match ){
					
					if( $coupon_row->is_dollar_based ){
						$discount_total = floatval( $coupon_row->promo_dollar );
						
					}else if( $coupon_row->is_percentage_based ){
						$discount_total = ( floatval( $products[0]['price'] ) * ( floatval( $coupon_row->promo_percentage ) / 100 ) );
						
					}
			
				}
				// END MATCHING COUPON SECTION
			
				// Billing Information
				$billing_country = $shipping_country = stripslashes( $_POST['ec_cart_billing_country'] );
	
				$billing_first_name = $shipping_first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
				$billing_last_name = $shipping_last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
					
				if( isset( $_POST['ec_cart_billing_company_name'] ) ){
					$billing_company_name = $shipping_company_name = stripslashes( $_POST['ec_cart_billing_company_name'] );
				}else{
					$billing_company_name = $shipping_company_name = "";
				}
				
				$billing_address = $shipping_address = stripslashes( $_POST['ec_cart_billing_address'] );
				if( isset( $_POST['ec_cart_billing_address2'] ) ){
					$billing_address2 = $shipping_address2 = stripslashes( $_POST['ec_cart_billing_address2'] );
				}else{
					$billing_address2 = $shipping_address2 = "";
				}
				
				$billing_city = $shipping_city = stripslashes( $_POST['ec_cart_billing_city'] );
				if( isset( $_POST['ec_cart_billing_state_' . $billing_country] ) ){
					$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state_' . $billing_country] );
				}else{
					$billing_state = $shipping_state = stripslashes( $_POST['ec_cart_billing_state'] );
				}
				
				$billing_zip = $shipping_zip = stripslashes( $_POST['ec_cart_billing_zip'] );
				if( isset( $_POST['ec_cart_billing_phone'] ) ){
					$billing_phone = $shipping_phone = stripslashes( $_POST['ec_cart_billing_phone'] );
				}else{
					$billing_phone = "";
				}
				// END BILLING INFO
				
				// Shipping Information
				if( isset( $_POST['ec_shipping_selector'] ) )
					$shipping_selector = $_POST['ec_shipping_selector'];
				else
					$shipping_selector = "false";
				
				if( $shipping_selector == "true" ){
					$shipping_country = stripslashes( $_POST['ec_cart_shipping_country'] );
					
					$shipping_first_name = stripslashes( $_POST['ec_cart_shipping_first_name'] );
					$shipping_last_name = stripslashes( $_POST['ec_cart_shipping_last_name'] );
					
					if( isset( $_POST['ec_cart_shipping_company_name'] ) ){
						$shipping_company_name = stripslashes( $_POST['ec_cart_shipping_company_name'] );
					}else{
						$shipping_company_name = "";
					}
					
					$shipping_address = stripslashes( $_POST['ec_cart_shipping_address'] );
					if( isset( $_POST['ec_cart_shipping_address2'] ) ){
						$shipping_address2 = stripslashes( $_POST['ec_cart_shipping_address2'] );
					}else{
						$shipping_address2 = "";
					}
					
					$shipping_city = stripslashes( $_POST['ec_cart_shipping_city'] );
					
					if( isset( $_POST['ec_cart_shipping_state_' . $shipping_country] ) ){
						$shipping_state = stripslashes( $_POST['ec_cart_shipping_state_' . $shipping_country] );
					}else{
						$shipping_state = stripslashes( $_POST['ec_cart_shipping_state'] );
					}
					
					$shipping_zip = stripslashes( $_POST['ec_cart_shipping_zip'] );
					if( isset( $_POST['ec_cart_shipping_phone'] ) ){
						$shipping_phone = stripslashes( $_POST['ec_cart_shipping_phone'] );
					}else{
						$shipping_phone = "";
					}
				}
				// END SHIPPING INFO
				
				// Order Notes
				if( isset( $_POST['ec_order_notes'] ) ){
					$order_notes = stripslashes( $_POST['ec_order_notes'] );
				}else{
					$order_notes = "";
				}
				
				// Create Account Information
				if( isset( $_POST['ec_contact_first_name'] ) ){
					$first_name = stripslashes( $_POST['ec_contact_first_name'] );
				}else if( isset( $_POST['ec_cart_billing_first_name'] ) ){
					$first_name = stripslashes( $_POST['ec_cart_billing_first_name'] );
				}else{
					$first_name = "";
				}
				if( isset( $_POST['ec_contact_last_name'] ) ){
					$last_name = stripslashes( $_POST['ec_contact_last_name'] );
				}else if( isset( $_POST['ec_cart_billing_last_name'] ) ){
					$last_name = stripslashes( $_POST['ec_cart_billing_last_name'] );
				}else{
					$last_name = "";
				}
				
				if( isset( $_POST['ec_contact_create_account'] ) )
					$create_account = $_POST['ec_contact_create_account'];
				else if( isset( $_POST['ec_create_account_selector'] ) )
					$create_account = true;
				else
					$create_account = false;
				
				
				// CREATE ACCOUNT IF NEEDED
				if( isset( $_POST['ec_contact_email'] ) ){
					$email = $_POST['ec_contact_email'];
					$GLOBALS['ec_cart_data']->cart_data->email = $email;
				}
				
				if( isset( $_POST['ec_contact_email'] ) && !$create_account ){
					$GLOBALS['ec_cart_data']->cart_data->is_guest = true;
					$GLOBALS['ec_cart_data']->cart_data->guest_key = $GLOBALS['ec_cart_data']->ec_cart_id;
				}else{
					$GLOBALS['ec_cart_data']->cart_data->is_guest = false;
				}
				
				if( $create_account ){
					$email = $_POST['ec_contact_email'];
					$password = md5( $_POST['ec_contact_password'] );
					$password = apply_filters( 'wpeasycart_password_hash', $password, $_POST['ec_contact_password'] );
					
					// INSERT USER
					$billing_id = $this->mysqli->insert_address( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
					
					$shipping_id = $this->mysqli->insert_address( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_phone, $shipping_company_name );
					
					$user_level = "shopper";
					if( isset( $_POST['ec_contact_is_subscriber'] ) )
						$is_subscriber = true;
					else
						$is_subscriber = false;
					
					$user_id = $this->mysqli->insert_user( $email, $password, $first_name, $last_name, $billing_id, $shipping_id, $user_level, $is_subscriber );
					$this->mysqli->update_address_user_id( $billing_id, $user_id );
					$this->mysqli->update_address_user_id( $shipping_id, $user_id );
		
					do_action( 'wpeasycart_account_added', $user_id );
		
					// MyMail Hook
					if( function_exists( 'mymail' ) ){
						$subscriber_id = mymail('subscribers')->add(array(
							'firstname' => $first_name,
							'lastname' => $last_name,
							'email' => $email,
							'status' => 1,
						), false );
					}
					
					if( $user_id != 0 ){
					
						$GLOBALS['ec_cart_data']->cart_data->user_id = $user_id;
						$GLOBALS['ec_cart_data']->cart_data->email = $email;
						$GLOBALS['ec_cart_data']->cart_data->username = $first_name . " " . $last_name;
						$GLOBALS['ec_cart_data']->cart_data->first_name = $first_name;
						$GLOBALS['ec_cart_data']->cart_data->last_name = $last_name;
				
						$GLOBALS['ec_user'] = new ec_user( "" );
						
					}
				}else{ // Customer already exists, lets update their billing address
					$user = new ec_user( "" );
					$this->mysqli->update_address( $user->billing_id, $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_zip, $billing_country, $billing_phone, $billing_company_name );
				}
				// END CREATE ACCOUNT
				
				// Set Sessions
				$GLOBALS['ec_cart_data']->cart_data->billing_first_name = $billing_first_name;
				$GLOBALS['ec_cart_data']->cart_data->billing_last_name = $billing_last_name;
				$GLOBALS['ec_cart_data']->cart_data->billing_company_name = $billing_company_name;
				$GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 = $billing_address;
				$GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 = $billing_address2;
				$GLOBALS['ec_cart_data']->cart_data->billing_city = $billing_city;
				$GLOBALS['ec_cart_data']->cart_data->billing_state = $billing_state;
				$GLOBALS['ec_cart_data']->cart_data->billing_zip = $billing_zip;
				$GLOBALS['ec_cart_data']->cart_data->billing_country = $billing_country;
				$GLOBALS['ec_cart_data']->cart_data->billing_phone = $billing_phone;
				
				$GLOBALS['ec_cart_data']->cart_data->shipping_selector = $shipping_selector;
				
				$GLOBALS['ec_cart_data']->cart_data->shipping_first_name = $shipping_first_name;
				$GLOBALS['ec_cart_data']->cart_data->shipping_last_name = $shipping_last_name;
				$GLOBALS['ec_cart_data']->cart_data->shipping_company_name = $shipping_company_name;
				$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 = $shipping_address;
				$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 = $shipping_address2;
				$GLOBALS['ec_cart_data']->cart_data->shipping_city = $shipping_city;
				$GLOBALS['ec_cart_data']->cart_data->shipping_state = $shipping_state;
				$GLOBALS['ec_cart_data']->cart_data->shipping_zip = $shipping_zip;
				$GLOBALS['ec_cart_data']->cart_data->shipping_country = $shipping_country;
				$GLOBALS['ec_cart_data']->cart_data->shipping_phone = $shipping_phone;
				
				$GLOBALS['ec_cart_data']->cart_data->first_name = $first_name;
				$GLOBALS['ec_cart_data']->cart_data->last_name = $last_name;
				
				$GLOBALS['ec_cart_data']->cart_data->order_notes = $order_notes;
				
				$GLOBALS['ec_cart_data']->save_session_to_db( );
										
				$GLOBALS['ec_user']->setup_billing_info_data( $billing_first_name, $billing_last_name, $billing_address, $billing_address2, $billing_city, $billing_state, $billing_country, $billing_zip, $billing_phone, $billing_company_name );
				$GLOBALS['ec_user']->setup_shipping_info_data( $shipping_first_name, $shipping_last_name, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_country, $shipping_zip, $shipping_phone, $shipping_company_name );
				$product = new ec_product( $products[0] );
				$quantity = 1;
				if( isset( $_POST['ec_quantity'] ) )
					$quantity = $_POST['ec_quantity'];
				
				if( count( $subscription_list ) <= 0 ){
					// Setup for processing
					// Setup for processing
					if( class_exists( "ec_stripe" ) ){
						
						$stripe = new ec_stripe( );
						
						// Coupon Check
						if( $coupon ){
							$coupon_get = array( "promocode_id" => $coupon );
							$coupon_exists = $stripe->get_coupon( $coupon_get );
							if( $coupon_exists === false ){
								$is_amount_off = false;
								if( $coupon_row->promo_dollar > 0 )
									$is_amount_off = true;
								$redeem_by = NULL;
								if( $coupon_row->expiration_date != '' ){
									$redeem_by = strtotime( $coupon_row->expiration_date ) + 7*60*60;
								}
								$stripe_coupon = array(
									"promocode_id"		=> $coupon_row->promocode_id,
									"duration"			=> $coupon_row->duration,
									"duration_in_months"=> $coupon_row->duration_in_months,
									"is_amount_off"		=> $is_amount_off,
									"amount_off"		=> $coupon_row->promo_dollar * 100,
									"percent_off"		=> $coupon_row->promo_percentage,
									"redeem_by"			=> $redeem_by,
									"max_redemptions"	=> $coupon_row->max_redemptions
								);
								$stripe->insert_coupon( $stripe_coupon );
							}
						}
						
						// Payment Information
						$payment_method = $this->get_payment_type( $this->sanatize_card_number( $_POST['ec_card_number'] ) );
						$card_holder_name = stripslashes( $_POST['ec_cart_billing_first_name'] . " " . $_POST['ec_cart_billing_last_name'] );
						$card_number = $_POST['ec_card_number'];
						if( isset( $_POST['ec_expiration_month'] ) && isset( $_POST['ec_expiration_year'] ) ){
							$exp_month = $_POST['ec_expiration_month'];
							$exp_year = $_POST['ec_expiration_year'];
						}else{
							$exp_date = $_POST['ec_cc_expiration'];
							$exp_month = substr( $exp_date, 0, 2 );
							$exp_year = substr( $exp_date, 5 );
							if( strlen( $exp_year ) == 2 ){
								$exp_year = "20" . $exp_year;
							}
						}
						$security_code = $_POST['ec_security_code'];
						
						$card = new ec_credit_card( $payment_method, $card_holder_name, $card_number, $exp_month, $exp_year, $security_code );
						$customer_id = $GLOBALS['ec_user']->stripe_customer_id;
						
						// Tests vars
						$need_to_update_customer_id = false;
						$customer_insert_test = false;
						
						if( $customer_id == "" ){
							$customer_id = $stripe->insert_customer( $GLOBALS['ec_user'], NULL, $product->subscription_signup_fee );
							$need_to_update_customer_id = true;
						}else{
							$found_customer = $stripe->update_customer( $GLOBALS['ec_user'], $product->subscription_signup_fee );
							if( !$found_customer ){ // Likely switched from test to live or to a new account, so customer id was wrong
								$customer_id = $stripe->insert_customer( $GLOBALS['ec_user'], NULL, $product->subscription_signup_fee );
								$need_to_update_customer_id = true;
							}
						}
						
						if( $need_to_update_customer_id && $customer_id ){ // Customer inserted to stripe successfully
							$this->mysqli->update_user_stripe_id( $GLOBALS['ec_user']->user_id, $customer_id );
							$GLOBALS['ec_user']->stripe_customer_id = $customer_id;
							$customer_insert_test = true;
						}else if( $need_to_update_customer_id && !$customer_id ){
							$customer_insert_test = false;
						}else{
							$customer_insert_test = true;
						}
						
						if( $customer_insert_test ){ // Customer inserted successfully (OR didn't need to be inserted)
							
							$card_result = $stripe->insert_card( $GLOBALS['ec_user'], $card );
								
							
							if( $card_result ){ //Card Submitted Successfully
								
								$plan_added = $product->stripe_plan_added;
								
								if( !$product->stripe_plan_added ){ // Add plan if needed
									$plan_added = $stripe->insert_plan( $product );
									$this->mysqli->update_product_stripe_added( $product->product_id );
								}
								
								if( $plan_added ){ // Plan added successfully
									
									if( $product->is_shippable ){
										$ship_price_total = $product->price * $quantity;
										$ship_weight_total = $product->weight * $quantity;
										$ship_quantity = $quantity;
									}else{
										$ship_price_total = 0;
										$ship_weight_total = 0;
										$ship_quantity = 0;
									}
									
									do_action( 'wpeasycart_cart_subscription_updated', $product, $quantity );
									
									$this->shipping = new ec_shipping( $ship_price_total, $ship_weight_total, $ship_quantity, 'RADIO', $GLOBALS['ec_user']->freeshipping, $product->length, $product->width, $product->height * $quantity, array( $product ) );
									if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) && $product->is_shippable ){
										$this->cart->shippable_total_items = $quantity;
									}
									
									$this->cart->subtotal = ( $product->price + $product->subscription_signup_fee ) * $quantity;
									
									$this->order_totals = new ec_order_totals( $this->cart, $GLOBALS['ec_user'], $this->shipping, $this->tax, $this->discount );
									
									if( $product->is_taxable || $product->vat_rate ){
										$taxable_subtotal = 0;
										$vatable_subtotal = 0;
										if( $product->is_taxable )
											$taxable_subtotal = $product->price * $quantity - $discount_total;
										if( $product->vat_rate )
											$vatable_subtotal = $product->price * $quantity - $discount_total;
										
										if( get_option( 'ec_option_tax_cloud_api_id' ) != "" && get_option( 'ec_option_tax_cloud_api_key' ) != "" ){
											wpeasycart_taxcloud( )->setup_subscription_for_tax( $product, $quantity );
										}
										$this->tax = new ec_tax( $product->price * $quantity, $taxable_subtotal, $vatable_subtotal, $GLOBALS['ec_user']->shipping->state, $GLOBALS['ec_user']->shipping->country, $GLOBALS['ec_user']->taxfree, $this->shipping->get_shipping_price( ) + ( $this->product->handling_price_each * $quantity ) + $this->product->handling_price );
									}else{
										$this->tax = new ec_tax( 0, 0, 0, $GLOBALS['ec_user']->shipping->state, $GLOBALS['ec_user']->shipping->country, $GLOBALS['ec_user']->taxfree, $this->shipping->get_shipping_price( ) + ( $this->product->handling_price_each * $quantity ) + $this->product->handling_price );
									}
									
									$this->order_totals = new ec_order_totals( $this->cart, $GLOBALS['ec_user'], $this->shipping, $this->tax, $this->discount );
									
									if( get_option( 'ec_option_collect_shipping_for_subscriptions' ) && $this->order_totals->shipping_total > 0 ){
										$stripe->update_customer( $GLOBALS['ec_user'], $this->order_totals->shipping_total );
									}
									
									$prorate = "false";
									if( $product->subscription_prorate )
										$prorate = "true";
									$trial_end_date = NULL;
									if( $product->trial_period_days > 0 )
										$trial_end_date = strtotime( "+" . $product->trial_period_days . " days" );
									$stripe_response = $stripe->insert_subscription( $product, $GLOBALS['ec_user'], $card, $coupon, $prorate, $trial_end_date, $quantity, number_format( $this->tax->get_tax_rate( ), 2, '.', '' ) );
									
									if( $stripe_response ){ // Subscription added successfully
										
										$subscription_id = $this->mysqli->insert_stripe_subscription( $stripe_response, $product, $GLOBALS['ec_user'], $card, $quantity );
										$subscription_row = $this->mysqli->get_subscription_row( $subscription_id );
										$coupon_promocode_id = "";
										if( isset( $coupon_row ) )
											$coupon_promocode_id = $coupon_row->promocode_id;
										
										$this->mysqli->update_user_default_card( $GLOBALS['ec_user'], $card );
										$subscription = new ec_subscription( $subscription_row );
										
										if( $product->trial_period_days > 0 ){
											
											$subscription->send_trial_start_email( $GLOBALS['ec_user'] );
											
										}else{
											// Get Shipping Method to Save
											$shipping_method = "";
											if( !get_option( 'ec_option_use_shipping' ) || $this->order_totals->shipping_total <= 0 ){
												$shipping_method = "";
											}else if( $this->shipping->shipping_method == "fraktjakt" ){
												$shipping_method = $this->shipping->get_selected_shipping_method( );
												
											}else if( $GLOBALS['ec_cart_data']->cart_data->shipping_method != "" && $GLOBALS['ec_cart_data']->cart_data->shipping_method != "standard" )
												$shipping_method = $this->mysqli->get_shipping_method_name( $GLOBALS['ec_cart_data']->cart_data->shipping_method );
											
											else if( ( $this->shipping->shipping_method == "price" || $this->shipping->shipping_method == "weight" ) && $GLOBALS['ec_cart_data']->cart_data->expedited_shipping != "" )
												$shipping_method = $GLOBALS['language']->get_text( "cart_estimate_shipping", "cart_estimate_shipping_express" );
											
											else
												$shipping_method = $GLOBALS['language']->get_text( "cart_estimate_shipping", "cart_estimate_shipping_standard" );
											
											$order_id = $this->mysqli->insert_subscription_order( $product, $GLOBALS['ec_user'], $card, $subscription_id, $coupon_promocode_id, $order_notes, $this->subscription_option1_name, $this->subscription_option2_name, $this->subscription_option3_name, $this->subscription_option4_name, $this->subscription_option5_name, $this->subscription_option1_label, $this->subscription_option2_label, $this->subscription_option3_label, $this->subscription_option4_label, $this->subscription_option5_label, $quantity, $this->order_totals, $shipping_method, $this->tax, $discount_total );	
											do_action( 'wpeasycart_order_paid', $order_id );
											$order_row = $this->mysqli->get_order_row( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
											$order = new ec_orderdisplay( $order_row );
											$order_details = $this->mysqli->get_order_details( $order_id, $GLOBALS['ec_cart_data']->cart_data->user_id );
											$subscription->send_email_receipt( $GLOBALS['ec_user'], $order, $order_details );
											$this->mysqli->update_product_stock( $product->product_id, $quantity );
											
											if( $subscription->payment_duration > 0 && $subscription->payment_duration == 1 ){
												$stripe->cancel_subscription( $GLOBALS['ec_user'], $subscription->stripe_subscription_id );
												$this->mysqli->cancel_stripe_subscription( $subscription->stripe_subscription_id );
											}
											
										}
										
										// Unset Variables Entered
										$GLOBALS['ec_cart_data']->checkout_session_complete( );
										
										if( $product->trial_period_days > 0 ){
											header( "location: " . $this->account_page . $this->permalink_divider . "ec_page=subscription_details&subscription_id=" . $subscription_id );
										
										}else{
											header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=checkout_success&order_id=" . $order_id );
										}
									
									}else{
										header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_failed" );	
									
									}// Close check for subscription insertion
									
								}else{
									header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_added_failed" );
								
								}// Close check for stripe plan insertion
								
							}else{
								header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=card_error" );
							
							}// Close check for card insertion
						
						}else{
							header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=user_insert_error" );
						
						}// Close check for customer insertion to stripe check
						
					}else if( class_exists( 'ec_paypal' ) ){ // Close check for PayPal
						
						$coupon_promocode_id = "";
						if( isset( $coupon_row ) )
							$coupon_promocode_id = $coupon_row->promocode_id;
										
						$order_id = $this->mysqli->insert_paypal_subscription_order( $product, $GLOBALS['ec_user'], $coupon_promocode_id, $order_notes, $this->subscription_option1_name, $this->subscription_option2_name, $this->subscription_option3_name, $this->subscription_option4_name, $this->subscription_option5_name, $this->subscription_option1_label, $this->subscription_option2_label, $this->subscription_option3_label, $this->subscription_option4_label, $this->subscription_option5_label, $quantity );
						$paypal = new ec_paypal( );
						$paypal->display_subscription_form( $order_id, $GLOBALS['ec_user'], $product );
						
						// Unset Variables Entered
						$GLOBALS['ec_cart_data']->cart_data->subscription_option1 = "";
						$GLOBALS['ec_cart_data']->cart_data->subscription_option2 = "";
						$GLOBALS['ec_cart_data']->cart_data->subscription_option3 = "";
						$GLOBALS['ec_cart_data']->cart_data->subscription_option4 = "";
						$GLOBALS['ec_cart_data']->cart_data->subscription_option5 = "";
						
						$GLOBALS['ec_cart_data']->cart_data->subscription_advanced_option = "";
						
						$GLOBALS['ec_cart_data']->cart_data->billing_first_name = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_last_name = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_address_line_1 = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_address_line_2 = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_city = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_state = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_zip = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_country = "";
						$GLOBALS['ec_cart_data']->cart_data->billing_phone = "";
						
						$GLOBALS['ec_cart_data']->cart_data->shipping_selector = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_first_name = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_last_name = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_1 = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_address_line_2 = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_city = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_state = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_zip = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_country = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_phone = "";
						
						$GLOBALS['ec_cart_data']->cart_data->use_shipping = "";
						$GLOBALS['ec_cart_data']->cart_data->shipping_method = "";
						$GLOBALS['ec_cart_data']->cart_data->expedited_shipping = ""; 
						
						if( $GLOBALS['ec_cart_data']->cart_data->user_id == "" ){
							$GLOBALS['ec_cart_data']->cart_data->email = "";
							$GLOBALS['ec_cart_data']->cart_data->first_name = "";
							$GLOBALS['ec_cart_data']->cart_data->last_name = "";
						}
						
						$GLOBALS['ec_cart_data']->cart_data->create_account = "";
						$GLOBALS['ec_cart_data']->cart_data->coupon_code = "";
						$GLOBALS['ec_cart_data']->cart_data->giftcard = "";
						$GLOBALS['ec_cart_data']->cart_data->order_notes = "";
						setcookie('ec_cart_id', "", time( ) - 300, "/" ); 
		
						$GLOBALS['ec_cart_data']->clear_db_session( );
						
						global $wpdb;
						
						$vals = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
						$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
						
						$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
						$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
						while( $check_tempcart_id || $check_tempcart_data_id ){ // If we get a result, create new and go until we get a unique tempcart id...
							$session_cart_id = $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)] . $vals[rand(0, 25)];
							$check_tempcart_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart.* FROM ec_tempcart WHERE ec_tempcart.session_id = %s", $session_cart_id ) );
							$check_tempcart_data_id = $wpdb->get_row( $wpdb->prepare( "SELECT ec_tempcart_data.* FROM ec_tempcart_data WHERE ec_tempcart_data.session_id = %s", $session_cart_id ) );
						}
						$GLOBALS['ec_cart_id'] = $session_cart_id;
						$_SESSION['ec_cart_id'] = $session_cart_id;
						setcookie( 'ec_cart_id', $session_cart_id, time( ) + ( 3600 * 24 * 1 ), "/" );
		
						$GLOBALS['ec_cart_data'] = new ec_cart_data( $GLOBALS['ec_cart_data']->ec_cart_id );
						
						die( );
						
					}else{ // Close check for paypal
						$GLOBALS['ec_cart_data']->save_session_to_db( );
						header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_setup_error" );
					}
			
				}else{
					$GLOBALS['ec_cart_data']->save_session_to_db( );
					header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=already_subscribed" );
				
				}// Close check for already subscribed error
			
			}else{
				
				$GLOBALS['ec_cart_data']->save_session_to_db( );
				header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=subscription_not_found" );
				
			}// Close check for subscription existing
			
		}else{
			$GLOBALS['ec_cart_data']->save_session_to_db( );
			header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $model_number . "&ec_cart_error=email_exists" );
			
		}// Close user exists error for guest checkout
		
	}
	
	private function process_send_inquiry( ){
		
		$inquiry_email = filter_var( stripslashes( $_POST['ec_inquiry_email'] ), FILTER_SANITIZE_EMAIL );
		$inquiry_name = stripslashes( $_POST['ec_inquiry_name'] );
		$inquiry_message = stripslashes( $_POST['ec_inquiry_message'] );
		$model_number = $_POST['ec_inquiry_model_number'];
		if( isset( $_POST['ec_inquiry_send_copy'] ) )
			$send_copy = true;
		else
			$send_copy = false;
		
		$product = $this->mysqli->get_product( $model_number );
		$file_temp_num = rand( 1000000, 999999999 );
		if( $product->use_advanced_optionset ){
			$option_vals = $this->get_advanced_option_vals( $product->product_id, $file_temp_num );
		}else{
			$option1 = $option2 = $option3 = $option4 = $option5 = "";
			if( isset( $_POST['ec_option1'] ) )				$option1 = $GLOBALS['ec_options']->get_optionitem( $_POST['ec_option1'] );
			if( isset( $_POST['ec_option2'] ) )				$option2 = $GLOBALS['ec_options']->get_optionitem( $_POST['ec_option2'] );
			if( isset( $_POST['ec_option3'] ) )				$option3 = $GLOBALS['ec_options']->get_optionitem( $_POST['ec_option3'] );
			if( isset( $_POST['ec_option4'] ) )				$option4 = $GLOBALS['ec_options']->get_optionitem( $_POST['ec_option4'] );
			if( isset( $_POST['ec_option5'] ) )				$option5 = $GLOBALS['ec_options']->get_optionitem( $_POST['ec_option5'] );
		}
		
		if( $product && $inquiry_email != "" && $inquiry_name != "" && $inquiry_message != "" ){
			
			// Create mail script
			$email_logo_url = get_option( 'ec_option_email_logo' ) . "' alt='" . get_bloginfo( "name" );
			
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-Type: text/html; charset=utf-8";
			$headers[] = "From: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
			$headers[] = "Reply-To: " . stripslashes( get_option( 'ec_option_password_from_email' ) );
			$headers[] = "X-Mailer: PHP/".phpversion();
			
			$headers2   = array();
			$headers2[] = "MIME-Version: 1.0";
			$headers2[] = "Content-Type: text/html; charset=utf-8";
			$headers2[] = "From: " . $inquiry_email;
			$headers2[] = "Reply-To: " . $inquiry_email;
			$headers2[] = "X-Mailer: PHP/".phpversion();
			
			$has_product_options = false;
			
			ob_start();
			if( file_exists( WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php' ) )	
				include WP_PLUGIN_DIR . '/wp-easycart-data/design/layout/' . get_option( 'ec_option_base_layout' ) . '/ec_inquiry_email.php';	
			else
				include WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/design/layout/' . get_option( 'ec_option_latest_layout' ) . '/ec_inquiry_email.php';
			$message = ob_get_clean();
			
			$email_send_method = get_option( 'ec_option_use_wp_mail' );
			$email_send_method = apply_filters( 'wpeasycart_email_method', $email_send_method );
			
			if( $email_send_method == "1" ){
				if( $send_copy )
					wp_mail( $inquiry_email, $GLOBALS['language']->get_text( "product_details", "product_details_inquiry_title" ), $message, implode("\r\n", $headers ) );
				
				wp_mail( stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), $GLOBALS['language']->get_text( "product_details", "product_details_inquiry_title" ), $message, implode( "\r\n", $headers2 ) );
			}else if( $email_send_method == "0" ){
				$admin_email = stripslashes( get_option( 'ec_option_bcc_email_addresses' ) );
				$to = $inquiry_email;
				$subject = $GLOBALS['language']->get_text( "product_details", "product_details_inquiry_title" );
				$mailer = new wpeasycart_mailer( );
				if( $send_copy )
					$mailer->send_order_email( $to, $subject, $message );
				$mailer->send_order_email( $admin_email, $subject, $message );
			}else{
				if( $send_copy )
					do_action( 'wpeasycart_custom_inquiry_email', stripslashes( get_option( 'ec_option_order_from_email' ) ), $inquiry_email, stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), $GLOBALS['language']->get_text( "product_details", "product_details_inquiry_title" ), $message );
				else
					wp_mail( stripslashes( get_option( 'ec_option_bcc_email_addresses' ) ), $GLOBALS['language']->get_text( "product_details", "product_details_inquiry_title" ), $message, implode("\r\n", $headers2 ) );
			}
			
			if( get_option( 'ec_option_use_old_linking_style' ) )
				header( "location: " . $this->store_page . $this->permalink_divider . "model_number=" . $product->model_number . "&ec_store_success=inquiry_sent" );
			else
				header( "location: " . get_permalink( $product->post_id ) . $this->permalink_divider . "ec_store_success=inquiry_sent" );
			
		}
		
	}
	
	private function process_deconetwork_add_to_cart( ){
		
		$this->mysqli->deconetwork_add_to_cart( );
		header( "location: " . $this->cart_page );
	
	}
	
	public function process_subscribe_v3( ){
		
		$product_id = $_POST['product_id'];
		$cart_id = $GLOBALS['ec_cart_data']->ec_cart_id;
		$product = $this->mysqli->get_product( "", $product_id );
		$use_advanced_optionset = $product->use_advanced_optionset;
		$quantity = 1;
		if( isset( $_POST['ec_quantity'] ) )
			$quantity = $_POST['ec_quantity'];
			
		$GLOBALS['ec_cart_data']->cart_data->subscription_quantity = $quantity;
			
		//Product Options
		$GLOBALS['ec_cart_data']->cart_data->subscription_option1 = "";
		$GLOBALS['ec_cart_data']->cart_data->subscription_option2 = "";
		$GLOBALS['ec_cart_data']->cart_data->subscription_option3 = "";
		$GLOBALS['ec_cart_data']->cart_data->subscription_option4 = "";
		$GLOBALS['ec_cart_data']->cart_data->subscription_option5 = "";
		
		if( !$use_advanced_optionset ){
			
			if( isset( $_POST['ec_option1'] ) )				$GLOBALS['ec_cart_data']->cart_data->subscription_option1 = $_POST['ec_option1'];
			else											$GLOBALS['ec_cart_data']->cart_data->subscription_option1 = "";
			
			if( isset( $_POST['ec_option2'] ) )				$GLOBALS['ec_cart_data']->cart_data->subscription_option2 = $_POST['ec_option2'];
			else											$GLOBALS['ec_cart_data']->cart_data->subscription_option2 = "";
			
			
			if( isset( $_POST['ec_option3'] ) )				$GLOBALS['ec_cart_data']->cart_data->subscription_option3 = $_POST['ec_option3'];
			else											$GLOBALS['ec_cart_data']->cart_data->subscription_option3 = "";
			
			
			if( isset( $_POST['ec_option4'] ) )				$GLOBALS['ec_cart_data']->cart_data->subscription_option4 = $_POST['ec_option4'];
			else											$GLOBALS['ec_cart_data']->cart_data->subscription_option4 = "";
			
			
			if( isset( $_POST['ec_option5'] ) )				$GLOBALS['ec_cart_data']->cart_data->subscription_option5 = $_POST['ec_option5'];
			else											$GLOBALS['ec_cart_data']->cart_data->subscription_option5 = "";
			
		}
		
		if( $use_advanced_optionset ){
			
			$option_vals = $this->get_advanced_option_vals( $product_id, $cart_id );
			
		}
		
		$GLOBALS['ec_cart_data']->cart_data->subscription_advanced_option = maybe_serialize( $option_vals );
		$GLOBALS['ec_cart_data']->save_session_to_db( );
		
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $product->model_number );
		
	}
	
	private function process_update_subscription_quantity( ){
		
		$product_id = $_POST['product_id'];
		$product = $this->mysqli->get_product( "", $product_id );
		
		if( $product ){
		
			$quantity = $_POST[ 'ec_quantity' ];
			$GLOBALS['ec_cart_data']->cart_data->subscription_quantity = $quantity;
		
		}
		
		$GLOBALS['ec_cart_data']->save_session_to_db( );
		header( "location: " . $this->cart_page . $this->permalink_divider . "ec_page=subscription_info&subscription=" . $product->model_number  );
	}
	/* END PROCESS FORM SUBMISSION FUNCTIONS */
	
	/* Customer File Upload Function */
	private function upload_customer_file( $tempcart_id, $upload_field_name ){
		
		# Check to see if the file is accessible
		if( isset($_FILES[$upload_field_name]['name']) && $_FILES[$upload_field_name]['name'] != '' ) {
			$max_filesize = 5000000;
			$max_filesize = apply_filters( 'wp_easycart_max_filesize_upload_limit', $max_filesize );
			
			$filetypes = array( 'text/plain', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip', 'application/x-bzip2', 'application/x-bzip', 'application/x-bzip2', 'application/x-gzip', 'application/x-gzip', 'multipart/x-gzip' );
			$filtered_file_types = apply_filters( 'wpeasycart_allowed_file_upload_types', $filetypes );
			if( is_array( $filtered_file_types) )
				$filetypes = $filtered_file_types;
			
			if( is_dir( WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/" ) )
				$upload_path =  WP_PLUGIN_DIR . "/wp-easycart-data/products/uploads/";
			else
				$upload_path =  WP_PLUGIN_DIR . "/wp-easycart/products/uploads/";
		 
			# Check to see if the filesize is too large
			if( $_FILES[$upload_field_name]['size'] <= $max_filesize && in_array( $_FILES[$upload_field_name]['type'], $filetypes ) ){
				
				# Create a custom dir for this order
				mkdir( $upload_path . $tempcart_id . "/", 0711 );
				
				# If file has gotten this far, it is successful
				$copy_to = $upload_path . $tempcart_id . "/" . $_FILES[$upload_field_name]['name'];
		
				# Upload the file
				$upload = move_uploaded_file( $_FILES[$upload_field_name]['tmp_name'], $copy_to );
		 
				# Check to see if upload was successful
				if( $upload ){
					return true;
				}
			}
		}
		return false;
	}
	
	private function sanatize_card_number( $card_number ){
		
		return preg_replace( "/[^0-9]/", "", $card_number );
	
	}
	
	private function get_payment_type( $card_number ){
		
		if( preg_match("/^5[1-5]\d{14}$/", $card_number ) )
                return "mastercard";
 
        else if( preg_match( "/^4[0-9]{12}(?:[0-9]{3}|[0-9]{6})?$/", $card_number))
                return "visa";
 
        else if( preg_match( "/^3[47][0-9]{13}$/", $card_number ) )
                return "amex";
 
        else if( preg_match( "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/", $card_number ) )
                return "diners";
 
        else if( preg_match( "/^6(?:011\d{12}|5\d{14}|4[4-9]\d{13}|22(?:1(?:2[6-9]|[3-9]\d)|[2-8]\d{2}|9(?:[01]\d|2[0-5]))\d{10})$/", $card_number ) )
                return "discover";
 
        else if( preg_match( "/^(?:2131|1800|35\d{3})\d{11}$/", $card_number ) )
                return "jcb";
				
		else
				return "Credit Card";
		
	}
	
	public function display_order_number_link( $order_id ){
		
		if( substr_count( $this->account_page, '?' ) )				$permalink_divider = "&";
		else														$permalink_divider = "?";
		
		if( $GLOBALS['ec_cart_data']->cart_data->is_guest == "" ){
			echo "<a href=\"" . $this->account_page . $permalink_divider . "ec_page=order_details&order_id=" . $order_id . "\">" . $order_id . "</a>";
		}else{
			echo "<a href=\"" . $this->account_page . $permalink_divider . "ec_page=order_details&order_id=" . $order_id . "&guest_key=" . $GLOBALS['ec_cart_data']->cart_data->guest_key . "\">" . $order_id . "</a>";
		}
	}
	
	public function get_shipping_method_name( ){
		return $this->mysqli->get_shipping_method_name( $GLOBALS['ec_cart_data']->cart_data->shipping_method );
	}
	
	public function get_payment_image_source( $image ){
		
		if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/" . $image ) ){
			return plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/" . $image );
		}else{
			return plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/" . $image );
		}
		
	}
	
	private function add_affiliatewp_subscription_order( $order_id, $user, $product ){
		
		if( affiliate_wp( )->tracking->was_referred( ) ){
			
			$affiliate_id = affiliate_wp( )->tracking->get_affiliate_id( );
			$default_rate = affwp_get_affiliate_rate( $affiliate_id );
			$has_affiliate_rule = false;
		
			$affiliate_rule = $this->mysqli->get_affiliate_rule( affiliate_wp()->tracking->get_affiliate_id( ), $product->product_id );
			if( $affiliate_rule )
				$has_affiliate_rule = true;
			
			if( $has_affiliate_rule ){
				if( $affiliate_rule->rule_type == "percentage" )
					$total_earned += ( $product->price * ( $affiliate_rule->rule_amount / 100 ) );
						
				else if( $affiliate_rule->rule_type == "amount" )
					$total_earned += $affiliate_rule->rule_amount;	
				
			}else
				$total_earned += ( $product->price * $default_rate );
			
			$data = array(
				'affiliate_id' => $affiliate_id,
				'visit_id'     => affiliate_wp()->tracking->get_visit_id( ),
				'amount'       => $total_earned,
				'description'  => $user->billing->first_name . " " . $user->billing->last_name,
				'reference'    => $order_id,
				'context'      => 'WP EasyCart',
			);
			$result = affiliate_wp()->referrals->add( $data );
			
			return $result;

		}
		
		return "";
		
	}
	
	public function get_selected_payment_method( ){
		$default_method =  get_option( 'ec_option_default_payment_type' );
		if( isset( $_SESSION['ec_selected_payment_method'] ) )
			return $_SESSION['ec_selected_payment_method'];
		else if( $default_method == "manual_bill" && $this->use_manual_payment( ) )
			return "manual_bill";
		else if( $default_method == "affirm" && get_option( 'ec_option_use_affirm' ) )
			return "affirm";
		else if( $default_method == "third_party" && $this->use_third_party( ) )
			return "third_party";
		else if( $default_method == "credit_card" && $this->use_payment_gateway( ) )
			return "credit_card";
		else if( $this->use_payment_gateway( ) )
			return "credit_card";
		else if( $this->use_third_party( ) )
			return "third_party";
		else if( get_option( 'ec_option_use_affirm' ) )
			return "affirm";
		else if( $this->use_manual_payment( ) )
			return "manual_bill";
	}
	
}

?>