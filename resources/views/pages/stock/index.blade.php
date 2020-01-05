@extends('layouts.master', ["activePage" => "stock", "titlePage" => "Stok Barang" ])

@section('content')
{{-- stock generation --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableCategory">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Tanggal Keranjang</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($generation->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                    @endif
                    @foreach ($generation as $i =>$gen)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td class="text-center">{{ $gen->generation }}</td>
                        <td class="text-center">{{ $gen->time->format('d M Y') }}</td>
                        <td class="text-center"><i class="btn btn-facebook btn-sm">{{ $gen->status }}</i></td>
                        <td class="text-center">
                                <a href="{{ route('admin.generation.show', ['id'=>$gen->id]) }}" class="btn  btn-primary btn-sm"><i class="fa fa-share"></i> Detail</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    {{-- pengajuan Stock --}}
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Pengajuan Barang</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <button type="button" id="btn-refresh-admin-sub" class="btn btn-info btn-sm mr-3"><i class="fa fa-refresh"></i> Refresh</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-stripped" id="tableStockDistributionSubmission">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Cabang</th>
                                <th>Harga Jual Satuan (Rp)</th>
                                <th>Harga Jual Grosir (Rp)</th>
                                <th>Qyt</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- stok cabang --}}
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                Cabang
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-stripped" id="tableStockDistributionCabang">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
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
    $('#tableStockDistributionSubmission').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.stock-distribution.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "stock.name" },
            { data: "cabang.name" },
            { data: "price_sell" },
            { data: "price_grosir" },
            { data: "quantity" },
            { data: "status" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
    $('#tableStockDistributionCabang').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.stock-distribution.data.cabang') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name" },
            { data: "allStock" },
            // { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/stockDistribution.js') }}"></script>
@endpush
