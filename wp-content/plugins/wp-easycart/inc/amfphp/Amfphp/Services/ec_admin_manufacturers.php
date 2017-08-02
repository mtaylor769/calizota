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

class ec_admin_manufacturers{		
	
	private $db;
	
	function __construct( ){
		
		global $wpdb;
		$this->db = $wpdb; 

	}//ec_admin_manufacturers

	public function _getMethodRoles( $methodName ){

			 if( $methodName == 'getmanufacturers' ) 		return array( 'admin' );
		else if( $methodName == 'getmanufacturerset' ) 		return array( 'admin' );
		else if( $methodName == 'deletemanufacturer' ) 		return array( 'admin' );
		else if( $methodName == 'updatemanufacturer' ) 		return array( 'admin' );
		else if( $methodName == 'addmanufacturer' ) 		return array( 'admin' );
		else  												return null;

	}//_getMethodRoles
	
	function getmanufacturers( ){
		
		$sql = "SELECT ec_manufacturer.* FROM ec_manufacturer ORDER BY ec_manufacturer.name";
		$results = $this->db->get_results( $sql );
		
		if( count( $results ) > 0 ){
			return $results;
		}else{
			return array( "noresults" );
		}
		
	}//getmanufacturers
	
	function getmanufacturerset( $startrecord, $limit, $orderby, $ordertype, $filter ){

		$sql = "SELECT SQL_CALC_FOUND_ROWS ec_manufacturer.* FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id != '' " . $filter . " ORDER BY " .  $orderby . " " . $ordertype . " LIMIT " . $startrecord . ", " . $limit;
		$results = $this->db->get_results( $sql );
		$totalquery = $this->db->get_var( "SELECT FOUND_ROWS()" );
		
		if( count( $results ) > 0 ){
			$results[0]->totalrows = $totalquery;
			return $results;
		}else{
			return array( "noresults" );
		}
		
	}//getmanufacturerset
	
	function deletemanufacturer( $manufacturerid ){
		
		// Delete WordPress Post
		$sql = "SELECT ec_manufacturer.post_id FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id = %d";
		$post_id = $this->db->get_var( $this->db->prepare( $sql, $manufacturerid ) );
		wp_delete_post( $post_id, true );
		
		// Delete EC DB Items
		$sql = "DELETE FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id = %d";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $manufacturerid ) );
		
		if( $rows_affected ){
			return array( "success" );
		}else{
			return array( "error" );
		}
		
	}//deletemanufacturer
	
	function updatemanufacturer( $manufacturerid, $manufacturer ){
		  
		$manufacturer = (array)$manufacturer;
		
		// Update WordPress Post
		$sql = "SELECT ec_manufacturer.post_id FROM ec_manufacturer WHERE ec_manufacturer.manufacturer_id = %d";
		$post_id = $this->db->get_var( $this->db->prepare( $sql, $manufacturerid ) );
		$post = array(	'ID'			=> $post_id,
						'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturerid . "\"]",
						'post_status'	=> "publish",
						'post_title'	=> $GLOBALS['language']->convert_text( $manufacturer['manufacturername'] ),
						'post_type'		=> "ec_store",
						'post_name'		=> str_replace(' ', '-', $GLOBALS['language']->convert_text( $manufacturer['manufacturername'] ) ),
		);
		wp_update_post( $post );
		
		// Update GUID
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "posts SET " . $wpdb->prefix . "posts.guid = %s WHERE " . $wpdb->prefix . "posts.ID = %d", get_permalink( $post_id ), $post_id ) );
		
		// Update EC DB Item
		$sql = "UPDATE ec_manufacturer SET ec_manufacturer.name = %s, ec_manufacturer.clicks = %s WHERE ec_manufacturer.manufacturer_id = %d";
		$this->db->query( $this->db->prepare( $sql, $manufacturer['manufacturername'], $manufacturer['clicks'], $manufacturerid ) );
		
		return array( "success" );
		
	}//updatemanufacturer
	
	function addmanufacturer( $manufacturer ){
		
		$manufacturer = (array)$manufacturer;
		
		// Insert EC DB Item
		$sql = "INSERT INTO ec_manufacturer( ec_manufacturer.name, ec_manufacturer.clicks ) VALUES( '%s', '%s' )";
		$rows_affected = $this->db->query( $this->db->prepare( $sql, $manufacturer['manufacturername'], $manufacturer['clicks'] ) );
		
		if( $rows_affected ){
			$manufacturerid = $this->db->insert_id;
		
			// Insert a WordPress Custom post type post.
			$post = array(	'post_content'	=> "[ec_store manufacturerid=\"" . $manufacturerid . "\"]",
							'post_status'	=> "publish",
							'post_title'	=> $GLOBALS['language']->convert_text( $manufacturer['manufacturername'] ),
							'post_type'		=> "ec_store"
			);
			$post_id = wp_insert_post( $post );
			
			// Update post_id for EC DB Item
			$db = new ec_db( );
			$db->update_manufacturer_post_id( $manufacturerid, $post_id );
		
			return array( "success" );
		
		}else{
			return array( "error" );
		}
		
	}//addmanufacturer

}//ec_admin_manufacturers
?>