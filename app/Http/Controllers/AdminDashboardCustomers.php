<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Hash;

class AdminDashboardCustomers extends Controller
{
    //
    public function index(Request $request)
    {

        $data = DB::table('customers')
            ->join('lkcities', 'lkcities.id', '=', 'customers.city_id')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'customers.district_id')
            ->select('customers.*', 'lkcities.name_en as city', 'lkdistricts.name_en as district')
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
                ->addColumn('action', function ($customer) {
                    $customerFName = $customer->first_name;
                    $customerLName = $customer->last_name;
                    $customerName = '<span>' . $customerFName . ' ' . $customerLName . '</span>';
                    $btn = '<span class="fas fa-edit editBtn" data-id="' . $customer->id . '" data-toggle="modal" data-target=".bd-AddEdit-modal-lg" target="modalAddEdit" data-button = "Update" data-title="Edit ' . $customerName . ' Details"></span></br>';

                    $btn = $btn . '<span class="fas fa-trash removeBtn1" data-id="' . $customer->id . '"></span></br>';
                    $btn = $btn . '<span class="fas fa-trash removeBtn2" data-id="' . $customer->id . '"></span>';
                    return $btn;
                })


                ->addColumn('name', function ($customer) {
                    $customerName = '<span>' . $customer->first_name . ' ' . $customer->last_name . '</span>';
                    return $customerName;
                })

                ->addColumn('ids', function () {

                    $value = numIncrement();
                    return $value;
                })

                ->addColumn('city', function ($customer) {
                    $city = $customer->city;
                    return $city;
                })

                ->addColumn('district', function ($customer) {
                    $district = $customer->district;
                    return $district;
                })

                ->addColumn('newsletters', function ($customer) {
                    $newsletter_status = $customer->newsletters;
                    if ($newsletter_status == 1) {
                        $txt = "<span>Requested</span>";
                        return $txt;
                    } else {
                        $txt = "<span>Not Requested</span>";
                        return $txt;
                    }
                })

                ->addColumn('pro_pic', function ($customer) {
                    $txt = '';

                    if ($customer->profile_pic) {
                        $img_arr1 = str_replace("[", '', $customer->profile_pic);
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

                ->addColumn('status', function ($customer) {
                    $customerblacklisted = $customer->blacklisted;
                    $customerdeleted = $customer->delete_status;
                    if ($customerblacklisted && $customerdeleted) {
                        $txt = "<span>Deleted</br>Blacklisted</span>";
                        return $txt;
                    } elseif ($customerdeleted) {
                        $txt = "<span>Deleted</span>";
                        return $txt;
                    } elseif ($customerblacklisted) {
                        $txt = "<span>Blacklisted</span>";
                        return $txt;
                    } else {
                        $txt = "<span></span>";
                        return $txt;
                    }
                })

                ->rawColumns(['ids', 'name', 'city', 'district', 'pro_pic', 'newsletters', 'status', 'action'])
                ->setRowId('{{$id}}')

                ->make(true);
        }
        return view('admin.dashboard_customers');
    }

    public function deleteCustomer(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('customers')->where('id', $row)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function blacklistCustomer(Request $request)
    {
        $row = $request->get('rowid');

        $status = 0;
        $affected = DB::table('customers')->where('id', $row)
            ->update(['blacklisted' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
