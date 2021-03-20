<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public static function sendRegisterMail($name, $email, $verfication_code, $datetime)
    {
        $data = [
            'name' => $name,
            'verification_code' => $verfication_code,
            'datetime' =>  $datetime
        ];

        Mail::to($email)->send(new RegisterMail($data));
    }
}
