<div class="container">
	<div class="row">
		<div class="col-md-5">
			<p class="mb-3">code :</p>
			<p class="mb-3">Nama :</p>
			<p class="mb-3">Jumlah :</p>
			<p class="mb-3">Harga Beli :</p>
			<p class="mb-3">Kategori :</p>
			<p class="mb-3">Merek :</p>
			<p class="mb-3">Keranjang :</p>
			<p class="mb-3">status :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3"><b>{{ $data->code }}</b></p>
			<p class="mb-3">{{ $data->name }}</p>
			<p class="mb-3">{{ $data->quantity_p + $data->quantity_tbh }}</p>
			<p class="mb-3">{{ $data->price_purchase }}</p>
			<p class="mb-3">{{ $data->category->name }}</p>
			<p class="mb-3">{{ $data->brand->name }}</p>
			<p class="mb-3">{{ $gen }}</p>
			<p class="mb-3"><b>{{ $data->status }}</b></p>
		</div>
	</div>
</div>