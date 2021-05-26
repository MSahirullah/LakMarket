<div class="header_1 ">
    <nav class="navbar navbar-expand-lg navbar-light navbar-1">

        <!-- header image -->
        <img src="img/weblogo.png" class="header-img" alt="LAK MARKET LOGO">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup, #navbarNavAltMarkup1" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- navbar 1 search -->
        <form autocomplete="off" action="#"></form>
        <div class="nav-item dropdown search-bar">
            <input type="text" id="search-text" class="form-control search-input" placeholder="Search">
        </div>
        <button type="submit" class="search-btn"><i class="fa fa-search search-icon" aria-hidden="true"></i></button>
        </form>

        <!-- navbar 1 links -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-link nlink" href="#">HOME</a>
                <a class="nav-link nlink" href="#">ABOUT</a>
                <a class="nav-link nlink" href="customer-care">CUSTOMER CARE</a>

                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <a class="nav-link nlink" href="{{ route('login') }}">SIGN IN</a>
                @endif

                @if (Route::has('register'))
                <a class="nav-link nlink" href="{{ route('register') }}">SIGN UP</a>
                @endif
                @else
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">SIGN OUT</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endguest
                <a class="nav-link become-a-seller" href="#">BECOME A SELLER</a>
            </div>
        </div>

    </nav>
</div>

<div class="header_2">
    <nav class="navbar navbar-expand-lg navbar-light navbar-2">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

            <div class="navbar-nav ml-auto">
                <a class="nav-link align-middle nlink" href="#">WISHLIST

                    <span><img class="wishlist-icon" src="img/wishlist-icon.png" alt="wishlist-icon"></span></a>
                <a class="nav-link nlink" href="#">CART
                    <i class="fa fa-shopping-cart cart-icon" aria-hidden="true"></i>
                </a>

                <div class="nav-item dropdown city-wapper">
                    <input type="text" id="CityInputTxt" class="form-control city-input" placeholder="All Cities">
                    <i class="fa fa-map-marker-alt city-icon" aria-hidden="true"></i>
                    <i class="fa fa-angle-down city-angle-icon" aria-hidden="true"></i>
                </div>

            </div>
        </div>
    </nav>
</div>