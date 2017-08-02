<?php
/**
 * Loads the child theme textdomain.
 */
function blacky_child_theme_setup() {
    load_child_theme_textdomain( 'blacky');
}
add_action( 'after_setup_theme', 'blacky_child_theme_setup' );

function blacky_child_enqueue_styles() {
    $parent_style = 'blacky-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'blacky-style',get_stylesheet_directory_uri() . '/blacky.css');
}
add_action( 'wp_enqueue_scripts', 'blacky_child_enqueue_styles',99);
?>