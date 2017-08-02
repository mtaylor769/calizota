<?php

if( isset( $_GET['ec_success'] ) && $_GET['ec_success'] == "oscommerce-imported" ){ ?>
	<div class="updated">
        <p>Your osCommerce store has been imported to the EasyCart. There are no guarantees that all options have been imported, becuase osCommerce offers so many extensions. Please check over the data and manually add anything that may be missing.</p>
    </div>
<?php } ?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=oscommerce-importer&ec_action=import-oscommerce-products" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">Import From osCommerce</div>
<div class="ec_adin_page_intro"><p>Importing your data from your osCommerce store is as simple as a click of a button! Although we do our best to import your data, not everything is transferrable or is known about all extensions available to the osCommerce system. The following information is imported by our system:</p>
<ul>
	<li>Product Categories</li>
    <li>Option Sets</li>
    <li>Option Item Price Changes</li>
    <li>Manufacturers</li>
    <li>Products are imported by the following rules:<ul>
    	<li>Stock quantity, model number, weight, image name, and manufacturer.</li>
        <li>Titles and descriptions are added to the products.</li>
        <li>Connects products to option sets.</li>
        <li>Connects products to categories.</li>
    </ul></li>
</ul>

</div>
<div class="ec_adin_page_intro"><p>***Please note! If you do not have osCommerce installed, clicking import will cause a server error and you will need to press the back button to return to your WordPress admin. Please only use this feature if you are really importing from osCommerce.</p></div>

<div class="ec_save_changes_row"><input type="submit" value="IMPORT osCommerce DATA NOW" class="ec_save_changes_button" /></div>

</form>