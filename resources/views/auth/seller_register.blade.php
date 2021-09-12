@extends('layouts.app')
@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection
@section('css')
<link href="{{ URL::asset('/css/sellerRegister.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content site-container" style="background-image:url('/img/sign-bg.png');background-size: contain;">
    <div class="form-content">
        <div class="container">
            <div class="row jc-c">
                <div class="col-md-8">
                    <div class="welcome-window pb-15">

                        <div>
                            <p class="fw-bold welcome-msg text-center">Welcome to Lak Market!</p>
                            <p class="fw-bold welcome-seller text-center">Create Your Business Account...</p>
                        </div>
                        <hr>
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><strong>Account</strong></li>
                            <li id="personal"><strong>Personal</strong></li>
                            <li id="confirm"><strong>Finish</strong></li>
                        </ul>
                        <hr>

                        <div id="accountTab">
                            <form method="POST" action="{{route('register.seller')}}" id="verifySellerForm">
                                @csrf
                                <div class="row">
                                    <div class=" col-md-12 pr-25">
                                        <p class="col-title-seller">Account Inforamtion : </p>

                                        <label id="dataEmail" data-email="" for="sellerEmail">{{ __('Business Email') }} <span class="required"></span> </label>
                                        <input type="email" class="form-control sign-input mb-15" name="email" value="{{ old('email') }}" required autocomplete="email" id="sellerEmail" autofocus placeholder="Enter your email address" />


                                        <button type="button" id="sellerRegSub" class="btn btn-primary reg-button-2 button-reg-1">
                                            Verify Email
                                        </button>
                                        <button type="button" id="sellerRegResend" class="reg-button-2 button-reg-1 btn btn-success submit-button button-3" disabled style="display: none;">
                                            Click Here to Resend <span class="timer">(<span id="timer">60</span>)</span>
                                        </button>
                                        <button type="submit" class="seller-submit" style='display:none;' disabled></button>

                                    </div>
                                </div>
                            </form>
                            <div id="verifyCode" style="display:none;">
                                <form method="POST" action="{{route('verify.seller')}}" id="VerifyCodeSellerForm" class="digit-group mb-100" data-group-name="digits" data-autosubmit="false" autocomplete="off">

                                    <div class="row jc-c">
                                        <div class="col-md-12 pr-25">
                                            <hr>
                                            <div class="success-img" style="background-image:url('/img/check-mark.png');"> </div>
                                            <p class="mb-8 text-center ">{{ __('Before proceeding, please check your email for a verification code.') }}
                                            <div class="done_text text-center mt-20">

                                                <input type="text" id="digit-1" name="digit-1" data-next="digit-2" autofocus />
                                                <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                                                <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                                                <span class="splitter">&ndash;</span>
                                                <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                                                <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                                                <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" />

                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="sellerVerifSub" class="btn btn-primary reg-button-3 button-reg-1 mt-35">
                                        Verify Account
                                    </button>
                                </form>

                            </div>


                        </div>
                        <div id="businessTab" style="display:none">
                            <form method="POST" action="{{route('submit.seller')}}" id="submitSellerDetails">
                                <div class="row">
                                    <div class="col">
                                        <label for="first-name">{{ __('Seller Full Name') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" name="full-name" required autocomplete="full-name" autofocus id="full-name" onkeypress="return /^[a-zA-Z\s]*$/i.test(event.key)" pattern="([A-zÀ-ž\s]){2,}" placeholder="Enter your full name ">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <label for="business-name">{{ __('Business Name') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" name="business-name" value="{{ old('name') }}" required autocomplete="business-name" pattern="([A-z0-9À-ž\s]){2,}" id="business-name" placeholder="Enter your business name"><br>
                                    </div>

                                    <div class="col">
                                        <label for="selectCategory">{{ __('Business Category') }} <span class="required"></span> </label>
                                        <select class="selectpicker form-control sign-input" id="selectCategory">

                                            @foreach($shopC as $shop)
                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="bMobile">{{ __('Business Mobile Number') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" name="bMobile" id="bMobile" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" pattern="[0]{1}[0-9]{9}" placeholder="Enter your business mobile number" /><br>
                                    </div>

                                    <div class="col">
                                        <label for="bHotline">{{ __('Business Hotline') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" name="bHotline" id="bHotline" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" pattern="[0]{1}[0-9]{9}" placeholder="Enter your business hotline" /><br>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="address">{{ __('Business Address') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" name="address" required autocomplete="address" id="address" pattern="([A-z0-9À-ž\s]){2,}" placeholder="Enter your business address ">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col autocomplete">
                                        <label for="reg-district">{{ __('District') }} <span class="required"></span> </label>

                                        <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="reg-district" id="reg-district" placeholder="Select your district" />
                                        <i class="fa fa-angle-down reg-angle-icon reg-district-icon" id="reg-district-icon" aria-hidden="true"></i>
                                        <br>
                                    </div>

                                    <div class="col">
                                        <label for="reg-hometown">{{ __('City') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="reg-hometown" id="reg-hometown" placeholder="Select your city" />
                                        <i class="fa fa-angle-down reg-angle-icon reg-hometown-icon" id="reg-hometown-icon" aria-hidden="true"></i><br>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="storeLocation">{{ __('Store Location') }} <span class="required"></span> </label>
                                        <div class="map-span">
                                            <span><i class="fas fa-search-location"></i> Click here to get your current location</span>
                                        </div>
                                        <div id="storeLocation" class="form-control text-center align-middle" data-la="79.8612" data-lo="6.9271">
                                        </div>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input mt-9" name="cashOnDelivery" checked type="checkbox" value="1" id="cashOnDel">
                                            <label class="form-check-label" for="cashOnDel">
                                                Cash On Delivery Available
                                                <span class="required"></span> </label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row text-right">
                                    <div class="col">
                                        <button type="button" id="sellerDeailsSubmit" class="btn btn-primary reg-button-4 button-reg-1">
                                            Create Seller Account
                                        </button>
                                        <button type="submit" class="sellerDeailsSubmitBtn" style='display:none;' disabled></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="confirmTab" style="display: none;">
                            <div class="row jc-fe confirmTab-div">

                                <div class='success-text'>
                                    <div class="logo"></div>
                                    <span class="text1">Thank You. <br> We are verifying your <br> information.</span><br>
                                    <br>
                                    <span class="text2">We will notify you of your <br> verfication status via email in 24 to 36 hours.</span><br><br>
                                    <a href="/"><button>Go to Home</button></a>
                                </div>

                                <div class="success-bg"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>
<script src="{{ asset('/js/sellerRegister.js') }}" defer></script>
@endsection