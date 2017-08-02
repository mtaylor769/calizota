<?php
/*
* DO NOT ADD SCRIPTS HERE, Use a child theme or plugin to add scripts into your header.
* 
- Force plugins to stop stating incorrect errors -
* wp_head();
*/
  	get_template_part('templates/head');
  	?>
	<body <?php body_class(); ?>>
	<?php do_action('ascend_after_body_open'); ?>
	<div id="wrapper" class="container">
	<?php
	   	do_action('ascend_beforeheader');

	      	get_template_part('templates/header');
	      
	    do_action('ascend_header_after');
	  ?>

  			<div id="inner-wrap" class="wrap clearfix contentclass hfeed" role="document">

        	<?php 	/*
		        	* Hooked 
		        	*/
		        	do_action('ascend_content_top');
