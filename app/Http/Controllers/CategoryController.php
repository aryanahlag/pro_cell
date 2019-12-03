<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RequestCategory;
use App\Http\Requests\RequestCategory;
use Illuminate\Http\Request;
use DataTables;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
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

        $category = Category::create($data);

        return response()->json(['msg' => $category->name . ' Telah Ditambahkan']);
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
        // dd('okoko');
        $data = Category::findOrFail($id);

        return view('pages.category.edit', [
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

        $category = Category::findOrFail($id);

        $category->update($data);

        return response()->json(['msg' => $category->name . ' Berhasil di edit']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['msg' => $category->name . ' Berhasil Di hapus']);
    }

    public function datatables()
    {
        $category = Category::query();
        return DataTables::of($category)->addColumn('action', function ($category) {
            return view('pages.category.action', [
                'model' => $category,
                'url_show' => route('admin.category.show', $category->id),
                'url_edit' => route('admin.category.edit', $category->id),
                'url_delete' => route('admin.category.destroy', $category->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
