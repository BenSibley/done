<?php get_header(); ?>

<?php get_template_part('banner'); ?>

<div class='archive-header'>
	<p>Category:</p>
    <h2><?php single_cat_title(); ?></h2>
</div>

<?php get_template_part('loop', 'archive'); ?>

<?php compete_themes_post_navigation(); ?>

<?php get_footer(); ?>