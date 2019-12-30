@extends('layouts.master', ["activePage" => "service", "titlePage" => "Service" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h4>Item Servis</h4>
        <a href="{{ route('employee.service.index', $slug) }}" class="btn btn-sm btn-danger ml-auto"><i class="fa fa-times"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('employee.item.store', $service_id) }}" class="form-horizontal" method="POST" id="form-update">
            @csrf
            <div id="data">
                <div class="form-group">
                    <input type="text" name="name[]" class="form-control" id="name" autocomplete="off" placeholder="Nama" value="Biaya Service">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" min="1" name="quantity[]" class="form-control" id="quantity" autocomplete="off" placeholder="Qyt" value="1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" value="25000" name="price[]" class="form-control" id="price" autocomplete="off" placeholder="harga">
                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" class="badge badge-info ml-auto addRow"><i class="fa fa-plus"></i></a>
            <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
            <div class="d-flex">
                <button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
$('.addRow').on('click', function(e) {
    e.preventDefault();
    addRow();
});

function addRow() {
	let res = "";
    res = ` 
			<div class="major">
            <div class="row">
                <div class="col-md-11">
                    <hr>
                </div  class="col-md-1">
                <a href="javascript:void(0)" class="text-center remove">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        <div class="form-group">
            <input type="text" name="name[]" class="form-control" placeholder="Nama Item" id="name" autocomplete="off">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="quantity[]" placeholder="Qyt" class="form-control" id="quantity" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="price[]" placeholder="Harga" class="form-control" id="price" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
        `;
    $('#data').append(res);
};
$('body').on('click', ".remove", function(e) {
	e.preventDefault();
    let last = $('.major').length;
    console.log($(this).parent())
    $(this).parent().parent().remove();
	// console.info(last);
    // if (last == 1) {
    //     alert("Form input tidak bisa dihapus");
    // } else {
    //     $(this).parent().remove();
    // }
});

</script>
@endpush
