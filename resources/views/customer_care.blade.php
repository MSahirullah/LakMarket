@extends('layouts.app')

@section('content')

<div class="content">
    <div class="form-content">
        <div class="titlebar">
            <a href=""><i class="fa fa-chevron-left titlebar-icon" aria-hidden="true"></i>
                <span class="titlebar-title">CUSTOMER CARE</span></a>
        </div>
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="welcome-window">
                                <p class="fw-bold welcome-msg ">How can we help you? </p>
                                <p class="welcome-desc">For all enquiries, Please email us using the form below. </p>
                                <div class="row">
                                    <div class="col">
                                        <label for="name">{{ __('Full Name') }} <span class="required"></span> </label>
                                        <input type="text" class="form-control sign-input required" name="name" required autocomplete="name" autofocus id="name" /><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="email">{{ __('Email') }} <span class="required"></span> </label>
                                        <input type="email" class="form-control sign-input" name="email" required autocomplete="email" id="email" /><br>
                                    </div>
                                    <div class="col">
                                        <label for="phoneno">{{ __('Phone Number') }} <span class="required astrike-hide"></span> </label>
                                        <input type="text" class="form-control sign-input" name="phoneno" id="phoneno" value="+94" /><br>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <label for="enquiry">Enquiry <span class="required"></span> </label>
                                    <textarea class="form-control signin-input cc-enquiry" name="enquiry" id="enquiry" required></textarea>

                                </div>
                                <button type="submit" class="btn btn-primary submit-button button-1">
                                    Send
                                </button>

                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="img/customer-care-img.svg" class="img-fluid cc-image" alt="CUSTOMER CARE IMAGE" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection