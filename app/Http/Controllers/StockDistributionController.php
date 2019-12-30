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

    public function datatables()
    {
        $employee = Employee::where("user_id", Auth::id())->first();
        $sd = StockDistribution::query()->where('cabang_id', $employee->cabang_id)->with(['stock']);

        $data = DataTables::of($sd)
            ->addColumn('action', function($service){
                return view('pages.service.action', [
                    'model'=>$service,
                    'url_show'=>route('employee.service.show', ["service" => $service->id]),
                    'url_edit'=>route('employee.service.edit', ["service" => $service->id]),
                    'url_delete'=>route('employee.service.destroy', ["service" => $service->id]),
                    'url_pay'=>route('employee.service.payForm', ["service" => $service->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
