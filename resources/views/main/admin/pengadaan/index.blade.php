@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Pengadaan Barang</h1>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-table"></i> Data Pengadaan Barang
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('pengadaan.index') }}" method="get" id="searchForm">
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
                                <th class="col-1">Tiket ID</th>
                                <th class="col-3">Teknisi</th>
                                <th class="col-3">Merk</th>
                                <th class="col-3">Jenis</th>
                                <th class="col-1">Qty</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengadaan as $peng)
                            <tr class="text-center align-middle">
                                <td>{{ $peng->ticket_id }}</td>
                                <td>{{ $peng->technician->user->name }}</td>
                                <td>{{ $peng->merk }}</td>
                                <td>{{ $peng->jenis }}</td>
                                <td>{{ $peng->quantity }}</td>
                                <td>
                                    @empty($peng->pengadaan_status_id)
                                    <button type="button" class="border-0 btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal" title="Terima" data-attr="{{ $peng->id }}"><i class="fa-solid fa-sm fa-fw fa-check"></i></button>
                                    <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" title="Tolak" data-attr="{{ $peng->id }}"><i class="fa-solid fa-sm fa-fw fa-xmark"></i></button>
                                    @else
                                    {{ $peng->pengadaan_status->status }}
                                    @endempty
                                </td>
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
                    {{ $pengadaan->links() }}
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Acc Modal -->
<div id="accModal" class="modal fade" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accModalLabel">Terima Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="accForm">
                @method('put')
                @csrf
                <div class="modal-body">
                    Apakah Anda yakin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Terima</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal fade" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permintaan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="rejectForm">
                @method('delete')
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="description" class="form-label">Keterangan</label>
                        <input type="text" name="description" id="description" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Search
        $("#search").on("keyup", function() {
            $("#searchForm").submit();
        });

        // Acc
        $('button[title="Terima"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#accForm").attr("action", "{{ url('admin/pengadaan') }}/" + id);
        });

        // Reject
        $('button[title="Tolak"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#rejectForm").attr("action", "{{ url('admin/pengadaan/reject') }}/" + id);
        });
    });
</script>
@endsection