<?php require_once( "assets/inc/adminv2_functions.php" ); ?>
<?php include( "assets/elements/notifications.php" ); ?>
<?php include( "assets/menus/mainmenu.php" );
$ec_license = new ec_license( );
?>
<div class="ec_admin_holder<?php if( isset( $_GET['ec_panel'] ) && ($_GET['ec_panel'] == "admin" || $_GET['ec_panel'] == "demos" || $_GET['ec_panel'] == "support") ){ echo "_console"; } ?>">
	<?php
	if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "dashboard" ){
		include( "assets/menus/leftmenu_dashboard.php" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "store-setup" ){
		include( "assets/menus/leftmenu_setup.php" );
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "admin-console" ){
		if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "simple-admin" ){
			include( "assets/menus/leftmenu_simple_admin.php" );
		}else{
			// Hide this section
		}
	}else if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "help-support" ){
		//include( "assets/menus/leftmenu_help.php" );
	}else{
		include( "assets/menus/leftmenu_dashboard.php" );
	}
	?>
    
    <?php 
	if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "admin" ){
		include( "assets/panels/admin_console.php" );
	} else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "support" ){
		include( "assets/panels/support.php" );
	} else { ?>
    <div class="ec_admin_content">
    	<div class="ec_admin_content_inner">
        	<?php 
			include( "assets/elements/popup.php" );
			if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "statistics" ){
				include( "assets/panels/dashboard_statistics.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "inventory-status" ){
				include( "assets/panels/dashboard_inventory.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "abandoned-carts" ){
				include( "assets/panels/dashboard_abandoned_carts.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "store-status" ){
				include( "assets/panels/dashboard_status.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "backup-store" ){
				include( "assets/panels/dashboard_backup.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-setup" ){
				include( "assets/panels/basic_setup.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "basic-settings" ){
				include( "assets/panels/basic_settings.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-settings" ){
				include( "assets/panels/email_setup.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "email-test" ){
				include( "assets/panels/email_tests.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "colorize-easycart" ){
				include( "assets/panels/colorize_easycart.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "payment-settings" ){
				include( "assets/panels/payment_settings.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-design" ){
				include( WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . "/design/theme/" . get_option('ec_option_base_theme') . "/admin_panel.php");
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-language" ){
				include( "assets/panels/advanced_language.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "advanced-setup" ){
				include( "assets/panels/advanced_setup.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "woo-importer" ){
				include( "assets/panels/woo_importer.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "oscommerce-importer" ){
				include( "assets/panels/oscommerce_importer.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "google-merchant" ){
				include( "assets/panels/google_merchant.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "mymail-integration" ){
				include( "assets/panels/mymail_integration.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "design-management" ){
				include( "assets/panels/design_management.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "simple-admin" ){
				include( "assets/panels/simple_admin.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "plugin-information" ){
				include( "assets/elements/versions_chart.php" );
			}else if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "quick-start" ){
				include( "assets/panels/quick_start.php" );
			}else if( !$ec_license->is_registered( ) ){
				include( "assets/panels/quick_start.php" );
			}else{
				include( "assets/panels/dashboard_statistics.php" );
			}
			?>
        </div>
    </div>
    <?php } ?>
</div>