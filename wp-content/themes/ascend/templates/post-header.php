<?php
	// Post Header
	global $post; 
			$ascend = ascend_get_options();
			if(isset($ascend['single_header_title_size'])){
				$title_data = $ascend['single_header_title_size'];
			} else {
				$title_data = '70';
			}

			if(isset($ascend['single_header_title_size_small'])){
				$title_small_data = $ascend['single_header_title_size_small'];
			} else {
				$title_small_data = '30';
			}

			if(isset($ascend['single_header_subtitle_size'])){
				$subtitle_data = $ascend['single_header_subtitle_size'];
			} else {
				$subtitle_data = '40';
			}

			if(isset($ascend['single_header_subtitle_size_small'])){
				$subtitle_small_data = $ascend['single_header_subtitle_size_small'];
			} else {
				$subtitle_small_data = '20';
			}


	// Sinlge Product
	if(is_singular('product')){
		if(!empty($post_header_title)) {
			$page_title_title = $post_header_title;
		} else if(isset($ascend['product_post_title_content']) && $ascend['product_post_title_content'] == 'custom') {
			if(isset($ascend['product_header_title_text'])) {
				$page_title_title = $ascend['product_header_title_text']; 
			} else { 
				$page_title_title = '';
			}
			if(!empty($ascend['product_header_subtitle_text'])) {
				$bsub = $ascend['product_header_subtitle_text'];
			}
		} else if (isset($ascend['product_post_title_content']) && $ascend['product_post_title_content'] == 'category') {
			$terms = wp_get_post_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
			if ( !empty($terms) ) {
	            $cat = $terms[0];
	            $page_title_title = $cat->name;
	        } else {
	            $page_title_title = '';
	        }
		} else {
			$page_title_title =  get_the_title();
		}
		if( ascend_display_product_breadcrumbs()) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	} else if(is_singular('portfolio')){
		// Sinlge Portfolio
		if(!empty($post_header_title)) {
			$page_title_title = $post_header_title;
		} else if(isset($ascend['portfolio_post_title_content']) && $ascend['portfolio_post_title_content'] == 'custom') {
			if(isset($ascend['portfolio_header_title_text'])) {
				$page_title_title = $ascend['portfolio_header_title_text']; 
			} else { 
				$page_title_title = '';
			}
			if(!empty($ascend['portfolio_header_subtitle_text'])) {
				$bsub = $ascend['portfolio_header_subtitle_text'];
			}
		} else if (isset($ascend['portfolio_post_title_content']) && $ascend['portfolio_post_title_content'] == 'portfolio-type') {
			$terms = wp_get_post_terms( $post->ID, 'portfolio-type', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
			if ( !empty($terms) ) {
	            $cat = $terms[0];
	            $page_title_title = $cat->name;
	        } else {
	            $page_title_title = '';
	        }
		} else {
			$page_title_title =  get_the_title();
		}
		if( ascend_display_portfolio_breadcrumbs()) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	} else if(is_singular('post')){
		// Blog Post
		if(!empty($post_header_title)) {
			$page_title_title = $post_header_title;
		} else if(isset($ascend['blog_post_title_content']) && $ascend['blog_post_title_content'] == 'custom') {
			if(isset($ascend['post_header_title_text'])) {$page_title_title = $ascend['post_header_title_text']; } else { $page_title_title = '';}
			if(!empty($ascend['post_header_subtitle_text'])){ $bsub = $ascend['post_header_subtitle_text'];}
		} else if (isset($ascend['blog_post_title_content']) && $ascend['blog_post_title_content'] == 'posttitle') {
			$page_title_title =  get_the_title();
		} else {
			$terms = wp_get_post_terms( $post->ID, 'category', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
			if ( !empty($terms) ) {
	            $cat = $terms[0];
	            $page_title_title = $cat->name;
	        } else {
	            $page_title_title = '';
	        }
		}
		if( ascend_display_post_breadcrumbs()) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	} else if(is_singular('tribe_events')){
		// Blog Post
		if(!empty($post_header_title)) {
			$page_title_title = $post_header_title;
		} else {
			$page_title_title = tribe_get_event_label_singular();
		} 
		if( ascend_display_post_breadcrumbs()) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	} else if(is_attachment()){
		$page_title_title = get_the_title();
		if( apply_filters('ascend_attachment_breadcrumbs', false) ) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	} else {
		// Other singe post.
		if(!empty($post_header_title)) {
			$page_title_title = $post_header_title;
		} else  {
			$page_title_title =  get_the_title();
		} 
		if( apply_filters('ascend_custom_post_type_breadcrumbs', false, $post) ) {
		 	$breadcrumb = true;
		 	$breadclass = "kt_bc_active";
		} else {
		 	$breadcrumb = false;
		 	$breadclass = "kt_bc_not_active";
		}
	}

?>
	<div id="pageheader" class="titleclass post-header-area <?php echo esc_attr($breadclass);?>">
	<div class="header-color-overlay"></div>
	<?php do_action('ascend_header_overlay'); ?>
		<div class="container">
			<div class="page-header">
				<div class="page-header-inner">
					<h1 class="post_head_title entry-title" itemprop="name" <?php echo 'data-max-size="'.esc_attr($title_data).'" data-min-size="'.esc_attr($title_small_data).'"'; ?>><?php echo esc_html($page_title_title); ?></h1>
					<?php if(!empty($bsub)) { echo '<p class="subtitle" data-max-size="'.esc_attr($subtitle_data).'" data-min-size="'.esc_attr($subtitle_small_data).'"> '.do_shortcode($bsub).' </p>'; } ?>
				</div>
			</div>
		</div><!--container-->
		<?php if($breadcrumb) { ascend_breadcrumbs(); } ?>
	</div><!--titleclass-->
