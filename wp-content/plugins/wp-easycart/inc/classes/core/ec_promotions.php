<?php

class ec_promotions{
	
	public $promotions;
	
	/****************************************
	* CONSTRUCTOR
	*****************************************/
	function __construct( ){
		$db = new ec_db( );
		$this->promotions = $db->get_promotions( );
	}
		
}

?>