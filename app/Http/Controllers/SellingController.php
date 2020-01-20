<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockDistribution;
use Auth;
use Date;
use DataTables;
use DB;
use Validator;


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

        // return response()->json('okok');
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        // dd($request);
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
