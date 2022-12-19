@extends('layouts.app')
@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection
@section('css')
<link href="{{ URL::asset('/css/sellerRegister.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content site-container">
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
                            <form method="POST" action="{{route('store.registerProcess')}}" id="verifySellerForm">
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
                                <form method="POST" action="{{route('store.verify')}}" id="VerifyCodeSellerForm" class="digit-group mb-100" data-group-name="digits" data-autosubmit="false" autocomplete="off">

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
                            <form method="POST" action="{{route('store.submitDetails')}}" id="submitSellerDetails">
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
<script>
    $(document).ready(function() {


        alertMSG = $('#regStatus').attr('dataMSG');
        alertID = $('#regStatus').attr('dataID');
        if (alertMSG) {
            vanillaAlert(alertID, alertMSG);
        }

        $(".reg-button-2").click(function() {
            sendRegMail();
        });

        $('.button-3').click(function() {
            if ($('#timer').text() == 0) {
                sendRegMail();
            }
        });

        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());

                if (e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if (prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if (next.length) {
                        $(next).select();
                    } else {
                        if (parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });

        $('.reg-button-3').click(function() {

            var digit_1 = $('#digit-1').val();
            var digit_2 = $('#digit-2').val();
            var digit_3 = $('#digit-3').val();
            var digit_4 = $('#digit-4').val();
            var digit_5 = $('#digit-5').val();
            var digit_6 = $('#digit-6').val();
            var email = $('#dataEmail').attr('data-email');

            if (digit_1 && digit_2 && digit_3 && digit_4 && digit_5 && digit_6) {
                $.post($('#VerifyCodeSellerForm').attr('action'), {
                        "_token": post_token,
                        "digit_1": digit_1,
                        "digit_2": digit_2,
                        "digit_3": digit_3,
                        "digit_4": digit_4,
                        "digit_5": digit_5,
                        "digit_6": digit_6,
                        "email": email,
                    },
                    function(data) {
                        data = [0, 'Your email is verified  successfully.'];
                        vanillaAlert(data[0], data[1]);
                        if (data[0] == 0) {
                            $('#personal').addClass('active');
                            $('#accountTab').hide(500);
                            $('#businessTab').show(500);
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                        }
                    });
            }
        });

        alertMSG = $('#regStatus').attr('dataMSG');
        alertID = $('#regStatus').attr('dataID');
        if (alertMSG) {
            vanillaAlert(alertID, alertMSG);
        }

        for (var i = 60; i >= 0; i--) {
            $('#timer').val(i);
        }

        $('body:not(#corner-popup)').click(function() {
            $('#corner-popup').hide();
        });




        function autocomplete(inp, tmpParam, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /// RND Start

            inp.addEventListener("focusin", function(e) {

                if (tmpParam) {
                    arr = cities;
                    var selectedDis = $("#reg-district").val();
                    if (!selectedDis || !districts.includes(selectedDis)) {
                        arr = [];
                        arr.push(" -- Please select district first -- ");
                        inp.val = null;
                    }

                }

                $(`.${inp.id}-icon`).removeClass('fa-angle-down').addClass('fa-angle-up');
                $(`#${inp.id}`).addClass('data-focused');

                var a, b, i, val = this.value;
                currentFocus = -1;

                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", `autocomplete-items ${this.id}autocomplete-items`);

                this.parentNode.appendChild(a);

                for (i = 0; i < arr.length; i++) {
                    if (arr[i] == " -- Please select district first -- ") {
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    } else {

                        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            b = document.createElement("DIV");
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            b.addEventListener("click", function(e) {
                                var selectedDis = this.getElementsByTagName("input")[0].value;
                                inp.value = selectedDis;
                                if (!tmpParam) {
                                    getDistrictCities(selectedDis);
                                }
                                closeAllLists();
                            });
                        }
                    }

                    a.appendChild(b);
                }

            });

            inp.addEventListener('focusout', function(e) {

                var user_input_val = $(`#${inp.id}`).val();
                if (arr.includes(user_input_val)) {
                    inp.value = user_input_val
                } else {
                    inp.value = null;
                    if (!tmpParam) {
                        $("#reg-hometown").val('');
                    }
                }

                setTimeout(function() {
                    closeAllLists();
                }, 150);

                setTimeout(function() {
                    $(`#${inp.id}`).removeClass('data-focused');
                }, 500);

                $(`.${inp.id}-icon`).removeClass('fa-angle-up').addClass('fa-angle-down');

            });

            $(`#${inp.id}-icon`).unbind().click(function() {

                if ($(`#${inp.id}`).hasClass('data-focused')) {
                    $(`#${inp.id}`).focusout();
                } else {
                    $(`#${inp.id}`).focus();
                }
            });


            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;

                closeAllLists();

                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", `autocomplete-items ${this.id}autocomplete-items`);
                this.parentNode.appendChild(a);

                if (!val) {
                    for (i = 0; i < arr.length; i++) {

                        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                            b = document.createElement("DIV");
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                            b.addEventListener("click", function(e) {
                                var selectedDis = this.getElementsByTagName("input")[0].value;
                                inp.value = selectedDis;
                                if (!tmpParam) {
                                    getDistrictCities(selectedDis);
                                }
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                    return false;
                }


                for (i = 0; i < arr.length; i++) {

                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                        b.addEventListener("click", function(e) {
                            var selectedDis = this.getElementsByTagName("input")[0].value;
                            inp.value = selectedDis;
                            if (!tmpParam) {
                                getDistrictCities(selectedDis);
                            }
                            closeAllLists();
                        });

                        a.appendChild(b);
                    }
                }
            });

            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {

                var x = document.getElementsByClassName(`${inp.id}autocomplete-items`);

                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
        }

        var districts = []
        var districts_ids = []
        var cities = []

        cities.push(" -- Please select district first -- ")

        $.post('/register-district', {
            "_token": post_token
        }, function(data) {
            const iterator = data.values();

            for (const value of iterator) {
                districts_ids[value['name_en']] = value['id'];
                districts.push(value['name_en']);
            }

        });

        function getDistrictCities(dis_name) {

            var dis_id = districts_ids[dis_name];
            cities = []

            $.post('/register-cities', {
                'dis_id': dis_id,
                "_token": post_token
            }, function(data) {
                const iterator = data.values();
                for (const value of iterator) {
                    cities.push(value['name_en']);
                }

            });
        }

        autocomplete(document.getElementById("reg-district"), 0, districts);
        autocomplete(document.getElementById("reg-hometown"), 1, cities);


        $('#businessTab #sellerDeailsSubmit').click(function() {

            var validate = true;

            // var full_name = $('#full-name').val();
            // var business_name = $('#business-name').val();
            // var selectCategory = $('#selectCategory').val();
            // var bMobile = $('#bMobile').val();
            // var bHotline = $('#bHotline').val();
            // var address = $('#address').val();
            // var reg_district = $('#reg-district').val();
            // var reg_hometown = $('#reg-hometown').val();
            // var location_lo = $('#storeLocation').attr('data-lo');
            // var location_la = $('#storeLocation').attr('data-la');
            // var cashOnDel = $('#cashOnDel').val();
            // var email = $('#dataEmail').attr('data-email');

            // if (full_name.length < 2 || address.length < 2) {
            //     validate = false;
            // }
            // else if (business_name.length < 2) {
            //     validate = false;
            // }
            // else if (bMobile.length < 10) {
            //     validate = false;
            // }
            // else if (!(reg_district && reg_hometown)) {
            //     validate = false;
            // }

            data = [0, 'Thank you! Your information has been submitted.'];
            vanillaAlert(data[0], data[1]);
            if (data[0] == 0) {
                $('#confirm').addClass('active');
                $('#businessTab').hide(500);
                $('#confirmTab').show(500);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
            }


            // if (validate) {
            //     $.post($('#submitSellerDetails').attr('action'),
            //         {
            //             "_token": "post_token",
            //             'full_name': "full_name",
            //             'business_name': "business_name",
            //             'selectCategory': "selectCategory",
            //             'bMobile': "bMobile",
            //             'bHotline': "bHotline",
            //             'address': "address",
            //             'reg_district': "reg_district",
            //             'reg_hometown': "reg_hometown",
            //             'location_la': "location_lo",
            //             'location_lo': "location_la",
            //             'cashOnDel': "cashOnDel",
            //             "email": "email",
            //         },
            //         function (data) {
            //             data = [0, 'Thank you! Your information has been submitted.'];
            //             vanillaAlert(data[0], data[1]);
            //             if (data[0] == 0) {
            //                 $('#confirm').addClass('active');
            //                 $('#businessTab').hide(500);
            //                 $('#confirmTab').show(500);
            //                 $("html, body").animate({ scrollTop: 0 }, "slow");
            //             }
            //         });
            // } else {

            //     $('#submitSellerDetails .sellerDeailsSubmitBtn').removeAttr('disabled');
            //     $('#submitSellerDetails .sellerDeailsSubmitBtn').click();
            //     $("html, body").animate({ scrollTop: 50 }, "slow");
            //     $('#submitSellerDetails .sellerDeailsSubmitBtn').attr('disabled', 'disabled');

            // }
        })



    });


    var marker = false;

    function initMap() {

        lo = $('#storeLocation').attr('data-lo');
        la = $('#storeLocation').attr('data-la');

        var centerOfMap = new google.maps.LatLng(lo, la);
        var map = new google.maps.Map(document.getElementById('storeLocation'), {
            center: centerOfMap,
            zoom: 12,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER,
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER,
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP,
            },
            fullscreenControl: true,
        });

        var _marker = new google.maps.Marker({
            position: new google.maps.LatLng($('#storeLocation').attr('data-lo'), $('#storeLocation').attr('data-la')),
            map: map,
            draggable: true,
            title: ''
        });

        google.maps.event.addListener(_marker, 'dragend', function(marker) {
            var latLng = marker.latLng;
            $('#storeLocation').attr('data-lo', latLng.lat());
            $('#storeLocation').attr('data-la', latLng.lng());
        });

        _marker.setMap(map);

        google.maps.event.trigger(map, 'resize');
    }



    function sendRegMail() {
        var email = $('#sellerEmail').val();
        var email = $('#sellerEmail').val();

        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var value = re.test(String(email).toLowerCase());

        if (value) {
            $('.content').loading({
                message: "Sending Your Email Verification Code..."
            });

            $.post($('#verifySellerForm').attr('action'), {
                    "email": email,
                    "_token": post_token,
                },
                function(data) {
                    data = [0, "Before proceeding, Please check email for verification code."];

                    vanillaAlert(data[0], data[1]);
                    if (data[0] == 0) {

                        var email = $('#sellerEmail').val();
                        $('#dataEmail').attr('data-email', email);
                        $('#sellerRegSub').hide();
                        $('.button-3').attr('disabled', 'disabled');
                        $('.timer').show();
                        $('#timer').text(60);
                        $('#sellerRegResend').show();
                        var x = 1;
                        for (var i = 59; i >= 0; i--) {
                            x = x + 1;
                            delay(i, x);
                        }

                        function delay(i, x) {
                            setTimeout(() => {
                                $('#timer').text(i);
                            }, 1000 * x);
                        }

                        setTimeout(() => {
                            $('.button-3').removeAttr('disabled');
                            $('.timer').hide();

                        }, 62000);

                        $('#verifyCode').removeAttr('style');

                        $("html, body").animate({
                            scrollTop: 330
                        }, "slow");
                    }
                    $('.content').loading('stop');
                });
        } else {
            $('#verifySellerForm .seller-submit').removeAttr('disabled')
            $('#verifySellerForm .seller-submit').click();
            $('#verifySellerForm .seller-submit').attr('disabled', 'disabled');
        }
    }

    $('.map-span').click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                $('#storeLocation').attr('data-la', position.coords.longitude);
                $('#storeLocation').attr('data-lo', position.coords.latitude);

                initMap();
            });
        } else {
            vanillaAlert(1, "Sorry, your browser does not support HTML5 geolocation.");
        }
    })
</script>
@endsection