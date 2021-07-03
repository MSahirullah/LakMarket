<?php

namespace App\Http\Controllers;

use App\Models\SellerCategories;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SellerDashboardProducts;
use App\Models\SellerProductCategories;
use Illuminate\Support\Facades\Session;

class SellerDashboardCategories extends Controller
{
    public function manageCategories(Request $request)
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

        $data = DB::table('seller_product_category')
            ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
            ->where([
                ['seller_product_category.seller_id', "=",  $sellerId]
            ])
            ->select('product_categories.name as name', 'seller_product_category.id as id')
            ->get();



        $seller = DB::table('sellers')
            ->where([
                ['id', "=",  $sellerId]
            ])
            ->select('shop_category_id')
            ->get();

        $seller = json_decode($seller, true)[0]['shop_category_id'];

        $categories = DB::table('product_categories')
            ->where([
                ['shop_categories_id', "=",  $seller]
            ])
            ->select('name', 'id')
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
                ->addColumn('action', function ($category) {
                    $categoryName = $category->name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $category->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit Category Details"></span>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $category->id . '"> </span>';
                    return $btn;
                })


                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })

                ->rawColumns(['ids', 'action'])
                ->setRowId('{{$id}}')

                ->make(true);
        }

        return view('seller.dashboard_categories', ['categories' => $categories]);
    }

    public function addNewCategory(Request $request)
    {
        $newcategory = new SellerProductCategories();
        $sellerId = Session::get('seller');


        $category = DB::table('product_categories')
            ->where([
                ['name', "=",  $request->categoryName]
            ])
            ->select('id')
            ->get();

        $category = json_decode($category, true)[0]['id'];



        $check = DB::table('seller_product_category')
            ->where([
                ['product_category_id', "=",  $category],
                ['seller_id', "=",  $sellerId],
            ])
            ->select('id')
            ->get();

        $check = json_decode($check, true);

        if ($check == []) {

            $newcategory->seller_id = $sellerId;
            $newcategory->product_category_id = $category;
            $newcategory->save();

            Session::flash('status', ['0', 'Category has been successfully added to the store!']);
            return redirect()->route('category.list');
        }

        Session::flash('status', ['1', 'This category already exists on your store.']);

        return redirect()->route('category.list');
    }

    public function categoryDetails(Request $request)
    {
        $cid = $request->get('rowid');

        $data = DB::table('seller_product_category')
            ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
            ->where([
                ['seller_product_category.id', '=', $cid]
            ])
            ->select('product_categories.name as name', 'seller_product_category.id as id')
            ->get();
        return $data;
    }

    public function deleteCategory(Request $request)
    {
        $cid = $request->get('rowid');
        $sellerId = Session::get('seller');

        $status = 0;

        $affected = DB::table('seller_product_category')->where([['id', '=', $cid]])->delete();

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function updateCategory(Request $request)
    {
        $cid = $request->get('cid');
        $sellerId = Session::get('seller');
        $status = 0;

        $category = DB::table('product_categories')
            ->where([
                ['name', "=",  $request->categoryName]
            ])
            ->select('id')
            ->get();

        $category = json_decode($category, true)[0]['id'];

        $check = DB::table('seller_product_category')
            ->where([
                ['product_category_id', "=",  $category],
                ['seller_id', "=",  $sellerId],
            ])
            ->select('id')
            ->get();


        $check = json_decode($check, true);


        if ($check == []) {

            $affected = DB::table('seller_product_category')
                ->where([
                    ['id', '=', $cid]
                ])
                ->update(['product_category_id' => $category]);

            if ($affected) {
                $status = 1;
            }
        }

        return $status;
    }
}
