<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellerDashboardDiscounts extends Controller
{
    public function index()
    {
        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
        }

        return view('seller.dashboard_discounts');
    }
}
