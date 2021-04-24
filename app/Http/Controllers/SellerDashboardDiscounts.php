<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboardDiscounts extends Controller
{
    public function index()
    {
        return view('seller.dashboard_discounts');
    }
}
