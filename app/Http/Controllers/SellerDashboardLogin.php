<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class SellerDashboardLogin extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req)
    {
        $email = $req['d-email'];
        $password = $req['d-password'];

        $seller = Seller::where([business_em'ail' => $email, 'delete_status' => '0'])->first();

        if ($seller) {
            if ($seller->blacklisted) {
                return redirect()->back()->with(session()->put('invalidEmail', "Sorry you can't login with this email address. (RSN : Blacklisted)"));
            }
            if ($seller->password != $password) {

                return redirect()->back()->with(session()->put('invalidEmail', 'The email or password you entered is incorrect.'));
            } else {

                Cookie::queue(Cookie::make('valSideBar', '0'));
                $req->session()->put('seller', $seller->id);
                return redirect('seller/dashboard');
            }
        }
        return redirect()->back()->with(session()->put('invalidEmail', 'The email or password you entered is incorrect.'));
    }
}


//if (!$seller || !Hash::check($password, $seller->password)) {