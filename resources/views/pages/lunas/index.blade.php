@extends('layouts.master', ["activePage" => "service", "titlePage" => "lunas" ])
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Servis</h4>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <a href="{{ route('employee.service.index', $slug) }}" class="btn btn-danger btn-sm mr-2">
                    <i class="fa fa-times"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped" id="tableService">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Nama Pelanggan
                        </th>
                        <th>
                            Unit 
                        </th>
                        <th>
                            Tanggal Keluar
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#tableService').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('service.lunasdata') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "customer_name" },
            { data: "unit" },
            { data: "tgl_keluar" },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<script src="{{ asset('js/service.js')}}"></script>
@endpush
