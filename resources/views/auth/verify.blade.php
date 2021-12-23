@extends('layouts.app')
@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection
@section('content')

<div class="content site-container" >
    <div class="form-content">
        <div class="container">
            <div class="col-md-12">
                <div class="row jc-c">
                    <div class="col-md-5">
                        <div class="welcome-window">
                            <p class="fw-bold text-center welcome-msg">Verify Your Email Address</p>
                            <div class="success-img" style="background-image:url('/img/check-mark.png');"> </div>
                            <div>
                                <p class="mb-8 text-center">{{ __('Before proceeding, please check your email for a verification link.') }}<br>{{ __('If you did not receive the email,') }}
                                </p>
                                <form method="POST" action="{{ route('verification.resend') }}" id="verifyForm">
                                    @csrf
                                    @if(Session::has('status'))
                                    <input type="hidden" name="cus_id" value="{{Session::get('status')[2]}}">
                                    @endif
                                    <button type="button" class="btn btn-success submit-button button-3" id="verifyBtn" disabled>
                                        Click Here to Resend <span class="timer">(<span id="timer">60</span>)</span>
                                    </button>
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