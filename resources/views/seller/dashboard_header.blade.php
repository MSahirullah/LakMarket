<div class="wrapper">
    <div id="bodyContent">
        <span id="collapseStatus"></span>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light navbar-custom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="sideBarToggle" data-widget="pushmenu" href="#" role="button" data-toggle-status = {{request()->cookie('valSideBar')}} onclick="ocMiniSideMenu()"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/seller/dashboard" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item dashboard-home-search">
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control shadow-none input-search-box" type="text" placeholder="Search" aria-label="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-navbar home-search-submit" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">7</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">7 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/seller/logout">Log Out
                        <i class="fas fa-sign-out-alt na-sign-out-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 {{ request()->cookie('valSideBar')==0 ? '' : 'menu-collapse' }}" id="sideMenu">
            <!-- Brand Logo -->
            <a href="/seller/dashboard" class="brand-link">
                <img src="/img/dashboard-logo.png" alt="LAK MARKETLogo" class="brand-image" style="opacity: 0.8" />
                <span class="brand-text font-weight-light">Lak Market</span>
            </a>

            <span id="seller-name" data-name='{{Session::get('sellerName')}}' data-image='{{Session::get('sellerImage')}}'></span>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 d-flex">
                    <div class="image">
                        <img src="" class="elevation-2" alt="User Image" id="user-profile-photo" />
                    </div>
                    <div class="info">
                        <a href="/seller/dashboard" class="online-seller-name"></a><br>
                        <span class="online-status"></span>
                        <span class="online-status-seller">Seller</span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">

                        <li class="nav-item">
                            <a href="{{route('seller.dashboard')}}" class="nav-link" id="sidebarMenuDashboard">
                                <i class=" nav-icon fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('seller.profile')}}" class="nav-link" id="sidebarMenuProfile">
                                <i class="nav-icon fas fa-store"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('product.list')}}" class="nav-link" id="sidebarMenuProducts">
                                <i class="nav-icon fas fa-shopping-basket"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('category.list')}}" class="nav-link" id="sidebarMenuCatagories">
                                <i class="nav-icon fas fa-copy"></i>
                                <span>Catagories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('stock.list')}}" class="nav-link" id="sidebarMenuStocks">
                                <i class="nav-icon fas fa-cart-arrow-down"></i>
                                <span>Stock</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('orders.list')}}" class="nav-link" id="sidebarMenuOrders">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('discounts.list')}}" class="nav-link" id="sidebarMenuDiscounts">
                                <i class="nav-icon fas fa-percent"></i>
                                <span>Discounts</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('newsletter.requests')}}" class="nav-link" id="sidebarMenuNewsLetters">
                                <i class="nav-icon fas fa-envelope-open-text"></i>
                                <span>News Letters</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</div>