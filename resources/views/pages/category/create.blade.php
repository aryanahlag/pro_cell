<form action="{{ route('admin.category.store') }}" class="form-horizontal" method="POST" id="form-store">
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Kategori
		</label>
		<input type="text" name="name" class="form-control" id="name" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>
