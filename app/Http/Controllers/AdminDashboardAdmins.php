<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Hash;

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

            $name = $admin->full_name;
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
                    $adminName = $admin->full_name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $admin->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $adminName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn1" data-id="' . $admin->id . '"></span></br>';
                    $btn = $btn . '<span class="fas fa-trash removeBtn2" data-id="' . $admin->id . '"></span>';
                    return $btn;
                })


                ->addColumn('name', function ($admin) {
                    $adminName = $admin->full_name;
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

                ->addColumn('status', function ($admin) {
                    $adminblacklisted = $admin->blacklisted;
                    $admindeleted = $admin->delete_status;
                    if ($adminblacklisted && $admindeleted) {
                        $txt = "<span>Deleted</br>Blacklisted</span>";
                        return $txt;
                    } elseif ($admindeleted) {
                        $txt = "<span>Deleted</span>";
                        return $txt;
                    } elseif ($adminblacklisted) {
                        $txt = "<span>Blacklisted</span>";
                        return $txt;
                    } else {
                        $txt = "<span></span>";
                        return $txt;
                    }
                })

                ->rawColumns(['ids', 'name', 'image', 'status', 'action'])
                ->setRowId('{{$id}}')

                ->make(true);
        }
        return view('admin.dashboard_admins');
    }

    public function adminDetails(Request $request)
    {
        $aid = $request->get('rowid');

        $data = DB::table('administrators')
            ->where('administrators.id', $aid)
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
                /* ['delete_status', '=', 0], */
            ])
            ->select('*')
            ->get()->first();

        if (!$AdminDetails) {

            $admin->full_name = $request->full_name;
            $admin->email = $request->email;
            $admin->phone_number = $request->phone_number;
            $admin->address = $request->address;
            $admin->password = Hash::make($request->password);
            $admin->date_of_birth = $request->dob;
            $admin->role = "ASSIST_ADMIN";
            $admin->is_verified = 1;
            $admin->blacklisted = 0;
            $admin->delete_status = 0;
            $admin->save();

            Session::flash('status', ['0', 'Admin has been successfully added!']);
        } else {
            Session::flash('status', ['1', 'Something went wrong. Please try again later!']);
            if ($AdminDetails->blacklisted) {
                Session::flash('status', ['1', 'This Admin has been blacklisted!']);
            } else if ($AdminDetails->delete_status) {
                Session::flash('status', ['2', 'This Admin no longer in our system!']);
            } else if ($AdminDetails->email == $request->email) {
                Session::flash('status', ['2', 'This Admin already exists!']);
            }
        }
        return redirect()->back();
    }

    public function deleteAdmin(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('administrators')->where('id', $row)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function blacklistAdmin(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('administrators')->where('id', $row)
            ->update(['blacklisted' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function updateAdminDetails(Request $request)
    {

        $aid = $request->get('aid');
        $status = 0;

        $updateDetails = [
            'full_name' => $request->get('full_name'),
            'phone_number' => $request->get('phone_number'),
            'date_of_birth' => $request->get('dob'),
            'address' => $request->get('address'),
            'LinkedIn' => $request->get('linkedin'),
        ];

        $files = $request->file('images');
        $uploadedFiles = [];

        $affected = DB::table('administrators')
            ->where('id', $aid)
            ->update($updateDetails);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
    public function changePassword(Request $request)
    {

        $admin = new administrator();
        $adminId = Session::get('admin');

        $AdminDetails = DB::table('administrators')
            ->where([
                ['email', "=",  $request->email],
                ['delete_status', '=', 0],
                ['blacklisted', '=', 0]
            ])
            ->select('*')
            ->get()->first();

        if (!$AdminDetails) {
            Session::flash('status', ['1', 'Something went wrong. Please try again later!']);
            if ($AdminDetails->blacklisted) {
                Session::flash('status', ['1', 'This Admin has been blacklisted!']);
            } else if ($AdminDetails->delete_status) {
                Session::flash('status', ['2', 'This Admin no longer in our system!']);
            } else if ($AdminDetails->email != $request->email) {
                Session::flash('status', ['2', 'Admin does not exists!']);
            }
        } else {
            $AdminDetails = DB::table('administrators')
                ->where('email', '=', $request->email)
                ->update(['password' => $request->password]);

            Session::flash('status', ['0', 'password sucessfully changed!']);
        }
        return redirect()->back();
    }
}
