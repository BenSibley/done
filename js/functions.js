jQuery(document).ready(function($){

    // enable fitvids on posts
    $(".entry-content").fitVids();

    // bind the tap event (from 'tappy.min.js') on the menu icon
    $('#toggle-navigation').bind('tap', onTap);

    // open and close menu & apply keyboard accessibility
    function onTap() {
        if ($('#site-header').hasClass('toggled')) {
            $('#site-header').removeClass('toggled')
            $('#menu-primary').css('height', 'auto');
            $(window).unbind('scroll');
            $('#menu-primary').find('a, input').attr('tabindex', -1);
        } else {
            var bodyHeight = $('body').height();
            $('#site-header').addClass('toggled')
            $('#menu-primary').css('height', bodyHeight);
            $(window).scroll(onScroll);
            $('#menu-primary').find('a, input').attr('tabindex', 0);
        }
    }
    /* at mobile width, don't include nav items in tabindex unless menu opened */
    if($(window).width() < 900){
        $('#menu-primary').find('a, input').attr('tabindex', -1);
    }

    // close menu if scrolled past all menu items
    function onScroll() {
        var menuItemsBottom = $('#menu-primary > ul').offset().top + $('#menu-primary > ul').height();

        // keep updating var on scroll
        var topDistance = $(window).scrollTop();
        if (topDistance > menuItemsBottom) {
            $(window).unbind('scroll');
            onTap();
        }
    }

    /*  allow dropdown menu items to be visible/accessed with keyboard */
    $('#menu-primary a').focus(function(){
        $(this).parents('ul').addClass('focused');
    });
    $('#menu-primary a').focusout(function(){
        $(this).parents('ul').removeClass('focused');
    });

    /*  allow search input in menu to be visible/accessed with keyboard */
    $('#site-header').find('.search-field').focus(function(){
        $('#submit-proxy-checkbox').prop('checked', true);
    });
    $('#site-header').find('.search-field').focusout(function(){
        $('#submit-proxy-checkbox').prop('checked', false);
    });
    /* close search input in header when .dark-overlay is clicked */
    $('.dark-overlay').click(function() {
        if($('#submit-proxy-checkbox').is(':checked')){
            $('#submit-proxy-checkbox').prop('checked', false);
        }
    });
    /* enable i to be clicked to get around IE9 z-index issue */
    $('#site-header').find('.fa-search').click(function(){
        if($('#submit-proxy-checkbox').is(':not(:checked)')){
            $('#submit-proxy-checkbox').prop('checked', true);
        }
    });

    /* portfolio page gallery functionality */

    /* add page-# classes used to determine visibility and keyboard accessibility */
    function galleryAssignClasses(liClass){

        // remove all existing page-# classes
        $('#portfolio-items li').removeClass((function (index, css) {
            return (css.match (/\bpage-\S+/g) || []).join(' ');
        }));
        // remove all existing item-# classes
        $('#portfolio-items li').removeClass((function (index, css) {
            return (css.match (/\bitem-\S+/g) || []).join(' ');
        }));
        // remove all portfolio items from keyboard access
        $('#portfolio-items li a').attr('tabindex', -1);

        // pages of three at mobile widths
        if($(window).width() < 700){
            $('#portfolio-items li.' + liClass + ':lt(3)').addClass('page-1 visible');
            $('#portfolio-items li.' + liClass + ':lt(3) a').attr('tabindex', 0);
            $('#portfolio-items li.' + liClass + ':lt(6):not(.page-1)').addClass('page-2');
            $('#portfolio-items li.' + liClass + ':lt(9):not(.page-1, .page-2)').addClass('page-3');
            $('#portfolio-items li.' + liClass + ':lt(12):not(.page-1, .page-2, .page-3)').addClass('page-4');
            $('#portfolio-items li.' + liClass + ':lt(15):not(.page-1, .page-2, .page-3, .page-4)').addClass('page-5');
            $('#portfolio-items li.' + liClass + ':lt(18):not(.page-1, .page-2, .page-3, .page-4, .page-5)').addClass('page-6');
        }
        // pages of six at larger widths
        if ($(window).width() > 699 ) {
            $('#portfolio-items li.' + liClass + ':lt(6)').addClass('page-1 visible');
            $('#portfolio-items li.' + liClass + ':lt(6) a').attr('tabindex', 0);
            $('#portfolio-items li.' + liClass + ':lt(12):not(.page-1)').addClass('page-2');
            $('#portfolio-items li.' + liClass + ':lt(18):not(.page-1, .page-2)').addClass('page-3');
        }

        // apply item-# classes to all portfolio items in visible category
        var i = 1;
        $('#portfolio-items li.' + liClass + '').each(function(){
            $(this).addClass('item-' + i + '');
            i++
        });
    }
    galleryAssignClasses('all');

    /* create the pagination nav dots */
    function galleryPagination(liClass){

        /* remove any existing pagination nav dots (so the function is reusable) */
        $('#gallery-navigation').find('li').remove();
        var numProjects = $('#portfolio-items li.' + liClass +'').length;

        // 3 results per page/dot at mobile widths
        if($(window).width() < 700){
            numProjects = numProjects / 3;
            numProjects = Math.ceil(numProjects);
        }
        // 6 results per page/dot at larger widths
        if ($(window).width() > 699 ) {
            numProjects = numProjects / 6;
            numProjects = Math.ceil(numProjects);
        }
        // create the navigation and add current to first li
        var i;
        for(i = 1; i <= numProjects; ++i){
            if(i == 1) {
                $( "#gallery-navigation").find('ul').append( "<li class='dot-" + i + " current'><button></button></li>" );
            } else {
                $( "#gallery-navigation").find('ul').append( "<li class='dot-" + i + "'><button></button></li>" );
            }
        }

        // bind the tap event to change pages
        $('#gallery-navigation').find('li').bind('tap', galleryPaginationTouch);
    }
    galleryPagination('all');

    /* get the height of the gallery before changing anything */
    function gallerySetHeight(){
        var galleryHeight = $('#portfolio-items').css('height');
        /* make sure the gallery height doesn't shrink */
        $('#portfolio-items').css('min-height', galleryHeight);
    }
    gallerySetHeight();


    /* toggle the current class on the dot clicks and the visible class on the portfolio items */
    function galleryPaginationTouch(){

        /* get the height of the gallery before changing anything */
        var galleryHeight = $('#portfolio-items').css('height');

        // pagination
        if(!$(this).hasClass('current')) {
            // reapply the current class
            $('#gallery-navigation').find('.current').removeClass('current');
            $(this).addClass('current');
            // move visibility and keyboard accessibility over one page
            var count = $(this).index() + 1;
            $('.portfolio-item').removeClass('visible');
            $('.portfolio-item a').attr('tabindex', -1);
            $('.portfolio-item.page-' + count + '').addClass('visible');
            $('.portfolio-item.page-' + count + ' a').attr('tabindex', 0);
        }

        /* make sure the gallery height doesn't shrink */
        $('#portfolio-items').css('min-height', galleryHeight);
    }

    /* open or close dropdown when label or item is 'tapped' */
    $('#dropdown-container').bind('tap', galleryFilterOpen);

    // add/remove open class on the filtering drop down used on mobile
    function galleryFilterOpen(){

        if($('#dropdown-container').hasClass('open')) {
            $('#dropdown-container').removeClass('open');
            $('#dropdown-container').find('.dropdown a').attr('tabindex', -1);
        } else {
            $('#dropdown-container').addClass('open');
            $('#dropdown-container').find('.dropdown a').attr('tabindex', 0);
        }
    }
    /* take dropdown filter options out of keyboard flow if dropdown is closed */
    if($(window).width() < 1100){
        $('#dropdown-container').find('.dropdown a').attr('tabindex', -1);
    }

    /* filter by class when category link 'tapped' */
    $('#dropdown-container').find('.dropdown a').bind('tap', galleryFilter);

    function galleryFilter(){

        // change current class to the new filter option
        $('#dropdown-container').find('.current').removeClass('current');
        $(this).addClass('current');

        /* remove 'visible' from portfolio items not in category */
        var category = $(this).text();
        $('.portfolio-item').removeClass('visible');

        // run the functions to apply the new page-# and item-# classes and re-paginate
        galleryPagination(category);
        galleryAssignClasses(category);
    }

    /* allow graceful resizing */
    $(window).resize(function(){
        galleryAssignClasses('all');
        galleryPagination('all');
        $('#portfolio-items').removeAttr('style');
    });

    /* contact form float pattern */
    function contactFormFloatPattern(){

        var contactFormInputs = $('#simple-contact-form').find('input, textarea');
        // add class to label on keypress in input/textarea
        contactFormInputs.keypress(function(){
            $(this).parent().find('label').addClass('active');
        });
        // remove class on label on leaving focus of input/textarea if empty
        $('input, textarea').blur(function(){
            if (! this.value) {
                $(this).parent().find('label').removeClass('active');
            }
        });
    }
    contactFormFloatPattern();

    /* open contact banner when button is 'tapped' */
    $('#contact-open-button, #contact-close-button').bind('tap', openContactBanner);

    function openContactBanner(){

        // set variables
        var bannerContent = $('#banner-content');
        var contactBanner = $('#contact-banner');
        var totalHeight = 0;

        // get height of combined children
        $(bannerContent).children().each(function(){
            totalHeight = totalHeight + $(this).outerHeight();
        });

        // change bannerContent height to combined size of children or 0
        if(!contactBanner.hasClass('open')) {
            contactBanner.addClass('open');
            bannerContent.css('height', totalHeight);
            // smooth scroll to top of banner-content
            $('html,body').animate({
                scrollTop: bannerContent.offset().top
            }, 500);
            // make links and inputs keyboard accessible when banner is open
            $(contactBanner).find('input:not(:hidden), a:not("#contact-open-button"), textarea').each(function() {
                $(this).attr('tabindex', 0);
            });
            return false;
        } else {
            contactBanner.removeClass('open');
            bannerContent.css('height', 0);
            // smooth scroll to top of page
            $('html,body').animate({
                scrollTop: $('#main').offset().top
            }, 500);
            // make links and inputs keyboard inaccessible when banner is not open
            $(contactBanner).find('input:not(:hidden), a:not("#contact-open-button"), textarea').each(function() {
                $(this).attr('tabindex', -1);
            });
            return false;
        }
    }
    /* contact banner accessibility - remove keyboard accessibility of banner when closed */
    $('#contact-banner').find('input:not(:hidden), a:not("#contact-open-button"), textarea').each(function() {
        $(this).attr('tabindex', -1);
    });

    /* enable hover effects on portfolio items when focused on (keyboard accessibility) */
    $('.image-link, .title-link').focus(function(){
        $(this).parents('li').addClass('focused');
    });
    // and remove the effects
    $('.image-link, .title-link').focusout(function(){
        $(this).parents('li').removeClass('focused');
    });
});

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);