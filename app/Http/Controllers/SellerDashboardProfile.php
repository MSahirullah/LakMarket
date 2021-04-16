<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class SellerDashboardProfile extends Controller
{
    public function sellerProfile()
    {

        $sellerId = Session::get('seller');

        $data = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->where('sellers.id', "=",  $sellerId)
            ->select('sellers.*', 'shop_categories.name as shop_category_name', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
            ->get();

        $data[0]->profile_photo = "/" . $data[0]->profile_photo;
        $data[0]->store_image = "/" . $data[0]->store_image;

        return view('seller.dashboard_profile')->with('sellerData', $data[0]);
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
}
