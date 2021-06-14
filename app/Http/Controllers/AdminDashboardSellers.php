<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\seller;

class AdminDashboardSellers extends Controller
{
    //
    public function adminSellers()
    {
        $sellers = seller :: all();
        return view('admin.dashboard_sellers')->with('sellers',$sellers);
    }
}
