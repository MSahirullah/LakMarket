<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Session;

class SellerDashboard extends Controller
{
    function index(Request $request, Response $response)
    {
        $sellerId = Session::get('seller');

        if (!$sellerId) {
            CommonController::checkSeller('/seller/login');
        }

        $data = DB::table('sellers')
            ->where('id', "=",  $sellerId)
            ->select('full_name', 'profile_photo')
            ->get();

        $data[0]->profile_photo = "/" . $data[0]->profile_photo;

        $request->session()->put('sellerName', $data[0]->full_name);
        $request->session()->put('sellerImage', $data[0]->profile_photo);

        return (view('seller.dashboard_home'));
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
