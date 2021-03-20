<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboard extends Controller
{
    function index()
    {
        return (view('seller.dashboard_home'));
    }
}
