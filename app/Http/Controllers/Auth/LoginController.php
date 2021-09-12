<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\CustomerModel;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
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
        $customer = CustomerModel::where(['email' => $email, 'blacklisted' => '0', 'delete_status' => '0'])->first();

        if ($customer) {

            if (!$customer->is_verified) {

                $customer->verification_code = bin2hex(random_bytes(32));
                $customer->save();

                $name = $customer->first_name . ' ' . $customer->last_name;
                MailController::sendRegisterMail($name, $customer->email, $customer->verification_code);

                Session::flash('status', ['3', 'Please verify your email account.', $customer->id]);
                return view('auth.verify');
            } else if (Hash::check($password, $customer->password)) {

                $city = DB::table('lkcities')
                    ->join('lkdistricts', 'lkdistricts.id', '=', 'lkcities.district_id')
                    ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
                    ->where('lkcities.id', $customer->city_id)
                    ->select('lkcities.name_en as city', 'lkdistricts.name_en as district', 'lkprovinces.name_en as province')

                    ->get();

                $location = json_decode($city, true)[0];

                FacadesAuth::login($customer);
                $req->session()->put('customer', $customer);
                $value = [];
                $value['0'] = $city[0]->city;
                $value['1'] = '3';
                $value['2'] = array($location['province'], $location['district'],  $location['city']);
                $req->session()->put('customer-city', $value);

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
