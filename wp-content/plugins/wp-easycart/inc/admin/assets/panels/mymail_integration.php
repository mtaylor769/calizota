<?php

if( isset( $_GET['ec_success'] ) && $_GET['ec_success'] == "mymail-imported" ){ ?>
	<div class="updated">
        <p>Your subscribers have been successfully imported to your MyMail plugin!</p>
    </div>
<?php } ?>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=mymail-integration&ec_action=import-subscribers" method="POST" enctype="multipart/form-data">
<div class="ec_admin_page_title">MyMail Integration</div>
<div class="ec_adin_page_intro"><p>WP EasyCart is a proud supporter of the MyMail Newsletter Plugin and highly recommends installing and using their plugin. Learn more about MyMail Here: <a href="http://codecanyon.net/item/mymail-email-newsletter-plugin-for-wordpress/3078294?ref=wpeasycart" target="_blank">MyMail WordPress Plugin</a>.</p>
<ul>
	<li>Download and install the MyMail plugin.</li>
    <li>Setup your MyMail plugin as is needed.</li>
    <li>Export existing subscribers to the MyMail system by clicking the button below.</li>
    <li>Newsletter subscribers will be automatically added to MyMail as they sign up through the EasyCart.</li>
</ul>

</div>

<?php if( function_exists( "mymail" ) ){ ?>

<div class="ec_save_changes_row"><input type="submit" value="ADD EXISTING SUBSCRIBERS TO MYMAIL NOW" class="ec_save_changes_button" /></div>

<?php }else{ ?>
<div class="ec_save_changes_row">
<div class="error">
    <p>We require that you first install the MyMail plugin before you can export existing subscribers to the MyMail platform. Once installed, return here to add your current customers.</p>
</div></div>
<?php }?>
</form>