@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4 mb-2">Tiket</h1>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Tiket
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="mb-2 col-6 col-lg-3">
                        <form action="{{ route('tickets.index') }}" method="get" id="searchForm">
                            @csrf
                            <div class="d-flex">
                                <label for="search" class="my-auto me-2">Cari</label>
                                <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1">ID</th>
                                <th class="col-3">Pelapor</th>
                                <th class="col-2">Kategori</th>
                                <th class="col-2">Tanggal</th>
                                <th class="col-2">Keterangan</th>
                                <th class="col-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            <tr class="text-center">
                                <td>{{ $ticket->id }}</td>
                                <td class="text-start">{{ $ticket->employee->user->name }}</td>
                                <td>{{ $ticket->category->category }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td class="text-start">{{ str($ticket->description)->limit(19) }}</td>
                                <td>{{ $ticket->ticket_status->status }}</td>
                            </tr>
                            @empty
                            <tr class="text-center">
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
        $("#search").on("keyup", function() {
            $("#searchForm").submit();
        });
    });
</script>
@endsection