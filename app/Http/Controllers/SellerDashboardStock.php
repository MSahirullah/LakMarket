<?php

namespace App\Http\Controllers;

use App\Models\SellerStocks;
use Illuminate\Support\Facades\Session;
use DataTables;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class SellerDashboardStock extends Controller
{
    public function manageStock(Request $request)
    {
        $sellerId = Session::get('seller');

        if (!$sellerId) {
            CommonController::checkSeller('/seller/login');
        }

        $data = SellerDashboard::checkSellerInfo();
        if ($data) {
            Session::flash('status', ['1', $data]);
            return redirect()->route('seller.profile');
        }


        $tableType = $request->query->get('type');
        $data = "";


        // $data = DB::table('stocks')->where('product_id', '114')->latest('id')->first();

        // dd($data);



        $dataQ = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where([
                ['products.seller_id', "=",  $sellerId],
                ['stocks.delete_status', '=', 0],
            ]);

        $modalData = DB::table('products')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['delete_status', '=', 0],
            ])

            ->get();


        if (!json_decode($modalData, true)) {
            Session::flash('status', ['2', 'Please add products first!']);
            return redirect()->route('product.list');
        }


        if ($tableType == 'summery-stock') {
            $dataQ->select('stocks.id', DB::raw('SUM(stocks.added_stock) as added_stock'), DB::raw('SUM(stocks.stock_usage) as stock_usage'), 'stocks.outof_stock', 'stocks.created_at', 'stocks.product_id', 'stocks.product_color',  'products.name as product_name')
                ->groupBy('stocks.product_id', 'stocks.product_color');

            $data = $dataQ->get();

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
                    ->addColumn('ids', function () {

                        $value = numIncrement();
                        return $value;
                    })

                    ->addColumn('created_at', function ($stocks) {


                        $pid = $stocks->product_id;
                        $data = DB::table('stocks')->where('product_id', "=", $pid)->latest('id')->first();
                        $date = $data->created_at;
                        $Rdate =  date_format(new DateTime($date), "Y-M-d") . "<br>" . date_format(new DateTime($date), "H:i:s");
                        return $Rdate;
                    })

                    ->addColumn('available_stock', function ($stocks) {

                        $current_stock = $stocks->added_stock;
                        $used_stock = $stocks->stock_usage;
                        $available_stock = $current_stock - $used_stock;
                        return $available_stock;
                    })

                    ->addColumn('outof_stock', function ($stocks) {

                        $OOS = $stocks->outof_stock;
                        if (!$OOS) {
                            $btn = '<button class="stock-status" data-id="' . $stocks->id . '">In Stock</button>';
                        } else if ($stocks->added_stock - $stocks->stock_usage <= 0) {
                            $btn = '<button class="stock-status-oos disabled" disabled>Out of Stock</button>';
                        } else {
                            $btn = '<button class="stock-status-oos" data-id="' . $stocks->id . '">Out of Stock</button>';
                        }

                        return $btn;
                    })

                    ->rawColumns(['ids', 'outof_stock', 'created_at'])
                    ->setRowId('{{$id}}')

                    ->make(true);
            }
        } else if ($tableType == 'all-stock') {
            $dataQ->select('stocks.*', 'products.name as product_name')->orderBy('stocks.id', 'desc');

            $data = $dataQ->get();

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
                    ->addColumn('action', function ($stocks) {
                        $btn = '<span class="fas fa-trash removeBtn" data-id="' . $stocks->id . '"> </span>';
                        return $btn;
                    })
                    ->addColumn('ids', function () {

                        $value = numIncrement();
                        return $value;
                    })

                    ->addColumn('created_at', function ($stocks) {

                        $date = $stocks->created_at;
                        $Rdate =  date_format(new DateTime($date), "Y-M-d") . " &nbsp &nbsp   " . date_format(new DateTime($date), "H:i:s");
                        return $Rdate;
                    })

                    ->rawColumns(['ids', 'action', 'created_at'])
                    ->setRowId('{{$id}}')

                    ->make(true);
            }
        }



        return view('seller.dashboard_stock', ['stocks' => $data, 'stockdetails' => $modalData]);
        // return view('seller.dashboard_stock');
    }

    public function stockData(Request $request)
    {


        $sellerId = Session::get('seller');

        $productD = DB::table('products')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['name', '=', $request->pName],
            ])
            ->select('colors')
            ->get();

        if ($productD) {
            $colors = json_decode($productD, true)[0]['colors'];
            return $colors;
        }
        return 0;
    }



    public function addNewStock(Request $request)
    {
        $stock = new SellerStocks();
        $sellerId = Session::get('seller');

        $productId = DB::table('products')
            ->where([
                ['seller_id', "=",  $sellerId],
                ['name', '=', $request->product],
            ])
            ->select('id')
            ->get()->first();

        $stock->product_id = $productId->id;
        $stock->added_stock = $request->stock;
        $stock->product_color = $request->colors;
        $stock->save();

        Session::flash('status', ['0', 'Stock has been successfully added to the store!']);
        return redirect()->back();
    }

    public function deleteStock(Request $request)
    {
        $sid = $request->get('rowid');

        $status = 0;
        $affected = DB::table('stocks')->where('id', $sid)
            ->update(['delete_status' => 1]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }

    public function changeStockStatus(Request $request)
    {
        $sid = $request->get('rowid');
        $status = 0;
        $val = 0;

        $data = DB::table('stocks')->where('id', "=", $sid)->select('*')->get()->first();

        if (!$data->outof_stock) {
            $val = 1;
        }


        $affected = DB::table('stocks')->where('id', $sid)
            ->update(['outof_stock' => $val]);

        if ($affected) {
            $status = 1;
        }

        return $status;
    }
}
