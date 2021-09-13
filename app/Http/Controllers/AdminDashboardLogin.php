<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminDashboardLogin extends Controller
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

        $admin = administrator::where(['email' => $email, 'delete_status' => '0'])->first();

        if ($admin) {
            if ($admin->blacklisted) {
                Session::flash('status', ['1', "Sorry you can't login with this email address. (RSN : Blacklisted)"]);
                return redirect()->back();
            } else if (Hash::check($password, $admin->password)) {
                Cookie::queue(Cookie::make('valSideBar', '0'));
                $req->session()->put('admin', $admin->id);
                return redirect('admin/dashboard');
            } else {
                Session::flash('status', ['1', "The password you entered is incorrect."]);
                return redirect()->back();
            }
        }

        Session::flash('status', ['1', "The email doen't have a Lak Market Admin account."]);
        return redirect()->back();
    }
}

//if (!$seller || !Hash::check($password, $seller->password)) {