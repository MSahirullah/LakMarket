<div class="header" id="header" data="{{(Request::route()->getName())}}">
    <nav class="navbar navbar-expand-lg navbar-light bg-light header-1">
        @if(Session::has('status'))
        <div id="status" dataMSG="{{Session::get('status')[1]}}" dataID="{{Session::get('status')[0]}}"></div>
        @endif
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <div class="nav-item">

                    <a class="nav-link a-nav-link" href="#"><i class="fas fa-mobile-alt"></i>Get The Mobile App</a>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link a-nav-link" href="{{route('about')}}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a-nav-link" href="{{ route('customer-care') }}">Customer Care</a>
                    </li>
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link a-nav-link" href="{{ route('login') }}">Sign In</a>
                    </li>
                    @endif
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link a-nav-link" href="{{ route('register') }}">Sign Up</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item">
                        @if((Session::has('customer')))
                        <form id=" logout-form" action="{{route('logout')}}" method="POST">
                            @csrf
                    <li class="nav-item dropdown p-0 logged-user">
                        <a class="nav-link dropdown-toggle a-nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Session::get('customer')['first_name']}}'s Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item f-upp" href="#"><i class="fas fa-user-circle"></i> My Account</a>
                            <div class="dropdown-divider"></div>
                            <button type="submit" class="dropdown-item " href="#"><i class="fas fa-box"></i> My Orders</button>
                            <div class="dropdown-divider"></div>
                            <button type="submit" class="dropdown-item " href="#"><i class="fas fa-sign-out-alt"></i> Logout</button>

                        </div>
                    </li>
                    </form>
                    @endif
                    </li>
                    @endguest
                    <li class=" nav-item">
                        <a class="nav-link a-nav-link become-a-seller" href="{{route('seller.register')}}">Become A Seller</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="fixed-header">
        <nav class="navbar navbar-light bg-light header-2">
            <div class="container">

                <a class="navbar-brand" href="/">
                    <img src="/img/weblogo_1.png" class="header-img" alt="LAK MARKET LOGO">
                </a>

                <div class="nav-search">
                    <span id="searchCato" data-cato="{{Session::has('searchCato')?Session::get('searchCato'):''}}"></span>
                    <form autocomplete="off" action="{{route('search')}}" class="nav justify-content-cente">
                        <span class="nav-item dropdown search-bar ">

                            <input type="text" class=" typeahead form-control search-input" name="q" id="searchP" placeholder="Search..." onClick="this.select();" value="{{ app('request')->input('q') }}" data-q="{{Session::has('query') ? Session::get('query') : ''}}" aria-label="Search" />
                            <select class=" selectpicker select-cato f-cpt" id="select-search-cato" name='category'>
                                <option value='All Categories' selected>All Categories</option>
                                <option value='Pharmacies'>Pharmacies</option>
                                <option value='Book Shops'>Book Shops</option>
                                <option value='Computer Shops'>Computer Shops</option>
                                <option value='Mobile Phone Shops'>Mobile Phone Shops</option>
                                <option value='Bags & Footwear Shops'>Bags & Footwear Shops</option>
                                <option value='Electronic Shops'>Electronic Shops</option>
                                <option value='Toys Shops'>Toys Shops</option>
                                <option value='Sports Shops'>Sports Shops</option>
                            </select>

                        </span>

                        <button type="button" class="search-btn"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
                        <button type="hidden" id='searchSubmitBtn' style='display:none'></button>
                    </form>
                </div>

                <div class="cart-div">
                    @if ((Session::has('customer')))

                    <a href="{{route('cart')}}" class="customer-cart ">
                        @endif
                        <div class="cart">
                            <span class="left-border"></span>
                            <img src="/img/cart-icon.png" alt="Cart Icon" class="cart-icon">
                            <span class="cart-count">0</span>
                        </div>
                        @if ((Session::has('customer')))
                    </a>
                    <div class="cart-block ">
                        <div class="cart-block-content">
                            <div class="cart-title">
                                <h5><span>2</span> items in my cart </h5>
                            </div>
                            <div class="cart-list">
                                <ul class="my_cart_summery">
                                    <li class="product-info">
                                        <div class="p-left">
                                            <a href="#">
                                                <img class="img-responsive" src="https://bigdeals.lk/uploads/thumbs/appip12mgjg3zpalarge.jpg" alt="p10">
                                            </a>
                                        </div>
                                        <div class="p-right">
                                            <p class="p-name">iPhone 12 - Black 256GB</p>
                                            <p class="p-price">Rs 270,999</p>
                                            <p class="p-qty">Qty: 1<span><a href="#" onclick="deleteItem(101745)" class="product-delete" data-id="64"><i class="fa fa-trash-o pull-right cart-delete"></i></a></span></p>
                                        </div>
                                    </li>
                                    <li class="product-info">
                                        <div class="p-left"><a href="#"><img class="img-responsive" src="https://bigdeals.lk/uploads/thumbs/appip12pmgd83zpalarge.jpg" alt="p10"></a></div>
                                        <div class="p-right">
                                            <p class="p-name">Apple Iphone 12 Max Silver 128GB</p>
                                            <p class="p-price">Rs 309,999</p>
                                            <p class="p-qty">Qty: 1<span><a href="#" onclick="deleteItem(101744)" class="product-delete" data-id="64"><i class="fa fa-trash-o pull-right cart-delete"></i></a></span></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="total-cart">
                                <span class="total-price">Total</span>
                                <span class="total-price pull-right total-price-span">Rs <span id="my_cart_total_price">580,998</span></span>
                            </div>
                            <div class="cart-buttons">
                                <a href="https://bigdeals.lk/cart/order/summery" class="btn-check-out"><button> Checkout </button></a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div>
                    </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light header-1 header-3">
            <div class="container pl-0">
                <ul class="navbar-nav">
                    <li class="nav-item" id="logo-hider" style="display:none;">
                        <a class="navbar-brand" href="#">
                            <img src="/img/weblogo_2.png" class="header-img-2" alt="LAK MARKET LOGO">
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link a-link-2" href="/">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    @if (Request::route()->getName() != 'home')
                    <li class="nav-item cato-drop-down cato-link ">
                        <span class="nav-link a-link-2 " href="#">CATEGORIES
                            <i class="fas fa-chevron-down cato-icon"></i>
                            <i class="fas fa-chevron-up cato-icon" style="display:none;"></i>

                            <div class="cato-list" id="cato-list-all" style="display:none;">
                                <div class="cato-item">
                                    <a href="/category/pharmacies" class="card-link cato-card-catos fs-13"><i class="fas fa-pills cato-card-item-icon"></i> Pharmacies</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/book-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-pencil-ruler cato-card-item-icon"></i> Book Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/computer-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-laptop cato-card-item-icon"></i> Computer Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/mobile-phone-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-mobile-alt cato-card-item-icon"></i> Mobile Phone Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/bags-and-footwear-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-suitcase-rolling cato-card-item-icon"></i> Bags & Footwear Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/electronic-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-camera-retro cato-card-item-icon"></i> Electronic Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/toys-shop" class="card-link cato-card-catos fs-13"><i class="fab fa-waze cato-card-item-icon" style="font-size:14px"></i> Toys Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="/category/sports-shops" class="card-link cato-card-catos fs-13"><i class="fas fa-table-tennis cato-card-item-icon"></i> Sports Shops</a>
                                </div>
                            </div>
                        </span>


                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link a-link-2" href="#">WISHLIST <img src="/img/wishlist-icon.png" alt="Wishlist Icon" class="wishlist-icon"></a>
                    </li>
                </ul>

                <div class="nav-item dropdown city-wapper">
                    <input type="text" id="CityInputTxt" class="form-control city-input" placeholder="All Provinces" value="{{Session::has('customer-city')?Session::get('customer-city')['0']:'All of Sri Lanka'}}" READONLY aria-label="Location">
                    <span id="locationData" data-pro="{{Session::has('customer-city')?Session::get('customer-city')['2'][0]:'All of Sri Lanka'}}" data-dis="{{Session::has('customer-city')?Session::get('customer-city')['2'][1]:'All Districts'}}" data-cit="{{Session::has('customer-city')?Session::get('customer-city')['2'][2]:'All Cities'}}"></span>



                    <i class="fa fa-map-marker-alt city-icon" aria-hidden="true"></i>
                    <i class="fa fa-angle-down city-angle-icon" id='city-angle-icon' aria-hidden="true"></i>


                    <div class="location-select-div">
                        <div class="row">
                            <div class="col-cus province">
                                <label for="provinceS">{{ __('Province') }} </label>

                                <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="provinceS" id="provinceS" placeholder="All Provinces" />
                                <i class="fa fa-angle-down reg-angle-icon provinceS-icon" aria-hidden="true"></i>

                            </div>
                            <div class="col-cus district">
                                <label for="districtS">{{ __('District') }} </label>

                                <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="districtS" id="districtS" placeholder="All Districts" />
                                <i class="fa fa-angle-down reg-angle-icon districtS-icon" aria-hidden="true"></i>

                            </div>
                            <div class="col-cus city">
                                <label for="cityS">{{ __('City') }} </label>
                                <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="cityS" id="cityS" placeholder="All Cities" />
                                <i class="fa fa-angle-down reg-angle-icon cityS-icon" aria-hidden="true"></i><br>

                            </div>

                            <div class="col-cus-2">
                                <div><i class="fas fa-times btn-close"></i></div>
                                @if ((Session::has('customer')))
                                <div><i class="fas fa-home btn-home"></i></div>
                                @endif
                                <button class="btn-locate"><i class="fas fa-map-marker-alt"></i></button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </nav>


    </div>
</div>