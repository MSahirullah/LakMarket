<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class SellerDashboard extends Controller
{
    function index(Request $request)
    {


        if (Session::has('seller')) {
            $sellerId = Session::get('seller')['id'];

            $data = DB::table('sellers')
                ->where('id', "=",  $sellerId)
                ->select('full_name', 'profile_photo')
                ->get();

            $request->session()->put('sellerName', $data[0]->full_name);
            $request->session()->put('sellerImage', $data[0]->profile_photo);

            return (view('seller.dashboard_home'));
        }
        else{
            abort(404, '/seller/login');
        }
    }
}
