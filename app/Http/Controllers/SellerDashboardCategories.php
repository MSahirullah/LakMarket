<?php

namespace App\Http\Controllers;

use App\Models\SellerCategories;
use Session;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SellerDashboardProducts;

class SellerDashboardCategories extends Controller
{
    public function sellerCategories(Request $request)
    {



        $sellerId = Session::get('seller');

        $data = DB::table('product_categories')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['blacklisted', '=', 0],
                ['delete_status', '=', 0]
            ])
            ->select('id', 'name', 'image')
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
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $category->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $categoryName . ' Details"></span>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $category->id . '"> </span>';
                    return $btn;
                })


                ->addColumn('image', function ($category) {
                    $txt = '';

                    if ($category->image) {
                        $img_arr1 = str_replace("[", '', $category->image);
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
                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })

                ->rawColumns(['ids', 'action', 'image'])
                ->setRowId('{{$id}}')

                ->make(true);
        }

        return view('seller.dashboard_categories', ['categories' => $data]);
    }

    public function addNewCategory(Request $request)
    {
        $category = new sellerCategories();
        $sellerId = Session::get('seller');

        $categoryDetails = DB::table('product_categories')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['name', '=', $request->name],
                ['delete_status', '=', 0],
            ])
            ->select('*')
            ->get()->first();

        if (!$categoryDetails) {

            $category->seller_id = $sellerId;
            $category->name = $request->name;
            $category->save();

            $categoryUrl = SellerDashboardProducts::slug($request->name . '-' . json_decode($category, true)['id']);
            $category->url = $categoryUrl;

            $file = $request->file('image');

            if ($file) {

                $destinationPath = 'categories/images/' . $categoryUrl;
                $file->move($destinationPath, $file->getClientOriginalName());
                $uploadedFile = $destinationPath . '/' . $file->getClientOriginalName();


                $category->image = $uploadedFile;
                $category->save();
            }
            return redirect()->route('category.list')->with(session()->put(['alert' => 'success', 'message' => 'Category has been successfully added to the store!']));
        } else {
            if ($categoryDetails->blacklisted) {

                return redirect()->route('category.list')->with(session()->put(['alert' => 'error', 'message' => 'This category has been blacklisted!']));
            } else if ($categoryDetails->name == $request->name) {

                return redirect()->route('category.list')->with(session()->put(['alert' => 'warning', 'message' => 'This category already exists!']));
            }
        }
        return redirect()->route('category.list')->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    }

    public function deleteCategory(Request $request)
    {
        $cid = $request->get('rowid');

        $status = 0;
        $affected = DB::table('product_categories')->where('id', $cid)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function categoryDetails(Request $request)
    {
        $cid = $request->get('rowid');

        $data = DB::table('product_categories')
            ->where('id', $cid)
            ->select('id', 'name', 'image')
            ->get();

        return $data;
    }

    public function updateCategory(Request $request)
    {

        $cid = $request->get('cid');
        $status = 0;

        // $cato_id = DB::table('product_categories')
        //     ->where([
        //         ['seller_id', "=",  $sellerId],
        //         ['name', "=",  $request->product_category]
        //     ])
        //     ->select('id')
        //     ->get();

        $categoryUrl = SellerDashboardProducts::slug($request->get('name') . '-' . $cid);

        $updateDetails = [
            'name' => $request->get('name'),
            'url' => $categoryUrl,
        ];

        $file = $request->file('image');



        // if ($file != null) {
        //     $k = 0;
        //     foreach ($files as $file) {
        //         if ($k < 3) {
        //             $destinationPath = 'products/images/' . $productUrl;
        //             $file->move($destinationPath, $file->getClientOriginalName());
        //             $uploadedFiles[] = $destinationPath . '/' . $file->getClientOriginalName();
        //             $k++;
        //         }
        //     }
        //     $updateDetails['images'] = $uploadedFiles;
        // }


        if ($file) {

            $destinationPath = 'categories/images/' . $categoryUrl;
            $file->move($destinationPath, $file->getClientOriginalName());
            $uploadedFile = $destinationPath . '/' . $file->getClientOriginalName();

            $updateDetails['image'] = $uploadedFile;
        }

        $affected = DB::table('product_categories')
            ->where('id', $cid)
            ->update($updateDetails);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
