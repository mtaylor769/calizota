<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//All Code and Design is copyrighted by Level Four Development, LLC
//
//Level Four Development, LLC provides this code "as is" without warranty of any kind, either express or implied,     
//including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.         
//
//Only licnesed users may use this code and storfront for live purposes. All other use is prohibited and may be 
//subject to copyright violation laws. If you have any questions regarding proper use of this code, please
//contact Level Four Development, llc and EasyCart prior to use.
//
//All use of this storefront is subject to our terms of agreement found on Level Four Development, LLC's  website.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
class ec_admin_authentication{		
	
	private $db;
	
	public function __construct( ){
		
		global $wpdb;
		$this->db = $wpdb;

	}//ec_admin_authentication
	
	public function getregrequest( $reqid ){
		  
		  $sql = "SELECT ec_user.password FROM ec_user LEFT JOIN ec_role ON ( ec_user.user_level = ec_role.role_label ) WHERE ec_user.password = %s AND   ( ec_user.user_level = 'admin' OR ec_role.admin_access = 1 )";
		  $results = $this->db->get_results( $this->db->prepare( $sql, $reqid ) );
		  
		  if( count( $results ) > 0 ){
			  AmfphpAuthentication::addRole( 'admin' );
			  return array( "success" );
		  }else{
			  return array( "noresults" );
		  }
		  
	}//getregrequest

	public function login( $email, $password ){

		$sql = "SELECT ec_user.*, ec_role.admin_access FROM ec_user LEFT JOIN ec_role ON ( ec_user.user_level = ec_role.role_label ) WHERE ec_user.email = %s AND ec_user.password = %s AND ( ec_user.user_level = 'admin' OR ec_role.admin_access = 1 )";
		$results = $this->db->get_results( $this->db->prepare( $sql, $email, $password ) );
		  
		if( count( $results ) > 0 ){
			AmfphpAuthentication::addRole('admin');
			return $results;
		}else{
			return array( "noresults" );
		}
		
	}//login
	
}//ec_admin_authentication
?>