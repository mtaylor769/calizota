<div class="post-grid-footer-meta kt_color_gray">
    <span class="postdate kt-post-date updated" itemprop="datePublished">
        <?php echo get_the_date(get_option( 'date_format' ));?>
    </span> 
    <?php 
    if(get_comments_number() != 0){
        echo '<span class="postcommentscount kt-post-comments"><a href="'.esc_url(get_the_permalink()).'#comments" class="kt_color_gray"><i class="kt-icon-comments-o"></i>'.get_comments_number( '0', '1', '%' ).'</a></span>';
    } ?>
    <span class="postauthor kt-post-author author vcard">
            <span>
                <span class="kt_color_gray" rel="author" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo esc_attr(get_the_author()); ?>">
                	<meta itemprop="author" class="fn" content="<?php echo esc_attr(get_the_author()); ?>">
                 	<i class="kt-icon-user"></i>
                </span>
            </span>
    </span>
</div>