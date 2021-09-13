@extends('layouts.app')


@section('title')
{{$q}} - Buy {{$q}} at Best price in Sri Lanka |
@endsection

@section('content')

<div class="site-wrapper pt-16">

    @if($type == "search")
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">Search Result</a>
    </div>

    @elseif($type == "subCato")
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="/category/{{$catoUrl}}">{{$cato}}</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">{{$q}}</a>
    </div>

    @endif

    <div class="site-container container">
        <div class="search-result">
            <div class="row">
                <div class="filter-col">
                    <div class="filter-item mt-0">
                        <div class="filter-item-body">
                            <span id="searchFilter" data-sort="{{Session::has('searchFilterSort')?Session::get('searchFilterSort'):''}}"></span>
                            <input type="hidden" name="q" id='temp1'>
                            <input type="hidden" name="" id='temp2'>
                            <p class="filter-title-text">Sort By :</p>
                            <span class="nav-item dropdown sort-filter">
                                <i class="fas fa-chevron-down down-btn"></i>
                                <select class="selectpicker sort-filter-select" id='sort-filter-select' name='sort'>
                                    <option>Best Match</option>
                                    <option>Price Low to High</option>
                                    <option>Price High to Low</option>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="filter-item-body">
                            <p class="filter-title-text mb-15">Delivery Type :</p>
                            <div class="delivery-check">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="paidDelivery" checked value="0">
                                    <label class="custom-control-label" for="paidDelivery">Paid Delivery</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="cashOnDelivery" checked value="1">
                                    <label class="custom-control-label" for="cashOnDelivery">Cash On Delivery</label>
                                </div>
                            </div>
                            </span>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Price :</p>
                            <div class="filter-price">
                                <input name="priceMin" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="text" onkeypress="return  /^[0-9]?[0-9]*$/i.test(event.key)" class="form-control p-input " id="priceMin" maxlength="9" placeholder="min">
                                <span class="filter-price-dash">-</span>
                                <input name="priceMax" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="text" onkeypress="return  /^[0-9]?[0-9]*$/i.test(event.key)" class="form-control p-input " id="priceMax" maxlength="9" placeholder="max">

                                <button class="filter-btn-1" id="rangeBtn"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="filter-item-body text-center">
                            <button id='clearFBtn' class="filter-btn-1 btn-2"> <i class="fas fa-trash"></i>Clear All Filters</i></button>
                        </div>
                    </div>
                    <div id="categories">
                    </div>
                </div>
                <div class="result-col">
                    <div class="result-count"></div>
                    <div class="h-line"></div>
                    <div class='no-result'></div>

                    <div class="search-tile-title">
                        <h4>Related shops for "{{$q}}"</h4>
                    </div>
                    <div id="search-stores"></div>
                    <div class="h-line h-l-1"></div>
                    <div class="search-tile-title" style="margin-bottom: 15px;">
                        <h4>Related products for "{{$q}}"</h4>
                    </div>
                    <div class="view-buttons">
                        <span>View: </span>
                        <button class="tile-view-btn"><i class="fas fa-th-large view-button-selected"></i></button>
                        <button class="list-view-btn"><i class="fas fa-th-list"></i></button>
                    </div>
                    <div id="product-tile">
                    </div>
                    <div id="product-menu" style="display: none;">
                    </div>
                    <div class="h-line">
                    </div>
                    <div>
                        <ul class="pagination justify-content-end pagination-ul">
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link pagination-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link pagination-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link pagination-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link pagination-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link pagination-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link pagination-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <div class="pagination-go-to">
                                <span>Total <span>60</span> pages</span>
                                <span class="go-to-text">Go to Page</span>
                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="priceFrom" maxlength="3">
                                <button class="filter-btn-1"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        localStorage.setItem("filters", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);

        fx = true;

        if (fx && !(performance.navigation.type == performance.navigation.TYPE_RELOAD)) {
            localStorage.setItem("pageView", 'tile');
            fx = false;
        }

        $('.search-product').mouseover(function() {
            $(".option-btn", this).show();
        });

        $('.search-product').mouseout(function() {
            $(".option-btn", this).hide();
        });

        $('.search-tile-product-div .search-product').mouseover(function() {
            $(".option-btn", this).show();
        });

        $('.search-tile-product-div .search-product').mouseout(function() {
            $(".option-btn", this).hide();
        });

        var stores = <?php echo json_encode($stores) ?>;
        var storeCount = <?php echo $storeCount ?>;
        var productCount = <?php echo $productCount ?>;
        var q = '<?php echo $q ?>';
        var products = <?php echo json_encode($products) ?>;
        var categories = <?php echo json_encode($categories) ?>;

        resultSummery(storeCount, productCount, q);
        Result(productCount, q, stores, products, categories, storeCount);
    });

    function resultSummery(storeCount, productCount, q) {
        y = document.createElement("DIV");
        y.setAttribute("class", 'resultSummery');

        if ((storeCount > 1) && (productCount > 1)) {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shops and ' + productCount + ' Products found for "' + q + '"</h5>';
        } else if ((storeCount > 1) && !(productCount > 1)) {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shops and ' + productCount + ' Product found for "' + q + '"</h5>';
        } else if (!(storeCount > 1) && (productCount > 1)) {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shop and ' + productCount + ' Products found for "' + q + '"</h5>';
        } else if (!(storeCount > 1) && !(productCount > 1)) {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shop and ' + productCount + ' Product found for "' + q + '"</h5>';
        }
        $('.result-count').append(y);

    }

    function Result(productCount, q, stores, products, categories, storeCount) {

        $(".result-col .products").remove();
        $(".result-col .products-menu").remove();
        $(".filter-item .categorySP").remove();
        $(".result-col .stores").remove();
        $(".result-col .storesWO").remove();
        $(".result-col .noResult").remove();

        if (productCount == '0') {
            z = document.createElement("DIV");
            z.setAttribute("class", 'noResult');
            z.innerHTML = '<div class="no-result-img"></div><div class="no-result-h">No Result For Search...</div><div class="no-result-p">We\'re sorry. Your search "' + q + '" did not match any products.Please try again.</div>';

            $('.result-col .products-menu').hide();
            $('.result-col .products').hide();
            $('.filter-item .categorySP').hide();
            $('.result-col .stores').hide();

            $('.search-tile-title').hide();
            $('.view-buttons').hide();
            $('.h-l-1').hide();

            $('.no-result').append(z);

        } else {

            $('.result-col .products-menu').show();
            $('.result-col .products').show();
            $('.filter-item .categorySP').show();
            $('.result-col .stores').show();

            $('.search-tile-title').show();
            $('.view-buttons').show();
            $('.h-l-1').show();

            // $(".result-col .products").load(window.location.href + ".result-col .products");
            // $(".result-col .products-menu").load(window.location.href + ".result-col .products-menu");
            // $(".filter-item .categorySP").load(window.location.href + ".filter-item .categorySP");
            // $(".result-col .stores").load(window.location.href + ".result-col .stores");
            // $(".result-col .resultSummery").load(window.location.href + ".result-col .resultSummery");
            // $(".result-col .storesWO").load(window.location.href + ".result-col .storesWO");
            // $(".result-col .noResult").load(window.location.href + ".result-col .noResult");

            searchShops(stores, storeCount);
            showResult(products);
            searchCategories(productCount, categories);
        }
    }

    function searchShops(stores, storeCount) {

        if ((parseInt(storeCount) < 4)) {
            a = document.createElement("DIV");
            a.setAttribute("class", 'search-tile-div row mr-0 ml-0 storesWO');

            $.each(stores, function(index, value) {
                a.innerHTML += ' <div class="col-md-3 home-tile stores"> <div class="home-tile-body"> <a href="/store/' + value.url + '"> <img src="/' + value.store_logo + '" alt="' + value.store_name + '" class="home-tile-img home-tile-shop-img"> </a> <div class="home-tile-title"> <a href="/store/' + value.url + '" class="home-tile-title-h">' + value.store_name + '</a> <p class="home-tile-title-p">' + value.city + '</p> <div class="home-tile-rating"> <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span> </div> </div> <div class="search-tile-button"> <a href="/store/' + value.url + '" class="search-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Visit</a> <a href="https://maps.google.com/?q=' + value.longitude + ',' + value.latitude + '" target="_blank" class="search-tile-get-direction"><i class="fas fa- directions direction-icon"></i>Direction</a> </div> </div> </div>';
            });

            $('#search-stores').append(a);

        } else {
            a = document.createElement("DIV");
            a.setAttribute("class", 'search-tile-div owl-carousel owl-theme owl-c-4 owl-c-4-1 stores');

            $.each(stores, function(index, value) {
                a.innerHTML += ' <div class="col-md home-tile stores"> <div class="home-tile-body"> <a href="/store/' + value.url + '"> <img src="/' + value.store_logo + '" alt="' + value.store_name + '" class="home-tile-img home-tile-shop-img"> </a> <div class="home-tile-title"> <a href="/store/' + value.url + '" class="home-tile-title-h">' + value.store_name + '</a> <p class="home-tile-title-p">' + value.city + '</p> <div class="home-tile-rating"> <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span> </div> </div> <div class="search-tile-button"> <a href="/store/' + value.url + '" class="search-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Visit</a> <a href="https://maps.google.com/?q=' + value.longitude + ',' + value.latitude + '" target="_blank" class="search-tile-get-direction"><i class="fas fa- directions direction-icon"></i>Direction</a> </div> </div> </div>';
            });


            $('#search-stores').append(a);

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
            $('.owl-c-4').owlCarousel(configOwl(2, 4, 4000, 2200));
        }
    }

    function showResult(products) {
        b = document.createElement("DIV");
        b.setAttribute("class", 'search-tile-product-div products');

        $.each(products, function(index, value) {
            discount = value.discount != '0.00' ? '<div class="discount-wrapper"><div class="discount-text"><span class="discount-amount">-' + (value.discount).split(".")[0] + '</span> <span class="discount-sign">%</span><span class="discount-off">Off</span></div><img class="discount-img" src="/img/discount-wrapper.png" alt="discount"></div>' : '';

            stock = value.stock == 0 ? '<div class="outofstock"> <div> Out of Stock </div></div>' : '';

            image = (value.images).split(",")[0].replaceAll("\\", '').replaceAll("[\"", '').replaceAll("\"]", '');
            imageAlt = value.name.length > 10 ? value.name.substr(0, 10) + "..." : value.name;
            name = value.name.length > 50 ? value.name.substr(0, 50) + "..." : value.name;
            price = value.discounted_price;
            unitP = value.discount != '0.00' ? '<p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">' + value.unit_price + '</span></p>' : '';

            b.innerHTML += '<div class="search-tile"><div class="search-tile-body search-product"> ' + discount + '' + stock + ' <div class="image-container"> <a href="/product/' + value.url + '"><img src="/' + image + '" alt="' + imageAlt + '" class="home-tile-img p-0"></a> </div><div class="product-rating-div-search"> <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span> </div> <div class="home-tile-title text-center mb-10"> <div class="product_name"> <a href="/product/' + value.url + '" class="home-tile-title-h price-tile"> ' + name + ' </a> </div> <div class="home-tile-price"> <p class="home-tile-price-rs">Rs. <span class="home-tile-price">' + price + '</span></p><div class="product-price"> ' + unitP + ' </div></div> <div class="option-btn" style="display:none"> <button class="option-btn-1"><i class="fas fa-heart"></i></button> <button class="option-btn-2"><i class="fas fa-cart-plus"></i></button> </div> <div class="by-now-btn"> <button>Buy Now</button> </div> </div></div>  </div> ';
        });
        $('#product-tile').append(b);

        x = document.createElement("DIV");
        x.setAttribute("class", 'search-tile-product-div-hr products-menu');

        $.each(products, function(index, value) {
            discount = value.discount != '0.00' ? '<div class="discount-wrapper"><div class="discount-text"><span class="discount-amount">-' + (value.discount).split(".")[0] + '</span><span class="discount-sign">%</span><span class="discount-off">Off</span></div><img class="discount-img" src="/img/discount-wrapper.png" alt="discount"></div>' : '';

            stock = value.stock == 0 ? '<div class="outofstock"> <div> Out of Stock </div></div>' : '';

            image = (value.images).split(",")[0].replaceAll("\\", '').replaceAll("[\"", '').replaceAll("\"]", '');
            imageAlt = value.name.length > 10 ? value.name.substr(0, 10) + "..." : value.name;
            name = value.name.length > 50 ? value.name.substr(0, 50) + "..." : value.name;
            price = value.discounted_price;
            long_desc = value.long_desc.length > 140 ? value.long_desc.substr(0, 140) + "..." : value.long_desc;
            unitP = value.discount != '0.00' ? '<p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">' + value.unit_price + '</span></p>' : ''

            x.innerHTML += '<div class="search-tile-hr"><div class="row search-tile-body search-product menu-product"><div class="col-md-c-3"> ' + discount + '' + stock + '<div class="image-container"><a href="/product/' + value.url + '"><img src="/' + image + '"  alt="' + imageAlt + '" class="home-tile-img p-0"></a></div><div class="product-rating-div-search"><i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span></div></div><div class="home-tile-title col-md-7"><a href="/product/' + value.url + '" class="home-tile-title-h price-tile">' + name + '</a><div class="product-desc"><div class="shor-desc">' + value.short_desc + '</div><div class="long-desc">' + long_desc + '</div></div><div class="shop-name"><a href="/store/' + value.sellerURL + '">' + value.seller + '</a></div><div class="district-city"><span class="district">' + value.district + '</span><span">, </span><span class="city">' + value.city + '</span></div></div><div class="col-md-c-2  text-center"><div class="home-tile-price pt-10"><p class="home-tile-price-rs">Rs. <span class="home-tile-price">' + price + '</span></p><div class="product-price">' + unitP + '</div></div><div class="option-btn" style="display:none;"><button style="margin: 0px 8px 0px 7px;"><i class="fas fa-heart"></i></button><button style="margin: 0px 5px 0px 10px"><i class="fas fa-cart-plus"></i></button></div><div class="by-now-btn"><button>Buy Now</button></div></div></div></div>';
        });
        $('#product-menu').append(x);
    }

    function searchCategories(productCount, categories) {
        d = document.createElement("DIV");
        d.setAttribute("class", 'filter-item');
        d.setAttribute('style', "border-bottom:unset;");

        if (productCount != 0) {

            e = document.createElement("DIV");
            e.setAttribute("class", 'filter-item-body categorySP');
            e.innerHTML = '<p class="filter-title-text mb-0">Related Categories</p>';

            f = document.createElement("DIV");
            f.setAttribute("class", 'filter-related-cato');

            $.each(categories, function(index, value) {
                f.innerHTML += '<li class="f-r-c-li-i"> <a href="/category/' + value[0] + '"><i class="fas fa-chevron-right"></i> ' + index + '</a></li>';

                $.each(value[1], function(x, y) {

                    f.innerHTML += '<li class="f-r-c-li-ii"> <a href="/category/' + value[0] + '/' + y[1] + '">' + y[0] + '</a></li>';
                });
            });
            e.append(f);
            d.append(e);
        };

        $('#categories').append(d);
    }
</script>

<script src="{{ asset('js/search.js') }}" defer></script>

@endsection