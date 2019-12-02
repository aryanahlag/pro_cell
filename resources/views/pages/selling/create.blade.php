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
    <div class="col-md-6" style="border:1px solid black;">
        <div class="card w-80">
            <div class="card-body">
                <h5 class="card-title">Barang</h5>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">F2 Cari Kode</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
            </div>

            <div class="card w-75">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Button</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        asdad
    </div>
</div>
</form>
@endsection
