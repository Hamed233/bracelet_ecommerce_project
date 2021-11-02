var browserWindow = $(window);

// :: 1.0 Preloader Active Code
browserWindow.on('load', function() {
    $('.preloader').fadeOut('slow', function() {
        $(this).remove();
    });
});

$('.h-center').click(function() {
    $('.center-inp').removeClass('none').slideDown(1000);
});

$('.filter-content').click(function() {
    $('#myModal').css('display', 'block');
});

$('.filter_ok').click(function() {
    $('#myModal').css('display', 'none');
});

$('#chooseCoordinateType').click(function() {
    $('#personalizeArea').toggleClass('d-none');
});

// Added to cart message
$('.btn-cart').click(function() {
    $(this).addClass("done");
    $(this).attr("disabled", true);
    $(this).html('added');
    $(this).data('clicked', true);
});

// switch between text & password
var passField = $('.password');

$('.show-pass, .show-pass-log').hover(function() {

    passField.attr('type', 'text');

}, function() {

    passField.attr('type', 'password');
});

// confirmation ( delete product )
$('.confirm').click(function() {
    return confirm('Are your sure to remove this product ?');
});


// =================================

/* [ Focus form ]*/
$('.input100').each(function() {
    $(this).on('blur', function() {
        if ($(this).val().trim() != "") {
            $(this).addClass('has-val');
        } else {
            $(this).removeClass('has-val');
        }
    })
})

// ----- Function To Make Link Active -----
$(document).ready(function() {
    $(".classynav li a").addClass("active");
});

$(document).ready(function() {
    $(".classynav li a").click(function() {
        $(".classynav li a").removeClass('active');
        $(this).addClass('active');
    })

    var loc = window.location.href;
    $(".classynav li a").removeClass('active');
    $(".classynav li a").each(function() {
        if (loc.indexOf($(this).attr("href")) != -1) {
            $(this).closest('.classynav li a').addClass("active");
        }
    });
});

// for alert success

$(document).ready(function() {
    $('.cap_status').fadeOut('slow', function() {
        $('.cap_status').delay(3000).fadeOut();
    });
});

/* validate password */

var myInput = document.getElementById("psw");
if (myInput != null) {
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
}