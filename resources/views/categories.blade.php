@extends('layouts.app')

@section('content')
<div class="site-wrapper">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="#">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">Book Shops</a>
    </div>
    <div class="site-container container">

        <div class="search-result">
            <div class="row">
                <div class="filter-col">


                    <div class="filter-item mt-0">
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

                    <div class="filter-item" style="border-bottom:unset;">
                        <div class="filter-item-body">
                            <p class="filter-title-text">Sub Categories</p>
                            <div class="filter-related-cato">
                                <li class="f-r-c-li-i selected-c"> <i class="fas fa-chevron-right"></i> <a class="selected-c" href="#">Cato 01</a></li>
                                <li class="f-r-c-li-ii"> <a href="#">Cato 01-01</a></li>
                                <li class="f-r-c-li-ii"><a href="#">Cato 01-02</a></li>
                                <li class="f-r-c-li-ii"><a href="#">Cato 01-03</a></li>
                                <li class="f-r-c-li-ii"><a href="#">Cato 01-04</a></li>
                                <li class="f-r-c-li-ii"><a href="#">Cato 01-05</a></li>
                                <li class="f-r-c-li-ii"><a href="#">Cato 01-06</a></li>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="result-col">
                    <div class="result-count">
                        <div>
                            <h5> <b><span>3550</span></b> Shops found in <b>"<span>Book Shops</span>"</b></h5>
                        </div>
                    </div>
                    <div class="h-line">
                    </div>

                    <div class="search-tile-title">
                        <h4>Shops for "<span>Book Shops</span>"</h4>
                    </div>
                    <div class="search-tile-product-div">
                        @for ($i = 0; $i <21; $i++) <div class="category-tile">
                            <div class="search-tile-body category-shops">
                                <img src="https://i.picsum.photos/id/180/200/300.jpg?hmac=EC8Kweq0GgryGedfHPQFsFTXsZ8NgHaYU5ZnhoGkPLA" alt="Alt text" class="home-tile-img home-tile-shop-img">
                                <div class="home-tile-title">
                                    <a href="#" class="home-tile-title-h">Jayanthi Bookshop</a>
                                    <p class="home-tile-title-p">Mawanella</p>
                                    <div class="home-tile-rating">
                                        <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                                    </div>
                                </div>
                                <div class="search-tile-button">
                                    <a href="#" class="search-tile-visit"><i class="fas fa-shopping-cart shop-icon"></i>Show Now</a>
                                    <a href="#" class="search-tile-get-direction"><i class="fas fa-directions direction-icon"></i>Get Direction</a>
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
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/categories.js') }}" defer></script>
@endsection