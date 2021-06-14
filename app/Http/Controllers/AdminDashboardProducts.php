<?php

namespace App\Http\Controllers;

use App\models\SellerProducts;
use Illuminate\Http\Request;

class AdminDashboardProducts extends Controller
{
    //
    public function adminProducts()
    {
        $products = SellerProducts::all();
        return view('admin.dashboard_products')->with('products', $products);
    }
}
