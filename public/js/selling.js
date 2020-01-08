// $('*').off('keyup  keydown');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let findCode = $("#findCode");
let findName = $("#findName");
let qty = $("#qty");
let cash = $("#cash");
let tbody = $('#tbody');
let stockName = $('#stockName');
let price = $('#price');
let sid = $('#sid');
let totalShow = $('#total');
let no = tbody.length;
let form = $('#form'); 
window.onload = loaded();
function loaded() {
	findCode.val('');
	stockName.val('');
	price.val('');
	sid.val('');
	qty.val(1);
	totalShow.val(0);
	findCode.focus();
}
$('body').on('load', function () {
	
})
$(document).ready(function() {
	const body = $('body');
	window.onkeydown = function (e) {
		let key = e.keyCode;
		if (
			key == 112 || //f1 x
			key == 113 || //f2 x
			key == 114 || //f3 x
			key == 115 || //f4 x
			// key == 116 || //f5
			key == 117 || //f6
			key == 118 || //f7
			key == 119 || //f8
			key == 120 || //f9 x
			key == 121 || //f10 x
			key == 122 || //f11
			key == 123 //f12
			) {
			switch (key) {
				// findcode
				case 112:
					findCode.focus();
					break;
					// finename
				case 113:
					findName.focus();
					break;
				// qty
				case 114:
					if (!e.metaKey) {
						e.preventDefault();
					}
					qty.focus();
					break;
				// cash
				case 119:
					cash.focus();
					break;
				// input barang
				case 115:
				inputBar();

					break;
				// Bayar 
				case 121:
					form.submit();
					break;;

			}
		}
	} 
});

findCode.on('change', function () {
	const url = $(this).data('url');
	const data = $(this).val();
	$.ajax({
		url: url,
		type: "post",
		data: {
			code: data,
		},
		success: function (res) {
			stockName.val(res.name);
			price.val(res.price);
			sid.val(res.sd);
		},
		error: function (xhr) {
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

			// $.each(errors.errors, function(key, value){
			// 	$('#' + key)
			// 	.closest('.form-group .form-control')
			// 	.addClass('is-invalid')
			// 	$('#' + key)
			// 	.closest('.form-group')
			// 	.append(
			// 		`<span class="help-block">`+value+`</span>`
			// 	)
			// });
		}
	})
});
$('body').on('click', '#inputBarang', function (e) {
	e.preventDefault();
	inputBar()
})

$('body').on('click', '.rmv', function (e) {
	e.preventDefault();
	$(this).parent().parent().remove();
})

$('body').on('submit', '#form', function (e) {
	e.preventDefault();
	const data = $(this).serializeArray();
	const url = $(this).attr('action');
	$.ajax({
		url:url,
		type: 'post',
		data: data,
		success: function (res) {
			console.log('ok')
		}
	})
})

function toTable() {
	tbody.append(` 
		<tr>
            <input type="hidden" name="sd[]" value="${sid.val()}">
            <td>${tbody.length + 1}</td>
            <td>
                <input type="text" name="nama_barang[]" class="cl-line nama_barang" value="${stockName.val()}" readonly>
            </td>
            <td>
                <input type="text" name="qty[]" class="grey-line qty"  value="${qty.val()}">
            </td>
            <td>
                <input type="text" name="price[]" class="cl-line price" value="${price.val()}" readonly>
            </td>
            <td>
                <input type="text" name="sub-tot[]" class="cl-line sub-tot" value="${qty.val() * price.val()}" readonly>
            </td>
            <td>
                <input type="checkbox" name="grosir[]" value="0" class=""grosir>
            </td>
            <td>
                <a href="javascript:void(0)" class="rmv"><i class="fa fa-times text-danger"></i></a>
            </td>
        </tr>

	`);
	findCode.val('');
	stockName.val('');
	price.val('');
	sid.val('');
	qty.val(1);
	total();
	// $('.qty').on('keyup', function () {
	// 	alert($(this).val());
	// 	console.log($(this).parent().parent().parent());
	// })
	$('tbody').delegate('.qty', 'keyup', function() {
        var tr = $(this).parent().parent();
        var quantity = tr.find('.quantity').val();
        var budget = tr.find('.budget').val();
        var amount = (quantity * budget);
        tr.find('.amount').val(amount);
        total();
    });
}

function total() {
	let total_price = 0;
	$('.sub-tot').each(function(i, e) {
		var sub = $(this).val() - 0;
		total_price += sub;
	});
	totalShow.val(total_price);
}
function inputBar() {
	if (qty.val() == '') {
		Swal.fire({
			title:'Peringatan !',
			type:'warning',
			text: "Jumlah Tidak diketahui",
		});
	}else if (stockName.val() == '') {
		Swal.fire({
			title:'Peringatan !',
			type:'warning',
			text: "Tidak ada Barang",
		});
	}else{
		toTable();
	}
}

