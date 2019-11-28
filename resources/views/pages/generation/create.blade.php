@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Keranjang" ])

@section('content')
<form action="{{ route('admin.generation.store') }}" method="post">
@csrf
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Tanggal</label>
                    <input type="date" name="time" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                    <div class="box">
                            <div class="box-header with-border">
                              <h3 class="box-title">Aksi</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save</button>
                                  </div>
                                  <div class="col-md-6">
                                    <a href="{{ route('admin.generation.index') }}" class="btn btn-danger btn-block"><i class="fa fa-times"></i> Cancel</a>
                                  </div>
                                </div>
                            </div>
                          </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
