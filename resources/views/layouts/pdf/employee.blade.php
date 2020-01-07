@extends('layouts.pdf_template')

@section('content')
	<table>
		<thead>
		<tr>
			<th>No</th>
			<th>Nama Karyawan</th>
			<th>Alamat</th>
		</tr>
		</thead>
		<tbody>
			@foreach($employee as $data)
				<tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $data->name }}</td>
					<td>{{ $data->address }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
