<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkoutNotify(Request $request)
    {
        return view('coming_soon', [
            'status' => '-',
            'msg' => '-'
        ]);
    }
    public function checkoutSuccess(Request $request)
    {
        // dd($request);
        $orderID = $request->order_id;
        $customer = Session::get('customer');

        $total_amount = DB::table('order_details')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->where([
                ['orders.customer_id', '=', $customer->id],
                ['orders.status', '=', '0'],
                ['order_details.order_id', '=', $orderID],
            ])
            ->sum('price');

        $newPayment = new Payment();

        $newPayment->amount = $total_amount;
        $newPayment->currency = 'LKR';
        $newPayment->payable_type = 'order';
        $newPayment->payable_id = $orderID;
        $newPayment->payer_type = 'customer';
        $newPayment->payer_id = $customer->id;
        $newPayment->save();

        $affected = DB::table('orders')
            ->where('id', $orderID)
            ->update(['payment_status' => 1]);

        return view('coming_soon', [
            'status' => '0',
            'msg' => 'Payment successfull. Your order has been received.'
        ]);
    }
    public function checkoutCancelled(Request $request)
    {
        return view('coming_soon', [
            'status' => '-',
            'msg' => '-'
        ]);
    }
}
