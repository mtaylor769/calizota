<?php 
/*-----------------------------------------------------------------------------------*/
/* This theme supports WooCommerce */
/*-----------------------------------------------------------------------------------*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function ascend_woocommerce_support() {
    add_theme_support( 'woocommerce' );

    if (class_exists('woocommerce')) {
    	if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
    		$ascend = ascend_get_options();
    		if(isset($ascend['product_gallery_zoom']) && 1 == $ascend['product_gallery_zoom']) {
    			add_theme_support( 'wc-product-gallery-zoom' );
    		}
			if(isset($ascend['product_gallery_slider']) && 1 == $ascend['product_gallery_slider']) {
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );

        // Disable WooCommerce Lightbox
        if (get_option( 'woocommerce_enable_lightbox' ) == true ) {
            update_option( 'woocommerce_enable_lightbox', false );
        }

        add_action('ascend_archive_title_container', 'ascend_wc_print_notices', 40);
        add_action('ascend_page_title_container', 'ascend_wc_print_notices', 40);
        add_action('ascend_post_header', 'ascend_wc_print_notices', 40);
        add_action('ascend_portfolio_header', 'ascend_wc_print_notices', 40);
        add_action('ascend_front_page_title_container', 'ascend_wc_print_notices', 40);
        function ascend_wc_print_notices() {
            if(!is_shop() and !is_woocommerce() and !is_cart() and !is_checkout() and !is_account_page() ) {
              echo '<div class="container kt-woo-messages-none-woo-pages">';
              echo do_shortcode( '[woocommerce_messages]' );
              echo '</div>';
            }
        }
	    if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
	    	add_filter('woocommerce_add_to_cart_fragments', 'ascend_get_refreshed_fragments');
	    } else {
	    	add_filter('add_to_cart_fragments', 'ascend_get_refreshed_fragments');
	    }
	 	function ascend_get_refreshed_fragments($fragments) {
		    // Get mini cart
		    ob_start();

		    woocommerce_mini_cart();

		    $mini_cart = ob_get_clean();

		    // Fragments and mini cart are returned
		    $fragments['li.kt-mini-cart-refreash'] ='<li class="kt-mini-cart-refreash">' . $mini_cart . '</li>';

		    return $fragments;

		}
	  	if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
	    	add_filter('woocommerce_add_to_cart_fragments', 'ascend_get_refreshed_fragments_number');
	    } else {
	    	add_filter('add_to_cart_fragments', 'ascend_get_refreshed_fragments_number');
	    }
	 	function ascend_get_refreshed_fragments_number($fragments) {
		    global $woocommerce;
		    // Get mini cart
		    ob_start();

		    ?><span class="kt-cart-total"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span> <?php

		    $fragments['span.kt-cart-total'] = ob_get_clean();

		    return $fragments;

	 	}
	}    

}
add_action( 'after_setup_theme', 'ascend_woocommerce_support' );
