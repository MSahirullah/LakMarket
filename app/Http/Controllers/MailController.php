<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Mail\RegisterMail;
use App\Mail\SellerRegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public static function sendRegisterMail($name, $email, $verfication_code)
    {
        $data = [
            'name' => $name,
            'verification_code' => $verfication_code,
        ];

        Mail::to($email)->send(new RegisterMail($data));
    }

    public static function sendPasswordResetMail($email, $resetLink)
    {
        $data = [
            'resetLink' => $resetLink,
        ];

        Mail::to($email)->send(new PasswordReset($data));
    }

    public static function sendSellerVerificationMail($email, $verification_code)
    {
        $data = [
            'verification_code' => $verification_code,
        ];

        Mail::to($email)->send(new SellerRegisterMail($data));
    }
}
