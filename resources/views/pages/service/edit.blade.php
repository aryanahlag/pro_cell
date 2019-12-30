<form action="{{ route('employee.service.update', ['service' => $data->id]) }}" class="form-horizontal" method="POST" id="form-store">
	@csrf
	@method("PUT")
	<div class="form-group">
		<label for="name">
			Nama Pelanggan
		</label>
		<input type="text" name="customer_name" class="form-control" id="customer_name" autocomplete="off" value="{{ $data->customer_name }}">
	</div>
	<div class="form-group">
		<label for="name">
			Unit
		</label>
		<input type="text" name="unit" class="form-control" id="unit" autocomplete="off" value="{{ $data->unit }}">
	</div>
	<div class="form-group">
		<label for="name">
			DP
		</label>
		<input type="text" name="dp" class="form-control" id="dp" autocomplete="off" value="{{ $data->dp }}">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
	</div>
</form>
