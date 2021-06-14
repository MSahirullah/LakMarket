<?php

namespace App\Http\Controllers;

use App\Models\administrator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Session;

class AdminDashboardAdmins extends Controller
{
    //
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
                    $adminName = $admin->first_name ." ". $admin->last_name;
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $admin->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $adminName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn" data-id="' . $admin->id . '"></span>';
                    return $btn;
                })


                ->addColumn('name', function ($admin) {
                    $adminName = $admin->first_name ." ". $admin->last_name;
                    $txt = "<span>" . $adminName . "</span> <br> <span><i>".$admin->role."</i></span>";
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