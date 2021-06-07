@extends('layouts.app')

@section('content')

<div class="content" style="background-image:url('/img/sign-bg.png');background-size: contain; padding-bottom: 150px;">
    @if(Session::has('regStatus'))
    <div id="regStatus" dataMSG="{{Session::get('regStatus')[1]}}" dataID="{{Session::get('regStatus')[0]}}"></div>
    @endif
    <div class="form-content">
        <div class="container">
            <!-- <div class="col-md-12"> -->
            <div class="row jc-c">
                <div class="col-md-12">
                    <div class="welcome-window pb-15">
                        <div>
                            <p class="fw-bold welcome-msg text-center">Welcome to Lak Market!</p>
                        </div>
                        <hr>
                        <div>
                            <p class="welcome-desc lg">Already have an account? <a href="{{route('login')}}">Sign In</a> here.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" id="reg-form">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 pr-25">
                                    <p class="text-center col-title">Personal Inforamtion</p>
                                    <hr>

                                    <div class="row">
                                        <div class="col">
                                            <label for="first-name">{{ __('First Name') }} <span class="required"></span> </label>
                                            <input type="text" class="form-control sign-input" name="first-name" required autocomplete="first-name" autofocus id="first-name" onkeypress="return /[a-z]/i.test(event.key)" placeholder="Enter your first name ">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="last-name">{{ __('Last Name') }} <span class="required"></span> </label>
                                            <input type="text" class="form-control sign-input" name="last-name" value="{{ old('name') }}" required autocomplete="last-name" autofocus id="last-name" onkeypress="return /[a-z]/i.test(event.key)" placeholder="Enter your last name"><br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col autocomplete">
                                            <label for="reg-district">{{ __('District') }} <span class="required"></span> </label>

                                            <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="reg-district" id="reg-district" placeholder="Select your district" />
                                            <i class="fa fa-angle-down reg-angle-icon" id="reg-district-icon" aria-hidden="true"></i>
                                            <br>
                                        </div>

                                        <div class="col">
                                            <label for="reg-hometown">{{ __('Home Town') }} <span class="required"></span> </label>
                                            <input type="text" class="form-control sign-input" onClick="this.select();" autocomplete="off" name="reg-hometown" id="reg-hometown" placeholder="Select your home town" />
                                            <i class="fa fa-angle-down reg-angle-icon" id="reg-hometown-icon" aria-hidden="true"></i><br>
                                        </div>

                                    </div>

                                    <!-- <div class="row">
                                        <div class="col">
                                            <label for="reg-phoneno">{{ __('Phone Number') }} <span class="required"></span> </label>
                                            <input type="tel" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" class="form-control sign-input" style="padding-left: 40px;" name="reg-phoneno" id="reg-phoneno" />
                                            <span class="mob-contry-code">+94</span>
                                            <br>
                                        </div>
                                    </div> -->

                                </div>
                                <div class="col-md-6 pl-25">
                                    <p class="text-center col-title">Sign-In Inforamtion</p>
                                    <hr>
                                    <label for="email">{{ __('Email') }} <span class="required"></span> </label>
                                    <input type="email" class="form-control sign-input" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" placeholder="Enter your email address" /><br />
                                    <div class="row">
                                        <div class="col">
                                            <label for="password">{{ __('Password') }} <span class="required"></span> </label>
                                            <input type="password" class="form-control sign-input pr-30" name="password" required autocomplete="current-password" id="password" placeholder="Enter your password" required autocomplete="current-password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"><br>
                                            <span toggle="#password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>
                                        </div>

                                        <div class="col">
                                            <label for="confirm-password">{{ __('Confirm Password') }} <span class="required"></span> </label>
                                            <input type="password" class="form-control sign-input pr-30" required autocomplete="current-password" id="confirm-password" placeholder="Enter your password" required autocomplete="current-password" /><br>
                                            <span toggle="#confirm-password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>
                                        </div>
                                    </div>

                                    <div class="form-check check-form">
                                        <input class="form-check-input" name="newletters" type="checkbox" value="1" id="newletters" checked>
                                        <label class="form-check-label " for="newletters">
                                            Sign Up for Newsletter
                                        </label>
                                    </div>
                                    <button type="button" class="btn btn-primary reg-button button-reg-1">
                                        Register
                                    </button>
                                    <input type="submit" value="" id="form-submit" style="display: none;">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
    $.fn.cornerpopup({
        variant: 10,
        slide: 1,
        escClose: 1,
        content: "<div class='hide-mobile p-sm-8 pop-up-img-div'><img src='/img/img-3.png' align='center' class='responsive pop-up-img'></div> <div> <div class='corner-container'><p class='corner-head'> BECOME A SELLER ON <br> LAK MARKET </p><a href='{{route('login')}}' onclick='loginCall();' class='corner-btn-close'>Create Your Business Account</a></div></div>",
    });
</script>

<script src="{{ asset('js/register.js') }}" defer></script>
@endsection