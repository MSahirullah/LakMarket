<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CommonController;

class AdminDashboardProfile extends Controller
{
    public function AdminProfile()
    {

        $adminId = Session::get('admin');

        if (!$adminId) {
            // CommonController::checkAdmin('/admin/login');
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
        $validate = $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validate) {

            $file = $request->file('profile_photo');
            $uploadedFiles = "";
            $destinationPath = 'admin/images/' . $adminId . '/profile';
            $file->move($destinationPath, $file->getClientOriginalName());
            $uploadedFiles = $destinationPath . '/' . $file->getClientOriginalName();

            $affected = DB::table('administrators')->where('id', $adminId)
                ->update(['profile_photo' => $uploadedFiles]);

            if ($affected) {
                $request->session()->put('adminImage', '/' . $uploadedFiles);

                Session::flash('status', ['0', "Profile picture updated!"]);
                return redirect()->back();
            } else {
                Session::flash('status', ['1', "Please do not insert the same image!"]);
                return redirect()->back();
            }
        } else {
            Session::flash('status', ['1', "something went wrong please try again!"]);
            return redirect()->back();
        }

        dd($validate);
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

    /* <<<<<<< HEAD
    

=======
>>>>>>> 4190b601d9ab0cf1792bf70970257364617f83f1 */
    public function adminLLChange(Request $request)
    {
        $adminId = Session::get('admin');
        $linkedin = $request->get('linkedin');

        $affected = DB::table('administrators')->where('id', $adminId)
            ->update(['LinkedIn' => $linkedin]);

        if ($affected) {
            Session::flash('status', ['0', "LinkedIn Link updated!"]);
            return redirect()->back();
        }
        Session::flash('status', ['1', "Something went wrong. Please try again later!"]);
        return redirect()->back();
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
    public function adminDetails(Request $request)
    {
        $aid = $request->get('rowid');

        $data = DB::table('administrators')
            ->where('id', $aid)
            ->select('*')
            ->get();

        return $data;
    }
}
