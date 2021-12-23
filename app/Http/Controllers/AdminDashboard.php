<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AdminDashboard extends Controller
{

    public function contactUs()
    {

        $adminId = Session::get('admin');


        if (!$adminId) {

            return redirect()->route('admin.loginV');
        }

        return (view('admin.dashboard_contact'));
    }

    public function queries()
    {
        $adminId = Session::get('admin');

        if (!$adminId) {
            return redirect()->route('admin.loginV');
        }

        return (view('admin.dashboard_queries'));
    }

    public function reviews()
    {
        $adminId = Session::get('admin');

        if (!$adminId) {
            return redirect()->route('admin.loginV');
        }

        return (view('admin.dashboard_reviews'));
    }

    public function newsletterRequests()
    {
        $adminId = Session::get('admin');

        if (!$adminId) {
            return redirect()->route('admin.loginV');
        }

        return (view('admin.dashboard_newsletter_requests'));
    }

    function index(Request $request)
    {
        $adminId = Session::get('admin');

        if (!$adminId) {
            return redirect()->route('admin.loginV');
        }

        $data = DB::table('administrators')
            ->where('id', "=",  $adminId)
            ->select('full_name', 'profile_photo')
            ->get();

        $data[0]->profile_photo = "/" . $data[0]->profile_photo;

        $request->session()->put('adminName', $data[0]->full_name);

        $request->session()->put('adminImage', $data[0]->profile_photo);

        return (view('admin.dashboard_home'));
    }

    public function clearSession(Request $request)
    {
        $request->session()->forget('alert');
        $request->session()->forget('message');
        $request->session()->forget('invalidEmail');
    }

    public function changeSideBarStatus(Request $request)
    {
        $status = $request->get('status');
        Cookie::queue(Cookie::make('valSideBar', $status));
    }
}
