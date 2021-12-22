@extends('layouts.app')


@section('css')
<link href="{{ URL::asset('css/flash-deals.css') }}" rel="stylesheet">
@endsection

@section('title')
Lak Market {{$title}} - Best Discounts & Best Products in Sri Lanka |
@endsection

@section('content')


<div class="site-wrapper pt-16 deals">

    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" id="typeF" typeF={{$type}}>{{$title}}</a>
    </div>

    <div class="site-container container con-banner">
        <div class="banner {{$title == 'Flash Deals' ? 'banner-1' : 'banner-2'}}">
            <div class="banner-text">
                {{$title}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="sr">
            <div class="row">
                <div class="filter-col">
                    <div class="filter-item mt-0">
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

                </div>
                <div class="result-col">
                    <div class="result-count"></div>
                    <div class="h-line"></div>
                    <div class='no-result'></div>

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

        localStorage.setItem("dealsFilters", [$('#select-search-cato').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);

        fx = true;

        if (fx && !(performance.navigation.type == performance.navigation.TYPE_RELOAD)) {
            localStorage.setItem("dealsPageView", 'tile');
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

        var productCount = <?php echo $productCount ?>;
        var products = <?php echo json_encode($products) ?>;
        var type = "<?php echo $title ?>";

        resultSummery(productCount);
        Result(productCount, products, type);
    });

    function resultSummery(productCount) {
        y = document.createElement("DIV");
        y.setAttribute("class", 'resultSummery');

        if (productCount > 1) {
            y.innerHTML = '<h5 class="sr-title"> ' + productCount + ' Products in {{$title}}.</h5>';
        } else if (productCount == 1) {
            y.innerHTML = '<h5 class="sr-title"> ' + productCount + ' Product in {{$title}}.</h5>';
        }
        $('.result-count').append(y);

    }

    function Result(productCount, products, type) {

        $(".result-col .products").remove();
        $(".result-col .products-menu").remove();
        $(".result-col .noResult").remove();

        if (productCount == '0') {
            z = document.createElement("DIV");
            z.setAttribute("class", 'noResult');
            z.innerHTML = '<div class="no-result-img"></div><div class="no-result-h">No Products For ' + type + '...</div><div class="no-result-p">Please try again.</div>';

            $('.result-col .products-menu').hide();
            $('.result-col .products').hide();
            $('.search-tile-title').hide();
            $('.view-buttons').hide();

            $('.no-result').append(z);

        } else {

            $('.result-col .products-menu').show();
            $('.result-col .products').show();
            $('.search-tile-title').show();
            $('.view-buttons').show();
            showResult(products);
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
            name = value.name.length > 40 ? value.name.substr(0, 40) + "..." : value.name;
            price = value.discounted_price;
            unitP = value.discount != '0.00' ? '<p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">' + value.unit_price + '</span></p>' : '';
            rating = (value.rating.toString()).length > 1 ? value.rating : value.rating + '.0';

            if (value.type == "Imported Product") {
                pType = "<div class = 'ribbon ribbon-top-right rtr1'><span>Imported</span></div>";
            } else if (value.type == "Local Product") {
                pType = "<div class = 'ribbon ribbon-top-right rtr2'><span>Local</span></div>";
            } else {
                pType = '';
            }

            b.innerHTML += '<div class="search-tile"><div class="search-tile-body search-product">' + discount + '' + stock + ' <div class="image-container">' + pType + '<a href="/product/' + value.url + '"><img src= "/' + image + '"alt= "' + imageAlt + '"class= "home-tile-img p-0" ></a></div><div class= "product-rating-div-search" ><i class= "fas fa-star rating-star-icon"></i><span class="rating-value">(' + rating + ')</span ></div><div class="home-tile-title text-center mb-10"><div class="product_name"><a href="/product / ' + value.url + '" class="home-tile-title-h price-tile ">' + name + ' </a></div><div class="home-tile-price "><p class="home-tile-price-rs ">Rs. <span class="home-tile-price ">' + price + '</span></p><div class="product-price ">' + unitP + ' </div></div><div class="option-btn " style="display: none "><button class="option-btn-1 "><i class="fas fa-heart "></i></button><button class="option-btn-2 "><i class="fas fa-cart-plus "></i></button></div><div class="by-now-btn "><button>Buy Now</button></div></div></div></div>';
        });
        $('#product-tile').append(b);

        x = document.createElement("DIV");
        x.setAttribute("class", 'search-tile-product-div-hr products-menu');

        $.each(products, function(index, value) {
            discount = value.discount != '0.00' ? '<div class="discount-wrapper"><div class="discount-text"><span class="discount-amount">-' + (value.discount).split(".")[0] + '</span><span class="discount-sign">%</span><span class="discount-off">Off</span></div><img class="discount-img" src="/img/discount-wrapper.png" alt="discount"></div>' : '';

            stock = value.stock == 0 ? '<div class="outofstock"> <div> Out of Stock </div></div>' : '';

            image = (value.images).split(",")[0].replaceAll("\\", '').replaceAll("[\"", '').replaceAll("\"]", '');
            imageAlt = value.name.length > 10 ? value.name.substr(0, 10) + "..." : value.name;
            name = value.name.length > 60 ? value.name.substr(0, 60) + "..." : value.name;
            price = value.discounted_price;
            long_desc = value.long_desc.length > 140 ? value.long_desc.substr(0, 140) + "..." : value.long_desc;
            unitP = value.discount != '0.00' ? '<p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">' + value.unit_price + '</span></p>' : ''
            rating = (value.rating.toString()).length > 1 ? value.rating : value.rating + '.0';

            if (value.type == "Imported Product") {
                pType = "<div class = 'ribbon ribbon-top-right rtr1'><span>Imported</span></div>";
            } else if (value.type == "Local Product") {
                pType = "<div class = 'ribbon ribbon-top-right rtr2'><span>Local</span></div>";
            } else {
                pType = '';
            }


            x.innerHTML += '<div class="search-tile-hr"><div class="row search-tile-body search-product menu-product"><div class="col-md-c-3"> ' + discount + '' + stock + '<div class="image-container">' + pType + '<a href="/product/' + value.url + '"><img src="/' + image + '"  alt="' + imageAlt + '" class="home-tile-img p-0"></a></div><div class="product-rating-div-search"><i class="fas fa-star rating-star-icon"></i><span class="rating-value">(' + rating + ')</span></div></div><div class="home-tile-title col-md-7"><a href="/product/' + value.url + '" class="home-tile-title-h price-tile">' + name + '</a><div class="product-desc"><div class="shor-desc">' + value.short_desc + '</div><div class="long-desc">' + long_desc + '</div></div><div class="shop-name"><a target="_blank" href="/store/' + value.sellerURL + '">' + value.seller + '</a></div><div class="district-city"><span class="district">' + value.district + '</span><span">, </span><span class="city">' + value.city + '</span></div></div><div class="col-md-c-2  text-center"><div class="home-tile-price pt-10"><p class="home-tile-price-rs">Rs. <span class="home-tile-price">' + price + '</span></p><div class="product-price">' + unitP + '</div></div><div class="option-btn" style="display:none;"><button style="margin: 0px 8px 0px 7px;"><i class="fas fa-heart"></i></button><button style="margin: 0px 5px 0px 10px"><i class="fas fa-cart-plus"></i></button></div><div class="by-now-btn"><button>Buy Now</button></div></div></div></div>';
        });
        $('#product-menu').append(x);
    }
</script>

<script src="{{ asset('js/deals.js') }}" defer></script>

@endsection