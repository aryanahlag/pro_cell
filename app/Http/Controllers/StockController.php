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
        $data["category"] = \App\Category::orderBy('name', 'asc')->get();
        $data["brand"] = \App\Brand::orderBy('name', 'asc')->get();
        $data["supplier"] = \App\Supplier::orderBy('name', 'asc')->get();

        return view('pages.generation.createStock', $data);
    }

    public function createSingle($id)
    {
        // $data['generation'] = Generation::where('id', $id)->first();
        $data['generation'] = $id;
        $data["category"] = \App\Category::all();
        $data["brand"] = \App\Brand::all();
        $data["supplier"] = \App\Supplier::all();

        return view('pages.stock.create', $data);
    }

    public function storeSingle(Request $request,$id)
    {
        $customMessages = [
            'code.required' => 'Kode Harus Di isi.',
            'code.unique' => 'Kode Sudah Ada.',
            'name.required' => 'Nama Harus Di isi.',
            'price_purchase.required' => 'Harga Beli Harus Di isi.',
            'quantity_p.required' => 'Harga Beli Harus Di isi.',
            'quantity_p.integer' => 'Qyt Harus Angka.',
            'price_purchase.integer' => 'Qyt Harus Angka.',
        ];
        $validator = Validator::make($request->all(),[
            'code' => "required|unique:stocks",
            'name' => "required",
            'price_purchase' => "required|integer",
            'quantity_p' => "required|integer",
            'category_id' => "required",
            'brand_id' => "required",
            'supplier_id' => "required",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $stock = Stock::create([
            'code' => $request->code,
            'name' => $request->name,
            'price_purchase' => $request->price_purchase,
            'status' => "unsold",
            'quantity_p' => $request->quantity_p,
            'quantity_tbh' => 0,
            'information' => $request->information,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'generation_id' => $id,
            'supplier_id' => $request->supplier_id,
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
                    'price_purchase' => $request->price[$key],
                    'status' => "unsold",
                    'quantity_p' => $request->quantity_p[$key],
                    'quantity_tbh' => 0,
                    'information' => $request->information[$key],
                    'category_id' => $request->category[$key],
                    'brand_id' => $request->brand[$key],
                    'supplier_id' => $request->supplier[$key],
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
            'code' => "required",
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
            'quantity_p' => $request->quantity,
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

    public function createTbh($generation, $id)
    {
        $data = [];
        $data['gen'] = Generation::findOrFail($generation);
        $data['data'] = Stock::findOrFail($id);
        return view('pages.stock.tbh', $data);
    }

    public function storeTbh(Request $request, $generation, $id)
    {
        $customMessages = [
            'tbh.required' => 'Qty Tambahan Harus Di isi.',
            'tbh.numeric' => 'Qty Tambahan Harus Angka.',
            'tbh.min' => 'Qty Tambahan Minimal 1.',
        ];
        $validator = Validator::make($request->all(),[
            'tbh' => "required|numeric|min:1",
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $gen = Generation::findOrFail($generation);
        $stock = Stock::findOrFail($id);
        if ($gen->status == 'verify') {
            return response()->json(['msg' => 'Tidak Dapat Menambah Keranjang Sudah Di Verifikasi Silahkan Memebuat Keranjang Baru'], 401);
        }
        $res_tbh = $stock->quantity_tbh;
        // dd($res_tbh + $request->tbh);
        $stock->update([
            'quantity_tbh' => $res_tbh + $request->tbh,
        ]);

        return response()->json(['msg' => 'quantity Tambahan Berhasil Sebanyak ' . $request->tbh]);
    }
}
