@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Buat Stok" ])

@section('content')
<form action="{{ route('admin.stock.store') }}" method="post">
@csrf
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Buat Stok</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                            <th>Lainnya</th>
                            <th><a href="#" class="addRow"><i class="glyphicon glyphicon-plus"></i></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text"  class="form-control"></td>
                            <td><input type="text"  class="form-control"></td>
                            <td><input type="text"  class="form-control"></td>
                            <td><input type="text"  class="form-control" required=""></td>
                            <td><input type="text"  class="form-control"></td>
                            <td><input type="text"  class="form-control"></td>
                            <td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border: none"></td>
                            <td style="border: none"></td>
                            <td style="border: none"></td>
                            <td>Total</td>
                            <td><b class="total"></b> </td>
                            <td><input type="submit" name="" value="Submit" class="btn btn-success"></td>
                        </tr>
                    </tfoot>
                </table>
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
