<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestBrand;
use App\Brand;
use DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $brand = Brand::create($data);

        return response()->json(['msg' => $brand->name . ' Telah Ditambahkan']);
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
        $data = Brand::findOrFail($id);

        return view('pages.brand.edit', [
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
        $data = $request->all();

        $brand = Brand::findOrFail($id);

        $brand->update($data);

        return response()->json(['msg' => $brand->name . ' Berhasil di edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        return response()->json(['msg' => $brand->name . ' Berhasil Di hapus']);
    }

    public function datatables()
    {
        $brand = Brand::query();
        return DataTables::of($brand)->addColumn('action', function ($brand) {
            return view('pages.brand.action', [
                'model' => $brand,
                'url_show' => route('admin.brand.show', $brand->id),
                'url_edit' => route('admin.brand.edit', $brand->id),
                'url_delete' => route('admin.brand.destroy', $brand->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
