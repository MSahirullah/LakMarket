<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchContrller extends Controller
{
    public function search()
    {
        return view('search');
    }
}
