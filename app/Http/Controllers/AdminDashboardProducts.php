<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProducts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Hash;

class AdminDashboardProducts extends Controller
{
    //
    public function index(Request $request)
    {

        $data = DB::table('products')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_catrgory_id')
            ->select('products.*', 'sellers.full_name as seller_name', 'product_categories.name as product_category')
            ->get();

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
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $product->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $productName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn1" data-id="' . $product->id . '"></span></br>';
                    return $btn;
                })


                ->addColumn('name', function ($product) {
                    $productName = $product->name;
                    $txt = "<span>" . $productName . "</span>";
                    return $txt;
                })

                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })
                ->addColumn('seller_name', function ($product) {
                    $seller_name = $product->seller_name;
                    return $seller_name;
                })
                ->addColumn('product_category', function ($product) {
                    $product_category = $product->product_category;
                    return $product_category;
                })
                ->addColumn('cod', function ($product) {
                    $cod_status = $product->cod;
                    if ($cod_status == 1) {
                        $txt = "<span>Available</span>";
                        return $txt;
                    } else {
                        $txt = "<span>Not Available</span>";
                        return $txt;
                    }
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
                            $txt .= '<img src=' . $img . ' width="100px" class="table-img">';
                        }
                    }
                    return $txt;
                })

                ->addColumn('status', function ($product) {
                    $productblacklisted = $product->blacklisted;
                    $productdeleted = $product->delete_status;
                    if ($productblacklisted && $productdeleted) {
                        $txt = "<span>Deleted</br>Blacklisted</span>";
                        return $txt;
                    } elseif ($productdeleted) {
                        $txt = "<span>Deleted</span>";
                        return $txt;
                    } elseif ($productblacklisted) {
                        $txt = "<span>Blacklisted</span>";
                        return $txt;
                    } else {
                        $txt = "<span></span>";
                        return $txt;
                    }
                })

                ->rawColumns(['ids', 'name', 'seller_name', 'product_category', 'images', 'status', 'action', 'cod'])
                ->setRowId('{{$id}}')

                ->make(true);
        }
        return view('admin.dashboard_products');
    }

    public function deleteProduct(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('products')->where('id', $row)
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
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->where('products.id', $pid)
            ->select('products.*', 'sellers.full_name as seller_name',)
            ->get();

        return $data;
    }

    public function updateProductDetails(Request $request)
    {

        $pid = $request->get('pid');
        $status = 0;

        $updateDetails = [
            'name' => $request->get('item_name'),
            'code' => $request->get('product_code'),
            //'product_catrgory_id' => $request->get('product_category'),
        ];

        $files = $request->file('images');
        $uploadedFiles = [];

        $affected = DB::table('products')
            ->where('id', $pid)
            ->update($updateDetails);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
