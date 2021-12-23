@extends('layouts.app')
@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy  |
@endsection 
@section('content')

<div class="content" >

    @if(Session::has('loginStatus'))
    <div id="status" data="{{ Session::get('loginStatus') }}"></div>
    @endif
    <div class="form-content">
        <div class="container site-container">
            <div class="col-md-12">
                <div class="row jc-c">
                    <div class="col-md-5">
                        <form method="POST" action="{{ route('update.password') }}">
                            @csrf
                            <div class="welcome-window">
                                <p class="fw-bold text-center welcome-msg">Change Your Password</p>
                                <hr>
                                <div class="reset-img" style="background-image:url('img/reset-icon.png');"> </div>
                                <div>
                                    <input type="hidden" name="token" value="{{ $token }}">



                                    <label for="password">{{ __('New Password') }} <span class="required"></span> </label>
                                    <input type="password" class="form-control sign-input" name="password" required autocomplete="current-password" id="password" placeholder="Enter your password" required autocomplete="current-password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"><br>
                                    <span toggle="#password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>



                                    <label for="confirm-password">{{ __('Confirm Password') }} <span class="required"></span> </label>
                                    <input type="password" class="form-control sign-input" required autocomplete="current-password" id="confirm-password" placeholder="Enter your password" required autocomplete="current-password" /><br>
                                    <span toggle="#confirm-password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>


                                    <button type="button" class="btn btn-success submit-button button-4 button-reg-4">
                                        Change Password
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
<script src="{{ asset('js/reset.js') }}" defer></script>
@endsection