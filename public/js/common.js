$(document).ready(function () {
    var btn = $('#backToTopBtn');

    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '300');
    });

    $("input").on("click", function () {
        $(this).select();
    });
    $("input").focus(function () {
        $(this).select();
    });
    $("input").focusin(function () {
        $(this).select();
    });

});


function configOwl(item_2, item_3, time_1, time_2) {
    return ({
        loop: true,
        margin: 10,
        nav: false,
        autoplayTimeout: time_1,
        autoplay: true,
        autoplaySpeed: time_2,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,

            },
            600: {
                items: item_2,
            },
            900: {
                items: item_3,
            }
        }
    });
}

function checkDeliveryStatus(pid = '#paidDelivery', cid = '#cashOnDelivery') {
    data = '';

    if ($(pid).prop("checked") == true && $(cid).prop("checked") == true) {
        data = '3';
    }
    if (!$(pid).prop("checked") == true && !$(cid).prop("checked") == true) {
        data = '0';
    }
    else if ($(pid).prop("checked") == true && !$(cid).prop("checked") == true) {
        data = '1';
    }
    else if (!$(pid).prop("checked") == true && $(cid).prop("checked") == true) {
        data = '2';
    }

    return data;
}

function acceptOnlyNumber() {
    $(this).keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
};

function vanillaAlert(inp, msg, time = 6000) {

    var title = ['Success!', 'Error!', 'Warning!', 'Information!'];
    var type = ['success', 'error', 'warning', 'info'];
    var icon = ['success.png', 'error.png', 'warning.png', 'info.png']
    var path = '/img/alert-logo/';

    VanillaToasts.create({
        title: title[inp],
        text: msg,
        type: type[inp],
        icon: path + icon[inp],
        timeout: time
        // callback: function() { ... } // executed when toast is clicked / optional parameter
    });
}

function handleCart(url, color = '', qty = 1) {

    if (logged != '') {

        $.post("/shoppingCart/add",
            {
                _token: post_token,
                url: url,
                color: color,
                quantity: qty
            },
            function (data) {

                vanillaAlert(data[0], data[1]);
                checkCartStatus();

            });
    }
    else {
        window.location.href = "/login";
    }
}

function checkCartStatus() {

    if (logged != '') {
        $.post("/shoppingCart/status",
            {
                _token: post_token,
            },
            function (data) {

                $("#cartCount").text(data);

            });
    }
}