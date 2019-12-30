<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generation;
use App\Stock;
use Validator;
use Date;
use Auth;

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

    public function createSingle($id)
    {
        // $data['generation'] = Generation::where('id', $id)->first();
        $data['generation'] = $id;
        $data["category"] = \App\Category::all();
        $data["brand"] = \App\Brand::all();

        return view('pages.stock.create', $data);
    }

    public function storeSingle(Request $request,$id)
    {
        $customMessages = [
            'code.required' => 'Kode Harus Di isi.',
            'code.unique' => 'Kode Sudah Ada.',
            'name.required' => 'Nama Harus Di isi.',
            'price_purchase.required' => 'Harga Beli Harus Di isi.',
            'quantity.required' => 'Harga Beli Harus Di isi.',
            'quantity.integer' => 'Qyt Harus Angka.',
            'price_purchase.integer' => 'Qyt Harus Angka.',
        ];
        $validator = Validator::make($request->all(),[
            'code' => "required|unique:stocks",
            'name' => "required",
            'price_purchase' => "required|integer",
            'quantity' => "required|integer",
            'category_id' => "required",
            'brand_id' => "required",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::create([
            'code' => $request->code,
            'name' => $request->name,
            'price_purchase' => $request->price_purchase,
            'status' => "unsold",
            'quantity' => $request->quantity,
            'information' => $request->information,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'generation_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(["msg", "$stock->name Berhasil Ditambahkan"], 200);

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
                    'status' => "unsold",
                    'quantity' => $request->quantity[$key],
                    'information' => $request->information[$key],
                    'category_id' => $request->category_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'generation_id' => $id,
                    'user_id' => Auth::id(),
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
    public function show($generation, $id)
    {
        $data = [];
        $stock = Stock::findOrFail($id);
        $gen = Date::parse($stock->generation->time)->format('d F Y');

        $data["data"] = $stock;
        $data["gen"] = $gen;


        return view("pages.stock.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($generation, $id)
    {
        $data = [];
        $data["generation"] = $generation;
        $data["stock"] = Stock::findOrFail($id);
        $data["category"] = \App\Category::all();
        $data["brand"] = \App\Brand::all();

        return view("pages.stock.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $generation, $id)
    {
        $customMessages = [
            'code.required' => 'Kode Harus Di isi.',
            'name.required' => 'Nama Harus Di isi.',
            'price_purchase.required' => 'Harga Beli Harus Di isi.',
            'quantity.required' => 'Harga Beli Harus Di isi.',
            'quantity.integer' => 'Qyt Harus Angka.',
            'price_purchase.integer' => 'Qyt Harus Angka.',
        ];
        $validator = Validator::make($request->all(),[
            'code' => "required|unique:stocks",
            'name' => "required",
            'price_purchase' => "required|integer",
            'quantity' => "required|integer",
            'category_id' => "required",
            'brand_id' => "required",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::findOrFail($id);
        $stock->update([
            'code' => $request->code,
            'name' => $request->name,
            'price_purchase' => $request->price_purchase,
            'status' => "unsold",
            'quantity' => $request->quantity,
            'information' => $request->information,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            // 'generation_id' => $generation,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return response()->json(["msg", "$stock->name Behasil dihapus"], 200);
    }
}
