<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Customer;
use App\Models\CustomerModel;
use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Carbon\Carbon;

use function Complex\exp;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return CustomerModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function register(Request $request)
    {
        $customer = new CustomerModel();

        //check customer email already exists
        $valid_email = CustomerModel::where(['email' => $request['email'], 'blacklisted' => '0', 'delete_status' => '0'])->first();


        if ($valid_email != null) {
            Session::flash('regStatus', ['1', 'This Email Address already exists. Please sign in.']);
            return redirect()->back();
        }

        $districtId = DB::table('lkdistricts')
            ->select('id')
            ->where('name_en', $request['reg-district'])
            ->get();

        $districtId = json_decode($districtId, true)[0]['id'];

        $cityID = DB::table('lkcities')
            ->select('id')
            ->where(['name_en' => $request['reg-hometown'], 'district_id' => $districtId])
            ->get();

        $cityID = json_decode($cityID, true)[0]['id'];

        // dd($request);
        $newsletterStatus = 0;
        if ($request['newletters']) {
            $newsletterStatus = $request['newletters'];
        }

        $customer->first_name = ucfirst($request['first-name']);
        $customer->last_name = ucfirst($request['last-name']);
        $customer->email  = $request['email'];
        $customer->verification_code = bin2hex(random_bytes(32));
        $customer->password = Hash::make($request->password);
        $customer->newsletters = $newsletterStatus;
        $customer->district_id  = $districtId;
        $customer->city_id   = $cityID;
        $customer->save();

        if ($customer != null) {
            $name = $customer->first_name . ' ' . $customer->last_name;
            MailController::sendRegisterMail($name, $customer->email, $customer->verification_code);

            Session::flash('status', ['0', 'Your account has been created. Please check email for verification link.', $customer->id]);
            return view('auth.verify');
        }
        Session::flash('regStatus', ['1', 'Something went wrong. Please try again later.']);
        return redirect()->back();
    }

    public function resendVerification(Request $req)
    {
        $customer = CustomerModel::where(['id' => $req['cus_id']])->first();

        $verification_code = bin2hex(random_bytes(32));

        if ($customer->is_verified == 0) {

            $customer = Customer::where('id', $req['cus_id'])
                ->update(['verification_code' => $verification_code]);

            $name = $customer->first_name . ' ' . $customer->last_name;
            MailController::sendRegisterMail($name, $customer->email, $customer->verification_code);

            Session::flash('status', ['0', 'Your account has been created. Please check email for verification link.', $customer->id]);
            return view('auth.verify');
        }
        Session::flash('regStatus', ['1', 'Something went wrong. Please try again later.']);
        return redirect()->route('register');
    }

    public function verifyCustomer(Request $request)
    {
        $verfication_code = $request->query('code');
        $customer = CustomerModel::where(['verification_code' => $verfication_code])->first();

        if ($customer != null) {

            $customer->is_verified = 1;
            $customer->email_verified_at = Carbon::now();
            $customer->save();

            FacadesAuth::login($customer);
            Session::flash('status', ['0', 'Your account is verified  successfully.']);
            $request->session()->put('customer', $customer);

            return redirect()->route('home');
        }
        Session::flash('status', ['1', 'Your Verification is invalid.']);
        return redirect()->route('register');
    }

    public function sellerRegister(Request $request)
    {
        $seller = new Seller();

        //check customer email already exists
        $valid_email = Seller::where(['business_email' => $request->email, 'blacklisted' => '0', 'delete_status' => '0'])->first();

        $verCode = strval(random_int(100000, 999999));

        if ($valid_email != null) {
            if ($valid_email->is_verified) {
                return [1, 'This Email Address already exists. Please sign in.'];
            } else if ($valid_email->verification_code) {
                $seller = Seller::where('business_email',  $request->email)
                    ->update(['verification_code' => $verCode]);
            }
        } else {
            $seller->business_email = $request->email;
            $seller->verification_code = $verCode;
            $seller->save();
        }

        if ($seller != null) {
            MailController::sendSellerVerificationMail($request->email, $verCode);
            return [0, 'Before proceeding, Please check email for verification code.'];
        }
        return [1, 'Something went wrong. Please try again later.'];
    }

    public function sellerVerify(Request $request)
    {
        $d1 = $request->digit_1;
        $d2 = $request->digit_2;
        $d3 = $request->digit_3;
        $d4 = $request->digit_4;
        $d5 = $request->digit_5;
        $d6 = $request->digit_6;

        $code = $d1 . $d2 . $d3 . $d4 . $d5 . $d6;
        $email = $request->email;

        $seller = Seller::where(['verification_code' => $code, 'business_email' => $email])->first();

        if ($seller != null) {
            $seller->is_verified = 1;
            $seller->email_verified_at = Carbon::now();
            $seller->save();

            return [0, 'Your email is verified  successfully.'];
        }

        return [1, 'The verification is invalid. Please check your email and try again.'];
    }

    public function sellerSubmit(Request $request)
    {
        $email = $request->email;

        $seller = Seller::where(['business_email' => $email, 'is_verified' => 1])->first();

        if ($seller != null) {

            $districtId = DB::table('lkdistricts')
                ->select('id')
                ->where('name_en', $request['reg_district'])
                ->get();

            $districtId = json_decode($districtId, true)[0]['id'];

            $cityID = DB::table('lkcities')
                ->select('id')
                ->where(['name_en' => $request['reg_hometown'], 'district_id' => $districtId])
                ->get();

            $cityID = json_decode($cityID, true)[0]['id'];

            $sellerURL = $this->slug($request->business_name . '-' . json_decode($seller, true)['id']);

            $seller->full_name = $request->full_name;
            $seller->store_name = $request->business_name;
            $seller->shop_category_id = $request->selectCategory;
            $seller->business_mobile = $request->bMobile;
            $seller->hotline = $request->bHotline;
            $seller->address = $request->address;
            $seller->district_id = $districtId;
            $seller->city_id = $cityID;
            $seller->latitude = $request->location_lo;
            $seller->longitude = $request->location_la;
            $seller->is_cod_available = $request->cashOnDel;
            $seller->url = $sellerURL;
            $seller->save();

            return [0, 'Thank you! Your information has been submitted.'];
        }

        return [1, 'Something went wrong. Please try again later.'];
    }

    public static function slug($text)
    {
        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = str_replace(' ', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
