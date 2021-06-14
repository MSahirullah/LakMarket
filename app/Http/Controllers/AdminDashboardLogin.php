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
            } else if (!$admin->is_verified) {

                $admin->verification_code = bin2hex(random_bytes(32));
                $admin->save();

                $name = $admin->first_name . ' ' . $admin->last_name;
                MailController::sendAdminVerificationMail($name, $admin->email, $admin->verification_code);

                Session::flash('status', ['2', 'Please verify your email account.', $admin->id]);
                return view('auth.admin_verify');

            } else if ($admin->password != $password) {
                Session::flash('status', ['1', "The password you entered is incorrect."]);
                return redirect()->back();
            } else {
                Cookie::queue(Cookie::make('valSideBar', '0'));
                $req->session()->put('admin', $admin->id);
                return redirect('admin/dashboard');
            }
        }

        Session::flash('status', ['1', "The email doen't have a Lak Market Admin account."]);
        return redirect()->back();
    }
}

//if (!$seller || !Hash::check($password, $seller->password)) {