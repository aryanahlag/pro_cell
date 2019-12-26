<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generation;
use App\Stock;
use DataTables;
use Validator;
use Date;

class GenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $generation = Generation::where('status', 'unverify')->orderBy('time', 'asc')->with(['stock'])->get();
        return view('pages.generation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.generation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unique = Generation::where('time', $request->time)->get();

        if (count($unique) > 0) {
            return response()->json(["msg" => "Tanggal sudah terdaftar"], 401);
        }

        $gen = Generation::create([
            'generation' => date('Y', strtotime($request->time)),
            'time' => $request->time,
            'status' => "unverify",
        ]);
        // return
        return response()->json(['msg' => "Keranjang Berhasil Ditambahkan"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['generation'] = Generation::where('id', $id)->first();
        // $data['stocks'] = Stock::where('generation_id', $id)->get();

        return view('pages.generation.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $generation = Generation::find($id);
        $date = Date::parse($generation->time)->format('Y-m-d');
        // dd($date);
        return view('pages.generation.edit', ["data" => $date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gen = Generation::findOrFail($id);
        $stock = \App\Stock::where('generation_id', $id)->get();
        if (count($stock) > 0) {
            return response()->json(["msg" => "Keranjang Memiliki Stock"], 401);
        }
        $gen->delete();
        // return
        return response()->json(["msg" => "Keranjang Berhasil dihapus"], 200);
    }

    public function verify($id)
    {
        $gen = Generation::findOrFail($id);
        $gen->update(['status' => 'verify']);
        // return
        return response()->json(["msg", "Keranjang pada $gen->time Berhail di verivikasi"], 200);
        // generation
    }

    public function datatables()
    {
        $generation = Generation::query()->with('stock')->where('status', 'unverify')->orderBy('time', 'asc');
        return DataTables::of($generation)
            ->addColumn("allStock", function ($generation){
                $stock_count = Stock::where("generation_id", $generation->id)->count();

                return $stock_count;
            })
            ->addColumn('myTime', function($generation){
                // $newDate = date("d F Y", strtotime($originalDate));
                return Date::parse($generation->time)->format('d F Y');
            })
            ->addColumn('action', function ($generation) {
                return view('pages.generation.action', [
                    'model' => $generation,
                    'url_show' => route('admin.generation.show', $generation->id),
                    'url_edit' => route('admin.generation.edit', $generation->id),
                    'url_delete' => route('admin.generation.destroy', $generation->id),
                    'url_verify' => route('admin.generation.verify', $generation->id),
                ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function stockGenerationData($id)
    {
        $stock = Stock::query()->where('generation_id', $id);
        return DataTables::of($stock)
            ->addColumn('action', function ($stock) {
                return view('pages.stock.action', [
                    'model' => $stock,
                    'url_edit' => route('admin.stock.edit', ["generation" => $stock->generation_id, "stock" => $stock->id]),
                    'url_delete' => route('admin.stock.destroy', ["generation" => $stock->generation_id, "stock" => $stock->id]),
                    'url_show' => route('admin.stock.show', ["generation" => $stock->generation_id, "stock" => $stock->id]),
                ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
