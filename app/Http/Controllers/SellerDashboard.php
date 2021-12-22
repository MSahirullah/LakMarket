<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session as Session;


class SellerDashboard extends Controller
{
    function index(Request $request, Response $response)
    {

        $sellerId = Session::get('seller');

        if (!$sellerId) {
            return redirect()->route('seller.loginV');
        }

        $data = DB::table('sellers')
            ->where('id', "=",  $sellerId)
            ->select('store_name', 'store_logo', 'status')
            ->get();

        $data[0]->store_logo = "/" . $data[0]->store_logo;

        $request->session()->put('storeName', $data[0]->store_name);
        $request->session()->put('sellerImage', $data[0]->store_logo);
        $request->session()->put('sellerStatus', $data[0]->status);

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
        }

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

    public static function checkSellerInfo()
    {

        $sellerId = Session::get('seller');

        $data = DB::table('sellers')
            ->where('id', "=",  $sellerId)
            ->select('*')
            ->get();

        if (!$data[0]->status) {
            return 'Please change the password.';
        } else if (!$data[0]->birthday) {
            if (!$data[0]->store_logo) {
                return 'Please complete missing informations. [Store Background Image/Birthday]';
            }
            return 'Please complete missing informations. [Bthirday]';
        } else {
            if (!$data[0]->store_logo) {
                return 'Please complete missing informations. [Store Background Image]';
            }
        }
    }
}
