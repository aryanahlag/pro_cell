<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\User;
use DataTables;
use Validator;

class MakeEmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employee = Employee::orderBy('name', 'asc')->get();
        return view('pages.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cabang = \App\Cabang::all();
        return view('pages.employee.create',[
            "cabang" => $cabang
        ]);
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
        $data  = [];
        $data['data'] = Employee::findOrFail($id);
        return view('pages.employee.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data  = [];
        $data['data'] = Employee::findOrFail($id);
        $data['cabang'] = \App\Cabang::all();
        return view('pages.employee.edit', $data);

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

    public function datatables()
    {
        $employee = Employee::query()->with(['user', 'cabang'])->orderBy('name', 'desc');
        return DataTables::of($employee)->addColumn('action', function ($employee) {
            return view('pages.employee.action', [
                'model' => $employee,
                'url_show' => route('admin.makeEmployee.show', $employee->id),
                'url_edit' => route('admin.makeEmployee.edit', $employee->id),
                'url_delete' => route('admin.makeEmployee.destroy', $employee->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
