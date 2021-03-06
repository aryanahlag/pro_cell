@if(Auth::user()->role == "admin")
<form action="{{ route('admin.stock-distribution.storeShipment') }}" class="form-horizontal" method="POST" id="form-store">
    <div class="form-group">
        <label for="cabang">Cabang</label>
        <select name="cabang" class="form-control" id="cabang" data-url-check="{{ route('stock-distribution.check') }}">
            @foreach(\App\Cabang::orderBy('name', 'asc')->get() as $q)
            <option value="{{ $q->id }}" {{ $loop->index == 1 ? 'selected' : '' }}>{{ $q->name }}</option>
            @endforeach
        </select>
    </div>
@else
<form action="{{ route('employee.stock-distribution.storeSingle') }}" class="form-horizontal" method="POST" id="form-store">
@endif
	@csrf
	<div class="form-group">
		<label for="name">
			Stok
		</label>
		<select id="stock_id" class="form-control" style="width: 100%" data-url-check="{{ route('stock-distribution.check') }}"></select>
	</div>
	<div class="form-group">
		<label for="quantity" class="d-flex justify-content-between">
			<span>Qyt</span> 
            <b id="sisa"></b>
		</label>
		<input type="number" min="1" name="quantity" class="form-control" id="quantity" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="price_sell" class="d-flex justify-content-between">
			<span>Harga Jual</span> 
            <a href="javascript:void(0)" class="float-right" id="jual"></a>
		</label>
		<input type="number" min="1" name="price_sell" class="form-control" id="price_sell" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="price_grosir" class="d-flex justify-content-between">
			<span>Harga Grosir</span> <a href="javascript:void(0)" class="float-right" id="grosir"></a>
		</label>
		<input type="number" min="1" name="price_grosir" class="form-control" id="price_grosir" autocomplete="off">
	</div>
    <div class="form-group">
        <label for="information">
            Information
        </label>
        <textarea name="information" class="form-control" id="information"></textarea>
    </div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
	<input type="hidden" name="stock_id" value="" id="stockTarget">
</form>
<script>
	$(document).ready(function () {
		$('#stock_id').select2({
        ajax: {
            url: "{{ route('stock-distribution.sel2') }}",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                };
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Cari Stok Barang',
        // minimumInputLength: 1,
        templateResult: function (repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
            	"<div class='select2-result-repository clearfix'>" +
	            	'<div class="select2-result-stock__title"></div>' +
	            	'<p class="select2-result-stock__information"></p>' +
	            	'<div class="row">' +
	            		'<div class="col-md-4 select2-result-stock__price"></div>' +
	            		'<div class="col-md-4 select2-result-stock__qyt"><i class="fa fa-archive"></i> </div>' +
	            	'</div>'+
	            '</div>'
            	);

            $container.find(".select2-result-stock__title").text(repo.name);
            $container.find(".select2-result-stock__information").text(repo.information);
            $container.find(".select2-result-stock__price").append("Rp. "+ repo.price_purchase);
            $container.find(".select2-result-stock__qyt").append(repo.quantity);

            return $container;
            // return repo.name+"<br>"+"<span>Qyt : "+repo.quantity+"</span>";
        },
        templateSelection: function (repo) {
        	$container = $(`<div class="selectionResult">
					<div class="selectionResult__general"></div>
        		</div>`)
        	$container.find('.selectionResult__general').html(
        			repo.name+
        			'&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fa fa-archive text-info"></i> ' + repo.quantity + 
        			'&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fas fa-money-bill-wave text-success"></i> ' + repo.price_purchase
    			)
        	if (repo.name == undefined && repo.quantity == undefined) {
        		return repo.text
        	}
            // return repo.name+'&nbsp&nbsp<i class="fa fa-archive"></i> '+repo.quantity || repo.text;
            return $container || repo.text
        }
    });
	})
</script>
