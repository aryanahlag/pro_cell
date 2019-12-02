<?php

namespace App\Http\Controllers;

use App\Barcode;
use Illuminate\Http\Request;
use DNS1D;
use App\Stock;
use Illuminate\Support\Facades\Input;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.card.card');
    }

    public function barcodeStore(Request $request)
    {
        $res = substr($request->code, 0, strlen($request->code) - 1);
        $data = explode("-", $res);
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $data2 = [
                    'code' => $data[$key],
                ];
                Barcode::insert($data2);
            }
        }
        return response()->json(['msg' => 'Store Success', 'data' => count($data)]);
        // return redirect()->route("barcode.print", count($data));
    }

    public function print($limit)
    {
        $code = Barcode::orderBy('id', 'desc')->limit($limit)->get();
        return view('pages.card.print', compact('code'));
    }
}
