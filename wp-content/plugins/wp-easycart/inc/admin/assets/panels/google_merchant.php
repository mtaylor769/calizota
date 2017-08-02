<?php if( isset( $_GET['ec_success'] ) && $_GET['ec_success'] == "google-import-complete" ){ ?>

<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Google Merchant data has been saved.</strong></p></div>

<?php }?>

<div class="ec_admin_page_title">Setup Products for Google Merchant Feed</div>
<div class="ec_adin_page_intro">
  <p>Setting up Google Merchant requires you to set a lot of options that do not apply to the store, but are useful in the Google Merchant system. Please enter as many options as possible during setup for best results. Instructions to create a Google Merchant Feed are provided below.</p>
<ol>
	<li>Download the CSV <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=download-google-csv">here</a> and fill out the necessary information. Please note that the product_id, model_number, price, sale_price, and brand CANNOT be edited through the CSV file. This is for your reference only. This data must be edited through the EasyCart admin area and is done this way to allow you to quickly download the latest XML feed file and upload those changes to Google.</li>
    <li>Upload your CSV to import the merchant feed data: <br />
    	<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=upload-google-csv" method="POST" enctype="multipart/form-data" style="border:1px solid #939393; width:300px; padding:25px; text-align:center; line-height:45px; margin:20px 0; background:#EFEFEF;">
        	<input type="file" name="csv_file" /><br />
            <input type="submit" value="Import" />
        </form>
    </li>
	<li>Download your <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=download-feed">XML feed</a> and manually upload in you Google Merchant account under Feeds. You should start by selecting Mode as Test, Feed Type as Products, and when uploading select &quot;regular uploads by user&quot;. Please note that you are required by Google to include a GTIN, MPN, and condition with each product. Any product without these values will not be included in the XML feed file generated.</li>
    <li>Once the test is successful, download your latest <a href="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=google-merchant&ec_action=download-feed">XML feed</a> and manually upload as a Standard Feed with the same options as before (non-test feed is the only diffence here) and be sure to choose &quot;regular uploads by user&quot;.</li>
    <li>You must visit this page, download, and re-upload the XML file whenever you need the data refreshed in your Google Merchant Account.</li>
    <li>While inserting Google Product Categories, please use data from <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">this list</a>.</li>
    <li>While inserting GTIN and MPN, use <a href="https://support.google.com/merchants/answer/160161?hl=en" target="_blank">this help page</a>.</li>
    <li>Product Type is strongly suggested by Google as well and to avoid the warning messages you should add a value to this field.</li>
</ol>

</div>