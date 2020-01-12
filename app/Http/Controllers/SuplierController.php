<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier as Suplier;
use DataTables;
use Date;
use DB;
use Validator;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.suplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.suplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function codeSup()
    {
        $max_query = DB::table('suppliers')->max('code');
        // $kodeB = Inventaris::all();
        $date = date("ymdh");

        if ($max_query != null) {
            $nilai = substr($max_query, 11, 11);
            $kode = (int) $nilai;
            // tambah 1
            $kode = $kode + 1;
            $auto_kode = "SPY". $date . str_pad($kode, 4, "0",  STR_PAD_LEFT);
        } else {
            $auto_kode = "SPY". $date . "0001";
        }

        return $auto_kode;
    }

    public function store(Request $request)
    {
        $customMessages = [
            'name.required' => "Nama Tidak Boleh Kosong",
            'address.required' => "Alamat Tidak Boleh Kosong",
            'phone.required' => "Nomor Telepon Tidak Boleh Kosong",
            'phone.numeric' => "Nomor Telepon Harus Angka",
        ];
        $validator = Validator::make($request->all(),[
            "name" => "required|max:100",
            "address" => "required",
            "phone" => "required|numeric",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }


        $sup = Suplier::create([
            'code' => $this->codeSup(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return response()->json(['msg' => "{$sup->name} Berhasil Ditambahkan"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['data'] = Suplier::findOrFail($id);
        return view('pages.suplier.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = Suplier::findOrFail($id);
        return view('pages.suplier.edit', $data);
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
        $customMessages = [
            'name.required' => "Nama Tidak Boleh Kosong",
            'address.required' => "Alamat Tidak Boleh Kosong",
            'phone.required' => "Nomor Telepon Tidak Boleh Kosong",
            'phone.numeric' => "Nomor Telepon Harus Angka",
        ];
        $validator = Validator::make($request->all(),[
            "name" => "required|max:100",
            "address" => "required",
            "phone" => "required|numeric",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $sup = Suplier::findOrFail($id);

        $sup->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['msg' => "{$sup->name} Berhasil Diperbahrui"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sup = Suplier::findOrFail($id);
        $sup->delete();
        return response()->json(['msg' => "$sup->name Berhasil Dihapus"]);
    }

    public function datatables()
    {
        $suplier = Suplier::query()->orderBy('created_at', 'DESC');
        return DataTables::of($suplier)
            ->addColumn('allStock', function ($suplier){
                $stock_count = \App\Stock::where("supplier_id", $suplier->id)->count();
                return $stock_count;
            })
            ->addColumn('action', function ($suplier) {
                return view('pages.suplier.action', [
                    'model' => $suplier,
                    'url_show' => route('admin.suplier.show', $suplier->id),
                    'url_edit' => route('admin.suplier.edit', $suplier->id),
                    'url_delete' => route('admin.suplier.destroy', $suplier->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
