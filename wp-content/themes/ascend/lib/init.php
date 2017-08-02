<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * initial setup and constants
 */
function ascend_setup() {
 	global $pagenow;
 	$ascend = ascend_get_options();
  	if(isset($ascend['above_header_style']) && $ascend['above_header_style'] == "center" && isset($ascend['site_layout']) && $ascend['site_layout'] == "above") {
      	register_nav_menus(array(
	        'left_navigation' 		=> __('Left Navigation', 'ascend'),
	        'right_navigation' 		=> __('Right Navigation', 'ascend'),
	        'secondary_navigation'	=> __('Secondary Navigation', 'ascend'),
	        'mobile_navigation' 	=> __('Mobile Navigation', 'ascend'),
	        'topbar_navigation' 	=> __('Topbar Navigation', 'ascend'),
	        'footer_navigation' 	=> __('Footer Navigation', 'ascend'),
      	));
  	} else {
  		register_nav_menus(array(
	        'primary_navigation' 	=> __('Primary Navigation', 'ascend'),
	        'secondary_navigation' 	=> __('Secondary Navigation', 'ascend'),
	        'mobile_navigation' 	=> __('Mobile Navigation', 'ascend'),
	        'topbar_navigation' 	=> __('Topbar Navigation', 'ascend'),
	        'footer_navigation' 	=> __('Footer Navigation', 'ascend'),
      	));
  	} 

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support('post-formats', array('gallery', 'image', 'video', 'quote'));
    add_theme_support( 'automatic-feed-links' );
    add_editor_style('/assets/css/kt-editor-style.css');
    add_post_type_support( 'attachment', 'page-attributes' );

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
    add_theme_support( 'custom-logo', array(
	   'flex-width' 	=> true,
	   'flex-height' 	=> true,
	) );
	add_theme_support('custom-background');
    // Indicate widget sidebars can use selective refresh in the Customizer.
    add_theme_support( 'customize-selective-refresh-widgets' );

    define( 'ASCEND_VERSION', '1.1.7' );
    // Square
	add_image_size( 'ascend-600x600', 600, 600, true);
	//portrait
	add_image_size( 'ascend-540x620', 540, 620, true);
	//landscape
	add_image_size( 'ascend-720x480', 720, 480, true);
}
add_action('after_setup_theme', 'ascend_setup');


/**
 * Page titles
 */
function ascend_title() {
  	if (is_home()) {
    	if (get_option('page_for_posts', true)) {
      		$title = get_the_title(get_option('page_for_posts', true));
    	} else {
     		$title = __('Latest Posts', 'ascend');
    	}
  	} elseif (is_archive()) {
  		$title = get_the_archive_title();
  	} elseif (is_search()) {
    	$title = sprintf(__('Search Results for %s', 'ascend'), get_search_query());
  	} elseif (is_404()) {
    	$title = __('Not Found', 'ascend');
  	} else {
    	$title = get_the_title();
  	}
  	return apply_filters('ascend_title', $title);
}
add_filter('get_the_archive_title', 'ascend_filter_archive_title');
function ascend_filter_archive_title($title){
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    	if ( is_category() ) {
      		$title = single_cat_title( '', false );
    	} elseif ( is_tag() ) {
        	$title = single_tag_title( '', false );
    	} elseif (is_author()) {
      		$title = sprintf(__('Author: %s', 'ascend'), get_the_author());
    	} else if ($term) {
      		$title = $term->name;
    	} elseif (is_day()) {
      		$title = sprintf(__('Day: %s', 'ascend'), get_the_date());
    	} elseif (is_month()) {
      		$title = sprintf(__('Month: %s', 'ascend'), get_the_date('F Y'));
    	} elseif (is_year()) {
      		$title = sprintf(__('Year: %s', 'ascend'), get_the_date('Y'));
    	} 
    	return $title;
}
