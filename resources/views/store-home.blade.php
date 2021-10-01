@extends('layouts.app')
@section('title')
{{$store->store_name}} | {{$store->store_cato}} |
@endsection

@section('content')
<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p mb-0">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="/category/{{$store->cato_url}}">{{$store->store_cato}}</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" id="storeHome" data-url="{{$store->url}}">{{$store->store_name}}</a>

    </div>
    <div class="site-container container pl-0 pr-0 c-c-s-2">
        <div class="store-header-location">
            <div id="map"></div>
        </div>
        <div class="store-details-div">
            <div class="row store-details">
                <div class="col-md-c-1 store-logo">
                    <img src="/{{$store->store_logo}}" alt="{{substr($store->store_name, 0 , 10)}}">
                </div>
                <div class="col-md-6 store-info">
                    <div class="store-name" sid="{{$store->id}}" id="storeD">
                        <h2>{{$store->store_name}}</h2>
                    </div>
                    <div class="by-now-btn">
                        <a {{(Session::has('customer')) ? '' : 'href=/follow'}}><button {{(Session::has('customer')) ? 'id=followBtn' : ''}} class="{{$followS == 1 ? 'followed' : '' }}"><i class="fas fa-user-plus" style="padding-right:5px;"></i> <span id="followBtnTxt">{{$followS == 1 ? 'Followed' : 'Follow' }}</span></button></a>

                    </div>
                    <div class="report-btn">
                        <a {{Session::has('customer') ? "data-toggle=modal data-target=#sellerReportModal" : "href=/report"  }}>Report Seller</a>
                    </div>
                    <div class="store-follow">
                        <div class="followers"><i class="far fa-star"></i> <span id="followers">{{$followers}}</span> followers</div>
                        <div><i class="fas fa-medal"></i> <span>{{$positiveF}}</span>% (<span>{{$positiveFC}}</span>) Positive Ratings.</div>
                    </div>

                    <div class="col-md-12 store-search pr-0 pl-0">
                        <form action="{{route('store.search', $store->url)}}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" id="storeSearchQ" name="q" placeholder="Search in Shop" maxlength="50" value="{{Session::has('storeSearchCato')?Session::get('storeSearchCato'):''}}">
                                <div class=" input-group-append">
                                    <button class="btn btn-primary" id="searchSubmitBtnTemp">
                                        <i class="fas fa-search" style="padding-right: 5px;"></i>Search
                                    </button>
                                    <button type="submit" id='storeSearchSubmitBtn' style='display:none'></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-c-4 store-contact">
                    <div class="store-since">Seller since {{date('F Y', strtotime($store->created_at))}}</div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-phone-square-alt icon"></i>
                        </div>

                        <div class="col-sm pl-0 pr-0 contact-details mobile">
                            <div class="item">{{$store->hotline ? 'Hotline : '.$store->hotline : ''}}</div>
                            <div class="item">{{$store->business_mobile ? 'Business Mobile : '.$store->business_mobile : ''}}</div>
                        </div>
                    </div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-map-marker-alt icon"></i>
                        </div>
                        <div class=" col-sm pl-0 pr-0 contact-details address">
                            <div class="item">{{$store->address}}</div>
                            <div class="location">
                                <div class="by-now-btn">
                                    <a href="https://maps.google.com/?q={{$store->longitude}},{{$store->latitude}}" target="_blank"><button><i class="fas fa-location-arrow location-icon"> </i> Get Direction</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0 mb-15 ">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-envelope icon"></i>
                        </div>
                        <div class="col-sm pl-0 pr-0 contact-details email">
                            <div class="item" id="itemEmail" onclick="selectText('itemEmail')">{{$store->business_email}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container store-container" style="padding-top:18px;">

        <div class="sr">
            <div class="row">
                <div class="filter-col">
                    @if($catoID != '')
                    <div class="filter-item mt-0 mb-pt-1 back-text-div">
                        <a href="{{route('store.index', $store->url)}}">
                            <p class="back-text "><i class="far fa-arrow-alt-circle-left pr--5 "></i> Back to Store Home</p>
                        </a>
                    </div>
                    @endif
                    <div class="filter-item mt-0">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Sort By :</p>
                            <span class="nav-item dropdown sort-filter">
                                <i class="fas fa-chevron-down down-btn"></i>
                                <select class="selectpicker sort-filter-select" id="sort-filter-select">
                                    <option>Best Match </option>
                                    <option>Price Low to High</option>
                                    <option>Price High to Low</option>
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Delivery Type :</p>
                            <div class="delivery-check">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="paidDeliveryStore" checked>
                                    <label class="custom-control-label" for="paidDeliveryStore">Paid Delivery</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="cashOnDeliveryStore" checked>
                                    <label class="custom-control-label" for="cashOnDeliveryStore">Cash On Delivery</label>
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

                                <button class="filter-btn-1" id="rangeBtn2"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="filter-item-body text-center">
                            <button id='clearFBtn' class="filter-btn-1 btn-2"> <i class="fas fa-trash"></i>Clear All Filters</i></button>
                        </div>
                    </div>

                    <div class="filter-item" style="border-bottom:unset;">
                        <div class="filter-item-body" id="catoSelected" sCato="{{$catoID != '' ? $catoID : ''}}">
                            <p class="filter-title-text">Categories</p>
                            <div class="filter-related-cato">
                                @if($q != '')
                                <li class="f-r-c-li-i">
                                    <i class="fas fa-chevron-right"></i>
                                    <a target="_blank" href="/store/{{$store->url}}">All Products</a>
                                </li>
                                @endif
                                @foreach($shopCategories as $sc)
                                <li class="f-r-c-li-i {{$q == $sc['name'] ? 'red-selected' : ''}}">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="{{route('store.category', ['store' => $sc['storeURL'], 'category' => $sc['url']])}}" class="{{$q == $sc['name'] ? 'red-selected' : ''}}">{{$sc['name']}}</a>
                                </li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="result-col" id="result-col">
                    <div class="search-tile-title" style="margin-bottom: 15px;">
                        @if($q != '')
                        <h4 id="relatedProductTxt">Related products for "{{$q}}"</h4>
                        @endif
                    </div>

                    <div class="result-count ">
                        <div class="view-buttons {{$q != '' ? '' : 'view-buttons-2'}}">
                            <span>View: </span>
                            <button class="tile-view-btn"><i class="fas fa-th-large view-button-selected"></i></button>
                            <button class="list-view-btn"><i class="fas fa-th-list"></i></button>
                        </div>
                    </div>

                    <div class="h-line">
                    </div>
                    <div class='no-result'></div>
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

    <div class="modal fade" id="storeReportModal" tabindex="-1" role="dialog" aria-labelledby="storeReportModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <form action="{{route('report.review')}}" method="post">

                    @csrf
                    <input type="hidden" name="review_id" value="" id="reviewID-report">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Select a reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio1" name="reportRadio" class="custom-control-input" value="Return / Refund Issue" required>
                            <label class="custom-control-label" for="reportRadio1">Return / Refund Issue</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio2" name="reportRadio" class="custom-control-input" value="Service Related Issue" required>
                            <label class="custom-control-label" for="reportRadio2">Service Related Issue</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio3" name="reportRadio" class="custom-control-input" value="Wrong Picture" required>
                            <label class="custom-control-label" for="reportRadio3">Wrong Picture</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio4" name="reportRadio" class="custom-control-input" value="Personal/Order Details" required>
                            <label class="custom-control-label" for="reportRadio4">Personal/Order Details</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio5" name="reportRadio" class="custom-control-input" value="Abusive Language" required>
                            <label class="custom-control-label" for="reportRadio5">Abusive Language</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio6" name="reportRadio" class="custom-control-input" value="Irrelevant Information" required>
                            <label class="custom-control-label" for="reportRadio6">Irrelevant Information</label>
                        </div>
                        <div class="form-group">
                            <label for="addInfoReport" class='reportTextarea'>Additional Comments</label>
                            <textarea class="form-control addInfoReport" name='addInfoReport' id="addInfoReport" rows="4" maxlength="250"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning btn-report-submit">Report</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @endsection

    @section('scripts')
    <script>
        var marker = false;

        function initMap() {
            var lo = <?php echo $store->longitude ?>;
            var la = <?php echo $store->latitude ?>;

            var centerOfMap = new google.maps.LatLng(lo, la);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: centerOfMap,
                zoom: 15,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER,
                },
                scaleControl: true,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP,
                },
                fullscreenControl: true,
            });

            var _marker = new google.maps.Marker({
                position: centerOfMap,
                map: map,
                title: ''
            });

            _marker.setMap(map);
        }

        $(document).ready(function() {
            localStorage.setItem("filtersInStore", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);

            var products = <?php echo json_encode($products) ?>;
            var q = <?php echo json_encode($q) ?>;


            fx = true;

            if (fx && !(performance.navigation.type == performance.navigation.TYPE_RELOAD)) {
                localStorage.setItem("pageViewStore", 'tile');
                fx = false;
                Result(products);
                if (q != '') {
                    $("html, body").animate({
                        scrollTop: 550
                    }, 300);
                }
            } else {
                Result(products);
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

        });

        function Result(products) {

            $("#result-col .search-tile-product-div").remove();
            $("#result-col .products-menu").remove();
            $("#result-col .noResult").remove();

            var productCount = Object.keys(products).length;

            if (productCount == 0) {
                z = document.createElement("DIV");
                z.setAttribute("class", 'noResult');
                z.innerHTML = '<div class="no-result-img"></div><div class="no-result-h">No Products Found...</div><div class="no-result-p"></div>';

                $('.result-col .products-menu').hide();
                $('.result-col .products-menu').html('');
                $('.result-col .products').hide();
                $('.result-col .products').html('');

                $('.view-buttons').hide();
                $('.h-l-1').hide();

                $('.no-result').append(z);

            } else {

                $('.result-col .products-menu').show();
                $('.result-col .products').show();
                $('.view-buttons').show();
                $('.h-l-1').show();

                // $(".result-col .products").load(window.location.href + ".result-col .products");
                // $(".result-col .products-menu").load(window.location.href + ".result-col .products-menu");
                // $(".filter-item .categorySP").load(window.location.href + ".filter-item .categorySP");
                // $(".result-col .stores").load(window.location.href + ".result-col .stores");
                // $(".result-col .resultSummery").load(window.location.href + ".result-col .resultSummery");
                // $(".result-col .storesWO").load(window.location.href + ".result-col .storesWO");
                // $(".result-col .noResult").load(window.location.href + ".result-col .noResult");
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

                b.innerHTML += '<div class="search-tile"><div class="search-tile-body search-product"> ' + discount + '' + stock + ' <div class="image-container"> <a href="/product/' + value.url + '"><img src="/' + image + '" alt="' + imageAlt + '" class="home-tile-img p-0"></a> </div><div class="product-rating-div-search"> <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(' + rating + ')</span> </div> <div class="home-tile-title text-center mb-10"> <div class="product_name"> <a href="/product/' + value.url + '" class="home-tile-title-h price-tile"> ' + name + ' </a> </div> <div class="home-tile-price"> <p class="home-tile-price-rs">Rs. <span class="home-tile-price">' + price + '</span></p><div class="product-price"> ' + unitP + ' </div></div> <div class="option-btn" style="display:none"> <button class="option-btn-1"><i class="fas fa-heart"></i></button> <button class="option-btn-2"><i class="fas fa-cart-plus"></i></button> </div> <div class="by-now-btn"> <button>Buy Now</button> </div> </div></div>  </div> ';
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

                x.innerHTML += '<div class="search-tile-hr"><div class="row search-tile-body search-product menu-product"><div class="col-md-c-3"> ' + discount + '' + stock + '<div class="image-container"><a href="/product/' + value.url + '"><img src="/' + image + '"  alt="' + imageAlt + '" class="home-tile-img p-0"></a></div><div class="product-rating-div-search"><i class="fas fa-star rating-star-icon"></i><span class="rating-value">(' + rating + ')</span></div></div><div class="home-tile-title col-md-7"><a href="/product/' + value.url + '" class="home-tile-title-h price-tile">' + name + '</a><div class="product-desc"><div class="shor-desc">' + value.short_desc + '</div><div class="long-desc">' + long_desc + '</div></div><div class="shop-name"></div><div class="district-city"></div></div><div class="col-md-c-2  text-center"><div class="home-tile-price pt-10"><p class="home-tile-price-rs">Rs. <span class="home-tile-price">' + price + '</span></p><div class="product-price">' + unitP + '</div></div><div class="option-btn" style="display:none;"><button style="margin: 0px 8px 0px 7px;"><i class="fas fa-heart"></i></button><button style="margin: 0px 5px 0px 10px"><i class="fas fa-cart-plus"></i></button></div><div class="by-now-btn"><button>Buy Now</button></div></div></div></div>';
            });
            $('#product-menu').append(x);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>
    <script src="{{ asset('js/store.js') }}" defer></script>

    @endsection