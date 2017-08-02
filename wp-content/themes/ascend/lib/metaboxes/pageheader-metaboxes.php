<?php 
add_filter( 'cmb2_admin_init', 'ascend_pageheader_metaboxes');
function ascend_pageheader_metaboxes(){
	$prefix = '_kad_';

	$ascend_pageheader = new_cmb2_box( array(
		'id'         	=> 'pageheader_metabox',
		'title'      	=> __("Page Title and Subtitle", 'ascend'),
		'object_types'  => array('page'),
		'priority'   	=> 'default',
	) );
	
	$ascend_pageheader->add_field( array(
		'name'    => __("Hide Page Title Area", 'ascend' ),
		'desc'    => '',
		'id'      => $prefix . 'pagetitle_hide',
		'type'    => 'select',
		'options' => array(
			'default' 	=> __("Default", 'ascend' ),
			'show' 		=> __("Show", 'ascend' ),
			'hide' 		=> __("Hide", 'ascend' ),
		),
	) );


}