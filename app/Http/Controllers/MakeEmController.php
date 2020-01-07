<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\User;
use Excel;
use PDF;
use App\Exports\EmployeeExport as EmployeeExport;

class MakeEmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::orderBy('name', 'asc')->get();
        return view('pages.employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'employee'
        ]);
        Employee::create([
            'name' => $request->name,
            'user_id' => $user->id
        ]);

        return redirect()->route('admin.makeEmployee.index');
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
        $employee = Employee::where('id', $id)->with(['user'])->first();
        return view('pages.employee.edit', compact('employee'));
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
        $employee = Employee::find($id);
        // update
        if ($request->username) {
            User::find($employee->user_id)->update(['username' => $request->username]);
        }
        $employee->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.makeEmployee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        // delete
        User::destroy($employee->user_id);
        $employee->delete();
        // return
        return redirect()->route('admin.makeEmployee.index');
    }

    public function excel(){
        return Excel::download(new EmployeeExport, 'Employee.xlsx');
    }

    public function pdf()
    {
        $employee = Employee::all();

        $pdf = PDF::loadView('layouts.pdf.employee', compact('employee'));

        return $pdf->download('employee.pdf');
    }

}
