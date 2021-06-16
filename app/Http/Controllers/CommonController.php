<?php

namespace App\Http\Controllers;

use App\Models\Lkcities;
use App\Models\Lkdistricts;
use App\Models\Lkprovinces;
use App\Models\SellerProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CommonController extends Controller
{

    public function getProvinces()
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

    public function getDistricts()
    {
        $districts = Lkdistricts::all('id', 'name_en');
        return $districts;
    }

    public function getCities(Request $req)
    {
        $district_id = $req->get('dis_id');
        $cities = DB::table('lkcities')
            ->select('name_en')
            ->where('district_id', $district_id)
            ->get();

        return $cities;
    }

    public static function checkSeller($url)
    {
        abort(404, $url);
    }

    public function searchAutocomplete(Request $request)
    {
        $data = SellerProducts::select("name")
                ->where("name","LIKE","%{$request->query}%")
                ->get();
   
        return response()->json($data);
    }
}
