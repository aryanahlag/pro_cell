<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemService;
use App\Service;
use DB;
use Auth;

class ItemServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($service_id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($service_id)
    {
        $data = [];
        $employ = \App\Employee::where("user_id", Auth::id())->first();
        $data["service_id"] = $service_id;
        $data['slug'] = $employ->cabang->slug;
        return view("pages.item-service.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $service_id)
    {
        if (count($request->name) > 0) {
            foreach ($request->name as $key => $value) {
                $data = [
                    'name' => $request->name[$key],
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                    'service_id' => $request->service_id,
                ];
                ItemService::insert($data);
            }

            $total = ItemService::selectRaw("SUM((price * quantity)) AS total")->where("service_id", $service_id)->first();
            $service = Service::findOrFail($service_id);
            $service->update([
                'total_price' => $total->total - $service->dp
            ]);
            // get slug
            $employ = \App\Employee::where("user_id", Auth::id())->first();
            
        }
        return redirect()->route('employee.service.index', $employ->cabang->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($service_id,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($service_id,$id)
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
    public function update(Request $request, $service_id,$id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($service_id, $id)
    {
        //
    }
}
