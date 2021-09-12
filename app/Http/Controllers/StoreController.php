<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class StoreController extends Controller
{
    public function index(Request $request, $store)
    {
        $followers = 0;
        $followS = 0;
        $positiveF = '';
        $positiveFC = '';
        $storeD = '';
        $customer = '';
        if (Session::has('customer')) {
            $customer = Session::get('customer')['id'];
        }
        $storeD = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->where([
                ['sellers.url', '=', $store]
            ])
            ->select('sellers.*', 'shop_categories.name as store_cato', 'shop_categories.url as cato_url')
            ->get();

        if (!sizeof($storeD)) {
            abort('404');
        }

        $followers = DB::table('followers')->where([['seller_id', '=', $storeD[0]->id]])->count();

        $positiveF = DB::table('reviews')
            ->join('products', 'products.id', '=', 'reviews.product_id')
            ->where([
                ['products.seller_id', '=', $storeD[0]->id]
            ])
            ->avg('reviews.rating');

        $positiveFC = DB::table('reviews')
            ->join('products', 'products.id', '=', 'reviews.product_id')
            ->where([
                ['products.seller_id', '=', $storeD[0]->id]
            ])
            ->count('reviews.rating');

        $positiveF = ($positiveF / 5) * 100;


        $followed = DB::table('followers')->where([['seller_id', '=', $storeD[0]->id]])->count();

        if ($customer) {
            $followS = DB::table('followers')
                ->where([['seller_id', '=', $storeD[0]->id], ['customer_id', '=', $customer]])
                ->count();
        }
        // dd($followS);
        return view('store-home', [
            'store' => $storeD[0],
            'followers' => $followers,
            'positiveF' => $positiveF,
            'positiveFC' => $positiveFC,
            'followS' => $followS

        ]);
    }

    public function followStore(Request $request)
    {
        $store = $request->store;
        $customer = Session::get('customer')['id'];
        $followed = -1;


        if ($store && $customer) {

            $followCheck =  DB::table('followers')
                ->join('sellers', 'sellers.id', '=', 'followers.seller_id')
                ->where([['sellers.url', '=', $store], ['followers.customer_id', '=', $customer]])
                ->count();

            $storeID = DB::table('sellers')
                ->where([['url', '=', $store]])
                ->select('id')
                ->get();

            $storeID = $storeID[0]->id;

            if (!$followCheck) {

                $newFollow = new Followers();

                $newFollow->seller_id = $storeID;
                $newFollow->customer_id = $customer;
                $newFollow->save();
            } else {

                $affected = DB::table('followers')
                    ->where([['seller_id', '=', $storeID], ['customer_id', '=', $customer]])
                    ->delete();
            }
            $followed = DB::table('followers')->where([['seller_id', '=', $storeID]])->count();
        }

        return $followed;
    }
}
