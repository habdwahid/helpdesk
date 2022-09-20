@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row row-cols-1 row-cols-md-3 gx-5 gy-4 justify-content-center">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Total Tiket
                        {{ $ticket }}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Tiket Selesai
                        {{ $ticket_solved }}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body fw-semibold">
                        Tiket Sedang Dikerjakan
                        {{ $ticket_process }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-lg-between">
            <div class="col">
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
    let labels = ["Sedang Dikerjakan", "Selesai"];
    let values = ["{{ $ticket_process }}", "{{ $ticket_solved }}"];
    let colors = ["Yellow", "Green"];

    let dataPie = [{
        labels: labels,
        values: values,
        type: "pie",
        marker: {
            colors: colors
        }
    }];

    let layoutPie = {
        title: "Persentase Tahun {{ date('Y') }}"
    };

    let configPie = {
        responsive: true
    };

    Plotly.newPlot("pieChart", dataPie, layoutPie, configPie);
</script>
@endsection