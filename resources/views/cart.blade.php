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
            <div id="deliveryInfoContent" style="display: none">
                <div class="row">
                    <div class="col-md-8">
                        <div id="deliveryInfoContentAddress">
                        </div>
                    </div>
                    <div class="col-md-4 cart-summery-layout">
                        <div id="deliveryInfoContentSummery">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="paymentOptionDiv">
            <div id="paymentOptionContent" style="display: none">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEditAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered address-modal" role="document">
        <div class="modal-content">
            <form action="#" method="post">
                @csrf
                <input type="hidden" name="review_id" value="" id="reviewID-report">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-4">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="c-48" for="fullNameC">{{ __('Full Name') }} <span class="required"></span> </label>
                                <input type="text" class="form-control sign-input required c-48 " onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" name="full_nameC" required autocomplete="name" autofocus id="fullNameC" placeholder="Enter your first and last name" maxlength="100" />
                            </div>
                            <div class="col">
                                <label class="c-48" for="phoneC">{{ __('Phone Number') }} <span class="required"></span> </label>
                                <input type="text" class="form-control sign-input pl-45 c-48 " required name="phoneC" id="phoneC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" placeholder="7XXXXXXXX" />
                                <span class="mob-contry-code">+94</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="c-48" for="addressC">{{ __('Address') }} <span class="required"></span> </label>
                                <input type="text" class="form-control sign-input required c-48 " name="addressC" required autocomplete="address" id="addressC" placeholder="Enter your address" maxlength="75" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="c-48" for="districtC">{{ __('District') }} <span class="required"></span> </label> <br>
                                <select class="selectpicker selector" name="districtC" required id="districtC" title="Choose your district">
                                    @foreach($districts as $district)
                                    <option value="{{$district->id}}">{{$district->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="c-48" for="cityC">{{ __('City') }} <span class="required"></span> </label> <br>
                                <select class="selectpicker selector" name="cityC" required id="cityC" title="Choose your city" disabled>
                                </select>
                            </div>
                            <div class="col">
                                <label class="c-48" for="labelC">{{ __('Label') }} <span class="required"></span> </label>
                                <input type="text" class="form-control sign-input required c-48 " name="labelC" required autocomplete="label" id="labelC" placeholder="Ex: Home / Office" maxLength="20" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modal" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-modal btn-modal-submit">Save</button>
                        <button type="submit" class="d-none" id="btnSubmitC"></button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        if (performance.navigation.type == performance.navigation.TYPE_BACK_FORWARD) {
            localStorage.setItem("viewCart", '0');
            localStorage.setItem("proURLCart", '');
            location.reload();
        }

        var window = 0;
        var status = <?php echo $status ?>;
        var item_count = <?php echo $item_count ?>;
        var count = <?php echo $count ?>;
        var total = <?php echo $total ?>;
        var cart_list = <?php echo json_encode($cart_list) ?>;
        var cus = '';

        getReadyAll(status, item_count, count, total, cart_list);
        deliveryInfo(0);

        $(document).on("click", '#btnSecureCheckout', function() {

            $('#btnSecureCheckout').attr('disabled', 'disabled');
            $('#btnSecureCheckout').addClass('disabled-button');

            var full_name = $('#full_nameA').text();
            var address = $('#addressA').text();
            var postal_code = $('#postal_codeA').text();
            var cityID = $('#cityA').attr('data');
            var city = $('#cityA').text();
            var districtID = $('#districtA').attr('data');
            var district = $('#districtA').text();
            var province = $('#provinceA').text();
            var phone = $('#phoneA').text();
            var totalAmount = $('#totals').text().replace(",", "");
            var count = $('#count').text();

            if (full_name == '' || address == '' || postal_code == '' || city == '' || district == '' || province == '' || phone == '') {
                vanillaAlert(1, 'Please select a shipping address.');
            } else {

                inHTML = '<form action="https://sandbox.payhere.lk/pay/checkout" method="post"><input type="hidden" name="merchant_id" value="{{env("PAY_HERE_MERCHANT_ID")}}"><input type="hidden" name="notify_url" value="{{route("checkout.notify")}}"><input type="hidden" name="return_url" value="{{route("checkout.success")}}"><input type="hidden" name="cancel_url" value="{{route("checkout.cancelled")}}"><input type="hidden" name="country" value="Sri Lanka"><input type="hidden" name="currency" value="LKR"><input type="hidden" id="order_idCH" name="order_id" value=""><input type="hidden" id="total_amountCH" name="amount" value=""><input type="hidden" id="proNamesCH" name="items" value=""><input type="hidden" id="first_nameCH" name="first_name" value=""><input type="hidden" id="last_nameCH" name="last_name" value=""><input type="hidden" id="emailCH" name="email" value=""><input id="phoneCH" type="hidden" name="phone" value=""><input type="hidden" id="addressCH" name="address" value=""><input type="hidden" id="cityCH" name="city" value=""><button id="submitCH" type="submit"></button></form>'

                $('#paymentOptionContent').append(inHTML);

                if (full_name.indexOf(' ') >= 0) {
                    var name = [];
                    var name = full_name.split(' ');
                    var first_name = name[0];
                    var second_name = name[1];
                } else {
                    var first_name = full_name;
                    var second_name = " ";
                }

                $.post("/order/add", {
                        "_token": post_token,
                        "proURL": checkCheckBox(),
                        "full_name": full_name,
                        "district": districtID,
                        "city": cityID,
                        "phone": phone,
                        "address": address,
                    },
                    function(data) {
                        if (data[0] == '0') {

                            $('#order_idCH').val(data[1]);
                            $('#total_amountCH').val(totalAmount);
                            $('#proNamesCH').val(count + ' item(s)');
                            $('#first_nameCH').val(first_name);
                            $('#last_nameCH').val(second_name);
                            $('#emailCH').val(data[2]);
                            $('#phoneCH').val('0' + phone);
                            $('#addressCH').val(address);
                            $('#cityCH').val(city);

                            $('#submitCH').trigger('click');
                            alertify.alert('<div class="pop-up-msg">Redirecting to payment gateway...<br>Please wait!</div>').set('basic', true);

                        } else {
                            vanillaAlert(data[0], data[1]);
                        }
                    });

                $('#btnSecureCheckout').removeAttr('disabled');
                $('#btnSecureCheckout').removeClass('disabled-button');
            }
        });

        if (performance.navigation.type == performance.navigation.TYPE_NAVIGATE) {
            localStorage.setItem("viewCart", '0');
            localStorage.setItem("proURLCart", '');
        }

        if (localStorage.getItem("viewCart") === null) {
            localStorage.setItem("viewCart", "0");
            // 
        } else if (localStorage.getItem("viewCart") == "0") {
            proURL = localStorage.getItem("proURLCart");
            proURL = proURL.split(",");
            makeCheckBox(proURL);
            selectProduct(proURL);
            //
        } else if (localStorage.getItem("viewCart") == "1") {
            $('#deliveryInfo').addClass('active');
            $('#productsCart').hide();
            $('#noProductsCart').hide();
            $('#deliveryInfoContent').show();
            proURL = localStorage.getItem("proURLCart");
            proURL = proURL.split(",");
            makeCheckBox(proURL);
            selectProduct(proURL);

        }
    });

    function createHeader() {
        inHTML = '<ul id="progressbar"><li class="active" id="orderSummery"><span>Order Summery</span></li><li id="deliveryInfo"><span>Delivery Information</span></li><li id="paymentOption"><span>Payment Options</span></li></ul><hr class="devider-hr">';

        $('#cartHeader').append(inHTML);
    }

    function deliveryInfo(status = 0) {
        $.post("/shoppingCart/customer", {
                "_token": post_token,
            },
            function(data) {
                $('#deliveryInfoContentAddress').empty();
                inHTML = '<div class="cart-layout-inner"><p class="title-text">SHIPPING ADDRESS</p><hr class="inner-div2"><div class="delivery-form"><div class="d-flex flex-wrap">';

                if (data['status']) {
                    $.each(data['addresses'], function(key, value) {
                        inHTML += createCard(true, data['addresses'].length, data['addresses'][key]);
                    });
                    inHTML += createCard(false, data['addresses'].length, '');
                } else {
                    inHTML += createCard(false, 0);
                }
                inHTML += '</div></div>';

                $('#deliveryInfoContentAddress').append(inHTML);

                if (!status) {
                    createCartSummery();
                }

            });
    }

    function createCartSummery() {
        $('#deliveryInfoContentSummery').empty();

        var inHTML = '<div class="cart-layout-inner"><p class="title-text">CART SUMMERY</p><div class="shadow p-3 mb-5 bg-white rounded"><div class="row justify-content-center"><div class="col"><p class="txt-sub-total mbb-5">Total Items:</p></div><div class="col"><p class="text-right txt-sub-total mbb-5" id="count"></p></div></div><div class="row justify-content-center"><div class="col"><p class="txt-sub-total">Cart Sub Total:</p></div><div class="col"><p class="text-right txt-sub-total">Rs. <span id="totals"></span></p></div></div><hr class="inner-div2"><div class="row justify-content-center"><div class="col"><p class="txt-order-total">Order Total</p></div><div class="col"><p class="text-right txt-order-total2">Rs. <span id="total"></span></p></div></div><div id="addressInCartSummery"></div><button id="btnSecureCheckout" class="btn-cart btn-checkout">SECURE CHECKOUT <i class="fas fa-chevron-right pl--5"></i></button><button id="btnShoppingCart" class="btn-cart btn-continue2 mt-10"> <i class="fas fa-chevron-left pr--5"> </i> SHOPPING CART </button></div></div><div class="f-div"></div></div></div>';

        selectProduct(checkCheckBox());

        $('#deliveryInfoContentSummery').append(inHTML);
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

            inHTML += '<div class="row"><div class="col-md-8"><div class="cart-layout-inner"><p class="title-text">SHOPPING CART</p><div class="select-all-div"><input type="checkbox" name="selectAll" id="selectAll" class="check-select check-size"><label for="selectAll" class="pl-25">Select all (<span id="cartAllProducts">' + item_count + '</span>)</label><div id="removeAllProducts" class="delete-selected-div"><span><i class="far fa-trash-alt "></i> Delete</span></div></div><hr class="inner-hr">';

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
        return '<div class="col-md-4 cart-summery-layout"><div class="cart-layout-inner"><p class="title-text">CART SUMMERY</p><div class="shadow p-3 mb-5 bg-white rounded"><div class="row justify-content-center"><div class="col"><p class="txt-sub-total mbb-5">Total Items:</p></div><div class="col"><p class="text-right txt-sub-total mbb-5" id="totalCount">' + count + '</p></div></div><div class="row justify-content-center"><div class="col"><p class="txt-sub-total">Cart Sub Total:</p></div><div class="col"><p class="text-right txt-sub-total">Rs. <span id="totalAmounts">' + total + '</span></p></div></div><hr class="inner-div2"><div class="row justify-content-center"><div class="col"><p class="txt-order-total">Order Total</p></div><div class="col"><p class="text-right txt-order-total2">Rs. <span id="totalAmount">' + total + '</span></p></div></div><button id="btnCheckout" class="btn-cart btn-checkout">PROCEED <i class="fas fa-chevron-right pl--5"></i></button><button id="btnCheckout" class="btn-cart btn-continue2 mt-10"> <i class="fas fa-chevron-left pr--5"> </i> CONTINUE SHOPPING</button></div></div><div class="f-div"></div></div></div>';
    }

    function createCard(status, count, address = '') {
        if (status) {

            disabled = address.status != '0' ? 'disabled' : '';

            inHTML = '<div class="card card-div mb-4" style="width: 18rem;"><div class="card-body"><div class="card-content" id="shippingAddress"><h5 class="card-title card-label"><span id="addressLabel">' + address.label + '</span></h5><h6 class="card-title"><span id="addressName">' + address.full_name + '</span></h6><p class="card-text mb-10"><span id="addressAdd">' + address.address + '</span> </br><span id="addressPostalCode">' + address.postal_code + '</span></br><span id="addressCity" data="' + address.cityID + '">' + address.city + '</span>, <span id="addressDistrict" data="' + address.districtID + '">' + address.district + '</span>, <span id="addressProvince" >' + address.province + '</span></br>Phone: +94<span id="addressPhone">' + address.phone + '</span></p></div><div class="d-flex justify-content-between" data="' + address.id + '"><button class="btn btn-light card-btn" id="editAddress">Edit</button><button class="btn btn-light card-btn" ' + disabled + ' id="deleteAddress">Remove</button></div></div></div>';
        } else {
            var check = count % 2 == 0 ? "height:14rem" : '';
            inHTML = '<div class="card card-div add-new-address mb-4" style="width: 18rem;' + check + '"><div class=" card-content d-flex align-items-center h-100 justify-content-center" id="addNewAddress"><div class="pr-p5 text-center"><i class="fas fa-plus pr-10"></i><br><p class="mb-0">Add New Address</p></div></div></div>';
        }
        return inHTML;
    }
</script>
<script src="{{ asset('js/cart.js') }}" defer></script>
@endsection