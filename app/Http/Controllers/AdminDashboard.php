<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Session;

class AdminDashboard extends Controller
{
    function index(Request $request)
    {
        $adminId = Session::get('admin');

        if (!$adminId) {
            CommonController::checkAdmin('/admin/login');
        }

        $data = DB::table('administrators')
            ->where('id', "=",  $adminId)
            ->select('first_name','last_name', 'profile_photo')
            ->get();

        $data[0]->profile_photo = "/" . $data[0]->profile_photo;

        $request->session()->put('adminName', $data[0]->first_name.' '.$data[0]->last_name);
        $request->session()->put('adminImage', $data[0]->profile_photo);

        return (view('admin.dashboard_home'));
    }

    public function clearSession(Request $request)
    {
        $request->session()->forget('alert');
        $request->session()->forget('message');
        $request->session()->forget('invalidEmail');
    }

    public function changeSideBarStatus(Request $request)
    {
        $status = $request->get('status');
        Cookie::queue(Cookie::make('valSideBar', $status));
    }
}
