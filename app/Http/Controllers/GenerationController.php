<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generation;
use App\Stock;

class GenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generation = Generation::where('status', 'unverify')->orderBy('time', 'asc')->with(['stock'])->get();
        return view('pages.generation.index', compact('generation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.generation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Generation::create([
            'generation' => date('Y', strtotime($request->time)),
            'time' => $request->time,
            'status' => "unverify",
        ]);
        // return
        return redirect()->route('admin.generation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['generation'] = Generation::where('id', $id)->first();
        $data['stocks'] = Stock::where('generation_id', $id)->get();

        return view('pages.generation.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $generation = Generation::find($id);
        return view('page.generation.edit', compact('generation'));
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
        $gen = Generation::find($id);
        $gen->delete();
        // return
        return redirect()->route('admin.generation.index')->with('msg', 'Delete Success');
    }

    public function verify($id)
    {
        Generation::find($id)->update(['status' => 'verify']);
        // return
        return redirect()->route('admin.stock-generation.index');
    }
}
