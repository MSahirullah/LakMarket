<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboardNewsletters extends Controller
{
    public function index()
    {
        return view('seller.dashboard_newsletters');
    }
}
