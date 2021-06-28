<?php

namespace App\Http\Controllers;

use App\Models\SellerProducts;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SellerDashboardProducts extends Controller
{
    public function manageProducts(Request $request)
    {
        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
        }


        $sellerId = Session::get('seller');

        if (!$sellerId) {
            CommonController::checkSeller('/seller/login');
        }

        $data = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->where([
                ['products.seller_id', "=",  $sellerId],
                ['products.blacklisted', '=', 0],
                ['products.delete_status', '=', 0]
            ])
            ->select('products.id', 'products.images', 'products.code',  'products.name', 'products.type', 'products.colors', 'products.sizes', 'products.discount', 'products.tax', 'products.short_desc', 'products.unit_price', 'product_categories.name as category_name')
            ->get();


        $cato = DB::table('seller_product_category')
            ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
            ->where([
                ['seller_product_category.seller_id', "=",  $sellerId]
            ])
            ->select('product_categories.name as name', 'seller_product_category.id as id')
            ->get();

        $last_record = DB::table('products')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['blacklisted', '=', 0],
                ['delete_status', '=', 0]
            ])
            ->select('product_catrgory_id', 'type')
            ->latest('created_at')->first();

        $last_cato = DB::table('product_categories')
            ->join('seller_product_category', 'seller_product_category.product_category_id', '=', 'product_categories.id')
            ->where([
                ['seller_product_category.product_category_id', "=",  $last_record->product_catrgory_id],
            ])
            ->select('product_categories.name as name')
            ->get();

        $last_cato = json_decode($last_cato, true)[0]['name'];
        $last_type = $last_record->type;

        Session::flash('last_data',  [$last_cato, $last_type]);

        if ($request->ajax()) {

            $num = 0;

            function numIncrement()
            {
                global $num;
                $num++;
                return $num;
            }

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($product) {
                    $productName = $product->name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $product->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $productName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $product->id . '"></span>';
                    return $btn;
                })

                ->addColumn('category_name', function ($product) {
                    $cat_name = $product->category_name;

                    $txt = '<span>' . $cat_name . '</span><br><span><small><i>(' . $product->type . ')<//i></small></span>';
                    return $txt;
                })

                ->addColumn('unit_price', function ($product) {
                    $unit_price = floatval($product->unit_price);

                    $discount = floatval($product->discount);

                    $tax = floatval($product->tax);

                    $price = ($unit_price * (100 - $discount) * (100 - $tax)) / (100 * 100);
                    $price = number_format($price, 2, '.', ',');
                    $unit_price = number_format($unit_price, 2, '.', ',');

                    $txt = '<span>' . $unit_price . '</span><br><span><i>(' . $price . ')</i></span>';
                    return $txt;
                })


                ->addColumn('images', function ($product) {
                    $txt = '';

                    if ($product->images) {
                        $img_arr1 = str_replace("[", '', $product->images);
                        $img_arr2 = str_replace("]", '', $img_arr1);
                        $img_arr = explode(",", $img_arr2);

                        foreach ($img_arr as $image) {
                            $img = "/" . $image;
                            $img = str_replace('"', '', $img);
                            $img = str_replace('"', '', $img);
                            $txt .= '<img src=' . $img . ' width="40px" class="table-img">';
                        }
                    }

                    return $txt;
                })

                ->addColumn('name', function ($product) {
                    $txt = "<strong>" . $product->name . "</strong> <br> <small>" . $product->short_desc . "</small> <br><br><i>-" . $product->code . "-</i>";
                    return $txt;
                })

                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })

                ->rawColumns(['action', 'images', 'name', 'ids', 'category_name', 'unit_price'])
                ->setRowId('{{$id}}')

                ->make(true);
        }

        return view('seller.dashboard_products', ['catogeries' => $cato, 'products' => $data]);
    }

    public function addNewProduct(Request $request)
    {
        $product = new SellerProducts();
        $sellerId = Session::get('seller');

        $tax = '0.00';
        if ($request->tax) {
            $tax = $request->tax;
        }

        $discount = '0.00';
        if ($request->discount) {
            $tax = $request->discount;
        }



        $productDetails = DB::table('products')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['code', '=', $request->code],
                ['delete_status', '=', 0],
            ])
            ->select('*')
            ->get()->first();

        if (!$productDetails) {

            $cato_id = DB::table('seller_product_category')
                ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
                ->where([
                    ['seller_product_category.seller_id', "=",  $sellerId],
                    ['product_categories.name', "=",  $request->product_category]
                ])
                ->select('product_categories.id')
                ->get();

            $product->seller_id = $sellerId;
            $product->product_catrgory_id = json_decode($cato_id, true)[0]['id'];
            $product->code = $request->code;
            $product->name = $request->name;
            $product->type = $request->type;
            $product->url = "test";
            $product->images = "test";
            $product->short_desc = $request->short_desc;
            $product->long_desc = $request->long_desc;
            $product->unit_price = $request->unit_price;
            $product->tax = $tax;
            $product->discount = $discount;
            $product->colors = $request->colors;
            $product->sizes = $request->sizes;
            $product->delete_status = 0;
            $product->save();

            $productUrl = $this->slug($request->name . '-' . json_decode($product, true)['id']);
            $product->url = $productUrl;

            $files = $request->file('images');
            $uploadedFiles = [];

            $k = 0;
            foreach ($files as $file) {
                if ($k < 3) {
                    $destinationPath = 'products/images/' . $productUrl;
                    $file->move($destinationPath, $file->getClientOriginalName());
                    $uploadedFiles[] = $destinationPath . '/' . $file->getClientOriginalName();
                    $k++;
                }
            }

            $product->images = $uploadedFiles;
            $product->save();

            Session::flash('status', ['0', 'Product has been successfully added to the store!']);
        } else {
            Session::flash('status', ['1', 'Something went wrong. Please try again later!']);
            if ($productDetails->blacklisted) {
                Session::flash('status', ['1', 'This product has been blacklisted!']);
            } else if ($productDetails->code == $request->code) {
                Session::flash('status', ['2', 'This product already exists!']);
            }
        }
        return redirect()->back();
    }

    public static function slug($text)
    {
        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = str_replace(' ', '-', $text);
        
        // remove duplicate -
        $text = str_replace(',', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function deleteProduct(Request $request)
    {
        $pid = $request->get('rowid');

        $status = 0;
        $affected = DB::table('products')->where('id', $pid)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function productDetails(Request $request)
    {
        $pid = $request->get('rowid');

        $data = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->where('products.id', $pid)
            ->select('products.*', 'product_categories.name as category_name')
            ->get();

        return $data;
    }

    public function updateProduct(Request $request)
    {



        $pid = $request->get('pid');
        $sellerId = Session::get('seller');
        $status = 0;

        $cato_id = DB::table('seller_product_category')
            ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
            ->where([
                ['seller_product_category.seller_id', "=",  $sellerId],
                ['product_categories.name', "=",  $request->product_category]
            ])
            ->select('product_categories.id')
            ->get();


        $productUrl = $this->slug($request->get('name') . '-' . $pid);

        $updateDetails = [
            'product_catrgory_id' => json_decode($cato_id, true)[0]['id'],
            'name' => $request->get('name'),
            'url' => $productUrl,
            'short_desc' => $request->get('short_desc'),
            'long_desc' => $request->get('long_desc'),
            'unit_price' => $request->get('unit_price'),
            'tax' => $request->get('tax'),
            'discount' => $request->get('discount'),
            'colors' => $request->get('colors'),
            'sizes' => $request->get('sizes'),
            'type' => $request->get('type')
        ];

        $files = $request->file('images');
        $uploadedFiles = [];

        if ($files != null) {
            $k = 0;
            foreach ($files as $file) {
                if ($k < 3) {
                    $destinationPath = 'products/images/' . $productUrl;
                    $file->move($destinationPath, $file->getClientOriginalName());
                    $uploadedFiles[] = $destinationPath . '/' . $file->getClientOriginalName();
                    $k++;
                }
            }
            $updateDetails['images'] = $uploadedFiles;
        }

        $affected = DB::table('products')
            ->where('id', $pid)
            ->update($updateDetails);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
