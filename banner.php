<?php
/**
 * Created by PhpStorm.
 * User: bensibley
 * Date: 5/15/14
 * Time: 12:46 PM
 */

?>

<div id="contact-banner" class="contact-banner" style="background-image: url('<?php echo ct_get_option('banner_background_image'); ?>');">
    <div class="top">
        <h3><?php echo ct_get_option('banner_heading'); ?></h3>
        <a href="#banner-content" id="contact-open-button" class="contact-open-button"><?php echo ct_get_option('banner_button_text'); ?></a>
    </div>
    <div id="banner-content" class="banner-content">
        <?php
        if(ct_get_option('banner_main_image') == 'yes') {
            echo get_avatar(get_bloginfo('admin_email'), 120);
        } else {
            echo "<img src='" . ct_get_option('banner_main_image_upload') . "' />";
        }
        ?>
        <h2><?php echo ct_get_option('banner_content_heading'); ?></h2>
        <p><?php echo ct_get_option('banner_main_content'); ?></p>
        <?php
        if(ct_get_option('banner_author_radio') == 'yes') {
            echo "<span>-". get_bloginfo('title') . "</span>";
        } else {
            echo "<span>-". ct_get_option('banner_author') . "</span>";
        }
        ?>
        <a class="arrow-link" href="#contact-form">
            <?php echo ct_downward_arrows_svg(); ?>
        </a>
        <div id="contact-form" class="contact-form">
            <?php
            if(ct_get_option('banner_contact_form_radio') == 'sbcf'){
                if (function_exists('simple_contact_form')) simple_contact_form();
            } else {
                echo do_shortcode(stripslashes(ct_get_option("banner_contact_form_shortcode")));
            }
            ?>
        </div>
        <a href="#" id="contact-close-button" class="contact-close-button">close banner</a>
    </div>
</div>