@extends('layouts.master', ["activePage" => "karyawan-buat", "titlePage" => "Akun Karyawan" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Akun Karyawan</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="{{ route('admin.makeEmployee.create') }}" class="btn btn-success" id="btn-create">
                    <i class="fa fa-plus"></i>
                    Tambah Akun Karyawan
                </a>
                <a style="margin-right:5px;" href="{{ route('makeEmployee.excel') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-file-excel"></i>
                    Print Excel
                </a>
                <a style="margin-right:5px;" href="{{ route('makeEmployee.pdf') }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-file-pdf"></i>
                    Print PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableEmployee">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Cabang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#tableEmployee').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.makeEmployee.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name" },
            { data: "cabang.name" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/employee.js')}}"></script>
@endpush
