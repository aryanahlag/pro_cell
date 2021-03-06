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
                    {{-- <button onclick="get()">get val</button> --}}
                {{-- <a href="{{ route('employee.stock-distribution.createSingle') }}" class="btn btn-primary btn-sm mr-3" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah Barang
                </a>
                <a href="{{ route('employee.stock-distribution.create') }}" class="btn btn-success btn-sm mr-3">Tambah Banyak Barang</a> --}}
                <a href="{{ route('employee.stock-distribution.indexSubmission', $slug) }}" class="btn btn-info btn-sm">Pengajuan Barang</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableStockDistribution">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nama Barang</th>
                        <th>Harga Jual Satuan (Rp)</th>
                        <th>Harga Jual Grosir (Rp)</th>
                        <th>Qyt</th>
                        {{-- <th></th> --}}
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
    // let markup = $('#myModal .modal-body');
    $('#tableStockDistribution').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.stock-distribution.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "stock.code" },
            { data: "stock.name" },
            { data: "price_sell" },
            { data: "price_grosir" },
            { data: "quantity" },
            // { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/stockDistribution.js')}}"></script>
@endpush
