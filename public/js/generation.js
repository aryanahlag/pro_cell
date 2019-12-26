$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '#btn-create', function(e) {
    // alert('okok');
    e.preventDefault();
    const url = $(this).attr('href');
    // console.log(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(res) {
            $('#myModal .modal-title').html('Tambah Merek');
            $('#myModal .modal-body').html(res);
            $('#myModal').modal('show');
        }
    });
});

$('body').on('submit', '#form-store', function(e) {
    e.preventDefault();
    const url = $(this).attr('action');
    const form = $(this).serializeArray();
    // me9889
    console.log(form);

    $('form').find('.form-group').removeClass('has-errors');
    $('form').find('.help-block').remove();

    $.ajax({
        url: url,
        type: 'POST',
        data: form,
        success: function(res) {
            $('#myModal').modal('hide');

            Swal.fire({
                title: 'Sukses !',
                type: 'success',
                text: res.msg,
                showConfirmButton: false,
                timer: 2000
            });

            $('#tableGeneration').DataTable().ajax.reload();
        },

        error: function(xhr) {

            if (xhr.status === 500) {
                Swal.fire({
                    title: 'Peringatan !',
                    type: 'warning',
                    text: "Terjadi Kesalahan",
                });
            }


            const errors = xhr.responseJSON;

            if (xhr.status === 401) {
                Swal.fire({
                    title: 'Peringatan !',
                    type: 'warning',
                    text: errors.msg,
                });
            }

            $.each(errors.errors, function (key, value) {
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

$('body').on('click', '.btn-edit', function(e) {
    // alert('okok');
    e.preventDefault();
    const url = $(this).attr('href');
    const title = $(this).attr('title');
    // console.log(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(res) {
            $('#myModal .modal-title').html('Edit ' + title);
            $('#myModal .modal-body').html(res);
            $('#myModal').modal('show');
        }
    });
});

$('body').on('submit', '#form-update', function(e) {
    e.preventDefault();
    const url = $(this).attr('action');
    const form = $(this).serializeArray();

    $('form').find('.form-group').removeClass('has-errors');
    $('form').find('.help-block').remove();

    $.ajax({
        url: url,
        type: 'POST',
        data: form,
        success: function(res) {
            $('#myModal').modal('hide');

            Swal.fire({
                title: 'Sukses !',
                type: 'success',
                text: res.msg,
                showConfirmButton: false,
                timer: 2000
            });

            $('#tableGeneration').DataTable().ajax.reload();
        },

        error: function(xhr) {

            if (xhr.status === 500) {
                Swal.fire({
                    title: 'Peringatan !',
                    type: 'warning',
                    text: "Terjadi Kesalahan",
                });
            }


            const errors = xhr.responseJSON;

            if (xhr.status === 401) {
                Swal.fire({
                    title: 'Peringatan !',
                    type: 'warning',
                    text: errors.msg,
                });
            }

            $.each(errors.errors, function(key, value) {
                $('#' + key)
                    .closest('.form-group')
                    .addClass('has-errors')
                    .append(
                        `<span class="help-block">` + value + `</span>`
                    )
            });
        }
    });
});

$('body').on('click', '.btn-delete', function(e) {
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
                        '_method': 'DELETE'
                    },
                    success: function(res) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableGeneration').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;

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

$('body').on('click', '.btn-verify', function(e) {
    e.preventDefault();

    const url = $(this).attr('href');

    const data = $(this).attr('title');

    Swal.fire({
            title: 'Verivikasi Ini ?',
            type: 'warning',
            text: data + ' Diverifikasi',
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
                        $('#myModal').modal('hide');

                        Swal.fire({
                            title: 'Sukses !',
                            type: 'success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 1800
                        });

                        $('#tableGeneration').DataTable().ajax.reload();
                    },

                    error: function(xhr) {
                        const error = xhr.responseJSON;

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
