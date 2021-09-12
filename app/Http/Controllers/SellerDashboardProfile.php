<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as Session;

// use App\Http\Controllers\CommonController;

class SellerDashboardProfile extends Controller
{

    public function sellerProfile()
    {

        $sellerId = Session::get('seller');

        if (!$sellerId) {
            CommonController::checkSeller('/seller/login');
        }

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
        }



        $data = DB::table('sellers')
            ->join('shop_categories', 'shop_categories.id', '=', 'sellers.shop_category_id')
            ->join('lkcities', 'lkcities.id', '=', 'sellers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'sellers.district_id')
            ->where('sellers.id', "=",  $sellerId)
            ->select('sellers.*', 'shop_categories.name as shop_category_name', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
            ->get()
            ->first();

        $data->store_logo = "/" . $data->store_logo;

        $districts = DB::table('lkdistricts')
            ->select('name_en')
            ->get();

        return view('seller.dashboard_profile')->with(['sellerData' => $data, 'districtsData' => $districts]);
    }

    // public function sellerProfileChange(Request $request)
    // {

    //     $sellerId = Session::get('seller');
    //     $file = $request->file('profile_photo');
    //     $uploadedFiles = "";

    //     $destinationPath = 'sellers/images/' . $sellerId . '/profile';
    //     $file->move($destinationPath, $file->getClientOriginalName());
    //     $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

    //     $affected = DB::table('sellers')->where('id', $sellerId)
    //         ->update(['profile_photo' => $uploadedFiles]);

    //     if ($affected) {
    //         $request->session()->put('sellerImage', '/' . $uploadedFiles);
    //         return redirect()->back()->with(session()->put(['alert' => 'success', 'message' => 'Profile picture updated!']));
    //     }
    //     return redirect()->back()->with(session()->put(['alert' => 'error', 'message' => 'Something went wrong. Please try again later!']));
    // }

    public function sellerStoreChange(Request $request)
    {
        $sellerId = Session::get('seller');
        $file = $request->file('store_image');
        $uploadedFiles = "";


        $destinationPath = 'sellers/images/' . $sellerId . '/store';
        $file->move($destinationPath, $file->getClientOriginalName());
        $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['store_logo' => $uploadedFiles]);




        $data = DB::table('sellers')
            ->where('sellers.id', "=",  $sellerId)
            ->select('sellers.*')
            ->get();

        if ($affected) {
            $data[0]->store_logo = "/" . $data[0]->store_logo;
            $request->session()->put('sellerImage', $data[0]->store_logo);
            Session::flash('status', ['0', 'Store Background Image Updated!']);
            return redirect()->route('seller.profile');
        }
        Session::flash('status', ['2', 'please select another image!']);
        return redirect()->route('seller.profile');
    }


    public function sellerHotlineChange(Request $request)
    {

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->back();
        }

        $sellerId = Session::get('seller');
        $hotline = $request->hotline;

        $hotline = "+94$hotline";

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['hotline' => $hotline]);

        if ($affected) {
            Session::flash('status', ['0', 'Hotline Updated!']);
            return redirect()->back();
        }
        Session::flash('status', ['1', 'Something went wrong. Please try again later.']);
        return redirect()->back();
    }

    public function sellerBdayChange(Request $request)
    {
        $sellerId = Session::get('seller');

        $bday = $request->bday;

        $affected = DB::table('sellers')->where('id', $sellerId)
            ->update(['birthday' => $bday]);

        if ($affected) {
            Session::flash('status', ['0', 'Birthday Updated!']);
            return redirect()->back();
        }
        Session::flash('status', ['1', 'Something went wrong. Please try again later.']);
        return redirect()->back();
    }

    public function sellerDDChange(Request $request)
    {

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->back();
        }

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

    public function sellerPasswordChange(Request $request)
    {
        $sellerId = Session::get('seller');

        $currentPass = $request->cP;
        $newPass = Hash::make($request->nP);

        $data = DB::table('sellers')
            ->where('sellers.id', "=",  $sellerId)
            ->select('sellers.*')
            ->get();

        if (Hash::check($currentPass, $data[0]->password)) {
            $affected = DB::table('sellers')->where('id', $sellerId)
                ->update(['password' => $newPass, 'status' => '1']);
            if ($affected) {
                $request->session()->put('sellerStatus', $data[0]->status);
                return [0, "Your password has been changed successfully."];
            }
            return [1, "Something went wrong. Please try again later."];
        }
        return [1, "Please enter the correct current password."];
    }
}
