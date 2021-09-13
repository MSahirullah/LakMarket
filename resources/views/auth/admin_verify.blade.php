<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lak Market | Administrator Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- icheck bootstrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillatoasts@1.4.0/vanillatoasts.min.css">

    <link rel="stylesheet" href="{{ URL::asset('/css/admincss/login.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/sellercss/login.css') }}">
    <link href="{{ URL::asset('css/common.css') }}" rel="stylesheet">



    <link href="{{ URL::asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/register.css') }}" rel="stylesheet">







    <script>
        var post_token = "{{ csrf_token() }}";
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillatoasts@1.4.0/vanillatoasts.min.js"></script>
    <script src="{{ asset('/js/adminjs/login.js') }}" defer></script>
    <script src="{{ asset('/js/adminjs/common.js') }}" defer></script>

    <script src="{{ asset('/js/adminjs/verify.js') }}" defer></script>

</head>

<body>

    <div class="content site-container" style="background:#e9ecef">
        <div class="form-content">
            <div class="container">
                <div class="col-md-12">
                    <div class="row jc-c">
                        <div class="col-md-5">
                            <div class="welcome-window mt-145">
                                <p class="fw-bold text-center welcome-msg">Verify Your Email Address</p>
                                <div class="success-img" style="background-image:url('/img/check-mark.png');"> </div>
                                <div>
                                    <p class="mb-8 text-center">{{ __('Before proceeding, please check your email for a verification link.') }}<br>{{ __('If you did not receive the email,') }}
                                    </p>
                                    <form method="POST" action="{{ route('admin.verification_resend') }}" id="verifyForm">
                                        @csrf
                                        @if(Session::has('status'))
                                        <input type="hidden" name="admin_id" value="{{Session::get('status')[2]}}">
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
    <footer class="bg-light d-login-footer">
        <div class="text-right p-3">
            <a href="#">Contact Us</a>
        </div>
    </footer>
</body>

</html>