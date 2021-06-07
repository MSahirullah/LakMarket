@extends('layouts.app')

@section('content')

{{View::make('store-header')}}

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
                                <a href="#">Jayanthi Electronics</a>
                            </div>

                            <div class="district-city">
                                <span class="district">Kegalle</span>
                                <span">,</span>
                                    <span class="city">Mawanella</span>
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

@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>
<script src="{{ asset('js/store.js') }}" defer></script>
@endsection