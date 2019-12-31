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
                <a href="{{ route('employee.stock-distribution.create') }}" class="btn btn-primary btn-sm mr-3" id="btn-create">
                    <i class="fas fa-plus"></i> Tambah Barang
                </a>
                <a href="" class="btn btn-success btn-sm">Tambah Banyak Barang</a>
            </div>
        </div>
                {{-- <select id="stock_id" style="width: 100%"></select> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableStockDistribution">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Jual Satuan (Rp)</th>
                        <th>Harga Jual Grosir (Rp)</th>
                        <th>Qyt</th>
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
    $('#tableStockDistribution').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.stock-distribution.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "stock.name" },
            { data: "price_sell" },
            { data: "price_grosir" },
            { data: "quantity" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
    // $('#stock_id').select2({
    //     ajax: {
    //         url: "http://127.0.0.1:8000/employee/sd/sel2",
    //         dataType: "json",
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 q: params.term,
    //             };
    //         },
    //         processResults: function (data) {
    //             // Transforms the top-level key of the response object from 'items' to 'results'
    //             return {
    //                 results: data.items
    //             };
    //         }
    //     },
    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 1,
    //     templateResult: function (repo) {
    //         if (repo.loading) {
    //             return repo.text;
    //         }
    //         // console.log(repo.quantity)
    //         var $container = $(
    //             "<div class='select2-result-repository clearfix'>" +
    //               "<div class='select2-result-repository__meta'>" +
    //                 "<div class='select2-result-repository__title'></div>" +
    //                 "<div class='select2-result-repository__information'></div>" +
    //                 "<div class='select2-result-repository__statistics'>" +
    //                   "<div class='select2-result-repository__price'><i class='fa fa-flash'></i> </div>" +
    //                   "<div class='select2-result-repository__qyt'><i class='fa fa-star'></i> </div>" +
    //                 "</div>" +
    //             "</div>"
    //         );
    //         $container.find(".select2-result-repository__title").text(repo.name);
    //         $container.find(".select2-result-repository__information").text(repo.information);
    //         $container.find(".select2-result-repository__price").append("Rp. "+ repo.price_purchase);
    //         $container.find(".select2-result-repository__qyt").append(repo.quantity);

    //         return $container;
    //         // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
    //     },
    //     templateSelection: function (repo) {
    //         return repo.name || repo.text;
    //     }
    // });
});
</script>
<script src="{{ asset('js/stockDistribution.js')}}"></script>
@endpush
