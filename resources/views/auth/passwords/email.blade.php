@extends('layouts.app')

@section('content')

<div class="content site-container" style="background-image:url('/img/sign-bg.png');background-size: contain; ">
    <div class="form-content">
        <div class="container ">
            <div class="col-md-12">
                <div class="row jc-c">
                    <div class="col-md-5">
                        <form method="POST" action="{{ route('reset.password') }}">
                            @csrf
                            <div class="welcome-window">
                                <p class="fw-bold text-center welcome-msg">{{ __('Reset Password') }}</p>
                                <div class="reset-img" style="background-image:url('/img/padlock.png');"> </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="email">{{ __('Email Address') }} <span class="required"></span> </label>
                                            <input type="email" class="form-control sign-input" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" id="email" placeholder="Enter your email address" /><br />
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-secondary submit-button button-2">
                                        {{ __('Send Password Reset Link') }}
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
</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/verify.js') }}" defer></script>
@endsection