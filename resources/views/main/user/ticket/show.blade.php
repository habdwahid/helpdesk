@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <h1 class="mt-4 mb-2">Tiket Saya</h1>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Tiket Saya
            </div>
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('tickets.show') }}" method="get" id="searchForm">
                            @csrf
                            <div class="mb-2 d-flex">
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
                                <th class="col-2">Kategori</th>
                                <th class="col-3">Deskripsi</th>
                                <th class="col-2">Status</th>
                                <th class="col-2">Estimasi Selesai</th>
                                <th class="col-2">Selesai Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            <tr class="text-center">
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->category->category }}</td>
                                <td class="text-start">{!! nl2br($ticket->description) !!}</td>
                                <td>{{ $ticket->ticket_status->status }}</td>
                                <td>{{ $ticket->solved_at }}</td>
                                <td>{{ ($ticket->ticket_status_id === 3 ? $ticket->updated_at : '-') }}</td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="6">Tidak ada data</td>
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
        // Search Function
        $("#search").on("keyup", function() {
            $("#searchForm").submit();
        });
    });
</script>
@endsection