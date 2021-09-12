@extends('layouts.app')
@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection
@section('content')

<div class="content" style="background-image:url('/img/sign-bg.png');background-size: contain; ">

    @if(Session::has('loginStatus'))
    <div id="status" data="{{ Session::get('loginStatus') }}"></div>
    @endif
    <div class="form-content">
        <div class="container site-container">
            <div class="col-md-12">
                <div class="row jc-c">
                    <div class="col-md-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="welcome-window">
                                <p class="fw-bold text-center welcome-msg">Welcome to Lak Market!</p>
                                <hr>
                                <div>
                                    <p class="welcome-desc lg">New to Lak Market? <a href="{{route('register')}}">Register</a> here.</p>
                                </div>
                                <div>
                                    <label for="email">{{ __('Email') }} <span class="required"></span> </label>
                                    <input type="email" class="form-control sign-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email" placeholder="Enter your email" /><br />


                                    <label for="password">{{ __('Password') }} <span class="required"></span> </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror sign-input pr-30" name="password" required autocomplete="current-password" id="password" placeholder="Enter your password" /><br />
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

                                    <button type="submit" class="btn btn-primary submit-button button-1">
                                        Sign In
                                    </button>
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
<script src="{{ asset('js/login.js') }}" defer></script>
@endsection