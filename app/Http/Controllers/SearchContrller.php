<?php

namespace App\Http\Controllers;

use App\Models\SellerCategories;
use App\Models\SellerProductCategories;
use App\Models\SellerProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SearchContrller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;

        $orderBy = 'name';
        $orderByVal = 'ASC';

        $cato = $request->category;
        Session::flash('searchCato', $cato);
        Session::flash('query', $query);

        if ($cato != "All Categories") {
            $catoQ = ['shop_categories.name', '=', $cato];
        } else {
            $catoQ = ['shop_categories.name', '!=', Null];
        }

        $result = $this->searchResult($query, $orderBy, $orderByVal, $catoQ);

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
            'type' => 'search'
        ]);
    }

    public function searchFilterSort(Request $request)
    {
        $query = $request->q;

        $sort = $request->sort;

        if ($sort == "Price High to Low") {
            $orderBy = 'discounted_price';
            $orderByVal = 'DESC';
        } else if ($sort == "Price Low to High") {
            $orderBy = 'discounted_price';
            $orderByVal = 'ASC';
        } else {
            $orderBy = 'name';
            $orderByVal = 'ASC';
        }

        $cato = $request->category;
        Session::flash('searchCato', $cato);
        Session::flash('searchFilterSort', $sort);
        Session::flash('query', $query);

        if ($cato != "All Categories") {
            $catoQ = ['shop_categories.name', '=', $cato];
        } else {
            $catoQ = ['shop_categories.name', '!=', Null];
        }

        $deliveryS = $request->deliveryStatus;

        $result = $this->searchResult($query, $orderBy, $orderByVal, $catoQ, $deliveryS);

        $productList = $result[0] ? $result[0] : [];
        $sellerList = $result[1] ? $result[1] : [];
        $sellerLen = $result[2] ? $result[2] : 0;
        $productLen = $result[3] ? $result[3] : 0;
        $shop_proCatoList = $result[4] ? $result[4] : [];

        return  [
            'stores' => $sellerList,
            'products' => $productList,
            'storeCount' => $sellerLen,
            'productCount' => $productLen,
            'categories' => $shop_proCatoList,
            'type' => 'search'
        ];
    }

    public function searchFilter(Request $request)
    {
        $query = $request->q;
        $sort = $request->sort;
        $priceMin = $request->priceMin;
        $priceMax = $request->priceMax;

        if ($sort == "Price High to Low") {
            $orderBy = 'products.discounted_price';
            $orderByVal = 'DESC';
        } else if ($sort == "Price Low to High") {
            $orderBy = 'products.discounted_price';
            $orderByVal = 'ASC';
        } else {
            $orderBy = 'name';
            $orderByVal = 'ASC';
        }

        $cato = $request->category;
        Session::flash('searchCato', $cato);
        Session::flash('searchFilterSort', $sort);
        Session::flash('query', $query);

        if ($cato != "All Categories") {
            $catoQ = ['shop_categories.name', '=', $cato];
        } else {
            $catoQ = ['shop_categories.name', '!=', Null];
        }

        $deliveryS = $request->deliveryStatus;

        $result = $this->searchResult($query, $orderBy, $orderByVal, $catoQ, $deliveryS, $priceMin, $priceMax);

        $productList = $result[0] ? $result[0] : [];
        $sellerList = $result[1] ? $result[1] : [];
        $sellerLen = $result[2] ? $result[2] : 0;
        $productLen = $result[3] ? $result[3] : 0;
        $shop_proCatoList = $result[4] ? $result[4] : [];

        return  [
            'stores' => $sellerList,
            'products' => $productList,
            'storeCount' => $sellerLen,
            'productCount' => $productLen,
            'categories' => $shop_proCatoList,
            'q' => $request->q,
            'type' => 'search'
        ];
    }

    public function flashDeals()
    {

        $query = '';

        $orderBy = 'name';
        $orderByVal = 'ASC';

        $cato = $request->category;
        Session::flash('searchCato', $cato);
        Session::flash('query', $query);

        if ($cato != "All Categories") {
            $catoQ = ['shop_categories.name', '=', $cato];
        } else {
            $catoQ = ['shop_categories.name', '!=', Null];
        }

        $result = $this->searchResult($query, $orderBy, $orderByVal, $catoQ);

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
            'type' => 'search'
        ]);
    }


    public static function searchResult($q, $ordby, $ordbyval, $catoQ, $deliveryS = '3', $priceMin = '0.00', $priceMax = '10000000.00')
    {
        $location = Session::get('customer-city');
        $arr = '';
        $orderBy = $ordby;
        $orderByVal = $ordbyval;

        if ($location[1] == '0') {
            $arr = ['lkcities.id', '!=', 'null'];
        } else if ($location[1] == '1') {
            $arr = ['lkprovinces.name_en', '=', $location[2][0]];
        } else if ($location[1] == '2') {
            $arr = ['lkdistricts.name_en', '=', $location[2][1]];
        } else if ($location[1] == '3') {
            $arr = ['lkcities.name_en', '=', $location[2][2]];
        }

        $query = $q;

        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['products.cod', '!=', 'null'];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['products.cod', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['products.cod', '=', '1'];
        }

        if ((!$priceMin || $priceMin == '0.00') && (!$priceMax || $priceMax == '0.00')) {
            $priceMin = '0.00';
            $priceMax = '10000000.00';
        }

        $priceMin = (float) $priceMin;
        $priceMax = (float) $priceMax;

        $productList = [];
        $shopCatoList = [];
        $productCatoList = [];
        $shop_proCatoList = [];
        $sellerList = [];

        $dataNames = DB::table('product_categories')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->where(
                [
                    ['product_categories.name', '=', $query],
                ]
            )
            ->select('product_categories.id')
            ->orderBy('id')
            ->get();

        if (sizeof($dataNames)) {

            foreach ($dataNames as $data) {
                $products = DB::table('products')
                    ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
                    ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
                    ->join('sellers', 'sellers.id', '=', 'products.seller_id')
                    ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
                    ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
                    ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
                    ->where(
                        [
                            ['products.product_catrgory_id', '=', $data->id],
                            ['products.blacklisted', '=', '0'],
                            ['products.delete_status', '=', '0'],
                            ['sellers.blacklisted', '=', '0'],
                            ['product_categories.delete_status', '=', '0'],
                            ['sellers.delete_status', '=', '0'],
                            ['sellers.verified_seller', '=', '1'],
                            $arr, $catoQ, $deliveryQ
                        ]
                    )
                    ->select('products.*', 'product_categories.name as pro_cato', 'product_categories.shop_categories_id as shop_pro_cato_id', 'product_categories.url as pro_url',  'shop_categories.name as shop_cato', 'shop_categories.id as shop_cato_id', 'shop_categories.url as shop_url', 'sellers.store_name as seller', 'sellers.url as sellerURL', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
                    ->orderBy($orderBy, $orderByVal)
                    ->whereBetween('products.discounted_price', [$priceMin, $priceMax])
                    ->get();

                foreach ($products as $product) {
                    if (!in_array($product, $productList)) {
                        array_push($productList, $product);
                    }

                    if (!in_array(array($product->shop_cato_id, $product->shop_cato, $product->shop_url, $product->pro_cato), $shopCatoList)) {
                        array_push($shopCatoList, array($product->shop_cato_id, $product->shop_cato, $product->shop_url, $product->pro_cato));
                    }

                    $temp_pro = [];
                    foreach ($productCatoList as $tmp) {
                        $temp_pro[] = $tmp[1];
                    }

                    if (!in_array($product->pro_cato, $temp_pro)) {
                    }
                }
            }

            foreach ($shopCatoList as $d) {

                $temp = array();
                foreach ($productCatoList as $p) {

                    if ($d[0] == $p[0]) {
                        if (!in_array([$p[1], $p[2]], $temp)) {
                            array_push($temp, [$p[1], $p[2]]);
                        }
                    } else if ($d[3] == $p[1]) {
                        if (!in_array([$p[1], $p[2]], $temp)) {
                            array_push($temp, [$p[1], $p[2]]);
                        }
                    }
                }

                if (!in_array([$d[2], $temp], $shop_proCatoList)) {
                    $shop_proCatoList[$d[1]] = [$d[2], $temp];
                }
            }
        } else {

            $products = DB::table('products')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
                ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
                ->join('sellers', 'sellers.id', '=', 'products.seller_id')
                ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
                ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
                ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')

                ->where(
                    [
                        ['products.name', 'LIKE', '%' . $query . '%'],
                        ['products.blacklisted', '=', '0'],
                        ['products.delete_status', '=', '0'],
                        ['sellers.blacklisted', '=', '0'],
                        ['product_categories.delete_status', '=', '0'],
                        ['sellers.delete_status', '=', '0'],
                        ['sellers.verified_seller', '=', '1'],
                        ['sellers.status', '=', '1'],
                        $arr, $catoQ, $deliveryQ
                    ]
                )
                ->select('products.*', 'product_categories.name as pro_cato', 'product_categories.shop_categories_id as shop_pro_cato_id', 'product_categories.url as pro_url',  'shop_categories.name as shop_cato', 'shop_categories.id as shop_cato_id', 'shop_categories.url as shop_url', 'sellers.store_name as seller', 'sellers.url as sellerURL', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
                ->orderBy($orderBy, $orderByVal)
                ->whereBetween('products.discounted_price', [$priceMin, $priceMax])
                ->get();


            foreach ($products as $product) {

                if (!in_array(array($product->shop_cato_id, $product->shop_cato, $product->shop_url), $shopCatoList)) {
                    array_push($shopCatoList, array($product->shop_cato_id, $product->shop_cato, $product->shop_url));
                }

                if (!in_array(array($product->shop_pro_cato_id, $product->pro_cato, $product->pro_url), $productCatoList)) {
                    array_push($productCatoList, array($product->shop_pro_cato_id, $product->pro_cato, $product->pro_url));
                }

                $product_colors_stock = [];

                $product->stock = 0;

                if ($product->colors) {
                    $colors = $product->colors;
                    $colors = str_replace(" ", "", $colors);
                    $colors = explode(",", $colors);

                    $product_colors_stock = [];

                    foreach ($colors as $color) {
                        $stock = DB::table('stocks')
                            ->where([
                                ['product_id', '=', $product->id],
                                ['product_color', '=', $color],
                            ])
                            ->select('*')
                            ->get();

                        if (sizeof($stock)) {

                            $stock = $stock[0];

                            if ($stock->outof_stock == '1') {

                                $product_colors_stock[$color] = 0;
                                //
                            } else {
                                $stock_added = DB::table('stocks')
                                    ->where([
                                        ['product_id', '=', $product->id],
                                        ['product_color', '=', $color],
                                    ])
                                    ->sum('added_stock');

                                $stock_usage = DB::table('stocks')
                                    ->where([
                                        ['product_id', '=', $product->id],
                                        ['product_color', '=', $color],
                                    ])
                                    ->sum('stock_usage');

                                if (($stock_added - $stock_usage) == 0) {
                                    $product_colors_stock[$color] = 0;
                                } else {
                                    $product_colors_stock[$color] = $stock_added - $stock_usage;
                                }
                            }
                        } else {
                            $product_colors_stock[$color] = 0;
                        }

                        if ($product->stock == 0) {
                            if ($product_colors_stock[$color] != 0) {
                                $product->stock = 1;
                            }
                        }
                    }
                } else {

                    $stock = DB::table('stocks')
                        ->where([
                            ['product_id', '=', $product->id]
                        ])
                        ->select('*')
                        ->get();

                    if (sizeof($stock)) {

                        $stock = $stock[0];

                        if ($stock->outof_stock == '0') {
                            //
                            $stock_added = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product->id],
                                ])
                                ->sum('added_stock');

                            $stock_usage = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product->id],
                                ])
                                ->sum('stock_usage');

                            if (($stock_added - $stock_usage) != 0) {
                                $product->stock = 1;
                            }
                        }
                    }
                }


                // if ($product_colors_stock) {
                //     $product->colors = $product_colors_stock;
                // }

                if (!in_array($product, $productList)) {
                    array_push($productList, $product);
                }
            }

            foreach ($shopCatoList as $d) {

                $temp = array();
                foreach ($productCatoList as $p) {

                    if ($d[0] == $p[0]) {
                        if (!in_array([$p[1], $p[2]], $temp)) {
                            array_push($temp, [$p[1], $p[2]]);
                        }
                    }
                }

                if (!in_array([$d[2], $temp], $shop_proCatoList)) {
                    $shop_proCatoList[$d[1]] = [$d[2], $temp];
                }
            }
        }

        $x = 0;
        foreach ($shop_proCatoList as $key => $value) {
            $pro = $productList[$x];

            $sellers = DB::table('sellers')
                ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
                ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
                ->join('products', 'products.seller_id', '=', 'sellers.id')
                ->where(
                    [
                        ['shop_categories.name', '=', $key],
                        ['products.seller_id', '=', $pro->seller_id]
                    ]
                )
                ->select('sellers.*', 'lkcities.name_en as city')
                ->get();
            foreach ($sellers as $seller) {
                if (!in_array($seller, $sellerList)) {
                    array_push($sellerList, $seller);
                }
            }
            $x++;
        }


        $sellerLen = sizeof($sellerList);
        $productLen = sizeof($productList);

        usort($productList, function ($a, $b) {
            if ($a->stock == $b->stock) {
                return 0;
            }
            return ($a->stock > $b->stock) ? -1 : 1;
        });

        return [$productList, $sellerList, $sellerLen, $productLen, $shop_proCatoList];
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
