$.ajaxSetup({
	header: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

const token = $('meta[name="csrf-token"]').attr('content'); 

$('body').on('click', '#btn-create', function (e) {
	e.preventDefault();
	const url = $(this).attr('href');

	$.ajax({
		url: url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html('Tambah Supplier');
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
				// $('#code').focus();
			setTimeout(() => {
				$('#name').focus();
			}, 500);
		}
	})
});

$('body').on('click', '.btn-edit', function (e) {
	e.preventDefault();
	const url = $(this).attr('href');
	const title = $(this).attr('title');

	$.ajax({
		url:url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html('Edit'+ title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	})
})

$('body').on('submit', '#form-update', function (e) {
	e.preventDefault();
	const url = $(this).attr('action');
	const data = $(this).serializeArray();

	$('form').find('.form-group').removeClass('has-errors');
    $('form').find('.help-block').remove();

    $.ajax({
    	url: url,
    	type: 'post',
    	data: data,
    	success: function (res) {
    		$('#myModal').modal('hide');

    		Swal.fire({
    			title: 'Sukses !',
    			type: 'success',
    			text: res.msg,
				showConfirmButton: false,
				timer: 2000
			});

			$('#tableSuplier').DataTable().ajax.reload();
    	},
    	error: function (xhr) {
    		if (xhr.status == 500) {
    			Swal.fire({
	    			title: 'Peringatan !',
	    			type: 'warning',
	    			text: "terjadi Kesalahan",
					showConfirmButton: false,
					timer: 2000
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

			if (xhr.status == 422) {
				$.each(errors.errors, function(key, value){
					$('#' + key)
					.closest('.form-group .form-control')
					.addClass('is-invalid')
					$('#' + key)
					.closest('.form-group')
					.append(
						`<span class="help-block text-danger">`+value+`</span>`
					)
				});
			}
    	}
    })
});

$('body').on('submit', '#form-store', function (e) {
	e.preventDefault();
	const url = $(this).attr('action');
	const data = $(this).serializeArray();

	$('form').find('.form-group').removeClass('has-errors');
    $('form').find('.help-block').remove();

    $.ajax({
    	url: url,
    	type: 'post',
    	data: data,
    	success: function (res) {
    		$('#myModal').modal('hide');

    		Swal.fire({
    			title: 'Sukses !',
    			type: 'success',
    			text: res.msg,
				showConfirmButton: false,
				timer: 2000
			});

			$('#tableSuplier').DataTable().ajax.reload();
    	},
    	error: function (xhr) {
    		if (xhr.status == 500) {
    			Swal.fire({
	    			title: 'Peringatan !',
	    			type: 'warning',
	    			text: "terjadi Kesalahan",
					showConfirmButton: false,
					timer: 2000
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

			if (xhr.status == 422) {
				$.each(errors.errors, function(key, value){
					$('#' + key)
					.closest('.form-group .form-control')
					.addClass('is-invalid')
					$('#' + key)
					.closest('.form-group')
					.append(
						`<span class="help-block text-danger">`+value+`</span>`
					)
				});
			}
    	}
    })
});

$('body').on('click', '.btn-show', function (e) {
	e.preventDefault();
	const url = $(this).attr('href');
	const title = $(this).attr('title');

	$.ajax({
		url:url,
		dataType: 'html',
		success: function (res) {
			$('#myModal .modal-title').html("Detail" + title);
			$('#myModal .modal-body').html(res);
			$('#myModal').modal('show');
		}
	})
});

$('body').on('click', '#btn-delete', function (e) {
    e.preventDefault();

    const url = $(this).attr('href');

    const data = $(this).attr('title');

    Swal.fire({
            title: 'Anda Yakin ?',
            type: 'warning',
            text: data + ' Akan Dihapus Permanen',
            showCancelButton: true,
            confirmButtonColor: '#EF2E2E',
            cancelButtonColor: '#8A8A8A',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Batal',
        })
        .then(res => {
            if (res.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE',
                        '_token' : token
                    },
                    success: function (res) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableSuplier').DataTable().ajax.reload();
                    },

                    error: function (xhr) {
                        const error = xhr.responseJSON;
                        console.log(xhr);
                        Swal.fire({
                            title: 'Peringatan !',
                            type: 'warning',
                            text: error.msg,
                        });
                    }
                });
            }
        })
});

