<div class="container">
	<div class="row">
		<div class="col-md-5">
			<p class="mb-3">Nama Pelanggan :</p>
			<p class="mb-3">Unit :</p>
			<p class="mb-3">DP :</p>
			<p class="mb-3">Harga :</p>
			<p class="mb-3">Tanggal Masuk :</p>
			<p class="mb-3">Tanggal Keluar :</p>
			<p class="mb-3">Bayar :</p>
			<p class="mb-3">Kembalian :</p>
		</div>
		<div class="col-md-7">
			<p class="mb-3">{{ $data->customer_name }}</p>
			<p class="mb-3">{{ $data->unit }}</p>
			<p class="mb-3">{{ $data->dp }}</p>
			<p class="mb-3">{{ $data->total_price }}</p>
			<p class="mb-3">{{ $data->date_in }}</p>
			<p class="mb-3">{{ $data->date_out }}</p>
			<p class="mb-3">{{ $data->pay }}</p>
			<p class="mb-3">{{ $data->change }}</p>
		</div>
	</div>
	<hr>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<td>Item</td>
					<td>Qyt</td>
					<td>Harga</td>
				</tr>
			</thead>
			<tbody>
				@foreach($data->item_service as $q)
				<tr>
					<td>{{ $q->name }}</td>
					<td>{{ $q->quantity }}</td>
					<td>{{ $q->price }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>