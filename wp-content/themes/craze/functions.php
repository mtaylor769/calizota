<?php
/**
 * Craze functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Craze
 */ 

if ( ! function_exists( 'craze_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function craze_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org.
	 * If you're building a theme based on Craze, use a find and replace
	 * to change 'craze' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'craze');
   
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	// add theme support woocommerce
	add_theme_support( 'woocommerce' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	// for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	/*
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	*/
	add_theme_support( 'post-thumbnails' );
	
	// Thumbnail sizes 
	add_image_size( 'craze-featured', 600, 600, true );
	
	add_image_size( 'craze-featured-single', 980, 600, true );
	
	add_editor_style('editor-style.css');
	
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'craze' ),
	) );
    
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	// custom logo 
	if ( ! function_exists( 'Craze_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since craze
	 */
	function Craze_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
	endif;
   
 	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'craze_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}  
endif;
   
add_action( 'after_setup_theme', 'craze_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function craze_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'craze_content_width', 640 );
}
add_action( 'after_setup_theme', 'craze_content_width', 0 );

/**  
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function craze_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'craze' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar(array(
		'id' => 'footer1-craze',
		'name' => esc_html__( 'Footer 1', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	register_sidebar(array(
		'id' => 'footer2-craze',
		'name' => esc_html__( 'Footer 2', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'id' => 'footer3-craze',
		'name' => esc_html__( 'Footer 3', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'id' => 'footer4-craze',
		'name' => esc_html__( 'Footer 4', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-2 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'id' => 'footer5-craze',
		'name' => esc_html__( 'Footer 5', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget col-sm-4 %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'id' => 'sidebar-shop',
		'name' => esc_html__( 'Sidebar Shop', 'craze' ),
		'description'   => esc_html__( 'Add widgets here.', 'craze' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}
add_action( 'widgets_init', 'craze_widgets_init' );

// remove sidebar from single product page

function craze_remove_sidebar_product_page() {
    if ( is_singular('product') ) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
    }
}
add_action('template_redirect', 'craze_remove_sidebar_product_page');

/**
 * Enqueue scripts and styles.
 */
function craze_scripts() {

    wp_enqueue_script( 'craze-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '1.0', true );

    wp_enqueue_script( 'craze-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery'), '1.0', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css',array(),'3.3.4' );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome-4.7.0/css/font-awesome.min.css',array(),'4.7.0' );
	
	wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() .'/css/simple-line-icons.css',array(),'2.4.0' );
	
	wp_enqueue_style( 'craze-raleway-font','https://fonts.googleapis.com/css?family=Raleway', array(), '1.0', 'all' );
	
	wp_enqueue_style( 'craze-style', get_stylesheet_uri() );
   
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.4', true );
	
	wp_enqueue_script( 'craze-custom-js', get_template_directory_uri() . '/js/custom-js.js', array('jquery'), '2.0.1', true );
    
}

add_action( 'wp_enqueue_scripts', 'craze_scripts' );


function craze_admin_script($foody_hook){
	
	if($foody_hook != 'appearance_page_craze_pro') {
		return;
	} 
    
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome-4.7.0/css/font-awesome.min.css',array(),'4.7.0' );
	wp_enqueue_style( 'craze-custom-css', get_template_directory_uri() .'/css/craze-custom.css',array(),'1.0' );

}

add_action( 'admin_enqueue_scripts', 'craze_admin_script' );


// Display an optional post thumbnail.

if ( ! function_exists( 'craze_post_thumbnail')) :
						
	function craze_post_thumbnail() {
	
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
	
			return;
	
		}
	
		if ( is_singular() ) :
		?>
	
		<div class="entry-summary">
	
			<?php the_post_thumbnail(); ?>
	
		</div><!-- .post-thumbnail -->
	
	   
		<?php else : ?>
	
	
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
	
				<?php
					the_post_thumbnail('post-thumbnail', array( 'alt' => esc_attr(get_the_title())));
					
				?>
	
			</a>
		</div>
	
	
	
		<?php endif; // End is_singular()
	}

endif;


/**
 * Clean up the_excerpt()
 */
function craze_excerpt_length($length) {
 
	if ( is_admin() ) {
        return $length;
    }else{
		return 50;
	}
	
}		

function craze_excerpt_more($more) {
 
	return '<a class="craze-excerpt-btn" href="'.esc_url(get_the_permalink()).'" rel="nofollow">'.__("Read More &hellip;",'craze').'</a>';
}

add_filter('excerpt_length', 'craze_excerpt_length');

add_filter('excerpt_more', 'craze_excerpt_more');	


/*Add theme menu page*/
 
add_action('admin_menu', 'craze_menu');

function craze_menu() {
	
	$craze_page_title = __("Craze Pro",'craze');
	
	$craze_menu_title = __("Craze Pro",'craze');
	
	add_theme_page($craze_page_title, $craze_menu_title, 'edit_theme_options', 'craze_pro', 'craze_pro_page');  
	
} 

/*
**
** Premium Theme Feature Page
**
*/

function craze_pro_page(){
	
	if ( is_admin() ) {
		include_once( get_template_directory(). '/inc/admin/premium-screen/index.php');
	} 
	
}

 
/* Include Premium Button Class File*/
 
require_once( trailingslashit( get_template_directory() ) . 'trt-customize-pro/premium/class-customize.php' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';