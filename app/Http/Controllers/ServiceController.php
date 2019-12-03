<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\ItemService;
use Validator;
use Date;
use Auth;
use DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.service.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            "customer_name" => "required|min:1|string",
            "unit" => "required",
            "dp" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $service = Service::create([
            "customer_name" => $request->customer_name,
            "dp" => $request->dp,
            "unit" => $request->unit,
            "date_in" => Date::now()->format('Y-m-d'),
            "status" => "belum lunas",
            "total_price" => 0,
            "user_id" => Auth::id(),
        ]);

        return response()->json(["msg" => "Service Dangan atas nama ".$service->customer_name." Behasil di Tambahkan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Service::findOrFail($id);

        return view("pages.service.show", compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Service::findOrFail($id);

        return view("pages.service.edit", compact("data"));
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
        $service = Service::findOrFail($id);
        $validator = Validator::make($request->all(),[
            "customer_name" => "required|min:1|string",
            "unit" => "required",
            "dp" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $service->update([
            "customer_name" => $request->customer_name,
            "dp" => $request->dp,
            "unit" => $request->unit,
        ]);
        
        return response()->json(["msg", "Berhasil di update" ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(["msg" => "Service atas Nama ". $service->customer_name." Berhasil di hapus"]);
    }

    public function datatables()
    {
        $service = Service::query()->where("status", "belum lunas");

        return DataTables::of($service)
            ->addColumn('tgl_masuk', function($service){
                return Date::parse($service->date_in)->format('d-m-Y');
            })
            ->addColumn('action', function($service){
            return view('pages.service.action', [
                'model'=>$service,
                'url_show'=>route('employee.service.show', $service->id),
                'url_edit'=>route('employee.service.edit', $service->id),
                'url_delete'=>route('employee.service.destroy', $service->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function payForm($service_id)
    {
        $data = Service::findOrFail($service_id);
        return view("pages.service.pay", compact("data"));
    }

    public function payment(Request $request, $service_id)
    {
        if ($request->change < 0) {
            return response()->json([
                "errors" => "Uang Kurang" 
            ], 422);
        }

        $service = Service::findOrFail($service_id);
        $service->update([
            'status' => "lunas",
            "pay" => $request->pay,
            "change" => $request->change,
            "date_out" => Date::now()->format('Y-m-d'),
        ]);

        return response()->json(["msg" => "Pembayaran Berhasil"], 200);

    }

    public function sudahlunas()
    {
        return "okoko";
    }

    public function lunasData()
    {
        $service = Service::query()->where("status", "lunas");

        return DataTables::of($service)
            ->addColumn('tgl_masuk', function($service){
                return Date::parse($service->date_in)->format('d-m-Y');
            })
            ->addColumn('tgl_keluar', function($service){
                return Date::parse($service->date_out)->format('d-m-Y');
            })
            ->addColumn('action', function($service){
            return view('pages.lunas.action', [
                'model'=>$service,
                'url_show'=>route('employee.service.show', $service->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
