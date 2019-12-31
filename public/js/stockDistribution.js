$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '#btn-create', function (e) {
	// alert('okok');
	e.preventDefault();
	const url = $(this).attr('href');
	// console.log(url);
	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html('Tambah Stok');
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	});
});


$('body').on('change', '#stock_id', function () {
	let data = $(this).val();
	$('#stockTarget').val(data);
});

$('body').on('submit', '#form-store', function (e) {
	e.preventDefault();
	
})