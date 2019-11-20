<form action="{{ route('brand.store') }}" class="form-horizontal" method="POST" id="form-store">
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Merek
		</label>
		<input type="text" name="name" class="form-control" id="name" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>