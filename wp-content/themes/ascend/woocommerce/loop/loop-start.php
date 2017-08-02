 <?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce, $woocommerce_loop;
	$ascend = ascend_get_options();
	if ( empty( $woocommerce_loop['columns'] ) ) {
	 	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	}
	//$woocommerce_loop['rand'] = $woocommerce_loop['columns'];

  	if(ascend_display_sidebar()) {
        $columns = "shopcolumn".$woocommerce_loop['columns']." shopsidebarwidth"; 
  	} else {
		$columns = "shopcolumn".$woocommerce_loop['columns']." shopfullwidth"; 
  	}
  	if(is_cart()) {
      	$columns = "shopcolumn-cart".$woocommerce_loop['columns']." shopfullwidth";
    }
	if(isset($ascend['product_img_resize']) && $ascend['product_img_resize'] == 0) { 
		$isoclass = 'init-masonry';
	} else { 
		$isoclass = 'init-masonry-intrinsic';
	}
	if ( get_option( 'woocommerce_enable_review_rating' ) != 'no' && isset($ascend['shop_rating']) && $ascend['shop_rating'] != '0') {
 		$ratingclass = 'kt-show-rating';
 	} else {
 		$ratingclass = 'kt-hide-rating';
 	}
?>
<ul class="products kad_product_wrapper rowtight <?php echo esc_attr($columns); ?> <?php echo esc_attr($isoclass); ?> <?php echo esc_attr($ratingclass); ?> reinit-masonry" data-masonry-selector=".kad_product" data-masonry-style="masonry">