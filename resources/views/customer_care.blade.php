@extends('layouts.app')

@section('content')

<div class="content" style="background-image:url('/img/sign-bg.png');background-size: contain; ">
    <div class="container c-p mt--30">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">Customer Care</a>
    </div>
    <div class="form-content">
        <div class="container">
            <div class="row jc-c">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('send-enquiry') }}">
                        @csrf
                        <input type="hidden" name="role" value="ROLE_CUSTOMER">
                        <div class="welcome-window">
                            <p class="fw-bold welcome-msg ">How can we help you? </p>
                            <p class="welcome-desc">For all enquiries, Please email us using the form below. </p>
                            <div class="row">
                                <div class="col">
                                    <label for="name">{{ __('Full Name') }} <span class="required"></span> </label>
                                    <input type="text" class="form-control sign-input required" onkeypress="return /[a-z]/i.test(event.key)" name="full_name" required autocomplete="name" autofocus id="name" placeholder="Enter your full name" value="{{(Session::has('customer'))?(Session::get('customer')['first_name'])." ". (Session::get('customer')['last_name']):''}}" /><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="email">{{ __('Email') }} <span class="required"></span> </label>
                                    <input type="email" class="form-control sign-input" name="email" required autocomplete="email" id="email" placeholder="Enter your email" value="{{(Session::has('customer'))?(Session::get('customer')['email']):''}}" />
                                </div>
                                <div class="col">
                                    <label for="phoneno">{{ __('Phone Number') }} <span class="required astrike-hide"></span> </label>
                                    <input type="text" class="form-control sign-input" name="mobile_no" id="mobile_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" pattern="[0]{1}[7]{1}[0-8]{1}[0-9]{7}" placeholder="Enter your phone number" value="{{(Session::has('customer'))?(Session::get('customer')['mobile_no']):''}}" /><br>
                                </div>
                            </div>
                            <div class="form-floating">
                                <label for="enquiry">Enquiry <span class="required"></span> </label>
                                <textarea class="form-control signin-input cc-enquiry" name="enquiry" id="enquiry" required></textarea>

                            </div>
                            <button type="submit" class="btn btn-primary submit-button button-1">
                                Send <i class="fas fa-paper-plane pl--5"></i>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection