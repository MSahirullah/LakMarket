<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboardOrders extends Controller
{
    public function index()
    {
        return view('seller.dashboard_orders');
    }
}
