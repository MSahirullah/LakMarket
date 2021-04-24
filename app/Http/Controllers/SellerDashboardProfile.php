<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\CommonController;

class SellerDashboardProfile extends Controller
{
    public function sellerProfile()
    {

        $sellerId = Session::get('seller');

        if (!$sellerId) {
            CommonController::checkSeller('/seller/login');
        }

        $data = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->where('sellers.id', "=",  $sellerId)
            ->select('sellers.*', 'shop_categories.name as shop_category_name', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
            ->get()
            ->first();

        // dd($data);


        $data->profile_photo = "/" . $data->profile_photo;
        $data->store_image = "/" . $data->store_image;

        $districts = DB::table('lkdistricts')
            ->select('name_en')
            ->get();

        return view('seller.dashboard_profile')->with(['sellerData' => $data, 'districtsData' => $districts]);
    }

    public function sellerProfileChange(Request $request)
    {
        $sellerId = Session::get('seller');
        $file = $request->file('profile_photo');
        $uploadedFiles = "";

        $destinationPath = 'sellers/images/' . $sellerId . '/profile';
        $file->move($destinationPath, $file->getClientOriginalName());
        $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['profile_photo' => $uploadedFiles]);

        if ($affected) {
            $request->session()->put('sellerImage', '/' . $uploadedFiles);
            return redirect()->back()->with(session()->put(['alert' => 'success', 'message' => 'Profile picture updated!']));
        }
        return redirect()->back()->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    }

    public function sellerStoreChange(Request $request)
    {
        $sellerId = Session::get('seller');
        $file = $request->file('store_image');
        $uploadedFiles = "";

        $destinationPath = 'sellers/images/' . $sellerId . '/store';
        $file->move($destinationPath, $file->getClientOriginalName());
        $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['store_image' => $uploadedFiles]);

        if ($affected) {
            return redirect()->back()->with(session()->put(['alert' => 'success', 'message' => 'Store image updated!']));
        }
        return redirect()->back()->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    }


    public function sellerHotlineChange(Request $request)
    {
        $sellerId = Session::get('seller');
        $hotline = $request->hotline;

        $hotline = "+94$hotline";

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['hotline' => $hotline]);

        if ($affected) {
            return redirect()->back()->with(session()->put(['alert' => 'success', 'message' => 'Hotline updated!']));
        }
        return redirect()->back()->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    }

    public function sellerDDChange(Request $request)
    {
        $sellerId = Session::get('seller');
        $deliveringDistricts = $request->get('delivery_districts');

        $districts = implode(", ", $deliveringDistricts);

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['delivering_districts' => $districts]);

        if ($affected) {
            return redirect()->back()->with(session()->put(['alert' => 'success', 'message' => 'Delivering districts updated!']));
        }
        return redirect()->back()->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    }
}
