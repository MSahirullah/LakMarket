<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellerDashboardDiscounts extends Controller
{
    public function index()
    {
        $sellerId = Session::get('seller');

        if (!$sellerId) {
            return redirect()->route('seller.loginV');
        }

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
        }

        return view('seller.dashboard_discounts');
    }
}