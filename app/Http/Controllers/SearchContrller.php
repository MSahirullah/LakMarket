<?php

namespace App\Http\Controllers;

use App\Models\SellerCategories;
use App\Models\SellerProductCategories;
use App\Models\SellerProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchContrller extends Controller
{
    public function search()
    {
        return view('search');
    }

    public function searchAutocomplete(Request $request)
    {

        if ($request->category != "All Categories") {
            $productNames = DB::table('product_categories')
                ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
                ->where(
                    [
                        ['product_categories.name', 'LIKE', '%' . $request->term . '%'],
                        ['shop_categories.name', '=', $request->category]
                    ]
                )
                ->select('product_categories.id', 'product_categories.name')
                ->orderBy('name')
                ->limit(13)
                ->get();

            if (!sizeof($productNames)) {
                $productNames = DB::table('product_categories')
                    ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
                    ->where(
                        [
                            ['product_categories.name', 'LIKE', '%' . $request->term . '%'],

                        ]
                    )
                    ->select('product_categories.id', 'product_categories.name')
                    ->orderBy('name')
                    ->limit(13)
                    ->get();
            }
        } else {
            $productNames = SellerCategories::where(
                [['name', 'LIKE', '%' . $request->term . '%']]
            )
                ->select('id', 'name')
                ->orderBy('name')
                ->limit(13)
                ->get();
        }

        if (!sizeof($productNames)) {
            $productNames = SellerCategories::where(
                [['name', '!=', Null]]
            )
                ->select('id', 'name')
                ->orderBy('name')
                ->limit(13)
                ->get();
        }

        return $productNames;
    }
}
