@extends('layouts.app')

@section('css')
<link href="{{ URL::asset('css/flash-deals.css') }}" rel="stylesheet">
@endsection

@section('title')
Lak Market {{$title}} - Best Discounts & Best Products in Sri Lanka |
@endsection

@section('content')
<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">{{$title}}</a>
    </div>
    <div class="site-container container con-banner">
        <div class="banner banner-3">
            <div class="banner-text">
                {{$title}}
            </div>
        </div>
    </div>
    <div class="container">

        <div class="sr store-categories">
            <div class="row">
                <div class="filter-col">
                    <div class="filter-item mt-0">
                        <div class="filter-item-body">
                            <p class="filter-title-text mb-15">Delivery Type :</p>
                            <div class="delivery-check">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="paidDelivery" checked>
                                    <label class="custom-control-label" for="paidDelivery">Paid Delivery</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="cashOnDelivery" checked>
                                    <label class="custom-control-label" for="cashOnDelivery">Cash On Delivery</label>
                                </div>
                            </div>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="result-col">
                    <div class="result-count">

                    </div>
                    <div class="h-line">
                    </div>


                    <div class='no-result'>
                    </div>

                    <div id="storesC">
                    </div>

                    <div class="pagination-div">

                        <div class="pagination-udiv">
                            <div class="h-line"></div>

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
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var stores = <?php echo json_encode($stores) ?>;
        var storeCount = <?php echo $storesCount ?>;
        var title = '<?php echo $title ?>';

        resultSummery(storeCount, title);
        resultData(storeCount, title, stores)

        $('.delivery-check input[type="checkbox"]').change(function() {
            filterPOST(title)
        });
    });

    function resultData(storeCount, title, stores) {

        // $(".resultSummery").load(window.location.href + ".resultSummery");
        $(".resultSummery").remove();
        $(".result-col .noResult").remove();
        $(".result-col .stores").remove();
        resultSummery(storeCount, title);

        if (storeCount == '0') {
            z = document.createElement("DIV");
            z.setAttribute("class", 'noResult');
            z.innerHTML = '<div class="no-result-img"></div><div class="no-result-h">No Shops For ' + title + '... </div><div class="no-result-p">Please try again.</div > ';

            $('.result-col .storesC').hide();
            $('.no-result').append(z);

        } else {
            $('.result-col .storesC').show();
            storesFunc(stores);
        }
    }

    function resultSummery(storeCount, title) {
        y = document.createElement("DIV");
        y.setAttribute("class", 'resultSummery ');
        if (storeCount > 1) {
            y.innerHTML = '<h5 class="sr-title"> ' + storeCount + ' Shops found for "' + title + '"</h5>';
        } else {
            y.innerHTML = '<h5 class="sr-title"> ' + storeCount + ' Shop found for "' + title + '"</h5>';
        }
        $('.result-count').append(y);
    }

    function storesFunc(stores) {
        d = document.createElement("DIV");
        d.setAttribute("class", 'search-tile-product-div stores ');

        $.each(stores, function(index, value) {

            imageAlt = value.store_name.length > 10 ? value.store_name.substr(0, 10) + "..." : value.store_name;
            name = value.store_name.length > 32 ? value.store_name.substr(0, 32) + "..." : value.store_name;
            ld = value.city + ', ' + value.district + ' District';
            location_d = ld.length > 32 ? ld.substr(0, 32) + "..." : ld;
            rating = (value.rating.toString()).length > 1 ? value.rating : value.rating + '.0';

            d.innerHTML += '<div class="category-tile"><div class="search-tile-body category-shops"><a target="_blank" href="/store/' + value.url + '"><img src="/' + value.store_logo + '" alt="' + imageAlt + '" class="home-tile-img home-tile-shop-img"></a><div class="home-tile-title"><a target="_blank" href="/store/' + value.url + '" class="home-tile-title-h">' + name + '</a><div><span class="home-tile-title-p">' + location_d + '</span></div><div class="home-tile-rating"><i class="fas fa-star rating-star-icon"></i><span class="rating-value">(' + rating + ')</span></div></div><div class="search-tile-button"><a target="_blank" href="/store/' + value.url + '" class="search-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Show Now</a><a href="https://maps.google.com/?q=' + value.longitude + ',' + value.latitude + '" target="_blank" class="search-tile-get-direction"><i class="fas fa-directions direction-icon"></i>Get Direction</a></div></div></div>';
        });
        $('#storesC').append(d);
    }
</script>

<script src="{{ asset('js/topRatedShop.js') }}" defer></script>
@endsection