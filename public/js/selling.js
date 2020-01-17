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
	setCookie('qty', 0, 1);
}
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
			key == 123 || //f12
			key == 107 // plus di keyboard komputer di atas enter
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
				case 107:
					let target = e.explicitOriginalTarget;
					// let str = target.value;
					setTimeout(() => {
						let str = document.getElementById('cash').value
						let n = str.length;
						let res = str.replace('+', ''); 
						$('#cash').val(res);
						console.log(res);
					}, 100)

					break;

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
	// console.log(e.keyCode);
	e.preventDefault();
	const data = $(this).serialize();
	console.info(data);
	const url = $(this).attr('action');
	$.ajax({
		url:url,
		type: 'post',
		data: data,
		success: function (res) {
			console.log('ok')
		}
	})
});
$('body').on('change', '.qty', function () {
	let qty = $(this).val();
	let price = $(this).parent().parent().find('.price').val()
	$(this).parent().parent().find('.sub-tot').val(qty*price);
	total()
})
i = 1;
function toTable() {
	let there = $(`[data-code=${findCode.val()}]`);
	if (there.length != 0) {
		let thereQty = there.find('.qty').val();
		let ress = parseInt(thereQty) + parseInt(qty.val());
		there.find('.qty').val(ress);
		there.find('.sub-tot').val(ress * parseInt(there.find('.price').val()))

	}else{
		tbody.prepend(` 
			<tr data-code="${findCode.val()}">
	            <input type="hidden" name="sd[]" value="${sid.val()}">
	            <td>${i++}</td>
	            <td>
	                <input type="text" name="code[]" class="cl-line code" value="${findCode.val()}" readonly>
	            </td>
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
	}
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

setInterval(()=> {
	// console.log(1)
	$('#hd_cash').val(cash.val())
	$('#hd_total').val($("#total").val())
},300)

function setCookie(name, value, daysToLive) {
    // Encode value in order to escape semicolons, commas, and whitespace
    var cookie = name + "=" + encodeURIComponent(value);

    if (typeof daysToLive === "number") {
        /* Sets the max-age attribute so that the cookie expires
        after the specified number of days */
        cookie += "; max-age=" + (daysToLive * 24 * 60 * 60);

        document.cookie = cookie;
    }}
function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");

    // Loop through the array elements
    for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");

        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if (name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }

    // Return null if not found
    return null;}