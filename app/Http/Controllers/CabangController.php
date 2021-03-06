<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Cabang;
use DataTables;
use Excel;
use PDF;
use App\Exports\CabangExport as CabangExport;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cabang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];  
        $data['now'] = date('Y-m-d');
        return view('pages.cabang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->name, "-");

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'address' => $request->address,
            'date' => $request->date,
        ];

        $cabang = Cabang::create($data);

        return response()->json(['msg' => $cabang->name . ' Telah Ditambahkan']);
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
        $data = Cabang::findOrFail($id);

        return view('pages.cabang.edit', [
            'data' => $data
        ]);
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
        $slug = Str::slug($request->name, "-");
        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'address' => $request->address,
            'date' => $request->date,
        ];

        $cabang = Cabang::findOrFail($id);

        $cabang->update($data);

        return response()->json(['msg' => $cabang->name . ' Berhasil di edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);

        $user = \App\Employee::where('cabang_id', $id)->get();
        if (count($user) > 0) {
            return response()->json(["msg" => "Cabang Masih Memliki Pegawai"], 401);
        }

        $cabang->delete();

        return response()->json(['msg' => $cabang->name . ' Berhasil Di hapus']);
    }

    public function datatables()
    {
        $cabang = Cabang::query();
        return DataTables::of($cabang)->addColumn('action', function ($cabang) {
            return view('pages.cabang.action', [
                'model' => $cabang,
                'url_show' => route('admin.cabang.show', $cabang->id),
                'url_edit' => route('admin.cabang.edit', $cabang->id),
                'url_delete' => route('admin.cabang.destroy', $cabang->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function excel(){
        return Excel::download(new CabangExport, 'Cabang.xlsx');
    }

    public function pdf()
    {
        $cabang = Cabang::all();

        $pdf = PDF::loadView('layouts.pdf.cabang', compact('cabang'));

        return $pdf->download('cabang.pdf');
    }
}
