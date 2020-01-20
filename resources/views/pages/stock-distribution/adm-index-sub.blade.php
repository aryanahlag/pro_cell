@extends('layouts.master', ["activePage" => "pengajuan", "titlePage" => "Pengajuan" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Pengajuan Barang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button type="button" id="btn-refresh-admin-sub" class="btn btn-info btn-sm mr-3"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableStockDistributionSubmission">
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
    $('#tableStockDistributionSubmission').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.stock-distribution.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "stock.name" },
            { data: "cabang.name" },
            { data: "price_sell", render: function (a,b,c) {
                if (c.req_price != "") {
                    let sell = c.req_price.split("|")
                    return sell[0]
                }else{
                    return c.price_sell
                }
            } },
            { data: "price_grosir", render: function (a,b,c) {
                if (c.req_price != "") {
                     let grosir = c.req_price.split("|")
                    return grosir[1]
                }else{
                    return c.price_grosir
                }
            } },
            { data: "quantity" },
            { data: "status", render : function (a,b,c) {
                let stts = c.status ;
                if (stts == "submission") {
                    return `<span class="badge badge-info">Pengajuan</span>`
                }
                if (stts == "accepted") {
                    return `<span class="badge badge-success">Diterima</span>`
                }

                if (stts == "rejected") {
                    return `<span class="badge badge-danger">Ditolak</span>`
                }
            } },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/stockDistribution.js')}}"></script>
@endpush
