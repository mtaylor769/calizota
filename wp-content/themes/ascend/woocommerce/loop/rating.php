<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' ) {
	return;
}
	$ascend = ascend_get_options();
	if (!isset($ascend['shop_rating']) ||  $ascend['shop_rating'] != '0') { 
		if ( version_compare( WC_VERSION, '3.0', '>' ) ) {
			$rating_html = wc_get_rating_html($product->get_average_rating());
		} else	{
			$rating_html = $product->get_rating_html();
		}

		if ( $rating_html ) { 
			echo '<a href="'.esc_url(get_the_permalink()).'">'.$rating_html.'</a>';
		} else { 
			echo "<span class='kt-notrated'>".__('not rated', 'ascend')."</span>"; 
		}
 	}