@extends('layouts.master', ["activePage" => "penjualan", "titlePage" => "Penjualan" ])
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/selling.css') }}">
@endpush
{{-- <form action="{{ route('employee.selling.store') }}" id="form" method="post"> --}}
    <div class="row">
        <div class="col-md-3">
            <div class="total">
                <p class="lead">Total:</p>
                <br>
                <h2 class="d-flex">Rp. <input type="text" id="total" class="cl-line tot" name="total" readonly></h2>
            </div>
            <br>
            <sup><i class="fa fa-keyboard"></i> Shortcut Keyboard</sup>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <p class="badge badge-warning" style="color:black;">(F1) = Cari Barcode</p>
                    <p class="badge badge-warning" style="color:black;">(F3) = Masukan Qty</p>
                    <p class="badge badge-warning" style="color:black;">(F8) = Cash</p>
                </div>
                <div class="col-md-6">
                    <p class="badge badge-warning" style="color:black;">(F2) = Cari Barang</p>
                    <p class="badge badge-warning" style="color:black;">(F4) = Input Barang</p>
                    <p class="badge badge-warning" style="color:black;">(F7) = Potongan</p>
                    <p class="badge badge-warning" style="color:black;">(+) = Bayar</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">F2 Cari Nama</span>
                                </div>
                                <input type="text" class="form-control" id="findName" aria-describedby="inputGroup-sizing-default">
                            </div> --}}
                            <button type="button" class="btn btn-block btn-light btn-sm mb-3" data-toggle="modal" data-target="#modal-stock" id="findName"><i class="fa fa-search"></i> Cari Barang (F2) </button>
                            <div class="input-group">
                                <input type="text" class="form-control" data-url="{{ route('employee.selling.fsbc') }}" aria-describedby="basic-addon2" id="findCode">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Cari Kode (F1) <i class="ml-3 fa fa-spinner loaded hide"></i></span>
                                </div>
                            </div>
                            <input type="text" name="stockName" id="stockName" class="form-control form-control-sm" placeholder="Nama Barang" readonly>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="qty" id="qty" class="form-control form-control-sm" placeholder="Qty (F3)" autosave="off">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Harga (Rp)" readonly>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-block btn-sm mt-3" id="inputBarang"><i class="fa fa-plus"></i> Input Barang (F4)</button>
                        </div>
                        {{-- form awal --}}
                        {{-- <form class=""> --}}
                        {{--  --}}
                        <!--  -->
                        <div class="col-md-6 text-center">
                            {{-- <i class="fa fa-spinner loaded hide"></i> --}}
                            <div class="form-group mb-3">
                                <input type="text" name="cash" id="cash" placeholder="Cash (F8)" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" name="potongan" id="potongan" placeholder="Potongan (F7)" value="0" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="change" id="change" placeholder="Kembalian" class="form-control" readonly>
                            </div>
                            <button type="submit" id="bayar" class="btn btn-warning btn-block btn-sm">Bayar (F10)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sid">
    <hr>
    <div class="table-responsive">
        <form action="{{ route('employee.selling.store') }}" id="form" method="post">
        <input type="hidden" name="cash" id="hd_cash">
        <input type="hidden" name="total" id="hd_total">
        <input type="hidden" name="potong" id="hd_potongan">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                    {{-- <th>Grosir</th> --}}
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
        </form>
    </div>
    {{-- form akhir --}}
    {{-- </form> --}}
    {{--  --}}
{{-- </form> --}}
<!-- Modal -->
<div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title stock" id="exampleModalScrollableTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body stock">
        {{-- <div class="table-responsive"> --}}
            <table id="tableStock" class="table table-stripped" style="width: 100%">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Harga Satuan</th>
                        <th>Harga Grosir</th>
                        <th>*</th>
                    </tr>
                </thead>       
            </table>
        {{-- </div> --}}
      </div>
      <div class="modal-footer stock">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">&times; Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready( function () {
        $('#tableStock').DataTable({
            "ajax" : "{{ route('selling.stockDataSelling') }}",
            "columns" : [
                {"data" : "code", render : function (a, b, c) {
                    return `<span data-s-code="${c.code}" class="s-code">${c.code}</span>`;
                }},
                {"data" : "stock.name", render : function (a,b,c) {
                    return `<span data-s-name="${c.name}" class="s-name">${c.name}</span>`;
                }},
                {"data" : "price_sell", render : function (a,b,c) {
                     return `<span data-s-price="${c.price_sell}" class="s-price">${c.price_sell}</span>`;
                }},
                {"data" : "price_grosir", render: function (a,b,c) {
                    return `<span data-s-grosir="${c.price_grosir}" class="s-grosir">${c.price_grosir}</span>`;
                }},
                {"data" : "stock_id", render: function (a,b,c) {
                    return `<a href="javascript:void(0)" class="select-stock badge badge-info" data-s-sid="${c.stock_id}" data-s-sd="${c.id}"><i class="fa fa-check-circle"></i> Pilih</a>`
                }},
            ]
        });
    });
</script>
<script src="{{ asset('js/selling.js') }}"></script>
@endpush
