<form action="{{ route('admin.stock.store.tbh', ["generation" => $gen, "stock" => $data->id]) }}" class="form-horizontal" method="POST" id="form-update">
	@csrf
	@method("PUT")
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="code">
					code
				</label>
				<input type="text" name="code" class="form-control" id="code" autocomplete="off" value="{{ $data->code }}" disabled>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name">
					name
				</label>
				<input type="text" name="name" class="form-control" id="name" autocomplete="off" value="{{ $data->name }}" disabled>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="quantity">
					Qty Awal
				</label>
				<input type="number" name="quantity" class="form-control" id="quantity" autocomplete="off" value="{{ $data->quantity_p }}" disabled>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="price_purchase">
					Harga Beli
				</label>
				<input type="number" name="price_purchase" class="form-control" id="price_purchase" autocomplete="off" value="{{ $data->price_purchase }}" disabled>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="tbh">Qty Tambahan</label>
		<input type="text" name="tbh" class="form-control" id="tbh">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>
