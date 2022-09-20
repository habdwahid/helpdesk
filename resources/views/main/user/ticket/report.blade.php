@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Laporan Tiket</h1>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> Laporan Tiket
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="col-8">
                        <form action="{{ route('tickets.report') }}" method="get">
                            @csrf
                            <div class="row justify-content-between align-items-center mb-2">
                                <div class="col-6">
                                    <label for="date_start" class="form-label">Tanggal</label>
                                    <div class="d-flex">
                                        <input type="date" name="date_start" id="date_start" class="form-control form-control-sm text-muted" value="{{ request('date_start') }}">
                                        <span class="mx-2">-</span>
                                        <input type="date" name="date_end" id="date_end" class="form-control form-control-sm text-muted" value="{{ request('date_end') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="technicians" class="form-label">Teknisi</label>
                                    <select name="technicians" id="technicians" class="form-select form-select-sm text-muted">
                                        <option value="">Semua Teknisi</option>
                                        @forelse ($technicians as $technician)
                                        <option value="{{ $technician->id }}" @selected(request('technicians')==$technician->id)>{{ $technician->user->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select form-select-sm text-muted">
                                        <option value="">Semua Status</option>
                                        @forelse ($statuses as $status)
                                        <option value="{{ $status->id }}" @selected( request('status')==$status->id )>{{ $status->status }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" name="btn-submit" class="btn btn-sm btn-primary">Filter</button>
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
                                <th class="col-1">No</th>
                                <th class="col-2">ID</th>
                                <th class="col-3">Teknisi</th>
                                <th class="col-2">Tanggal</th>
                                <th class="col-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ ((empty($ticket->technician_id)) ? '-' : $ticket->technician->user->name) }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td>{{ $ticket->ticket_status->status }}</td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="5">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        let a = $('a[title="Cetak"]');
        let end = $("#date_end").val();
        let start = $("#date_start").val();
        let status = $("#status").val();
        let technician = $("#technicians").val();

        if (start != "") {
            a.attr("href", "{{ url('reports') }}/" + start);
        } else {
            a.attr("href", "{{ url('reports') }}/" + <?= date('Y'); ?> + "-01-01");
        }

        if (end != "") {
            if (start != "") {
                a.attr("href", "{{ url('reports') }}/" + start + "/" + end);
            } else {
                a.attr("href", "{{ url('reports') }}/" + <?= date('Y'); ?> + "-01-01/" + end);
            }
        } else {
            if (start != "") {
                a.attr("href", "{{ url('reports') }}/" + start + "/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?>);
            } else {
                a.attr("href", "{{ url('reports') }}/" + <?= date('Y'); ?> + "-01-01/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?>);
            }
        }

        if (technician != "") {
            if (end != "") {
                if (start != "") {
                    a.attr("href", "{{ url('reports/get') }}/" + start + "/" + end + "/" + technician);
                } else {
                    a.attr("href", "{{ url('reports/get') }}/" + <?= date('Y'); ?> + "-01-01/" + end + "/" + technician);
                }
            } else {
                if (start != "") {
                    a.attr("href", "{{ url('reports/get') }}/" + start + "/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + technician);
                } else {
                    a.attr("href", "{{ url('reports/get') }}/" + <?= date('Y'); ?> + "-01-01/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + technician);
                }
            }
        }

        if (status != "") {
            if (technician != "") {
                if (end != "") {
                    if (start != "") {
                        a.attr("href", "{{ url('reports/get') }}/" + start + "/" + end + "/" + technician + "/" + status);
                    } else {
                        a.attr("href", "{{ url('reports/get') }}/" + <?= date('Y'); ?> + "-01-01/" + end + "/" + technician + "/" + status);
                    }
                } else {
                    if (start != "") {
                        a.attr("href", "{{ url('reports/get') }}/" + start + "/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + technician + "/" + status);
                    } else {
                        a.attr("href", "{{ url('reports/get') }}/" + <?= date('Y'); ?> + "-01-01/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + technician + "/" + status);
                    }
                }
            } else {
                if (end != "") {
                    if (start != "") {
                        a.attr("href", "{{ url('reports') }}/" + start + "/" + end + "/" + status);
                    } else {
                        a.attr("href", "{{ url('reports') }}/" + <?= date('Y'); ?> + "-01-01/" + end + "/" + status);
                    }
                } else {
                    if (start != "") {
                        a.attr("href", "{{ url('reports') }}/" + start + "/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + status);
                    } else {
                        a.attr("href", "{{ url('reports') }}/" + <?= date('Y'); ?> + "-01-01/" + <?= date('Y'); ?> + "-" + <?= date('m'); ?> + "-" + <?= date('d') ?> + "/" + status);
                    }
                }
            }
        }
    });
</script>
@endsection