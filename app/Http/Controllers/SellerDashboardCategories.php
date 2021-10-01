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

        $sellerId = Session::get('seller');

        if (!$sellerId) {
            return redirect()->route('seller.loginV');
        }

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
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



        foreach (json_decode($categories, true) as $kc => $cat) {
            foreach (json_decode($data, true) as $kd => $d) {
                if ($cat['name'] == $d['name']) {
                    unset($categories[$kc]);
                }
            }
        }

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

                    $btn =  '<span class="fas fa-trash removeBtn" data-id="' . $category->id . '"> </span>';
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


        $sellerId = Session::get('seller');

        $c1 = 0;
        $c2 = 0;



        foreach ($request->categoryName as $category) {
            $newcategory = new SellerProductCategories();
            $category_0 = DB::table('product_categories')
                ->where([
                    ['name', "=",  $category]
                ])
                ->select('id')
                ->get();

            $category_1 = json_decode($category_0, true)[0]['id'];

            $check = DB::table('seller_product_category')
                ->where([
                    ['product_category_id', "=",  $category_1],
                    ['seller_id', "=",  $sellerId],
                ])
                ->select('id')
                ->get();

            $check = json_decode($check, true);

            if ($check == []) {

                $newcategory->seller_id = $sellerId;
                $newcategory->product_category_id = $category_1;
                $newcategory->save();

                $c1 = $c1 + 1;
            } else {
                $c2 = $c2 + 1;
            }
        }

        $txt = '';
        if ($c1 > 1) {
            $txt = $txt . $c1 . ' ' . 'categories has been successfully added to the store. ';
        } else if ($c1 > 0) {
            $txt =  $txt . $c1 . ' ' . 'category has been successfully added to the store. ';
        }
        if ($c2 > 1) {
            $txt =  $txt . $c2 . ' ' . 'categories already exists on your store.';
        } else if ($c2 > 0) {
            $txt =  $txt . $c2 . ' ' . 'category already exists on your store.';
        }

        if ($c1 > 0) {
            Session::flash('status', ['0', $txt]);
        } else {
            Session::flash('status', ['1', $txt]);
        }

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
