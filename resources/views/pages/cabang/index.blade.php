@extends('layouts.master', ["activePage" => "cabang", "titlePage" => "Cabang" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Cabang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <button style="margin-right:5px;" data-url="{{ route('admin.cabang.create') }}" class="btn btn-primary" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah Cabang
                </button>
                <a style="margin-right:5px;" href="{{ route('cabang.excel') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-file-excel"></i>
                    Print Excel
                </a>
                <a href="{{ route('cabang.pdf') }}" class="btn btn-sm btn-danger">
                    <i class="fa fa-file-pdf"></i>
                    Print PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableCabang">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Nama Cabang
                        </th>
                        <th>
                            Alamat
                        </th>
                        <th>
                            Tanggal Dibuat
                        </th>
                        <th>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#tableCabang').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.cabang.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name" },
            { data: "address" },
            { data: "date" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/cabang.js')}}"></script>
@endpush
