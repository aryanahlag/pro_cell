@extends('layouts.master', ["activePage" => "report-pembelian", "titlePage" => "Report Pembelian" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="" class="btn btn-success" id="btn-create">
                    <i class="fa fa-plus"></i>
                    Tambah Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
