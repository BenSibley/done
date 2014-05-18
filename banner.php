<?php
/**
 * Created by PhpStorm.
 * User: bensibley
 * Date: 5/15/14
 * Time: 12:46 PM
 */

$banner_display_options = compete_themes_get_option('banner_display_options');

// if no pages
if($banner_display_options == 'no-pages'){
    return;
}
// if not all pages
elseif($banner_display_options != 'all-pages'){

    // portfolio page only
    if($banner_display_options == 'portfolio'){

        // if not portfolio page, abort
        if(!is_page_template('page-portfolio.php')) {
            return;
        }
    }
    // otherwise check multicheck options
    elseif($banner_display_options == 'more-control'){

        // break if portfolio is an option and this is the portfolio page
        $multicheck_results = compete_themes_get_option('banner_display_multicheck');

        if($multicheck_results){

            $exit = true;

            foreach($multicheck_results as $multicheck_result){

                // if is portfolio page
                if($multicheck_result == 'portfolio'){

                    if(is_page_template('page-portfolio.php')){
                        $exit = false;
                        break;
                    }
                }
                // if is blog posts
                elseif($multicheck_result == 'posts'){

                    if(is_singular('post')){
                        $exit = false;
                        break;
                    }
                }
                // if is a project page
                elseif($multicheck_result == 'projects'){

                    if(is_singular('done_project')){
                        $exit = false;
                        break;
                    }
                }
                // if is a page (not template like portfolio)
                elseif($multicheck_result == 'pages'){

                    if(is_page() && !is_page_template()){
                        $exit = false;
                        break;
                    }
                }
                // if is blog
                elseif($multicheck_result == 'home'){

                    if(is_home()){
                        $exit = false;
                        break;
                    }
                }
                // if is an archive page
                elseif($multicheck_result == 'archives'){

                    if(is_archive()){
                        $exit = false;
                        break;
                    }
                }
            }
            // if current page doesn't match any multicheck options
            if ($exit){
                return;
            }
        /* if NONE matched, return */
        } else {
            return;
        }
    }
}

// Apply color theme chosen by user

if(compete_themes_get_option('banner_theme') == 'dark'){
    $banner_theme = 'dark-theme';
} else {
    $banner_theme = 'light-theme';
}
?>


<div id="contact-banner" class="contact-banner <?php echo $banner_theme ?>" style="background-image: url('<?php echo compete_themes_get_option('banner_background_image'); ?>');">
    <div class="top">
        <h3><?php echo compete_themes_get_option('banner_heading'); ?></h3>
        <a href="#banner-content" id="contact-open-button" class="contact-open-button"><?php echo compete_themes_get_option('banner_button_text'); ?></a>
    </div>
    <div id="banner-content" class="banner-content">
        <?php
        if(compete_themes_get_option('banner_main_image') == 'yes') {
            echo get_avatar(get_bloginfo('admin_email'), 120);
        } else {
            echo "<img src='" . compete_themes_get_option('banner_main_image_upload') . "' />";
        }
        ?>
        <h2><?php echo compete_themes_get_option('banner_content_heading'); ?></h2>
        <p><?php echo compete_themes_get_option('banner_main_content'); ?></p>
        <?php
        if(compete_themes_get_option('banner_author_radio') == 'yes') {
            echo "<span>-". get_bloginfo('title') . "</span>";
        } else {
            echo "<span>-". compete_themes_get_option('banner_author') . "</span>";
        }
        ?>
        <a class="arrow-link" href="#contact-form">
            <?php echo compete_themes_downward_arrows_svg(); ?>
        </a>
        <div id="contact-form" class="contact-form">
            <?php
            if(compete_themes_get_option('banner_contact_form_radio') == 'sbcf'){
                if (function_exists('simple_contact_form')) simple_contact_form();
            } else {
                echo do_shortcode(stripslashes(compete_themes_get_option("banner_contact_form_shortcode")));
            }
            ?>
        </div>
        <a href="#" id="contact-close-button" class="contact-close-button">close banner</a>
    </div>
</div>