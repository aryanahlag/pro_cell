@extends('layouts.master', ["activePage" => Auth::user()->role == 'employee' ? "stock-distribution" : "pengiriman", "titlePage" => "Stock Distribution" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h4>Barang Toko</h4>
        @if(Auth::user()->role == 'employee')
        <a href="{{ route('stock-distribution.index', $slug) }}" class="btn btn-sm btn-danger ml-auto"><i class="fa fa-times"></i> Kembali</a>
        @elseif(Auth::user()->role == 'admin')
        <a href="{{ route('admin.stock-distribution.shipment.index') }}" class="btn btn-sm btn-danger ml-auto"><i class="fa fa-times"></i> Kembali</a>
        @endif
    </div>
    <div class="card-body">
        <div class="d-flex">
            <h4 id="total">Total Stock : </h4>
            <a href="javascript:void(0)" class="btn btn-info ml-auto mb-3 addRow"><i class="fa fa-plus"></i></a>
        </div>
        <form action="{{ route('stock-distribution.store') }}" class="form-horizontal" method="POST" id="form-update">
            @csrf
            <div id="data">
                <div class="form-group">
                    <select  class="form-control select-stock" name="stock[]" style="width: 100%"></select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" min="1" name="quantity[]" class="form-control" id="quantity" autocomplete="off" placeholder="Qyt">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="price_sell[]" class="form-control" id="price_sell" autocomplete="off" placeholder="Harga Jual">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="price_grosir[]" class="form-control" id="price_grosir" autocomplete="off" placeholder="Harga Grosir">
                        </div>
                    </div>
                </div>
            </div>
            
            
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    let no = 1;
    window.onload = init();
    function init() {
        $('#total').html('Total Barang : '+no)
    }
$('.addRow').on('click', function(e) {
    e.preventDefault();
    addRow();
    no++
    $('#total').html(`Total Barang : ${no}`);
});

function addRow() {
    let res = "";
    res = $(` 
        <div class="major">
            
            <div class="form-group">
                <select  class="form-control select-stock" name="stock_id[]" style="width: 100%"></select>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="number" min="1" name="quantity[]" class="form-control" id="quantity" autocomplete="off" placeholder="Qyt">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="price_sell[]" class="form-control" id="price_sell" autocomplete="off" placeholder="Harga Jual">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="price_grosir[]" class="form-control" id="price_grosir" autocomplete="off" placeholder="Harga Grosir">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <hr>
                </div  class="col-md-1">
                <a href="javascript:void(0)" class="text-center remove">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
        `);
    res.find('.select-stock').select2(setupSelect2)
    $('#data').prepend(res);
    // mySelect();
};
$('body').on('click', ".remove", function(e) {
    e.preventDefault();
    let last = $('.major').length;
    $(this).parent().parent().remove();
    no--;
    $('#total').html(`Total Stock : ${no}`);
});
function mySelect() {
    $('.select-stock').select2(setupSelect2);
}

const setupSelect2 = {
        ajax: {
            url: "{{ route('stock-distribution.sel2') }}",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            }
        },
        placeholder: 'Cari Stok Barang',
        // minimumInputLength: 1,
        templateResult: function(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                '<div class="select2-result-stock__title"></div>' +
                '<p class="select2-result-stock__information"></p>' +
                '<div class="row">' +
                '<div class="col-md-4 select2-result-stock__price"></div>' +
                '<div class="col-md-4 select2-result-stock__qyt"><i class="fa fa-archive"></i> </div>' +
                '</div>' +
                '</div>'
            );

            $container.find(".select2-result-stock__title").text(repo.name);
            $container.find(".select2-result-stock__information").text(repo.information);
            $container.find(".select2-result-stock__price").append("Rp. " + repo.price_purchase);
            $container.find(".select2-result-stock__qyt").append(repo.quantity);

            return $container;
            // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
        },
        templateSelection: function(repo) {
            $container = $(`<div class="selectionResult">
                    <div class="selectionResult__general"></div>
                </div>`)
            $container.find('.selectionResult__general').html(
                repo.name +
                '&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fa fa-archive text-info"></i> ' + repo.quantity +
                '&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fas fa-money-bill-wave text-success"></i> ' + repo.price_purchase
            )
            if (repo.name == undefined && repo.quantity == undefined) {
                return repo.text
            }
            // return repo.name+'&nbsp&nbsp<i class="fa fa-archive"></i> '+repo.quantity || repo.text;
            return $container || repo.text
        }}
$(document).ready(function() {
    mySelect();
})



</script>
@endpush
