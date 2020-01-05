<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDistribution;
use App\Stock;
use DataTables;
use Auth;
use Date;
use Validator;
use DB;

class StockDistributionController extends Controller
{
    public function index()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $data = [];
        $data['slug'] = $employee->cabang->slug;
        return view('pages.stock-distribution.index', $data);
    }

    public function create()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $data = [];
        $data['slug'] = $employee->cabang->slug;
        return view('pages.stock-distribution.multi-create', $data); 
    }

    public function createSingle()
    {
        return view('pages.stock-distribution.create');
    }

    public function store(Request $request)
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        if (count($request->stock) > 0) {
            foreach ($request->stock as $key => $value) {
                $data = [
                    'stock_id' => $request->stock[$key],
                    'cabang_id' => $employee->cabang_id,
                    'quantity' => $request->quantity[$key],
                    'price_sell' => $request->price_sell[$key],
                    'price_grosir' => $request->price_grosir[$key],
                    'status' => 'submission',
                ];
                Stock::insert($data);
            }
        }
        return redirect()->route('admin.generation.show', $id);    
    }

    public function storeSingle(Request $request)
    {
        $customMessages = [
            'stock_id.required' => 'Stock Harus Di isi.',
            'stock_id.exists' => 'Stock Tidak Ada.',
            'price_sell.required' => 'Harga Jual Harus Di isi.',
            'price_sell.integer' => 'Harga Jual Harus Angka.',
            'price_grosir.required' => 'Harga Grosir Harus Di isi.',
            'price_grosir.integer' => 'Harga Grosir Harus Angka.',
            'quantity.required' => 'Harga Beli Harus Di isi.',
            'quantity.integer' => 'Qyt Harus Angka.',
            'quantity.min' => 'Qyt Minimal 1.',
        ];
        $validator = Validator::make($request->all(),[
            "stock_id" => "required",
            "price_sell" => "required|integer",
            "price_grosir" => "required|integer",
            "quantity" => "required|integer|min:1",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::where('id', $request->stock_id)->first();
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        // dd(!$stock);
        if (!$stock) {
            return response()->json(['msg' => 'Stock Tidak Ditemukan'], 401);
        }

        if ($stock->quantity < $request->quantity) {
            return response()->json(['msg' => "Qyt Tidak Valid" ], 401);
        }

        if ($stock->price_purchase > $request->price_sell) {
            return response()->json(['msg' => "Harga Jual Terlalu Kecil" ], 401);
        }

        if ($stock->price_purchase > $request->price_grosir) {
            return response()->json(['msg' => "Harga Grosir Terlalu Kecil" ], 401);
        }

        $sd = StockDistribution::create([
            'stock_id' => $request->stock_id,
            'cabang_id' => $employee->cabang_id,
            'quantity' => $request->quantity,
            'price_sell' => $request->price_sell,
            'price_grosir' => $request->price_grosir,
            'status' => 'submission',
            'information' => $request->information
        ]);

        return response()->json(['msg' => 'Pengajuan Stock Berhasil'], 200);
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

    public function datatables()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->where('cabang_id', $employee->cabang_id)->with(['stock'])->where('status', 'accepted');

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function findStock()
    {
        // $generation = \App\Generation::where("status", "verify")->get();
        // $st_gen = \App\Generation::where("status", "verify")->with(['stock'])
        // $stock = Stock::where("name", 'LIKE', '%' .   request('q') . '%')->with(['brand', 'category', 'generation'])->get();
        $stock = DB::table('generations')
            ->join('stocks', 'generations.id', '=', 'stocks.generation_id')
            ->select('stocks.id','stocks.information', 'stocks.name', 'stocks.quantity', 'stocks.price_purchase')
            ->where('generations.status', 'verify')
            ->where('stocks.name', 'LIKE', "%". request('q'). "%")
            ->get();
        return response()->json(["items" => $stock], 200);
    }

    public function dataSubmission()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->where('cabang_id', $employee->cabang_id)->with(['stock'])->where('status', '!=','accepted')->orderBy('status', 'ASC');

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function indexSubmission()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $data = [];
        $data['slug'] = $employee->cabang->slug;
        return view('pages.stock-distribution.index-sub', $data);
    }

    public function dataAdminSubmission()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->with(['stock', 'cabang'])->orderBy('status', 'ASC');

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                    'url_verify'=>route('stock-distribution.verify', ["stock_distribution" => $sd->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function stockDistributionVerify(Request $request, $sd)
    {
        $stock_dis = StockDistribution::find($sd);
        $stock = Stock::find($stock_dis->stock_id);
        if ($stock_dis->status == "accepted") {
            return response()->json(['msg' => "Sudah Terverifikasi"], 401);
        }
        if ($stock_dis->status == "rejected") {
            return response()->json(['msg' => "Sudah Ditolak"], 401);
        }
        if (request()->isMethod("PUT")) {
            $sd_qyt = $stock_dis->quantity;
            $stock_qyt = $stock->quantity;
            $res_stock = $stock_qyt - $sd_qyt ;
            $stock->update([
                "quantity" => $res_stock,
            ]);

            $stock_dis->update([
                "status" => "accepted",
            ]);

            return response()->json(["msg" => "{$stock->name} Sudah Terverifikasi"], 200);
        }
        if (request()->isMethod("POST")) {
            $stock_dis->update([
                "status" => "rejected",
            ]);

            return response()->json(["msg" => "{$stock->name} Ditolak"], 200);
        } 
    }
}
