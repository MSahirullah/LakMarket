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
                        <a class="nav-link a-nav-link" href="#">About</a>
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
                            <li class="nav-item dropdown p-0">
                                <a class="nav-link dropdown-toggle a-nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{Session::get('customer')['first_name']}}'s Account
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item f-upp" href="#">My Account</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="submit" class="dropdown-item " href="#">Logout</button>

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
                    <form autocomplete="off" action="#" class="nav justify-content-cente">
                        <span class="nav-item dropdown search-bar ">
                            <input type="text" id="search-text" class="form-control search-input" placeholder="Search...">
                            <select class="selectpicker select-cato f-cpt">
                                <option>Pharmacies</option>
                                <option>Book Shops</option>
                                <option>Computer Shops</option>
                                <option>Mobile Phone Shops</option>
                                <option>Bags & Footwear Shops</option>
                                <option>Electronic Shops</option>
                                <option>Toys Shops</option>
                                <option>Sports Shops</option>
                            </select>

                        </span>

                        <button type="submit" class="search-btn"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
                    </form>
                </div>


                <div class="cart">
                    <span class="left-border"></span>
                    <img src="/img/cart-icon.png" alt="Cart Icon" class="cart-icon">
                    <span class="cart-count">0</span>
                </div>

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

                            <div class="cato-list" style="display:none;">
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-pills cato-card-item-icon"></i> Pharmacies</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-pencil-ruler cato-card-item-icon"></i> Book Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-laptop cato-card-item-icon"></i> Computer Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-mobile-alt cato-card-item-icon"></i> Mobile Phone Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-suitcase-rolling cato-card-item-icon"></i> Bags & Footwear Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-camera-retro cato-card-item-icon"></i> Electronic Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fab fa-waze cato-card-item-icon" style="font-size:14px"></i> Toys Shops</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos fs-13"><i class="fas fa-table-tennis cato-card-item-icon"></i> Sports Shops</a>
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
                    <input type="text" id="CityInputTxt" class="form-control city-input" placeholder="All Cities">
                    <i class="fa fa-map-marker-alt city-icon" aria-hidden="true"></i>
                    <i class="fa fa-angle-down city-angle-icon" aria-hidden="true"></i>
                </div>

            </div>
        </nav>
    </div>
</div>