<?php
/**
 * Craze Theme Customizer.
 *
 * @package Craze
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

 
function craze_customize_register( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	
	
	//for customer care no and e-mail id
	$wp_customize->add_section("home_page_set", array(
		"title" => __("Top Header", "craze"),
		"priority" => 31,
	)); 
		
		$wp_customize->add_setting("paypal_highlight_before_text", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"paypal_highlight_before_text",
			array(
				"label" => __("Paypal Highlight Before Text", "craze"),
				"section" => "home_page_set",
				"settings" => "paypal_highlight_before_text",
				"type" => "text",
				
			)
		));
		
		$wp_customize->add_setting("paypal_highlight_text", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"paypal_highlight_text",
			array(
				"label" => __("Paypal Highlight Text", "craze"),
				"section" => "home_page_set",
				"settings" => "paypal_highlight_text",
				"type" => "text",
				
			)
		));
		
		$wp_customize->add_setting("paypal_highlight_after_text", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"paypal_highlight_after_text",
			array(
				"label" => __("Paypal Highlight After Text", "craze"),
				"section" => "home_page_set",
				"settings" => "paypal_highlight_after_text",
				"type" => "text",
				
			)
		));
		
		// for customer care no 
		$wp_customize->add_setting("cust_care_no", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"cust_care_no",
			array(
				"label" => __("Enter Customer Care No", "craze"),
				"section" => "home_page_set",
				"settings" => "cust_care_no",
				"type" => "text",
				
			)
		));
		
		$wp_customize->add_setting("cust_care_id", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"cust_care_id",
			array(
				"label" => __("Enter Customer Care Email-Id", "craze"),
				"section" => "home_page_set",
				"settings" => "cust_care_id",
				"type" => "text",
				
			)
		));
		
		
	//for Banner top Content
	$wp_customize->add_section("banner_top_cntnt", array(
		"title" => __("Banner Top Content", "craze"),
		"priority" => 31,
	));
	
		$wp_customize->add_setting("banner_del_info", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"banner_del_info",
			array(
				"label" => __("First Section Heading", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "banner_del_info",
				"type" => "text",
				
			)
		));
		
		$wp_customize->add_setting("first_banner_cntnt", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"first_banner_cntnt",
			array(
				"label" => __("First Section Content", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "first_banner_cntnt",
				"type" => "text",
				
			)
		));
		
		// for banner top content second heading
		$wp_customize->add_setting("scnd_banner_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"scnd_banner_head",
			array(
				"label" => __("Second Section Heading", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "scnd_banner_head",
				"type" => "text",
				
			)
		));
		
		// for banner top content second content
		$wp_customize->add_setting("scnd_banner_cntnt", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"scnd_banner_cntnt",
			array(
				"label" => __("Second Section Content", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "scnd_banner_cntnt",
				"type" => "text",
				
			)
		));
		
		// for banner top content third heading
		$wp_customize->add_setting("thrd_banner_head", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"thrd_banner_head",
			array(
				"label" => __("Third Section Heading", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "thrd_banner_head",
				"type" => "text",
				
			)
		));
		
		// for banner top content third content
		$wp_customize->add_setting("thrd_banner_cntnt", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"thrd_banner_cntnt",
			array(
				"label" => __("Third Section Content", "craze"),
				"section" => "banner_top_cntnt",
				"settings" => "thrd_banner_cntnt",
				"type" => "text",
				
			)
		));
		
		
	//for Banner images
	$wp_customize->add_section("banner_image", array(
		"title" => __("Banner Images", "craze"),
		"priority" => 31,
	));
		
		// for banner on off option
		$wp_customize->add_setting("craze_home_banner_on_off", array(
			"default" => 'off',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_radio_sanitize_row',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"craze_home_banner_on_off",
			array(
			'type' => 'radio',
			'label' => __("Banner On/Off", "craze"),
			'section' => 'banner_image',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off',
			),
		)
		));	
		
		//for Banner 1
		$wp_customize->add_setting("bnr_img1", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"bnr_img1",
			array(
				"label" => __("Banner Image 1", "craze"),
				"section" => "banner_image",
				"settings" => "bnr_img1",
				
			)
		)); 
		
		//for Banner 2
		$wp_customize->add_setting("bnr_img2", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"bnr_img2",
			array(
				"label" => __("Banner Image 2", "craze"),
				"section" => "banner_image",
				"settings" => "bnr_img2",
				
			)
		)); 
		
		//for Banner 3
		$wp_customize->add_setting("bnr_img3", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"bnr_img3",
			array(
				"label" => __("Banner Image 3", "craze"),
				"section" => "banner_image",
				"settings" => "bnr_img3",
				
			)
		)); 
		
		
	//for small three Banner
	$wp_customize->add_section("small_banner1_image", array(
		"title" => __("Small Banners", "craze"),
		"priority" => 31,
	));
		
		// for small banner on off option
		$wp_customize->add_setting("craze_small_banner_on_off", array(
			"default" => 'off',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_radio_sanitize_row',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"craze_small_banner_on_off",
			array(
			'type' => 'radio',
			'label' => __("Banner On/Off", "craze"),
			'section' => 'small_banner1_image',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off',
			),
		)
		));
		
		//for small Banner 1 Image
		$wp_customize->add_setting("sml_bnr1_img", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"sml_bnr1_img",
			array(
				"label" => __("Small Banner 1 Image", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_img",
				
			)
		)); 
		
		//for small Banner 1 highlight before text
		$wp_customize->add_setting("sml_bnr1_high_before_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr1_high_before_txt",
			array(
				"label" => __("Small Banner 1 Highlight Before Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_high_before_txt",
				"type" => "text",
				
			)
		)); 
		
		
		//for small Banner 1 highlight text
		$wp_customize->add_setting("sml_bnr1_high_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr1_high_txt",
			array(
				"label" => __("Small Banner 1 Highlight Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_high_txt",
				"type" => "text",
				
			)
		)); 
		
		//for small Banner 1 highlight after text
		$wp_customize->add_setting("sml_bnr1_high_after_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr1_high_after_txt",
			array(
				"label" => __("Small Banner 1 Highlight After Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_high_after_txt",
				"type" => "text",
				
			)
		)); 
		
		//for small Banner 1 button text
		$wp_customize->add_setting("sml_bnr1_btn_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr1_btn_txt",
			array(
				"label" => __("Small Banner 1 Button Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_btn_txt",
				"type" => "text",
				
			)
		)); 
		
		// for small Banner 1 button link address
		$wp_customize->add_setting("sml_bnr1_btn_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr1_btn_link",
			array(
				"label" => __("Small Banner 1 Shop Now Button Link", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr1_btn_link",
				"type" => "url",
			)
		));
		
		//for small Banner 2 Image
		$wp_customize->add_setting("sml_bnr2_img", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"sml_bnr2_img",
			array(
				"label" => __("Small Banner 2 Image", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_img",
				
			)
		)); 
		
		//for small Banner 2 highlight before text
		$wp_customize->add_setting("sml_bnr2_high_before_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr2_high_before_txt",
			array(
				"label" => __("Small Banner 2 Highlight Before Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_high_before_txt",
				"type" => "text",
				
			)
		)); 
		
		
		//for small Banner 2 highlight text
		$wp_customize->add_setting("sml_bnr2_high_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr2_high_txt",
			array(
				"label" => __("Small Banner 2 Highlight Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_high_txt",
				"type" => "text",
				
			)
		)); 
		
		//for small Banner 2 highlight after text
		$wp_customize->add_setting("sml_bnr2_high_after_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr2_high_after_txt",
			array(
				"label" => __("Small Banner 2 Highlight After Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_high_after_txt",
				"type" => "text",
				
			)
		)); 
		
		//for small Banner 2 button text
		$wp_customize->add_setting("sml_bnr2_btn_txt", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr2_btn_txt",
			array(
				"label" => __("Small Banner 2 Button Text", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_btn_txt",
				"type" => "text",
				
			)
		));
		
		// for small Banner 2 button link address
		$wp_customize->add_setting("sml_bnr2_btn_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sml_bnr2_btn_link",
			array(
				"label" => __("Small Banner 2 Shop Now Button Link", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr2_btn_link",
				"type" => "url",
			)
		));

		//for small Banner 3 Image
		$wp_customize->add_setting("sml_bnr3_img", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"sml_bnr3_img",
			array(
				"label" => __("Small Banner 3 Image", "craze"),
				"section" => "small_banner1_image",
				"settings" => "sml_bnr3_img",
				
			)
		)); 
		
		
	//for body Banner
	$wp_customize->add_section("body_banner", array(
		"title" => __("Home Page Content", "craze"),
		"priority" => 31,
	));
	
		// for product headings 
		$wp_customize->add_setting("top_prdct_head", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"top_prdct_head",
			array(
				"label" => __("Heading of Top Rated Product", "craze"),
				"section" => "body_banner",
				"settings" => "top_prdct_head",
				"type" => "text",
				
			)
		));
	
		//for body Banner Image
		$wp_customize->add_setting("body_bnnr_img", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"body_bnnr_img",
			array(
				"label" => __("Body Banner Image", "craze"),
				"section" => "body_banner",
				"settings" => "body_bnnr_img",
				
			)
		));
		
		//for body Banner button text
		$wp_customize->add_setting("body_bnnr_btn", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"body_bnnr_btn",
			array(
				"label" => __("Body Banner Button Text", "craze"),
				"section" => "body_banner",
				"settings" => "body_bnnr_btn",
				"type" => "text",
				
			)
		));
		
		// for Banner Button Link Address
		$wp_customize->add_setting("baner_btn_link", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"baner_btn_link",
			array(
				"label" => __("Body Banner Shop Now Button Link", "craze"),
				"section" => "body_banner",
				"settings" => "baner_btn_link",
				"type" => "url",
			)
		));
		
		// for sale product headings 
		$wp_customize->add_setting("sale_prdct_head", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"sale_prdct_head",
			array(
				"label" => __("Heading of Sale Product", "craze"),
				"section" => "body_banner",
				"settings" => "sale_prdct_head",
				"type" => "text",
				
			)
		));
		
		// for best selling product headings 
		$wp_customize->add_setting("best_selling_prdct_head", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"best_selling_prdct_head",
			array(
				"label" => __("Heading of Best Selling Product", "craze"),
				"section" => "body_banner",
				"settings" => "best_selling_prdct_head",
				"type" => "text",
				
			)
		));
		
		
		// for top rated product headings 
		$wp_customize->add_setting("top_rated_prdct_head", array(
		"default" => '',
		"transport" => "refresh",
		'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"top_rated_prdct_head",
			array(
				"label" => __("Heading of Top Rated Product", "craze"),
				"section" => "body_banner",
				"settings" => "top_rated_prdct_head",
				"type" => "text",
				
			)
		));
	 	
	//for footer content
	$wp_customize->add_section("footer_content", array(
		"title" => __("Footer Content", "craze"),
		"priority" => 33,
	));
	
		$wp_customize->add_setting("copyright_text", array(
			"default" => '',
			"transport" => "refresh",
			'sanitize_callback' => 'craze_text_sanitize',
		));
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"copyright_text",
			array(
				"label" => __("Copyright Text", "craze"),
				"section" => "footer_content",
				"settings" => "copyright_text",
				"type" => "text",
				
			)
		));
		

	
}

add_action( 'customize_register', 'craze_customize_register' );


function craze_text_sanitize( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function craze_radio_sanitize_row($input) {
  $valid_keys = array(
		'on' => 'On',
		'off' => 'Off',
  );
  if ( array_key_exists( $input, $valid_keys ) ) {
	 return $input;
  } else {
	 return '';
  }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function craze_customize_preview_js() {
	wp_enqueue_script( 'craze_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'craze_customize_preview_js' );
