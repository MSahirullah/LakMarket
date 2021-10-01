<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class HomeDealsController extends Controller
{
    public function flashDeals(Request $request)
    {
        $result = $this->flashDealsProducts($priceMin = '0.00', $priceMax = '10000000.00', $deliveryS = '3', $limit = 30);

        return view('deals', [
            'products' => $result,
            'productCount' => sizeof($result),
            'type' => 'flashDeals',
            'title' => 'Flash Deals'
        ]);
    }

    public function topRatedProductsF()
    {
        $result = $this->topRatedProducts($priceMin = '0.00', $priceMax = '10000000.00', $deliveryS = '3', $limit = 30);

        return view('deals', [
            'products' => $result,
            'productCount' => sizeof($result),
            'type' => 'topRatedProducts',
            'title' => 'Top Rated Products'
        ]);
    }

    public function flashDealsFiler(Request $request)
    {
        $priceMin = $request->priceMin;
        $priceMax = $request->priceMax;
        $deliveryS = $request->deliveryStatus;

        $result = $this->flashDealsProducts($priceMin, $priceMax, $deliveryS, 30);

        return [
            'products' => $result,
            'productCount' => sizeof($result),
            'type' => 'flashDeals',
            'title' => 'Flash Deals'
        ];
    }

    public function topRatedProductsFfileter(Request $request)
    {
        $priceMin = $request->priceMin;
        $priceMax = $request->priceMax;
        $deliveryS = $request->deliveryStatus;

        $result = $this->topRatedProducts($priceMin, $priceMax, $deliveryS, 30);

        return [
            'products' => $result,
            'productCount' => sizeof($result),
            'type' => 'topRatedProducts',
            'title' => 'Top Rated Products'
        ];
    }

    public function topRatedShop()
    {
        $result = $this->topRShops();

        return view('tr-shops', [
            'title' => 'Top Rated Shops',
            'storesCount' => sizeof($result),
            'stores' => $result,
        ]);
    }

    public function topRatedShopFileter(Request $request)
    {

        $result = $this->topRShops($sdeliveryS = $request->deliveryStatus);

        return [
            'title' => 'Top Rated Shops',
            'storesCount' => sizeof($result),
            'stores' => $result
        ];
    }

    public static function flashDealsProducts($priceMin = '0.00', $priceMax = '10000000.00', $deliveryS = '3', $limit = 25)
    {

        if ((!$priceMin || $priceMin == '0.00') && (!$priceMax || $priceMax == '0.00')) {
            $priceMin = '0.00';
            $priceMax = '10000000.00';
        }

        $priceMin = (float) $priceMin;
        $priceMax = (float) $priceMax;

        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['products.cod', '!=', null];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['products.cod', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['products.cod', '=', '1'];
        }

        // $location = Session::get('customer-city');
        // $arr = '';

        // if ($location[1] == '0') {
        //     $arr = ['lkcities.id', '!=', 'null'];
        // } else if ($location[1] == '1') {
        //     $arr = ['lkprovinces.name_en', '=', $location[2][0]];
        // } else if ($location[1] == '2') {
        //     $arr = ['lkdistricts.name_en', '=', $location[2][1]];
        // } else if ($location[1] == '3') {
        //     $arr = ['lkcities.name_en', '=', $location[2][2]];
        // }

        $productList = [];

        $flashD = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where(
                [
                    ['products.blacklisted', '=', '0'],
                    ['products.delete_status', '=', '0'],
                    ['products.discount', '!=', '0.00'],
                    ['sellers.blacklisted', '=', '0'],
                    ['product_categories.delete_status', '=', '0'],
                    ['sellers.delete_status', '=', '0'],
                    ['sellers.verified_seller', '=', '1'],
                    // $arr, 
                    $deliveryQ
                ]
            )
            ->select('products.*', 'sellers.store_name as seller', 'sellers.url as sellerURL', 'lkdistricts.name_en as district', 'lkcities.name_en as city')
            ->orderBy('discount', 'DESC')
            ->limit($limit)
            ->whereBetween('products.discounted_price', [$priceMin, $priceMax])
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
                        ['reviews.product_id', '=', $fd->id],
                        ['reviews.delete_status', '=', '0']
                    ])
                    ->select('rating')
                    ->get();

                if (sizeof($rating_temp)) {
                    $fd->rating  = round(DB::table('reviews')
                        ->where(
                            [
                                ['product_id', '=', $fd->id],
                                ['delete_status', '=', '0']
                            ]
                        )
                        ->avg('rating'), 1);
                } else {
                    $fd->rating = '0.0';
                }

                $add_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0'], ['delete_status', '=', '0']])
                    ->sum('added_stock');

                $used_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0'], ['delete_status', '=', '0']])
                    ->sum('stock_usage');

                if ($add_stock > 0) {
                    $stock = $add_stock - $used_stock;
                }
                if ($stock == 0) {
                    unset($flashD[$key]);
                } else {
                    $flashD[$key]->stock = $stock;
                }
                $fd->discounted_price = number_format($fd->discounted_price, 2);
                $fd->unit_price = number_format($fd->unit_price, 2);
            }
        }

        $flashD = json_decode($flashD, true);

        return $flashD;
    }

    public static function topRatedProducts($priceMin = '0.00', $priceMax = '10000000.00', $deliveryS = '3', $limit = 25)
    {
        if ((!$priceMin || $priceMin == '0.00') && (!$priceMax || $priceMax == '0.00')) {
            $priceMin = '0.00';
            $priceMax = '10000000.00';
        }

        $priceMin = (float) $priceMin;
        $priceMax = (float) $priceMax;

        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['products.cod', '!=', null];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['products.cod', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['products.cod', '=', '1'];
        }

        // $location = Session::get('customer-city');
        // $arr = '';

        // if ($location[1] == '0') {
        //     $arr = ['lkcities.id', '!=', 'null'];
        // } else if ($location[1] == '1') {
        //     $arr = ['lkprovinces.name_en', '=', $location[2][0]];
        // } else if ($location[1] == '2') {
        //     $arr = ['lkdistricts.name_en', '=', $location[2][1]];
        // } else if ($location[1] == '3') {
        //     $arr = ['lkcities.name_en', '=', $location[2][2]];
        // }

        $productList = [];

        $topRProducts = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where(
                [
                    ['products.blacklisted', '=', '0'],
                    ['products.delete_status', '=', '0'],
                    ['products.discount', '!=', '0.00'],
                    ['sellers.blacklisted', '=', '0'],
                    ['product_categories.delete_status', '=', '0'],
                    ['sellers.delete_status', '=', '0'],
                    ['sellers.verified_seller', '=', '1'],
                    // $arr,
                    $deliveryQ
                ]
            )
            ->select('products.*', 'sellers.store_name as seller', 'sellers.url as sellerURL', 'lkdistricts.name_en as district', 'lkcities.name_en as city')
            ->orderBy('name', 'ASC')
            ->limit($limit)
            ->whereBetween('products.discounted_price', [$priceMin, $priceMax])
            ->get();


        if (sizeof($topRProducts)) {
            foreach ($topRProducts as $key => $fd) {

                $stock = 0;

                if ($fd->images) {

                    $images = str_replace("\\", "", $fd->images);
                    $images = str_replace("[\"", "", $images);
                    $images = str_replace("\"]", "", $images);
                    $images = str_replace("\"", "", $images);

                    $images = explode(",", $images);
                    $topRProducts[$key]->images = $images[0];
                }

                $rating_temp = DB::table('reviews')
                    ->where([
                        ['reviews.product_id', '=', $fd->id],
                        ['reviews.delete_status', '=', '0']
                    ])
                    ->select('rating')
                    ->get();

                if (sizeof($rating_temp)) {
                    $fd->rating  = round(DB::table('reviews')
                        ->where(
                            [
                                ['product_id', '=', $fd->id],
                                ['delete_status', '=', '0']
                            ]
                        )
                        ->avg('rating'), 1);
                } else {
                    $fd->rating = '0.0';
                }


                $add_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0'], ['delete_status', '=', '0']])
                    ->sum('added_stock');

                $used_stock = DB::table('stocks')
                    ->where([['product_id', '=', $fd->id], ['outof_stock', '=', '0'], ['delete_status', '=', '0']])
                    ->sum('stock_usage');

                if ($add_stock > 0) {
                    $stock = $add_stock - $used_stock;
                }

                if ($stock == 0 || $fd->rating == '0.0') {
                    unset($topRProducts[$key]);
                } else {
                    $topRProducts[$key]->stock = $stock;
                }

                $fd->discounted_price = number_format($fd->discounted_price, 2);
                $fd->unit_price = number_format($fd->unit_price, 2);
            }
        }

        $topRProducts = json_decode($topRProducts, true);

        usort($topRProducts, function ($a, $b) {
            if ($a['rating'] == $b['rating']) {
                return 0;
            }
            return ($a['rating'] > $b['rating']) ? -1 : 1;
        });

        return $topRProducts;
    }

    public static function topRShops($deliveryS = '3')
    {
        // $location = Session::get('customer-city');
        // $arr = '';

        // if ($location[1] == '0') {
        //     $arr = ['lkcities.id', '!=', 'null'];
        // } else if ($location[1] == '1') {
        //     $arr = ['lkprovinces.name_en', '=', $location[2][0]];
        // } else if ($location[1] == '2') {
        //     $arr = ['lkdistricts.name_en', '=', $location[2][1]];
        // } else if ($location[1] == '3') {
        //     $arr = ['lkcities.name_en', '=', $location[2][2]];
        // }

        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['sellers.is_cod_available', '!=', 'null'];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['sellers.is_cod_available', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['sellers.is_cod_available', '=', '1'];
        }

        $stores = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where([
                ['sellers.blacklisted', '=', '0'],
                ['sellers.delete_status', '=', '0'],
                ['sellers.verified_seller', '=', '1'],
                ['sellers.status', '=', '1'],
                // $arr, 
                $deliveryQ
            ])
            ->select('sellers.id', 'sellers.store_logo', 'sellers.store_name', 'sellers.longitude', 'sellers.latitude', 'sellers.url', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
            ->limit(25)
            ->orderBy('name')
            ->get();

        if (sizeof($stores)) {
            foreach ($stores as $store) {

                $rating_temp = DB::table('reviews')
                    ->join('products', 'products.id', '=', 'reviews.product_id')
                    ->where([
                        ['products.seller_id', '=', $store->id],
                        ['reviews.delete_status', '=', '0']
                    ])
                    ->select('rating')
                    ->get();

                if (sizeof($rating_temp)) {
                    $store->rating = round(DB::table('reviews')
                        ->join('products', 'products.id', '=', 'reviews.product_id')
                        ->where([
                            ['products.seller_id', '=', $store->id],
                            ['reviews.delete_status', '=', '0']
                        ])
                        ->avg('rating'), 1);
                } else {
                    $store->rating  = '0.0';
                }
            }
        }

        $stores = json_decode($stores, true);

        usort($stores, function ($a, $b) {
            if ($a['rating'] == $b['rating']) {
                return 0;
            }
            return ($a['rating'] > $b['rating']) ? -1 : 1;
        });

        // dd($stores);

        return $stores;
    }
}
