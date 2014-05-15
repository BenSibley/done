<?php get_header(); ?>
    
<div class='archive-header'>
	<p>Tag:</p>
	<h2><?php single_tag_title(); ?></h2>
</div>

<?php get_template_part('loop'); ?>

<?php ct_post_navigation(); ?>

<?php get_footer(); ?>