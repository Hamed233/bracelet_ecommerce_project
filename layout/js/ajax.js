/* Filter products */
$(document).ready(function() {

    filter_data();

    function filter_data() {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action_product = 'fetch_data';
        var catid = $('#catid').val();
        var status_product = get_filter('status_product');
        var country_made = get_filter('country_made');
        // var sort;

        // $(function() {
        //     if ($('input:radio[name="ordering"]').is(':checked')) {
        //         sort = $(this).val();
        //         console.log(sort);
        //     } else {
        //         console.log("Fail");
        //     }
        // });

        // // var sort = get_filter('sort');
        // if (document.getElementsByName('ordering').checked) {
        //     var sort = document.getElementsByName('ordering').value;
        //     console.log(sort);
        // } else {
        //     console.log("Fail");
        // }

        $.ajax({
            url: "includes/actions/fetch_product_data.php",
            method: "POST",
            data: {
                catid: catid,
                action_product: action_product,
                status_product: status_product,
                country_made: country_made
                    // sort: sort
            },
            success: function(data) {
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function() {
        filter_data();
    });

    $('#price_range').slider({
        range: true,
        min: 1000,
        max: 6500,
        values: [1000, 6500],
        step: 500,
        stop: function(event, ui) {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });

});

var count = 0;

$(function() {
    $('.clickableSymbol').click(function(e) {
        e.preventDefault();

        $click = $('.productSymbolArea');

        count = ($click.data("click_count") || 0) + 1;
        $click.data("click_count", count);
        if (count <= 14) {
            var img_info = $(this).data("img");
            var id = $(this).data("id");

            $.ajax({
                type: 'post',
                url: 'includes/actions/store_symols.php',
                data: {
                    item_img: img_info,
                    product_id: id
                },
                success: function(response) {
                    document.getElementById("model").innerHTML = response;
                }
            });

        } else {
            $('.cap_status').addClass('alert alert-danger').html("<i class=\"fas fa-times\"></i> You can Choose 14 Symbols just!").fadeIn('slow').delay(3000).fadeOut('slow');
            // $click.html("<div class='text-center'>You can Choose 14 Symbols just!</div>");
            $click.unbind("click");
        }

        // return true;

    });
});

function deleteShape() {
    var shap_id = $(".shape-content img").data("shapeid");
    var product_id = $(".shape-content").data("id");
    count = 0;
    $.ajax({
        type: "post",
        url: "includes/actions/store_symols.php",
        data: {
            p_id: product_id,
            shap_id: shap_id,
            action: "do"
        },
        success: function(response) {
            $(".shape-content").remove();
        }
    });

}

function checkRefresh() {
    if (typeof document.refreshForm !== 'undefined') {
        if (document.refreshForm.visited.value == "") {
            // This is a fresh page load
            document.refreshForm.visited.value = "1";
            var id = $('.clickableSymbol').data("id");
            $.ajax({
                type: 'post',
                url: 'includes/actions/store_symols.php',
                data: {
                    id_img: id
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }
    }
}

/* Start Add To Cart */

$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            total_cart_items: "totalitems"
        },
        success: function(response) {
            document.getElementById("cart-quantity").innerHTML = response;
        },
        error: function() {
            document.getElementById("cart-quantity").innerHTML = 0;
        }
    });
});

$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            total_love_items: "totalheart"
        },
        success: function(response) {
            document.getElementById("span_count").innerHTML = response;
        },
        error: function() {
            document.getElementById("span_count").innerHTML = 0;
        }
    });
});

function cart(id) {
    var elem = document.getElementById(id);
    var img = elem.getElementsByTagName("img")[0].src;
    // var img = $('#product_img').data("img");
    var description = $('.description_p').data("description");
    var productname = $('.part-one h1').data("productname");
    var price = $('.part-one h4').data("price");
    var color = $('img.catalogSwatchActive').data("color");
    var size = $('.size_bracelet option:selected').data("size");
    var kind = $('.part-three input').data("kind");
    var text_engraving = $('.text-engrave input').val();
    var position_eng = $('.text-engrave input').data("position");
    var quantity = document.getElementById(id + "_quantity").value;
    var discount = document.getElementById(id + "_discount").value;
    var product_id = $('.product-info').data("id");

    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            item_img: img,
            item_dec: description,
            item_name: productname,
            product_id: product_id,
            item_price: price,
            color_p: color,
            size: size,
            kind_p: kind,
            text_engraving: text_engraving,
            position_eng: position_eng,
            item_quantity: quantity,
            price_discount: discount,
            cart: "cart"
        },
        success: function(response) {
            document.getElementById("cart-quantity").innerHTML = response;
            $('.cap_status').addClass('alert alert-primary').html("Added to Cart <i class=\"fas fa-check-circle\"></i>").fadeIn('slow').delay(2000).fadeOut('slow');
            $('#myModal').css('display', 'block');
        }
    });

}

$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            mycart: "cart"
        },
        success: function(response) {
            if (document.getElementById("mecart") != null) {
                document.getElementById("mecart").innerHTML = response;
            }
        }
    });
});

function getNumbers(inputString) {
    var regex = /\d+\.\d+|\.\d+|\d+/g,
        results = [],
        n;

    while (n = regex.exec(inputString)) {
        results.push(parseFloat(n[0]));
    }

    return results;
}

function addLove(pid, cusid) {
    var productid = pid;
    var customer_id = cusid;
    var icon = $("#" + productid + "_love").data('icon');

    $.ajax({
        type: 'post',
        url: 'includes/actions/store_items.php',
        data: {
            "productid": productid,
            "user_id": customer_id,
            "icon": icon
        },
        success: function(result) {
            var strVal = result.includes("Deleted");
            if (strVal == true) {
                $('.cap_status').addClass('alert alert-danger').html("Deleted from Fav <i class=\"fas fa-check-circle\"></i>").fadeIn('slow').delay(2000).fadeOut('slow');
                $("#" + getNumbers(result) + "_love").removeClass("fas").addClass("far").attr('data-icon', 'far').css("color", "#000");
            } else {
                $('.cap_status').addClass('alert alert-primary').html("<i class=\"fas fa-check-circle\"></i> Added to Fav").fadeIn('slow').delay(2000).fadeOut('slow');
                $("#" + result + "_love").removeClass("far").addClass("fas").attr('data-icon', 'fas').css("color", "rgb(250, 106, 11)");
            }
        }
    });
}