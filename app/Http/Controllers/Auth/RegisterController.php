<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MailController;
use DateTime;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'reg-name' => ['required', 'string', 'max:255'],
            'reg-email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'reg-password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function register(Request $request)
    {

        $validate_date = $request->validate([
            "password" => 'required|min:8'

        ]);

        $customer = new Customers();
        $dt = new DateTime();

        // $customer->full_name = $request->{'reg-name'};

        //Check Email already exists
        $valid_email_data = Customers::where(['email' => $request->{"reg-email"}])->first();

        if ($valid_email_data != null) {

            if ($valid_email_data->blacklisted) {
                return redirect()->back()->with(session()->flash('invalidEmail', "Sorry you can't register with this email address. (RSN : Blacklisted)"));
            }

            if ($valid_email_data->delete_status) {
                $customer = $valid_email_data;
            } else {
                return redirect()->back()->with(session()->flash('invalidEmail', 'This email address already exists. Please Sign-in.'));
            }
        }

        $customer->full_name = $request->{"reg-name"};
        $customer->email = $request->{"reg-email"};
        $customer->mobile_no = $request->{"reg-phoneno"};
        $customer->hometown = $request->{"reg-hometown"};
        $customer->district = $request->{"reg-district"};
        $customer->password = Hash::make($request->{"password"});
        $customer->verification_code = sha1(time());
        $customer->delete_status = 0;
        $customer->last_logged_at = $dt->format('Y-m-d H:i:s');
        $customer->save();

        if ($customer != null) {

            MailController::sendRegisterMail(
                $customer->full_name,
                $customer->email,
                $customer->verification_code,
                $customer->last_logged_at
            );
            return redirect()->back()->with(session()->flash('regMailStatus', ['cls' => 'alert-success', 'message' => 'Your account has been created. Please check your inbox for verification link.']));
        }
        return redirect()->back()->with(session()->flash('regMailStatus', ['cls' => 'alert-danger', 'message' => 'Something went wrong. Please try again later.']));
    }

    
    public function verifyUser(Request $request)
    {
        $verfication_code = $request['code'];
        $user = User::where(['verification_code' => $verfication_code])->first();

        if ($user != null) {
            $user->is_verified = 1;
            $user->save();

            return redirect()->route('login')->with(session()->flash('alert-success', 'Your account is verified. Please Login.'));
        }
        return redirect()->route('login')->with(session()->flash('alert-danger', 'Your Verification is invalid'));
    }

}
