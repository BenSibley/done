<?php
/*
 * Template Name: Portfolio
 *
 */

get_header(); ?>

<?php get_template_part('banner'); ?>

<div class='entry-header'>
    <h1 class='entry-title'><?php the_title(); ?></h1>
</div>
<?php ct_display_portfolio_items(); ?>

<?php get_footer(); ?>

<?php
/* get the Project Category(ies) for each Project */
function ct_get_porftolio_item_category($portfolio_item){
    $categories = get_the_terms($portfolio_item->ID, 'done_project_category');
    if ( $categories && ! is_wp_error( $categories ) ){
        $category_links = array();

        foreach ( $categories as $category ) {
            $category_links[] = $category->name;
        }
        $the_category = join( ", ", $category_links );
        return $the_category;
    }
}

/* creates dropdown & normal links for filtering */
function ct_display_filter_options(){

    $taxonomy = 'done_project_category';
    $tax_terms = get_terms($taxonomy);

    $html = "<div id='dropdown-container' class='dropdown-container'>";
    $html .= "<span id='filter-label'>Filter by Category</span>";
    $html .= ct_downward_arrows_svg();
    $html .= "<ul class='dropdown'>";
    $html .= "<li><a class='current' href='#'>all</a></li>";
    foreach ($tax_terms as $tax_term) {
        $html .= "<li><a href='#'>$tax_term->name</a></li>";
    }
    $html .= "</ul></div>";
    echo $html;
}

function ct_display_portfolio_items(){

    /* get all projects */
    $portfolio_items = get_posts(array(
        'post_type' => 'done_project',
        'posts_per_page' => 99,
    ));

    ct_display_filter_options();

    $html = "<ul id='portfolio-items' class='portfolio-items'>";

    /* output html for each portfolio item */
    foreach($portfolio_items as $portfolio_item){

        /* add lis with all and category name classes */
        $html .= "<li class='portfolio-item all ". ct_get_porftolio_item_category($portfolio_item). "'>";
        /* add the featured image as a background-image */
        if (has_post_thumbnail( $portfolio_item->ID ) ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $portfolio_item->ID ), 'single-post-thumbnail' );
            $image = $image[0];
            $html .= "<div class='image-container' style=\"background-image: url('".$image."')\">";
        } else {
            $html .= "<div>";
        }
        $html .= "<a class='image-link' href='". get_the_permalink($portfolio_item) ."'></a>";
        $html .= "<div class='content'><span>". ct_get_porftolio_item_category($portfolio_item) ."</span>";
        $html .= "<a href='". get_the_permalink($portfolio_item) ."'><h2>". get_the_title($portfolio_item) ."</h2></a>";
        $html .= "</div></div></li>";
    }
    $html .= "</ul>";
    $html .= "<nav id='gallery-navigation' class='gallery-navigation'><ul></ul></nav>";
    echo $html;

}


