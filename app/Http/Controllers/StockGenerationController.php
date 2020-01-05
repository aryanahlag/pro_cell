<?php

namespace App\Http\Controllers;

use App\Generation;
use Illuminate\Http\Request;
use App\Stock;
use App\StockDistribution;
use App\Cabang;
use DataTables;
use Auth;
use Validator;
use Date;

class StockGenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $generation = Generation::where('status', 'verify')->orderBy('time', 'asc')->with(['stock'])->get();
        $data['generation'] = $generation;
        // $data['sd'] = StockDistribution::where('status', 'submission')-with(['stock'])->get();
        return view('pages.stock.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function stockCabang()
    {
        $cabang = Cabang::query()->with('stockDistribution')->orderBy('name', 'ASC');
        return DataTables::of($cabang)
            ->addColumn("allStock", function ($cabang){
                $stock_count = StockDistribution::where("cabang_id", $cabang->id)->count();
                return $stock_count;
            })
            // ->addColumn('action', function ($cabang) {
            //     return view('pages.cabang.action', [
            //         'model' => $cabang,
            //         'url_show' => route('admin.cabang.show', $cabang->id),
            //         'url_edit' => route('admin.cabang.edit', $cabang->id),
            //         'url_delete' => route('admin.cabang.destroy', $cabang->id),
            //         'url_verify' => route('admin.cabang.verify', $cabang->id),
            //     ]);
            // })
            ->rawColumns(['action'])->addIndexColumn()->make(true);
    }

}
