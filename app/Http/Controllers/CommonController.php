<?php

namespace App\Http\Controllers;

use App\Models\Lkcities;
use App\Models\Lkdistricts;
use App\Models\Lkprovinces;
use App\Models\SellerProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Session;

class CommonController extends Controller
{

    public static function getProvinces()
    {
        $provinces = DB::table('lkprovinces')
            ->select('name_en', 'id')
            ->orderBy('name_en')
            ->get();

        return $provinces;
    }

    public function getDistrictsbyID(Request $req)
    {
        $province_id = $req->get('pro_id');
        $districts = DB::table('lkdistricts')
            ->select('name_en', 'id')
            ->where('province_id', $province_id)
            ->orderBy('name_en')
            ->get();

        return $districts;
    }

    public static function getDistricts()
    {
        $districts = Lkdistricts::all('id', 'name_en');
        return $districts;
    }

    public function getCities(Request $req)
    {
        $district_id = $req->get('dis_id');
        $cities = DB::table('lkcities')
            ->select('id', 'name_en', 'postal_code')
            ->where('district_id', $district_id)
            ->get();

        return $cities;
    }

    // public function searchAutocomplete(Request $request)
    // {
    //     $data = SellerProducts::select("name")
    //         ->where("name", "LIKE", "%{$request->query}%")
    //         ->get();

    //     return response()->json($data);
    // }

    // public function getCategories()
    // {
    //     $data = DB::table('shop_categories')
    //         ->select('name', 'id', 'url')
    //         ->get();



    //     $data = json_decode($data, true);
    //     return $data;
    // }

    public function changeCustomerLocation(Request $request)
    {

        $data = $request->data;
        $value = [];

        $data = str_replace(array(
            '[', ']', '\'', '"'
        ), '', $data);

        $data = explode(',', $data);

        if ($data[0] == 'allP') {

            $value['0'] = 'All of Sri Lanka';
            $value['1'] = '0';
            $value['2'] = array('0', '0', '0');

            //
        } else if ($data[1] == 'allD') {

            $value['0'] = $data[0] . ' ' . 'Province';
            $value['1'] = '1';
            $value['2'] = array($data[0], '0', '0');
            //
        } else if ($data[2] == 'allC') {

            $value['0'] = $data[1] . ' ' . 'District';
            $value['1'] = '2';
            $value['2'] = array($data[0], $data[1], '0');
            //
        } else {
            $value['0'] = $data[2];
            $value['1'] = '3';
            $value['2'] = array($data[0], $data[1],  $data[2]);
        }

        $request->session()->put('customer-city', $value);

        return 1;
    }

    public function locationReset(Request $request)
    {
        $customer = FacadesSession::get('customer');

        $city = DB::table('lkcities')
            ->join('lkdistricts', 'lkdistricts.id', '=', 'lkcities.district_id')
            ->join('lkprovinces', 'lkprovinces.id', '=', 'lkdistricts.province_id')
            ->where('lkcities.id', $customer->city_id)
            ->select('lkcities.name_en as city', 'lkdistricts.name_en as district', 'lkprovinces.name_en as province')

            ->get();
        $location = json_decode($city, true)[0];

        $value = [];
        $value['0'] = $city[0]->city;
        $value['1'] = '3';
        $value['2'] = array($location['province'], $location['district'],  $location['city']);
        $request->session()->put('customer-city', $value);

        return 1;
    }

    public static function comingSoon($status, $msg)
    {
        return view('coming_soon', [
            'status' => $status,
            'msg' => $msg,
        ]);
    }
}
