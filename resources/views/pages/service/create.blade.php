<form action="{{ route('employee.service.store') }}" class="form-horizontal" method="POST" id="form-update">
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Pelanggan
		</label>
		<input type="text" name="customer_name" class="form-control" id="customer_name" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="name">
			Unit
		</label>
		<input type="text" name="unit" class="form-control" id="unit" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="name">
			DP
		</label>
		<input type="text" name="dp" class="form-control" id="dp" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>
