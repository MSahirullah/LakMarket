<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lak Market | Seller Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- icheck bootstrap -->

    <link rel="stylesheet" href="{{ URL::asset('css/sellercss/login.css') }}">



    <script>
        var post_token = "{{ csrf_token() }}";
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{ asset('js/sellerjs/login.js') }}" defer></script>



</head>

<body>
    <div class="login-body">
        <div class="card d-login-window">
            <p class="card-header text-center">
                <span class="d-login-t1">LAK MARKET</span>
                <br>
                <span class="d-login-t2">Seller Login</span>
            </p>
            <form method="POST" action="{{route('seller.login')}}" class='d-login-form'>
                @csrf
                <p class="d-login-desc">Please login to continue.</p>


                @if (session('status'))
                <p>{{Session::get('status')}}</p>
                @endif

                @if(Session::has('invalidEmail'))
                <p class="alert alert-danger bsalert">{{ Session::get('invalidEmail') }}</p>
                @endif

                <div class="mb-3">
                    <label for="d-email">{{ __('Email') }} <span class="required"></span> </label>
                    <input type="d-email" class="form-control sign-input" name="d-email" value="{{ old('email') }}" autofocus id="d-email" placeholder="Enter your email" required><br />


                    <label for="d-password">{{ __('Password') }} <span class="required"></span> </label>
                    <input type="password" class="form-control sign-input" name="d-password" id="d-password" placeholder="Enter your password" required><br />
                    <span toggle="#d-password" class="far fa-fw fa-eye sign-field-icon toggle-password"></span>

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
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>
    <footer class="bg-light d-login-footer">
        <div class="text-right p-3">
            <a href="#">Contact Us</a>
        </div>
    </footer>
</body>



</html>