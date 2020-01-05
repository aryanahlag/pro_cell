@extends('layouts.master', ["activePage" => "penjualan", "titlePage" => "Penjualan" ])
@section('content')
<form action="" method="post">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="total">
                <p class="lead">Total:</p>
                <br>
                <h2 class="">Rp. 1000.00</h2>
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
        <div class="col-md-9" style="border:1px solid black;">
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
                                <input type="text" class="form-control" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">F1 Cari Kode</span>
                                </div>
                            </div>
                            <input type="text" name="stockName" class="form-control" placeholder="Nama Barang">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="stockName" class="form-control" placeholder="Qyt (F3)">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="stockName" class="form-control" placeholder="Harga (Rp)">
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-block btn-sm mt-3"><i class="fa fa-plus"></i> Input Barang (F4)</button>
                        </div>
                        <!--  -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input type="number" name="cash" placeholder="Cash (F8)" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="number" name="cange" placeholder="Kembalian" class="form-control" disabled>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block">Bayar (F10)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script src="{{ asset('js/selling.js') }}"></script>
@endpush
