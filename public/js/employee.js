$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '#btn-create', function (e) {
	e.preventDefault();
	let url  = 	$(this).attr("href");

	$.ajax({
		url: url,
		dataType: "html",
		success: function (res) {
			$('#myModal .modal-title').html('Tambah Karyawan');
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	})
});

$('body').on('click', '.btn-show', function (e) {
	e.preventDefault();
	const url  = 	$(this).attr("href");
	const title =   $(this).attr("title");

	$.ajax({
		url: url,
		dataType: "html",
		success: function (res) {
			$('#myModal .modal-title').html('Detail '+ title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	})
});

$('body').on('click', '.btn-edit', function (e) {
	e.preventDefault();
	const url  = 	$(this).attr("href");
	const title =   $(this).attr("title");

	$.ajax({
		url: url,
		dataType: "html",
		success: function (res) {
			$('#myModal .modal-title').html('Detail '+ title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	})
});

$('body').on('click', '#btn-delete', function(e){
	e.preventDefault();

	const url = $(this).attr('href');

	const data = $(this).attr('title');

	Swal.fire({
		title:'Anda Yakin ?',
		type:'warning',
		text:data + ' Akan Dihapus Permanen',
		showCancelButton: true,
		confirmButtonColor:'#EF2E2E',
		cancelButtonColor:'#8A8A8A',
		confirmButtonText:'Ya, Hapus !',
		cancelButtonText:'Batal',
	})
	.then(res=>{
		if (res.value) {
			$.ajax({
				url:url,
				type:'POST',
				data: {
					'_method':'DELETE'
				},
				success: function(res){
					$('#myModal').modal('hide');

					Swal.fire({
						title:'Sukses !',
						type:'success',
						text:res.msg,
						showConfirmButton: false,
						timer: 1800
					});

					$('#tableEmployee').DataTable().ajax.reload();
				},

				error: function(xhr){
					const error = xhr.responseJSON;

					Swal.fire({
						title:'Peringatan !',
						type:'warning',
						text:error.msg,
					});
				}
			});
		}
	})
});

$('body').on("submit", "#form-store", function (e) {
	e.preventDefault();
	let url = $(this).attr("action");
	let data = $(this).serializeArray;

	$('form').find('.form-group').removeClass('has-errors');
	$('form').find('.help-block').remove();
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		success: function (res) {
			$('#myModal').modal('hide');

			Swal.fire({
				title:'Sukses !',
				type:'success',
				text:res.msg,
				showConfirmButton: false,
				timer: 2000
			});

			$('#tableEmployee').DataTable().ajax.reload();
		},
		error: function (xhr) {
			const errors = xhr.responseJSON;
			if (xhr.status === 500) {
				Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:"Terjadi Kesalahan",
				});
			}

			$.each(errors.errors, function(key, value){
				$('#' + key)
				.closest('.form-group')
				.addClass('has-errors')
				.append(
					`<span class="help-block">`+value+`</span>`
				)
			});
		}
	})
})
