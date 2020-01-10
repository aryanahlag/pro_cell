<form action="{{ route('admin.suplier.update', $data->id) }}" method="POST" id="form-update">
	@csrf
	@method('PUT')
	{{-- <div class="form-group">
		<label for="code">Kode Suplier</label>
		<div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">SPY</span>
            </div>
            <input type="text" class="form-control" id="code" name="code" aria-describedby="inputGroup-sizing-default" autofocus>
        </div>
	</div> --}}
	<div class="form-group">
		<label for="name">Kode Suplier</label>
		<input type="text" class="form-control" id="code" value="{{ $data->code }}" disabled>
	</div>
	<div class="form-group">
		<label for="name">Nama Suplier</label>
		<input type="text" name="name" class="form-control" id="name" placeholder="Nama Suplier" autocomplete="off" value="{{ $data->name }}">
	</div>
	<div class="form-group">
		<label for="address">Alamat</label>
		<textarea name="address" class="form-control" id="address" placeholder="Alamat">{{ $data->address }}</textarea>
	</div>
	<div class="form-group">
		<label for="phone">Telepon</label>
		<input type="text" name="phone" class="form-control" id="phone" placeholder="Nomor Telepon" value="{{ $data->phone }}" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Edit</button>
	</div>
</form>