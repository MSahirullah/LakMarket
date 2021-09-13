<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerRegister extends Controller
{
    public function index()
    {

        $data = DB::table('shop_categories')
            ->select('id', 'name')
            ->get();

        return view('auth.seller_register')->with('shopC', $data);
    }
}
