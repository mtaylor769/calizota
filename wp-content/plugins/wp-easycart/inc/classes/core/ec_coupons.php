<?php

class ec_coupons{
	
	public $coupons;
	
	/****************************************
	* CONSTRUCTOR
	*****************************************/
	function __construct( ){
		global $wpdb;
		$coupons = wp_cache_get( 'wpeasycart-coupons' );
		if( !$coupons ){
			$coupons = $wpdb->get_results( "SELECT ec_promocode.*, IF( ec_promocode.expiration_date < NOW( ), 1, 0 ) as coupon_expired FROM ec_promocode" );
			if( count( $coupons ) == 0 )
				$coupons = "EMPTY";
			wp_cache_set( 'wpeasycart-coupons', $coupons );
		}
		if( $coupons == "EMPTY" )
			$coupons = array( );
		$this->coupons = $coupons;
	}
	
	public function redeem_coupon_code( $promocode_id ){
		
		for( $i=0; $i<count( $this->coupons ); $i++ ){
			
			if( strtolower( $this->coupons[$i]->promocode_id ) == strtolower( $promocode_id ) )
				return $this->coupons[$i];
			
		}
		
		return false;
		
	}
		
		
}

?>