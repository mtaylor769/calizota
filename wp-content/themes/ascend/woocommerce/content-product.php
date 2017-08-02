<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$ascend = ascend_get_options();
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ){
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

	$product_column = $woocommerce_loop['columns'];

	if ($product_column == '1') {
		$itemsize = 'col-md-12 col-sm-12 col-xs-12 col-ss-12';
	} else if ($product_column == '2') {
 		$itemsize = 'col-xxl-4 col-xl-6 col-md-6 col-sm-6 col-xs-12 col-ss-12';
 	} else if ($product_column == '3'){ 
 		$itemsize = 'col-xxl-25 col-xl-3 col-md-4 col-sm-4 col-xs-6 col-ss-12'; 
 	} else if ($product_column == '6'){
 		$itemsize = 'col-xxl-15 col-xl-2 col-md-2 col-sm-3 col-xs-4 col-ss-6'; 
 	} else if ($product_column == '5'){ 
 		$itemsize = 'col-xxl-2 col-xl-25 col-md-25 col-sm-3 col-xs-4 col-ss-6';
 	} else {
 		$itemsize = 'col-xxl-2 col-xl-25 col-md-3 col-sm-4 col-xs-6 col-ss-6'; 
 	}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
$classes[] = 'grid_item';
$classes[] = 'product_item';
$classes[] = 'clearfix';
$classes[] = 'kt_item_fade_in';

$terms = get_the_terms( $post->ID, 'product_cat' );
if ( $terms && ! is_wp_error( $terms ) ) {
		$links = array();
		foreach ( $terms as $term ) {
			$links[] = $term->slug;
		}
		$links = preg_replace("/[^a-zA-Z 0-9]+/", "-", $links);
		$tax = join( " ", $links );		
} else {	
	$tax = '';
}
?>
<li class="<?php echo esc_attr($itemsize);?> <?php echo esc_attr($tax);?> kad_product">
	<div <?php post_class( $classes ); ?>>

	<?php 
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10 (UNHOOKED BY THEME)
	 */
	do_action( 'woocommerce_before_shop_loop_item' ); 

	/**
	 * woocommerce_before_shop_loop_item_title hook
	 *
	 * @hooked ascend_woocommerce_image_link_open - 2
	 * @hooked woocommerce_show_product_loop_sale_flash - 10 
	 * @hooked woocommerce_template_loop_product_thumbnail - 10 (UNHOOKED BY THEME)
	 * @hooked ascend_woocommerce_template_loop_product_thumbnail - 10
	 * @hooked ascend_woocommerce_image_link_close - 50
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' ); ?> 

	<?php 
	/**
 	* woocommerce_shop_loop_item_title hook
 	*
 	* @hooked ascend_woocommerce_archive_content_wrap_start - 5
 	* @hooked ascend_woocommerce_archive_title_wrap_start - 6
 	* @hooked ascend_woocommerce_archive_title_link_start - 7
 	* @hooked woocommerce_template_loop_product_title - 10 (UNHOOKED BY THEME)
 	* @hooked ascend_woocommerce_template_loop_product_title - 10 
 	* @hooked ascend_woocommerce_archive_title_link_end - 15
 	* @hooked woocommerce_template_loop_product_title - 20
 	* @hooked ascend_woocommerce_archive_title_wrap_end - 50
 	*/
	do_action( 'woocommerce_shop_loop_item_title' );
	?>
		
	<?php
	/**
	 * woocommerce_after_shop_loop_item_title hook
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 * @hooked ascend_woocommerce_archive_content_wrap_end - 50
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>

	<?php 
	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5 (UNHOOKED BY THEME)
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' ); ?>

	</div>
</li>