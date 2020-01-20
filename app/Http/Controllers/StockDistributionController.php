<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDistribution;
use App\Stock;
use DataTables;
use App\Cabang;
use Auth;
use Date;
use Validator;
use DB;

class StockDistributionController extends Controller
{
    // public function __construct()
    // {
    //     $user = Auth::check();
    //     if (!$user) {
    //         return response()->json(['msg' => "Terjadi Kesalahan .. Refresh Halaman"], 401);
    //     }
    // }
    public function index()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $data = [];
        $data['slug'] = $employee->cabang->slug;
        return view('pages.stock-distribution.index', $data);
    }

    public function create()
    {
        $data = [];
        if (Auth::user()->role == 'employee') {
            $employee = \App\Employee::where("user_id", Auth::id())->first();
            $data['slug'] = $employee->cabang->slug;
        }
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
            'price_sell.numeric' => 'Harga Jual Harus Angka.',
            'price_grosir.required' => 'Harga Grosir Harus Di isi.',
            'price_grosir.numeric' => 'Harga Grosir Harus Angka.',
            'quantity.required' => 'Harga Beli Harus Di isi.',
            'quantity.numeric' => 'Qyt Harus Angka.',
            'quantity.min' => 'Qyt Minimal 1.',
        ];
        $validator = Validator::make($request->all(),[
            "stock_id" => "required",
            "price_sell" => "required|numeric",
            "price_grosir" => "required|numeric",
            "quantity" => "required|numeric|min:1",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::where('id', $request->stock_id)->first();
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::where('stock_id', $request->stock_id)->where('cabang_id', $employee->cabang_id)->where('status', '!=', 'submission')->where('status', '!=', 'rejected')->get();
        


        if (!$stock) {
            return response()->json(['msg' => 'Stock Tidak Ditemukan'], 401);
        }

        $all_stock = $stock->quantity_p + $stock->quantity_tbh;
        if ($request->quantity > $all_stock) {
            return response()->json(['msg' => "Jumlah Maksimal {$all_stock}"], 401);
        }


        if ($stock->price_purchase > $request->price_sell) {
            return response()->json(['msg' => "Harga Jual Terlalu Kecil" ], 401);
        }

        if ($stock->price_purchase > $request->price_grosir) {
            return response()->json(['msg' => "Harga Grosir Terlalu Kecil" ], 401);
        }

        // =================================================================== //
        // jika ada request harga
        $res_price = [$request->price_sell, $request->price_grosir];
        if (count($sd)) {
            dd(true);
            $old_sd = DB::table('stock_distributions')
                    ->select('stock_id', 'price_sell', 'price_grosir', DB::raw('SUM(quantity) AS quantity'))
                    ->groupBy('stock_id', 'price_sell', 'price_grosir')
                    ->where('stock_id', $request->stock_id)
                    ->where('cabang_id', $employee->cabang_id)
                    ->where('status', '!=', 'submission')
                    ->where('status', '!=', 'rejected')
                    ->first();
            if ($request->price_sell != $old_sd->price_sell) {
                $res_price[0] = $request->price_sell;
                DB::table('stock_distributions')
                    ->where('stock_id', $request->stock_id)
                    ->where('cabang_id', $employee->cabang_id)
                    ->update(['price_sell' => $request->price_sell]);
            }

            if ($request->price_grosir != $old_sd->price_grosir) {
                $res_price[1] = $request->price_grosir;
                DB::table('stock_distributions')
                    ->where('stock_id', $request->stock_id)
                    ->where('cabang_id', $employee->cabang_id)
                    ->update(['price_grosir' => $request->price_grosir]);
            }
        }
        

        if ($stock->quantity_tbh > $request->quantity) {
            $res_quantity = $stock->quantity_tbh - $request->quantity;
            // dd($res_quantity. '====='.  $request->quantity);
            $stock->update([
                "quantity_tbh" => $res_quantity,
            ]);
        }else {
            $res_quantity = $request->quantity - $stock->quantity_tbh;
            $res_quantity = $stock->quantity_p - $res_quantity;
            // dd($res_quantity. '====='.  $request->quantity);
            $stock->update([
                "quantity_tbh" => 0,
                "quantity_p" => $res_quantity,
            ]);
        }
        
        $sd = StockDistribution::create([
            'stock_id' => $request->stock_id,
            'cabang_id' => $employee->cabang_id,
            'quantity' => $request->quantity,
            'price_sell' => $res_price[0],
            'price_grosir' => $res_price[1],
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
        $sd = StockDistribution::query()
            ->where('cabang_id', $employee->cabang_id)
            ->with(['stock'])
            ->select('stock_id', 'price_sell', 'price_grosir', DB::raw('SUM(quantity) AS quantity'))
            ->groupBy('stock_id', 'price_sell', 'price_grosir')
            ->where('status', 'accepted')
            ->orWhere('status', 'shipment');
        // dd($sd);

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                    'page' => '',
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function checkStock(Request $request)
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::where('stock_id', $request->sid)->where('cabang_id', $employee->cabang_id)->where('status', '!=', 'submission')->where('status', '!=', 'rejected')->get();
        if (count($sd) > 0) {
            $old_sd = DB::table('stock_distributions')
                    ->select('stock_id', 'price_sell', 'price_grosir', DB::raw('SUM(quantity) AS quantity'))
                    ->groupBy('stock_id', 'price_sell', 'price_grosir')
                    ->where('stock_id', $request->sid)
                    ->where('cabang_id', $employee->cabang_id)
                    ->where('status', '!=', 'submission')
                    ->where('status', '!=', 'rejected')
                    ->first();
            return response()->json([
                'stock_id' => $old_sd->stock_id,
                'price_sell' => $old_sd->price_sell,
                'price_grosir' => $old_sd->price_grosir,
                'qty' => $old_sd->quantity,
            ], 200);
        }else{
            return "new";
        }
    }

    public function findStock()
    {
        // $generation = \App\Generation::where("status", "verify")->get();
        // $st_gen = \App\Generation::where("status", "verify")->with(['stock'])
        // $stock = Stock::where("name", 'LIKE', '%' .   request('q') . '%')->with(['brand', 'category', 'generation'])->get();
        $stock = DB::table('generations')
            ->join('stocks', 'generations.id', '=', 'stocks.generation_id')
            ->select('stocks.id','stocks.information', 'stocks.name', DB::raw('quantity_p + quantity_tbh AS quantity'), 'stocks.price_purchase')
            ->where('generations.status', 'verify')
            ->where('stocks.name', 'LIKE', "%". request('q'). "%")
            ->get();
        return response()->json(["items" => $stock], 200);
    }

    public function dataSubmission()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->where('cabang_id', $employee->cabang_id)->with(['stock'])->where('status', '!=','accepted')->where('status', '!=','shipment')->orderBy('status', 'ASC');

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                    'page' => ''
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
                    'page' => 'submission',
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
            $res_quantity = 0;
            $all_stock = $stock->quantity_p + $stock->quantity_tbh;


            if ($stock->quantity_tbh > $stock_dis->quantity) {
                $res_quantity = $stock->quantity_tbh - $stock_dis->quantity;
                $stock->update([
                    "quantity_tbh" => $res_quantity,
                ]);
            }else {
                $res_quantity = $stock_dis->quantity - $stock->quantity_tbh;
                $res_quantity = $stock->quantity_p - $res_quantity;
                // dd($res_quantity. '====='.  $request->quantity);
                $stock->update([
                    "quantity_tbh" => 0,
                    "quantity_p" => $res_quantity,
                ]);
            }

            // $sd_qyt = $stock_dis->quantity;
            // $stock_qyt = $stock->quantity;
            // $res_stock = $stock_qyt - $sd_qyt ;
            // $stock->update([
            //     "quantity" => $res_stock,
            // ]);

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

    public function shipmentIndex()
    {
        return view('pages.stock-distribution.shipment');
    }

    public function shipmentData()
    {
        $sd = StockDistribution::query()->where('status', 'shipment')->with(['stock', 'cabang'])->orderBy('created_at', 'DESC');

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                    'url_verify'=>route('stock-distribution.verify', ["stock_distribution" => $sd->id]),
                    'page' => 'shipment'                    
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function createShipment()
    {
        return view('pages.stock-distribution.create');
    }

    public function storeShipment(Request $request)
    {
        $customMessages = [
            'stock_id.required' => 'Stock Harus Di isi.',
            'stock_id.exists' => 'Stock Tidak Ada.',
            'price_sell.required' => 'Harga Jual Harus Di isi.',
            'price_sell.numeric' => 'Harga Jual Harus Angka.',
            'price_grosir.required' => 'Harga Grosir Harus Di isi.',
            'price_grosir.numeric' => 'Harga Grosir Harus Angka.',
            'quantity.required' => 'Harga Beli Harus Di isi.',
            'quantity.numeric' => 'Qyt Harus Angka.',
            'quantity.min' => 'Qyt Minimal 1.',
            'cabang.required' => 'Pilih Cabang'
        ];
        $validator = Validator::make($request->all(),[
            "stock_id" => "required",
            "price_sell" => "required|numeric",
            "price_grosir" => "required|numeric",
            "quantity" => "required|numeric|min:1",
            "cabang" => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::where('id', $request->stock_id)->first();
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $thatSd = StockDistribution::where('stock_id', $request->stock_id)->first();
        if (!$stock) {
            return response()->json(['msg' => 'Stock Tidak Ditemukan'], 401);
        }

        $res_quantity = 0;
        // if ($stock->quantity_tbh != 0) {
        $all_stock = $stock->quantity_p + $stock->quantity_tbh;
        if ($request->quantity > $stock->quantity_p + $stock->quantity_tbh) {
            return response()->json(['msg' => "Jumlah Maksimal {$all_stock}"], 401);
        }

        if ($stock->price_purchase > $request->price_sell) {
            return response()->json(['msg' => "Harga Jual Terlalu Kecil" ], 401);
        }

        if ($stock->price_purchase > $request->price_grosir) {
            return response()->json(['msg' => "Harga Grosir Terlalu Kecil" ], 401);
        }

        if ($stock->quantity_tbh > $request->quantity) {
            $res_quantity = $stock->quantity_tbh - $request->quantity;
            // dd($res_quantity. '====='.  $request->quantity);
            $stock->update([
                "quantity_tbh" => $res_quantity,
            ]);
        }else {
            $res_quantity = $request->quantity - $stock->quantity_tbh;
            $res_quantity = $stock->quantity_p - $res_quantity;
            // dd($res_quantity. '====='.  $request->quantity);
            $stock->update([
                "quantity_tbh" => 0,
                "quantity_p" => $res_quantity,
            ]);
        }
        
        $cabang = Cabang::findOrFail($request->cabang);
        $sd = StockDistribution::create([
            'stock_id' => $request->stock_id,
            'cabang_id' => $request->cabang,
            'quantity' => $request->quantity,
            'price_sell' => $request->price_sell,
            'price_grosir' => $request->price_grosir,
            'status' => 'shipment',
            'information' => $request->information
        ]);

        return response()->json(['msg' => "Stock Berhasil DIkirim ke {$cabang->name} Sebanyak {$request->quantity}"], 200);
    }
}
