<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Session;

class LoginController extends Controller
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
        $email = $req['email'];
        $password = $req['password'];

        // $user = CustomerModel::where(['email' => $email, 'blacklisted' => '0', 'delete_status' => '0'])->first();
        $customer = CustomerModel::where(['email' => $email, 'blacklisted' => '0', 'delete_status' => '0', 'is_verified' => 1])->first();

        if ($customer) {

            if (Hash::check($password, $customer->password)) {
                FacadesAuth::login($customer);
                $req->session()->put('customer', $customer);
                return redirect()->route('home');
            }
            Session::flash('loginStatus', 'The passowrd is incorrect.');
            return redirect()->back();
        }
        
        Session::flash('loginStatus', "The email doen't have a Lak Market account. Please Register.");
        return redirect()->back();
    }

    public function logout()
    {
        FacadesAuth::logout();
        Session::flush();
        return redirect('/');
        // return redirect()->route('home');
    }
}
