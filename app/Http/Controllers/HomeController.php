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

        $location = Session::get('customer-city');
        $arr = '';

        if ($location[1] == '0') {
            $arr = ['lkcities.id', '!=', 'null'];
        } else if ($location[1] == '1') {
            $arr = ['lkprovinces.name_en', '=', $location[2][0]];
        } else if ($location[1] == '2') {
            $arr = ['lkdistricts.name_en', '=', $location[2][1]];
        } else if ($location[1] == '3') {
            $arr = ['lkcities.name_en', '=', $location[2][2]];
        }

        $productList = [];

        $flashD = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->join('stocks', 'products.id', '=', 'stocks.product_id')
            ->where(
                [
                    ['products.blacklisted', '=', '0'],
                    ['products.delete_status', '=', '0'],
                    ['sellers.blacklisted', '=', '0'],
                    ['product_categories.delete_status', '=', '0'],
                    ['sellers.delete_status', '=', '0'],
                    ['sellers.verified_seller', '=', '1'],
                    $arr,
                ]
            )
            ->distinct('stocks.product_id')
            ->select('products.*')
            ->orderBy('discount', 'DESC')
            ->limit(18)
            ->get();


        if (sizeof($flashD)) {
            foreach ($flashD as $key => $fd) {

                $stock = 0;

                if ($fd->images) {

                    $images = str_replace("\\", "", $fd->images);
                    $images = str_replace("[\"", "", $images);
                    $images = str_replace("\"]", "", $images);
                    $images = str_replace("\"", "", $images);

                    $images = explode(",", $images);


                    $flashD[$key]->images = $images[0];
                }

                $rating_temp = DB::table('reviews')
                    ->where([
                        ['reviews.product_id', '=', $fd->id]
                    ])
                    ->select('rating')
                    ->get();

                if (sizeof($rating_temp)) {
                    $fd->rating  = round(DB::table('reviews')->where([['product_id', '=', $fd->id]])->avg('rating'), 1);
                    // $rating_temp[0]->rating;
                } else {
                    $fd->rating = '0.0';
                }

                $add_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0']])
                    ->sum('added_stock');

                $used_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0']])
                    ->sum('stock_usage');

                if ($add_stock > 0) {
                    $stock = $add_stock - $used_stock;
                }
                if ($stock == 0) {
                    unset($flashD[$key]);
                } else {
                    $flashD[$key]->stock = $stock;
                }
            }
        }

        // dd($flashD);
        return view('home', [
            'flashD' => $flashD,
        ]);
    }
}
