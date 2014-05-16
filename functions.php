<?php

// register and enqueue all of the scripts used by Aside
function ct_load_javascript_files() {

    wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400');
    wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');

    if(! is_admin() ) {
        wp_enqueue_script('functions', get_template_directory_uri() . '/js/functions.js', array('jquery'),'', true);
        wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array('jquery'),'', true);
        wp_enqueue_script('placeholders', get_template_directory_uri() . '/js/placeholders.min.js', array('jquery'),'', true);
        wp_enqueue_script('media-query-polyfill', get_template_directory_uri() . '/js/respond.min.js', array('jquery'),'', true);
        wp_enqueue_script('tappy', get_template_directory_uri() . '/js/tappy.min.js', array('jquery'),'', true);

        wp_enqueue_style('google-fonts');
        wp_enqueue_style('font-awesome');
    }
    // enqueues the comment-reply script on posts & pages.  This script is included in WP by default
    if( is_singular() && comments_open() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' ); 
}

add_action('wp_enqueue_scripts', 'ct_load_javascript_files' );

// Initialize the metabox class
add_action( 'init', 'ct_initialize_cmb_meta_boxes', 9999 );
function ct_initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'assets/custom-meta-boxes/init.php' );
    }
}

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'ct_theme_setup', 10 );

function ct_theme_setup() {
	
    /* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();
    
	/* Theme-supported features go here. */
    add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary' ));
    add_theme_support( 'hybrid-core-template-hierarchy' );
    add_theme_support( 'hybrid-core-styles', array( 'style', 'reset', 'gallery' ) );
    add_theme_support( 'loop-pagination' );
    add_theme_support( 'featured-header' );
    add_theme_support( 'cleaner-gallery' );
    add_theme_support( 'automatic-feed-links' ); //from WordPress core not theme hybrid

    // adds the file with the customizer functionality
    require_once( trailingslashit( get_template_directory() ) . 'functions-admin.php' );

    // adds the file with the customizer functionality
    require_once( trailingslashit( get_template_directory() ) . 'functions-theme-options.php' );

    // require TGM Plugin Activation
    require_once( trailingslashit( get_template_directory() ) . 'assets/TGM/class-tgm-plugin-activation.php' );
    // require file used to register required plugins
    require_once( trailingslashit( get_template_directory() ) . 'assets/TGM/ct_done_require_plugins.php' );
}

// takes user input from the customizer and outputs linked social media icons
function ct_social_media_icons() {
    
    $social_sites = ct_customizer_social_media_array();
    	
    // any inputs that aren't empty are stored in $active_sites array
    foreach($social_sites as $social_site) {
        if( strlen( get_theme_mod( $social_site ) ) > 0 ) {
            $active_sites[] = $social_site;
        }
    }
    
    // for each active social site, add it as a list item 
    if(!empty($active_sites)) {
        echo "<ul class='social-media-icons'>";
		foreach ($active_sites as $active_site) {?>
			<li>
				<a href="<?php echo esc_url(get_theme_mod( $active_site )); ?>">
					<?php if( $active_site == "vimeo") { ?>
						<i class="fa fa-<?php echo $active_site; ?>-square"></i> <?php
					} else { ?>
						<i class="fa fa-<?php echo $active_site; ?>"></i><?php 
					} ?>
				</a>
			</li><?php
		}
		echo "</ul>";
	}
}

// Creates the next/previous post section below every post
function ct_further_reading() {

    global $post;

    // gets the next & previous posts if they exist
    $previous_blog_post = get_adjacent_post(false,'',true);
    $next_blog_post = get_adjacent_post(false,'',false);

    if(get_the_title($previous_blog_post)) {
        $previous_title = get_the_title($previous_blog_post);
    } else {
        $previous_title = "The Previous Post";
    }
    if(get_the_title($next_blog_post)) {
        $next_title = get_the_title($next_blog_post);
    } else {
        $next_title = "The Next Post";
    }
    if(get_post_type() == "done_project"){
        $previous_text = "Previous Project";
    } else {
        $previous_text = "Previous Post";
    }
    if(get_post_type() == "done_project"){
        $next_text = "Next Project";
    } else {
        $next_text = "Next Post";
    }

    echo "<nav class='further-reading'>";
    if($previous_blog_post) {
        echo "<a class='prev' href='".get_permalink($previous_blog_post)."'>" . ct_left_arrows_svg() . " $previous_text <span class='screen-reader-text'>" . $previous_title . "</span></a>";
    } else {
        echo "<a class='prev' href='".esc_url(home_url())."'>Return Home</a>";
    }
    if($next_blog_post) {
        echo "<a class='next' href='".get_permalink($next_blog_post)."'>$next_text <span class='screen-reader-text'>" . $next_title . "</span>" . ct_right_arrows_svg() . "</a>";
    } else {
        echo "<a class='next' href='".esc_url(home_url())."'>Return Home</a>";
    }
    echo "</nav>";
}

// Outputs the categories the post was included in with their names hyperlinked to their permalink
function ct_category_display() {
       
    $categories = get_the_category();
    $separator = ' & ';
    $output = '';
    if($categories){
	    echo "<p>";
        foreach($categories as $category) {
            $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'ct_replace_me' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
        }
        echo trim($output, $separator);
	    echo "</p>";
    }
}

// Outputs the tags the post used with their names hyperlinked to their permalink
function ct_tags_display() {
       
    $tags = get_the_tags();
    $separator = ', ';
    $output = '';
    if($tags){
        echo "<div class='entry-tags'><span>Tags</span><p>";
        foreach($tags as $tag) {
            $output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'ct_replace_me' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
        }
        echo trim($output, $separator);
	    echo "</p></div>";
    }
}

/* added to customize the comments. Same as default except -> added use of gravatar images for comment authors */
function ct_customize_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
 
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <div class="comment-author"><?php echo get_avatar( get_comment_author_email(), 48 ); ?>
                <div>
                    <div class="author-name"><?php comment_author_link(); ?></div>
                    <div class="comment-date"><?php comment_date('n/j/Y'); ?></div>
                </div>    
            </div>
            <div class="comment-content">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', 'ct_replace_me') ?></em>
                    <br />
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
            <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'ct_replace_me' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            <?php edit_comment_link( 'edit' ); ?>
        </article>
    </li>
    <?php
}

/* added HTML5 placeholders for each default field */
function ct_update_fields($fields) {

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

	$fields['author'] = 
		'<p class="comment-form-author">
		    <label class="screen-reader-text">Your Name</label>
			<input required placeholder="Your Name*" id="author" name="author" type="text" aria-required="true" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' />
    	</p>';
    
    $fields['email'] = 
    	'<p class="comment-form-email">
    	    <label class="screen-reader-text">Your Email</label>
    		<input required placeholder="Your Email*" id="email" name="email" type="email" aria-required="true" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' />
    	</p>';
	
	$fields['url'] = 
		'<p class="comment-form-url">
		    <label class="screen-reader-text">Your Website URL</label>
			<input placeholder="Your URL" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" />
    	</p>';
    
	return $fields;
}
add_filter('comment_form_default_fields','ct_update_fields');

function ct_update_comment_field($comment_field) {
	
	$comment_field = 
		'<p class="comment-form-comment">
            <label class="screen-reader-text">Your Comment</label>
			<textarea required placeholder="Enter Your Comment&#8230;" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
		</p>';
	
	return $comment_field;
}
add_filter('comment_form_field_comment','ct_update_comment_field');

// for 'read more' tag excerpts
function ct_excerpt() {
	
	global $post;
	// check for the more tag
    $ismore = strpos( $post->post_content, '<!--more-->');
    
	/* if there is a more tag, edit the link to keep reading
	*  works for both manual excerpts and read more tags
	*/
    if($ismore) {
        the_content("Read the Post <span class='screen-reader-text'>" . get_the_title() . "</span>");
    } elseif(get_post_format() == ('aside' || 'status')) {
    	the_content();
    }
    // otherwise the excerpt is automatic, so output it
    else {
        the_excerpt();
    }
}

// for custom & automatic excerpts
function ct_excerpt_read_more_link($output) {
	global $post;
	return $output . "<p><a class='more-link' href='". get_permalink() ."'>Read the Post <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
}

add_filter('the_excerpt', 'ct_excerpt_read_more_link');

// change the length of the excerpts
function ct_custom_excerpt_length( $length ) {
    return 18;
}
add_filter( 'excerpt_length', 'ct_custom_excerpt_length', 999 );

// switch [...] to ellipsis on automatic excerpt
function ct_new_excerpt_more( $more ) {
	return '&#8230;';
}
add_filter('excerpt_more', 'ct_new_excerpt_more');

// turns of the automatic scrolling to the read more link 
function ct_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}

add_filter( 'the_content_more_link', 'ct_remove_more_link_scroll' );

// Adds navigation through pages in the loop
function ct_post_navigation() {

    $arrows_left = ct_left_arrows_svg();
    $arrows_right = ct_right_arrows_svg();
    $args = array(
        'prev_text' => "$arrows_left <span>Previous</span>",
        'next_text' => "<span>Next</span> $arrows_right"
    );
    if ( current_theme_supports( 'loop-pagination' ) ) loop_pagination($args);
}

// displays the social icons in the .entry-author div
function ct_author_social_icons() {

	$social_sites = ct_create_social_array();
    
    foreach($social_sites as $key => $social_site) {
    	if(get_the_author_meta( $social_site)) {
    		if($key == 'flickr' || $key == 'dribbble' || $key == 'instagram') {
                echo "<a href='".esc_attr(get_the_author_meta( $social_site))."'><i class=\"fa fa-$key\"></i></a>";
			} else {
	    		echo "<a href='".esc_attr(get_the_author_meta( $social_site))."'><i class=\"fa fa-$key-square\"></i></a>";
	    	}
    	}
    }
}

// adds the client name from the project page
function ct_project_client_display() {
    
    global $post;
    $client = get_post_meta( $post->ID, 'ct-done-project-client-meta-box', true );
    $client_url = get_post_meta( $post->ID, 'ct-done-project-client-url-meta-box', true );

    if(!empty($client)){
        echo "<div class='entry-client'><span>Client</span><p><a href='".$client_url."'>$client</a></p></div>";
    }
}

// adds the date from the project page
function ct_project_date_display() {

    global $post;
    $date = get_post_meta( $post->ID, 'ct-done-project-date-meta-box', true );

    if(!empty($date)){
        echo "<div class='entry-date'><span>Date</span><p>$date</p></div>";
    }
}
function ct_project_category_display() {

    $categories = get_terms('done_project_category');
    $separator = ' & ';
    $output = '';
    if($categories){
        $output .= "<div class='entry-categories'><span>Category</span><p>";
        foreach($categories as $category) {
            $output .= '<a href="'.get_term_link($category->name, 'done_project_category').'">'.$category->name.'</a>'.$separator;
        }
        echo trim($output, $separator);
        echo "</p></div>";
    }
}

// for displaying featured images including mobile versions and default versions
function ct_featured_image() {
	
	global $post;
	$has_image = false;
			
	if (has_post_thumbnail( $post->ID ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
		$image = $image[0];
		$has_image = true;
	}  
	if ($has_image == true) {
        echo "<div class='featured-image' style=\"background-image: url('".$image."')\"></div>";
    }
}

// does it contain a featured image?
function ct_contains_featured() {

    global $post;
	
	if(has_post_thumbnail( $post->ID ) ) {
		echo " has-featured-image";
	} else {
		echo " no-featured-image";
	}
}

// puts site title & description in the title tag on front page
add_filter( 'wp_title', 'ct_add_homepage_title' );
function ct_add_homepage_title( $title )
{
    if( empty( $title ) && ( is_home() || is_front_page() ) ) {
        return __( get_bloginfo( 'title' ), 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
    }
    return $title;
}

// calls pages for menu if menu not set
function ct_wp_page_menu() {
    wp_page_menu(array("menu_class" => "menu-unset"));
}

function ct_custom_color_css() {

    $primary_color = get_theme_mod( 'ct_primary_color');
    $secondary_color = get_theme_mod( 'ct_secondary_color');

    /* if there is a custom colors section */
    if($primary_color || $secondary_color){

        /* if it is not the default color, add the inline styles */
        if($primary_color != "#e5e5e5") {
            /*
             * $primary_css = stuff;
             */
            /* wp_add_inline_style('style', $primary_css); */
        }
        /* if it is not the default color, add the inline styles */
        if($secondary_color != "#333333") {
            /*
             * $secondary_css = stuff;
             */
            /* wp_add_inline_style('style', $secondary_css); */
        }
    }
}
add_action('wp_enqueue_scripts','ct_custom_color_css');

function ct_custom_layout_css(){

    $layout = get_theme_mod('ct_layout_settings');

    /* if the sidebar is on the left then add the necessary inline styles */
    if($layout == 'left') {
        /*
         * $css = stuff;
         * wp_add_inline_style('style', $css);
         * */
    }
}
add_action('wp_enqueue_scripts','ct_custom_layout_css');

function ct_body_class( $classes ) {
    if ( ! is_front_page() ) {
        $classes[] = 'not-front';
    }
    return $classes;
}
add_filter( 'body_class', 'ct_body_class' );

function ct_left_arrows_svg() {

    $svg = '
    <svg class="arrows-left" width="12px" height="21px" viewBox="0 0 14 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
        <title>leftward 2</title>
        <description>Created with Sketch.</description>
        <defs></defs>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
            <g id="leftward-2" sketch:type="MSLayerGroup" transform="translate(1.000000, 1.000000)" stroke="#2B2B2B">
                <path class="arrow-1 arrow" d="M-0.296480302,11.8054608 L9.76716909,6.50022441 L19.4722962,11.8602605" id="left-2" sketch:type="MSShapeGroup" transform="translate(9.500000, 9.500000) rotate(-90.000000) translate(-9.500000, -9.500000) "></path>
                <path class="arrow-2 arrow" d="M-7.2964803,11.8054608 L2.76716909,6.50022441 L12.4722962,11.8602605" id="left-1" sketch:type="MSShapeGroup" transform="translate(2.500000, 9.500000) rotate(-90.000000) translate(-2.500000, -9.500000) "></path>
            </g>
        </g>
    </svg>';

    return $svg;
}

function ct_right_arrows_svg() {

    $svg = '
    <svg class="arrows-right" width="12px" height="21px" viewBox="0 0 14 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
        <title>leftward 2</title>
        <description>Created with Sketch.</description>
        <defs></defs>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
            <g id="leftward-2" sketch:type="MSLayerGroup" transform="translate(1.000000, 1.000000)" stroke="#2B2B2B">
                <path class="arrow-1 arrow" d="M-0.296480302,11.8054608 L9.76716909,6.50022441 L19.4722962,11.8602605" id="left-2" sketch:type="MSShapeGroup" transform="translate(9.500000, 9.500000) rotate(90.000000) translate(-9.500000, -9.500000) "></path>
                <path class="arrow-2 arrow" d="M-7.2964803,11.8054608 L2.76716909,6.50022441 L12.4722962,11.8602605" id="left-1" sketch:type="MSShapeGroup" transform="translate(2.500000, 9.500000) rotate(90.000000) translate(-2.500000, -9.500000) "></path>
            </g>
        </g>
    </svg>';

    return $svg;
}

function ct_downward_arrows_svg() {

    $svg = '
    <svg id="downward-arrows" class="downward-arrows"  width="14px" height="10px" viewBox="0 0 14 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <title>Downward Arrows</title>
    <description>two downward facing arrows</description>
    <defs></defs>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <g id="Mobile-Portrait" sketch:type="MSArtboardGroup" transform="translate(-255.000000, -327.000000)" stroke="#666666">
            <g id="filtering" sketch:type="MSLayerGroup" transform="translate(29.000000, 259.000000)">
                <g id="downward" transform="translate(232.500000, 73.000000) scale(-1, 1) rotate(-90.000000) translate(-232.500000, -73.000000) translate(228.500000, 66.500000)" sketch:type="MSShapeGroup">
                    <path class="arrow" d="M0,7.96932876 L7.12695049,5 L14,8" id="top" transform="translate(6.500000, 6.500000) rotate(-90.000000) translate(-6.500000, -6.500000) "></path>
                    <path class="arrow" d="M-5,7.96932876 L2.12695049,5 L9,8" id="bottom" transform="translate(1.500000, 6.500000) rotate(-90.000000) translate(-1.500000, -6.500000) "></path>
                </g>
            </g>
        </g>
    </g>
</svg>';

    return $svg;
}

function ct_default_contact_form() {

    /* uses Very Simple Contact Form by Guide van der Leest */
    echo do_shortcode('[contact]');
}

/* if "done" is active, hides from wordpress repo update checks in case a theme called "done" is added to the repo */
function ct_hidden_theme( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
        return $r; // Not a theme update request. Bail immediately.

    $themes = unserialize( $r['body']['themes'] );
    unset( $themes[ get_option( 'template' ) ] );
    unset( $themes[ get_option( 'stylesheet' ) ] );
    $r['body']['themes'] = serialize( $themes );
    return $r;
}

add_filter( 'http_request_args', 'ct_hidden_theme', 5, 2 );

?>