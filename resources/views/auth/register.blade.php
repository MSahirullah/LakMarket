@extends('layouts.app')

@section('content')

<script>
    var post_token = "{{ csrf_token() }}";
</script>

<body>
    <div class="content">
        <div class="form-content">
            <div class="titlebar">
                <a href="#"><i class="fa fa-chevron-left titlebar-icon" aria-hidden="true"></i>
                    <span class="titlebar-title">SIGN UP</span></a>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="welcome-window">
                                <p class="fw-bold welcome-msg">Welcome to Lak Market!</p>
                                <p class="welcome-desc">Create your account.</p>

                                @if(Session::has('regMailStatus'))
                                <p class="alert {{ Session::get('regMailStatus')['cls']}} bsalert">{{ Session::get('regMailStatus')['message']}}</p>
                                @endif

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <label for="reg-name">{{ __('Full Name') }} <span class="required"></span> </label>
                                            <input type="text" class="form-control sign-input" name="reg-name" value="{{ old('name') }}" required autocomplete="reg-name" autofocus id="reg-name" placeholder="Enter your first name & last name"><br>
                                        </div>

                                    </div>

                                    <label for="reg-email">{{ __('Email') }} <span class="required"></span> </label>
                                    <input type="email" class="form-control sign-input" name="reg-email" value="{{ old('email') }}" required autocomplete="reg-email" id="reg-email" placeholder="Enter your email address" /><br />

                                    @if(Session::has('invalidEmail'))
                                    <p class="alert alert-danger bsalert">{{ Session::get('invalidEmail') }}</p>
                                    @endif

                                    <div class="row">
                                        <div class="col autocomplete">
                                            <label for="reg-district">{{ __('District') }} <span class="required"></span> </label>

                                            <input type="text" class="form-control sign-input" autocomplete="off" name="reg-district" id="reg-district" placeholder="Select your district" />
                                            <i class="fa fa-angle-down reg-angle-icon" id="reg-district-icon" aria-hidden="true"></i>
                                            <br>
                                        </div>

                                        <div class="col">
                                            <label for="reg-hometown">{{ __('Home Town') }} <span class="required"></span> </label>
                                            <input type="text" class="form-control sign-input" autocomplete="off" name="reg-hometown" id="reg-hometown" placeholder="Select your home town" />
                                            <i class="fa fa-angle-down reg-angle-icon" id="reg-hometown-icon" aria-hidden="true"></i><br>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="reg-phoneno">{{ __('Phone Number') }} <span class="required"></span> </label>
                                            <input type="tel" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" class="form-control sign-input" style="padding-left: 40px;" name="reg-phoneno" id="reg-phoneno" />
                                            <span class="mob-contry-code">+94</span>
                                            <br>
                                        </div>

                                        <div class="col">

                                            <label for="reg-password">{{ __('Password') }} <span class="required"></span> </label>
                                            <input type="password" class="form-control sign-input" name="password" required autocomplete="current-password" id="password" placeholder="Enter your password" /><br>
                                            <span toggle="#reg-password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>
                                        </div>
                                    </div>

                                    @error('password')
                                    <p class="alert alert-danger bsalert">{{$message}}</p>
                                    @enderror

                                    <button type="submit" class="btn btn-primary reg-button button-reg-1">
                                        Register
                                    </button>

                                </form>


                                <div class="reg-new"><span>Register As Seller</span></div>
                                <a href="/become-a-seller" class="btn btn-secondary reg-button button-reg-3">
                                    Become A Seller
                                </a>

                                <div class="reg-new"><span>Already Customer Of LAK MARKET</span></div>
                                <a href="/login" class="btn btn-primary reg-button button-reg-2">
                                    Sign In
                                </a>

                            </div>

                        </div>

                        <div class="col-md-6 text-center">
                            <img src="img/register-img.svg" class="img-fluid reg-image" alt="LOGIN IMAGE" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>

</script>

@endsection