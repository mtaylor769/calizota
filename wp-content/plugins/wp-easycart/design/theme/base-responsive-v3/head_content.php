<?php
$db = new ec_db( );
$page_options = $GLOBALS['ec_page_options']->page_options;

if( isset( $_GET['previewholder'] ) )
	$is_preview_holder = true;
else
	$is_preview_holder = false;

//----------------------//
// DISPLAY OPTIONS
//----------------------//

// DISPLAY TYPE SETUP
if( isset( $page_options->product_type ) )
	$product_type = $page_options->product_type;
else
	$product_type = get_option( 'ec_option_default_product_type' );
	
// DISPLAY QUICK VIEW SETUP
if( isset( $page_options->use_quickview ) )
	$quick_view = $page_options->use_quickview;
else
	$quick_view = get_option( 'ec_option_default_quick_view' );

// DISPLAY WIDTH SETUP
if( isset( $page_options->dynamic_image_sizing ) )  
	$dynamic_sizing = $page_options->dynamic_image_sizing;
else
	$dynamic_sizing = get_option( 'ec_option_default_dynamic_sizing' );

if( isset( $page_options->columns_smartphone ) )  
	$display_width_smartphone = (100/$page_options->columns_smartphone) . "%";
else if( get_option( 'ec_option_default_smartphone_columns' ) )
	$display_width_smartphone = (100/get_option( 'ec_option_default_smartphone_columns' ) ) . "%";
else
	$display_width_smartphone = (100/1) . "%";
	
if( isset( $page_options->columns_tablet ) )  
	$display_width_tablet = (100/$page_options->columns_tablet) . "%";
else if( get_option( 'ec_option_default_tablet_columns' ) )
	$display_width_tablet = (100/get_option( 'ec_option_default_tablet_columns' ) ) . "%";
else
	$display_width_tablet = (100/2) . "%";
	
if( isset( $page_options->columns_tablet_wide ) )  
	$display_width_tablet_wide = (100/$page_options->columns_tablet_wide) . "%";
else if( get_option( 'ec_option_default_tablet_wide_columns' ) )
	$display_width_tablet_wide = (100/get_option( 'ec_option_default_tablet_wide_columns' ) ) . "%";
else
	$display_width_tablet_wide = (100/2) . "%";
	
if( isset( $page_options->columns_laptop ) )  
	$display_width_laptop = (100/$page_options->columns_laptop) . "%";
else if( get_option( 'ec_option_default_laptop_columns' ) )
	$display_width_laptop = (100/get_option( 'ec_option_default_laptop_columns' ) ) . "%";
else
	$display_width_laptop = (100/3) . "%";
	
if( isset( $page_options->columns_desktop ) )  
	$display_width_desktop = (100/$page_options->columns_desktop ) . "%";
else if( get_option( 'ec_option_default_desktop_columns' ) )
	$display_width_desktop = (100/get_option( 'ec_option_default_desktop_columns' ) ) . "%";
else
	$display_width_desktop = (100/3) . "%";
	
// COLUMNS SETUP
if( isset( $page_options->columns_smartphone ) )  
	$columns_smartphone = $page_options->columns_smartphone;
else if( get_option( 'ec_option_default_smartphone_columns' ) )
	$columns_smartphone = get_option( 'ec_option_default_smartphone_columns' );
else
	$columns_smartphone = 1;
	
if( isset( $page_options->columns_tablet ) )  
	$columns_tablet = $page_options->columns_tablet;
else if( get_option( 'ec_option_default_tablet_columns' ) )
	$columns_tablet = get_option( 'ec_option_default_tablet_columns' );
else
	$columns_tablet = 2;
	
if( isset( $page_options->columns_tablet_wide ) )  
	$columns_tablet_wide = $page_options->columns_tablet_wide;
else if( get_option( 'ec_option_default_tablet_wide_columns' ) )
	$columns_tablet_wide = get_option( 'ec_option_default_tablet_wide_columns' );
else
	$columns_tablet_wide = 2;
	
if( isset( $page_options->columns_laptop ) )  
	$columns_laptop = $page_options->columns_laptop;
else if( get_option( 'ec_option_default_laptop_columns' ) )
	$columns_laptop = get_option( 'ec_option_default_laptop_columns' );
else
	$columns_laptop = 3;
	
if( isset( $page_options->columns_desktop ) )  
	$columns_desktop = $page_options->columns_desktop;
else if( get_option( 'ec_option_default_desktop_columns' ) )
	$columns_desktop = get_option( 'ec_option_default_desktop_columns' );
else
	$columns_desktop = 3;

// Image Height Setup
if( isset( $page_options->image_height_smartphone ) )
	$image_height_smartphone = str_replace( "px", "", $page_options->image_height_smartphone ) . "px";
else if( get_option( 'ec_option_default_smartphone_image_height' ) )
	$image_height_smartphone = str_replace( "px", "", get_option( 'ec_option_default_smartphone_image_height' ) ) . "px";
else
	$image_height_smartphone = '370px';
	
if( isset( $page_options->image_height_tablet ) )
	$image_height_tablet = str_replace( "px", "", $page_options->image_height_tablet ) . "px";
else if( get_option( 'ec_option_default_tablet_image_height' ) )
	$image_height_tablet = str_replace( "px", "", get_option( 'ec_option_default_tablet_image_height' ) ) . "px";
else
	$image_height_tablet = '380px';
	
if( isset( $page_options->image_height_tablet_wide ) )
	$image_height_tablet_wide = str_replace( "px", "", $page_options->image_height_tablet_wide ) . "px";
else if( get_option( 'ec_option_default_tablet_wide_image_height' ) )
	$image_height_tablet_wide = str_replace( "px", "", get_option( 'ec_option_default_tablet_wide_image_height' ) ) . "px";
else
	$image_height_tablet_wide = '310px';
	
if( isset( $page_options->image_height_laptop ) )
	$image_height_laptop = str_replace( "px", "", $page_options->image_height_laptop ) . "px";
else if( get_option( 'ec_option_default_laptop_image_height' ) )
	$image_height_laptop = str_replace( "px", "", get_option( 'ec_option_default_laptop_image_height' ) ) . "px";
else
	$image_height_laptop = '310px';
	
if( isset( $page_options->image_height_desktop ) )
	$image_height_desktop = str_replace( "px", "", $page_options->image_height_desktop ) . "px";
else if( get_option( 'ec_option_default_desktop_image_height' ) )
	$image_height_desktop = str_replace( "px", "", get_option( 'ec_option_default_desktop_image_height' ) ) . "px";
else
	$image_height_desktop = '310px';

// COLOR SETUP
if( get_option( 'ec_option_details_main_color' ) != '' )
	$color1 = get_option( 'ec_option_details_main_color' );
else
	$color1 = '#222222';
	
if( get_option( 'ec_option_details_second_color' ) != '' )
	$color2 = get_option( 'ec_option_details_second_color' );
else
	$color2 = '#666666';

// Product Details Light/Dark
if( get_option( 'ec_option_use_dark_bg' ) != '' ){
	$bg_theme_dark = get_option( 'ec_option_use_dark_bg' );
}else{
	$bg_theme_dark = 0;
}

// Product Details 1/2 Columns
if( get_option( 'ec_option_details_columns_desktop' ) != '' ){
	$details_columns_desktop = get_option( 'ec_option_details_columns_desktop' );
}else{
	$details_columns_desktop = 2;
}

if( get_option( 'ec_option_details_columns_laptop' ) != '' ){
	$details_columns_laptop = get_option( 'ec_option_details_columns_laptop' );
}else{
	$details_columns_laptop = 2;
}

if( get_option( 'ec_option_details_columns_tablet_wide' ) != '' ){
	$details_columns_tablet_wide = get_option( 'ec_option_details_columns_tablet_wide' );
}else{
	$details_columns_tablet_wide = 1;
}

if( get_option( 'ec_option_details_columns_tablet' ) != '' ){
	$details_columns_tablet = get_option( 'ec_option_details_columns_tablet' );
}else{
	$details_columns_tablet = 1;
}

if( get_option( 'ec_option_details_columns_smartphone' ) != '' ){
	$details_columns_smartphone = get_option( 'ec_option_details_columns_smartphone' );
}else{
	$details_columns_smartphone = 1;
}

// Cart 1/2 Columns
if( get_option( 'ec_option_cart_columns_desktop' ) != '' ){
	$cart_columns_desktop = get_option( 'ec_option_cart_columns_desktop' );
}else{
	$cart_columns_desktop = 2;
}

if( get_option( 'ec_option_cart_columns_laptop' ) != '' ){
	$cart_columns_laptop = get_option( 'ec_option_cart_columns_laptop' );
}else{
	$cart_columns_laptop = 2;
}

if( get_option( 'ec_option_cart_columns_tablet_wide' ) != '' ){
	$cart_columns_tablet_wide = get_option( 'ec_option_cart_columns_tablet_wide' );
}else{
	$cart_columns_tablet_wide = 1;
}

if( get_option( 'ec_option_cart_columns_tablet' ) != '' ){
	$cart_columns_tablet = get_option( 'ec_option_cart_columns_tablet' );
}else{
	$cart_columns_tablet = 1;
}

if( get_option( 'ec_option_cart_columns_smartphone' ) != '' ){
	$cart_columns_smartphone = get_option( 'ec_option_cart_columns_smartphone' );
}else{
	$cart_columns_smartphone = 1;
}

// DISPLAY OPTIONS //

// Check for Safari/Admin //
$ua = $_SERVER["HTTP_USER_AGENT"];
$safariorchrome = strpos($ua, 'Safari') ? true : false;
$chrome = strpos($ua, 'Chrome') ? true : false;
if( $safariorchrome && !$chrome )
	$safari = true;
else
	$safari = false;

$ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');

if( $is_preview_holder ){ ?>
<script>
jQuery( document ).ready( function( ){
	jQuery( '#ec_admin_preview_container' ).appendTo( document.body );
} );
</script>
<?php } ?>

<style>
<?php
////////////////////////////////////////////////////////////////////////
?>
.ec_product_type1 .ec_product_addtocart{ background-color:<?php echo $color1; ?>; border-bottom-color:<?php echo $color2; ?>; }
.ec_product_type1 .ec_product_addtocart:hover{ background-color:<?php echo $color2; ?>; border-bottom-color:<?php echo $color1; ?>; }
.ec_product_type1 .ec_product_quickview > input:hover{ background:<?php echo $color1; ?>; background-color:<?php echo $color1; ?>; }
.ec_product_type3 .ec_product_addtocart{ background-color:<?php echo $color1; ?> !important; }
.ec_product_type3 .ec_product_addtocart:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_product_type3 .ec_product_addtocart:hover{ background-color:<?php echo $color1; ?>; }
.ec_product_type3 .ec_product_quickview > input:hover{ background:<?php echo $color1; ?>; background-color:<?php echo $color1; ?>; }
.ec_product_type5 .ec_product_addtocart:hover{ background-color:<?php echo $color1; ?>; }
.ec_product_type5 .ec_product_quickview > input:hover{ background:<?php echo $color1; ?>; background-color:<?php echo $color1; ?>; }
.ec_price_container_type5{ background-color:<?php echo $color1; ?>; }
.ec_price_container_type5:after{ border-color: <?php echo $color2; ?> transparent transparent <?php echo $color2; ?>; }
.ec_product_type6 .ec_product_meta_type6 .ec_price_container{ background-color:<?php echo $color1; ?>; }
.ec_product_type6 .ec_product_meta_type6 .ec_price_container:after{ border-color:<?php echo $color2; ?> transparent transparent <?php echo $color2; ?>; }
.ec_product_type6 .ec_product_meta_type6 .ec_product_addtocart{ background-color:<?php echo $color1; ?> !important; }
.ec_product_type6 .ec_product_meta_type6 .ec_product_addtocart, .ec_product_meta_type6 .ec_product_addtocart a.ec_added_to_cart_button{ background-color:<?php echo $color1; ?> !important; }
.ec_product_type6 .ec_product_meta_type6 .ec_product_addtocart:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_product_type6 .ec_product_meta_type6 .ec_product_addtocart:hover, .ec_product_meta_type6 .ec_product_addtocart a.ec_added_to_cart_button:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_product_type6 .ec_product_meta_type6 .ec_product_quickview > input:hover{ background-color:<?php echo $color1; ?>; }
.ec_product_quickview_content_title, .ec_product_quickview_content_title > a{ color:<?php echo $color1; ?> !important; }
.ec_product_quickview_content_title:hover, .ec_product_quickview_content_title > a:hover{ color:<?php echo $color2; ?> !important; }
.ec_product_quickview_content_quantity input[type="submit"], .ec_product_quickview_content_quantity input[type="button"], .ec_product_quickview_content_add_to_cart a{ background-color:<?php echo $color1; ?> !important; }
.ec_product_quickview_content_quantity input[type="submit"]:hover, .ec_product_quickview_content_quantity input[type="button"]:hover, .ec_product_quickview_content_add_to_cart a:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_product_quickview_content_quantity .ec_minus, .ec_product_quickview_content_quantity .ec_plus{ background-color:<?php echo $color1; ?>; }
.ec_product_quickview_content_quantity .ec_minus:hover, .ec_product_quickview_content_quantity .ec_plus:hover{ background-color:<?php echo $color2; ?>; }
.ec_quickview_view_details a{ color:<?php echo $color1; ?> !important; }
.ec_quickview_view_details a:hover{ color:<?php echo $color2; ?> !important; }
.ec_product_page_sort > .ec_product_page_showing{ color:<?php echo $color1; ?>; }
.ec_product_star_on{ border-bottom-color:<?php echo $color1; ?> !important; color:<?php echo $color1; ?>; border-bottom-color:<?php echo $color1; ?>; }
.ec_product_star_on:before{ border-bottom-color:<?php echo $color1; ?>; }
.ec_product_star_on:after{ color:<?php echo $color1; ?>; border-bottom-color:<?php echo $color1; ?>; }
.ec_product_star_off{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?> !important; color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
.ec_product_star_off:before{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
.ec_product_star_off:after{ color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
.ec_product_added_to_cart a, .ec_cart_checkout_link{ color:<?php echo $color1; ?> !important; }
.ec_product_added_to_cart a:hover, .ec_cart_checkout_link:hover{ color:<?php echo $color2; ?> !important; }
.ec_product_details_page a{ color:<?php echo $color1; ?>; }
.ec_product_details_page a:hover{ color:<?php echo $color2; ?>; }
.ec_details_title{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?> !important; }
.ec_details_price > .ec_product_price{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#000000<?php }?>; }
.ec_details_price > .ec_product_sale_price{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#000000<?php }?>; }
.ec_details_images{ width:<?php if( $details_columns_desktop == 1 ){ ?>100%<?php }else{ ?>47%<?php }?>; }
.ec_details_magbox{ display:none<?php if( $details_columns_desktop == 1 ){?> !important<?php }?>; }
.ec_details_right{ <?php if( $details_columns_desktop == 1 ){ ?>width:100%; margin-left:0;<?php }else{ ?>width:53%; margin-left:47%;<?php }?> }
.ec_details_model_number{ color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#666666<?php }?> !important; }
.ec_details_description{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?> !important; }
.ec_details_stock_total{ color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#666666<?php }?> !important; }
.ec_details_add_to_cart_area > .ec_details_quantity > .ec_minus, .ec_details_add_to_cart_area > .ec_details_quantity > .ec_plus, .ec_details_add_to_cart_area > .ec_details_add_to_cart > input, .ec_details_add_to_cart_area > .ec_details_add_to_cart > a, .ec_details_customer_reviews_row > input[type="button"], .ec_details_inquiry_popup_main > form > .ec_details_add_to_cart input, .ec_details_inquiry_popup_main > form > .ec_details_add_to_cart > a{ background-color:<?php echo $color1; ?> !important; }
.ec_details_add_to_cart_area > .ec_details_quantity > .ec_minus:hover, .ec_details_add_to_cart_area > .ec_details_quantity > .ec_plus:hover, .ec_details_add_to_cart_area > .ec_details_add_to_cart > input:hover, .ec_details_add_to_cart_area > .ec_details_add_to_cart > a:hover, .ec_details_customer_reviews_row > input[type="button"]:hover, .ec_details_inquiry_popup_main > form > .ec_details_add_to_cart > input:hover, .ec_details_inquiry_popup_main > form > .ec_details_add_to_cart > a:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_details_categories{ color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#666666<?php }?> !important; }
.ec_details_manufacturer{ color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#666666<?php }?> !important; }
.ec_details_tabs{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?>; }
.ec_details_tab.ec_active{ border-top-color:<?php echo $color1; ?>; }
.ec_details_customer_reviews_left > h3{ color:<?php echo $color1; ?> !important; }
.ec_details_customer_review_date{ color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#666666<?php }?>; }
.ec_details_customer_review_date > strong{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?>; }
.ec_details_customer_review_data{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?>; }
.ec_details_customer_reviews_form > .ec_details_customer_reviews_form_holder > h3{ color:<?php echo $color1; ?> !important; }
.ec_details_customer_reviews_row{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{?>#222222<?php }?>; }
.ec_details_customer_reviews_row > input[type="button"]{ background-color:<?php if( $bg_theme_dark ){ ?>#AAAAAA<?php }else{?>#333<?php }?>; color:<?php if( $bg_theme_dark ){ ?>#000000<?php }else{?>#FFFFFF<?php }?>; }
.ec_details_customer_reviews_row > input[type="button"]:hover{ background-color:<?php if( $bg_theme_dark ){ ?>#CCCCCC<?php }else{?>#333333<?php }?>; }
.ec_details_related_products_area > h3{ color:<?php echo $color1; ?> !important; }
.ec_product_details_star_on{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?> !important; color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?>; border-bottom-color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?>; }
.ec_product_details_star_on:before{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?>; }
.ec_product_details_star_on:after{ color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?>; border-bottom-color:<?php if( $bg_theme_dark ){ ?>#FFFFFF<?php }else{ echo $color1; }?>; }
.ec_product_details_star_off{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?> !important; color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
.ec_product_details_star_off:before{ border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
.ec_product_details_star_off:after{ color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; border-bottom-color:<?php if( $bg_theme_dark ){ ?>#666666<?php }else{?>#CCCCCC<?php }?>; }
<?php if( $bg_theme_dark ){ ?>
.ec_details_option_label{ color:#FFFFFF; }
<?php }?>
.ec_details_swatches > li.ec_selected > img{ border:2px solid <?php echo $color1; ?>; }
.ec_special_heading{ color:<?php echo $color1; ?>; }
.ec_special_icon, .ec_special_icon_list{ background-color:<?php echo $color1; ?>; }
.ec_cart_page a, .ec_restricted a{ color:<?php echo $color1; ?>; }
.ec_cart_page a:hover, .ec_restricted a:hover{ color:<?php echo $color2; ?>; }
a.ec_cart_empty_button{ background-color:<?php echo $color1; ?> }
a.ec_cart_empty_button:hover{ background-color:<?php echo $color2; ?> }
.ec_cart_breadcrumb{ color:<?php echo $color1; ?>; }
.ec_cart > thead > tr{ border-bottom-color:<?php echo $color1; ?>; }
.ec_cartitem_title{ color:<?php echo $color1; ?> !important; }
.ec_cartitem_quantity_table > tbody > tr > td > .ec_minus, .ec_cartitem_quantity_table > tbody > tr > td > .ec_plus, .ec_cartitem_quantity_table > tbody > tr > td > .ec_cartitem_update_button{ background-color:<?php echo $color1; ?> !important; }
.ec_cartitem_quantity_table > tbody > tr > td > .ec_minus:hover, .ec_cartitem_quantity_table > tbody > tr > td > .ec_plus:hover, .ec_cartitem_quantity_table > tbody > tr > td > .ec_cartitem_update_button:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_cart_button_row > .ec_account_button{ background-color:<?php echo $color1; ?> !important; }
.ec_cart_button_row > .ec_account_button:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_cart_button_row > .ec_cart_button, .ec_cart_button_row input[type="button"], .ec_cart_button_row a{ background-color:<?php echo $color1; ?> !important; }
.ec_cart_button_row > .ec_cart_button:hover, .ec_cart_button_row input[type="button"]:hover, .ec_cart_button_row a:hover{ background-color:<?php echo $color2; ?> !important; }
.ec_cart_button_row a.ec_account_login_link{ background:none !important; background-color:transparent !important; color:<?php echo $color1; ?>; }
.ec_cart_button_row a.ec_account_login_link:hover{ background:none !important; background-color:transparent !important; color:<?php echo $color2; ?>; }
.ec_cart_input_row > a, .ec_cart_input_row > b, .ec_cart_input_row > strong, .ec_account_order_details_item_display_title > a{ color:<?php echo $color1; ?>; }
.ec_cart_input_row > a:hover, .ec_account_order_details_item_display_title > a:hover{ color:<?php echo $color2; ?>; }
<?php if( $bg_theme_dark ){ ?>
.ec_cart_header, .ec_cart_price_row, .ec_cart_price_row_label, .ec_cart_price_row_total, .ec_cart_input_row label, .ec_cart_input_row{ color:#FFF; }
<?php }?>
ul.ec_menu_vertical li a:hover{ background-color:<?php echo $color1; ?>; }
ul.ec_menu_vertical ul li a:hover, ul.ec_menu_vertical ul ul li a:hover, .ec_categorywidget a:hover, .ec_manufacturerwidget a:hover, .ec_pricepointwidget a:hover, .ec_groupwidget a:hover, .ec_product_widget_title a:hover{ color:<?php echo $color1; ?> !important; }

.ec_search_widget input[type="submit"], .ec_newsletter_widget input[type="submit"], input[type="submit"].ec_login_widget_button{ background-color:<?php echo $color1; ?>; border-bottom:4px solid <?php echo $color2; ?>; }
.ec_search_widget input[type="submit"]:hover, .ec_newsletter_widget input[type="submit"]:hover, input[type="submit"].ec_login_widget_button:hover{ background-color:<?php echo $color2; ?>; border-bottom:4px solid <?php echo $color1; ?>; }

.ec_cart_widget_minicart_wrap{ background:<?php echo $color1; ?>; }

.ec_categorywidget a, .ec_manufacturer_widget a, .ec_pricepoint_widget a, .ec_group_widget a, .ec_cartwidget a{ color:<?php echo $color1; ?>; }
.ec_categorywidget a:hover, .ec_manufacturer_widget a:hover, .ec_pricepoint_widget a:hover, .ec_group_widget a:hover, .ec_cartwidget a:hover{ color:<?php echo $color2; ?> !important; }

.ec_newsletter_content h1, .ec_newsletter_close{ color:<?php echo $color1; ?>; }
.ec_newsletter_content input[type='submit']{ background-color:<?php echo $color1; ?>;}
.ec_newsletter_content input[type='submit']:hover{ background-color:<?php echo $color2; ?>; }

.ec_account_order_item_buy_button, .ec_account_order_item_download_button{ background-color:<?php echo $color1; ?>; }
.ec_account_order_item_buy_button:hover, .ec_account_order_item_download_button:hover{ background-color:<?php echo $color2; ?>; }
.ec_account_dashboard_row_divider a, .ec_account_order_line_column5 a, .ec_account_complete_payment_button{ background-color:<?php echo $color1; ?> !important; }
.ec_account_dashboard_row_divider a:hover, .ec_account_order_line_column5 a:hover, .ec_account_complete_payment_button:hover{ background:<?php echo $color2; ?> !important; background-color:<?php echo $color2; ?> !important; }

.ec_store_table a{ color:<?php echo $color1; ?> !important; }
.ec_store_table a:hover{ color:<?php echo $color2; ?> !important; }

.ec_cart_success_title{ color:<?php echo $color1; ?> !important; }
.ec_cart_success_continue_shopping_button > a{ background:<?php echo $color1; ?> !important; }
.ec_cart_success_continue_shopping_button > a:hover{ background:<?php echo $color2; ?> !important; }

@media only screen and ( min-width:1140px ){
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_desktop; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_desktop; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_desktop; ?>; height:<?php echo $image_height_desktop; ?>; }
	#ec_current_media_size{ max-width:1300px; }
	.ec_product_li:nth-child( <?php echo $columns_desktop; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_desktop; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_desktop; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_desktop; ?>; height:<?php echo $image_height_desktop; ?>; }
	#ec_current_media_size{ max-width:1300px; }
	.ec_product_li:nth-child( <?php echo $columns_desktop; ?>n+1 ) .ec_product_editor{ left:227px; }
	<?php if( $details_columns_desktop == 1 ){ ?>
	.ec_details_mobile_title_area{ display:block; }
	.ec_details_images, .ec_details_right, .ec_details_customer_reviews_left, .ec_details_customer_reviews_form, .ec_details_customer_review_date{ float:left; margin-left:0px; width:100%; }
	.ec_details_right{ padding-left:0px; }
	.ec_details_right > form > .ec_details_breadcrumbs.ec_small, .ec_details_right > form > .ec_details_title, .ec_details_right > form > .ec_title_divider, .ec_details_right > form > .ec_details_price, .ec_details_right > form > .ec_details_rating{ display:none; }
	.ec_details_customer_review_list{ width:100%; }
	<?php }?>
	
	.ec_category_li{ width:<?php echo $display_width_desktop; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_desktop; ?>n+1 ){ clear:both; }
	.ec_category_li{ width:<?php echo $display_width_desktop; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_desktop; ?>n+1 ){ clear:both; }
	.ec_category_li:nth-child( <?php echo $columns_desktop; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	<?php if( $cart_columns_desktop == 1 ){ ?>
	.ec_cart_breadcrumb.ec_inactive, .ec_cart_breadcrumb_divider{ display:none; }
	.ec_cart_breadcrumb{ width:100%; text-align:center; font-size:22px; }
	.ec_cart_left{ width:100%; padding-right:0px; border-right:0px; }
	.ec_cart_right{ width:100%; padding-left:0px; }
	.ec_cart_right > .ec_cart_header.ec_top{ margin-top:15px; }
	.ec_show_two_column_only{ display:none !important; }
	#ec_cart_payment_one_column{ display:block; }
	#ec_cart_payment_hide_column{ display:none; }
	<?php }?>
}

@media only screen and ( min-width:990px ) and ( max-width:1139px ){
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_laptop; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_laptop; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_laptop; ?>; height:<?php echo $image_height_laptop; ?>; }
	#ec_current_media_size{ max-width:1139px; }
	.ec_product_li:nth-child( <?php echo $columns_laptop; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_laptop; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_laptop; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_laptop; ?>; height:<?php echo $image_height_laptop; ?>; }
	#ec_current_media_size{ max-width:1139px; }
	.ec_product_li:nth-child( <?php echo $columns_laptop; ?>n+1 ) .ec_product_editor{ left:227px; }
	<?php if( $details_columns_laptop == 1 ){ ?>
	.ec_details_magbox{ display:none !important }
	.ec_details_mobile_title_area{ display:block; }
	.ec_details_images, .ec_details_right, .ec_details_customer_reviews_left, .ec_details_customer_reviews_form, .ec_details_customer_review_date{ float:left; margin-left:0px; width:100%; }
	.ec_details_right{ padding-left:0px; }
	.ec_details_right > form > .ec_details_breadcrumbs.ec_small, .ec_details_right > form > .ec_details_title, .ec_details_right > form > .ec_title_divider, .ec_details_right > form > .ec_details_price, .ec_details_right > form > .ec_details_rating{ display:none; }
	.ec_details_customer_review_list{ width:100%; }
	<?php }?>
	
	.ec_category_li{ width:<?php echo $display_width_laptop; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_laptop; ?>n+1 ){ clear:both; }
	.ec_category_li{ width:<?php echo $display_width_laptop; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_laptop; ?>n+1 ){ clear:both; }
	.ec_category_li:nth-child( <?php echo $columns_laptop; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	<?php if( $cart_columns_laptop == 1 ){ ?>
	.ec_cart_breadcrumb.ec_inactive, .ec_cart_breadcrumb_divider{ display:none; }
	.ec_cart_breadcrumb{ width:100%; text-align:center; font-size:22px; }
	.ec_cart_left{ width:100%; padding-right:0px; border-right:0px; }
	.ec_cart_right{ width:100%; padding-left:0px; }
	.ec_cart_right > .ec_cart_header.ec_top{ margin-top:15px; }
	.ec_show_two_column_only{ display:none !important; }
	#ec_cart_payment_one_column{ display:block; }
	#ec_cart_payment_hide_column{ display:none; }
	<?php }?>
}

@media only screen and ( min-width:768px ) and ( max-width:989px ) {
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_tablet_wide; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_tablet_wide; ?>; height:<?php echo $image_height_tablet_wide; ?>; }
	#ec_current_media_size{ max-width:989px; }
	.ec_product_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_tablet_wide; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_tablet_wide; ?>; height:<?php echo $image_height_tablet_wide; ?>; }
	#ec_current_media_size{ max-width:989px; }
	.ec_product_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ) .ec_product_editor{ left:227px; }
	<?php if( $details_columns_tablet_wide == 1 ){ ?>
	.ec_details_magbox{ display:none !important }
	.ec_details_mobile_title_area{ display:block; }
	.ec_details_images, .ec_details_right, .ec_details_customer_reviews_left, .ec_details_customer_reviews_form, .ec_details_customer_review_date{ float:left; margin-left:0px; width:100%; }
	.ec_details_right{ padding-left:0px; }
	.ec_details_right > form > .ec_details_breadcrumbs.ec_small, .ec_details_right > form > .ec_details_title, .ec_details_right > form > .ec_title_divider, .ec_details_right > form > .ec_details_price, .ec_details_right > form > .ec_details_rating{ display:none; }
	.ec_details_customer_review_list{ width:100%; }
	<?php }?>
	
	.ec_category_li{ width:<?php echo $display_width_tablet_wide; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ){ clear:both; }
	.ec_category_li{ width:<?php echo $display_width_tablet_wide; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ){ clear:both; }
	.ec_category_li:nth-child( <?php echo $columns_tablet_wide; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	<?php if( $cart_columns_tablet_wide == 1 ){ ?>
	.ec_cart_breadcrumb.ec_inactive, .ec_cart_breadcrumb_divider{ display:none; }
	.ec_cart_breadcrumb{ width:100%; text-align:center; font-size:22px; }
	.ec_cart_left{ width:100%; padding-right:0px; border-right:0px; }
	.ec_cart_right{ width:100%; padding-left:0px; }
	.ec_cart_right > .ec_cart_header.ec_top{ margin-top:15px; }
	.ec_show_two_column_only{ display:none !important; }
	#ec_cart_payment_one_column{ display:block; }
	#ec_cart_payment_hide_column{ display:none; }
	<?php }?>
}

@media only screen and ( min-width:481px ) and ( max-width:767px ){
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_tablet; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_tablet; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_tablet; ?>; height:<?php echo $image_height_tablet; ?>; }
	#ec_current_media_size{ max-width:767px; }
	.ec_product_li:nth-child( <?php echo $columns_tablet; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_tablet; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_tablet; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_tablet; ?>; height:<?php echo $image_height_tablet; ?>; }
	#ec_current_media_size{ max-width:767px; }
	.ec_product_li:nth-child( <?php echo $columns_tablet; ?>n+1 ) .ec_product_editor{ left:227px; }
	<?php if( $details_columns_tablet == 1 ){ ?>
	.ec_details_magbox{ display:none !important }
	.ec_details_mobile_title_area{ display:block; }
	.ec_details_images, .ec_details_right, .ec_details_customer_reviews_left, .ec_details_customer_reviews_form, .ec_details_customer_review_date{ float:left; margin-left:0px; width:100%; }
	.ec_details_right{ padding-left:0px; }
	.ec_details_right > form > .ec_details_breadcrumbs.ec_small, .ec_details_right > form > .ec_details_title, .ec_details_right > form > .ec_title_divider, .ec_details_right > form > .ec_details_price, .ec_details_right > form > .ec_details_rating{ display:none; }
	.ec_details_customer_review_list{ width:100%; }
	<?php }?>
	
	.ec_category_li{ width:<?php echo $display_width_tablet; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_tablet; ?>n+1 ){ clear:both; }
	.ec_category_li{ width:<?php echo $display_width_tablet; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_tablet; ?>n+1 ){ clear:both; }
	.ec_category_li:nth-child( <?php echo $columns_tablet; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	<?php if( $cart_columns_tablet == 1 ){ ?>
	.ec_cart_left{ width:100%; padding-right:0px; border-right:0px; }
	.ec_cart_right{ width:100%; padding-left:0px; }
	.ec_cart_right > .ec_cart_header.ec_top{ margin-top:15px; }
	.ec_show_two_column_only{ display:none !important; }
	#ec_cart_payment_one_column{ display:block; }
	#ec_cart_payment_hide_column{ display:none; }
	<?php }?>
}

@media only screen and ( max-width:480px ){
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_smartphone; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_smartphone; ?>; height:<?php echo $image_height_smartphone; ?>; }
	#ec_current_media_size{ max-width:480px; }
	.ec_product_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	.ec_product_li, li.ec_product_li{ width:<?php echo $display_width_smartphone; ?>; }
	.ec_product_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ){ clear:both; }
	.ec_image_container_none, .ec_image_container_none > div, .ec_image_container_border, .ec_image_container_border > div, .ec_image_container_shadow, .ec_image_container_shadow > div{ min-height:<?php echo $image_height_smartphone; ?>; height:<?php echo $image_height_smartphone; ?>; }
	#ec_current_media_size{ max-width:480px; }
	.ec_product_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ) .ec_product_editor{ left:227px; }
	.ec_product_quickview_content_data{ padding:15px; }
	.ec_product_page_sort > .ec_product_page_showing{ margin:0; }
	.ec_product_page_sort > select{ float:left; }
	.ec_product_type6 .ec_image_container_none, .ec_product_type6 .ec_image_container_border, .ec_product_type6 .ec_image_container_shadow{ width:100%; max-width:100%; }
	.ec_product_type6 .ec_product_meta_type6{ position:relative; width:100%; max-width:100%; margin-left:0; float:none; padding:15px; }
	.ec_product_type6 .ec_product_meta_type6 .ec_product_addtocart_container{ float:none; }
	
	.ec_details_swatches{ float:left; width:100%; }
	.ec_details_option_label{ border-right:none; }
	
	.ec_category_li{ width:<?php echo $display_width_smartphone; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ){ clear:both; }
	.ec_category_li{ width:<?php echo $display_width_smartphone; ?>; }
	.ec_category_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ){ clear:both; }
	.ec_category_li:nth-child( <?php echo $columns_smartphone; ?>n+1 ) .ec_product_editor{ left:227px; }
	
	<?php if( $details_columns_smartphone == 1 ){ ?>
	.ec_details_magbox{ display:none !important }
	.ec_details_mobile_title_area{ display:block; }
	.ec_details_images, .ec_details_right, .ec_details_customer_reviews_left, .ec_details_customer_reviews_form, .ec_details_customer_review_date{ float:left; margin-left:0px; width:100%; }
	.ec_details_right{ padding-left:0px; }
	.ec_details_right > form > .ec_details_breadcrumbs.ec_small, .ec_details_right > form > .ec_details_title, .ec_details_right > form > .ec_title_divider, .ec_details_right > form > .ec_details_price, .ec_details_right > form > .ec_details_rating{ display:none; }
	.ec_details_customer_review_list{ width:100%; }
	<?php }?>
	
	<?php if( $cart_columns_smartphone == 1 ){ ?>
	.ec_cart_left{ width:100%; padding-right:0px; border-right:0px; }
	.ec_cart_right{ width:100%; padding-left:0px; }
	.ec_cart_right > .ec_cart_header.ec_top{ margin-top:15px; }
	.ec_show_two_column_only{ display:none !important; }
	#ec_cart_payment_one_column{ display:block; }
	#ec_cart_payment_hide_column{ display:none; }
	<?php }?>
}

<?php if( current_user_can( 'manage_options' ) ){ ?>

<?php if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ipad_landscape.png" ) ){ ?>
.ec_admin_preview_ipad_landscape > input{ background:url( '<?php echo plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ipad_landscape.png" ); ?>' ) no-repeat; }
<?php }else{ ?>
.ec_admin_preview_ipad_landscape > input{ background:url( '<?php echo plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/ipad_landscape.png" ); ?>' ) no-repeat; }
<?php }?>

<?php if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ipad_portrait.png" ) ){ ?>
.ec_admin_preview_ipad_portrait > input{ background:url( '<?php echo plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/ipad_portrait.png" ); ?>') no-repeat; }
<?php }else{ ?>
.ec_admin_preview_ipad_portrait > input{ background:url( '<?php echo plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/ipad_portrait.png" ); ?>' ) no-repeat; }
<?php }?>

<?php if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/iphone_landscape.png" ) ){ ?>
.ec_admin_preview_iphone_landscape > input{ background:url( '<?php echo plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/iphone_landscape.png" ); ?>') no-repeat; }
<?php }else{ ?>
.ec_admin_preview_iphone_landscape > input{ background:url( '<?php echo plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/iphone_landscape.png" ); ?>' ) no-repeat; }
<?php }?>

<?php if( file_exists( WP_PLUGIN_DIR . "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/iphone_portrait.png" ) ){ ?>
.ec_admin_preview_iphone_portrait > input{ background:url( '<?php echo plugins_url( "/wp-easycart-data/design/theme/" . get_option( 'ec_option_base_theme' ) . "/images/iphone_portrait.png" ); ?>') no-repeat; }
<?php }else{ ?>
.ec_admin_preview_iphone_portrait > input{ background:url( '<?php echo plugins_url( "/wp-easycart/design/theme/" . get_option( 'ec_option_latest_theme' ) . "/images/iphone_portrait.png" ); ?>' ) no-repeat; }
<?php }?>

.ec_admin_preview_ipad_landscape > input:hover, .ec_admin_preview_ipad_portrait > input:hover, .ec_admin_preview_iphone_landscape > input:hover, .ec_admin_preview_iphone_portrait > input:hover{ background-color:#FFF; }

.ec_product_li:nth-child( <?php echo $columns_desktop; ?>n+1 ) .ec_product_editor{ left:227px; }
.ec_product_admin_reorder_button{ background-color:<?php echo $color1; ?>; }
.ec_product_admin_reorder_button:hover{ background-color:<?php echo $color2; ?> }
.ec_products_sortable_padding > ul{ width:<?php echo $columns_desktop * 220; ?>px; }
<?php }?>

<?php 

echo stripslashes( get_option( 'ec_option_custom_css' ) );

?>
</style>