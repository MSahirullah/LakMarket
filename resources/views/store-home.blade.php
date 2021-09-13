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
                    <div class="store-name">
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
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search in Shop">
                            <div class=" input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search" style="padding-right: 5px;"></i>Search
                                </button>
                            </div>
                        </div>
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


    <div class="container" style="padding-top:18px;">

        <div class="search-result">
            <div class="row">
                <div class="filter-col">
                    <div class="filter-item mt-0">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Sort By :</p>
                            <span class="nav-item dropdown sort-filter">
                                <i class="fas fa-chevron-down down-btn"></i>
                                <select class="selectpicker sort-filter-select">
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

                    <div class="filter-item">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Price :</p>
                            <div class="filter-price">
                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="priceFrom" maxlength="7">
                                <span class="filter-price-dash">-</span>
                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="priceTo" maxlength="7">

                                <button class="filter-btn-1"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="filter-item-body text-center">
                            <button class="filter-btn-1 btn-2"> <i class="fas fa-trash"></i>Clear All Filters</i></button>
                        </div>
                    </div>

                    <div class="filter-item" style="border-bottom:unset;">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Shop Categories</p>
                            <div class="filter-related-cato">
                                <li class="f-r-c-li-i"> <i class="fas fa-chevron-right"></i> <a href="#">Cato 01</a></li>
                                <li class="f-r-c-li-i"> <i class="fas fa-chevron-right"></i> <a href="#">Cato 02</a></li>
                                <li class="f-r-c-li-i"> <i class="fas fa-chevron-right"></i> <a href="#">Cato 03</a></li>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="result-col">
                    <div class="result-count">
                        <div>
                            <h5> <b><span>3550</span></b> Products in <b>"<span>Jayanthi Bookshop</span>"</b></h5>
                        </div>
                        <div class="view-buttons">
                            <span>View: </span>
                            <button class="tile-view-btn"><i class="fas fa-th-large view-button-selected"></i></button>
                            <button class="list-view-btn"><i class="fas fa-th-list"></i></button>
                        </div>
                    </div>
                    <div class="h-line">
                    </div>
                    <div class="search-tile-product-div">
                        @for ($i = 0; $i < 12; $i++) <div class="search-tile">
                            <div class="search-tile-body search-product">
                                <div class="discount-wrapper">
                                    <div class="discount-text">
                                        <span class="discount-amount">-99</span>
                                        <span class="discount-sign">%</span>
                                        <span class="discount-off">Off</span>
                                    </div>
                                    <img class="discount-img" src="img/discount-wrapper.png" alt="discount">
                                </div>
                                <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img p-0">
                                <div class="product-rating-div-search">
                                    <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                                </div>
                                <div class="home-tile-title text-center">
                                    <a href="#" class="home-tile-title-h price-tile">Google Home Voice...</a>
                                    <div class="home-tile-price">
                                        <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                                        <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span></p>
                                    </div>
                                    <div class="option-btn" style="display:none">
                                        <button class="option-btn-1"><i class="fas fa-heart"></i></button>
                                        <button class="option-btn-2"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                    <div class="by-now-btn">
                                        <button>Buy Now</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endfor
                </div>


                <div class="search-tile-product-div-hr" style="display:none;">
                    @for ($i = 0; $i < 6; $i++) <div class="search-tile-hr">
                        <div class="row search-tile-body search-product">
                            <div class="col-md-c-3">
                                <div class="discount-wrapper">
                                    <div class="discount-text">
                                        <span class="discount-amount">-99</span>
                                        <span class="discount-sign">%</span>
                                        <span class="discount-off">Off</span>
                                    </div>
                                    <img class="discount-img" src="img/discount-wrapper.png" alt="discount">
                                </div>
                                <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img p-0">

                                <div class="product-rating-div-search">
                                    <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                                </div>
                            </div>
                            <div class="home-tile-title col-md-7">
                                <a href="#" class="home-tile-title-h price-tile">Google Home Mini – Smart Speaker with Google Assistant</a>
                                <div class="shor-desc">1/2/3/4 gang TUYA WiFi Smart Touch Switch 220-240V Home Wall Button for Alexa and Google Home Assistant EU Standard.</div>
                                <div class="long-desc">No Neutral Line required. Wi-Fi direct connection. APP remote control. Link with other smart devices Support voice speaker control.</div>

                                <div class="shop-name">

                                </div>

                                <div class="district-city">

                                </div>

                            </div>
                            <div class="col-md-c-2  text-center">
                                <div class="home-tile-price" style="padding-top: 7px;">
                                    <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                                    <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span></p>
                                </div>
                                <div class="option-btn" style="display:none;">
                                    <button style="margin: 0px 8px 0px 6px;"><i class="fas fa-heart"></i></button>
                                    <button style="margin: 0px 5px 0px 7px"><i class="fas fa-cart-plus"></i></button>
                                </div>
                                <div class="by-now-btn">
                                    <button>Buy Now</button>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>
<script src="{{ asset('js/store.js') }}" defer></script>
@endsection