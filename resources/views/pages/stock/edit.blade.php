<form action="{{ route('admin.stock.update', ["generation" => $generation, "stock" => $stock->id]) }}" class="form-horizontal" method="POST" id="form-update">
	@csrf
	@method("PUT")
	<div class="form-group">
		<label for="code">
			code
		</label>
		<input type="text" name="code" class="form-control" id="code" autocomplete="off" value="{{ $stock->code }}">
	</div>
	<div class="form-group">
		<label for="name">
			name
		</label>
		<input type="text" name="name" class="form-control" id="name" autocomplete="off" value="{{ $stock->name }}">
	</div>
	<div class="form-group">
		<label for="quantity">
			Qyt
		</label>
		<input type="number" name="quantity" class="form-control" id="quantity" autocomplete="off" value="{{ $stock->quantity_p }}">
	</div>
	<div class="form-group">
		<label for="price_purchase">
			Harga Beli
		</label>
		<input type="number" name="price_purchase" class="form-control" id="price_purchase" autocomplete="off" value="{{ $stock->price_purchase }}">
	</div>
	<div class="form-group">
		<label for="category_id">
			Supplier
		</label>
		<select class="form-control" name="category_id">
			@foreach(\App\Supplier::all() as $q)
			<option value="{{ $q->id }}" {{ $q->id == $stock->supplier_id ? "selected" : "" }}>{{ $q->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="category_id">
			Kategori
		</label>
		<select class="form-control" name="category_id">
			@foreach($category as $q)
			<option value="{{ $q->id }}" {{ $q->id == $stock->category_id ? "selected" : "" }}>{{ $q->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="brand_id">
			Merek
		</label>
		<select class="form-control" name="brand_id">
			@foreach($brand as $q)
			<option value="{{ $q->id }}" {{ $q->id == $stock->brand_id ? "selected" : "" }}>{{ $q->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="information">
			Informasi
		</label>
		<textarea class="form-control" name="information">{{ $stock->information }}</textarea>
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
	</div>
</form>
