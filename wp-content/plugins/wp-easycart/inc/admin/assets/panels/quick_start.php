<?php
$has_store = ec_is_store_page_setup( );
$has_cart = ec_is_cart_page_setup( );
$has_account = ec_is_account_page_setup( );
$has_admin = ec_is_admin_installed( );
$has_manufacturer = ec_has_manufacturer( );
$has_menu = ec_has_menu( );
$has_category = ec_has_category( );
$has_product = ec_has_product( );
$has_custom_store_design = ec_has_custom_store_design( );
$has_logo = ec_has_receipt_logo( );
$has_payment = ec_has_payment_methods( );
$has_tax = ec_has_tax( );
$has_shipping = ec_has_shipping( );
$has_order = ec_has_order( );
$has_demouser = ec_has_demouser( );

$ec_url = "admin.php?page=" . htmlspecialchars ( $_GET['page'], ENT_QUOTES );
if( isset( $_GET['ec_page'] ) )
	$ec_url .= "&ec_page=" . htmlspecialchars ( $_GET['ec_page'], ENT_QUOTES );
if( isset( $_GET['ec_panel'] ) )
	$ec_url .= "&ec_panel=" . htmlspecialchars ( $_GET['ec_panel'], ENT_QUOTES );

$store_id = get_option( 'ec_option_storepage' );
$store_page = get_permalink( $store_id );
?>

<div class="ec_quick_start_guide">
<div class="ec_admin_page_title">QUICK SETUP GUIDE</div>
<h4>The quick start guide should help you find the most important pages to help you setup your store quickly!</h4>

<?php if( class_exists( 'WooCommerce' ) ){ ?>
<div class="updated">
    <p>We see you have WooCommerce installed. If you would like to transfer your products to the EasyCart, please visit our <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=woo-importer">WooCommerce importer page here</a>.</p>
</div>
<?php } ?>

<div class="ec_quick_setup_area">
    
    <div class="ec_checklist_container<?php if( !$has_store || !$has_cart || !$has_account ){ ?> ec_required<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            1. Setup Required Pages
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_store || !$has_cart || !$has_account ){ ?>
        	<a href="<?php echo $ec_url; ?>&ec_action=add_pages" class="ec_checklist_button">Setup Pages Now</a>
			<?php }else{ ?>
            <div class="ec_checklist_completed"></div>
        	<?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            2. Install Store Admin
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin" class="ec_checklist_button">Install Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_inactive<?php }else if( !$has_manufacturer ){?> ec_required<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            3. Add Manufacturer(s)
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<div class="ec_checklist_button">INSTALL ADMIN FIRST</div>
            <?php }else if( !$has_manufacturer ){ ?>
            <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=manufacturers" class="ec_checklist_button">Add Manufacturer Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_inactive<?php }else if( !$has_category ){?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            4. Add Categories
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<div class="ec_checklist_button">INSTALL ADMIN FIRST</div>
            <?php }else if( !$has_category){ ?>
            <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=categories" class="ec_checklist_button">Add Category Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_inactive<?php }else if( !$has_product ){?> ec_required<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            5. Add Products
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<div class="ec_checklist_button">INSTALL ADMIN FIRST</div>
            <?php }else if( !$has_product){ ?>
            <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=products" class="ec_checklist_button">Add Product Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_custom_store_design ){ ?> ec_optional<?php } ?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            6. Setup Store Design
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_custom_store_design ){ ?>
        	<a href="<?php echo $store_page; ?>" class="ec_checklist_button">Edit Store Design</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_logo ){ ?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            7. Upload Logo
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_logo ){ ?>
        	<a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=email-settings" class="ec_checklist_button">Add Logo Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_payment ){ ?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            8. Add Payment Methods
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_payment ){ ?>
        	<a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=payment-settings" class="ec_checklist_button">Add Methods Now</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_inactive<?php }else if( !$has_shipping ){ ?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            9. Setup Shipping Rates
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<div class="ec_checklist_button">INSTALL ADMIN FIRST</div>
            <?php }else if( !$has_shipping ){ ?>
            <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=shipping" class="ec_checklist_button">Add Shipping</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_admin ){ ?> ec_inactive<?php }else if( $has_demouser ){?> ec_required<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            10. Remove Demo User
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_admin ){ ?>
        	<div class="ec_checklist_button">INSTALL ADMIN FIRST</div>
            <?php }else if( $has_demouser ){ ?>
            <a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin&ec_admin_panel=users" class="ec_checklist_button">Create New Admin Account and Remove Demo User.</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
    <div class="ec_checklist_container<?php if( !$has_order ){ ?> ec_optional<?php }?>">
        <div class="ec_checklist_header">
            <div class="ec_checklist_collapse"></div>
            <div class="ec_checklist_expand"></div>
            11. Complete First Order
        </div>
        <div class="ec_checklist_content">
        	<?php if( !$has_order ){ ?>
            <a href="<?php echo $store_page; ?>" class="ec_checklist_button">Buy Something Now!</a>
            <?php }else{ ?>
            <div class="ec_checklist_completed"></div>
            <?php }?>
        </div>
    </div>
    
</div>
</div>