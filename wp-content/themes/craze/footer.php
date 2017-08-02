<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Craze
 */
 
?>

		</div><!-- #content -->
	</div><!-- #page -->
	</div>
<div class="container-fluid phoe-footer-main">
	<div class="row">
		<div class="container">
			
			<footer id="colophon" class="site-footer" role="contentinfo">
			
				<div id="inner-footer" class="clearfix">
										
					<div id="widget-footer" class="clearfix">
					
						<?php if ( is_active_sidebar( !dynamic_sidebar('footer1-craze'))) : ?>		
									
							<div class="col-sm-3">		
											
							</div>			
								
						<?php endif; ?>	
				
						<?php if ( is_active_sidebar( !dynamic_sidebar('footer2-craze'))) : ?>
						
						<div class="col-sm-3">
							
						</div>
					
						<?php endif; ?>
						
						<?php if ( is_active_sidebar( !dynamic_sidebar('footer3-craze'))) : ?>

						<div class="col-sm-3">
						
						</div>	

						<?php endif; ?>
						<?php if ( is_active_sidebar( !dynamic_sidebar('footer4-craze'))) : ?>
						
						<div class="col-sm-3">
							
						</div>
						
						<?php endif; ?>
						<?php if ( is_active_sidebar( !dynamic_sidebar('footer5-craze'))) : ?>
						
						<div class="col-sm-3">
							
						</div>
							
						<?php endif; ?>
						
					</div> <!-- #widget-footer -->
							
				</div> <!-- #inner-footer -->
				
				<div class="site-info">
					<p><?php printf(esc_html(get_theme_mod("copyright_text"))); ?> <a href="<?php echo esc_url( __( 'http://phoeniixx.com/', 'craze' ) ); ?>" rel="designer"><?php esc_html_e('phoeniixx','craze'); ?></a> </p>
				</div><!-- .site-info -->
				
			</footer><!-- #colophon -->

		</div><!-- .container -->
	</div><!-- .row -->
</div><!-- .container-fluid -->

<?php wp_footer(); ?>

</body>
</html>