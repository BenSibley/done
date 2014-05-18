jQuery(document).ready(function($){


    /* hide all additional options */
    if($('#banner_main_image1').is(':checked')){
        $('.cmb_id_banner_main_image_upload').hide();
    }
    if($('#banner_author_radio1').is(':checked')){
        $('.cmb_id_banner_author').hide();
    }
    if($('#banner_contact_form_radio1').is(':checked')){
        $('.cmb_id_banner_contact_form_shortcode').hide();
    }
    if(!$('#banner_display_options4').is(':checked')){
        $('.cmb_id_banner_display_multicheck').hide();
    }

    // bind the click events
    $('.cmb_id_banner_main_image').bind('click', showHiddenFields);
    $('.cmb_id_banner_author_radio').bind('click', showHiddenFields);
    $('.cmb_id_banner_contact_form_radio').bind('click', showHiddenFields);
    $('.cmb_id_banner_display_options').bind('click', showHiddenFields);

    function showHiddenFields(){

        if($('#banner_main_image2').is(':checked')){
            $('.cmb_id_banner_main_image_upload').show();
        } else {
            $('.cmb_id_banner_main_image_upload').hide();
        }
        if($('#banner_author_radio2').is(':checked')){
            $('.cmb_id_banner_author').show();
        } else {
            $('.cmb_id_banner_author').hide();
        }
        if($('#banner_contact_form_radio2').is(':checked')){
            $('.cmb_id_banner_contact_form_shortcode').show();
        } else {
            $('.cmb_id_banner_contact_form_shortcode').hide();
        }
        if($('#banner_display_options4').is(':checked')){
            $('.cmb_id_banner_display_multicheck').show();
        } else {
            $('.cmb_id_banner_display_multicheck').hide();
        }
    }



});