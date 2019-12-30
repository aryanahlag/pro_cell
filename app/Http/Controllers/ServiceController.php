<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Employee;
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
        $employee = Employee::where("user_id", Auth::id())->first();
        $service = Service::create([
            "customer_name" => $request->customer_name,
            "dp" => $request->dp,
            "unit" => $request->unit,
            "date_in" => Date::now()->format('Y-m-d'),
            "status" => "belum lunas",
            "cabang_id" => $employee->cabang_id,
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
        $data =  [];
        $data["data"] = Service::findOrFail($id);

        return view("pages.service.edit", $data);
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

        return response()->json(["msg" => "Service atas Nama ". $service->customer_name." Berhasil di hapus"],200);
    }

    public function datatables()
    {
        $employee = Employee::where("user_id", Auth::id())->first();
        $service = Service::query()->where("status", "belum lunas")->where("cabang_id", $employee->cabang_id);
        // dd($service);
        $data = DataTables::of($service)
            ->addColumn('tgl_masuk', function($service){
                return Date::parse($service->date_in)->format('d-m-Y');
            })
            ->addColumn('action', function($service){
                return view('pages.service.action', [
                    'model'=>$service,
                    'url_show'=>route('employee.service.show', ["service" => $service->id]),
                    'url_edit'=>route('employee.service.edit', ["service" => $service->id]),
                    'url_delete'=>route('employee.service.destroy', ["service" => $service->id]),
                    'url_pay'=>route('employee.service.payForm', ["service" => $service->id]),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
        return $data; 
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
        $employ = \App\Employee::where("user_id", Auth::id())->first();
        $data['slug'] = $employ->cabang->slug;
        return view('pages.lunas.index', $data);
    }

    public function lunasData()
    {
        $employee = Employee::where("user_id", Auth::id())->first();
        $service = Service::query()->where("status", "lunas")->where("cabang_id", $employee->cabang_id);

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
                'url_show'=>route('service.show.lunas', $service->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function lunasShow($service)
    {
        $data = Service::findOrFail($service);
        return view("pages.lunas.show", compact("data"));
    }

    public function cetakStruk($service)
    {
       $data = Service::findOrFail($service);
        return view("pages.lunas.cetak", compact("data"));
    }
}
