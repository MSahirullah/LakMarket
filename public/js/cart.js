$(document).ready(function () {

    $(document).on('click', '#homeRouteBtn', function () {
        window.location.href = "/";
    })

    $(document).on('keyup', '#qtyInput', function () {

        var parent = $(this).parent().parent().parent().parent();
        cVal = parseInt($(this).val());
        maxVal = parseInt($('#qtyInput').attr('dataMax'));
        if (cVal > maxVal) {
            $(this).val(maxVal);

            cVal = maxVal;
        }
        productQTYChange(cVal, $("#proName", parent).attr('href'));
    });

    $(document).on('click', '.increaser', function () {
        var parent = $(this).parent().parent().parent();
        var value = $('#qtyInput', parent).val();

        if (value) {
            maxval = $('#qtyInput', parent).attr('dataMax');
            value = parseInt(value);
            if (value < maxval) {
                value = value + 1;
                $('#qtyInput', parent).val(value);
                productQTYChange(value, $("#proName", parent).attr('href'));
            }
        }
    });

    $(document).on('click', '.dicreaser', function () {
        var parent = $(this).parent().parent().parent();
        var value = $('#qtyInput', parent).val();
        if (value) {
            value = parseInt(value);
            if (value > 1) {
                value = value - 1;
                $('#qtyInput', parent).val(value);
                productQTYChange(value, $("#proName", parent).attr('href'));
            }
        }
    });

    $(document).on('change', '.select-all-div input[type=checkbox]', function () {

        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $(document).on('change', '.select-product-store input[type=checkbox]', function () {
        var parent = $(this).parent().parent().parent();
        $("input[type=checkbox]", parent).prop('checked', $(this).prop('checked'));
    })

    $(document).on('change', '.select-product input[type=checkbox]', function () {
        var parent = $(this).parent().parent().parent();
        var count = $('#selectAllProductStore', parent).attr('data-p');
        var count2 = 0;

        $(".product-div", parent).find("input[type=checkbox]").each(function () {
            if ($(this).prop('checked') == true) {
                count2++;
            }
        });

        if (count == count2) {
            $("#selectAllProductStore", parent).prop('checked', $(this).prop('checked'));
        }
        else if ((count - 1) == count2) {
            $("#selectAllProductStore", parent).prop('checked', false);
        }
    })

    $(document).on('change', 'input[type=checkbox]', function () {
        selectProduct(checkCheckBox());
    });

    $(document).on('click', '#removeFromCart', function () {
        var parent = $(this).parent().parent().parent();
        url = $("#proName", parent).attr('href');

        if (url) {

            alertify.confirm('Remove From Cart', 'This product will be removed from your cart.',
                function () {
                    url = url.slice(9)
                    $.post("/cart/remove/product", {
                        "_token": post_token,
                        "url": url,
                    },
                        function (data) {
                            if (data['affected'] != 0) {
                                vanillaAlert(0, 'The product has been removed from your cart.');
                                getReadyAll(data['status'], data['item_count'], data['count'], data['total'], data['cart_list']);
                            }
                        });
                },
                function () { }).set('labels', { ok: 'REMOVE', cancel: 'CANCEL' });
        }

    });

    $(document).on('click', '#moveToWishlist', function () {
        var parent = $(this).parent().parent().parent();
        url = $("#proName", parent).attr('href');

        if (url) {
            alertify.confirm('Move To Wishlist', 'This product will be moved to wishlist and removed from your cart.',
                function () {
                    url = url.slice(9)
                    $.post("/cart/move/wishlist", {
                        "_token": post_token,
                        "url": url,
                    },
                        function (data) {
                            if (data['alert'] != 0) {
                                vanillaAlert(0, data['msg']);
                                getReadyAll(data['status'], data['item_count'], data['count'], data['total'], data['cart_list']);
                            }
                            else {
                                vanillaAlert(1, data['msg']);
                            }
                        });
                },
                function () { }).set('labels', { ok: 'MOVE', cancel: 'CANCEL' });
        }
    });

    $(document).on("click", '#btnCheckout', function () {
        var proURL = checkCheckBox();
        if (proURL.length) {
            $('#deliveryInfo').addClass('active');
            $('#productsCart').hide(500);
            $('#noProductsCart').hide(500);
        }
        else {
            vanillaAlert(1, 'No product selected.');
        }
    });


    $(document).on('click', '#removeAllProducts', function () {
        proURL = checkCheckBox();
        if (proURL.length != 0) {
            alertify.confirm('Remove From Cart', 'Are you sure you want to delete these product(s)?',
                function () {
                    $.post("/cart/remove/all", {
                        "_token": post_token,
                        "proURL": proURL,
                    },
                        function (data) {
                            if (data['affected'] != 0) {
                                vanillaAlert(0, 'The selected products have been removed from your cart.');
                                getReadyAll(data['status'], data['item_count'], data['count'], data['total'], data['cart_list']);
                            }
                        });
                },
                function () { }).set('labels', { ok: 'OK', cancel: 'CANCEL' });
        }
        else {
            vanillaAlert(1, 'No product selected.');
        }
    });

});

function productQTYChange(value, url) {
    url = url.slice(9);

    $.post("/cart/update", {
        "_token": post_token,
        "url": url,
        'value': value
    },
        function (data) {
            if (data) {
                selectProduct(checkCheckBox());
            }
        });
}

function checkCheckBox() {
    var products = [];
    $(".product-div").find("input[type=checkbox]").each(function () {
        if ($(this).prop('checked') == true && $(this).hasClass('product-check')) {

            parent = $(this).parent().parent();
            url = $("#proName", parent).attr('href');
            if (url) {
                url = url.slice(9)
                products.push(url);
            }
        }
    });
    return products;
}

function selectProduct(proURL) {
    $.post("/cart/total", {
        "_token": post_token,
        "proURL": proURL,
    },
        function (data) {
            if (data) {
                $('#totals').text(data['total']);
                $('#total').text(data['total']);
                $('#count').text(data['count']);
            }
        });
}