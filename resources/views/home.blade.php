@extends('layouts.app')

@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection

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
                            <a href="/category/pharmacies" class="card-link cato-card-catos"><i class="fas fa-pills cato-card-item-icon"></i> Pharmacies</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/book-shops" class="card-link cato-card-catos"><i class="fas fa-pencil-ruler cato-card-item-icon"></i> Book Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/computer-shops" class="card-link cato-card-catos"><i class="fas fa-laptop cato-card-item-icon"></i> Computer Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/mobile-phone-shops" class="card-link cato-card-catos"><i class="fas fa-mobile-alt cato-card-item-icon"></i> Mobile Phone Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/bags-and-footwear-shops" class="card-link cato-card-catos"><i class="fas fa-suitcase-rolling cato-card-item-icon"></i> Bags & Footwear Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/electronic-shops" class="card-link cato-card-catos"><i class="fas fa-camera-retro cato-card-item-icon"></i> Electronic Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/toys-shop" class="card-link cato-card-catos"><i class="fab fa-waze cato-card-item-icon" style="font-size:14px"></i> Toys Shops</a>
                        </div>
                        <div class="cato-item">
                            <a href="/category/sports-shops" class="card-link cato-card-catos"><i class="fas fa-table-tennis cato-card-item-icon"></i> Sports Shops</a>
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
                        <li data-target="#add-slider" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block slider-img" src="\img\add\1.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block slider-img" src="\img\add\2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block slider-img" src="\img\add\3.jpg" alt="Third slide">
                        </div>
                        <div class="carousel-item ">
                            <img class="d-block slider-img" src="\img\add\4.jpg" alt="Forth slide">
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
            <div class="row" style="padding: 25px 0px;">
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

    <div class="container pl-0 pr-0 home-p">
        <!-- Home Body -->
        <div class="wrapper">

            <!-- Home Flash Deals -->
            <div class="wrapper-div div-fade">
                <div class="item-div">
                    <div>
                        <i class="fas fa-bolt top-star-icon flash-deals"></i>
                        <h4 class="home-title">Flash Deals Of The Day</h4>
                    </div>
                    @if(sizeof($flashD))
                    <div class="text-right h-view-div">
                        <a class="h-view margin-b-ls mr-0" title="shop-more" href="{{route('flash.deals')}}">
                            Shop More
                            <i class="fas fa-angle-right item-div-icon"></i>
                        </a>
                    </div>
                    @endif
                </div>

                @if(!sizeof($flashD))
                <div class="home-no-products">
                    <img src="/img/no-products.jpg" />
                    <h3>No Products For Today Flash Deals...</h3>

                </div>
                @else
                <div class="row home-tile-div {{sizeof($flashD) > 4 ? 'owl-carousel owl-theme owl-c-6' : 'owl-carousel owl-theme owl-c-6-ii'}}">
                    @foreach($flashD as $value)

                    <div class="col-md home-tile home-flashDeals">
                        <div class="home-tile-body home-product">
                            <div class="image">
                                <a href="/product/{{$value['url']}}"> <img src="{{$value['images']}}" alt="{{strlen($value['name']) > 10 ? substr($value['name'], 0 , 10).'...' : $value['name']}}" class="home-tile-img"></a>
                            </div>
                            <div class="product-rating-div">
                                <i class="fas fa-star rating-star-icon"></i><span class="rating-value">({{strlen($value['rating'])>1 ? $value['rating'] : $value['rating'].'.0'}})</span>
                            </div>
                            <div class="home-tile-title text-center">
                                <div class="name">
                                    <a href="/product/{{$value['url']}}" class="home-tile-title-h price-tile">{{strlen($value['name']) > 35 ? substr($value['name'], 0 , 35).'...' : $value['name']}}</a>
                                </div>
                                <div class="home-tile-price">
                                    <p class="home-tile-price-rs">Rs. <span class="home-tile-price">{{$value['discounted_price']}}</span></p>
                                    @if($value['discount'] != '0.00')
                                    <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">{{$value['unit_price']}}</span><span class="home-tile-d-value">-{{$value['discount']}}</span></p>
                                    @endif
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
                    @endforeach
                </div>
                @endif
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
                    <div class="carousel-item">
                        <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-4.png" alt="Fourth slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-5.png" alt="Fifth slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-6.png" alt="Sixth slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-7.png" alt="Seventh slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 cato-slider-img" src="\img\cato\cato-8.png" alt="Eighth slide">
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


        <!-- Home Top Rated Products-->
        <div class="wrapper-div div-fade top-rated-product">
            <div class="item-div">
                <div>
                    <i class="fas fa-bolt top-star-icon flash-deals"></i>
                    <h4 class="home-title">Top Rated Product</h4>
                </div>

                @if(sizeof($topRProducts))
                <div class="text-right h-view-div">
                    <a class="h-view margin-b-ls mr-0" title="shop-more" href="{{route('topRated.products')}}">
                        Shop More
                        <i class="fas fa-angle-right item-div-icon"></i>
                    </a>
                </div>
                @endif
            </div>

            @if(!sizeof($topRProducts))
            <div class="home-no-products">
                <img src="/img/no-products.jpg" />
                <h3>No Top Rated Products...</h3>

            </div>
            @else
            <div class="row home-tile-div {{sizeof($topRProducts) > 4 ? 'owl-carousel owl-theme owl-c-6' : 'owl-carousel owl-theme owl-c-6-ii'}}">
                @foreach($topRProducts as $value)

                <div class="col-md home-tile">
                    <div class="home-tile-body home-product">
                        <div class="image">
                            @if($value['type'] == "Imported Product")
                            <div class="ribbon ribbon-top-right rtr1"><span>Imported</span></div>
                            @elseif($value['type'] == "Local Product")
                            <div class="ribbon ribbon-top-right rtr2"><span>Local</span></div>
                            @endif
                            <a href="/product/{{$value['url']}}"> <img src="{{$value['images']}}" alt="{{strlen($value['name']) > 10 ? substr($value['name'], 0 , 10).'...' : $value['name']}}" class="home-tile-img"></a>
                        </div>
                        <div class="product-rating-div">
                            <i class="fas fa-star rating-star-icon"></i><span class="rating-value">({{strlen($value['rating'])>1 ? $value['rating'] : $value['rating'].'.0'}})</span>
                        </div>
                        <div class="home-tile-title text-center">
                            <div class="name">
                                <a href="/product/{{$value['url']}}" class="home-tile-title-h price-tile">{{strlen($value['name']) > 35 ? substr($value['name'], 0 , 35).'...' : $value['name']}}</a>
                            </div>
                            <div class="home-tile-price">
                                <p class="home-tile-price-rs">Rs. <span class="home-tile-price">{{$value['discounted_price']}}</span></p>
                                @if($value['discount'] != '0.00')
                                <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">{{$value['unit_price']}}</span><span class="home-tile-d-value">-{{$value['discount']}}</span></p>
                                @endif
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
                @endforeach
            </div>
            @endif
        </div>


        <!-- Home Shop Adertisments -->
        <div class="wrapper-div div-fade home-add-div">
            <div class="row home-add">
                <div class="col-md home-add-shop">
                    <img src="/img/home/1.jpg" alt="Lak-Market Banner" class="home-add-shop-img">
                </div>

                <div class="col-md home-add-shop">
                    <img src="/img/home/2.jpg" alt="Lak-Market Banner" class="home-add-shop-img">
                </div>

                <div class="col-md home-add-shop">
                    <img src="/img/home/3.jpg" alt="Lak-Market Banner" class="home-add-shop-img">
                </div>
            </div>
        </div>


        <!-- Home Top Rated Shop -->
        <div class="wrapper-div div-fade htps">
            <div class="item-div">
                <div>
                    <i class="fas fa-store top-star-icon"></i>
                    <h4 class="home-title">Top Rated Shops</h4>
                </div>
                <div class="text-right h-view-div">
                    <a class="h-view margin-b-ls mr-0" data-id="" data-code="" title="view-all" href="{{route('topRated.shops')}}">
                        View All
                        <i class="fas fa-angle-right item-div-icon"></i>
                    </a>
                </div>
            </div>

            @if(!sizeof($topRShops))
            <div class="home-no-products">
                <img src="/img/no-products.jpg" />
                <h3>No Top Rated Shops...</h3>

            </div>
            @else
            <div class="row home-tile-div {{sizeof($topRShops) > 4 ? 'owl-carousel owl-theme owl-c-4' : 'owl-carousel owl-theme owl-c-4-ii'}}">

                @foreach($topRShops as $store)
                <div class="col-md home-tile trshops-details">
                    <div class="home-tile-body">
                        <a target="_blank" href="/store/{{$store['url']}}"> <img src="{{$store['store_logo']}}" alt="{{strlen($store['store_name']) > 32 ? substr($store['store_name'], 0 , 32).'...' : $store['store_name']}}" class="home-tile-img home-tile-shop-img store-img"></a>
                        <div class="home-tile-title">
                            <a target="_blank" href="/store/{{$store['url']}}" class="home-tile-title-h">{{strlen($store['store_name']) > 32 ? substr($store['store_name'], 0 , 32).'...' : $store['store_name']}}</a>
                            <p class="home-tile-title-p">{{strlen($store['city'] . ', ' . $store['district'] . 'District') > 32 ? substr($store['city'] . ', ' . $store['district'] . 'District', 0 , 32).'...' : $store['city'] . ', ' . $store['district'] . ' District'}}
                            </p>
                            <div class="home-tile-rating">
                                <i class="fas fa-star rating-star-icon"></i><span class="rating-value">({{strlen($store['rating'])>1 ? $store['rating'] : $store['rating'].'.0'}})</span>
                            </div>
                        </div>
                        <div class="home-tile-button mb-5p">
                            <a target="_blank" href="/store/{{$store['url']}}" class="home-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Shop Now</a>
                            <a href="https://maps.google.com/?q={{$store['longitude'] . ',' . $store['latitude'] }}" target="_blank" class="home-tile-get-direction"><i class="fas fa-directions direction-icon"></i>Get Direction</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif
        </div>


        <!-- Recommended For You -->
        <div class="rec-f-div">
            <!-- <div class="rec-f-head">
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
    @endfor -->
        </div>

        @endsection

        @section('scripts')

        <script src="{{ asset('js/home.js') }}" defer></script>
        @endsection