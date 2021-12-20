<?php

namespace App\Http\Controllers;

use App\Models\Customer_Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function addAddress(Request $request)
    {
        $customer = Session::get('customer');

        $province = DB::table('lkdistricts')
            ->where('id', $request->district)
            ->select('province_id')
            ->get();

        if (sizeof($province)) {

            $addressLabel = DB::table('customer_addresses')
                ->where([
                    ['label', '=', $request->label],
                ])
                ->select('*')
                ->get();

            if (sizeof($addressLabel)) {
                return [1, 'This label is already exists. Please enter another label.'];
            }

            $address = DB::table('customer_addresses')
                ->where([
                    ['customer_id', '=', $customer->id],
                    ['full_name', '=', $request->full_name],
                    ['address', '=', $request->address],
                    ['district_id', '=', $request->address],
                    ['city_id', '=', $request->address],
                    ['label', '=', $request->label],
                ])
                ->select('*')
                ->get();

            if (!sizeof($address)) {
                $province = $province[0]->province_id;

                $newAddress = new Customer_Address();

                $newAddress->customer_id = $customer->id;
                $newAddress->full_name = $request->full_name;
                $newAddress->mobile_no = $request->phone;
                $newAddress->address = $request->address;
                $newAddress->label = $request->label;
                $newAddress->province_id = $province;
                $newAddress->district_id = $request->district;
                $newAddress->city_id = $request->city;

                $newAddress->save();
                return [0, 'Shipping address successfully added to your account.'];
            } else {
                return [3, 'This shipping address is already exists.'];
            }
        }
        return [1, 'Sorry, something went wrong. Please try again, or refresh the page.'];
    }

    public function editAddress(Request $request)
    {
        $customer = Session::get('customer');


        $address = DB::table('customer_addresses')
            ->where([
                ['id', '=', $request->id],
                ['customer_id', '=', $customer->id],
            ])
            ->select('*')
            ->get();

        if (sizeof($address)) {
            $address = $address[0];
            if (
                $request->full_name == $address->full_name &&
                $request->phone == $address->mobile_no &&
                $request->address == $address->address &&
                $request->district == $address->district_id &&
                $request->city == $address->city_id &&
                $request->label == $address->label
            ) {
                return [2, 'Please make any changes.'];
            } else {

                $province = DB::table('lkdistricts')
                    ->where('id', $request->district)
                    ->select('province_id')
                    ->get();

                if (sizeof($province)) {
                    Customer_Address::where('id', $request->id)
                        ->update(
                            [
                                'full_name' => $request->full_name,
                                'mobile_no' => $request->phone,
                                'address' => $request->address,
                                'district_id' => $request->district,
                                'city_id' => $request->city,
                                'province_id' => $province[0]->province_id,
                                'label' => $request->label,
                            ]
                        );
                    return [0, 'Shipping address successfully updated.'];
                }
            }
        }

        return [1, 'Sorry, something went wrong. Please try again, or refresh the page.'];
    }

    public function removeAddress(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $affected = DB::table('customer_addresses')
                ->where([
                    ['id', '=', $request->id],
                ])->delete();

            if ($affected) {
                return [0, 'Shipping address successfully deleted.'];
            }
        }
        return [1, 'Sorry, something went wrong. Please try again, or refresh the page.'];
    }
}
