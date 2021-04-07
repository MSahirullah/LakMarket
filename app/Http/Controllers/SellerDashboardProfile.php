<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboardProfile extends Controller
{
    public function sellerProfile(){
        return (view('seller.dashboard_profile'));
    }
}
