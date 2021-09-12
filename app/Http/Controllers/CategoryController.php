<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(Request $request, $category)
    {
        $location = Session::get('customer-city');

        $result = $this->categoryResult($location, $category, 'url', '3');

        return view('categories', [
            'q' => $result[0],
            'storesCount' => $result[1],
            'stores' => $result[2],
            'categories' => $result[3]
        ]);
    }

    public function shopCategoryFilter(Request $request)
    {
        $deliveryS = $request->deliveryStatus;
        $location = Session::get('customer-city');
        $q = $request->q;
        $status = 'name';

        $result = $this->categoryResult($location, $q, $status, $deliveryS);

        return [
            'q' => $result[0],
            'storesCount' => $result[1],
            'stores' => $result[2],
            'categories' => $result[3]
        ];
    }

    public static  function categoryResult($location, $category, $status,  $deliveryS = '3')
    {
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

        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['sellers.is_cod_available', '!=', 'null'];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['sellers.is_cod_available', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['sellers.is_cod_available', '=', '1'];
        }

        if ($status == 'url') {
            $mq =  ['shop_categories.url', '=', $category];
        } elseif ($status == 'name') {
            $mq =  ['shop_categories.name', '=', $category];
        }

        $stores = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where([
                $mq, ['sellers.blacklisted', '=', '0'],
                ['sellers.delete_status', '=', '0'],
                ['sellers.verified_seller', '=', '1'],
                ['sellers.status', '=', '1'], $arr, $deliveryQ
            ])
            ->select('sellers.*', 'shop_categories.name as category', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
            ->orderBy('name')
            ->get();

        $categories = DB::table('product_categories')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->where([
                $mq
            ])
            ->select('product_categories.*', 'shop_categories.url as categoryUrl')
            ->orderBy('product_categories.name')
            ->get();

        $storesCount = sizeof($stores);

        $name = DB::table('shop_categories')
            ->where([$mq])
            ->select('name')
            ->get();

        // dd($name[0]->name);

        return [
            $name[0]->name,
            $storesCount,
            $stores,
            $categories
        ];
    }
}
