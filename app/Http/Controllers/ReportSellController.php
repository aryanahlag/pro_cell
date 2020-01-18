<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportSellController extends Controller
{
    public function singleExcel()
    {
        return Excel::download(new SellExport, 'Pembelian.xlsx');
    }
}
