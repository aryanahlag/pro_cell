
@extends('layouts.master', ["activePage" => "pengiriman", "titlePage" => "Pengiriman Ke Cabang" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Pengiriman Barang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button type="button" id="btn-refresh-admin-sub" class="btn btn-info btn-sm mr-3"><i class="fa fa-refresh"></i> Refresh</button>
                <a href="{{ route('admin.stock-distribution.shipment.create') }}" class="btn btn-primary btn-sm mr-3" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah
                </a>
                <a href="{{ route('stock-distribution.create') }}" class="btn btn-success btn-sm mr-3">Tambah Banyak</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableStockDistributionShipment">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Cabang</th>
                        <th>Harga Jual Satuan (Rp)</th>
                        <th>Harga Jual Grosir (Rp)</th>
                        <th>Qyt</th>
                        <th>Status</th>
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
    // let markup = $('#myModal .modal-body');
    $('#tableStockDistributionShipment').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.stock-distribution.shipment.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "stock.name" },
            { data: "cabang.name" },
            { data: "price_sell" },
            { data: "price_grosir" },
            { data: "quantity" },
            { data: "status", render: function (a,b,c) {
                return 'Kiriman'
            }},
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/stockDistribution.js')}}"></script>
@endpush
