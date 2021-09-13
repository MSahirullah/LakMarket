<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    public function index($category, $subCategory)
    {
        $categoryUrl = $category;
        $category = DB::table('shop_categories')
            ->where([['url', '=', $category]])
            ->select('name')
            ->get();

        $subCategory = DB::table('product_categories')
            ->where([['url', '=', $subCategory]])
            ->select('name')
            ->get();

        $subCategory = $subCategory[0]->name;
        $category  = $category[0]->name;

        $query = $subCategory;

        Session::flash('query', $query);

        $orderBy = 'name';
        $orderByVal = 'ASC';

        $cato = $category;

        // if ($cato != "All Categories") {
        // $catoQ = ['shop_categories.name', '=', $cato];
        // } else {
        $catoQ = ['shop_categories.name', '!=', Null];
        // }

        $result = SearchContrller::searchResult($query, $orderBy, $orderByVal, $catoQ);

        $productList = $result[0] ? $result[0] : [];
        $sellerList = $result[1] ? $result[1] : [];
        $sellerLen = $result[2] ? $result[2] : 0;
        $productLen = $result[3] ? $result[3] : 0;
        $shop_proCatoList = $result[4] ? $result[4] : [];


        return view('search', [
            'stores' => $sellerList,
            'products' => $productList,
            'storeCount' => $sellerLen,
            'productCount' => $productLen,
            'categories' => $shop_proCatoList,
            'q' => $query,
            'cato' => $category,
            'catoUrl' => $categoryUrl,
            'type' => 'subCato'
        ]);
    }
}
