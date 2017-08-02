<?php 

$validate = new ec_validation; 
$license = new ec_license;

if(isset($_POST['isupdate'])){
	
	update_option( 'ec_option_xsmall_width', $_POST['ec_option_xsmall_width'] );
	update_option( 'ec_option_xsmall_height', $_POST['ec_option_xsmall_height'] );
	update_option( 'ec_option_small_width', $_POST['ec_option_small_width'] );
	update_option( 'ec_option_small_height', $_POST['ec_option_small_height'] );
	update_option( 'ec_option_medium_width', $_POST['ec_option_medium_width'] );
	update_option( 'ec_option_medium_height', $_POST['ec_option_medium_height'] );
	update_option( 'ec_option_large_width', $_POST['ec_option_large_width'] );
	update_option( 'ec_option_large_height', $_POST['ec_option_large_height'] );
	update_option( 'ec_option_swatch_small_width', $_POST['ec_option_swatch_small_width'] );
	update_option( 'ec_option_swatch_small_height', $_POST['ec_option_swatch_small_height'] );
	update_option( 'ec_option_swatch_large_width', $_POST['ec_option_swatch_large_width'] );
	update_option( 'ec_option_swatch_large_height', $_POST['ec_option_swatch_large_height'] );
		
}

if( isset( $_GET['dismiss_lite_banner'] ) ){
	update_option( 'ec_option_show_lite_message', '0' );	
}

?>

<div class="wrap">
<?php if(!$license->is_registered()) {; ?>
<div class="ribbon">This banner appears when you have a WordPress EasyCart FREE version installed. To purchase the FULL version, you must purchase a license at <a href="http://www.wpeasycart.com?ecid=admin_console" target="_blank">www.wpeasycart.com</a></div>
<?php }?>

<img src="<?php echo plugins_url('images/WP-Easy-Cart-Logo.png', __FILE__); ?>" />

<?php if($_GET['settings-updated'] == true) { ?>
<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>Settings saved.</strong></p></div>
<?php }?>  

<div class="ec_contentwrap">
   
    <h2>Store Images</h2>
    
    <form method="post" action="options.php">
		<?php settings_fields( 'ec-store-images-group' ); ?>
        <table width="100%" cellpadding="0" cellspacing="0" class="form-table">
            
            <tr valign="top">
              <td width="50%" class="platformheading" scope="row">Image Sizes</td>
              <td width="50%" class="platformheadingimage"><img src="<?php echo plugins_url('images/settings_icon.png', __FILE__); ?>" alt="" width="25" height="25" /></td>
            </tr>
            <tr valign="top">
              <td colspan="2" scope="row">Image sizes throughout your store can be altered easily by adjusting the pixel width and height of the following section. You may need to ensure you upload product photography in the same dimensions as below so that skewing of images does not occur.</td>
            </tr>
            <tr valign="top">
                <td class="itemheading" scope="row">X-Small Image Size (thumbnails on product details page):</td>
            
                <td>Width: <input name="ec_option_xsmall_width" type="text" value="<?php echo get_option('ec_option_xsmall_width'); ?>" style="width:100px;" />
&nbsp;&nbsp;&nbsp;                   Height: <input name="ec_option_xsmall_height" type="text" value="<?php echo get_option('ec_option_xsmall_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Small Image Size (used in account and featured products):</td>
            
                <td>Width: <input name="ec_option_small_width" type="text" value="<?php echo get_option('ec_option_small_width'); ?>" style="width:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;Height:
<input name="ec_option_small_height" type="text" value="<?php echo get_option('ec_option_small_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Medium Image Size (used in product list):</td>
            
                <td>Width: <input name="ec_option_medium_width" type="text" value="<?php echo get_option('ec_option_medium_width'); ?>" style="width:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;Height:
<input name="ec_option_medium_height" type="text" value="<?php echo get_option('ec_option_medium_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Large Image Size (used in product details main image):</td>
            
                <td>Width: <input name="ec_option_large_width" type="text" value="<?php echo get_option('ec_option_large_width'); ?>" style="width:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;Height:
<input name="ec_option_large_height" type="text" value="<?php echo get_option('ec_option_large_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Small Swatch Image Size (used in product list for products with a first option set using swatch icons):</td>
            
                <td>Width: <input name="ec_option_swatch_small_width" type="text" value="<?php echo get_option('ec_option_swatch_small_width'); ?>" style="width:100px;" />
                &nbsp;&nbsp;&nbsp; Height: <input name="ec_option_swatch_small_height" type="text" value="<?php echo get_option('ec_option_swatch_small_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <td class="itemheading" scope="row">Large Swatch Image Size (used in product details for products with a first option set using swatch icons):</td>
            
                <td>Width: <input name="ec_option_swatch_large_width" type="text" value="<?php echo get_option('ec_option_swatch_large_width'); ?>" style="width:100px;" />
                &nbsp;&nbsp;&nbsp; Height: <input name="ec_option_swatch_large_height" type="text" value="<?php echo get_option('ec_option_swatch_large_height'); ?>" style="width:100px;" /></td>
            </tr>
                 
      </table>
        
        <p class="submit">
        <input type="hidden" name="isupdate" value="1" />
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    
    </form>
    </div>
</div>