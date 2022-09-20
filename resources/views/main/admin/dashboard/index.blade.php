@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row">
            <div class="col-xl-4 col-md-4">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Total Tiket
                        {{ $tickets }}
                    </div>
                    @can('admin')
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small stretched-link text-decoration-none" href="{{ route('tickets.index') }}">Selengkapnya</a>
                        <div class="small"><i class="fa-solid fa-fw fa-angle-right"></i></div>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Total Pegawai
                        {{ $employees }}
                    </div>
                    @can('admin')
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small stretched-link text-decoration-none" href="{{ route('employees.index') }}">Selengkapnya</a>
                        <div class="small"><i class="fa-solid fa-fw fa-angle-right"></i></div>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Total Teknisi
                        {{ $technicians }}
                    </div>
                    @can('admin')
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small stretched-link text-decoration-none" href="{{ route('admin.index') }}">Selengkapnya</a>
                        <div class="small"><i class="fa-solid fa-fw fa-angle-right"></i></div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
        @can('kepala')
        <form action="{{ route('user.dashboard') }}" method="get">
            @csrf
            <label for="month" class="form-label">Filter Berdasarkan Bulan</label>
            <div class="input-group mb-4">
                <input type="month" name="month" id="month" class="form-control text-muted" value="{{ request('month') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
        @endcan
        @can('admin')
        <form action="{{ route('dashboard') }}" method="get">
            @csrf
            <label for="month" class="form-label">Filter Berdasarkan Bulan</label>
            <div class="input-group mb-4">
                <input type="month" name="month" id="month" class="form-control text-muted" value="{{ request('month') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
        @endcan
        <div class="row justify-content-lg-between">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-fw fa-chart-column"></i> Line Chart
                    </div>
                    <div class="card-body overflow-hidden">
                        <div id="barChart" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-fw fa-chart-pie"></i> Pie Chart
                    </div>
                    <div class="card-body overflow-hidden">
                        <div id="pieChart" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="{{ asset('assets/js/plotly-2.12.1.min.js') }}"></script>
<script>
    let x = <?= json_encode($x) ?>;
    let y = <?= json_encode($y) ?>;

    let dataBar = [{
        x: x,
        y: y,
        type: "bar"
    }];

    let layoutBar = {
        title: "Angka Keluhan"
    };
    let configBar = {
        responsive: true
    };

    Plotly.newPlot("barChart", dataBar, layoutBar, configBar);
</script>
<script>
    let labels = ["Sedang Dikerjakan", "Ditolak", "Menunggu Konfirmasi", "Selesai"];
    let values = ["{{ $process }}", "{{ $rejected }}", "{{ $confirm }}", "{{ $solved }}"];
    let colors = ["Yellow", "Red", "Orange", "Green"];

    let dataPie = [{
        labels: labels,
        values: values,
        type: "pie",
        marker: {
            colors: colors
        }
    }];

    let layoutPie = {
        title: "Persentase"
    };

    let configPie = {
        responsive: true
    };

    Plotly.newPlot("pieChart", dataPie, layoutPie, configPie);
</script>
@endsection