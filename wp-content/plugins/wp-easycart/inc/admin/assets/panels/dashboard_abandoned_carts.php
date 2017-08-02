<?php
global $wpdb;

$isupdate = false;
if( isset( $_GET['action'] ) && $_GET['action'] == "send-abandoned-email" && isset( $_GET['tempcart_id'] ) ){
	wpeasycart_send_email_reminder( $_GET['tempcart_id'] );
	$isupdate = 1;
	
}else if( isset( $_GET['action'] ) && $_GET['action'] == "turn-on-abandoned-automation" ){
	if( !wp_next_scheduled( 'wpeasycart_abandoned_cart_automation' ) ){
		wp_schedule_event( time() + 10, 'daily', 'wpeasycart_abandoned_cart_automation' ); 
	}
	update_option( 'ec_option_abandoned_cart_automation', 1 );
	$isupdate = 2;

}else if( isset( $_GET['action'] ) && $_GET['action'] == "turn-off-abandoned-automation" ){
	wp_clear_scheduled_hook( 'wpeasycart_abandoned_cart_automation' ); 
	update_option( 'ec_option_abandoned_cart_automation', 0 );
	$isupdate = 3;
	
}else if( isset( $_GET['action'] ) && $_GET['action'] == "remove-from-list" && isset( $_GET['tempcart_session_id'] ) ){
	$wpdb->query( $wpdb->prepare( "UPDATE ec_tempcart SET hide_from_admin = 1 WHERE ec_tempcart.session_id = %s", $_GET['tempcart_session_id'] ) );
	$isupdate = 4;
}
$abandoned_carts = $wpdb->get_results( "SELECT ec_tempcart.tempcart_id, 
											   ec_tempcart.session_id,
											   ec_tempcart.quantity, 
											   ec_tempcart.abandoned_cart_email_sent, 
											   DATE_FORMAT( ec_tempcart.last_changed_date, '%b %e, %Y' ) AS tempcart_date, 
											   ec_tempcart_data.billing_first_name, 
											   ec_tempcart_data.billing_last_name, 
											   ec_tempcart_data.email, 
											   ec_product.title 
											   
										FROM ec_tempcart_data, ec_tempcart 
										LEFT JOIN ec_product ON ec_product.product_id = ec_tempcart.product_id 
										WHERE ec_tempcart.hide_from_admin = 0 AND
											  ec_tempcart_data.session_id = ec_tempcart.session_id AND 
											  ec_tempcart_data.email != '' AND 
											  ec_tempcart_data.email != 'guest' 
										
										ORDER BY ec_tempcart.session_id, 
												 last_changed_date DESC LIMIT 100" 
);
$products = $wpdb->get_results( "SELECT ec_product.product_id, ec_product.title FROM ec_product" );
?>

<div class="wrap">
	<?php if( $isupdate && $isupdate == "1" ) { ?>
        <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Abandoned Email Sent to User.</strong></p></div>
    <?php }else if( $isupdate && $isupdate == "2" ) { ?>
        <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Automatic abandoned cart emails will be sent after 3 days of inactivity.</strong></p></div>
    <?php }else if( $isupdate && $isupdate == "3" ) { ?>
        <div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Automatic abandoned cart emails are now OFF.</strong></p></div>
    <?php } ?>
    <h1>Abandoned Carts (w/User Info Entered) <?php if( get_option( 'ec_option_abandoned_cart_automation' ) ){ ?><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=abandoned-carts&action=turn-off-abandoned-automation" class="page-title-action">Turn off Automatic Abandoned Cart Emails</a><?php }else{ ?><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=abandoned-carts&action=turn-on-abandoned-automation" class="page-title-action">Turn on Automatic Abandoned Cart Emails</a><?php }?></h1>
    <table class="ec_inventory_status_table">
        <thead>
            <tr>
                <td class="ec_inventory_status_title">Product</td>
                <td class="ec_inventory_status_quantity">Quantity</td>
                <td class="ec_inventory_status_quantity">Customer</td>
                <td class="ec_inventory_status_quantity">Email</td>
                <td class="ec_inventory_status_quantity">Date</td>
                <td class="ec_inventory_status_quantity">Times Sent</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php 
            if( count( $abandoned_carts ) > 0 ){
				$last_session = '';
                $new_cart = false;
				foreach( $abandoned_carts as $cart ){ 
					if( $last_session != $cart->session_id ){
						$last_session = $cart->session_id;
						$new_cart = true;
					}
					if( $new_cart ){ ?>            
            <tr>
                <td colspan="7" height="1" bgcolor="#999999"></td>
            </tr>
					<?php } ?>
            <tr>
                <td class="ec_inventory_status_title"><?php echo $cart->title; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $cart->quantity; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $cart->billing_first_name . " " . $cart->billing_last_name; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $cart->email; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $cart->tempcart_date; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $cart->abandoned_cart_email_sent; ?></td>
                <td><?php if( $new_cart ){ ?><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=abandoned-carts&action=send-abandoned-email&tempcart_id=<?php echo $cart->tempcart_id; ?>">Email Reminder</a> | <a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=abandoned-carts&action=remove-from-list&tempcart_session_id=<?php echo $cart->session_id; ?>">Remove from List</a><?php }?></td>
            </tr>
            <?php 
					$new_cart = false;
				}
            }else{ ?>
            <tr>
                <td class="ec_inventory_status_title" colspan="4">No Abandoned Cart Found</td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    
    <h1 style="float:left; margin-top:25px;">Abandoned Products Stats (Last 7 Days)</h1>
    <table class="ec_inventory_status_table">
        <thead>
            <tr>
                <td class="ec_inventory_status_title">Product</td>
                <td class="ec_inventory_status_quantity">Quantity</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            if( count( $products ) > 0 ){
                foreach( $products as $cart ){
					$product_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ec_tempcart WHERE product_id = %d", $cart->product_id ) );
					$count = count( $product_rows );
					if( $count ){
				?>
            <tr>
                <td class="ec_inventory_status_title"><?php echo $cart->title; ?></td>
                <td class="ec_inventory_status_quantity"><?php echo $count; ?></td>
            </tr>
            <?php 
					}
				}
            }else{ ?>
            <tr>
                <td class="ec_inventory_status_title" colspan="4">No Abandoned Products Found</td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>