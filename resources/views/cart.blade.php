@extends('layouts.app')

@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection

@section('css')
<link href="{{ URL::asset('/css/cart.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">My Cart</a>
    </div>
    <div class="site-container container bg-w ">
        <div id="cartHeader"></div>

        <div id="orderSummeryDiv">
            <div id="productsCart"></div>
            <div id="noProductsCart"></div>
        </div>

        <div id="deliveryInfoDiv">
            <div id="deliveryInfoContent">
                <div class="row">
                    <div class="col-md-8">
                        <div class="cart-layout-inner">
                            <p class="title-text">SHIPPING ADDRESS</p>
                            <hr class="inner-div2">
                            <div class="delivery-form">
                                <div class="row">
                                    <div class="col">
                                        <label for="name">{{ __('Full Name') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input required" onkeypress="return /[a-z]/i.test(event.key)" name="full_name" required autocomplete="name" autofocus id="name" placeholder="Enter your first and last name" value="{{(Session::has('customer'))?(Session::get('customer')['first_name'])." ". (Session::get('customer')['last_name']):''}}" /><br>
                                    </div>
                                    <div class="col">
                                        <label for="phoneno">{{ __('Phone Number') }} <span class="required "></span> </label>
                                        <input type="text" class="form-control sign-input pl-45" name="mobile_no" id="mobile_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" pattern="[0]{1}[7]{1}[0-8]{1}[0-9]{7}" placeholder="Enter your phone number" value="{{(Session::has('customer'))?(Session::get('customer')['mobile_no']):''}}" />
                                        <span class="mob-contry-code">+94</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <select class="selectpicker" data-live-search="true" title="Choose your province" show-tick>
                                            <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                                            <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                            <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                                        </select>


                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        sds
                    </div>

                </div>
            </div>
        </div>

        <div id="paymentOptionDiv">

        </div>

        <div id="finishDiv">

        </div>


    </div>


    @endsection

    @section('scripts')
    <script>
        $(document).ready(function() {

            var window = 0;
            var status = <?php echo $status ?>;
            var item_count = <?php echo $item_count ?>;
            var count = <?php echo $count ?>;
            var total = <?php echo $total ?>;
            var cart_list = <?php echo json_encode($cart_list) ?>;


            getReadyAll(status, item_count, count, total, cart_list);
            deliveryInfo(count, total);

            $('#deliveryInfo').addClass('active');
            $('#productsCart').hide(500);
            $('#noProductsCart').hide(500);

        });

        function createHeader() {
            inHTML = '<ul id="progressbar"><li class="active" id="orderSummery"><span>Order Summery</span></li><li id="deliveryInfo"><span>Delivery Information</span></li><li id="paymentOption"><span>Payment Option</span></li><li id="finish"><span>Finish</span></li></ul><hr class="devider-hr">';

            $('#cartHeader').append(inHTML);
        }

        function deliveryInfo(count, total) {
            $('#cartSummery').append(cartSummery(count, total));
        }

        function getReadyAll(status, item_count, count, total, cart_list) {
            $('#productsCart').empty();
            $('#noProductsCart').empty();
            $('#cartHeader').empty();

            if (status) {
                $('#productsCart').show();
                $('#noProductsCart').hide();
                createHeader();

                inHTML = '';

                inHTML += '<div class="row"><div class="col-md-8"><div class="cart-layout-inner"><p class="title-text">SHOPPING CART</p><div class="select-all-div"><input type="checkbox" name="selectAll" id="selectAll" class="check-select check-size"><label for="selectAll" class="pl-25">Select all (' + item_count + ')</label><div id="removeAllProducts" class="delete-selected-div"><span><i class="far fa-trash-alt "></i> Delete</span></div></div><hr class="inner-hr">';

                $.each(cart_list, function(index, cartStore) {
                    inHTML += '<div class="store-div"><div class="row"><div class="col select-product-store"><input type="checkbox" name="selectAllProductStore" id="selectAllProductStore" class="check-select check-size" data-p="' + cartStore.length + '"><label class="pl-25 pbb-5 c-a label-store "><a target="_blank" href="/store/' + cartStore[0].store.url + '">' + cartStore[0].store.store_name + '</a><i class="fas fa-chevron-right pl--5"></i></label></div></div>';

                    $.each(cartStore, function(key, cart) {

                        color = cart.color != null ? '<p class="pro-color">Color: ' + cart.color + '</p>' : '';
                        price = cart.product.discount != '0' ? '<p class="ori-p mbb-5">Rs. ' + cart.product.unit_price + '</p><p class="dis">' + cart.product.discount + '% Off</p>' : '';

                        inHTML += '<hr class="inner-div2"><div class="row product-div"><div class="col-1 align-self-center select-product"><input type="checkbox" name="selectProduct" id="selectProduct" class="check-select check-size2 product-check"></div><div class="col-2 sec-col"><a href="/product/' + cart.product.url + '" target="_blank"><img class="img" src="' + cart.product.images + '" height="90px" width="90px" alt="' + cart.product.name + '"></a></div><div class="col-5"><p class="pro-name"><a href="/product/' + cart.product.url + '" target="_blank" id="proName">' + cart.product.name + '</a></p><p class="pro-desc">' + cart.product.short_desc + '</p>' + color + '</div><div class="col-2 prices prl-5"><p class="dis-p mbb-5">Rs. ' + cart.product.discounted_price + '</p>' + price + '</div><div class="col-2"><div class="qty">QTY: ' + cart.quantity + '</div><div class="qty-input"><div class="dicreaser"><i class="fas fa-minus"></i></div><div><input type="text" class="form-control qtyInput" name="qtyInput" pattern="[0-9]+" id="qtyInput" maxlength="3" required onkeypress="acceptOnlyNumber()" value="' + cart.quantity + '" dataMax="' + cart.stock + '"></div><div class="increaser"><i class="fas fa-plus"></i></div></div><div class="more-options d-flex justify-content-between"><div id="moveToWishlist" class="wishlist--icon"><i class="far fa-heart"></i></div><div class="remove--icon" id="removeFromCart"><i class="far fa-trash-alt "></i></div></div></div></div>';
                    });
                    inHTML += '</div><hr class="inner-hr">';
                });
                inHTML += '</div></div>';
                inHTML += cartSummery(count, total);

                $('#productsCart').append(inHTML);

            } else {
                $('#productsCart').hide();
                $('#noProductsCart').show();
                inHTML = '<div><div class="row no-cart"><div class="col"><p>There are no items in the cart.</p> <button type="button" id="homeRouteBtn" class="btn-continue bg-w border border-primary rounded">Continue Shopping <i class="fas fa-cart-plus"></i></button></div></div></div>';
                $('#noProductsCart').append(inHTML);
            }
        };

        function cartSummery(count, total) {
            return '<div class="col-md-4 cart-summery-layout"><div class="cart-layout-inner"><p class="title-text">CART SUMMERY</p><div class="shadow p-3 mb-5 bg-white rounded"><div class="row justify-content-center"><div class="col"><p class="txt-sub-total mbb-5">Total Items:</p></div><div class="col"><p class="text-right txt-sub-total mbb-5" id="count">' + count + '</p></div></div><div class="row justify-content-center"><div class="col"><p class="txt-sub-total">Cart Sub Total:</p></div><div class="col"><p class="text-right txt-sub-total">Rs. <span id="totals">' + total + '</span></p></div></div><hr class="inner-div2"><div class="row justify-content-center"><div class="col"><p class="txt-order-total">Order Total</p></div><div class="col"><p class="text-right txt-order-total2">Rs. <span id="total">' + total + '</span></p></div></div><button id="btnCheckout" class="btn-cart btn-checkout">PROCEED <i class="fas fa-chevron-right pl--5"></i></button><button id="btnCheckout" class="btn-cart btn-continue2 mt-10"> <i class="fas fa-chevron-left pr--5"> </i> CONTINUE SHOPPING</button></div></div><div class="f-div"></div></div></div>';
        }
    </script>
    <script src="{{ asset('js/cart.js') }}" defer></script>
    @endsection