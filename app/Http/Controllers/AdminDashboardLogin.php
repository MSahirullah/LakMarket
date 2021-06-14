<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

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

        $admin = administrator::where(['email' => $email])->first();

        if ($admin) {
            #if ($admin->blacklisted) {
             #   return redirect()->back()->with(session()->put('invalidEmail', "Sorry you can't login with this email address. (RSN : Blacklisted)"));
            #}
            if ($admin->password != $password) {

                return redirect()->back()->with(session()->put('invalidEmail', 'The email or password you entered is incorrect.'));
            } else {

                Cookie::queue(Cookie::make('valSideBar', '0'));
                $req->session()->put('admin', $admin->id);
                return redirect('admin/dashboard');
            }
        }
        return redirect()->back()->with(session()->put('invalidEmail', 'The email or password you entered is incorrect.'));
    }
}

//if (!$seller || !Hash::check($password, $seller->password)) {