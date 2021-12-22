$(document).ready(function () {


    $(document).on('click', ' #btnCart', function () {
        var url = $("#productURLP").attr("url");
        var color = $('#colorSelector').val();
        var qty = $('#qtyInput').val();

        handleCart(url, color, qty);

    });

    $('.increaser').click(function () {
        var value = $('#qtyInput').val();
        if (value) {
            maxval = $('#qtyInput').attr('dataMax');
            value = parseInt(value);
            if (value < maxval) {
                value = value + 1;
                $('#qtyInput').val(value);
            }
        }
    });

    $('.dicreaser').click(function () {
        var value = $('#qtyInput').val();
        if (value) {
            value = parseInt(value);
            if (value > 1) {
                value = value - 1;
                $('#qtyInput').val(value);
            }
        }
    });


    if ($('#stock').attr('data-stock') == '0') {
        $('#btnCart').attr('disabled', 'disabled');
        $('#btnBuy').attr('disabled', 'disabled');

        $('#btnCart').addClass('add-to-cart-btn-color');
        $('#btnBuy').addClass('buy-now-color');
    }
    else {
        $('#btnCart').removeAttr('disabled');
        $('#btnBuy').removeAttr('disabled');

        $('#btnCart').removeClass('add-to-cart-btn-color');
        $('#btnBuy').removeClass('buy-now-color');
    }


    $('#qtyInput').keyup(function () {

        cVal = parseInt($(this).val());
        maxVal = parseInt($('#qtyInput').attr('dataMax'));
        if (cVal > maxVal) {
            $(this).val(maxVal);
        }
    });


    $('.product-details-div-4 .add-to-wishlist').mouseover(function () {
        $(this).html('<i class="fas fa-heart" aria-hidden="true"></i>').animate({

        }, 200, function () { });
    });

    $('.product-details-div-4 .add-to-wishlist').mouseout(function () {
        $(this).html('<i class="far fa-heart" aria-hidden="true"></i>');
    });

    $('.productD .wrapper-div .home-tile').mouseover(function () {
        $(this).attr('style', 'border:1px solid #fff;');

    })
    $('.productD .wrapper-div .home-tile').mouseout(function () {
        $(this).attr('style', 'border:1px solid #dcdcdc;');
    })


    var open = false;


    $('.reviews-members-footer .more-r-opt').click(function () {
        if (open) {
            $('.more-r-opt-div').hide();
        }
        open = false;
        cls = $(this).attr('data');
        $('.reviews-members-footer .' + cls).slideToggle("fast");

        open = true;
    });

    $('.reviews-members-footer .more-r-opt').on('click', function (event) {
        event.stopPropagation();
    });

    $('body').click(function () {
        if (open) {
            $('.more-r-opt-div').hide();
        }
    })

    $('.reviews-members .helpful-btn').click(function () {
        var id = $('#help-count1', this).attr('data-value');

        yx = this;

        $.post("/review/helpful", {
            "_token": post_token,
            "review_id": id
        },
            function (data) {
                if (data) {
                    changeHelpful(yx, data);
                }
            });
    });


    $('.owl-c-6').owlCarousel(configOwl(3, 5, 7000, 2200));


    $(document).on('mouseover', '.home-product', function () {
        $(".option-btn", this).show();
    })

    $(document).on('mouseout', '.home-product', function () {
        $(".option-btn", this).hide();
    })



});

function changeHelpful(tx, data) {
    $('#help-count1', tx).text(data);
    if ($(tx).hasClass('helpful-marked')) {
        $(tx).removeClass('helpful-marked');
    }
    else {
        $(tx).addClass('helpful-marked');
    }
}