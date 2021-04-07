<?php

namespace App\Http\Controllers;

use App\Models\SellerProducts;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Session;

class SellerDashboardProducts extends Controller
{
    public function manageProducts(Request $request)
    {
        $sellerId = Session::get('seller')['id'];

        $data = DB::table('products')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->where([
                ['products.seller_id', "=",  $sellerId],
                ['products.blacklisted', '=', 0],
                ['products.delete_status', '=', 0]
            ])
            ->select('products.*', 'product_categories.name as category_name')
            ->get();


        $cato = DB::table('product_categories')
            ->join('sellers', 'sellers.id', '=', 'product_categories.seller_id')
            ->where([
                ['product_categories.seller_id', "=",  $sellerId],
                ['product_categories.blacklisted', '=', 0],
                ['product_categories.delete_status', '=', 0]
            ])
            ->select('product_categories.*')
            ->get();

        if ($request->ajax()) {

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($product) {
                    $productName = $product->name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $product->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success successBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $productName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $product->id . '"></span>';
                    return $btn;
                })

                ->addColumn('product_catrgory_id', function ($product) {
                    $cat_name = $product->category_name;
                    return $cat_name;
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
                    $txt = "<strong>" . $product->name . "</strong> <br> <small>" . $product->short_desc . "</small> <br><br> <i>-" . $product->code . "-</i>";
                    return $txt;
                })

                ->rawColumns(['action', 'images', 'name'])
                ->setRowId('{{$id}}')

                ->make(true);
        }

        return view('seller.dashboard_products', ['catogeries' => $cato, 'products' => $data]);
    }

    public function addNewProduct(Request $request)
    {
        $product = new SellerProducts();
        $sellerId = Session::get('seller')['id'];
        $status = 0;

        $productDetails = DB::table('products')
            ->where([['seller_id', "=",  $sellerId], ['code', '=', $request->code]])
            ->select('*')
            ->get()->first();

        if ($productDetails) {
            if ($productDetails->blacklisted) {
                $status = 1;
            } else if ($productDetails->code == $request->code) {
                $status = 2;
            }
        } else {
            $cato_id = DB::table('product_categories')
                ->where([
                    ['seller_id', "=",  $sellerId],
                    ['name', "=",  $request->product_category]
                ])
                ->select('id')
                ->get();

            $product->seller_id = $sellerId;
            $product->product_catrgory_id = json_decode($cato_id, true)[0]['id'];
            $product->code = $request->code;
            $product->name = $request->name;
            $product->url = "test";
            $product->images = "test";
            $product->short_desc = $request->short_desc;
            $product->unit_price = $request->unit_price;
            $product->tax = $request->tax;
            $product->discount = $request->discount;
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
            $status = 3;
        }

        return redirect()->route('seller.profile')->with(session()->now('addNewStatus', $status));
    }

    public static function slug($text)
    {
        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = str_replace(' ', '-', $text);

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
        $sellerId = Session::get('seller')['id'];
        $status = 0;

        $cato_id = DB::table('product_categories')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['name', "=",  $request->product_category]
            ])
            ->select('id')
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
            'sizes' => $request->get('sizes')
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
