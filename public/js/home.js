$(document).ready(function () {


    $('.cato-card-catos').hover(function () {
        $(this).parent().addClass('cato-item-hover');
    });

    $(".cato-card-catos").mouseout(function () {
        $('.cato-item').removeClass('cato-item-hover');
    });

    $('.owl-c-6').owlCarousel(configOwl(3, 5, 7000, 2200));
    $('.owl-c-6-ii').owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        autoplayTimeout: 7000,
        autoplay: true,
        autoplaySpeed: 2200,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,

            },
            600: {
                items: 3,
            },
            900: {
                items: 5,
            }
        }
    });

    $('.owl-c-3-1').owlCarousel(configOwl(2, 3, 8000, 3000));
    $('.owl-c-3-2').owlCarousel(configOwl(2, 3, 9000, 3000));

    $('.owl-c-4').owlCarousel(configOwl(2, 4, 7000, 2200));
    $('.owl-c-4-ii').owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        autoplayTimeout: 7000,
        autoplay: true,
        autoplaySpeed: 2200,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,

            },
            600: {
                items: 2,
            },
            900: {
                items: 4,
            }
        }
    });

    $('.home-product, .search-product').mouseover(function () {
        $(".option-btn", this).show();
    });

    $('.home-product, .search-product').mouseout(function () {
        $(".option-btn", this).hide();
    });

    $('.wrapper-div .home-tile').mouseover(function () {
        $(this).attr('style', 'border:1px solid #fff;');
    })
    $('.wrapper-div .home-tile').mouseout(function () {
        $(this).attr('style', 'border:1px solid #dcdcdc;');
    })

});