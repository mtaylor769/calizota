<div class="ec_admin_mainmenu">
	<div class="ec_admin_mainmenu_inner">
    	<div class="ec_admin_mainmenu_item"><a href="http://www.wpeasycart.com" class="ec_easycart_logo" target="_blank"></a></div>
        <div class="ec_admin_mainmenu_item<?php if( !isset( $_GET['ec_page'] ) || ( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "dashboard"  && $_GET['ec_panel'] == "statistics" ) ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=statistics">DASHBOARD</a></div>
        <div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "dashboard" && $_GET['ec_panel'] == "quick-start"  ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=dashboard&ec_panel=quick-start">QUICK START</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "store-setup" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=basic-setup">STORE SETUP</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "admin-console" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=admin-console&ec_panel=admin">STORE ADMIN</a></div>
    	<div class="ec_admin_mainmenu_item<?php if( isset( $_GET['ec_page'] ) && $_GET['ec_page'] == "help-support" ){ echo "_selected"; } ?>"><a href="admin.php?page=ec_adminv2&ec_page=help-support&ec_panel=support">HELP AND SUPPORT</a></div>
        <div class="ec_admin_mainmenu_searcharea"><form method="GET" action="https://www.wpeasycart.com/search-plugin-information/" target="_blank"><input type="submit" value="Search Docs" /><input type="text" name="q" placeholder="Enter Your Search" /></form></div>
    </div>
</div>