<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartDetails = $this->getCartDetails();

        $districts = CommonController::getDistricts();

        return view('cart', [
            'status' => $cartDetails['status'] == false ? 0 : 1,
            'cart_list' => $cartDetails['cart_list'],
            'count' => 0,
            'item_count' => $cartDetails['count'],
            'total' =>  "0",
            'saved' => "0",
            'districts' =>  $districts,
        ]);
    }

    public function cartCustomer()
    {
        $customer = Session::get('customer');

        $status = false;

        $addresses = DB::table('customer_addresses')
            ->join('lkcities', 'lkcities.id', '=', 'customer_addresses.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'customer_addresses.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'customer_addresses.province_id')
            ->where('customer_id', $customer->id)
            ->select('customer_addresses.id as id', 'address', 'full_name', 'lkcities.id as cityID', 'lkdistricts.id as districtID', 'lkcities.name_en as city', 'lkdistricts.name_en as district', 'lkprovinces.name_en as province', 'lkcities.postal_code as postal_code', 'label', 'mobile_no as phone', 'status')
            ->get();


        if (!sizeof($addresses)) {
            $status = false;
            return [
                'status' => $status,
            ];
        } else {

            $status = true;
            return [
                'status' => $status,
                'addresses' => json_decode($addresses, true)
            ];
        }
    }

    public function addToCart(Request $req)
    {
        $url = $req->url;
        $qty = $req->quantity;
        $customer = Session::get('customer');
        $cartColor = $req->color == '' ? ['product_id', '!=', Null] : ['color', '=', $req->color];

        $product =  DB::table('products')
            ->where([
                ['url', '=', $url]
            ])
            ->select('*')
            ->get();

        if (sizeof($product)) {

            $product = $this->getProductDetails($product[0]);

            $cart = DB::table('cart')
                ->where([
                    ['product_id', '=', $product->id],
                    ['customer_id', '=', $customer->id],
                    ['status', '=', '0'],
                    $cartColor
                ])
                ->select('*')
                ->get();

            if (!sizeof($cart)) {
                if ($product->stock != 0) {

                    $newCartProduct = new Cart();
                    $newCartProduct->customer_id = $customer->id;
                    $newCartProduct->product_id = $product->id;
                    $newCartProduct->quantity = $qty;
                    $newCartProduct->price = $product->discounted_price;

                    if ($product->colors) {
                        $colorC = '';

                        foreach ($product->colors as $color) {
                            if ($req->color != '' && $color['color'] == $req->color &&  $color['stock'] != 0) {
                                $colorC = $color['color'];
                            } else if ($req->color != '' && $color['color'] == $req->color &&  $color['stock'] == 0) {
                                return [1, 'This Product is currently out of stock.'];
                            }
                        }
                        if ($colorC == '') {
                            foreach ($product->colors as $color) {
                                if ($color['stock'] != 0) {
                                    $colorC = $color['color'];
                                }
                            }
                        }
                        $newCartProduct->color = $colorC;
                    }

                    $newCartProduct->save();
                    return [0, 'Product successfully added to your shopping cart.'];
                } else {
                    return [1, 'This Product is currently out of stock.'];
                }
            } else {

                //what happen if customer change the quantity

                if ($cart[0]->quantity != $qty) {

                    Cart::where('id', $cart[0]->id)
                        ->update(['quantity' => $qty]);

                    return [0, 'Product quantity successfully updated.'];
                }

                return [3, 'This Product is already in the cart.'];
            }
        }

        return [1, 'Sorry, something went wrong. Please try again, or refresh the page.'];
    }

    public function cartUpdate(Request $request)
    {
        $url = $request->url;
        $value = $request->value;
        $customer = Session::get('customer');
        $affected = 0;

        $affected = DB::table('cart')
            ->join('products', 'products.id', '=', 'cart.product_id')
            ->where([
                ['customer_id', '=', $customer->id],
                ['products.url', '=', $url],
                ['status', '=', '0'],
            ])->update(['quantity' => $value]);

        $cartDetails = $this->getCartDetails();

        return [
            'data' => $affected,
            'count' => $cartDetails['count'],
            'quantity' => $value,
            'total' =>  $cartDetails['total'],
            // 'saved' => $cartDetails['saved'],
        ];
    }

    public function cartStatus()
    {
        $customer = Session::get('customer');
        $total_amount = 0;
        $total_saved = 0;

        $productCount = DB::table('cart')->where([
            ['customer_id', '=', $customer->id],
            ['status', '=', '0'],
        ])->count();

        return $productCount;
    }

    public function cartMoveToWishlist(Request $request)
    {
        $customer = Session::get('customer');
        $url = $request->url;
        $affected = 0;
        $temp = 0;
        $msg = '';

        $cart = DB::table('cart')
            ->join('products', 'products.id', '=', 'cart.product_id')
            ->where([
                ['customer_id', '=', $customer->id],
                ['products.url', '=', $url],
                ['status', '=', '0'],
            ])
            ->select('cart.*')
            ->get();

        if (sizeof($cart)) {

            $cart = $cart[0];

            $affected = Cart::where('id', $cart->id)
                ->update(['status' => 1]);

            if ($affected) {
                $newWishlistProduct = new Wishlist();
                $newWishlistProduct->customer_id = $customer->id;
                $newWishlistProduct->product_id = $cart->product_id;
                $newWishlistProduct->quantity = $cart->quantity;
                $newWishlistProduct->price = $cart->price;

                if ($cart->color) {
                    $newWishlistProduct->color = $cart->color;
                }
                $newWishlistProduct->save();
                $temp = 1;
                $msg = 'Your product is moved to wishlist, you can re-add it to cart from wishlist.';

                $cartDetails = $this->getCartDetails();
                return ([
                    'alert' => $temp,
                    'msg' => $msg,
                    'status' => $cartDetails['status'] == false ? 0 : 1,
                    'cart_list' => $cartDetails['cart_list'],
                    'count' => 0,
                    'item_count' => $cartDetails['count'],
                    'total' =>  "0",
                    'saved' => "0",
                ]);
            } else {

                $temp = 0;
                $msg = 'Sorry, something went wrong. Please try again, or refresh the page.';
            }
        } else {

            $temp = 0;
            $msg = 'Sorry, something went wrong. Please try again, or refresh the page.';
        }

        return ([
            'alert' => $temp,
            'msg' => $msg,
        ]);
    }

    public function cartPriceUpdate(Request $request)
    {
        $urls = $request->proURL;
        $customer = Session::get('customer');
        $total_amount = 0;
        $total_saved = 0;
        $count = 0;

        if ($urls) {
            if (sizeof($urls)) {
                $products = DB::table('products')
                    ->whereIn('url', $urls)
                    ->get();

                if (sizeof($products)) {
                    $count = sizeof($products);
                    foreach ($products as $product) {

                        $cart = DB::table('cart')
                            ->where([
                                ['product_id', '=', $product->id],
                                ['customer_id', '=', $customer->id],
                                ['status', '=', '0'],
                            ])
                            ->get();
                        $cart = $cart[0];

                        //total amount
                        $total_amount = $total_amount + ((float)$product->discounted_price * $cart->quantity);
                        //total_saved
                        $total_saved = $total_saved + (((float)$product->unit_price - (float)$product->discounted_price) * $cart->quantity);
                    }
                    $total_amount = number_format($total_amount, 2);
                    $total_saved = number_format($total_saved, 2);
                }
            }
        }

        return [
            'total' => $total_amount == 0 ? '0' : $total_amount,
            'saved' => $total_saved == 0 ? '0' : $total_saved,
            'count' => $count,
        ];
    }

    public function cartRemoveProduct(Request $request)
    {
        $customer = Session::get('customer');
        $url = $request->url;
        $affected = 0;

        $affected = Cart::join('products', 'products.id', '=', 'cart.product_id')
            ->where([
                ['customer_id', '=', $customer->id],
                ['products.url', '=', $url],
                ['status', '=', '0'],
            ])
            ->update(['status' => 1]);

        if ($affected) {
            $cartDetails = $this->getCartDetails();

            return ([
                'affected' => $affected,
                'status' => $cartDetails['status'] == false ? 0 : 1,
                'cart_list' => $cartDetails['cart_list'],
                'count' => 0,
                'item_count' => $cartDetails['count'],
                'total' =>  "0",
                'saved' => "0",
            ]);
        }

        return ([
            'affected' => $affected,
        ]);
    }

    public function cartRemoveAllProduct(Request $request)
    {
        $customer = Session::get('customer');
        $proURL = $request->proURL;
        $affected = 0;

        $affected = DB::table('cart')
            ->join('products', 'products.id', '=', 'cart.product_id')
            ->where([
                ['customer_id', '=', $customer->id],
                ['status', '=', '0'],
            ])
            ->whereIn('products.url', $proURL)
            ->update(['status' => 1]);

        if ($affected) {
            $cartDetails = $this->getCartDetails();

            return ([
                'affected' => $affected,
                'status' => $cartDetails['status'] == false ? 0 : 1,
                'cart_list' => $cartDetails['cart_list'],
                'count' => 0,
                'item_count' => $cartDetails['count'],
                'total' =>  "0",
                'saved' => "0",
            ]);
        }

        return ([
            'affected' => $affected,
        ]);
    }

    public static function getCartDetails()
    {
        $customer = Session::get('customer');
        $status = false;
        $stores = [];
        $cartArray = [];
        $total_amount = 0;
        $total_saved = 0;

        $cart_list = DB::table('cart')
            ->where([
                ['customer_id', '=', $customer->id],
                ['status', '=', '0'],
            ])
            ->select('*')
            ->get();

        if (sizeof($cart_list)) {
            $status = true;
            foreach ($cart_list as $key => $cart) {

                //get the product details
                $product =  DB::table('products')
                    ->where([
                        ['id', '=', $cart->product_id]
                    ])
                    ->select("id", "seller_id", "name", "url", "images", "short_desc", "unit_price", "discounted_price", "tax", "discount")
                    ->get();

                if (sizeof($product)) {
                    if ($product[0]->images) {

                        $images = str_replace("\\", "", $product[0]->images);
                        $images = str_replace("[\"", "", $images);
                        $images = str_replace("\"]", "", $images);
                        $images = str_replace("\"", "", $images);

                        $images = explode(",", $images);
                        $product[0]->images = $images[0];
                    }
                }

                //get the store details
                $store = DB::table('sellers')
                    ->where([
                        ['id', '=', $product[0]->seller_id]
                    ])
                    ->select('id', 'store_name', 'url')
                    ->get();

                if (!in_array($store[0]->id, $stores)) {
                    array_push($stores, $store[0]->id);
                }

                //get the stock details
                $cart->stock = 0;
                if ($cart->color) {
                    $color = $cart->color;

                    $stock = DB::table('stocks')
                        ->where([
                            ['product_id', '=', $product[0]->id],
                            ['product_color', '=', $color],
                            ['delete_status', '!=', '1']
                        ])
                        ->select('*')
                        ->get();

                    if (sizeof($stock)) {

                        $stock = $stock[0];

                        if ($stock->outof_stock == '0') {

                            $stock_added = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product[0]->id],
                                    ['product_color', '=', $color],
                                    ['delete_status', '!=', '1']
                                ])
                                ->sum('added_stock');

                            $stock_usage = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product[0]->id],
                                    ['product_color', '=', $color],
                                    ['delete_status', '!=', '1']
                                ])
                                ->sum('stock_usage');

                            if (($stock_added - $stock_usage) != 0) {
                                $cart->stock = $stock_added - $stock_usage;
                            }
                        }
                    }
                } else {

                    $stock = DB::table('stocks')
                        ->where([
                            ['product_id', '=', $product[0]->id],
                            ['delete_status', '!=', '1']

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
                                    ['delete_status', '!=', '1']
                                ])
                                ->sum('added_stock');

                            $stock_usage = DB::table('stocks')
                                ->where([
                                    ['product_id', '=', $product[0]->id],
                                    ['delete_status', '!=', '1']
                                ])
                                ->sum('stock_usage');

                            if (($stock_added - $stock_usage) != 0) {
                                $cart->stock = $stock_added - $stock_usage;
                            }
                        }
                    }
                }

                //total amount
                $total_amount = $total_amount + ((float)$product[0]->discounted_price * $cart->quantity);
                //total_saved
                $total_saved = $total_saved + (((float)$product[0]->unit_price - (float)$product[0]->discounted_price) * $cart->quantity);

                $product[0]->discounted_price = number_format($product[0]->discounted_price, 2);
                $product[0]->unit_price = number_format($product[0]->unit_price, 2);
                $cart->price = number_format($cart->price, 2);

                $cart->product = $product[0];
                $cart->store = $store[0];
            }
        }

        foreach ($stores as $key => $store) {
            foreach ($cart_list as $cart) {
                if (($cart->store->id == $store)) {
                    $cartArray[$key][] = $cart;
                }
            }
        }

        $total_amount = number_format($total_amount, 2);
        $total_saved = number_format($total_saved, 2);

        return [
            'status' => $status,
            'cart_list' => $cartArray,
            'count' => sizeof($cart_list),
            'total' =>  $total_amount,
            'saved' => $total_saved,
        ];
    }

    public static function getProductDetails($product)
    {
        $product->discounted_price = number_format($product->discounted_price, 2);
        $product->unit_price = number_format($product->unit_price, 2);
        $product_colors_stock = [];

        if ($product->colors) {
            $colors = $product->colors;
            $colors = str_replace(" ", "", $colors);
            $colors = explode(",", $colors);

            $product_colors_stock = [];
            $product->stock = 0;

            foreach ($colors as $key => $color) {
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
                        $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
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
                            $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
                        } else {
                            $product_colors_stock[$key] = array('color' => $color, 'stock' => $stock_added - $stock_usage);
                        }
                    }
                } else {
                    $product_colors_stock[$key] = array('color' => $color, 'stock' => 0);
                }

                if ($product->stock == 0) {
                    if ($product_colors_stock[$key]['stock'] != 0) {
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

            $product->stock = 0;

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
                        $product->stock = $stock_added - $stock_usage;
                    }
                }
            }
        }


        if ($product_colors_stock) {

            usort($product_colors_stock, function ($item1, $item2) {
                return $item2['stock'] <=> $item1['stock'];
            });
            $product->colors = $product_colors_stock;
        }

        return $product;
    }
}
