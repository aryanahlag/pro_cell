<form action="{{ route('brand.update', $data->id) }}" class="form-horizontal" method="POST" id="form-update">
	{{ method_field('PUT') }}
	@csrf
	<div class="form-group">
		<label for="name">
			Nama Merek
		</label>
		<input type="text" name="name" class="form-control" id="name" autocomplete="off" value="{{ $data->name }}">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
	</div>
</form>