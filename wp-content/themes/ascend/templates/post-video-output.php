<?php 
global $post;
 	$video = get_post_meta( $post->ID, '_kad_post_video', true );
    if (filter_var($video, FILTER_VALIDATE_URL)) {  ?>
        <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
            <meta itemprop="name" content="<?php echo esc_attr(get_post_meta( $post->ID, '_kad_video_title', true ));?>" />
            <meta itemprop="description" content="<?php echo esc_attr(get_post_meta( $post->ID, '_kad_video_description', true ));?>" />
            <?php if(has_post_thumbnail()) { ?>
                <meta itemprop="thumbnailURL" content="<?php the_post_thumbnail_url(); ?>"/>
            <?php } ?>
            <meta itemprop="contentURL" content="<?php echo esc_attr($video);?>" />
            <div id="schema-videoobject" class="videofit video-container">
            <?php echo do_shortcode(wp_oembed_get(wp_kses_post($video)));?>
            </div>
        </div>
    <?php 
    } else { ?>
        <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
            <meta itemprop="name" content="<?php echo esc_attr(get_post_meta( $post->ID, '_kad_video_title', true ));?>" />
            <meta itemprop="description" content="<?php echo esc_attr(get_post_meta( $post->ID, '_kad_video_description', true ));?>" />
            <?php if(has_post_thumbnail()) { ?>
                <meta itemprop="thumbnailURL" content="<?php the_post_thumbnail_url(); ?>"/>
            <?php } 
            preg_match('/src="([^"]+)"/', $video, $match);
            if(is_array($match)){
            	$url = $match[1];
            } else {
            	$url = '';
            }
            ?>
            <meta itemprop="embedURL" content="<?php echo esc_attr($url);?>" />
            <div id="schema-videoobject" class="videofit video-container">
            <?php echo do_shortcode(wp_kses_post($video)); ?>
            </div>
        </div>
<?php }  
	if (has_post_thumbnail( $post->ID ) ) { 
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
            <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
            </div>
        <?php } 