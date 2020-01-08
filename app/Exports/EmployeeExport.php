<?php

namespace App\Exports;

use App\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $employee = Employee::all();
        return view('layouts.excel.employee', ['employee'=>$employee]);
    }


    public function registerEvents() : array{
    	return 	[
    		AfterSheet::class => function(AfterSheet $event){
    			$cellRange = 'A1:E5000';
    			$event->sheet->getDelegate()->getStyle($cellRange);
    		}
    	];
    }
}
