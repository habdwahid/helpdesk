@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <h1 class="mt-4">Tiket</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-table"></i> List Tiket
            </div>
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('technicians.show') }}" method="get" id="searchForm">
                            @csrf
                            <div class="d-flex mb-2">
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
                                <th class="col-2">Pelapor</th>
                                <th class="col-1">Kategori</th>
                                <th class="col-2">Tanggal Dibuat</th>
                                <th class="col-2">Estimasi Selesai</th>
                                <th class="col-3">Keterangan</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            <tr class="text-center">
                                <td data-attr="id">{{ $ticket->id }}</td>
                                <td class="text-start" data-attr="employee">{{ $ticket->employee->user->name }}</td>
                                <td data-attr="category">{{ $ticket->category->category }}</td>
                                <td data-attr="created">{{ $ticket->created_at }}</td>
                                <td>{{ $ticket->solved_at }}</td>
                                <td class="text-start">{{ str($ticket->description)->limit(30) }}</td>
                                <td>
                                    @if ($ticket->ticket_status_id === 4)
                                    {{ $ticket->ticket_status->status }}
                                    @else
                                    <button type="button" class="btn btn-sm btn-primary border-0" data-bs-toggle="modal" data-bs-target="#updateStatusModal" title="Update Status"><i class="fa-solid fa-sm fa-fw fa-pen-to-square"></i></button>
                                    @endif
                                </td>
                                <td class="d-none" data-attr="position">{{ $ticket->employee->position->position }}</td>
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

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Status Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="updateModalForm">
                    @method('put')
                    @csrf
                    <div class="mb-2">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" name="id" id="id" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="employee" class="form-label">Pelapor</label>
                        <input type="text" name="employee" id="employee" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="position" class="form-label">Jabatan</label>
                        <input type="text" name="position" id="position" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" name="category" id="category" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="text" name="merk" id="merk" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" name="jenis" id="jenis" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" name="qty" id="qty" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="2">Sedang Dikerjakan</option>
                            @forelse ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea name="description" id="description" cols="30" class="form-control" disabled></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
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

        $('button[title="Update Status"]').click(function() {
            $("#updateStatusModal").show("slow");
            let id = $(this).parent().siblings('td[data-attr="id"]').html();

            $("#updateModalForm").attr("action", "{{ url('technician') }}/" + id);
            $("#id").val(id);
            $("#employee").val($('td[data-attr="employee"]').html());
            $("#position").val($('td[data-attr="position"]').html());
            $("#category").val($('td[data-attr="category"]').html());
            $.ajax({
                url: "/get/ticket/" + id,
                method: "get",
                success: function(data) {
                    $("#description").html(data.description);
                }
            });
            $.ajax({
                url: "/get/permintaan/" + id,
                method: "get",
                success: function(data) {
                    $("#merk").val(data.merk);
                    $("#jenis").val(data.jenis);
                    $("#qty").val(data.quantity);
                }
            });
        });
    });
</script>
@endsection