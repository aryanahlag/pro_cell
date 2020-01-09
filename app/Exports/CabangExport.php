<?php

namespace App\Exports;

Use App\Cabang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CabangExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $cabang = Cabang::all();
        return view('layouts.excel.cabang', ['cabang'=>$cabang]);
    }


    public function registerEvents() : array{
    	return 	[
    		AfterSheet::class => function(AfterSheet $event){
    			$cellRange = 'A1:D5000';
    			$event->sheet->getDelegate()->getStyle($cellRange);
    		}
    	];
    }
}
