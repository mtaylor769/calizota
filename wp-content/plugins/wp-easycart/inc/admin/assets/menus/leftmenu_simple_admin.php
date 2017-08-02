<div class="ec_admin_leftmenu">
    <div class="ec_admin_leftmenu_inner arrow_pos_1">
        <div class="ec_admin_leftmenu_header">EasyCart Simple Admin</div>
        <div class="ec_admin_leftmenu_item<?php if( !isset( $_GET['ec_simple_panel'] ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin">Plugin Version Chart</a></div>
        <div class="ec_admin_leftmenu_item"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">Try Advanced Admin</a></div>
        
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-products" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-products">View Products</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-product-new" ){ echo "_selected"; } ?>">&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-product-new">Add New Product</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-orders" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-orders">View Orders</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_simple_panel'] ) && $_GET['ec_simple_panel'] == "simple-users" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=simple-admin&ec_simple_panel=simple-users">View Users</a></div>
    </div>
</div>