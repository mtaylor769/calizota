<?php
$isupdate = false;
if( isset( $_GET['ec_panel'] ) && $_GET['ec_panel'] == "colorize-easycart" && isset( $_GET['ec_action'] ) && $_GET['ec_action'] == "save_colors" && isset( $_POST['ec_option_details_main_color'] ) ){
	ec_update_colors( );
	$isupdate = true;
}
?>



<?php if( $isupdate ) { ?>
	<div id='setting-error-settings_updated' class='updated settings-success'><p><strong>Colorization saved.</strong></p></div>
<?php }?> 

<div class="ec_admin_page_title">Colorize EasyCart</div>
<div class="ec_adin_page_intro">This page allows you to set a default color, default sizing, and default design options. If you have upgraded to a V3 design package, you will be able to set defaults, which will be applied to all pages that you have not specifically set values to. If you wish to edit on a page by page basis, simply visit the page and use the live editing tools.</div>

<form action="admin.php?page=ec_adminv2&ec_page=store-setup&ec_panel=colorize-easycart&ec_action=save_colors" method="POST">
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Main Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_main_color" id="ec_option_details_main_color" value="<?php echo get_option( 'ec_option_details_main_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Second Color: </span>
        <span class="ec_colorizer_row_input"><input type="color" name="ec_option_details_second_color" id="ec_option_details_second_color" value="<?php echo get_option( 'ec_option_details_second_color' ); ?>" class="ec_color_block_input" style="width:45px;" /></span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Theme Background: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_use_dark_bg" id="ec_option_use_dark_bg">
    			<option value="1"<?php if( get_option( 'ec_option_use_dark_bg' ) == "1" ){?> selected="selected"<?php }?>>Dark Background</option>
        	    <option value="0"<?php if( get_option( 'ec_option_use_dark_bg' ) == "0" ){?> selected="selected"<?php }?>>Light Background</option>
    		</select>
    	</span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Page Options</div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Product Type: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_product_type" id="ec_option_default_product_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_type' ) == '1' ){ echo " selected='selected'"; }?>>Grid Type 1</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_type' ) == '2' ){ echo " selected='selected'"; }?>>Grid Type 2</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_type' ) == '3' ){ echo " selected='selected'"; }?>>Grid Type 3</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_type' ) == '4' ){ echo " selected='selected'"; }?>>Grid Type 4</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_type' ) == '5' ){ echo " selected='selected'"; }?>>Grid Type 5</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_type' ) == '6' ){ echo " selected='selected'"; }?>>List Type 6</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Hover Effect: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_product_image_hover_type" id="ec_option_default_product_image_hover_type">
                <option value="1"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '1' ){ echo " selected='selected'"; }?>>Image Flip</option>
                <option value="2"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '2' ){ echo " selected='selected'"; }?>>Image Crossfade</option>
                <option value="3"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '3' ){ echo " selected='selected'"; }?>>Lighten</option>
                <option value="5"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '5' ){ echo " selected='selected'"; }?>>Image Grow</option>
                <option value="6"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '6' ){ echo " selected='selected'"; }?>>Image Shrink</option>
                <option value="7"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '7' ){ echo " selected='selected'"; }?>>Grey-Color</option>
                <option value="8"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '8' ){ echo " selected='selected'"; }?>>Brighten</option>
                <option value="9"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '9' ){ echo " selected='selected'"; }?>>Image Slide</option>
                <option value="10"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '10' ){ echo " selected='selected'"; }?>>FlipBook</option>
                <option value="4"<?php if( get_option( 'ec_option_default_product_image_hover_type' ) == '4' ){ echo " selected='selected'"; }?>>No Effect</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Effect: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_product_image_effect_type" id="ec_option_default_product_image_effect_type">
                <option value="none"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'none' ){ echo " selected='selected'"; }?>>None</option>
                <option value="border"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'border' ){ echo " selected='selected'"; }?>>Border</option>
                <option value="shadow"<?php if( get_option( 'ec_option_default_product_image_effect_type' ) == 'shadow' ){ echo " selected='selected'"; }?>>Shadow</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Quick View: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_quick_view" id="ec_option_default_quick_view">
            	<option value="1"<?php if( get_option( 'ec_option_default_quick_view' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_quick_view' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Use Dynamic Images: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_dynamic_sizing" id="ec_option_default_dynamic_sizing">
            	<option value="1"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '1' ){ echo " selected='selected'"; }?>>On</option>
            	<option value="0"<?php if( get_option( 'ec_option_default_dynamic_sizing' ) == '0' ){ echo " selected='selected'"; }?>>Off</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Desktop Options</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
            <select name="ec_option_default_desktop_columns" id="ec_option_default_desktop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_desktop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
            </select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_desktop_image_height" id="ec_option_default_desktop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_desktop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_desktop_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Tablet Landscape</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_laptop_columns" id="ec_option_default_laptop_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_laptop_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_laptop_image_height" id="ec_option_default_laptop_image_height" type="number" value="<?php if( get_option( 'ec_option_default_laptop_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_laptop_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Tablet Portrait</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_tablet_wide_columns" id="ec_option_default_tablet_wide_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_wide_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_tablet_wide_image_height" id="ec_option_default_tablet_wide_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_wide_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_wide_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Smartphone Landscape</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_tablet_columns" id="ec_option_default_tablet_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_tablet_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_tablet_image_height" id="ec_option_default_tablet_image_height" type="number" value="<?php if( get_option( 'ec_option_default_tablet_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_tablet_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Default Product Responsive Smartphone Portrait</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Columns: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_default_smartphone_columns" id="ec_option_default_smartphone_columns">
                <option value="1"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
                <option value="3"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '3' ){ echo " selected='selected'"; }?>>3 Columns</option>
                <option value="4"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '4' ){ echo " selected='selected'"; }?>>4 Columns</option>
                <option value="5"<?php if( get_option( 'ec_option_default_smartphone_columns' ) == '5' ){ echo " selected='selected'"; }?>>5 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Image Height: </span>
        <span class="ec_colorizer_row_input">
        	<input name="ec_option_default_smartphone_image_height" id="ec_option_default_smartphone_image_height" type="number" value="<?php if( get_option( 'ec_option_default_smartphone_image_height' ) ){ echo str_replace( "px", "", get_option( 'ec_option_default_smartphone_image_height' ) ); }else{ echo "250"; } ?>" style="width:110px; float:left;" />px
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Product Details Columns</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Desktop: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_desktop" id="ec_option_details_columns_desktop">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_desktop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_desktop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_laptop" id="ec_option_details_columns_laptop">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_laptop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_laptop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_tablet_wide" id="ec_option_details_columns_tablet_wide">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_tablet_wide' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_tablet_wide' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_tablet" id="ec_option_details_columns_tablet">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_tablet' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_tablet' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_details_columns_smartphone" id="ec_option_details_columns_smartphone">
                <option value="1"<?php if( get_option( 'ec_option_details_columns_smartphone' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_details_columns_smartphone' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_admin_page_title" style="margin:30px 0 15px 0; font-size:14px;">Cart Page Columns</div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Desktop: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_desktop" id="ec_option_cart_columns_desktop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_desktop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_laptop" id="ec_option_cart_columns_laptop">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_laptop' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Tablet Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_tablet_wide" id="ec_option_cart_columns_tablet_wide">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet_wide' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Landscape: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_tablet" id="ec_option_cart_columns_tablet">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_tablet' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    <div class="ec_colorizer_row" style="float:left">
        <span class="ec_colorizer_row_label">Phone Portrait: </span>
        <span class="ec_colorizer_row_input">
        	<select name="ec_option_cart_columns_smartphone" id="ec_option_cart_columns_smartphone">
                <option value="1"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '1' ){ echo " selected='selected'"; }?>>1 Column</option>
                <option value="2"<?php if( get_option( 'ec_option_cart_columns_smartphone' ) == '2' ){ echo " selected='selected'"; }?>>2 Columns</option>
        	</select>
        </span>
    </div>
    
    <div class="ec_colorizer_button_row"><input type="submit" value="SAVE CHANGES" class="ec_save_changes_button" /></div>
</form>
	
<script>
jQuery( document ).ready( function( $ ){
	
	var custom_uploader;
	
	jQuery( '#upload_logo_button' ).click( function( e ){
 
		e.preventDefault( );
		
		if( custom_uploader ){
			custom_uploader.open( );
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media( {
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		} );
 
		custom_uploader.on( 'select', function( ){
			attachment = custom_uploader.state( ).get( 'selection' ).first( ).toJSON( );
			jQuery( '#email_logo_image' ).attr( "src", attachment.url );
			jQuery( '#ec_option_email_logo' ).val( attachment.url );
		} );
 
		custom_uploader.open( );
 
	});
} );
</script>