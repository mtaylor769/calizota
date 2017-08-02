<?php

if( isset( $_GET['ec_success'] ) && $_GET['ec_success'] == "woo-imported" ){ ?>
	<div class="updated">
        <p>Your WooCommerce store has been imported to the EasyCart. There are no guarantees that all options have been imported, becuase Woo offers so many extensions. Please check over the data and manually add anything that may be missing.</p>
    </div>
<?php } ?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=woo-importer&ec_action=import-woo-products" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">Import From WooCommerce</div>
<div class="ec_adin_page_intro"><p>Importing your data from your WooCommerce store is as simple as a click of a button! Although we do our best to import your data, not everything is transferrable or is known about all extensions available to the Woo system. The following information is imported by our system:</p>
<ul>
	<li>Woo Product Categories</li>
    <li>Woo Attributes are imported as option sets to our system</li>
    <li>Woo Products are imported by the following rules:<ul>
    	<li>Title, Description, Short Description, Price (Sale/Regular), Allow Comments, Taxable, Download, Service Item (Virtual), SKU, Download File, Download Limit, Download Expiry, Manage Stock, Stock Status, Stock Quantity</li>
        <li>Connects Imported Attributes (now option sets) to products the same as Woo has connected.</li>
        <li>Connects Product Categories to Products.</li>
        <li>If no SKU available, random model number is created.</li>
        <li>Product images are copied into our system from WordPress upload system</li>
        <li>Limited to 5 images and first 5 of image gallery used</li>
        <li>If no image gallery, uses featured image</li>
    </ul></li>
</ul>

</div>

<?php if( class_exists( "WooCommerce" ) ){ ?>

<div class="ec_save_changes_row"><input type="submit" value="IMPORT WooCommerce DATA NOW" class="ec_save_changes_button" /></div>

<?php }else{ ?>
<div class="ec_save_changes_row">
<div class="error">
    <p>We cannot detect a version of WooCommerce installed, which may mean that this section does not apply to your site or WooCommerce has been deactivated. In order for us to complete a successful import from WooCommerce, we need a copy of WooCommerce Installed and activated on your site.</p>
</div></div>
<?php }?>
</form>