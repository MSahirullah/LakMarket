@extends('layouts.app')

@section('title')
{{$q}} in Sri Lanka
@endsection

@section('content')
<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">{{$q}}</a>
    </div>
    <div class="site-container container">

        <div class="search-result store-categories">
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

                    <div class="filter-item" style="border-bottom:unset;">
                        <div id="filterC">
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
        var categories = <?php echo json_encode($categories) ?>;
        var stores = <?php echo json_encode($stores) ?>;
        var storeCount = <?php echo $storesCount ?>;
        var q = '<?php echo $q ?>';

        localStorage.setItem("SC", q);

        resultSummery(storeCount, q);
        resultData(storeCount, q, categories, stores)

        $('.delivery-check input[type="checkbox"]').change(function() {
            filterPOST(q)
        });
    });

    function resultData(storeCount, q, categories, stores) {

        // $(".resultSummery").load(window.location.href + ".resultSummery");
        $(".resultSummery").remove();
        $(".result-col .noResult").remove();
        $(".result-col .stores").remove();
        $(".filter-item .subCategories").remove();
        resultSummery(storeCount, q);

        if (storeCount == '0') {
            z = document.createElement("DIV");
            z.setAttribute("class", 'noResult');
            z.innerHTML = '<div class="no-result-img"></div><div class="no-result-h">No Result For ' + q + '... </div><div class="no-result-p">We\'re sorry. "' + q + '" are not currently on our Lak Market.</div > ';

            $('.filter-item .subCategories').hide();
            $('.result-col .storesC').hide();
            $('.no-result').append(z);

        } else {
            $('.filter-item .subCategories').show();
            $('.result-col .storesC').show();

            // $(".filter-item .subCategories").load(window.location.href + ".filter-item .subCategories");


            // $(".result-col .stores").load(window.location.href + ".result-col .stores");


            // $(".result-col .noResult").load(window.location.href + ".result-col .noResult");



            subCategories(storeCount, categories, q)
            storesFunc(stores);
        }
    }

    function subCategories(storeCount, categories, q) {
        a = document.createElement("DIV");
        a.setAttribute("class", 'filter-item-body subCategories');

        if (storeCount != 0) {

            a.innerHTML = '<p class="filter-title-text">Sub Categories</p>';

            b = document.createElement("DIV");
            b.setAttribute("class", 'filter-related-cato');

            c = document.createElement("DIV");
            c.setAttribute("class", 'filter-related-cato');

            c.innerHTML = '<li class="f-r-c-li-i selected-c pt-0"> <i class="fas fa-chevron-right"></i> <a class="selected-c">' + q + '</a></li>';

            $.each(categories, function(index, value) {
                c.innerHTML += '<li class="f-r-c-li-ii"> <a href="/category/' + value.categoryUrl + '/' + value.url + '">' + value.name + '</a></li>';
            });
            b.append(c);
            a.append(b);
        };

        $('#filterC').append(a);
    }

    function resultSummery(storeCount, q) {
        y = document.createElement("DIV");
        y.setAttribute("class", 'resultSummery ');
        if (storeCount > 1) {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shops found for "' + q + '"</h5>';
        } else {
            y.innerHTML = '<h5 class="search-result-title"> ' + storeCount + ' Shop found for "' + q + '"</h5>';
        }
        $('.result-count').append(y);
    }

    function storesFunc(stores) {
        d = document.createElement("DIV");
        d.setAttribute("class", 'search-tile-product-div stores');

        $.each(stores, function(index, value) {

            imageAlt = value.store_name.length > 10 ? value.store_name.substr(0, 10) + "..." : value.store_name;
            name = value.store_name.length > 32 ? value.store_name.substr(0, 32) + "..." : value.store_name;
            ld = value.city + ', ' + value.district + ' District';
            location_d = ld.length > 32 ? ld.substr(0, 32) + "..." : ld;

            console.log(location_d);

            d.innerHTML += '<div class="category-tile"><div class="search-tile-body category-shops"><a href="/store/' + value.url + '"><img src="/' + value.store_logo + '" alt="' + imageAlt + '" class="home-tile-img home-tile-shop-img"></a><div class="home-tile-title"><a href="value.url" class="home-tile-title-h">' + name + '</a><div><span class="home-tile-title-p">' + location_d + '</span></div><div class="home-tile-rating"><i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span></div></div><div class="search-tile-button"><a href="/store/' + value.url + '" class="search-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Show Now</a><a href="https://maps.google.com/?q=' + value.longitude + ',' + value.latitude + '" target="_blank" class="search-tile-get-direction"><i class="fas fa-directions direction-icon"></i>Get Direction</a></div></div></div>';
        });
        $('#storesC').append(d);
    }
</script>

<script src="{{ asset('js/categories.js') }}" defer></script>
@endsection