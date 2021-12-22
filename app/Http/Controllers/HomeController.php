<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Flare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function index(Request $req)
    {
        if (!Session::has('customer-city')) {
            $value = [];
            $value['0'] = 'All of Sri Lanka';
            $value['1'] = '0';
            $value['2'] = array('0', '0', '0');
            $req->session()->put('customer-city', $value);
        }

        $flashD = HomeDealsController::flashDealsProducts();
        $topRatedProducts = HomeDealsController::topRatedProducts();
        $topRShops = HomeDealsController::topRShops();

        // dd($flashD);
        return view('home', [
            'flashD' => $flashD,
            'topRProducts' => $topRatedProducts,
            'topRShops' => $topRShops,
        ]);
    }
}
