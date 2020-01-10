@extends('layouts.master', ["activePage" => "suplier", "titlePage" => "Suplier" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Suplier</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="{{ route('admin.suplier.create') }}" class="btn btn-primary btn-sm" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah Suplier
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableSuplier">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Suplier</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th></th>
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
    $('#tableSuplier').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.suplier.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "code" },
            { data: "name" },
            { data: "allStock" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/supplier.js')}}"></script>
@endpush
