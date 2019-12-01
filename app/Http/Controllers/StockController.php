<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generation;
use App\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['generation'] = Generation::where('id', $id)->first();

        return view('pages.generation.createStock', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (count($request->code) > 0) {
            foreach ($request->code as $key => $value) {
                $data = [
                    'code' => $request->code[$key],
                    'name' => $request->name[$key],
                    'price_purchase' => $request->price_purchase[$key],
                    'price_sell' => $request->price_sell[$key],
                    'status' => "unsold",
                    'quantity' => $request->quantity[$key],
                    'information' => $request->information[$key],
                    'category_id' => $request->category_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'generation_id' => $id,
                ];
                Stock::insert($data);
            }
        }
        return redirect()->route('admin.generation.show', $id);
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
}
