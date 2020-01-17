@extends('layouts.master', ["activePage" => "dashboard", "titlePage" => "Dashboard" ])

@section('content')
    @if (!Auth::guest())
        @if (Auth::user()->role == 'admin')
            <h1>Halo Admin</h1>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Blalal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        asdasdasdasdad
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Blalal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        asdasdasdasdad
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Blalal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        asdasdasdasdad
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-1">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Blalal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        asdasdasdasdad
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Chart Penjualan</h3>
                    </div>
                        <div class="chart-container" style="position: relative; height:50vh; width:100vh">
                            <canvas id="bar"></canvas>
                        </div>
                </div>
            </div>
        @elseif(Auth::user()->role == 'employee')
            <h1>Selamat datang Di Zena Cell</h1>
        @else
            <h1>Kamu siapa ?</h1>
        @endif
    @endif
@endsection

@push('js')
<script>
    var ctx = document.getElementById('bar').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    responsive: true,

    // The data for our dataset
    data: {
        labels: ['','January', 'Februari'],
        datasets: [{
            label: 'Januari',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 79, 132)',
            data: ['',20, 30]
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
@endpush
