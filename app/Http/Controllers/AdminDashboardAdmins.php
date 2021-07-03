<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;

class AdminDashboardAdmins extends Controller
{
    //

    public function resendVerification(Request $request)
    {
        $admin = administrator::where(['id' => $request['admin_id']])->first();

        $verification_code = bin2hex(random_bytes(32));

        if ($admin->is_verified == 0) {

            $admin = administrator::where('id', $request['admin_id'])
                ->update(['verification_code' => $verification_code]);

            $name = $admin->first_name . ' ' . $admin->last_name;
            MailController::sendAdminVerificationMail($name, $admin->email, $verification_code);

            Session::flash('status', ['0', 'Please check email for verification link.', $admin->id]);
            return view('auth.verify');
        }
        Session::flash('status', ['1', 'Something went wrong. Please try again later.']);
        return redirect()->route('admin.login');
    }

    public function index(Request $request)
    {

        $data = DB::table('administrators')
            ->select('*')
            ->where([
                ['delete_status', "=", 0],
            ])
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
                ->addColumn('action', function ($admin) {
                    $adminName = $admin->email . " " . $admin->last_name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $admin->email . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $adminName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $admin->email . '"></span>';
                    return $btn;
                })


                ->addColumn('name', function ($admin) {
                    $adminName = $admin->first_name . " " . $admin->last_name;
                    $txt = "<span>" . $adminName . "</span> <br> <span><i>" . $admin->role . "</i></span>";
                    return $txt;
                })

                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })

                ->addColumn('image', function ($admin) {
                    $txt = '';

                    if ($admin->profile_photo) {
                        $img_arr1 = str_replace("[", '', $admin->profile_photo);
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

                ->rawColumns(['ids', 'name', 'image', 'action'])
                ->setRowId('{{$id}}')

                ->make(true);
        }
        return view('admin.dashboard_admins');
    }

    public function adminDetails(Request $request)
    {
        $pid = $request->get('rowid');

        $data = DB::table('administrators')
            ->where('administrators.id', $pid)
            ->select('*')
            ->get();

        return $data;
    }

    public function addNewAdmin(Request $request)
    {
        $admin = new administrator();
        $adminId = Session::get('admin');

        $AdminDetails = DB::table('administrators')
            ->where([
                ['email', "=",  $request->email],
                ['delete_status', '=', 0],
            ])
            ->select('*')
            ->get()->first();

        if (!$AdminDetails) {

            /* $cato_id = DB::table('seller_product_category')
                ->join('product_categories', 'product_categories.id', '=', 'seller_product_category.product_category_id')
                ->where([
                    ['seller_product_category.seller_id', "=",  $sellerId],
                    ['product_categories.name', "=",  $request->product_category]
                ])
                ->select('product_categories.id')
                ->get(); */

            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->email = $request->email;
            $admin->phone_number = $request->phone_number;
            $admin->date_of_birth = $request->date_of_birth;
            $admin->address = $request->address;
            $admin->password = $request->password;
            $admin->role = $request->role;
            $admin->blacklisted = 0;
            $admin->delete_status = 0;
            $admin->save();

            /* $productUrl = $this->slug($request->name . '-' . json_decode($product, true)['id']);
            $product->url = $productUrl;

            $files = $request->file('images');
            $uploadedFiles = [];

            $k = 0;
            foreach ($files as $file) {
                if ($k < 3) {
                    $destinationPath = 'products/images/' . $productUrl;
                    $file->move($destinationPath, $file->getClientOriginalName());
                    $uploadedFiles[] = $destinationPath . '/' . $file->getClientOriginalName();
                    $k++;
                }
            }

            $product->images = $uploadedFiles;
            $product->save(); */

            Session::flash('status', ['0', 'Admin has been successfully added!']);
        } else {
            Session::flash('status', ['1', 'Something went wrong. Please try again later!']);
            /* if ($AdminDetails->blacklisted) {
                Session::flash('status', ['1', 'This product has been blacklisted!']);
            } else if ($AdminDetails->email == $request->email) {
                Session::flash('status', ['2', 'This Admin already exists!']);
            } */
        }
        return redirect()->back();
    }

    public function deleteAdmin(Request $request)
    {
        $pid = $request->get('rowid');

        $status = 0;
        $affected = DB::table('administrators')->where('id', $pid)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    
}
