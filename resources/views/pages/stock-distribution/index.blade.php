@extends('layouts.master', ["activePage" => "stock-distribution", "titlePage" => "Barang Toko" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Barang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="{{ route('employee.stock-distribution.create') }}" class="btn btn-primary btn-sm mr-3" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah Barang
                </a>
                <a href="" class="btn btn-success btn-sm">Tambah Banyak Barang</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableCategory">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Nama Kategori
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
    $('#tableCategory').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.category.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/category.js')}}"></script>
@endpush
