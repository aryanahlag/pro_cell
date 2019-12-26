@extends('layouts.master', ["activePage" => "pembelian", "titlePage" => "Buat Stok" ])

@section('content')
<form action="{{ route('admin.stock.store', ['generation'=>$generation->id]) }}" method="post">
@csrf
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Buat Stok</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button type="submit"class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                <a href="{{ route('admin.generation.show', ['id'=>$generation->id]) }}" style="margin-left:3px;" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                {{-- <th>Status</th> --}}
                                <th>Lainnya</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                {{-- <th>Harga Jual</th> --}}
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th><a href="javascript:void(0)" class="addRow"><i class="fa fa-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="code[]" class="form-control" required></td>
                                <td><input type="text" name="name[]" class="form-control" required></td>
                                {{-- <td><input type="text" name="status[]" class="form-control" value="unsold" readonly></td> --}}
                                <td><input type="text" name="information[]" class="form-control"></td>
                                <td><input type="number" min="1" name="quantity[]" class="form-control" required></td>
                                <td><input type="number" min="1" name="price_purchase[]" class="form-control" required></td>
                                {{-- <td><input type="number" min="1" name="price_sell[]" class="form-control" required></td> --}}
                                <td>
                                    <select name="category_id[]" id="" class="form-control" required>
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach (\App\Category::orderBy('name', 'asc')->get() as $t)
                                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                        <select name="brand_id[]" id="" class="form-control" required>
                                                <option value="" disabled>Pilih Merek</option>
                                                @foreach (\App\Brand::orderBy('name', 'asc')->get() as $a)
                                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                @endforeach
                                        </select>
                                </td>
                                <td>
                                    <a href="javascript:void(0)"  class="btn btn-danger" class="remove"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
@push('js')
    <script type="text/javascript">
    $('.addRow').on('click',function(e){
        e.preventDefault();
        addRow();
    });
    function addRow()
    {
        var tr='<tr>'+
                '<td><input type="text" name="code[]" class="form-control" required></td>'+
                '<td><input type="text" name="name[]" class="form-control" required></td>'+
                // '<td><input type="text" name="status[]" class="form-control" value="unsold" readonly></td>'+
                '<td><input type="text" name="information[]" class="form-control"></td>'+
                '<td><input type="number" min="1" name="quantity[]" class="form-control" required></td>'+
                '<td><input type="number" min="1" name="price_purchase[]" class="form-control" required></td>'+
                // '<td><input type="number" min="1" name="price_sell[]" class="form-control" required></td>'+
                `<td><select name="category_id[]" id="" class="form-control" required>
                    <option value="" disabled>Pilih Kategori</option>`+
                    @foreach (\App\Category::orderBy('name', 'asc')->get() as $a)
                        `<option value="{{ $a->id }}">{{ $a->name }}</option>`+
                    @endforeach
                    '</select></td>'+
                `<td><select name="brand_id[]" id="" class="form-control" required>
                    <option value="" disabled>Pilih Merek</option>`+
                    @foreach (\App\Brand::orderBy('name', 'asc')->get() as $a)
                        `<option value="{{ $a->id }}">{{ $a->name }}</option>`+
                    @endforeach
                    '</select></td>'+
                '<td><a href="javascript:void(0)" class="btn btn-danger removed"><i class="fa fa-trash"></i></a></td>'+
        '</tr>';
        $('tbody').append(tr);
    };

    $('body').on('click', ".removed", function(){
        var last=$('tbody tr').length;
        if(last==1){
            alert("Form input tidak bisa dihapus");
        }
        else{
             $(this).parent().parent().remove();
        }

    });
    // function myRemove() {
    //     var last=$('tbody tr').length;
    //     if(last==1){
    //         alert("Form input tidak bisa dihapus");
    //     }
    //     else{
    //         console.log($(this).parent());
    //          $(this).parent().parent().remove();
    //     }
    // }
</script>
@endpush
