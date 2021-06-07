@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/normalize.css') }}">
<!-- <link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/foundation.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/demo.css') }}"> -->
<link rel="stylesheet" href="{{ URL::asset('/xzoom/dist/xzoom.css') }}">
@endsection


@section('content')

<div class="site-wrapper">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="#">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="#">Book Shops</a>
        <i class="fas fa-chevron-right"></i>
        <a href="#">Novels</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">Madol Duwa</a>
    </div>
    <div class="site-container container ">
        <div class="row bg-w">
            <div class="col-md-4  mt-15">
                <section id="lens">
                    <div class="row">
                        <div class="large-5 column">
                            <div class="xzoom-container">
                                <img class="xzoom3" src="/xzoom/xzoom/images/gallery/preview/01_b_car.jpg" xoriginal="/xzoom/xzoom/images/gallery/original/01_b_car.jpg" />
                                <div class="xzoom-thumbs">
                                    <a href="/xzoom/xzoom/images/gallery/original/01_b_car.jpg"><img class="xzoom-gallery3" width="70" src="/xzoom/xzoom/images/gallery/thumbs/01_b_car.jpg" xpreview="/xzoom/xzoom/images/gallery/preview/01_b_car.jpg"></a>
                                    <a href="/xzoom/xzoom/images/gallery/original/02_o_car.jpg"><img class="xzoom-gallery3" width="70" src="/xzoom/xzoom/images/gallery/preview/02_o_car.jpg"></a>
                                    <a href="/xzoom/xzoom/images/gallery/original/03_r_car.jpg"><img class="xzoom-gallery3" width="70" src="/xzoom/xzoom/images/gallery/preview/03_r_car.jpg"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-5 mt-15 pl-0 product-details-col">
                <div class="product-details-div">
                    <div class="product-name">
                        <h3> Google Home Voice Controller</h3>
                        <a href="#" class="p-cato">Novel</a>
                    </div>
                    <div class="product-ratings">
                        <div class="ratings">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="line-s">
                            |
                        </div>
                        <div class="rating-count">
                            <span>11 </span> ratings
                        </div>
                        <div class="line-s">
                            |
                        </div>
                        <div class="rating-add">
                            <a href="#">Add your review</a>
                        </div>
                    </div>

                    <div class="product-shortdesc">
                        In publishing and graphic design a Lorem ipsum a is a placeholder text commonly used to demonstrate the visual form of document a typeface without relying on the meaningful content form of a document.
                    </div>
                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-2">
                    <div class="product-price">
                        <span>Rs.</span>
                        <span>15000.00</span>
                    </div>
                    <div class="product-availability text-right">
                        <div>
                            <span class="percentage">15%</span>
                            <span>Off</span>
                        </div>

                        <div>
                            <span>Availability:</span>
                            <span class="stock">In Stock (3500 available)</span>
                        </div>
                    </div>
                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-3">
                    <div class="qty-input">
                        <label for="#qytInput">Qty : </label>
                        <input type="text" class="form-control qtyInput" name="qtyInput" pattern="[0-9]+" id="qtyInput" maxlength="3" required onkeypress="acceptOnlyNumber()" value="1">
                        <div class="inc-dic ">
                            <div class="increaser"><i class="fas fa-plus"></i></div>
                            <div class="dicreaser"><i class="fas fa-minus"></i></div>
                        </div>
                    </div>
                    <div class="product-cs">
                        <label for="#colorSelector">Color : </label>
                        <select class="selectpicker p-select" data-width="80px" id="colorSelector">
                            <option value="">Red</option>
                            <option value="">Blue</option>
                            <option value="">Black</option>
                        </select>
                    </div>

                    <div class="product-cs">
                        <label for="#sizeSelector">Size : </label>
                        <select class="selectpicker p-select" data-width="80px" id="sizeSelector">
                            <option value="">Small</option>
                            <option value="">Medium</option>
                            <option value="">Large</option>
                        </select>
                    </div>

                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-4">
                    <div class="product-btn">
                        <button class="add-to-cart-btn">Add to Cart</button>
                        <button class="buy-now">Buy Now</button>
                    </div>
                </div>

            </div>
            <div class="col-md-3 mt-15 pr-0">
                @for ($i = 0; $i < 3; $i++) <!-- text -->
                    <div class="related-products row ml-0">
                        <div class="product-image">
                            <img src="https://picsum.photos/200" alt="lorem ipsum" width="65">
                        </div>
                        <div class="r-p-details">
                            <h6>Google Home Voice</h6>
                            <div class="r-p-r">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="r-p-price">
                                Rs. 15000.00
                            </div>
                        </div>
                    </div>
                    @endfor

                    <div class="hr-line"></div>
                    <div class="seller-details">
                        <div class="sold-by">Sold by</div>
                        <a href="#">
                            <h6>Jayanthi Bookshop</h6>
                        </a>
                        <div class="city text-right"> Mawanella</div>
                        <div class="hr-line-2"></div>
                        <div class="pos-ratings"> Positive Seller Ratings </div>
                        <div class="pos-ratings-num">92<span class="prc">%</span></div>
                        <div class="product-btn p-b-2">
                            <button class="visit-store"><i class="fas fa-shopping-cart shop-icon" aria-hidden="true"></i>Visit Store</button>
                            <button class="get-direction"><i class="fas fa-location-arrow location-icon" aria-hidden="true"> </i> Get direction</button>
                        </div>
                    </div>

            </div>
        </div>

        <div class="row bg-w mt-10 prlt-15">
            <div class="pl-0 pr-0">
                <nav class="footer-tab">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="true">Reviews <span class="cr">(<span>50</span>)</span></a>
                        <a class="nav-link" id="nav-desc-tab" data-toggle="tab" href="#nav-desc" role="tab" aria-controls="nav-desc" aria-selected="false">Description</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        <div>
                            <div class="review-section">

                                <div>
                                    @for ($i = 0; $i < 5; $i++)<!-- text -->
                                        <div class="review-summery">
                                            <div class="star-summery">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="bar-summery">
                                                <div id="bar-5"></div>
                                            </div>
                                            <div class="reviews-count">
                                                100%
                                            </div>
                                        </div>
                                        @endfor
                                </div>

                                <div class="summery-final">
                                    <div class="result-div">
                                        <span class="result">5.0</span><span class="dash">/</span><span class="f">5.0</span>
                                    </div>
                                    <div class="text-right summery-star-final">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="summery-count">
                                        50 ratings
                                    </div>

                                </div>
                            </div>
                            <div class="hr-line mt-25"></div>
                            <div class="bg-white rounded pt-15 pb-0 p-4 mb-4 detailed-ratings-and-reviews">

                                <h5 class="mb-1 title">All Ratings and Reviews</h5>
                                <div class="reviews-members pt-4 pb-4">
                                    <div class="media">
                                        <a href="#"><img alt="Generic placeholder image" src="http://bootdey.com/img/Content/avatar/avatar1.png" class="mr-3 rounded-pill"></a>
                                        <div class="media-body">
                                            <div class="reviews-members-header">
                                                <span class="star-rating float-right">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                                <h6 class="mb-1 rev-name">Gurdeep Sing</h6>
                                                <p class="text-gray rev-date">Tue, 20 Mar 2020</p>
                                            </div>
                                            <div class="reviews-members-body">
                                                <p>Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. </p>
                                            </div>
                                            <div class="reviews-members-footer">
                                                <button class="helpful-btn" href="#"><i class="fas fa-thumbs-up"></i> Helpful (<span id="help-count1">20</span>)</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="reviews-members pt-4 pb-4">
                                    <div class="media">
                                        <a href="#"><img alt="Generic placeholder image" src="http://bootdey.com/img/Content/avatar/avatar6.png" class="mr-3 rounded-pill"></a>
                                        <div class="media-body">
                                            <div class="reviews-members-header">
                                                <span class="star-rating float-right">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                                <h6 class="mb-1 rev-name">Gurdeep Sing</h6>
                                                <p class="text-gray rev-date">Tue, 20 Mar 2020</p>
                                            </div>
                                            <div class="reviews-members-body">
                                                <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                            </div>
                                            <div class="reviews-members-footer">
                                                <button class="helpful-btn" href="#"><i class="fas fa-thumbs-up"></i> Helpful (<span id="help-count2">20</span>)</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#">
                                    See All Reviews
                                </a>
                            </div>
                            <div class="hr-line mb-20"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc-tab">
                        <div class="description-section">
                            <p>Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. </p>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        
        <!-- Recommended For You -->
        <div class="row product-descript mt-25">
            <div class="rec-f-div">
                <div class="rec-f-head">
                    <div class="rec-line-t"></div>
                    <h4><span class="rec-line-t-text">Recommended Products</span></h4>
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
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="/xzoom/xzoom/js/vendor/modernizr.js"></script>
<script src="/xzoom/xzoom/js/vendor/jquery.js"></script>
<script src="/xzoom/dist/xzoom.min.js"></script>
<script src="xzoom\xzoom\hammer.js\1.0.5\jquery.hammer.min.js"></script>
<script src="/xzoom/xzoom/js/foundation/foundation.js"></script>
<script src="/xzoom/xzoom/js/setup.js"></script>
<script src="{{ asset('js/products.js') }}" defer></script>
@endsection