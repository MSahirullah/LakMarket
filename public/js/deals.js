$(document).ready(function () {

    $(document).on('mouseover', '.search-product', function () {
        $(".option-btn", this).show();
    })

    $(document).on('mouseout', '.search-product', function () {
        $(".option-btn", this).hide();
    })

    $('li').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    $('#product-menu').hide();

    var view = 'list';

    $('.list-view-btn').on('click', function () {
        showListView();
        localStorage.setItem("dealsPageView", 'list');

    });

    $('.tile-view-btn').on('click', function () {

        if (!$('.tile-view-btn i').hasClass('view-button-selected')) {
            $('.search-tile-product-div').show();
            $('#product-menu').hide();
            $('.list-view-btn i').removeClass('view-button-selected');
            $('.tile-view-btn i').addClass('view-button-selected');
            view = 'tile';
            localStorage.setItem("dealsPageView", 'tile');
        }
    });

    $('.delivery-check input[type="checkbox"]').change(function () {
        filterPOST(view)
    });

    $('#rangeBtn').click(function () {

        var price = 0.00;
        var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
        var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

        if (isNaN(priceMin))
            priceMin = 0.0;
        if (isNaN(priceMax))
            priceMax = 1000000.0;

        if (priceMin => 0 && priceMax > 0) {

            if ((!(priceMin >= 0 && priceMin <= 1000000)) || (!(priceMax >= 0 && priceMax <= 1000000))) {
                vanillaAlert(2, 'Price Range must be between Rs. 0.00 and Rs. 1000000.');
                return false;
            }
            if (priceMin > priceMax) {
                vanillaAlert(2, 'Please enter the price range correctly.');
                return false;
            }
            filterPOST(view)
        }
    })

    $('#clearFBtn').click(function () {

        $('#paidDelivery').prop("checked", true)
        $('#cashOnDelivery').prop("checked", true)

        $('#priceMin').val('');
        $('#priceMax').val('');

        filterPOST(view)
    })

    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        var filters = localStorage.getItem("dealsFilters");
        var pageView = localStorage.getItem("dealsPageView");
        filters = filters.split(',');

        if (filters[2] == '3') {
            $('#paidDelivery').prop("checked", true);
            $('#cashOnDelivery').prop("checked", true);
        }
        if (filters[2] == '0') {
            $('#paidDelivery').prop("checked", false);
            $('#cashOnDelivery').prop("checked", false);
        }
        else if (filters[2] == '1') {
            $('#paidDelivery').prop("checked", true);
            $('#cashOnDelivery').prop("checked", false);
        }
        else if (filters[2] == '2') {
            $('#paidDelivery').prop("checked", false);
            $('#cashOnDelivery').prop("checked", true);
        }

        $('#priceMin').val(filters[3]);
        $('#priceMax').val(filters[4]);

        filterPOST(pageView);
    }

});

function filterPOST(view = 'tile') {
    $('#loading').show();

    var type = $('#typeF').attr('typeF');

    if (type == 'flashDeals') {
        url = "/flash-deals/filter/";
    }
    else if (type == 'topRatedProducts') {
        url = "/top-rated-products/filter/";
    }

    var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
    var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

    if (isNaN(priceMin))
        priceMin = 0.0;
    if (isNaN(priceMax))
        priceMax = 1000000.0;

    $.post(url,
        {
            deliveryStatus: checkDeliveryStatus(),
            priceMin: priceMin,
            priceMax: priceMax,
            _token: post_token,
        },
        function (data) {

            $('#loading').fadeOut("slow");
            $("html, body").animate({ scrollTop: 0 }, 300);

            $(".result-col .resultSummery").remove();
            resultSummery(data['productCount']);

            Result(data['productCount'], data['products'], data['title']);
            $('#product-menu').hide();

            if (view == 'list') {
                showListView();
            }

            localStorage.setItem("dealsFilters", [$('#select-search-cato').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);
            localStorage.setItem("dealsPageView", view);
        });
}

function showListView() {
    $('.search-tile-product-div').hide();
    $('#product-menu').show();
    $('.tile-view-btn i').removeClass('view-button-selected');
    $('.list-view-btn i').addClass('view-button-selected');
    view = 'list';
    localStorage.setItem("dealsPageView", view);
}



