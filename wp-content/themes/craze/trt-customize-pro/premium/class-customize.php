<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Craze_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function craze_get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->craze_setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function craze_setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'craze_sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'craze_enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */ 
	public function craze_sections( $craze_manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'trt-customize-pro/premium/section-pro.php' );

		// Register custom section types.
		$craze_manager->register_section_type( 'Craze_Customize_Section_Pro' );

		// Register sections.
		$craze_manager->add_section(
			new Craze_Customize_Section_Pro(
				$craze_manager,
				'craze_pro',
				array(
					'title'    => esc_html__( 'Craze Pro', 'craze' ),
					'pro_text' => esc_html__( 'Go Pro','craze' ),
					'pro_url'  => 'https://www.phoeniixx.com/product/craze/',
					'priority' => 11,
					
				)
			)
		);
	}
 
	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function craze_enqueue_control_scripts() {

		wp_enqueue_script( 'craze-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customize-pro/premium/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'craze-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customize-pro/premium/customize-controls.css' );
	}
}

// Doing this customizer thang!
Craze_Customize::craze_get_instance();
