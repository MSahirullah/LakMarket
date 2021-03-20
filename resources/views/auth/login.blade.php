@extends('layouts.app')

@section('content')


<body>
    <div class="content">
        <div class="form-content">
            <div class="titlebar">
                <a href="#"><i class="fa fa-chevron-left titlebar-icon" aria-hidden="true"></i>
                    <span class="titlebar-title">SIGN IN</span></a>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="welcome-window">
                                    <p class="fw-bold welcome-msg">Welcome to Lak Market!</p>
                                    <p class="welcome-desc">Please Sign-in.</p>

                                    <div class="mb-3">
                                        <label for="email">{{ __('Email') }} <span class="required"></span> </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror sign-input" name="reg-email" value="{{ old('email') }}" required autocomplete="email" autofocus id="reg-email" placeholder="Enter your email" /><br />

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="inputPassword">{{ __('Password') }} <span class="required"></span> </label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror sign-input" name="password" required autocomplete="current-password" id="password" placeholder="Enter your password" /><br />
                                        <span toggle="#password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>



                                        <span class=" form-check text-right">
                                            <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label sign-in-remember" for="remember">
                                                Remember me
                                            </label>
                                        </span>
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-left">
                                            <span class="sign-in-forget">Forget Password?</span> <br /></a>
                                        @endif


                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <button type="submit" class="btn btn-primary submit-button button-1">
                                            Sign In
                                        </button>

                                    </div>
                                    <div class="sign-new"><span>New To LAK MARKET</span></div>

                                    <button type="submit" class="btn btn-primary submit-button button-1">
                                        Create Your Account
                                    </button>
                                    <button type="submit" class="btn btn-secondary submit-button button-2">
                                        Become A Seller
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7 text-center">
                            <img src="img/login-img.svg" class="img-fluid sign-image" alt="LOGIN IMAGE" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>













<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href=>
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection