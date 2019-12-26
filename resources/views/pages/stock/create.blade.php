<form action="{{ route('admin.stock.create.single.store', ["generation" => $generation]) }}" class="form-horizontal" method="POST" id="form-store">
	@csrf
	<div class="form-group">
		<label for="code">
			code
		</label>
		<input type="text" name="code" class="form-control" id="code" autocomplete="off">
		<span class="text-danger">*</span><span class="text-muted h6">Code Diketik</span>
	</div>
	<div class="form-group">
		<label for="name">
			name
		</label>
		<input type="text" name="name" class="form-control" id="name" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="quantity">
			Qyt
		</label>
		<input type="number" name="quantity" class="form-control" id="quantity" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="price_purchase">
			Harga Beli
		</label>
		<input type="number" name="price_purchase" class="form-control" id="price_purchase" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="category_id">
			Kategori
		</label>
		<select class="form-control" name="category_id">
			@foreach($category as $q)
			<option value="{{ $q->id }}">{{ $q->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="brand_id">
			Merek
		</label>
		<select class="form-control" name="brand_id">
			@foreach($brand as $q)
			<option value="{{ $q->id }}">{{ $q->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="information">
			Informasi
		</label>
		<textarea class="form-control" name="information"></textarea>
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>
