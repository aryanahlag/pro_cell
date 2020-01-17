<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockDistribution;
use Auth;
use Date;
use DataTables;


class SellingController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        return view('pages.selling.create');
    }
    public function store(Request $request)
    {
        dd($request);
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
        $stock = Stock::where('code', $request->code)->first();
        if (!$stock) {
            return response()->json(["msg" => "Barang Tidak Ditemukan"], 401);
        }
        $sd = StockDistribution::where('stock_id', 5)->where('status', 'shipment')->orWhere('status', 'accepted')->first();
        if (!$sd) {
            return response()->json(["msg" => "Barang Tidak Ditemukan"], 401);
        }

        // dd($sd);

        return response()->json([
            "name" => $stock->name,
            "price" => $sd->price_sell,
            "stock" => $stock->id,
            "sd" => $sd->id
        ]);
    }
}
