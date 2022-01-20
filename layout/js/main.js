// ******************************************* //
// ********** Js ************* //
// ******************************************* //

// Toggle Search Categories
$(".link-control").click(function () {
    if($('.wrap-search-form .wrap-list-cate').length > 0){
        $(".list-cate").slideToggle();
    }
});

$('#agreeing').click(function() {
    if ($('#agreeing:checked').length > 0) {
        $('.nextStep_disabled').removeAttr('disabled');
    } else {
        $('.nextStep_disabled').attr('disabled', 'disabled');
    }
});

// ------------- quantity input ------------
$(document).ready(function() {

    var quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('.quantity_js').val());
        // If is not undefined
        $('.quantity_js').val(quantity + 1);
    });

    $('.quantity-left-minus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('.quantity_js').val());
        // If is not undefined
        // Increment
        if (quantity > 0) {
            $('.quantity_js').val(quantity - 1);
        }
    });
});


// ---- color bracelet ------
$(".catalogSwatchContainerMain").on('click', function(e) {
    e.preventDefault();
    $(this).parent().children('.catalogSwatchContainer').children('.catalogSwatch').removeClass('catalogSwatchActive');
    $(this).children('.catalogSwatch').addClass('catalogSwatchActive');
});
(function($) {
    'use strict';

    var browserWindow = $(window);
    var welcomeSlide = $('.welcome-slides');

    // :: 1.0 Preloader Active Code
    browserWindow.on('load', function() {
        $('.preloader').fadeOut('slow', function() {
            $(this).remove();
        });
    });

    // :: 2.0 Tooltip Active Code
    if ($.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    // :: 3.0 Nav Active Code
    if ($.fn.classyNav) {
        $('#famieNav').classyNav();
    }

    // :: 4.0 Sticky Active Code
    if ($.fn.sticky) {
        $(".famie-main-menu").sticky({
            topSpacing: 0
        });
    }

    // :: 5.0 Sliders Active Code
    if ($.fn.owlCarousel) {
        welcomeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });

        welcomeSlide.on('translate.owl.carousel', function() {
            var slideLayer = $("[data-animation]");
            slideLayer.each(function() {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        welcomeSlide.on('translated.owl.carousel', function() {
            var slideLayer = welcomeSlide.find('.owl-item.active').find("[data-animation]");
            slideLayer.each(function() {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });

        $("[data-delay]").each(function() {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function() {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        $('.testimonial-slides').owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            dots: false,
            nav: true,
            navText: ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'],
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
    }

    // :: 6.0 ScrollUp Active Code
    if ($.fn.scrollUp) {
        browserWindow.scrollUp({
            scrollSpeed: 1500,
            scrollText: '<i class="fas fa-arrow-up"></i>'
        });
    }

    // :: 7.0 Video Play Icons Active Code
    if ($.fn.magnificPopup) {
        $('.play-icon').magnificPopup({
            type: 'iframe'
        });
    }

    // :: 8.0 Jarallax Active Code
    if ($.fn.jarallax) {
        $('.jarallax').jarallax({
            speed: 0.2
        });
    }

    // :: 9.0 Prevent Default a Click
    $('a[href="#"]').on('click', function(e) {
        e.preventDefault();
    });

    // :: 10.0 Search Box Active Code
    $('#searchIcon').on('click', function() {
        $('.search-form').toggleClass('search-active');
    });
    $('.closeIcon').on('click', function() {
        $('.search-form').removeClass('search-active');
    });

})(jQuery);


/*global $, confirm*/
$(function() {

    "use strict";

    // Switch Between Login & Signup

    $('.login-page h1 span').click(function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);

    });


    /* =========================================================================== */

    // Hide PlaceHolder on focus

    $('[placeholder]').focus(function() {

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', ' ');
    }).blur(function() {

        $(this).attr('placeholder', $(this).attr('data-text'));
    });



    /* =========================================================================== */

    // Confirmation With Button special('Delet')

    $('.confirm').click(function() {

        return confirm('Are You Sure....??');

    });

    $('.live').keyup(function() {

        $($(this).data('class')).text($(this).val());
    });

});

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}




var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    if (typeof slides[slideIndex - 1] !== 'undefined') {
        slides[slideIndex - 1].style.display = "block";
    }
    setTimeout(showSlides, 10000); // Change image every 10 seconds
}

// ------------------ Tabs ----------------------
function openCity(evt, actionName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(actionName).style.display = "block";
    evt.currentTarget.className += " active";
}


// tab images gallary

function myFunction(imgs) {
    // Get the expanded image
    var expandImg = document.getElementById("expandedImg");
    // Get the image text
    var imgText = document.getElementById("imgtext");
    // Use the same src in the expanded image as the image being clicked on from the grid
    expandImg.src = imgs.src;
    // Use the value of the alt attribute of the clickable image as text inside the expanded image
    imgText.innerHTML = imgs.alt;
    // Show the container element (hidden with CSS)
    expandImg.parentElement.style.display = "block";
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
if (typeof span !== 'undefined') {
    span.onclick = function() {
        modal.style.display = "none";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}