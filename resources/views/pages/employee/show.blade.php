<div class="container">
	<div class="row">
		<div class="col-md-5">
			<p class="mb-3">Nama Pegawai :</p>
			<p class="mb-3">Tingkatan :</p>
			<p class="mb-3">Alamat :</p>
			<p class="mb-3">Cabang :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3">{{ $data->name }}</p>
			<p class="mb-3">{{ $data->level }}</p>
			<p class="mb-3">{{ $data->address }}</p>
			<p class="mb-3">{{ $data->cabang->name }}</p>
		</div>
	</div>
</div>