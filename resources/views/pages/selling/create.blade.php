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
                    <p class="badge badge-warning" style="color:black;">F1 = Cari Barcode</p>
                    <p class="badge badge-warning" style="color:black;">F3 = Cari Barcode</p>
                    <p class="badge badge-warning" style="color:black;">F5 = Cari Barcode</p>
                </div>
                <div class="col-md-6">
                    <p class="badge badge-warning" style="color:black;">F2 = Cari Barcode</p>
                    <p class="badge badge-warning" style="color:black;">F4 = Cari Barcode</p>
                    <p class="badge badge-warning" style="color:black;">F6 = Cari Barcode</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">F2 Cari Nama</span>
                                </div>
                                <input type="text" class="form-control" id="findName" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" data-url="{{ route('employee.selling.fsbc') }}" aria-describedby="basic-addon2" id="findCode">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">F1 Cari Kode</span>
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
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="text" name="cash" id="cash" placeholder="Cash (F8)" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="number" name="change" id="change" placeholder="Kembalian" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block btn-sm">Bayar (F10)</button>
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
                    <th>Grosir</th>
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
@endsection
@push('js')
<script src="{{ asset('js/selling.js') }}"></script>
@endpush
