@extends('layouts.pdf_template')

@section('content')
	<table>
		<thead>
		<tr>
			<th>No</th>
			<th>Nama Toko</th>
			<th>Alamat</th>
			<th>Tanggal Dibuat</th>
		</tr>
		</thead>
		<tbody>
			@foreach($cabang as $data)
				<tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $data->name }}</td>
					<td>{{ $data->address }}</td>
					<td>{{ $data->date }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
