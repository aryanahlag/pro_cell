<form action="{{ route('admin.cabang.update', $data->id) }}" class="form-horizontal" method="POST" id="form-update">
	{{ method_field('PUT') }}
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Cabang
		</label>
		<input type="text" name="name" class="form-control" id="name" autofocus autocomplete="off" value="{{ $data->name }}">
    </div>
    <div class="form-group">
		<label for="address">
			Alamat
		</label>
		<input type="text" name="address" class="form-control" id="address" autocomplete="off" value="{{ $data->address }}">
	</div>
	<div class="form-group">
		<label for="date">
			Tanggal Dibuat
		</label>
		<input type="date" name="date" class="form-control" id="date" autocomplete="off" value="{{ $data->date }}">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
	</div>
</form>
