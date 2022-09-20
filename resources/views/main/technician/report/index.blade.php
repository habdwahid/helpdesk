@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-table me-1"></i> Data Keluhan
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="col-8">
                        <form action="{{ route('technicians.report') }}" method="get">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <label for="date_start" class="form-label">Tanggal</label>
                                    <div class="d-flex">
                                        <input type="date" name="date_start" id="date_start" class="form-control form-control-sm" value="{{ request('date_start') }}">
                                        <span class="mx-2">-</span>
                                        <input type="date" name="date_end" id="date_end" class="form-control form-control-sm" value="{{ request('date_end') }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" name="btn-submit" class="btn btn-sm btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-1 text-end">
                        <a href="" class="btn btn-sm btn-primary" target="_blank" title="Cetak"><i class="fa-solid fa-sm fa-fw fa-print"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1" scope="col">#</th>
                                <th class="col-1" scope="col">ID Tiket</th>
                                <th class="col-3" scope="col">Pelapor</th>
                                <th class="col-3" scope="col">Jabatan</th>
                                <th class="col-2" scope="col">Tanggal Pelaporan</th>
                                <th class="col-2" scope="col">Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->employee->user->name }}</td>
                                <td>{{ $ticket->employee->position->position }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td>{{ $ticket->updated_at }}</td>
                            </tr>
                            @empty
                            <tr class="text-center text-muted">
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        let start = $("#date_start").val();
        let end = $("#date_end").val();
        let a = $('a[title="Cetak"]');

        if (start != "") {
            a.attr("href", "{{ url('technician/report') }}/" + start + '.pdf');
        } else {
            a.attr("href", "{{ url('technician/report') }}/" + <?= date('Y'); ?> + "-01-01" + '.pdf');
        }

        if (end != "") {
            if (start != "") {
                a.attr("href", "{{ url('technician/report') }}/" + start + "/" + end + '.pdf');
            } else {
                a.attr("href", "{{ url('technician/report') }}/" + <?= date('Y'); ?> + "-01-01/" + end + '.pdf');
            }
        } else {
            if (start != "") {
                a.attr("href", "{{ url('technician/report') }}/" + start + "/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + '.pdf');
            } else {
                a.attr("href", "{{ url('technician/report') }}/" + <?= date('Y'); ?> + "-01-01/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + '.pdf');
            }
        }
    });
</script>
@endsection