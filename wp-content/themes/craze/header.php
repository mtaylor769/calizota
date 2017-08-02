<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Craze
 */
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div class="custom-header">
				
	<div class="custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div>
</div> <!-- custom-header -->

<div class="container-fluid phoe-header-top">
		<div class="row">
			<div class="col-md-6 col-sm-7 col-sx-12 phoe-paypal">
				<p> <span class="fa fa-paypal"></span>
					
					<?php echo esc_html(get_theme_mod("paypal_highlight_before_text")); ?>
					
						<span><?php echo esc_html(get_theme_mod("paypal_highlight_text")); ?></span> 
							
					<?php echo esc_html(get_theme_mod("paypal_highlight_after_text")); ?>
				</p>
			</div>
			<div class="col-md-6 col-sm-5 col-sx-12 phoe-top-menu">
				<div class="row">
					<ul class="pull-right">
						<li><a href="#"><span class="fa fa-phone"></span><?php echo esc_html(get_theme_mod("cust_care_no")); ?></a></li>
						<li><a href="#"><span class="fa fa-envelope"></span><?php echo esc_html(get_theme_mod("cust_care_id"));  ?></a></li>					
					</ul>
				</div>
			</div>
		</div>
</div>
<div class="container-fluid phoe-head-main">
	<div class="row">
	
	
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'craze' ); ?></a>

			<header id="masthead" class="site-header" role="banner">
				
				<div class="container craze_head_wrap">
					<?php if ( class_exists( 'WooCommerce' ) ) :?>
					<div class="col-xs-3 col-sm-4 phoe-my-account">
						<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id')));?>"> <span class="fa fa-user"></span> <span class="mobile_hide"><?php esc_html_e('My Account', 'craze'); ?></span> </a>
					</div>
					<?php endif;?>	
					<div class="col-xs-5 col-sm-4 phoe-logo">
						<div class="site-branding">
							<?php
							
							Craze_custom_logo();
							
							if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							endif;

							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
							<?php
							endif; ?>
						</div><!-- .site-branding -->
					</div>
					
					<?php if ( class_exists( 'WooCommerce' ) ) :?>
					<div class="col-xs-4 col-sm-4 phoe-cart-right">
					
						<?php global $woocommerce; ?><a class="cart-contents" href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'craze'); ?>"> <span class="icon-basket-loaded"></span> <?php echo sprintf(_n('<span class="item-count">%d</span> <span class="mobile_item_hide">'.__("item","craze").'</span>', '<span class="item-count">%d</span> <span class="mobile_item_hide">'.__("items","craze").'</span>', $woocommerce->cart->cart_contents_count, 'craze'), $woocommerce->cart->cart_contents_count);?> <span class="mobile_item_hide"> - </span><?php echo wp_kses_post($woocommerce->cart->get_cart_total()); ?></a>
					
					</div>
					<?php endif;?>	
					
				</div><!-- .container -->
				
				<div class="phoe-navigation-main">
				<div class="container">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class'=> 'craze-nav' ) ); ?>
					</nav><!-- #site-navigation -->
					
					<span class="craze-search-icon"><a href="javascript:void(0);"><i class="fa fa-search"></i></a></span>
						
					<div class="craze-search-form">
						<?php 	get_search_form();?>
						<span class="craze-search-close-icon"><i class="fa fa-times"></i></span>
					</div>
				</div>
				</div>
				
			</header><!-- #masthead -->

			
		</div>
	</div>
</div>

<div class="container-fluid phoe-banner-main">
	<div class="container">
		
				<div class="phoe-banner-top-bar">
					<ul>
						<li>
							<p>
								<i class="fa fa-truck"></i>
								<span><?php echo esc_html(get_theme_mod("banner_del_info")); ?></span> <?php echo esc_html(get_theme_mod("first_banner_cntnt")); ?>
							</p>
						</li>
						<li>
							<p>
								<i class="fa fa-globe"></i>
								<span><?php echo esc_html(get_theme_mod("scnd_banner_head")); ?></span> <?php echo esc_html(get_theme_mod("scnd_banner_cntnt")); ?>
							</p>
						</li>
						<li>
							<p>
								<i class="fa fa-gift"></i>
								<span><?php echo esc_html(get_theme_mod("thrd_banner_head")); ?></span> <?php echo esc_html(get_theme_mod("thrd_banner_cntnt")); ?>
							</p>
						</li>
					</ul>
				</div>
			
	</div>
</div>
	
	<div class="container">
	<div id="content" class="site-content">
