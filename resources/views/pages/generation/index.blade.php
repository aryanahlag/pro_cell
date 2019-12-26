@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Keranjang" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
                <a href="{{ route('admin.generation.create') }}" class="btn btn-success" id="btn-create">
                    <i class="fa fa-plus"></i>
                    Tambah Keranjang
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableGeneration">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Tanggal Keranjang</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
{{--                 <tbody>
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
                            <form action="{{ route('admin.generation.destroy',['id'=>$gen->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <a href="{{ route('admin.generation.edit', ['id'=>$gen->id]) }}" class="btn  btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                <a href="{{ route('admin.generation.show', ['id'=>$gen->id]) }}" class="btn  btn-primary btn-sm"><i class="fa fa-share"></i> Detail</a>
                            </form>
                            <form action="{{ route('admin.generation.verify', $gen->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn sm"><i class="fa fa-check-square"></i> Verify</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#tableGeneration').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.generation.data') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "generation" },
            { data: "myTime" },
            { data: "allStock" },
            { data: "status" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/generation.js')}}"></script>
@endpush
