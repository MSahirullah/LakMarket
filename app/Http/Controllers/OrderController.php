<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function index($valueCustomer)
    {
        // return view('ac_orders', [
        //     'type' => 'orders'
        // ]);
        return view('coming_soon', [
            'status' => '-',
            'msg' => '-'
        ]);
    }

    public function addToOrder(Request $request)
    {
        $proURL = $request->proURL;
        $customer = Session::get('customer');

        if (sizeof($proURL)) {
            $products = DB::table('cart')
                ->join('products', 'products.id', '=', 'cart.product_id')
                ->where([
                    ['customer_id', '=', $customer->id],
                    ['status', '=', '0'],
                ])
                ->whereIn('products.url', $proURL)
                ->select('cart.*')
                ->get();

            if (sizeof($products)) {
                $newOrder = new Order();

                $newOrder->customer_id = $customer->id;
                $newOrder->full_name = $request->full_name;
                $newOrder->district_id = $request->district;
                $newOrder->city_id = $request->city;
                $newOrder->shipping_address = $request->address;
                $newOrder->shipping_phone = $request->phone;
                $newOrder->shipping_email = $customer->email;

                $newOrder->save();

                foreach ($products as $product) {
                    $newOrderDetail = new OrderDetails();

                    $newOrderDetail->order_id = $newOrder->id;
                    $newOrderDetail->product_id = $product->product_id;
                    $newOrderDetail->quantity = $product->quantity;
                    $newOrderDetail->price = $product->price;

                    if ($product->color) {
                        $newOrderDetail->color = $product->color;
                    }

                    $newOrderDetail->save();

                    $affected = DB::table('cart')
                        ->where([
                            ['id', '=', $product->id],
                            ['status', '=', '0'],
                        ])->update(['status' => 1]);
                }
                return [0, $newOrder->id, $newOrder->shipping_email];
            }
        }
        return [1, 'Sorry, something went wrong. Please try again, or refresh the page.'];
    }
}
