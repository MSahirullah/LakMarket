<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;

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
                    $adminName = $admin->first_name . " " . $admin->last_name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $admin->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $adminName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $admin->id . '"></span>';
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
}
