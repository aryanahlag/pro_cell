@extends('layouts.master', ["activePage" => "stock", "titlePage" => "Stok Barang" ])

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Keranjang</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary" id="btn-create"> --}}
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
@endsection