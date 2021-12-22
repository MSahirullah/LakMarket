$(document).ready(function () {

    $(document).on('click', '#homeRouteBtn', function () {
        window.location.href = "/";
    })

    $(document).on('keypress', function (e) {
        if (e.which == 13 && $("#addEditAddressModal").hasClass('show')) {
            e.preventDefault();
            var btn = $(".btn-modal-submit").attr("id");

            if (btn == "newSubmit") {
                $('#newSubmit').trigger('click');
            }
            else if (btn == "editSubmit") {
                $('#editSubmit').trigger('click');
            }
        }
    });

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

    $(document).on('click', '#addNewAddress', function () {
        $('#modalTitle').text('Add New Address');
        $('#cityC').attr('disabled', 'disabled');
        $('.btn-modal-submit').attr('id', 'newSubmit');
        $('#fullNameC').val("");
        $('#phoneC').val("");
        $('#addressC').val("");
        $('#districtC').val("");
        $('#cityC').val("");
        $('#cityC').selectpicker('refresh');
        $('#districtC').selectpicker('refresh');
        $('#labelC').val("");
        $('#addEditAddressModal').modal('show')
    });

    $(document).on('change', '#districtC', function () {
        var district = $(this).val();
        getCitiesByDistrict(district);
    });

    $(document).on('click', '#deleteAddress', function () {

        var id = $(this).parent().attr('data');

        if (id != '') {
            alertify.confirm('Remove Shipping Address', 'Are you sure you want to delete this address?',
                function () {
                    $.post("/customer/account/shipping-address/remove", {
                        "_token": post_token,
                        "id": id,
                    },
                        function (data) {
                            vanillaAlert(data[0], data[1]);
                            deliveryInfo(1);
                            $('#addressInCartSummery').empty();
                        });
                },
                function () { }).set('labels', { ok: 'REMOVE', cancel: 'CANCEL' });
        }
    });

    $(document).on('click', '#editAddress', function () {
        $('#modalTitle').text('Edit Address');
        $('#cityC').removeAttr('disabled');
        $('.btn-modal-submit').attr('id', 'editSubmit');
        $('.btn-modal-submit').attr('data', $(this).parent().attr('data'));

        var parent = $(this).parent().parent();

        getCitiesByDistrict($('#addressDistrict', parent).attr('data'));
        $('#fullNameC').val($('#addressName', parent).text());
        $('#phoneC').val($('#addressPhone', parent).text());
        $('#addressC').val($('#addressAdd', parent).text());
        $('#districtC').selectpicker('val', $('#addressDistrict', parent).attr('data'));

        setTimeout(() => {
            $('#cityC').selectpicker('val', $('#addressCity', parent).attr('data'));
        }, 500);
        $('#labelC').val($('#addressLabel', parent).text());

        $('#addEditAddressModal').modal('show');
    });

    $(document).on('click', '#editSubmit', function () {
        var full_name = $('#fullNameC').val();
        var phone = $('#phoneC').val();
        var address = $('#addressC').val();
        var district = $('#districtC').val();
        var city = $('#cityC').val();
        var label = $('#labelC').val();
        var id = $(this).attr('data');

        if (full_name == '' || phone == '' || address == '' || district == '' || city == '' || label == '') {
            $('#btnSubmitC').trigger('click');
        }
        else {
            $.post("/customer/account/shipping-address/edit", {
                "_token": post_token,
                "full_name": full_name,
                'phone': phone,
                'address': address,
                'district': district,
                'city': city,
                'label': label,
                'id': id,
            },
                function (data) {
                    if (data) {
                        vanillaAlert(data[0], data[1]);
                        deliveryInfo(1);
                        if (data[0] == '0') {
                            $('#addEditAddressModal').modal('hide');
                            $('#addressInCartSummery').empty();
                        }
                    }
                });
        }
    });

    $(document).on('click', '#newSubmit', function () {

        var full_name = $('#fullNameC').val();
        var phone = $('#phoneC').val();
        var address = $('#addressC').val();
        var district = $('#districtC').val();
        var city = $('#cityC').val();
        var label = $('#labelC').val();

        if (full_name == '' || phone == '' || address == '' || district == '' || city == '' || label == '') {
            $('#btnSubmitC').trigger('click');
        }
        else {
            $.post("/customer/account/shipping-address/add", {
                "_token": post_token,
                "full_name": full_name,
                'phone': phone,
                'address': address,
                'district': district,
                'city': city,
                'label': label,
            },
                function (data) {
                    if (data) {
                        vanillaAlert(data[0], data[1]);
                        deliveryInfo(1);

                        if (data[0] == '0') {
                            $('#addEditAddressModal').modal('hide');
                            $('#addressInCartSummery').empty();
                        }
                    }
                });
        }
    });

    $(document).on('change', '.select-all-div input[type=checkbox]', function () {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        selectAllFuncion(checkCheckBox());
        localStorage.setItem("proURLCart", checkCheckBox().toString());
    });

    $(document).on('change', '.select-product-store input[type=checkbox]', function () {
        var parent = $(this).parent().parent().parent();
        $("input[type=checkbox]", parent).prop('checked', $(this).prop('checked'));
        selectAllFuncion(checkCheckBox());
        localStorage.setItem("proURLCart", checkCheckBox().toString());
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
        selectAllFuncion(checkCheckBox());
        localStorage.setItem("proURLCart", checkCheckBox().toString());
    })

    $(document).on('change', 'input[type=checkbox]', function () {
        selectProduct(checkCheckBox());
        selectAllFuncion(checkCheckBox());
        localStorage.setItem("proURLCart", checkCheckBox().toString());
    });

    $(document).on('click', '#shippingAddress', function () {
        $('#btnSecureCheckout').removeAttr('disabled');
        $('#btnSecureCheckout').removeClass('disabled-button');
        var full_name = $('#addressName', this).text();
        var address = $('#addressAdd', this).text();
        var postal_code = $('#addressPostalCode', this).text();
        var city = $('#addressCity', this).text();
        var district = $('#addressDistrict', this).text();
        var cityID = $('#addressCity', this).attr('data');
        var districtID = $('#addressDistrict', this).attr('data');
        var province = $('#addressProvince', this).text();
        var phone = $('#addressPhone', this).text();

        inHTML = '<hr class="inner-div2"><div class="row mt-4 mb-4"><div class="col-md-1"><i class="fas fa-map-marker-alt"></i></div><div class="col-md-10" id="addressSubmit"><span class="name font-weight-bold" id="full_nameA">' + full_name + '</span></br><span class="address"><span id="addressA">' + address + '</span> </br> <span id="postal_codeA">' + postal_code + ' </span></br><span id="cityA" data=' + cityID + '> ' + city + '</span>, <span id="districtA" data=' + districtID + '>' + district + '</span>, <span id="provinceA">' + province + ' </span></br> Phone: +94<span id="phoneA">' + phone + '</span></span></div></div>';

        $('.selected-card').removeClass('selected-card');
        $(this).parent().hasClass('selected-card') ? '' : $(this).parent().addClass('selected-card');

        $('#addressInCartSummery').empty();
        $('#addressInCartSummery').append(inHTML);
        $('#addressInCartSummery').show('fast');

    });

    $(document).on('click', '#removeFromCart', function () {
        var parent = $(this).parent().parent().parent();
        url = $("#proName", parent).attr('href');

        if (url) {

            alertify.confirm('Remove From Cart', 'This product will be removed from your cart.',
                function () {
                    url = url.slice(9)
                    $.post("/shoppingCart/remove/product", {
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
                    $.post("/shoppingCart/move/wishlist", {
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
            $('#productsCart').hide();
            $('#noProductsCart').hide();
            $('#deliveryInfoContent').show();
            localStorage.setItem("viewCart", "1");
            localStorage.setItem("proURLCart", proURL.toString());

        }
        else {
            vanillaAlert(1, 'No product selected.');
        }
    });

    $(document).on("click", '#btnShoppingCart', function () {

        var proURL = checkCheckBox();
        $('#deliveryInfo').removeClass('active');
        $('#deliveryInfoContent').hide();
        $('#productsCart').show();
        $('#noProductsCart').show();
        localStorage.setItem("viewCart", "0");
        localStorage.setItem("proURLCart", proURL.toString());

    });

    $(document).on('click', '#removeAllProducts', function () {
        proURL = checkCheckBox();
        if (proURL.length != 0) {
            alertify.confirm('Remove From Cart', 'Are you sure you want to delete these product(s)?',
                function () {
                    $.post("/shoppingCart/remove/all", {
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

    $.post("/shoppingCart/update", {
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

function selectAllFuncion(proURL) {
    if ($("#cartAllProducts").text() == proURL.length) {
        $("#selectAll").prop('checked', true);
    }
    else {
        $("#selectAll").prop('checked', false);
    }
}

function makeCheckBox(proURL) {

    var status = false;
    $.each(proURL, function (key, value) {
        $(".product-div").find("input[type=checkbox]").each(function () {
            parent = $(this).parent().parent();
            url = $("#proName", parent).attr('href');
            if (url) {
                url = url.slice(9);

                if (url == value && $(this).hasClass('product-check')) {
                    $(this).prop('checked', true);
                    status = true;
                }
            }
        });
    });

    if (status) {
        if ($("#cartAllProducts").text() == proURL.length) {
            $("#selectAll").prop('checked', true);
            $(".cart-layout-inner").find("input[type=checkbox]").each(function () {
                if ($(this).attr('id') == "selectAllProductStore") {
                    $(this).prop('checked', true);
                }
            })
        }
        else {
            $(".cart-layout-inner").find(".store-div").each(function () {

                var checkStatus = true;

                $(this).find("input[type=checkbox]").each(function () {

                    if ($(this).attr('id') == "selectProduct") {
                        if (!$(this).prop('checked')) {
                            checkStatus = false;
                        }
                    }
                });

                if (checkStatus) {
                    $(this).find("input[type=checkbox]").each(function () {
                        if ($(this).attr('id') == "selectAllProductStore") {
                            $(this).prop('checked', true);
                        }
                    });
                }
            });
        }
    }
}

function selectProduct(proURL) {

    $.post("/shoppingCart/total", {
        "_token": post_token,
        "proURL": proURL,
    },
        function (data) {
            if (data) {
                $('#totalAmounts').text(data['total']);
                $('#totalAmount').text(data['total']);
                $('#totalCount').text(data['count']);
                $('#totals').text(data['total']);
                $('#total').text(data['total']);
                $('#count').text(data['count']);
            }
        });
}

function getCitiesByDistrict(dis_id) {
    $.post("/register-cities", {
        "_token": post_token,
        "dis_id": dis_id,
    },
        function (data) {

            if (data.length) {
                inHTML = '';
                $.each(data, function (key, value) {
                    inHTML += '<option value="' + value.id + '">' + value.name_en + ' - ' + value.postal_code + '</option>';
                });
                $('#cityC').empty();
                $('#cityC').removeAttr('disabled');
                $('#cityC').append(inHTML);
                $('#cityC').selectpicker('refresh');
            }
        });
}

