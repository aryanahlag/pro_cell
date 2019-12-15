<form action="{{ route('admin.cabang.store') }}" class="form-horizontal" method="POST" id="form-store">
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Cabang
		</label>
		<input type="text" name="name" class="form-control" id="name" autofocus autocomplete="off">
	</div>
	<div class="form-group">
		<label for="address">
			Alamat
		</label>
		<input type="text" name="address" class="form-control" id="address" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="date">
			Tanggal Dibuat
		</label>
		<input type="date" name="date" class="form-control" id="date" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>
