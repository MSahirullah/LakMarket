<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\CommonController;

class AdminDashboardProfile extends Controller
{
    public function AdminProfile()
    {

        $adminId = Session::get('admin');

        if (!$adminId) {
            CommonController::checkAdmin('/admin/login');
        }

        $data = DB::table('administrators')
            ->where('administrators.id', "=",  $adminId)
            ->select('administrators.*')
            ->get()
            ->first();

        // dd($data);


        $data->profile_photo = "/" . $data->profile_photo;
        
        return view('admin.dashboard_profile')->with(['AdminData' => $data]);
    }

    public function adminProfileChange(Request $request)
    {
        $adminId = Session::get('admin');
        $file = $request->file('profile_photo');
        $uploadedFiles = "";

        $destinationPath = 'admin/images/' . $adminId . '/profile';
        $file->move($destinationPath, $file->getClientOriginalName());
        $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

        $affected = DB::table('administrators')->where('id', $adminId)
            ->update(['profile_photo' => $uploadedFiles]);

        if ($affected) {
            $request->session()->put('adminImage', '/' . $uploadedFiles);
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