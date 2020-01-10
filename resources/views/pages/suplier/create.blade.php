<form action="{{ route('admin.suplier.store') }}" method="POST" id="form-store">
	@csrf
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
		<label for="name">Nama Suplier</label>
		<input type="text" name="name" class="form-control" id="name" placeholder="Nama Suplier" autocomplete="off">
	</div>
	<div class="form-group">
		<label for="address">Alamat</label>
		<textarea name="address" class="form-control" id="address" placeholder="Alamat"></textarea>
	</div>
	<div class="form-group">
		<label for="phone">Telepon</label>
		<input type="text" name="phone" class="form-control" id="phone" placeholder="Nomor Telepon" autocomplete="off">
	</div>
	<div class="d-flex">
		<button type="submit" class="btn btn-primary ml-auto" id="action-primary">Tambah</button>
	</div>
</form>