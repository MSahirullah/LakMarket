<?php

namespace App\Http\Controllers;

use App\Models\Lkcities;
use App\Models\Lkdistricts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
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
}
