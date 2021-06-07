<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mail;

use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    public function postEmail(Request $request)
    {
        $token = bin2hex(random_bytes(32));

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        MailController::sendPasswordResetMail($request->email, $token);

        Session::flash('status', ['0', 'Your password reset email has been sent. Please check your email.']);
        return view('auth.login');
    }
}
