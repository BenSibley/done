jQuery(document).ready(function($){

    $(".entry-content").fitVids();

    // bind the tap event (from 'tappy.min.js') on the menu icon
    $('#toggle-navigation').bind('tap', onTap);

    function onTap() {
        if ($('#site-header').hasClass('toggled')) {
            $('#site-header').removeClass('toggled')
            $('#menu-primary').css('height', 'auto');
            $(window).unbind('scroll');
        } else {
            var bodyHeight = $('body').height();
            $('#site-header').addClass('toggled')
            $('#menu-primary').css('height', bodyHeight);
            $(window).scroll(onScroll);
        }
    }
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

    /* portfolio page gallery functionality */

    /* add page-# to every 3 portfolio items */
    function galleryAssignClasses(liClass){

        $('#portfolio-items li').removeClass((function (index, css) {
            return (css.match (/\bpage-\S+/g) || []).join(' ');
        }));
        $('#portfolio-items li').removeClass((function (index, css) {
            return (css.match (/\bitem-\S+/g) || []).join(' ');
        }));

        if($(window).width() < 700){
            $('#portfolio-items li.' + liClass + ':lt(3)').addClass('page-1 visible');
            $('#portfolio-items li.' + liClass + ':lt(6):not(.page-1)').addClass('page-2');
            $('#portfolio-items li.' + liClass + ':lt(9):not(.page-1, .page-2)').addClass('page-3');
            $('#portfolio-items li.' + liClass + ':lt(12):not(.page-1, .page-2, .page-3)').addClass('page-4');
            $('#portfolio-items li.' + liClass + ':lt(15):not(.page-1, .page-2, .page-3, .page-4)').addClass('page-5');
            $('#portfolio-items li.' + liClass + ':lt(18):not(.page-1, .page-2, .page-3, .page-4, .page-5)').addClass('page-6');
        }
        if ($(window).width() > 699 ) {
            $('#portfolio-items li.' + liClass + ':lt(6)').addClass('page-1 visible');
            $('#portfolio-items li.' + liClass + ':lt(12):not(.page-1)').addClass('page-2');
            $('#portfolio-items li.' + liClass + ':lt(18):not(.page-1, .page-2)').addClass('page-3');
        }

        var i = 1;
        $('#portfolio-items li.' + liClass + '').each(function(){
            $(this).addClass('item-' + i + '');
            i++
        });
    }
    galleryAssignClasses('all');

    /* add the proper number of nav dots */
    function galleryPagination(liClass){

        /* remove any existing pagination nav dots (so the function is reusable) */
        $('#gallery-navigation').find('li').remove();
        var numProjects = $('#portfolio-items li.' + liClass +'').length;

        if($(window).width() < 700){
            numProjects = numProjects / 3;
            numProjects = Math.ceil(numProjects);
        }
        if ($(window).width() > 699 ) {
            numProjects = numProjects / 6;
            numProjects = Math.ceil(numProjects);
        }
        var i;
        for(i = 1; i <= numProjects; ++i){
            if(i == 1) {
                $( "#gallery-navigation").find('ul').append( "<li class='dot-" + i + " current'><button></button></li>" );
            } else {
                $( "#gallery-navigation").find('ul').append( "<li class='dot-" + i + "'><button></button></li>" );
            }
        }

        // bind the tap event (from 'tappy.min.js') on the gallery nav dots
        $('#gallery-navigation').find('li').bind('tap', galleryPaginationTouch);
    }
    galleryPagination('all');

    /* toggle the current class on the dot clicks and the visible class on the portfolio items */
    function galleryPaginationTouch(){

        /* get the height of the gallery before changing anything */
        var galleryHeight = $('#portfolio-items').css('height');

        if(!$(this).hasClass('current')) {
            $('#gallery-navigation').find('.current').removeClass('current');
            $(this).addClass('current');
            var count = $(this).index() + 1;
            $('.portfolio-item').removeClass('visible');
            $('.portfolio-item.page-' + count + '').addClass('visible');
        }

        /* make sure the gallery height doesn't shrink */
        $('#portfolio-items').css('min-height', galleryHeight);
    }

    /* open or close dropdown when label or item is 'tapped' */
    $('#dropdown-container').bind('tap', galleryFilterOpen);

    function galleryFilterOpen(){

        if($('#dropdown-container').hasClass('open')) {
            $('#dropdown-container').removeClass('open');
        } else {
            $('#dropdown-container').addClass('open');
        }
    }

    /* filter by class when category link 'tapped' */
    $('#dropdown-container a').bind('tap', galleryFilter);

    function galleryFilter(){

        /* get the height of the gallery before changing anything */
        var galleryHeight = $('#portfolio-items').css('height');

        $('#dropdown-container').find('.current').removeClass('current');
        $(this).addClass('current');

        /* remove 'visible' from portfolio items not in category */
        var category = $(this).text();

        $('.portfolio-item').removeClass('visible');

        galleryPagination(category);
        galleryAssignClasses(category);

        /* make sure the gallery height doesn't shrink */
        $('#portfolio-items').css('min-height', galleryHeight);
    }

    /* allow graceful resizing */
    $(window).resize(function(){
        galleryAssignClasses('all');
        galleryPagination('all');
        $('#portfolio-items').removeAttr('style');
    });
});