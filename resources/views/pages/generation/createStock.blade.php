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
        <div class="d-flex">
            <h4 id="total">Total Stock : </h4>
            <a href="javascript:void(0)" class="btn btn-info ml-auto mb-3 addRow"><i class="fa fa-plus"></i></a>
        </div>
        
            <div id="data">
                <div class="form-group">
                    <input type="text" name="name[]" class="form-control form-control-sm" id="name" autocomplete="off" placeholder="Nama Barang" required>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="code[]" class="form-control form-control-sm" placeholder="Kode Barang" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" min="1" name="quantity_p[]" class="form-control form-control-sm" placeholder="qty" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" min="1" name="price[]" class="form-control form-control-sm" placeholder="Harga Beli (Rp)" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="supplier">Suplier</label>
                            <select name="supplier[]" class="form-control form-control-sm" required>
                                @foreach($supplier as $q)
                                <option value="{{ $q->id }}">{{ $q->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select name="category[]" class="form-control form-control-sm" required>
                                @foreach($category as $q)
                                <option value="{{ $q->id }}">{{ $q->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="brand">Merek</label>
                            <select name="brand[]" class="form-control form-control-sm" required>
                                @foreach($brand as $q)
                                <option value="{{ $q->id }}">{{ $q->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="information">Information</label>
                    <textarea class="form-control form-control-sm" name="infomation[]" placeholder="(Jika Ada)"></textarea>
                </div>
            </div>{{-- --}}
        </div>
    </div>
</form>

@endsection
@push('js')
    <script>
        window.onload = init();
        let no = 1;
        function init() {
            const name = $('input[name="name[]"]');
            const code = $('input[name="code[]"]');
            const qty = $('input[name="qty[]"]');
            const price = $('input[name="price[]"]');
            const information = $('textarea[name="information[]"]');
            const total = $('#total');
            total.html('Total Stock : 1');
            name.val('');
            code.val('');
            qty.val('');
            price.val('');
            information.val('');
            name.focus();
        }
    $('.addRow').on('click',function(e){
        e.preventDefault();
        addRow();
        no++
        $('#total').html(`Total Stock : ${no}`);
    });
    function addRow()
    {
        let res = ``;
        res =   '<div class="major">' +
                   
                    '<div class="form-group"><input type="text" name="name[]" class="form-control form-control" id="name" autocomplete="off" placeholder="Nama Barang" required></div>'+
                    '<div class="row">' +
                        '<div class="col-md-4"><div class="form-group"><input type="text" name="code[]" class="form-control form-control-sm" required autocomplete="off" placeholder="Kode Barang" required></div></div>'+
                        '<div class="col-md-4"><div class="form-group"><input type="number" name="quantity_p[]" class="form-control form-control-sm" required autocomplete="off" placeholder="qty" min="1" required></div></div>'+
                        '<div class="col-md-4"><div class="form-group"><input type="number" name="price[]" class="form-control form-control-sm" required autocomplete="off" placeholder="Harga Beli (Rp)" min="1" required></div></div>'+
                    '</div>'+
                    '<div class="row">' +
                        `<div class="col-md-4"> <div class="form-gruop"><label for="supplier">Suplier</label>`+
                            `<select name="supplier[]" class="form-control form-control-sm" required>`+
                                `<option value="" disabled>Pilih Supplier</option>`+
                                @foreach ($supplier as $a)
                                    `<option value="{{ $a->id }}">{{ $a->name }}</option>`+
                                @endforeach
                            `</select>`+
                        `</div></div>`+
                        `<div class="col-md-4"> <div class="form-gruop"><label for="category">Kategori</label>`+
                            `<select name="category[]" class="form-control form-control-sm" required>`+
                                `<option value="" disabled>Pilih Kategori</option>`+
                                @foreach ($category as $a)
                                    `<option value="{{ $a->id }}">{{ $a->name }}</option>`+
                                @endforeach
                            `</select>`+
                        `</div></div>`+
                        `<div class="col-md-4"> <div class="form-gruop"><label for="brand">Merek</label>`+
                            `<select name="brand[]" class="form-control form-control-sm" required>`+
                                `<option value="" disabled>Pilih Merek</option>`+
                                @foreach ($brand as $a)
                                    `<option value="{{ $a->id }}">{{ $a->name }}</option>`+
                                @endforeach
                            `</select>`+
                        `</div></div>`+
                    '</div>'+
                    '<div class="form-group"><label for="information">Information</label><textarea class="form-control form-control-sm" name="infomation[]" placeholder="(Jika Ada)"></textarea></div>'+
                     `<div class="row">
                        <div class="col-md-11">
                            <hr>
                        </div  class="col-md-1">
                        <a href="javascript:void(0)" class="text-center text-danger remove">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>`+
                '</div>'
        $('#data').prepend(res);
        console.log($('input[name="name[]"]'));
    }
    $('body').on('click', ".remove", function(e) {
        e.preventDefault();
        let last = $('.major').length;
        $(this).parent().parent().remove();
        no--
        $('#total').html(`Total Stock : ${no}`);
    });
</script>
@endpush
