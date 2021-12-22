<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use stdClass;

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

        //Store Categories
        $pCato =  DB::table('seller_product_category')
            ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
            ->where([['seller_id', '=', $storeD[0]->id]])
            ->select('product_categories.name', 'product_categories.url')
            ->orderBy('product_categories.name')
            ->get();

        $pCato2 = new stdClass;

        foreach ($pCato as $key => $data) {

            $pCato2->{$key} = ['name' => $data->name, 'url' => $data->url, 'storeURL' => $storeD[0]->url];
        }

        $products = $this->storeProductList($sellerID = $storeD[0]->id, $sort = 'Best Match');

        $positiveF = number_format(floatval($positiveF), 2);

        return view('store-home', [
            'store' => $storeD[0],
            'followers' => $followers,
            'positiveF' => $positiveF,
            'positiveFC' => $positiveFC,
            'followS' => $followS,
            'shopCategories' => $pCato2,
            'products' => $products,
            'q' => '',
            'catoID' => '',
        ]);
    }

    public function storeProductFilter(Request $request)
    {
        $sid = $request->storeId;
        $sort = $request->sort;
        $cato = $request->cato == '' ? 'All Categories' : $request->cato;
        $priceMin = $request->priceMin;
        $priceMax = $request->priceMax;
        $query = $request->q;

        $deliveryS = $request->deliveryStatus;

        $result = $this->storeProductList($sellerID = $sid, $sort = $sort, $deliveryS = $deliveryS, $priceMin = $priceMin, $priceMax = $priceMax, $cato = $cato, $query = $query);

        return (['products' => $result]);
    }

    public function storeProductList($sellerID, $sort, $deliveryS = '3', $priceMin = '0.00', $priceMax = '10000000.00', $cato = "All Categories", $query = '')
    {
        if ($deliveryS == '3' || $deliveryS == '0') {
            $deliveryQ = ['products.cod', '!=', null];
        } else if ($deliveryS == '1') {
            $deliveryQ = ['products.cod', '=', '0'];
        } else if ($deliveryS == '2') {
            $deliveryQ = ['products.cod', '=', '1'];
        }

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

        if ($query != '') {
            $qry = ['products.name', 'LIKE', '%' . $query . '%'];
        } else {
            $qry = ['products.name', '!=', 'null'];
        }

        if ((!$priceMin || $priceMin == '0.00') && (!$priceMax || $priceMax == '0.00')) {
            $priceMin = '0.00';
            $priceMax = '10000000.00';
        }

        if ($cato == "All Categories") {
            $catoQ = ['products.product_catrgory_id', '!=', 'null'];
        } else {
            $catoP =  DB::table('product_categories')
                ->where([['id', '=', $cato]])
                ->select('id')
                ->get();

            if (sizeof($catoP)) {
                $catoQ = ['products.product_catrgory_id', '=', $catoP[0]->id];
            } else {
                $catoQ = ['products.product_catrgory_id', '!=', 'null'];
            }
        }

        $priceMin = (float) $priceMin;
        $priceMax = (float) $priceMax;

        $productList = [];

        $products = DB::table('products')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->where(
                [
                    ['products.seller_id', '=', $sellerID],
                    ['products.delete_status', '=', '0'],
                    ['products.blacklisted', '=', '0'],
                    $deliveryQ, $catoQ, $qry
                ]
            )
            ->select('products.*')
            ->orderBy($orderBy, $orderByVal)
            ->whereBetween('products.discounted_price', [$priceMin, $priceMax])
            ->get();

        foreach ($products as $product) {
            if (!in_array($product, $productList)) {
                array_push($productList, $product);
            }
        }

        foreach ($productList as $product) {

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

            $product->discounted_price = number_format(floatval($product->discounted_price), 2);
            $product->unit_price = number_format($product->unit_price, 2);

            $rating_temp = DB::table('reviews')
                ->where([
                    ['reviews.product_id', '=', $product->id],
                    ['reviews.delete_status', '=', '0']
                ])
                ->select('rating')
                ->get();

            if (sizeof($rating_temp)) {
                $product->rating  = round(DB::table('reviews')
                    ->where(
                        [
                            ['product_id', '=', $product->id],
                            ['delete_status', '=', '0']
                        ]
                    )
                    ->avg('rating'), 1);
            } else {
                $product->rating = '0.0';
            }

            if (!in_array($product, $productList)) {
                array_push($productList, $product);
            }
        }



        usort($productList, function ($a, $b) {
            if ($a->stock == $b->stock) {
                return 0;
            }
            return ($a->stock > $b->stock) ? -1 : 1;
        });

        return $productList;
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

    public function storeCategoryProducts($store, $category)
    {
        $followers = 0;
        $followS = 0;
        $positiveF = '';
        $positiveFC = '';
        $storeD = '';
        $customer = '';

        $category = $category;
        $store = $store;

        $catoP =  DB::table('product_categories')
            ->where([['url', '=', $category]])
            ->select('*')
            ->get();

        $storeD = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->where([
                ['sellers.url', '=', $store]
            ])
            ->select('sellers.*', 'shop_categories.name as store_cato', 'shop_categories.url as cato_url')
            ->get();



        if (sizeof($catoP) && sizeof($storeD)) {

            $catoID = $catoP[0]->id;

            if (Session::has('customer')) {
                $customer = Session::get('customer')['id'];
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

            //Store Categories
            $pCato =  DB::table('seller_product_category')
                ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
                ->where([['seller_id', '=', $storeD[0]->id]])
                ->select('product_categories.name', 'product_categories.url')
                ->orderBy('product_categories.name')
                ->get();


            $pCato2 = new stdClass;
            $pCato2->{0} = ['name' => $catoP[0]->name, 'url' => $catoP[0]->url, 'storeURL' => $storeD[0]->url];

            foreach ($pCato as $key => $data) {
                if ($data->name !=  $catoP[0]->name) {
                    $pCato2->{$key + 1} = ['name' => $data->name, 'url' => $data->url, 'storeURL' => $storeD[0]->url];
                }
            }


            $products = $this->storeProductList($sellerID = $storeD[0]->id, $sort = 'Best Match',  $deliveryS = '3', $priceMin = '0.00', $priceMax = '10000000.00', $cato = $catoID);
            // dd($catoID);

            return view('store-home', [
                'store' => $storeD[0],
                'followers' => $followers,
                'positiveF' => $positiveF,
                'positiveFC' => $positiveFC,
                'followS' => $followS,
                'shopCategories' => $pCato2,
                'products' => $products,
                'q' => $catoP[0]->name,
                'catoID' => $catoP[0]->id,
            ]);
        }
        abort(404);
    }

    public function storeSearchProducts(Request $request, $store)
    {
        $query = $request->q;

        $followers = 0;
        $followS = 0;
        $positiveF = '';
        $positiveFC = '';
        $storeD = '';
        $customer = '';

        $store = $store;

        $catoP = DB::table('product_categories')
            ->where([['name', '=', $query],])
            ->select('*')
            ->get();

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


        if (Session::has('customer')) {
            $customer = Session::get('customer')['id'];
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

        if (sizeof($catoP)) {
            $catoID = $catoP[0]->id;

            //Store Categories
            $pCato =  DB::table('seller_product_category')
                ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
                ->where([['seller_id', '=', $storeD[0]->id]])
                ->select('product_categories.name', 'product_categories.url')
                ->orderBy('product_categories.name')
                ->get();


            $pCato2 = new stdClass;
            $pCato2->{0} = ['name' => $catoP[0]->name, 'url' => $catoP[0]->url, 'storeURL' => $storeD[0]->url];

            foreach ($pCato as $key => $data) {
                if ($data->name !=  $catoP[0]->name) {
                    $pCato2->{$key + 1} = ['name' => $data->name, 'url' => $data->url, 'storeURL' => $storeD[0]->url];
                }
            }

            $products = $this->storeProductList($sellerID = $storeD[0]->id, $sort = 'Best Match',  $deliveryS = '3', $priceMin = '0.00', $priceMax = '10000000.00', $cato = $catoID);

            return view('store-home', [
                'store' => $storeD[0],
                'followers' => $followers,
                'positiveF' => $positiveF,
                'positiveFC' => $positiveFC,
                'followS' => $followS,
                'shopCategories' => $pCato2,
                'products' => $products,
                'q' => $catoP[0]->name,
                'catoID' => $catoP[0]->id,
            ]);
        } else {

            //Store Categories
            $pCato =  DB::table('seller_product_category')
                ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
                ->where([['seller_id', '=', $storeD[0]->id]])
                ->select('product_categories.name', 'product_categories.url')
                ->orderBy('product_categories.name')
                ->get();

            $pCato2 = new stdClass;

            foreach ($pCato as $key => $data) {

                $pCato2->{$key} = ['name' => $data->name, 'url' => $data->url, 'storeURL' => $storeD[0]->url];
            }


            $products = $this->storeProductList($sellerID = $storeD[0]->id, $sort = 'Best Match',  $deliveryS = '3', $priceMin = '0.00', $priceMax = '10000000.00', $cato = "All Categories", $query = $query);

            Session::flash('storeSearchCato', $query);

            return view('store-home', [
                'store' => $storeD[0],
                'followers' => $followers,
                'positiveF' => $positiveF,
                'positiveFC' => $positiveFC,
                'followS' => $followS,
                'shopCategories' => $pCato2,
                'products' => $products,
                'q' => $query,
                'catoID' => -1,
            ]);
        }
    }
}
