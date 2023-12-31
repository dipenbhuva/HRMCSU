/**
 * Added or define custom $ taks in this file
 *
 * @package CodeVibrant
 * @subpackage Enrollment
 *
 * Distributed under the MIT license - http://opensource.org/licenses/MIT
 */

jQuery(document).ready(function($) {
    "use strict";
    
    /**
     * Homepage slider
     */
    $('.homepage-slider').lightSlider({
        adaptiveHeight:true,
        item:1,
        slideMargin:0,
        loop:true,
        pager:false,
        auto:false,
        speed: 700,
        pause: 4200,
        onSliderLoad: function() {
            $('.homepage-slider').removeClass('cS-hidden');
        }
    });

    /**
     * Testimonials slider
     */
    $('.testimonialsSlider').lightSlider({
        adaptiveHeight:true,
        item: 2,
        slideMargin: 30,
        loop:true,
        enableDrag:false,
        controls:false,
        pager:true,
        auto:false,
        speed: 700,
        pause: 4200,
        responsive : [
            {
                breakpoint:840,
                settings: {
                    item:2,
                    slideMove:1,
                    slideMargin:6,
                  }
            },
            {
                breakpoint:600,
                settings: {
                    item:1,
                    slideMove:1,
                  }
            }
        ]
    });
    
    // Scroll To Top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1000) { 
            $('#cv-scrollup').fadeIn('slow');
        } else {
            $('#cv-scrollup').fadeOut('slow');
        }
    });

    $('#cv-scrollup').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    
    // toggle-menu
    $('.menu-toggle').click(function(event) {
        $('#primary-menu').slideToggle('slow');
    });
    
    //responsive sub menu toggle

    $('<a href="javascript:void(0);" class="sub-toggle"><i class="fa fa-angle-right"></i></a>').insertAfter('#site-navigation .menu-item-has-children>a, #site-navigation .page_item_has_children>a');
    
    /*$('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
    $('#site-navigation .page_item_has_children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');*/
    

    $('#site-navigation .menu-item-has-children .sub-toggle').click(function() {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });

    $('#site-navigation .page_item_has_children .sub-toggle').click(function() {
        $(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('1000');
        $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });
    
    //home page search
    $('.header-search-wrapper .search-main').click(function() {
        $('.header-search-wrapper .search-form-main').toggleClass('search-activate');
    });
});