<?php 
	global $wpdb;
	$isupdate = false;
	$isinsert = false;
	$isdelete_product = false;
	$isdelete_order = false;
	$isdelete_user = false;
	$isproductlimit = false;
	
	// Process actions if needed
	if( isset( $_POST['ec_simple_admin_action'] ) ){
		if( $_POST['ec_simple_admin_action'] == "add-product" ){
			$total_prods = $wpdb->get_var( "SELECT COUNT( ec_product.product_id ) FROM ec_product" );
			
			if( $total_prods < 25 ){
			
				$ec_product_title = $_POST['ec_product_title'];
				$ec_product_model_number = preg_replace( '/[^a-zA-Z0-9_\-]/s', '', $_POST['ec_product_model_number'] );
				$ec_product_weight = $_POST['ec_product_weight'];
				$ec_product_manufacturer = $_POST['ec_product_manufacturer'];
				$ec_product_price = $_POST['ec_product_price'];
				$ec_product_description = $_POST['ec_product_description'];
				$ec_product_image = $_POST['ec_product_image'];
				
				// Place file on server, into the images folder
				$filename = $_FILES['ec_product_image']['name'];	
				$filetmpname = $_FILES['ec_product_image']['tmp_name'];	
				$fileType = $_FILES["ec_product_image"]["type"];
				$fileSizeMB = ($_FILES["ec_product_image"]["size"] / 1024 / 1000);
				$explodedfilename = explode(".", $filename);
				$nameoffile = $explodedfilename[0];
				$fileextension = $explodedfilename[1];
	
				move_uploaded_file( $_FILES['ec_product_image']['tmp_name'], "../wp-content/plugins/wp-easycart/products/pics1/".$nameoffile."_".$date.".".$fileextension);
				copy( "../wp-content/plugins/wp-easycart/products/pics1/".$nameoffile."_".$date.".".$fileextension, "../wp-content/plugins/wp-easycart-data/products/pics1/".$nameoffile."_".$date.".".$fileextension );
			
				$image_name = $nameoffile."_".$date.".".$fileextension;
				// End File Upload
				
				// Get manufacturer id OR add new manufacturer
				$sql = "SELECT ec_manufacturer.manufacturer_id FROM ec_manufacturer WHERE ec_manufacturer.name = %s";
				$manufacturer_id = $wpdb->get_var( $wpdb->prepare( $sql, $ec_product_manufacturer ) );
				
				if( $manufacturer_id == NULL ){
					// Insert a manufacturer
					$sql = "INSERT INTO ec_manufacturer( `name` ) VALUES( %s )";
					$wpdb->query( $wpdb->prepare( $sql, $ec_product_manufacturer ) );
					$manufacturer_id = $wpdb->insert_id;
				}
				// End manufacturer section
				
				// Insert Product
				$sql = "INSERT INTO ec_product( model_number, title, description, price, weight, manufacturer_id, image1, stock_quantity, activate_in_store, show_on_startup ) VALUES( %s, %s, %s, %s, %s, %d, %s, 999999, 1, 1 )";
				
				$wpdb->query( $wpdb->prepare( $sql, $ec_product_model_number, $ec_product_title, $ec_product_description, $ec_product_price, $ec_product_weight, $manufacturer_id, $image_name ) );
				// End Product Insert
				
				$isinsert = true;
			}else{
				$isproductlimit = true;
			}
		}else if( $_POST['ec_simple_admin_action'] == "update-product" ){
			$ec_product_title = $_POST['ec_product_title'];
			$ec_product_model_number = preg_replace( '/[^a-zA-Z0-9_\-]/s', '', $_POST['ec_product_model_number'] );
			$ec_product_weight = $_POST['ec_product_weight'];
			$ec_product_manufacturer = $_POST['ec_product_manufacturer'];
			$ec_product_price = $_POST['ec_product_price'];
			$ec_product_description = $_POST['ec_product_description'];
			$ec_product_image = $_POST['ec_product_image'];
			
			// Get manufacturer id OR add new manufacturer
			$sql = "SELECT ec_manufacturer.manufacturer_id FROM ec_manufacturer WHERE ec_manufacturer.name = %s";
			$manufacturer_id = $wpdb->get_var( $wpdb->prepare( $sql, $ec_product_manufacturer ) );
			
			if( $manufacturer_id == NULL ){
				// Insert a manufacturer
				$sql = "INSERT INTO ec_manufacturer( `name` ) VALUES( %s )";
				$wpdb->query( $wpdb->prepare( $sql, $ec_product_manufacturer ) );
				$manufacturer_id = $wpdb->insert_id;
			}
			// End manufacturer section
			
			if( isset( $_FILES['ec_product_image']['name'] ) && $_FILES['ec_product_image']['name'] != "" ){
			
				// Place file on server, into the images folder
				$filename = $_FILES['ec_product_image']['name'];	
				$filetmpname = $_FILES['ec_product_image']['tmp_name'];	
				$fileType = $_FILES["ec_product_image"]["type"];
				$fileSizeMB = ($_FILES["ec_product_image"]["size"] / 1024 / 1000);
				$explodedfilename = explode(".", $filename);
				$nameoffile = $explodedfilename[0];
				$fileextension = $explodedfilename[1];
	
				move_uploaded_file( $_FILES['ec_product_image']['tmp_name'], "../wp-content/plugins/wp-easycart/products/pics1/".$nameoffile."_".$date.".".$fileextension);
				copy( "../wp-content/plugins/wp-easycart/products/pics1/".$nameoffile."_".$date.".".$fileextension, "../wp-content/plugins/wp-easycart-data/products/pics1/".$nameoffile."_".$date.".".$fileextension );
			
				$image_name = $nameoffile."_".$date.".".$fileextension;
				// End File Upload
			
				// Update Product
				$sql = "UPDATE ec_product SET model_number = %s, title = %s, description = %s, price = %s, weight = %s, manufacturer_id = %d, image1 = %s WHERE product_id = %d";
				$wpdb->query( $wpdb->prepare( $sql, $ec_product_model_number, $ec_product_title, $ec_product_description, $ec_product_price, $ec_product_weight, $manufacturer_id, $image_name, $_POST['ec_product_product_id'] ) );
				// End Product Update
			}else{
				// Update Product
				$sql = "UPDATE ec_product SET model_number = %s, title = %s, description = %s, price = %s, weight = %s, manufacturer_id = %d WHERE product_id = %d";
				$wpdb->query( $wpdb->prepare( $sql, $ec_product_model_number, $ec_product_title, $ec_product_description, $ec_product_price, $ec_product_weight, $manufacturer_id, $_POST['ec_product_product_id'] ) );
				// End Product Update
			}
			$isupdate = true;
		}else if( $_POST['ec_simple_admin_action'] == "update-order" ){
			$order_id = $_POST['order_id'];
			$status_id = $_POST['orderstatus_id'];
			
			if( $status_id == "3" || $status_id == "6" || $status_id == "10" || $status_id == "15" )
				do_action( 'wpeasycart_order_paid', $order_id );
			else if( $status_id == "2" )
				do_action( 'wpeasycart_order_shipped', $order_id );
			else if( $status_id == "16" )
				do_action( 'wpeasycart_full_order_refund', $order_id );
			else if( $status_id == "17" )
				do_action( 'wpeasycart_partial_order_refund', $order_id );
			
			$sql = "UPDATE ec_order SET ec_order.orderstatus_id = %d WHERE ec_order.order_id = %d";
			$wpdb->query( $wpdb->prepare( $sql, $status_id, $order_id ) );
		}
	}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-product-delete" ){
		
		$product_id = $_GET['product_id'];
		$sql = "DELETE FROM ec_product WHERE ec_product.product_id = %d";
		$wpdb->query( $wpdb->prepare( $sql, $product_id ) );
		$isdelete_product = true;
		
	}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-order-delete" ){
		
		$order_id = $_GET['order_id'];
		$sql = "DELETE FROM ec_order WHERE ec_order.order_id = %d";
		$wpdb->query( $wpdb->prepare( $sql, $order_id ) );
		$isdelete_order = true;
		
	}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-user-delete" ){
		
		$user_id = $_GET['user_id'];
		$sql = "DELETE FROM ec_user WHERE ec_user.user_id = %d";
		$wpdb->query( $wpdb->prepare( $sql, $user_id ) );
		$isdelete_user = true;
		
	}
?>
<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Product updated.</strong></p></div>
<?php }else if( $isinsert ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Product inserted.</strong></p></div>
<?php }else if( $isdelete_product ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Product deleted.</strong></p></div>
<?php }else if( $isproductlimit ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success' style="border-left-color:#F00;"><p><strong>You have reached the maximum products for the FREE version.</strong></p></div>
<?php }else if( $isdelete_order ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Order deleted.</strong></p></div>
<?php }else if( $isdelete_user ){ ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>User deleted.</strong></p></div>
<?php } ?> 

<div class="ec_admin_page_title">SIMPLE STORE ADMIN</div>
<div class="ec_adin_page_intro">You are currently viewing the simple product, order, and user management system. This is the free version and includes the bare essentials for those users who need a simple store. This version is missing everything except the ability to add/edit/delete a basic product, view a basic order, and view a basic user. We recommend at least downloading and using the <em><strong>14-day free trial</strong></em> of the EasyCart Administrative Console software as it includes hundreds of other features that can be accessed from your PC/MAC, iPad, android device, or direcly in WordPress.</div>

<?php 
// Product List Panel
if( isset( $_GET['ec_simple_panel'] ) && ( $_GET['ec_simple_panel'] == "simple-products" || $_GET['ec_simple_panel'] == "simple-product-delete" ) ){ 
$products = $wpdb->get_results( "SELECT ec_product.title, ec_product.product_id FROM ec_product ORDER BY ec_product.title ASC" );
?>
<div class="ec_admin_page_title">SIMPLE STORE PRODUCTS</div>
<?php foreach( $products as $product ){ ?>
<div class="ec_product_row">
	<span class="ec_product_row_label"><?php echo $GLOBALS['language']->convert_text( $product->title ); ?></span>
    <span class="ec_product_row_input"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-product-edit&product_id=<?php echo $product->product_id; ?>">edit</a> | <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-product-delete&product_id=<?php echo $product->product_id; ?>">delete</a></span>
</div>
<?php }?>

<?php 
// Product New Panel
}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-product-new" ){ 
$model_numbers = $wpdb->get_results( "SELECT ec_product.model_number FROM ec_product" );
?>
<input type="hidden" id="ec_product_model_number_list" value='<?php echo json_encode( $model_numbers ); ?>' />
<form method="POST" enctype="multipart/form-data" action="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-products">
<div class="ec_admin_page_title">SIMPLE STORE ADD NEW PRODUCT</div>
<div class="ec_admin_error_row" id="ec_product_title_error">*Enter a Title</div>
<div class="ec_admin_error_row" id="ec_product_model_number_error">*Enter a Model Number</div>
<div class="ec_admin_error_row" id="ec_product_model_number_exists_error">*This Model Number Exists</div>
<div class="ec_admin_error_row" id="ec_product_weight_error">*Enter a Weight</div>
<div class="ec_admin_error_row" id="ec_product_manufacturer_error">*Enter a Manufacturer</div>
<div class="ec_admin_error_row" id="ec_product_price_error">*Enter a Price</div>
<div class="ec_admin_error_row" id="ec_product_description_error">*Enter a Description</div>
<div class="ec_admin_error_row" id="ec_product_image_error">*Enter a Product Image</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Title:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_title" id="ec_product_title" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Model Number:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_model_number" id="ec_product_model_number" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Weight:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_weight" id="ec_product_weight" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Manufacturer:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_manufacturer" id="ec_product_manufacturer" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Price:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_price" id="ec_product_price" /></span>
</div>
<div class="ec_product_row_tall">
	<span class="ec_product_add_row_label">Description:</span>
    <span class="ec_product_add_row_input"><textarea name="ec_product_description" id="ec_product_description"></textarea></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Product Image:</span>
    <span class="ec_product_add_row_input"><input type="file" name="ec_product_image" id="ec_product_image" accept="image/jpg, image/jpeg, image/png, image/gif" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">&nbsp;&nbsp;&nbsp;</span>
    <span class="ec_product_add_row_input"><input type="submit" value="ADD PRODUCT" onclick="return ec_check_add_product( );" /></span>
</div>
<input type="hidden" name="ec_simple_admin_action" value="add-product" />
</form>
<?php 
// Product Edit Panel
}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-product-edit" ){ ?>
<?php 
$model_numbers = $wpdb->get_results( "SELECT ec_product.model_number FROM ec_product" );
$product_id = $_GET['product_id'];
$product = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.product_id, ec_product.title, ec_product.model_number, ec_product.weight, ec_manufacturer.name as manufacturer_name, ec_product.price, ec_product.description, ec_product.image1 FROM ec_product LEFT JOIN ec_manufacturer ON (ec_manufacturer.manufacturer_id = ec_product.manufacturer_id) WHERE ec_product.product_id = %d", $product_id ) );
?>
<input type="hidden" id="ec_product_model_number_list" value='<?php echo json_encode( $model_numbers ); ?>' />
<form method="POST" enctype="multipart/form-data" action="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-products">
<div class="ec_admin_page_title">SIMPLE STORE EDIT PRODUCT</div>
<div class="ec_admin_error_row" id="ec_product_title_error">*Enter a Title</div>
<div class="ec_admin_error_row" id="ec_product_model_number_error">*Enter a Model Number</div>
<div class="ec_admin_error_row" id="ec_product_model_number_exists_error">*This Model Number Exists</div>
<div class="ec_admin_error_row" id="ec_product_weight_error">*Enter a Weight</div>
<div class="ec_admin_error_row" id="ec_product_manufacturer_error">*Enter a Manufacturer</div>
<div class="ec_admin_error_row" id="ec_product_price_error">*Enter a Price</div>
<div class="ec_admin_error_row" id="ec_product_description_error">*Enter a Description</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Title:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_title" id="ec_product_title" value="<?php echo $product->title; ?>" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Model Number:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_model_number" id="ec_product_model_number" value="<?php echo $product->model_number; ?>" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Weight:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_weight" id="ec_product_weight" value="<?php echo $product->weight; ?>" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Manufacturer:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_manufacturer" id="ec_product_manufacturer" value="<?php echo $product->manufacturer_name; ?>" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Price:</span>
    <span class="ec_product_add_row_input"><input type="text" name="ec_product_price" id="ec_product_price" value="<?php echo $product->price; ?>" /></span>
</div>
<div class="ec_product_row_tall">
	<span class="ec_product_add_row_label">Description:</span>
    <span class="ec_product_add_row_input"><textarea name="ec_product_description" id="ec_product_description"><?php echo $product->description; ?></textarea></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">Product Image:</span>
    <span class="ec_product_add_row_input"><img src="../wp-content/plugins/wp-easycart-data/products/pics1/<?php echo $product->image1; ?>" /><input type="file" name="ec_product_image" id="ec_product_image" accept="image/jpg, image/jpeg, image/png, image/gif" /></span>
</div>
<div class="ec_product_row">
	<span class="ec_product_add_row_label">&nbsp;&nbsp;&nbsp;</span>
    <span class="ec_product_add_row_input"><input type="submit" value="UPDATE PRODUCT" onclick="return ec_check_edit_product( );"/></span>
</div>
<input type="hidden" name="ec_product_old_model_number" id="ec_product_old_model_number" value="<?php echo $product->model_number; ?>" />
<input type="hidden" name="ec_product_product_id" id="ec_product_product_id" value="<?php echo $product->product_id; ?>" />
<input type="hidden" name="ec_simple_admin_action" value="update-product" />
</form>

<?php 
// Order List Panel
}else if( isset( $_GET['ec_simple_panel'] ) && ( $_GET['ec_simple_panel'] == "simple-orders" || $_GET['ec_simple_panel'] == "simple-order-delete" ) ){
$orders = $wpdb->get_results( "SELECT ec_order.order_id, DATE_FORMAT( ec_order.order_date, '%M %d, %Y - %h:%i %p' ) as order_date, ec_order.billing_first_name, ec_order.billing_last_name, ec_order.grand_total, ec_orderstatus.order_status FROM ec_order LEFT JOIN ec_orderstatus ON ( ec_orderstatus.status_id = ec_order.orderstatus_id ) ORDER BY ec_order.order_id DESC" );
?>
<div class="ec_admin_page_title">SIMPLE STORE ORDERS</div>
<?php foreach( $orders as $order ){ ?>
<div class="ec_order_row">
    <span class="ec_order_row_label"><?php echo $order->order_id; ?> | <?php echo $order->order_date; ?> | <?php echo $order->billing_first_name; ?> <?php echo $order->billing_last_name; ?> | <?php echo $GLOBALS['currency']->get_currency_display( $order->grand_total ); ?> | <?php echo $order->order_status; ?></span>
    <span class="ec_order_row_input"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-order-view&order_id=<?php echo $order->order_id; ?>">view</a> | <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-order-delete&order_id=<?php echo $order->order_id; ?>">delete</a></span>
</div>

<?php 
} // foreach close

// Order Details View Panel
}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-order-view" ){ 
$order_id = $_GET['order_id'];
$sql = "SELECT ec_order.order_id, DATE_FORMAT( ec_order.order_date, '%M %d, %Y - %h:%i %p' ) as order_date, ec_order.billing_first_name, ec_order.billing_last_name, ec_order.grand_total, ec_orderstatus.order_status, ec_order.order_weight, ec_order.billing_first_name, ec_order.billing_last_name, ec_order.billing_address_line_1, ec_order.billing_city, ec_order.billing_state, ec_order.billing_country, ec_order.billing_zip, ec_order.billing_phone, ec_order.shipping_first_name, ec_order.shipping_last_name, ec_order.shipping_address_line_1, ec_order.shipping_city, ec_order.shipping_state, ec_order.shipping_country, ec_order.shipping_zip, ec_order.shipping_phone, ec_order.sub_total, ec_order.tax_total, ec_order.shipping_total, ec_order.discount_total, ec_order.vat_total, ec_order.duty_total, ec_order.shipping_method FROM ec_order LEFT JOIN ec_orderstatus ON ( ec_orderstatus.status_id = ec_order.orderstatus_id ) WHERE " . $wpdb->prepare( "ec_order.order_id = %d", $order_id );
$order = $wpdb->get_row( $sql );
$sql = "SELECT ec_orderstatus.status_id, ec_orderstatus.order_status FROM ec_orderstatus ORDER BY ec_orderstatus.order_status ASC";
$orderstatus = $wpdb->get_results( $sql );
$sql = "SELECT ec_orderdetail.image1, ec_orderdetail.quantity, ec_orderdetail.model_number, ec_orderdetail.title, ec_orderdetail.unit_price, ec_orderdetail.total_price FROM ec_orderdetail WHERE ec_orderdetail.order_id = %d ORDER BY ec_orderdetail.title ASC";
$orderdetails = $wpdb->get_results( $wpdb->prepare( $sql, $order_id ) );
?>
<div class="ec_admin_page_title">SIMPLE STORE ORDER VIEW</div>
<div class="ec_order_view_row"><span class="ec_order_view_row_label">Order Number:</span><span class="ec_order_view_row_input"><?php echo $order->order_id; ?></span></div>
<div class="ec_order_view_row"><span class="ec_order_view_row_label">Order Date:</span><span class="ec_order_view_row_input"><?php echo $order->order_date; ?></span></div>
<form method="POST" enctype="multipart/form-data" action="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-order-view&order_id=<?php echo $order->order_id; ?>">
<div class="ec_order_view_row"><span class="ec_order_view_row_label">Order Status:</span><span class="ec_order_view_row_input"><select name="orderstatus_id">
						<?php foreach( $orderstatus as $status ){ ?>
                        <option value="<?php echo $status->status_id; ?>"<?php if( $status->order_status == $order->order_status ){ echo " selected=\"selected\""; } ?>><?php echo $status->order_status; ?></option>
                        <?php } ?>
                   </select><input type="submit" value="UPDATE" /></span>
</div>
<input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>" />
<input type="hidden" name="ec_simple_admin_action" value="update-order" />
</form>
<div class="ec_order_view_row"><span class="ec_order_view_row_label">Order Weight:</span><span class="ec_order_view_row_input"><?php echo $order->order_weight; ?></span></div>

<div class="ec_order_view_row">
	<div class="ec_order_view_left">
        <div><strong>Billing Address</strong></div>
        <div><?php echo $order->billing_first_name . " " . $order->billing_last_name; ?></div>
        <div><?php echo $order->billing_address_line_1; ?></div>
        <div><?php echo $order->billing_city . ", " . $order->billing_state . " " . $order->billing_zip; ?></div>
        <div><strong>Country:</strong> <?php echo $order->billing_country; ?></div>
        <div><strong>Phone:</strong> <?php echo $order->billing_phone; ?></div>
    </div>
	<div class="ec_order_view_right">
        <div><strong>Shipping Address</strong></div>
        <div><?php echo $order->shipping_first_name . " " . $order->shipping_last_name; ?></div>
        <div><?php echo $order->shipping_address_line_1; ?></div>
        <div><?php echo $order->shipping_city . ", " . $order->shipping_state . " " . $order->shipping_zip; ?></div>
        <div><strong>Country:</strong> <?php echo $order->shipping_country; ?></div>
        <div><strong>Phone:</strong> <?php echo $order->shipping_phone; ?></div>
    </div>
</div>

<div class="ec_order_view_row">
	<div class="ec_order_view_left">
		<div><strong>Order Totals</strong></div>
		<div>Sub-Total: <?php echo $GLOBALS['currency']->get_currency_display( $order->sub_total ); ?></div>
        <?php if( $order->tax_total != "0.000" ){ ?><div>Tax: <?php echo $GLOBALS['currency']->get_currency_display( $order->tax_total ); ?></div><?php } ?>
        <?php if( $order->shipping_total != "0.000" ){ ?><div>Shipping: <?php echo $GLOBALS['currency']->get_currency_display( $order->shipping_total ); ?></div><?php } ?>
        <?php if( $order->discount_total != "0.000" ){ ?><div>Discounts: <?php echo $GLOBALS['currency']->get_currency_display( (-1)*$order->discount_total ); ?></div><?php } ?>
        <?php if( $order->vat_total != "0.000" ){ ?><div>VAT: <?php echo $GLOBALS['currency']->get_currency_display( $order->vat_total ); ?></div><?php } ?>
        <?php if( $order->duty_total != "0.000" ){ ?><div>Duty: <?php echo $GLOBALS['currency']->get_currency_display( $order->duty_total ); ?></div><?php } ?>
        <div><strong>Grand Total:</strong> <?php echo $GLOBALS['currency']->get_currency_display( $order->grand_total ); ?></div>
	</div>
</div>

<div class="ec_order_details_header">
	<div class="ec_order_details_inner">
		<div class="ec_order_details_column_image"><strong>Image</strong></div>
		<div class="ec_order_details_column_quantity"><strong>Quantity</strong></div>
		<div class="ec_order_details_column_model_number"><strong>Model Number</strong></div>
		<div class="ec_order_details_column_title"><strong>Title</strong></div>
		<div class="ec_order_details_column_total_price"><strong>Total Price</strong></div>
		<div class="ec_order_details_column_unit_price"><strong>Unit Price</strong></div>
	</div>
</div>
<?php foreach( $orderdetails as $orderdetail ){ ?>
<div class="ec_order_view_row">
	<div class="ec_order_details_inner">
		<div class="ec_order_details_column_image"><img src="../wp-content/plugins/wp-easycart-data/products/pics1/<?php echo $orderdetail->image1; ?>" /></div>
		<div class="ec_order_details_column_quantity"><?php echo $orderdetail->quantity; ?></div>
		<div class="ec_order_details_column_model_number"><?php echo $orderdetail->model_number; ?></div>
		<div class="ec_order_details_column_title"><?php echo $orderdetail->title; ?></div>
		<div class="ec_order_details_column_total_price"><?php echo $GLOBALS['currency']->get_currency_display( $orderdetail->total_price ); ?></div>
		<div class="ec_order_details_column_unit_price"><?php echo $GLOBALS['currency']->get_currency_display( $orderdetail->unit_price ); ?></div>
	</div>
</div>
<?php }?>

<?php 
// Users List Panel
}else if( isset( $_GET['ec_simple_panel'] ) && ( $_GET['ec_simple_panel'] == "simple-users" || $_GET['ec_simple_panel'] == "simple-user-delete" ) ){ 
$users = $wpdb->get_results( "SELECT ec_user.user_id, ec_user.email, ec_user.first_name, ec_user.last_name, ec_user.user_level FROM ec_user ORDER BY ec_user.email ASC" );
?>
<div class="ec_admin_page_title">SIMPLE STORE USERS</div>
<?php foreach( $users as $user ){ ?>
<div class="ec_order_row">
    <span class="ec_order_row_label"><?php echo $user->email; ?> | <?php echo $user->first_name; ?> <?php echo $user->last_name; ?> | <?php echo $user->user_level; ?></span>
    <span class="ec_order_row_input"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-user-view&user_id=<?php echo $user->user_id; ?>">view</a> | <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-user-delete&user_id=<?php echo $user->user_id; ?>">delete</a></span>
</div>

<?php 
}//close foreach

// User Details View Panel
}else if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-user-view" ){ 
$user_id = $_GET['user_id'];
$sql = "SELECT 
		ec_user.user_id, ec_user.email, ec_user.first_name, ec_user.last_name, ec_user.user_level, 
		billing.first_name as billing_first_name, billing.last_name as billing_last_name, billing.address_line_1 as billing_address_line_1, billing.city as billing_city, billing.state as billing_state, billing.zip as billing_zip, billing.country as billing_country, billing.phone as billing_phone,
		shipping.first_name as shipping_first_name, shipping.last_name as shipping_last_name, shipping.address_line_1 as shipping_address_line_1, shipping.city as shipping_city, shipping.state as shipping_state, shipping.zip as shipping_zip, shipping.country as shipping_country, shipping.phone as shipping_phone
		FROM ec_user LEFT JOIN ec_address as billing ON (ec_user.default_billing_address_id = billing.address_id) LEFT JOIN ec_address as shipping ON (ec_user.default_shipping_address_id = shipping.address_id)
		WHERE ec_user.user_id = %d";
		
$user = $wpdb->get_row( $wpdb->prepare( $sql, $user_id ) );
?>

<div class="ec_admin_page_title">SIMPLE STORE USER VIEW</div>
<div class="ec_order_view_row">
	<div class="ec_order_view_left">
        <div><strong>User Info</strong></div>
        <div>User Name: <?php echo $user->first_name . " " . $user->last_name; ?></div>
        <div>Email: <?php echo $user->email; ?></div>
        <div>User Level: <?php echo $user->user_level; ?></div>
    </div>
</div>

<div class="ec_order_view_row">
	<div class="ec_order_view_left">
        <div><strong>Billing Address</strong></div>
        <div><?php echo $user->billing_first_name . " " . $user->billing_last_name; ?></div>
        <div><?php echo $user->billing_address_line_1; ?></div>
        <div><?php echo $user->billing_city . ", " . $user->billing_state . " " . $user->billing_zip; ?></div>
        <div><strong>Country:</strong> <?php echo $user->billing_country; ?></div>
        <div><strong>Phone:</strong> <?php echo $user->billing_phone; ?></div>
    </div>
	<div class="ec_order_view_right">
        <div><strong>Shipping Address</strong></div>
        <div><?php echo $user->shipping_first_name . " " . $user->shipping_last_name; ?></div>
        <div><?php echo $user->shipping_address_line_1; ?></div>
        <div><?php echo $user->shipping_city . ", " . $user->shipping_state . " " . $user->shipping_zip; ?></div>
        <div><strong>Country:</strong> <?php echo $user->shipping_country; ?></div>
        <div><strong>Phone:</strong> <?php echo $user->shipping_phone; ?></div>
    </div>
</div>

<?php }else{
// Default Page	
include( plugin_dir_path( __FILE__ ) . "../elements/versions_chart.php" );
}?>