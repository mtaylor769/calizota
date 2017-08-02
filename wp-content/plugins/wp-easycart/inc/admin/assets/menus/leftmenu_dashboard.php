<?php
$ec_license = new ec_license( );
?>
<div class="ec_admin_leftmenu">
    <div class="ec_admin_leftmenu_inner arrow_pos_1">
        <div class="ec_admin_leftmenu_header">EasyCart Dashboard</div>
        <div class="ec_admin_leftmenu_item<?php if( ( !isset( $_GET['ec_panel'] ) && !$ec_license->is_registered( ) ) || ( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "quick-start"  ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=quick-start">Quick Start Guide</a></div>
		<?php if( !$ec_license->is_registered( ) ){ ?>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "plugin-information" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=plugin-information">Plugin Information</a></div>
        <?php }?>
        <div class="ec_admin_leftmenu_item<?php if( ( !isset( $_GET['ec_panel'] ) && $ec_license->is_registered( ) ) || ( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "statistics" ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics">Statistics</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "inventory-status" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=inventory-status">Inventory Status</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "abandoned-carts" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=abandoned-carts">Abandoned Carts</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "store-status" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=store-status">Store Status</a></div>
        <div class="ec_admin_leftmenu_item<?php if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "backup-store" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=backup-store">Backup Store</a></div>
    </div>
</div>