<?php get_header(); ?>

<div class="search-container">
    
    <h1 class="entry-title"><span>Search Results for</span> "<?php echo $s ?>"</h1>
    <?php get_search_form(); ?>

    <?php
    // The loop
    if ( have_posts() ) :
        while (have_posts() ) :
            the_post();
            get_template_part( 'content-search' );
        endwhile;
    endif;
    ?>
    
    <?php compete_themes_post_navigation(); ?>
        
    <div class="search-bottom">
        <p>Can't find what you're looking for?  Try refining your search:</p>
        <?php get_search_form(); ?>    
    </div>

</div>
<?php get_footer(); ?>