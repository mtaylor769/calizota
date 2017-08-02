<?php
get_header(); 

global $post, $ascend_grid_carousel;
	$post_id 				= get_option( 'page_for_posts' );
    $blog_type 				= get_post_meta( $post_id, '_kad_blog_type', true );
    $blog_columns 			= get_post_meta( $post_id, '_kad_blog_columns', true );
	$ascend_grid_carousel 		= false;
    $ascend_blog_loop['loop'] 	= 1;
    $paged 					= (get_query_var('paged')) ? get_query_var('paged') : 1;
    $lay 					= ascend_get_postlayout($blog_type);
    $ascend_grid_columns 		= $blog_columns ? absint( $blog_columns ) : 3;
    if(ascend_display_sidebar()) {
        $fullclass 		= '';
        $ascend_has_sidebar = true;
    } else {
        $fullclass 		= 'fullwidth';
        $ascend_has_sidebar = false;
    }
    $itemsize = ascend_get_post_grid_item_size($ascend_grid_columns, $ascend_has_sidebar);

    /**
    * @hooked ascend_page_title - 20
    */
     do_action('ascend_page_title_container');
    ?>
	
	<div id="content" class="container">
		<div class="row">
  			<div class="main <?php echo esc_attr(ascend_main_class());?> <?php echo esc_attr($lay['pclass']); ?>" id="ktmain" role="main">
				<div class="kt_archivecontent <?php echo esc_attr($lay['tclass']); ?>" data-masonry-selector="<?php echo esc_attr($lay['data_selector']);?>" data-masonry-style="<?php echo esc_attr($lay['data_style']);?>"> 
	  				<?php
					if (!have_posts()) :?>
						<div class="error-not-found"><?php _e('Sorry, no blog entries found.', 'ascend'); ?></div>
					<?php 
					endif; 
					$ascend_blog_loop['count'] = $wp_query->post_count;
					while (have_posts()) : the_post(); 
					 	if($lay['sum'] == 'full'){ 
			                if (has_post_format( 'quote' )) {
			                    get_template_part('templates/content', 'post-full-quote'); 
			                } else {
			                    get_template_part('templates/content', 'post-full'); 
			                }
				        } else if($lay['sum'] == 'grid') { 
				        	if($lay['highlight'] == 'true' && $ascend_blog_loop['loop'] == 1 && $paged == 1) {
		                        get_template_part('templates/content', get_post_format());
		                    } else { ?>
		                       	<div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
		                       		<?php get_template_part('templates/content', 'post-grid'); ?>
		                       	</div>
		                   <?php }
				        } else if($lay['sum'] == 'photo') { ?>
			               	<div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
	                       		<?php get_template_part('templates/content', 'post-photo-grid'); ?>
	                       	</div>
				        <?php
				        } else if($lay['sum'] == 'below_title') {
				        	get_template_part('templates/content', 'post-title-above');
				        } else { 
				        	get_template_part('templates/content', get_post_format());
				        }
				        $ascend_blog_loop['loop'] ++;
	                endwhile;
            	?>
            	 </div><!-- /.archive content -->
            	 <?php 
					/**
	                * @hooked ascend_pagination - 20
	                */
	                do_action('ascend_pagination');
	                
	                /**
	                * @hooked ascend_page_comments - 20
	                */
	                do_action('ascend_page_footer');
	                ?>			
			</div><!-- /.main -->
			<?php 
			/**
		    * Sidebar
		    */
			if (ascend_display_sidebar()) : 
			      	get_sidebar();
		    endif; ?>
		</div><!-- /.row-->
	</div><!-- /.content -->
	<?php 

    get_footer(); 