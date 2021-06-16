@extends('layouts.app')

@section('content')

<div class="site-wrapper">
    <div class="container site-container pr-0 pl-0 pt-16">
        <div class="slider-cato">
            <div class="cato">
                <div class="card cato-card" style="width: 100%;">
                    <div class="card-body cato-card-body">
                        <div class="cato-title">
                            <i class="fas fa-list cato-card-icon"></i>
                            <h5 class="cato-card-title">Categories</h5>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-pills cato-card-item-icon"></i> Pharmacies</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-pencil-ruler cato-card-item-icon"></i> Book Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-laptop cato-card-item-icon"></i> Computer Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-mobile-alt cato-card-item-icon"></i> Mobile Phone Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-suitcase-rolling cato-card-item-icon"></i> Bags & Footwear Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-camera-retro cato-card-item-icon"></i> Electronic Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fab fa-waze cato-card-item-icon" style="font-size:14px"></i> Toys Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="#" class="card-link cato-card-catos"><i class="fas fa-table-tennis cato-card-item-icon"></i> Sports Shops</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider">
                <div id="add-slider" class="carousel slide add-slider" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#add-slider" data-slide-to="0" class="active"></li>
                        <li data-target="#add-slider" data-slide-to="1"></li>
                        <li data-target="#add-slider" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div align="center"><a class="shop-now-btn" href="#">Shop Now</a></div>
                            <img class="d-block slider-img" src="https://i.picsum.photos/id/198/200/200.jpg?hmac=3UdulfE9DTCNBECOusB2ignsI8T-XhkGI-M0P2BMJm8" alt="First slide">

                        </div>
                        <div class="carousel-item ">
                            <div align="center"><a class="shop-now-btn" href="#">Shop Now</a></div>
                            <img class="d-block slider-img" src="https://i.picsum.photos/id/403/200/200.jpg?hmac=GkAppJlJ6MSNvKNo7Hj3Z_I3QTbiwzOtyOJbh6jcZ0U" alt="Second slide">
                        </div>
                        <div class="carousel-item ">
                            <div align="center"><a class="shop-now-btn" href="#">Shop Now</a></div>
                            <img class="d-block slider-img" src="https://i.picsum.photos/id/803/200/200.jpg?hmac=bVMK2xFyXtTrgCuUIozDz-mYxDZuDYFh-C_1LHZDKL4" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#add-slider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#add-slider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="site-q">
        <div class="container text-center">
            <div class="row" style="padding: 20px 0px;">
                <div class="col-lg-4 site-q-col">
                    <i class="fas fa-hand-holding-usd site-q-icon"></i>
                    <div class="site-q-text-area">
                        <h5>Shop with confidence</h5>
                        <p>Original quality and affordable prices</p>
                    </div>
                </div>
                <div class="col-lg-4 site-q-col">
                    <i class="fas fa-credit-card site-q-icon"></i>
                    <div class="site-q-text-area">
                        <h5>Safe Payment</h5>
                        <p>100% secure payment</p>
                    </div>
                </div>
                <div class="col-lg-4 site-q-col">
                    <i class="far fa-comments site-q-icon"></i>
                    <div class="site-q-text-area">
                        <h5>24/7 Online Support</h5>
                        <p>24/7 365 days customer care support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pl-0 pr-0">
        <!-- Home Body -->
        <div class="wrapper">

            <!-- Home Flash Deals -->
            <div class="wrapper-div div-fade">
                <div class="item-div">
                    <div>
                        <i class="fas fa-bolt top-star-icon flash-deals"></i>
                        <h4 class="home-title">Flash Deals Of The Day</h4>
                    </div>
                    <div class="text-right h-view-div">
                        <a class="h-view margin-b-ls mr-0" data-id="" data-code="" title="view-all" href="#">
                            View All
                            <i class="fas fa-angle-right item-div-icon"></i>
                        </a>
                    </div>
                </div>

                <div class="row home-tile-div owl-carousel owl-theme owl-c-6">
                    @for ($i = 0; $i < 5; $i++) <div class="col-md home-tile">
                        <div class="home-tile-body home-product">
                            <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img  ">
                            <div class="product-rating-div">
                                <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                            </div>
                            <div class="home-tile-title text-center">
                                <a href="#" class="home-tile-title-h price-tile">Google Home Voice...</a>
                                <div class="home-tile-price">
                                    <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                                    <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span><span class="home-tile-d-value">-12%</span></p>
                                </div>
                                <div class="option-btn" style="display: none;">
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
        </div>


        <div id="cato_slider" class="carousel slide carousel-fade" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#cato_slider" data-slide-to="0" class="active"></li>
                <li data-target="#cato_slider" data-slide-to="1"></li>
                <li data-target="#cato_slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner cato-slider-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-3.png" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#cato_slider" role="button" data-slide="prev" style="margin: -25px;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#cato_slider" role="button" data-slide="next" style="margin: -25px;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


    <!-- Home Top Rated Products -->
    <div class="wrapper-div div-fade m-0">
        <div class="item-div">
            <div>
                <i class="fas fa-shopping-basket top-star-icon"></i>
                <h4 class="home-title">Top Rated Products</h4>
            </div>
            <div class="text-right h-view-div">
                <a class="h-view margin-b-ls mr-0" data-id="" data-code="" title="view-all" href="#">
                    View All
                    <i class="fas fa-angle-right item-div-icon"></i>
                </a>
            </div>
        </div>


        <div class="row home-tile-div" style="padding-bottom: 7px !important;">
            <div class="col-md-6 t-r-p" style="padding-right:7.5px;">
                <div class="t-r-p-title">
                    <h4>Local Products</h4>
                </div>
                <div class="row m-0 owl-carousel owl-theme owl-c-3-1">
                    @for ($i = 0; $i < 3; $i++) <div class="col-md home-tile ">
                        <div class="home-tile-body home-product t-r-p-tile">
                            <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img t-r-p-img">
                            <div class="product-rating-div">
                                <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                            </div>
                            <div class="home-tile-title text-center">
                                <a href="#" class="home-tile-title-h price-tile">Google Home Voice...</a>
                                <div class="home-tile-price">
                                    <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                                    <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span><span class="home-tile-d-value">-12%</span></p>
                                </div>
                                <div class="option-btn" style="display: none;">
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
        </div>

        <div class="col-md-6 t-r-p" style="padding-left:7.5px;">

            <div class="t-r-p-title">
                <h4>International Products</h4>
            </div>
            <div class="row m-0 owl-carousel owl-theme owl-c-3-2">
                @for ($i = 0; $i < 3; $i++) <div class="col-md home-tile">
                    <div class="home-tile-body home-product t-r-p-tile">
                        <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img t-r-p-img">
                        <div class="product-rating-div">
                            <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                        </div>
                        <div class="home-tile-title text-center">
                            <a href="#" class="home-tile-title-h price-tile">Google Home Voice...</a>
                            <div class="home-tile-price">
                                <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                                <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span><span class="home-tile-d-value">-12%</span></p>
                            </div>
                            <div class="option-btn" style="display: none;">
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
    </div>

</div>

</div>

<!-- Home Shop Adertisments -->
<div class="wrapper-div div-fade home-add-div">
    <div class="row home-add">
        <div class="col-md home-add-shop">
            <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-add-shop-img">
        </div>

        <div class="col-md home-add-shop">
            <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-add-shop-img">
        </div>

        <div class="col-md home-add-shop">
            <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-add-shop-img">
        </div>
    </div>
</div>



<!-- Home Top Rated Shop -->
<div class="wrapper-div div-fade">
    <div class="item-div">
        <div>
            <i class="fas fa-store top-star-icon"></i>
            <h4 class="home-title">Top Rated Shops</h4>
        </div>
        <div class="text-right h-view-div">
            <a class="h-view margin-b-ls mr-0" data-id="" data-code="" title="view-all" href="#">
                View All
                <i class="fas fa-angle-right item-div-icon"></i>
            </a>
        </div>
    </div>

    <div class="row home-tile-div owl-carousel owl-theme owl-c-4" style="padding-bottom: 13px !important;">
        @for ($i = 0; $i < 4; $i++) <div class="col-md home-tile">
            <div class="home-tile-body">
                <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img home-tile-shop-img">
                <div class="home-tile-title">
                    <a href="#" class="home-tile-title-h">Jayanthi Bookshop</a>
                    <p class="home-tile-title-p">Mawanella</p>
                    <div class="home-tile-rating">
                        <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                    </div>
                </div>
                <div class="home-tile-button">
                    <a href="#" class="home-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Shop Now</a>
                    <a href="#" class="home-tile-get-direction"><i class="fas fa-directions direction-icon"></i>Get Direction</a>
                </div>
            </div>
    </div>
    @endfor
</div>
</div>

<!-- Recommended For You -->
<div class="rec-f-div">
    <div class="rec-f-head">
        <div class="rec-line-t"></div>
        <h4><span class="rec-line-t-text">Recommended For You</span></h4>
        <div class="rec-line-t"></div>
    </div>

    <div class="h-tile-product-div">
        @for ($i = 0; $i < 15; $i++) <div class="p-h-i-r">
            <div class="home-tile-body search-product">
                <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img p-0">
                <div class="product-rating-div">
                    <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                </div>
                <div class="home-tile-title text-center">
                    <a href="#" class="home-tile-title-h price-tile">Google Home Voice...</a>
                    <div class="home-tile-price">
                        <p class="home-tile-price-rs">Rs. <span class="home-tile-price">10500.00</span></p>
                        <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">10500.00</span><span class="home-tile-d-value">-12%</span></p>
                    </div>
                    <div class="option-btn" style="display: none;">
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

@endsection

@section('scripts')

<script src="{{ asset('js/home.js') }}" defer></script>
<script type="text/javascript">
    $(document).ready(function() {

        var path = "{{ route('customer.search') }}";
        $('input.typeahead').typeahead({
            source: function(query, process) {
                return $.get(path, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    });
</script>

@endsection