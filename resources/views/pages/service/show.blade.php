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
			<p class="mb-3">{{ $data->total_price }}</p>
			<p class="mb-3">{{ $data->date_in }}</p>
			<a href="{{ route('employee.item.create', $data->id) }}" class="btn btn-primary btn-sm ml-auto">Tambah Item</a>
			<a href="{{ route('employee.service.pay', $data->id) }}" class="btn btn-success btn-sm ml-auto btn-pay">Bayar</a>
			{{-- <button type="button" class="btn btn-primary btn-sm float-right btn-item" data-url="{{ route('employee.item.create', $data->id) }}">Tambah Item</button> --}}
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