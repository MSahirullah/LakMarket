<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Hash;

class AdminDashboardSellers extends Controller
{
    //
    public function index(Request $request)
    {

        $data = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->select('sellers.*', 'shop_categories.name as shop_category_name', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
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
                ->addColumn('action', function ($seller) {
                    $sellerName = $seller->full_name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $seller->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $sellerName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn1" data-id="' . $seller->id . '"></span></br>';
                    $btn = $btn . '<span class="fas fa-trash removeBtn2" data-id="' . $seller->id . '"></span>';
                    return $btn;
                })


                ->addColumn('name', function ($seller) {
                    $sellerName = $seller->full_name;
                    $txt = "<span>" . $sellerName . "</span>";
                    return $txt;
                })

                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })
                ->addColumn('shop_category', function ($seller) {
                    $shop_category = $seller->shop_category_name;
                    return $shop_category;
                })

                ->addColumn('city', function ($seller) {
                    $city = $seller->city;
                    return $city;
                })

                ->addColumn('district', function ($seller) {
                    $district = $seller->district;
                    return $district;
                })

                ->addColumn('store_logo', function ($seller) {
                    $txt = '';

                    if ($seller->store_logo) {
                        $img_arr1 = str_replace("[", '', $seller->store_logo);
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

                ->addColumn('status', function ($seller) {
                    $sellerblacklisted = $seller->blacklisted;
                    $sellerdeleted = $seller->delete_status;
                    if ($sellerblacklisted && $sellerdeleted) {
                        $txt = "<span>Deleted</br>Blacklisted</span>";
                        return $txt;
                    } elseif ($sellerdeleted) {
                        $txt = "<span>Deleted</span>";
                        return $txt;
                    } elseif ($sellerblacklisted) {
                        $txt = "<span>Blacklisted</span>";
                        return $txt;
                    } else {
                        $txt = "<span></span>";
                        return $txt;
                    }
                })

                ->rawColumns(['ids', 'name', 'shop_category', 'city', 'district', 'store_logo', 'status', 'action'])
                ->setRowId('{{$id}}')

                ->make(true);
        }
        return view('admin.dashboard_sellers');
    }

    public function deleteSeller(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('sellers')->where('id', $row)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function blacklistSeller(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('sellers')->where('id', $row)
            ->update(['blacklisted' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function sellerDetails(Request $request)
    {
        $sid = $request->get('rowid');

        $data = DB::table('sellers')
            ->where('sellers.id', $sid)
            ->select('*')
            ->get();

        return $data;
    }

    public function updateSellerDetails(Request $request)
    {

        $sid = $request->get('sid');
        $status = 0;

        $updateDetails = [
            'full_name' => $request->get('full_name'),
            'business_mobile' => $request->get('phone_number'),
            'birthday' => $request->get('dob'),
            'address' => $request->get('address'),
            'hotline' => $request->get('hotline_number'),
            'store_name' => $request->get('store_name'),
        ];

        $files = $request->file('images');
        $uploadedFiles = [];

        $affected = DB::table('sellers')
            ->where('id', $sid)
            ->update($updateDetails);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
