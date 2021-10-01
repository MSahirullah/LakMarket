@extends('layouts.app')

@section('content')

<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">Search Result</a>
    </div>
    <div class="site-container container">

        <div class="sr">
            <div class="row">
                <div class="filter-col">
                    <div class="filter-item mt-0">
                        <div class="filter-item-body">
                            <span id="searchFilter" data-sort="{{Session::has('searchFilterSort')?Session::get('searchFilterSort'):''}}"></span>
                            <form action="{{route('search.filterSort')}}" method="GET" id="filterSort">
                                @csrf
                                <input type="hidden" name="q" id='temp1'>
                                <input type="hidden" name="" id='temp2'>
                                <p class="filter-title-text">Sort By :</p>
                                <span class="nav-item dropdown sort-filter">
                                    <i class="fas fa-chevron-down down-btn"></i>
                                    <select class="selectpicker sort-filter-select" id='sort-filter-select' name='sort'>
                                        <option>Best Match</option>
                                        <option>Price Low to High</option>
                                        <option>Price High to Low</option>
                                    </select>

                                </span>
                            </form>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="filter-item-body">
                            <p class="filter-title-text mb-15">Delivery Type :</p>
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
                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="priceFrom" maxlength="7" placeholder="min">
                                <span class="filter-price-dash">-</span>
                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="priceTo" maxlength="7" placeholder="max">

                                <button class="filter-btn-1"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="filter-item-body text-center">
                            <button class="filter-btn-1 btn-2"> <i class="fas fa-trash"></i>Clear All Filters</i></button>
                        </div>
                    </div>
                    @if($productCount != 0)
                    <div class="filter-item" style="border-bottom:unset;">
                        <div class="filter-item-body">
                            <p class="filter-title-text mb-0">Related Categories</p>
                            <div class="filter-related-cato">
                                @foreach($categories as $key=>$value)
                                <li class="f-r-c-li-i"> <a href="/category/{{$value[0]}}"><i class="fas fa-chevron-right"></i> {{$key}}</a></li>
                                @foreach($value[1] as $key2=>$value2)
                                <li class="f-r-c-li-ii"> <a href="/product-category/{{$value2[1]}}">{{$value2[0]}}</a></li>

                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="result-col">
                    <div class="result-count">
                        <div>
                            <h5 class="sr-title"> {{$storeCount}} Shops and {{$productCount}} Products found for "{{$q}}"</h5>
                        </div>
                    </div>
                    <div class="h-line">
                    </div>
                    @if($productCount == 0)
                    <div class='no-result'>

                        <div class="no-result-img"></div>
                        <div class="no-result-h">No Result For Search...</div>
                        <div class="no-result-p">We're sorry. "{{$q}}" did not match any products. Please try again.</div>
                    </div>

                    @else
                    <div class="search-tile-title">
                        <h4>Related shops for "{{$q}}"</h4>
                    </div>

                    <div id="search-stores">
                    </div>

                    <div class="h-line">
                    </div>

                    <div class="search-tile-title" style="margin-bottom: 15px;">
                        <h4>Related products for "{{$q}}"</h4>
                    </div>
                    <div class="view-buttons">
                        <span>View: </span>
                        <button class="tile-view-btn"><i class="fas fa-th-large view-button-selected"></i></button>
                        <button class="list-view-btn"><i class="fas fa-th-list"></i></button>
                    </div>

                    <div id="search-product-tile">
                    </div>

                    <div class="search-tile-product-div-hr" style="display:none;">
                        @foreach($products as $product) <div class="search-tile-hr">
                            <div class="row search-tile-body search-product menu-product">
                                <div class="col-md-c-3">
                                    @if($product->discount != '0.00')
                                    <div class="discount-wrapper">
                                        <div class="discount-text">
                                            <span class="discount-amount">-{{explode(".",$product->discount)[0]}}</span>
                                            <span class="discount-sign">%</span>
                                            <span class="discount-off">Off</span>
                                        </div>
                                        <img class="discount-img" src="img/discount-wrapper.png" alt="discount">
                                    </div>
                                    @endif
                                    <div class="image-container">
                                        <a href="/product/{{$product->url}}"><img src=/{{explode(',' , str_replace(array('[','"', ']', '\\'),'', $product->images))[0]}} alt="{{strlen($product->name) > 10 ? substr($product->name ,0,10)."..." : $product->name}}" class="home-tile-img p-0"></a>
                                    </div>


                                    <div class="product-rating-div-search">
                                        <i class="fas fa-star rating-star-icon"></i><span class="rating-value">(4.5)</span>
                                    </div>
                                </div>
                                <div class="home-tile-title col-md-7">
                                    <a href="#" class="home-tile-title-h price-tile">{{strlen($product->name) > 50 ? substr($product->name ,0,50)."..." : $product->name}}</a>
                                    <div class="product-desc" style="height:115px;">
                                        <div class="shor-desc">{{$product->short_desc}}</div>
                                        <div class="long-desc">{{strlen($product->long_desc) > 150 ? substr($product->long_desc ,0,150)."..." : $product->long_desc}}</div>
                                    </div>
                                    <div class="shop-name">
                                        <a href="{{$product->sellerURL}}">{{$product->seller}}</a>
                                    </div>

                                    <div class="district-city">
                                        <span class="district">{{$product->district}}</span>
                                        <span">,</span>
                                            <span class="city">{{$product->city}}</span>
                                    </div>

                                </div>
                                <div class="col-md-c-2  text-center">
                                    <div class="home-tile-price pt-10">
                                        <p class="home-tile-price-rs">Rs. <span class="home-tile-price">{{
                                            $product->discount !='0.00' ? $product->discounted_price : $product->unit_price}}
                                            </span></p>
                                        <div class="product-price">
                                            @if($product->discount != '0.00')
                                            <p class="home-tile-d-price-rs mb-8">Rs. <span class="home-tile-d-price">{{$product->unit_price}}</span></p>
                                            @endif
                                        </div>

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
                        @endforeach
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
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>

</script>

<script src="{{ asset('js/search.js') }}" defer></script>

@endsection