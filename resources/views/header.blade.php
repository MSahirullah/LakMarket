<div class="header" id="header" data="{{(Request::route()->getName())}}">
    <nav class="navbar navbar-expand-lg navbar-light bg-light header-1">
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
                        <a class="nav-link a-nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a>
                        <form id=" logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </li>
                    @endguest
                    <li class=" nav-item">
                        <a class="nav-link a-nav-link become-a-seller" href="#">Become A Seller</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="fixed-header">
        <nav class="navbar navbar-light bg-light header-2">
            <div class="container">

                <a class="navbar-brand" href="/">
                    <img src="img/weblogo_1.png" class="header-img" alt="LAK MARKET LOGO">
                </a>

                <div class="nav-search">
                    <form autocomplete="off" action="#" class="nav justify-content-cente">
                        <span class="nav-item dropdown search-bar ">
                            <input type="text" id="search-text" class="form-control search-input" placeholder="Search...">
                            <select class="selectpicker select-cato">
                                <option value="">Pharmacies</option>
                                <option value="">Staionary Shops</option>
                            </select>

                        </span>

                        <button type="submit" class="search-btn"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
                    </form>
                </div>


                <div class="cart">
                    <span class="left-border"></span>
                    <img src="img/cart-icon.png" alt="Cart Icon" class="cart-icon">
                    <span class="cart-count">0</span>
                </div>

            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light header-1 header-3">
            <div class="container pl-0">
                <ul class="navbar-nav">
                    <li class="nav-item" id="logo-hider" style="display:none;">
                        <a class="navbar-brand" href="#">
                            <img src="img/weblogo_2.png" class="header-img-2" alt="LAK MARKET LOGO">
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link a-link-2" href="#">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    @if (Request::route()->getName())
                    <li class="nav-item cato-link">
                        <span class="nav-link a-link-2 " href="#">CATEGORIES
                            <i class="fas fa-chevron-down cato-icon"></i>
                            <i class="fas fa-chevron-up cato-icon" style="display:none;"></i>

                            <div class="cato-list" style="display:none;">
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos"><i class="fas fa-pills cato-card-item-icon"></i> Pharmacies</a>
                                </div>
                                <div class="cato-item">
                                    <a href="#" class="card-link cato-card-catos"><i class="fas fa-pencil-ruler cato-card-item-icon"></i> Stationary Shops</a>
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
                        </span>


                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link a-link-2" href="#">WISHLIST <img src="img/wishlist-icon.png" alt="Wishlist Icon" class="wishlist-icon"></a>
                    </li>
                </ul>

                <span class="cart-2 {{(Request::route()->getName()) ? '':'nav-margin'}}" id="cart-hider" style="display:none;">
                    <span class="left-border-2"></span>
                    <img src="img/cart-icon-2.png" alt="Cart Icon" class="cart-icon-2">
                    <span class="cart-count-2">0</span>
                </span>

                <div class="nav-item dropdown city-wapper">
                    <input type="text" id="CityInputTxt" class="form-control city-input" placeholder="All Cities">
                    <i class="fa fa-map-marker-alt city-icon" aria-hidden="true"></i>
                    <i class="fa fa-angle-down city-angle-icon" aria-hidden="true"></i>
                </div>

            </div>
        </nav>
    </div>
</div>