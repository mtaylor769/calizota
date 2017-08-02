<?php

class ec_promotion{
	
	private $mysqli;								// ec_db structure
	public $promotions = array( );					// array of ec_promotion_item structures
	
	function __construct( ){
		$this->mysqli = new ec_db( );
		$promotion_rows = $GLOBALS['ec_promotions']->promotions;
		for( $i=0; $i<count( $promotion_rows ); $i++ ){
			$this->promotions[$i] = new ec_promotion_item( $promotion_rows[$i] );
		}
	}
	
	public function get_discount_total( $subtotal ){
		$cart_discount_total = 0;
		// Loop through promotions based on entire cart
		for( $i=0; $i<count( $this->promotions ); $i++ ){
			//price/percentage off when certain dollar amount reached
			if( $this->promotions[$i]->promotion_type == 6 ){
				if( $subtotal > $this->promotions[$i]->price2 ){
					// Discount cart by price 1
					if( $this->promotions[$i]->price1 != 0 ){
						if( $this->promotions[$i]->price1 > $cart_discount_total ){
							$cart_discount_total = $this->promotions[$i]->price1;
						}
					// Discount cart by percentage 1
					}else if( $this->promotions[$i]->percentage1 != 0 ){
						if( ( $subtotal * $this->promotions[$i]->percentage1 / 100 ) > $cart_discount_total ){
							$cart_discount_total = ( $subtotal * $this->promotions[$i]->percentage1 / 100 );
						}
					}
				}
			}
		}
		return $cart_discount_total;
	}
	
	public function apply_promotions_to_cart( &$cart, &$subtotal, &$total_promotion_text ){
		// Loop through possible individualized promotions for each cart row
		for( $i=0; $i<count( $cart ); $i++ ){
			$this->apply_promotion( $cart, $i );	
		}
		
		// Total Cart Discount Separate
		$cart_discount_total = 0;
		
		// Loop through promotions based on entire cart
		for( $i=0; $i<count( $this->promotions ); $i++ ){
			//price/percentage off when certain dollar amount reached
			if( $this->promotions[$i]->promotion_type == 6 ){
				if( $subtotal > $this->promotions[$i]->price2 ){
					// Discount cart by price 1
					if( $this->promotions[$i]->price1 != 0 ){
						if( $this->promotions[$i]->price1 > $cart_discount_total ){
							$cart_discount_total = $this->promotions[$i]->price1;
							$total_promotion_text = $this->promotions[$i]->promotion_name;
						}
					// Discount cart by percentage 1
					}else if( $this->promotions[$i]->percentage1 != 0 ){
						if( ( $subtotal * $this->promotions[$i]->percentage1 / 100 ) > $cart_discount_total ){
							$cart_discount_total = ( $subtotal * $this->promotions[$i]->percentage1 / 100 );
							$total_promotion_text = $this->promotions[$i]->promotion_name;
						}
					}
				}
			}
		}
		
		return $cart_discount_total;
	}
	
	public function get_shipping_discounts( $cart_subtotal, $shipping_total, &$shipping_promotion_text ){
		$shipping_discount = 0;
		
		// Loop through promotions based on entire cart
		for( $i=0; $i<count( $this->promotions ); $i++ ){
			// Shipping discount off total shipping
			// If 0 and 0, then free shipping
			if( $this->promotions[$i]->promotion_type == 4 ){
				if( $cart_subtotal >= $this->promotions[$i]->price2 ){
					
					// Discount cart by price 1
					if( $this->promotions[$i]->price1 != 0 ){
						if( $this->promotions[$i]->price1 > $shipping_discount ){
							$shipping_promotion_text = $this->promotions[$i]->promotion_name;
							$shipping_discount_total = $this->promotions[$i]->price1;
						}
					// Discount cart by percentage 1
					}else if( $this->promotions[$i]->percentage1 != 0 ){
						if( ( $shipping_total * $this->promotions[$i]->percentage1 / 100 ) > $shipping_discount_total ){
							$shipping_promotion_text = $this->promotions[$i]->promotion_name;
							$shipping_discount_total = ( $shipping_total * $this->promotions[$i]->percentage1 / 100 );
						}
					// Free Shipping
					}else{
						$shipping_promotion_text = $this->promotions[$i]->promotion_name;
						$shipping_discount_total = $shipping_total;
					}
				}
			}
		}
		
		if( isset( $shipping_discount_total ) && isset( $shipping_total ) && $shipping_discount_total > $shipping_total )
			$shipping_discount_total = $shipping_total;
		
		if( isset( $shipping_discount_total ) )
			return $shipping_discount_total;
		else
			return 0;
		
	}
	
	private function apply_promotion( &$cart, $cart_index ){
		
		if( $cart[$cart_index]->is_giftcard )
			return 0;
			
		$best_discount = 0;
		
		for( $i=0; $i<count( $this->promotions ); $i++ ){
			
			//price/percentage off product or groups of products or products with specific manufacturer
			if( $this->promotions[$i]->promotion_type == 1 ){
				$match_found = false;
				// Promotion applies to the product_id match
				if( $this->promotions[$i]->product_id_1 != 0 && $this->promotions[$i]->product_id_1 == $cart[$cart_index]->product_id ){
					$match_found = true;
				}else if( $this->promotions[$i]->manufacturer_id_1 != 0 && $this->promotions[$i]->manufacturer_id_1 == $cart[$cart_index]->manufacturer_id ){
					$match_found = true;
				}else if( $this->promotions[$i]->category_id_1 != 0 && $this->mysqli->has_category_match( $this->promotions[$i]->category_id_1, $cart[$cart_index]->product_id ) ){
					$match_found = true;
				}
				
				if( $match_found ){
					// Discount is Price
					if( $this->promotions[$i]->price1 != 0 ){
						$new_discount = $this->promotions[$i]->price1;
						if( $new_discount > $best_discount )
							$best_discount = $new_discount;
						
					// Discount is Percentage
					}else if( $this->promotions[$i]->percentage1 != 0 ){
						$new_discount = ( $cart[$cart_index]->unit_price * $this->promotions[$i]->percentage1 / 100 );
						if( $new_discount > $best_discount )
							$best_discount = $new_discount;
					
					}
					
				}
			
			}
		}	
		
		if( $best_discount > 0 ){
			$cart[$cart_index]->prev_price = $cart[$cart_index]->unit_price;
			$cart[$cart_index]->unit_price = $cart[$cart_index]->unit_price - $best_discount;
			// Make sure the unit_price isn't less than 0!
			if( $cart[$cart_index]->unit_price < 0 )
				$cart[$cart_index]->unit_price = 0;
		
			// Update cart item total price
			$cart[$cart_index]->total_price = $cart[$cart_index]->unit_price * $cart[$cart_index]->quantity;
		}
	}
	
	public function single_product_promotion( $product_id, $manufacturer_id, $price, &$promotion_text ){
		$best_discount = 0;
		$discount_price = $price;
		
		for( $i=0; $i<count( $this->promotions ); $i++ ){
			
			//price/percentage off product or groups of products or products with specific manufacturer
			if( $this->promotions[$i]->promotion_type == 1 ){
				$match_found = false;
				// Promotion applies to the product_id match
				if( $this->promotions[$i]->product_id_1 != 0 && $this->promotions[$i]->product_id_1 == $product_id ){
					$match_found = true;
				}else if( $this->promotions[$i]->manufacturer_id_1 != 0 && $this->promotions[$i]->manufacturer_id_1 == $manufacturer_id ){
					$match_found = true;
				}else if( $this->promotions[$i]->category_id_1 != 0 && $this->mysqli->has_category_match( $this->promotions[$i]->category_id_1, $product_id ) ){
					$match_found = true;
				}
				
				if( $match_found ){
					// Discount is Price
					if( $this->promotions[$i]->price1 != 0 ){
						$new_discount = $this->promotions[$i]->price1;
						if( $new_discount > $best_discount ){
							$best_discount = $new_discount;
							$promotion_text = $this->promotions[$i]->promotion_name;
						}
						
					// Discount is Percentage
					}else if( $this->promotions[$i]->percentage1 != 0 ){
						$new_discount = ( $price * $this->promotions[$i]->percentage1 / 100 );
						if( $new_discount > $best_discount ){
							$best_discount = $new_discount;
							$promotion_text = $this->promotions[$i]->promotion_name;
						}
					}	
				}
			}
		}	
		
		if( $best_discount > 0 ){
			$discount_price = $price - $best_discount;
			
			// Make sure the unit_price isn't less than 0!
			if( $discount_price < 0 )
				$discount_price = 0;
		
		}
		
		return $discount_price;	
	}
	
}

?>