<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    public function getPassword(Request $request)
    {

        $token = $request->query('token');

        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $updatePassword = DB::table('password_resets')
            ->where(['token' => $request->token])
            ->first();

        if (!$updatePassword) {
            Session::flash('status', ['1', 'Your password reset token is invalid']);
            return redirect('login');
        }

        $customer = CustomerModel::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

        Session::flash('status', ['0', 'Your password has been changed. Please login.']);
        return redirect('/login');
    }
}
