<div class="container">
	<div class="row">
		<div class="col-md-5">
			<p class="mb-3">Nama Pelanggan :</p>
			<p class="mb-3">Unit :</p>
			<p class="mb-3">DP :</p>
			<p class="mb-3">Harga :</p>
			<p class="mb-3">Tanggal Masuk :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3">{{ $data->customer_name }}</p>
			<p class="mb-3">{{ $data->unit }}</p>
			<p class="mb-3">{{ $data->dp }}</p>
			<p class="mb-3" id="totalPrice"><b>{{ $data->total_price }}</b></p>
			<p class="mb-3">{{ $data->date_in }}</p>
		</div>
	</div>
	<hr>
	<form action="{{ route("employee.service.pay", $data->id) }}" class="form-horizontal" id="form-pay" method="POST">
		@csrf
		@method("PUT")
		<div class="form-group">
			<label for="name">
				Bayar
			</label>
			<input type="number" name="pay" class="form-control pay" id="pay" autocomplete="off">
		</div>
		<input type="hidden" name="change" value="" id="change">
		<input type="hidden" name="change" value="" id="myPrice">
		<button type="submit" class="btn btn-primary btn-sm ml-auto">Bayar</button>
	</form>
</div>