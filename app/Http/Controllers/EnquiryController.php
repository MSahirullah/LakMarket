<?php

namespace App\Http\Controllers;

use App\Models\Enquiries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{
    public function index()
    {
        return view('customer_care');
    }

    public function sendEnquiry(Request $request)
    {
        $enquiry = new Enquiries();

        $enquiry->full_name = ucfirst($request['full_name']);
        $enquiry->email = $request['email'];
        $enquiry->mobile_no  = $request['mobile_no'];
        $enquiry->enquiry     = $request['enquiry'];
        $enquiry->role = $request['role'];
        $enquiry->save();

        Session::flash('status', ['0', 'Your enquiry has been successfully sent. You will get a reply soon.']);
        return redirect('/');
    }
}
