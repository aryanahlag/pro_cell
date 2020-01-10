@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Keranjang" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <a href="{{ route('admin.stock.single.create', ['generation'=>$generation->id]) }}" class="btn btn-info btn-sm" id="btn-create">
                    <i class="fa fa-plus"></i>
                    Buat Stock
                </a>
                <a href="{{ route('admin.stock.create', ['generation'=>$generation->id]) }}" class="btn btn-success btn-sm ml-3">
                    <i class="fa fa-plus"></i>
                    Buat Banyak Stock
                </a>
                <a href="{{ route('admin.generation.index') }}" class="btn btn-danger btn-sm ml-3">
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
                    <table class="table table-stripped" id="tableStockGeneration">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($stocks as $i => $stock)
                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td class="text-center">{{ $stock->code }}</td>
                                <td class="text-center">{{ $stock->name }}</td>
                                <td class="text-center">{{ $stock->status }}</td>
                                <td class="text-center">{{ $stock->quantity }}</td>
                                <td class="text-center">{{ $stock->price_purchase }}</td>
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
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#tableStockGeneration').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.stock.generation.data', ["generation" => $generation->id]) }}",
            columns: [
                { data: "DT_RowIndex", orderable: false, searchable: false },
                { data: "code" },
                { data: "name" },
                { data: "status" },
                { data: "quantity_p",render: function (a,b,c) {
                    let pk = Number(c.quantity_p);
                    let tbh = Number(c.quantity_tbh);
                    return pk + tbh;
                }},
                { data: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
<script src="{{ asset('js/stock.js') }}"></script>
@endpush
