@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Keranjang" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <a href="{{ route('admin.stock.create', ['generation'=>$generation->id]) }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i>
                    Buat Stock
                </a>
                <a href="{{ route('admin.generation.index') }}" style="margin-left:3px" class="btn btn-danger btn-sm">
                        <i class="fa fa-times"></i>
                        Kembali
                    </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-stripped" id="tableCategory">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Harga Beli</th>
                                <th class="text-center">Harga Jual</th>
                                <th class="text-center">Lainnya</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($stocks->count() == 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                            @endif
                            @foreach ($stocks as $i => $stock)
                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td class="text-center">{{ $stock->code }}</td>
                                <td class="text-center">{{ $stock->name }}</td>
                                <td class="text-center">{{ $stock->status }}</td>
                                <td class="text-center">{{ $stock->quantity }}</td>
                                <td class="text-center">{{ $stock->price_purchase }}</td>
                                <td class="text-center">{{ $stock->price_sell }}</td>
                                <td class="text-center">{{ $stock->information }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.stock.destroy', ['generation_id'=>$stock->generation_id, 'stock'=>$stock->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('admin.stock.edit', ['generation_id'=>$stock->generation_id, 'stock'=>$stock->id]) }}" class="btn  btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
