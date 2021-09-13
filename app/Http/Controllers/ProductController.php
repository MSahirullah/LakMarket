<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(Request $request, $pURL)
    {

        $customer = '';
        if (Session::has('customer')) {
            $customer = Session::get('customer');
        }
        $product = '';
        $images = '';
        $product_4 = '';
        $product_bottom = '';
        $reviews = 0;
        $ratings = '';
        $rating_avg = 0.00;
        $rating_con = '';
        $reviews_con = '';
        $sellerP = '';
        $ratingE = [0, 0, 0, 0, 0];
        $product_colors_stock = [];

        $product = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where([
                ['products.url', '=', $pURL]
            ])
            ->select('products.*', 'sellers.store_name as store', 'sellers.url as storeurl', 'sellers.latitude as storelat', 'sellers.longitude as storelog', 'lkcities.name_en as city', 'lkdistricts.name_en as district', 'product_categories.name as pcategory', 'shop_categories.name as scategory', 'product_categories.url as purl', 'shop_categories.url as surl', 'shop_categories.id as scid')
            ->get();

        if (sizeof($product)) {


            if ($product[0]->colors) {
                $colors = $product[0]->colors;
                $colors = str_replace(" ", "", $colors);
                $colors = explode(",", $colors);

                $product_colors_stock = [];
                $product[0]->stock = 0;

                foreach ($colors as $key => $color) {
                    $stock = DB::table('stocks')
                        ->where([
                            ['product_id', '=', $product[0]->id],
                            ['product_color', '=', $color],
                        ])
                        ->select('*')
                        ->get();

                    if (sizeof($stock)) {

                        $stock = $stock[0];

                        if ($stock->outof_stock == '1') {

                            $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
                        } else {
                            $stock_added = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product[0]->id],
                                    ['product_color', '=', $color],
                                ])
                                ->sum('added_stock');

                            $stock_usage = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product[0]->id],
                                    ['product_color', '=', $color],
                                ])
                                ->sum('stock_usage');

                            if (($stock_added - $stock_usage) == 0) {
                                $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
                            } else {
                                $product_colors_stock[$key] = array('color' => $color, 'stock' => $stock_added - $stock_usage);
                            }
                        }
                    } else {
                        $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
                    }

                    if ($product[0]->stock == 0) {
                        if ($product_colors_stock[$key]['stock'] != 0) {
                            $product[0]->stock = 1;
                        }
                    }
                }
            } else {

                $stock = DB::table('stocks')
                    ->where([
                        ['product_id', '=', $product[0]->id]
                    ])
                    ->select('*')
                    ->get();

                if (sizeof($stock)) {

                    $stock = $stock[0];

                    if ($stock->outof_stock == '0') {
                        //
                        $stock_added = DB::table('stocks')
                            ->where([
                                ['product_id', '=', $product[0]->id],
                            ])
                            ->sum('added_stock');

                        $stock_usage = DB::table('stocks')
                            ->where([
                                ['product_id', '=', $product[0]->id],
                            ])
                            ->sum('stock_usage');

                        if (($stock_added - $stock_usage) != 0) {
                            $product[0]->stock = $stock_added - $stock_usage;
                        }
                    }
                }
                $product[0]->stock = 0;
            }


            if ($product_colors_stock) {

                usort($product_colors_stock, function ($item1, $item2) {
                    return $item2['stock'] <=> $item1['stock'];
                });
                $product[0]->colors = $product_colors_stock;
            }

            $product = $product[0];

            $images = $product->images;
            $images = str_replace("[", "", $images);
            $images = str_replace("]", "", $images);
            $images = str_replace("\"", "", $images);
            $images = explode(",", $images);

            $product_4 = DB::table('products')
                ->where([
                    ['product_catrgory_id', '=', $product->product_catrgory_id],
                    ['products.id', '!=', $product->id]
                ])
                ->select('id', 'name', 'images', 'discounted_price', 'url')
                ->limit(4)
                ->get();

            //rating anuwa
            if (sizeof($product_4) < 4) {
                $product_4_b = DB::table('products')
                    ->where([
                        ['product_catrgory_id', '!=', $product->product_catrgory_id],
                        ['products.id', '!=', $product->id]
                    ])
                    ->select('id', 'name', 'images', 'discounted_price', 'url')
                    ->limit(4 - sizeof($product_4))
                    ->get();

                foreach ($product_4_b as $key => $value) {
                    $product_4->put($key + sizeof($product_4), $value);
                }
            }
            foreach ($product_4 as $val) {
                $imagesD = $val->images;
                $imagesD = str_replace("[", "", $imagesD);
                $imagesD = str_replace("]", "", $imagesD);
                $imagesD = str_replace("\"", "", $imagesD);
                $val->images = explode(",", $imagesD)[0];
            }

            foreach ($product_4 as $pro) {
                $rating_temp = DB::table('reviews')
                    ->where([
                        ['reviews.product_id', '=', $pro->id]
                    ])
                    ->select('rating')
                    ->get();

                if (sizeof($rating_temp)) {
                    $pro->rating  = $rating_temp[0]->rating;
                } else {
                    $pro->rating = 0;
                }
            }


            $product_bottom = DB::table('products')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
                ->join('shop_categories', 'shop_categories.id', '=', 'product_categories.shop_categories_id')
                ->where([
                    ['shop_categories.id', '=', $product->scid],
                    ['products.id', '!=', $product->id]
                ])
                ->select('products.*')
                ->orderBy('products.name', 'DESC')
                ->get();

            if (sizeof($product_bottom)) {
                foreach ($product_bottom as $val) {
                    $imagesD = $val->images;
                    $imagesD = str_replace("[", "", $imagesD);
                    $imagesD = str_replace("]", "", $imagesD);
                    $imagesD = str_replace("\"", "", $imagesD);
                    $val->images = explode(",", $imagesD)[0];

                    $rating_temp = DB::table('reviews')
                        ->where([
                            ['reviews.product_id', '=', $val->id]
                        ])
                        ->select('rating')
                        ->get();

                    if (sizeof($rating_temp)) {
                        $val->rating  = round(DB::table('reviews')->where([['product_id', '=', $val->id]])->avg('rating'), 1);
                        // $rating_temp[0]->rating;
                    } else {
                        $val->rating = '0.0';
                    }

                    $product_colors_stock = [];

                    $val->stock = 0;

                    if ($val->colors) {
                        $colors = $val->colors;
                        $colors = str_replace(" ", "", $colors);
                        $colors = explode(",", $colors);

                        $product_colors_stock = [];

                        foreach ($colors as $color) {
                            $stock = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $val->id],
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
                                            ['product_id', '=', $val->id],
                                            ['product_color', '=', $color],
                                        ])
                                        ->sum('added_stock');

                                    $stock_usage = DB::table('stocks')
                                        ->where([
                                            ['product_id', '=', $val->id],
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
                                    $val->stock = 1;
                                }
                            }
                        }
                    } else {

                        $stock = DB::table('stocks')
                            ->where([
                                ['product_id', '=', $val->id]
                            ])
                            ->select('*')
                            ->get();

                        if (sizeof($stock)) {

                            $stock = $stock[0];

                            if ($stock->outof_stock == '0') {
                                //
                                $stock_added = DB::table('stocks')
                                    ->where([
                                        ['product_id', '=', $val->id],
                                    ])
                                    ->sum('added_stock');

                                $stock_usage = DB::table('stocks')
                                    ->where([
                                        ['product_id', '=', $val->id],
                                    ])
                                    ->sum('stock_usage');

                                if (($stock_added - $stock_usage) != 0) {
                                    $val->stock = 1;
                                }
                            }
                        }
                    }
                }
                $product_bottom = json_decode($product_bottom, true);

                usort($product_bottom, function ($a, $b) {
                    if ($a['stock'] == $b['stock']) {
                        return 0;
                    }
                    return ($a['stock'] > $b['stock']) ? -1 : 1;
                });
            }

            $reviews = DB::table('reviews')
                ->join('customers', 'customers.id', '=', 'reviews.customer_id')
                ->where([
                    ['reviews.product_id', '=', $product->id]
                ])
                ->select('reviews.*', 'customers.first_name as fname', 'customers.last_name as lname')
                ->orderBy('reviews.review', 'DESC')
                ->get();

            if (sizeof($reviews)) {
                foreach ($reviews as $review) {
                    $x = DB::table('review_helpful')->where([['review_id', '=', $review->id]])->count();
                    $review->helpful_count  = $x;

                    $review->helpful_marked = 0;

                    if ($customer) {
                        $y = DB::table('review_helpful')->where([['review_id', '=', $review->id], ['customer_id', '=', $customer->id]])->count();
                        $review->helpful_marked  = $y;
                    }
                }
            }

            $ratings = DB::table('reviews')
                ->where([
                    ['product_id', '=', $product->id]
                ])
                ->select('rating')
                ->get();

            $rating_avg = DB::table('reviews')->where([['product_id', '=', $product->id]])->avg('rating');
            $rating_con = DB::table('reviews')->where([['product_id', '=', $product->id]])->count('rating');
            $reviews_con = DB::table('reviews')->where([['product_id', '=', $product->id]])->count('review');



            foreach ($ratings as $r) {
                if ($r->rating == "1") {
                    $ratingE[0] = $ratingE[0] + 1;
                } else if ($r->rating == "2") {
                    $ratingE[1] = $ratingE[1] + 1;
                } else if ($r->rating == "3") {
                    $ratingE[2] = $ratingE[2] + 1;
                } else if ($r->rating == "4") {
                    $ratingE[3] = $ratingE[3] + 1;
                } else if ($r->rating == "5") {
                    $ratingE[4] = $ratingE[4] + 1;
                }
            }

            foreach ($ratingE as $key => $rE) {
                if ($rE > 0) {
                    $ratingE[$key] = $rE / $rating_con * 100;
                }
            }

            // dd($ratingE);

            // dd(date('D, j M Y', '2021-07-07 23:48:10'));


            $sellerP = DB::table('reviews')
                ->join('products', 'products.id', '=', 'reviews.product_id')
                ->join('sellers', 'sellers.id', '=', 'products.seller_id')
                ->where([
                    ['products.seller_id', '=', $product->seller_id]
                ])
                ->avg('rating');
            // dd($sellerP);
            $sellerP = $sellerP / 5 * 100;
        }
        // dd($ratings[0]->rating);
        // dd(sizeof($images));
        // dd(sizeof($product_4));



        return view('products', [
            'product' => $product,
            'images' => $images,
            'productsTop' => $product_4,
            'product_bottom' => $product_bottom,
            'reviews' => $reviews,
            'ratings' => $ratings,
            'ratingAvg' => $rating_avg,
            'ratingCon' => $rating_con,
            'reviewsCon' => $reviews_con,
            'sellerP' => $sellerP,
            'ratingE' => $ratingE
        ]);
    }

    public function changeStock(Request $request)
    {
        $pid = $request->pid;
        $color = $request->color;
        $stock = 0;

        $stock_d = DB::table('stocks')
            ->where([
                ['product_id', '=', $pid],
                ['product_color', '=', $color],
            ])
            ->select('*')
            ->get();

        if (sizeof($stock_d)) {
            $stock_added = DB::table('stocks')
                ->where([
                    ['product_id', '=', $pid],
                    ['product_color', '=', $color],
                ])
                ->sum('added_stock');

            $stock_usage = DB::table('stocks')
                ->where([
                    ['product_id', '=', $pid],
                    ['product_color', '=', $color],
                ])
                ->sum('stock_usage');

            if (($stock_added - $stock_usage) != 0) {
                $stock = $stock_added - $stock_usage;
            } else {
                $stock = 0;
            }
        }

        return $stock;
    }
}
