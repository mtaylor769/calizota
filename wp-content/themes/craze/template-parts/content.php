<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Craze
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php  craze_post_thumbnail(); ?>

	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php craze_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	
	<div class="entry-content">
	
	<?php
		if ( is_single() ) : 
	
			the_content();
			
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'craze' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );

		else: 
		
			the_excerpt(); 
				
		endif; 
	?>
		
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php craze_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
