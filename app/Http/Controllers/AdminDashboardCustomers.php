<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminDashboardCustomers extends Controller
{
    //
    public function adminCustomers()
    {
        $customers = Customer :: all();
        return view('admin.dashboard_customers')->with('customers',$customers);
    }
}
