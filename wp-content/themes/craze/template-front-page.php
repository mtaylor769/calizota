<?php

/**

Template Name: Homepage

**/	
get_header();	

?>
</div>
</div>

<?php if(get_theme_mod("craze_home_banner_on_off") != '' && get_theme_mod("craze_home_banner_on_off") == 'on'): ?>

<div class="container-fluid phoe-slid">
	<div class="row">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
			<div class="item active">
			<?php if(get_theme_mod("bnr_img1") != ''): ?>
				<img src="<?php echo esc_url(get_theme_mod("bnr_img1")); ?>" />
			<?php endif;?>	 
			</div>

			<div class="item">
			  <?php if(get_theme_mod("bnr_img2") != ''): ?>
					<img src="<?php echo esc_url(get_theme_mod("bnr_img2")); ?>" />
				<?php endif;?>	
			</div>

			<div class="item">
				<?php if(get_theme_mod("bnr_img3") != ''): ?>
					<img src="<?php echo esc_url(get_theme_mod("bnr_img3")); ?>" />
				<?php endif;?>	
			</div>
			
		  </div>

		</div>
	</div>
</div>

<?php endif; ?>

<div class="container">

<?php if(get_theme_mod("craze_small_banner_on_off") != '' && get_theme_mod("craze_small_banner_on_off") == 'on'): ?>

<div class="phoe-trendy-main">
	<div class="row">
		<div class="col-sm-4">
			<div class="phoe-trendy">
				<span class="phoe-trendy-img">
					<?php if(get_theme_mod("sml_bnr1_img") != ''): ?>
						<img src="<?php echo esc_url(get_theme_mod("sml_bnr1_img"));?>" />
					<?php endif;?>	
				</span>
				<div class="phoe-trendy-content">
					<h2><?php echo esc_html(get_theme_mod("sml_bnr1_high_before_txt")); ?><span> <?php echo esc_html(get_theme_mod("sml_bnr1_high_txt")); ?></span> <?php echo esc_html(get_theme_mod("sml_bnr1_high_after_txt")); ?></h2>
					<a href="<?php echo esc_html(get_theme_mod("sml_bnr1_btn_link")); ?>"><?php echo esc_html(get_theme_mod("sml_bnr1_btn_txt")); ?></a>
				</div>
			</div>
		</div>
		
		<div class="col-sm-4">
			<div class="phoe-trendy">
				<span class="phoe-trendy-img">
					<?php if(get_theme_mod("sml_bnr2_img") != ''): ?>
						<img src="<?php echo esc_url(get_theme_mod("sml_bnr2_img"));?>" />
					<?php endif;?>	
				</span>
				<div class="phoe-trendy-content">
					<h2><?php echo esc_html(get_theme_mod("sml_bnr2_high_before_txt")); ?> <span><?php echo esc_html(get_theme_mod("sml_bnr2_high_txt")); ?></span> <?php echo esc_html(get_theme_mod("sml_bnr2_high_after_txt")); ?></h2>
					<a href="<?php echo esc_html(get_theme_mod("sml_bnr2_btn_link")); ?>"><?php echo esc_html(get_theme_mod("sml_bnr2_btn_txt")); ?></a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="phoe-trendy">
				<span class="phoe-trendy-img">
					<?php if(get_theme_mod("sml_bnr3_img") != ''): ?>
						<img src="<?php echo esc_url(get_theme_mod("sml_bnr3_img"));?>" />
					<?php endif;?>	
				</span>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

<?php if ( class_exists( 'WooCommerce' ) ) :?>
	<div class="phoe-feture-product">
		<h4><?php echo esc_html(get_theme_mod("top_prdct_head")); ?></h4>
		<?php echo do_shortcode ('[top_rated_products per_page="5" columns="5"]'); ?>
	</div>
<?php endif; ?>
<div class="phoe-shop-now-banner">
	<?php if(get_theme_mod("body_bnnr_img") != ''): ?>
		<img src="<?php echo esc_url(get_theme_mod("body_bnnr_img"));?>" />
	<?php endif;?>
	
	<span>
		<a href="<?php echo esc_html(get_theme_mod("baner_btn_link")); ?>"><?php echo esc_html(get_theme_mod("body_bnnr_btn")); ?><i class="fa fa-long-arrow-right"></i>
		</a>
	</span>
</div>
<?php if ( class_exists( 'WooCommerce' ) ) :?>
<div class="row">
	<div class="col-sm-4 col-xs-6 phoe-related-product">
		<div class="phoe-multiple-product">
			<h4><?php echo esc_html(get_theme_mod("sale_prdct_head")); ?></h4>
			<?php echo do_shortcode ('[sale_products per_page="3"]'); ?>
		</div>
	</div>
	<div class="col-sm-4 col-xs-6 phoe-related-product">
		<div class="phoe-multiple-product">
			<h4><?php echo esc_html(get_theme_mod("best_selling_prdct_head")); ?></h4>
			<?php echo do_shortcode ('[best_selling_products per_page="3"]'); ?>
		</div>
	</div>
	<div class="col-sm-4 col-xs-6 phoe-related-product">
		<div class="phoe-multiple-product">
			<h4><?php echo esc_html(get_theme_mod("top_rated_prdct_head")); ?></h4>
			<?php echo do_shortcode ('[top_rated_products per_page="3"]'); ?>
		</div>
	</div>
</div>
<?php 

endif;

get_footer(); ?>