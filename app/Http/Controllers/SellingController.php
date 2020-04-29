<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockDistribution;
use App\Order;
use Auth;
use Date;
use DataTables;
use DB;
use Validator;
use App\Selling;


class SellingController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        $data = [];
        $data['sell'] = StockDistribution::where('status', 'shipment')->orWhere('status', 'accepted')->get();
        return view('pages.selling.create', $data);
    }
    public function stockDataSelling()
    {
        // $sell = StockDistribution::where('status', 'shipment')->orWhere('status', 'accepted')->orderBy('stocks.name', 'ASC')->with(['stock'])->get();

        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sell = DB::table('stock_distributions')
            ->join('stocks', 'stock_distributions.stock_id', '=', 'stocks.id')
            ->select('stocks.id', 
                    'stocks.code', 
                    'stock_distributions.cabang_id',
                    'stocks.name', 
                    'stock_distributions.price_sell', 
                    'stock_distributions.price_grosir', 
                    // 'stock_distributions.id', 
                    'stock_distributions.stock_id')
            ->where('cabang_id', $employee->cabang_id)
            ->where('stock_distributions.status', 'shipment')
            ->orWhere('stock_distributions.status', 'accepted')
            ->groupBy('stocks.code', 
                    'stock_distributions.cabang_id',
                    'stocks.name', 
                    'stock_distributions.price_sell', 
                    'stock_distributions.price_grosir', 
                    'stock_distributions.stock_id')
            ->get();
        return response()->json(['data' => $sell]);
    }

    public function codeOr()
    {
        $max_query = DB::table('orders')->max('code');
        // $kodeB = Inventaris::all();
        $date = date("ymdh");

        if ($max_query != null) {
            $nilai = substr($max_query, 11, 11);
            $kode = (int) $nilai;
            // tambah 1
            $kode = $kode + 1;
            $auto_kode = "ZSL". $date . str_pad($kode, 4, "0",  STR_PAD_LEFT);
        } else {
            $auto_kode = "ZSL". $date . "0001";
        }

        return $auto_kode;
    }

    public function store(Request $request)
    {
        $customMessages = [
            'cash.required' => 'Masukan Uang Bayar.',
            'cash.numeric' => 'Bayar Hanya Diisi Angka.',
        ];
        $validator = Validator::make($request->all(),[
            'cash' => 'required|numeric',
            'total' => 'required',
            'sd' => 'required',
            'code' => 'required',
            'qty' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $res_total = $request->total - $request->potong;
        // dd($res_total);
        $ord = Order::create([
            'date' => Date::now()->format('Y/m/d H:i:s'),
            'code' => $this->codeOr(),
            'total_price' => "$request->total|$request->potong",
            'pay' => $request->cash,
            'cabang_id' => $employee->cabang_id,
        ]);
        $ssst = '';
        $qty_container = 0;
        if (count($request->code) > 0) {
            foreach ($request->code as $key => $value) {
                $ssst = Stock::where('code', $request->code[$key])->first();

                $sd = StockDistribution::where('stock_id', $ssst->id)
                                        ->where('cabang_id', $employee->cabang_id)
                                        ->where('status', '!=', 'rejected') 
                                        ->where('status', '!=', 'submission')
                                        ->orderBy('quantity', 'ASC')
                                        ->get();
                foreach ($sd as $q) {
                    if ($qty_container == 0) {
                        if ($q['quantity'] >= $request->qty[$key]) {
                            $sd_qty_res = $q['quantity'] - $request->qty[$key];

                            // dd($sd_qty_res);

                            StockDistribution::find($q['id'])->update(['quantity' => $sd_qty_res]);
                            break;
                        }else{
                            $qty_container += $request->qty[$key] - $q['quantity'];              

                            // dd($qty_container);

                            StockDistribution::find($q['id'])->update(['quantity' => 0]);
                        }
                    }else{
                        if ($q['quantity'] >= $qty_container) {
                            // dd($q['quantity']);
                            $sd_qty_res = $q['quantity'] - $qty_container;

                            // dd($sd_qty_res);

                            StockDistribution::find($q['id'])->update(['quantity' => $sd_qty_res]);
                            break;
                        }else{
                            // dd(false);
                            $qty_container += - $q['quantity'];              

                            // dd($qty_container);

                            StockDistribution::find($q['id'])->update(['quantity' => 0]);
                        }
                    }
                }

                $data = [
                    'stock_id' => $ssst->id,
                    'order_id' => $ord->id,
                    'user_id' => $employee->cabang_id,
                    'type' => 'satuan',
                    'quantity' =>  $request->qty[$key],
                    'sub_total' => $request->sub_tot[$key],
                ];
                Selling::create($data);
            }
        }

        // $tot_price = DB::table('sellings')
        //             ->select( DB::raw("SUM(sub_total) as total"))
        //             ->where('order_id', $ord->id)
        //             ->first();
        $kembalian =  $request->cash - $res_total;
        return response()->json(['msg' => "Kembalian $kembalian"], 200);

    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }

    public function checkQty()
    {
        
    }

    public function findSdByCode(Request $request)
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $stock = Stock::where('code', $request->code)->first();
        if (!$stock) {
            return response()->json(["msg" => "Barang Tidak Ditemukan"], 401);
        }
        $sd = StockDistribution::where('stock_id', $stock->id)->where('cabang_id', $employee->cabang_id)->where('status', 'shipment')->orWhere('status', 'accepted')->first();
        if (!$sd) {
            return response()->json(["msg" => "Barang Tidak Ditemukan"], 401);
        }
        return response()->json([
            "name" => $stock->name,
            "price" => $sd->price_sell,
            "stock" => $stock->id,
            "sd" => $sd->id
        ]);
    }
}
