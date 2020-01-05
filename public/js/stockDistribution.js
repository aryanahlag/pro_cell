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

			$('#tableStockDistribution').DataTable().ajax.reload();
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

$('body').on('click', ".btn-verify", function (e) {
	e.preventDefault();
	const url = $(this).attr('href');
	const data = $(this).attr('title');
	const cabang = $(this).data('cb');

	Swal.fire({
            title: 'Verivikasi Ini ?',
            type: 'warning',
            text: data + ' Diverifikasi di ' + cabang,
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Verfikasi !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'PUT'
                    },
                    success: function(res) {

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                        });

                        $('#tableStockDistributionSubmission').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        if (xhr.status === 401) {
							Swal.fire({
								title:'Peringatan !',
								type:'warning',
								text:error.msg,
							});
						}

                        if (xhr.status == 500) {
							Swal.fire({
	                            title: 'Peringatan !',
	                            type: 'warning',
	                            text: "Terjadi Kesalahan",
	                        });	
						}
                    }
                });
            }
        })
});
$('body').on('click', ".btn-reject", function (e) {
	e.preventDefault();
	const url = $(this).attr('href');
	const data = $(this).attr('title');
	const cabang = $(this).data('cb');

	Swal.fire({
            title: 'Verivikasi Ini ?',
            type: 'warning',
            text: data + ' Ditolak di ' + cabang,
            showCancelButton: true,
            confirmButtonColor: '#EF2E2E',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Tolak !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'POST'
                    },
                    success: function(res) {

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                        });

                        $('#tableStockDistributionSubmission').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        if (xhr.status === 401) {
							Swal.fire({
								title:'Peringatan !',
								type:'warning',
								text:error.msg,
							});
						}
						if (xhr.status == 500) {
							Swal.fire({
	                            title: 'Peringatan !',
	                            type: 'warning',
	                            text: "Terjadi Kesalahan",
	                        });	
						}
                        
                    }
                });
            }
        })
});
$('body').on('click', "#btn-refresh", function () {
	$('#tableStockDistribution').DataTable().ajax.reload();
})
$('body').on('click', "#btn-refresh-admin-sub", function () {
	$('#tableStockDistributionSubmission').DataTable().ajax.reload();
})