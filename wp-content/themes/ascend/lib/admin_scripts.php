<?php

/**
 * Enqueue CSS & JS
 */
function ascend_admin_scripts($hook) {
	if( $hook == 'appearance_page_kad_options' || $hook == 'widgets.php' ) {
		wp_enqueue_script('select2', get_template_directory_uri() . '/assets/js/min/select2-min.js', array( 'jquery' ), ASCEND_VERSION, false);
	}
	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' && $hook != 'widgets.php' && $hook != 'appearance_page_kad_options' ) {
		return;
	}
	wp_enqueue_style('ascend_admin_styles', get_template_directory_uri() . '/assets/css/ascend_admin.css', false, ASCEND_VERSION);

	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' && $hook != 'widgets.php' ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script('ascend_admin_main', get_template_directory_uri() . '/assets/js/min/ascend-admin-main-min.js', array( 'wp-color-picker', 'jquery' ), ASCEND_VERSION, false);

}

add_action('admin_enqueue_scripts', 'ascend_admin_scripts');
