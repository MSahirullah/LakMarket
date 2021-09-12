@extends('layouts.app')

@section('title')
{{$product->name}} - Buy at Best price in Sri Lanka |
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/normalize.css') }}">
<!-- <link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/foundation.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ URL::asset('/xzoom/xzoom/css/demo.css') }}"> -->
<link rel="stylesheet" href="{{ URL::asset('/xzoom/dist/xzoom.css') }}">
@endsection


@section('content')

<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="/category/{{$product->surl}}">{{$product->scategory}}</a>
        <i class="fas fa-chevron-right"></i>
        <a href="/category/{{$product->surl}}/{{$product->purl}}">{{$product->pcategory}}</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">{{$product->name}}</a>
    </div>
    <div class="site-container container productD">
        <div class="row bg-w">
            <div class="col-md-4  mt-15">
                <section id="lens">
                    <div class="row">
                        <div class="large-5 column">
                            <div class="xzoom-container">
                                <img class="xzoom3" src="/{{$images[0]}}" xoriginal="/{{$images[0]}}" width="318" height="318" />
                                <div class="xzoom-thumbs">
                                    <a href="/{{$images[0]}}"><img class="xzoom-gallery3" width="70" height="70" src="/{{$images[0]}}" xpreview="/{{$images[0]}}"></a>
                                    @if(sizeof($images) > 1)
                                    <a href="/{{$images[1]}}"><img class="xzoom-gallery3" width="70" height="70" src="/{{$images[1]}}"></a>
                                    @elseif(sizeof($images) > 2)
                                    <a href="/{{$images[2]}}"><img class="xzoom-gallery3" width="70" height="70" src="/{{$images[2]}}"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-5 mt-15 pl-0 product-details-col">
                <div class="product-details-div">
                    <div class="product-name">
                        <h3>{{$product->name}}</h3>
                        <a href="/category/{{$product->surl}}/{{$product->purl}}" class="p-cato">{{$product->pcategory}}</a>
                    </div>
                    <div class="product-ratings">
                        <div class="ratings">
                            <div class="stars-outer">
                                <div class="stars-inner">
                                </div>
                            </div>
                        </div>
                        <div class="line-s">
                            |
                        </div>
                        <div class="rating-count">
                            {{$ratingCon}} ratings
                        </div>
                        <div class="line-s">
                            |
                        </div>
                        <div class="rating-add">
                            {{$reviewsCon}} reviews
                        </div>
                    </div>

                    <div class="product-shortdesc">{{$product->short_desc}}</div>
                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-2">
                    <div class="product-price">
                        <span>Rs.</span>
                        <span>{{$product->discounted_price}}</span>
                        @if($product->discount != '0.00')
                        <br>
                        <div class="product-o-price">
                            <span>Rs.</span>
                            <span class='price'>{{$product->unit_price}}</span>
                        </div>
                        @endif
                    </div>
                    <div class="product-availability text-right">
                        @if($product->discount != '0.00')
                        <div>
                            <span class="percentage">{{explode('.', $product->discount)[0]}}%</span>
                            <span>Off</span>
                        </div>
                        @endif
                        <div>
                            <span>Availability:</span>
                            <span class="stock" id="stock" data-stock='{{$product->stock}}'>
                                @if($product->colors != null)
                                @if($product->colors[0]['stock'] != 0)
                                <span class="instock" id="InStock">In stock : {{$product->colors[0]["stock"]}}</span>
                                @else
                                <span class="outofstock" id="OutofStock">Out of stock</span>
                                @endif
                                <span class="" id="stockStatus" style="display:none;"></span>
                                @else
                                @if($product->stock != 0)
                                <span class="instock" id="InStock">In stock : {{$product->stock}}</span>
                                @else
                                <span class="outofstock" id="OutofStock">Out of stock</span>
                                @endif
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-3">
                    <div class="qty-input">
                        <label for="#qytInput"></label>
                        <input type="text" class="form-control qtyInput" name="qtyInput" pattern="[0-9]+" id="qtyInput" maxlength="3" required onkeypress="acceptOnlyNumber()" value="1" dataMax='{{$product->colors == null ? $product->stock : $product->colors[0]["stock"] }}'>
                        <div class="inc-dic ">
                            <div class="increaser"><i class="fas fa-plus"></i></div>
                            <div class="dicreaser"><i class="fas fa-minus"></i></div>
                        </div>
                    </div>
                    @if($product->colors)
                    <div class="product-cs">
                        <label for="#colorSelector">Color : </label>
                        <select class="selectpicker p-select" data-width="80px" id="colorSelector">
                            @foreach($product->colors as $color)
                            <option value="{{$color['color']}}">{{$color['color']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="hr-line"></div>
                <div class="product-details-div-4">
                    <div class="product-btn">
                        <button class="add-to-wishlist"><i class="far fa-heart" aria-hidden="true"></i></button>
                        <button id="btnCart" class="add-to-cart-btn">Add to Cart</button>
                        <button id="btnBuy" class="buy-now">Buy Now</button>
                    </div>
                </div>

            </div>
            <div class="col-md-3 mt-15 pr-0">
                @foreach($productsTop as $key=>$value)
                <!-- text -->
                <div class="related-products row ml-0 rel-pro-{{$key}}">
                    <div class="product-image">
                        <a href="/product/{{$value->url}}"><img class="product-top-img" src="/{{$value->images}}" alt="{{strlen($value->name) > 10 ? substr($value->name, 0 , 10).'...' : $value->name}}" width="75" height="75"></a>
                    </div>
                    <div class="r-p-details">
                        <a href="/product/{{$value->url}}">
                            {{strlen($value->name) > 24 ? substr($value->name, 0 , 24).'...' : $value->name}}
                        </a>
                        <div class="r-p-r">
                            <div class="stars-outer">
                                <div class="stars-inner">
                                </div>
                            </div>
                        </div>
                        <div class="r-p-price">
                            {{$value->discounted_price}}

                        </div>
                    </div>
                </div>
                @endforeach

                <div class="hr-line"></div>
                <div class="seller-details">
                    <div class="sold-by">Sold by</div>
                    <a href="/store/{{$product->storeurl}}">

                        <h6>{{$product->store}}</h6>
                    </a>
                    <div class="city text-right"> {{$product->city}} <br>{{$product->district}} District</div>
                    <div class="hr-line-2"></div>
                    <div class="pos-ratings"> Positive Seller Ratings </div>
                    <div class="pos-ratings-num">{{$sellerP}}<span class="prc">%</span></div>
                    <div class="product-btn p-b-2">
                        <a href="/store/{{$product->storeurl}}" target="_blank"><button class="visit-store"><i class="fas fa-shopping-cart shop-icon" aria-hidden="true"></i>Visit Store</button></a>
                        <a href="https://maps.google.com/?q={{$product->storelog}},{{$product->storelat}}" target="_blank"><button class="get-direction"><i class="fas fa-location-arrow location-icon" aria-hidden="true"> </i> Get direction</button></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row bg-w mt-10 prlt-15">
            <div class="pl-0 pr-0 w-100">
                <nav class="footer-tab">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="true">Reviews <span class="cr">(<span>{{$reviewsCon}}</span>)</span></a>
                        <a class="nav-link" id="nav-desc-tab" data-toggle="tab" href="#nav-desc" role="tab" aria-controls="nav-desc" aria-selected="false">Description</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        <div>
                            <div class="review-section">
                                <div id="review-summery-all">
                                </div>
                                <div class="summery-final">
                                    <div class="result-div">
                                        <span class="result">{{number_format((float)$ratingAvg, 1, '.', '')}}</span><span class="dash">/</span><span class="f">5.0</span>
                                    </div>
                                    <div class="stars-outer">
                                        <div class="stars-inner">
                                        </div>
                                    </div>
                                    <div class="summery-count">
                                        {{$ratingCon}} ratings
                                    </div>

                                </div>
                            </div>
                            <div class="hr-line mt-25"></div>
                            <div class="bg-white rounded pt-15 pb-0 p-4 mb-4  detailed-ratings-and-reviews">

                                <h5 class="mb-1 title">{{sizeof($reviews) != 0 ? 'All Ratings and Reviews' : 'No Reviews'}}</h5>
                                @foreach($reviews as $key=>$review)
                                <div class="reviews-members pt-4 pb-4 review-{{$key}}">
                                    <div class="media">

                                        <div class="media-body">
                                            <div class="reviews-members-header">
                                                <span class="star-rating float-right">
                                                    <div class="stars-outer">
                                                        <div class="stars-inner">
                                                        </div>
                                                    </div>
                                                </span>
                                                <h6 class="mb-1 rev-name">{{$review->fname.' '.$review->lname}}</h6>
                                                <p class="text-gray rev-date">{{date('D, j M Y', strtotime($review->created_at))}}</p>
                                            </div>
                                            <div class="reviews-members-body">
                                                <p>{{$review->review}}</p>
                                            </div>
                                            <div class="reviews-members-footer">
                                                <button class="helpful-btn {{$review->helpful_marked > 0 ? 'helpful-marked' : ''}}"><i class="fas fa-thumbs-up"></i> Helpful (<span id="help-count1" data-value="{{$review->id}}">{{$review->helpful_count}}</span>)</button>
                                                <div class="more-r-opt" data="opt-{{$key}}">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                                <div class="more-r-opt-div opt-{{$key}}" style="display:none;">
                                                    <span id="reviewID" data-value="{{$review->id}}"></span>
                                                    <a {{Session::has('customer') ? "data-toggle=modal data-target=#reportModal" : "href=/report"  }}>Report Abuse</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                                <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#"></a>
                            </div>
                            <!-- <div class="hr-line mb-20"></div> -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc-tab">
                        <div class="description-section">
                            <p class="fs-14">
                                <?php
                                echo nl2br($product->long_desc);
                                ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Recommended For You -->
        <div class="pb-25 reco">
            @if(sizeof($product_bottom))
            <div class="wrapper-div div-fade">
                <div class="item-div">
                    <div>
                        <h4 class="title">Recommended For You</h4>
                    </div>
                </div>
                <div class="row home-tile-div {{sizeof($product_bottom) > 4 ? 'owl-carousel owl-theme owl-c-6' : '' }}">
                    @foreach($product_bottom as $value)

                    <div class="col-md home-tile">
                        <div class="home-tile-body home-product product-bottom">
                            @if($value['discount'] != 0)
                            <div class="discount-wrapper">
                                <div class="discount-text">
                                    <span class="discount-amount">-{{explode(".", $value['discount'])[0]}}</span>
                                    <span class="discount-sign">%</span><span class="discount-off">Off</span>
                                </div>
                                <img class="discount-img" src="/img/discount-wrapper.png" alt="discount">
                            </div>
                            @endif
                            @if($value['stock']== 0)
                            <div class="outofstock">
                                <div> Out of Stock </div>
                            </div>
                            @endif
                            <div class="image">
                                <a href="/product/{{$value['url']}}"><img src="/{{$value['images']}}" alt="{{strlen($value['name']) > 10 ? substr($value['name'], 0 , 10).'...' : $value['name']}}" class="home-tile-img  "></a>
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
            </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <form action="{{route('report.review')}}" method="post">

                    @csrf
                    <input type="hidden" name="review_id" value="" id="reviewID-report">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Select a reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio1" name="reportRadio" class="custom-control-input" value="Return / Refund Issue" required>
                            <label class="custom-control-label" for="reportRadio1">Return / Refund Issue</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio2" name="reportRadio" class="custom-control-input" value="Service Related Issue" required>
                            <label class="custom-control-label" for="reportRadio2">Service Related Issue</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio3" name="reportRadio" class="custom-control-input" value="Wrong Picture" required>
                            <label class="custom-control-label" for="reportRadio3">Wrong Picture</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio4" name="reportRadio" class="custom-control-input" value="Personal/Order Details" required>
                            <label class="custom-control-label" for="reportRadio4">Personal/Order Details</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio5" name="reportRadio" class="custom-control-input" value="Abusive Language" required>
                            <label class="custom-control-label" for="reportRadio5">Abusive Language</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="reportRadio6" name="reportRadio" class="custom-control-input" value="Irrelevant Information" required>
                            <label class="custom-control-label" for="reportRadio6">Irrelevant Information</label>
                        </div>
                        <div class="form-group">
                            <label for="addInfoReport" class='reportTextarea'>Additional Comments</label>
                            <textarea class="form-control addInfoReport" name='addInfoReport' id="addInfoReport" rows="4" maxlength="250"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning btn-report-submit">Report</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @endsection

    @section('scripts') <script>
        $(document).ready(function() {

            var ratingCon = <?php echo json_encode($ratingCon)  ?>;
            var ratingAvg = <?php echo json_encode($ratingAvg)  ?>;
            var ratingE = <?php echo json_encode($ratingE)  ?>;
            var reviews = <?php echo json_encode($reviews)  ?>;
            var productsTop = <?php echo json_encode($productsTop)  ?>;
            var product = <?php echo json_encode($product)  ?>;

            ratingMake(ratingAvg, '.product-details-col .product-ratings .ratings .stars-inner');
            ratingMake(ratingAvg, '.summery-final .stars-inner');

            var x = 4;
            $.each(ratingE, function(index, value) {
                a = document.createElement("DIV");
                a.setAttribute("class", 'review-summery stars-' + index + '');
                a.innerHTML += '<div class="star-summery"><div class="stars-outer "><div class="stars-inner"></div></div></div><div class="bar-summery"><div id="bar-5-outer"><div id="bar-5-inner"></div></div></div><div class="reviews-count text-right">' + ratingE[x] + '%</div>';
                $('#review-summery-all').append(a);
                x--;
            });

            $.each(reviews, function(index, value) {
                ratingMake(value.rating, '.detailed-ratings-and-reviews .review-' + index + ' .reviews-members-header .stars-inner');
            });

            $.each(productsTop, function(index, value) {
                ratingMake(value.rating, '.rel-pro-' + index + ' .stars-inner');

            })

            var x = 0;
            for (i = 4; i >= 0; i--) {

                document.querySelector('#review-summery-all .stars-' + x + ' .stars-inner').style.width = (i + 1) * 20 + '%';
                document.querySelector('#review-summery-all .stars-' + x + ' #bar-5-inner').style.width = ratingE[i] + '%';
                x++;
            }

            $('.more-r-opt-div').click(function() {
                $('#reviewID-report').val($('#reviewID', this).attr('data-value'));
            });

            $('#colorSelector').change(function() {

                color = $(this).val();
                pid = product.id;

                $.post("/product/color/stock", {
                        pid: pid,
                        color: color,
                        _token: post_token,
                    },
                    function(data) {

                        $('#qtyInput').attr('dataMax', data)
                        $('#qtyInput').val('1')

                        if (data != 0) {
                            $('#OutofStock').hide();
                            $('#InStock').hide();
                            $('#stockStatus').text('In stock : ' + data);
                            $('#stockStatus').removeClass('outofstock');
                            $('#stockStatus').removeClass('instock');
                            $('#stockStatus').addClass('instock');
                            $('#stockStatus').removeAttr('style');

                            $('#btnCart').removeAttr('disabled');
                            $('#btnBuy').removeAttr('disabled');

                            $('#btnCart').removeClass('add-to-cart-btn-color');
                            $('#btnBuy').removeClass('buy-now-color');

                        } else {
                            $('#OutofStock').hide();
                            $('#InStock').hide();
                            $('#stockStatus').text('Out of stock');
                            $('#stockStatus').removeClass('outofstock');
                            $('#stockStatus').removeClass('instock');
                            $('#stockStatus').addClass('outofstock');
                            $('#stockStatus').removeAttr('style');

                            $('#btnCart').attr('disabled', 'disabled');
                            $('#btnBuy').attr('disabled', 'disabled');

                            $('#btnCart').addClass('add-to-cart-btn-color');
                            $('#btnBuy').addClass('buy-now-color');

                        }
                    });
            })
        });

        function ratingMake(rating, url) {
            const starPercentageRounded = `${Math.round((parseFloat(rating) / 5) * 100)}%`;
            document.querySelector(url).style.width = starPercentageRounded;


        }
    </script>

    <script src="/xzoom/xzoom/js/vendor/modernizr.js"></script>
    <!-- <script src="/xzoom/xzoom/js/vendor/jquery.js"></script> -->
    <script src="/xzoom/dist/xzoom.min.js"></script>
    <script src="/xzoom/xzoom/hammer.js/1.0.5/jquery.hammer.min.js"></script>
    <script src="/xzoom/xzoom/js/foundation/foundation.js"></script>
    <script src="/xzoom/xzoom/js/setup.js"></script>
    <script src="{{ asset('js/products.js') }}" defer></script>
    @endsection