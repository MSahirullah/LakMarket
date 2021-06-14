<?php

namespace App\Http\Controllers;

use App\Models\newsletters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewsletterController extends Controller
{
    public function addNewsletter(Request $request)
    {

        $newsletters = new newsletters();

        //check customer email already exists
        $valid_email = newsletters::where(['email' => $request['email']])->first();


        if ($valid_email != null) {
            Session::flash('status', ['1', 'This Email Address already subscribed.']);
            return redirect()->back();
        }

        $newsletters->email = $request['email'];
        $newsletters->save();

        Session::flash('status', ['0', 'You have successfully subscribed for newsletters.']);
        return redirect()->back();
    }
}
