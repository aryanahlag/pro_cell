@extends('layouts.master', ["activePage" => "karyawan-buat", "titlePage" => "Buat Akun Karyawan" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Akun Karyawan</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="{{ route('admin.makeEmployee.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                    Tambah Akun Karyawan
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableCategory">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($employee->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                    @endif
                    @foreach ($employee as $i =>$emp)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td class="text-center">{{ $emp->name }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.makeEmployee.destroy', ['id'=>$emp->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('admin.makeEmployee.edit', ['id'=>$emp->id]) }}" class="btn  btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
