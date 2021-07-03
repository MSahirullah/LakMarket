<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        $seller = Seller::where(['business_email' => $email, 'delete_status' => '0'])->first();

        if ($seller) {
            if ($seller->blacklisted) {
                Session::flash('status', ['1', "Sorry you can't login with this email address. (RSN : Blacklisted)"]);
                return redirect()->back();
            } elseif (!$seller->verified_seller) {
                Session::flash('status', ['2', "Your details have not yet been confirmed. Please login back in once the details are confirmed."]);
                return redirect()->back();
            } elseif (!Hash::check($password, $seller->password)) {
                Session::flash('status', ['1', "The password you entered is incorrect."]);
                return redirect()->back();
            } else {

                Cookie::queue(Cookie::make('valSideBar', '0'));
                $req->session()->put('seller', $seller->id);
                return redirect('seller/dashboard');
            }
        }
        Session::flash('status', ['1', "The email doen't have a Lak Market Seller account. Please Register."]);
        return redirect()->back();
    }
}


//if (!$seller || !Hash::check($password, $seller->password)) {