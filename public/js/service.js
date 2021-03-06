$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('body').on('click', '#btn-create', function (e) {
	// alert('okok');
	e.preventDefault();
	const url = $(this).data('url');
	// console.log(url);
	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html('Tambah Service');
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	});
});

$('body').on('submit', '#form-store', function (e) {
	e.preventDefault();
	const url = $(this).attr('action');
	const form = $(this).serializeArray();

	$('form').find('.form-group').removeClass('has-errors');
	$('form').find('.help-block').remove();

	$.ajax({
		url:url,
		type:'POST',
		data: form,
		success: function(res){
			$('#myModal').modal('hide');

			Swal.fire({
				title:'Sukses !',
				type:'success',
				text:res.msg,
				showConfirmButton: false,
				timer: 2000
			});

			$('#tableService').DataTable().ajax.reload();
		},

		error: function(xhr){

			if (xhr.status === 500) {
				Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:"Terjadi Kesalahan",
				});
			}


			const errors = xhr.responseJSON;

			if (xhr.status === 401) {
				Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:errors.msg,
				});
			}

			$.each(errors.errors, function(key, value){
				$('#' + key)
				.closest('.form-group .form-control')
				.addClass('is-invalid')
				$('#' + key)
				.closest('.form-group')
				.append(
					`<span class="help-block">`+value+`</span>`
				)
			});
		}
	});
});

$('body').on('click', '.btn-show', function (e) {
	// alert('okok');
	e.preventDefault();
	const url = $(this).attr('href');
	const title = $(this).attr('title');
	// console.log(url);
	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html(title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	});
});

$('body').on('click', '.btn-edit', function (e) {
	e.preventDefault();
	// alert('okok');	
	const url = $(this).attr('href');
	const title = $(this).attr('title');
	// console.log(url);
	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html(`Edit `+title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	});
});

$('body').on('submit', '#form-update', function (e) {
	e.preventDefault();
	const url = $(this).attr('action');
	const form = $(this).serializeArray();

	$('form').find('.form-group').removeClass('has-errors');
	$('form').find('.help-block').remove();

	$.ajax({
		url:url,
		type:'POST',
		data: form,
		success: function(res){
			$('#myModal').modal('hide');

			Swal.fire({
				title:'Sukses !',
				type:'success',
				text:res.msg,
				showConfirmButton: false,
				timer: 2000
			});

			$('#tableService').DataTable().ajax.reload();
		},

		error: function(xhr){

			if (xhr.status === 500) {
				Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:"Terjadi Kesalahan",
				});
			}


			const errors = xhr.responseJSON;

			if (xhr.status === 401) {
				Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:errors.msg,
				});
			}

			$.each(errors.errors, function(key, value){
				$('#' + key)
				.closest('.form-group .form-control')
				.addClass('is-invalid')
				$('#' + key)
				.closest('.form-group')
				.append(
					`<span class="help-block">`+value+`</span>`
				)
			});
		}
	});
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

					$('#tableService').DataTable().ajax.reload();
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
// ===================================== \\ Pay \\ ========================================
$("body").on("click", ".btn-pay", function (e) {
	e.preventDefault();
	$('#myModal').modal('hide');
	let url = $(this).attr("href");
	$.ajax({
		"url" : url,
		"dataType": "html",
		success: function (res) {
			
			$('#myModal .modal-title').html(`Pembayaran`);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		},
		errors: function (xhr) {
			const error = xhr.responseJSON;	
			Swal.fire({
				title:'Peringatan !',
				type:'warning',
				text:error.msg,
			});
		}
	})
	// alert("okok");
});

$("body").on("keyup", ".pay", function () {
	let pay = $(this).val();
	let totalPrice = $("#totalPrice b").html();
	$("#change").val(pay - totalPrice)
	$("#myPrice").val(totalPrice)
});

$("body").on("submit", "#form-pay", function (e) {
	e.preventDefault();
	// alert("okok");
	let url = $(this).attr("action");
	let urlCetak = $(this).data("cetak");
	let data = $(this).serializeArray();
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
				timer: 1800
			});
			window.open(urlCetak, '_blank');
			$('#tableService').DataTable().ajax.reload();
		},
		error: function (xhr) {
			const error = xhr.responseJSON;
			// console.log(error);
			if (xhr.status == 422) {
					Swal.fire({
					title:'Peringatan !',
					type:'warning',
					text:error.errors,
				});
			}
		},
	})
});

$('body').on('click', ".btn-lunas-show", function (e) {
	e.preventDefault();
	const url = $(this).attr('href');
	const title = $(this).attr('title');
	// console.log(url);
	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html(title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	});
})




// ===================================== \\ item service \\ ========================================
$("body").on("click", ".btn-item", function () {
	$('#myModal').modal('hide');
	let url = $(this).data("url");
	$.ajax({
		"url" : url,
		"dataType": "html",
		success: function (res) {
			$('#myModal .modal-title').html(`Tambah Item`);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		},
		errors: function () {
			alert("asdasdas");
		}
	})
	// alert("okok");
});

