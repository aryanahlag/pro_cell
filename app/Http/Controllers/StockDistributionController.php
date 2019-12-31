<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDistribution;
use App\Stock;
use DataTables;
use Auth;
use Date;
use Validator;

class StockDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.stock-distribution.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.stock-distribution.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
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

    public function datatables()
    {
        $employee = \App\Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->where('cabang_id', $employee->cabang_id)->with(['stock']);

        $data = DataTables::of($sd)
            ->addColumn('action', function($sd){
                return view('pages.stock-distribution.action', [
                    'model'=>$sd,
                    'url_show'=>route('employee.stock-distribution.show', ["stock_distribution" => $sd->id]),
                    'url_edit'=>route('employee.stock-distribution.edit', ["stock_distribution" => $sd->id]),
                    'url_delete'=>route('employee.stock-distribution.destroy', ["stock_distribution" => $sd->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);

        return $data;
    }

    public function findStock()
    {
        $stock = Stock::where("name", 'LIKE', '%' .   request('q') . '%')->with(['brand', 'category', 'generation'])->get();
        return response()->json(["items" => $stock], 200);
    }
}
