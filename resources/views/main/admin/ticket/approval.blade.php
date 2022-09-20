@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Tiket Approval</h1>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-check-circle"></i> {{ session('msg') }}
        </div>
        @endif
        <div class="mt-2 mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Tiket Approval
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="mb-2 col-6 col-lg-3">
                        <form action="{{ route('tickets.approval') }}" method="get" id="searchForm">
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
                                <td class="text-start" data-attr="name">{{ $ticket->employee->user->name }}</td>
                                <td>{{ $ticket->category->category }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td>{{ $ticket->solved_at }}</td>
                                <td class="text-start" data-attr="desc">{{ str($ticket->description)->limit(28) }}</td>
                                <td class="d-none" data-attr="position">{{ $ticket->employee->position->position }}</td>
                                <td class="d-none" data-attr="department">{{ (($ticket->employee->sub_department_id) ? $ticket->employee->sub_department->department->department : '-') }}</td>
                                <td class="d-none" data-attr="subdept">{{ (($ticket->employee->sub_department_id) ? $ticket->employee->sub_department->sub_department : '-') }}</td>
                                <td>
                                    <button type="button" class="border-0 btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal" title="Terima" data-attr="{{ $ticket->id }}"><i class="fa-solid fa-sm fa-fw fa-check"></i></button>
                                    <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" title="Tolak" data-attr="{{ $ticket->id }}"><i class="fa-solid fa-sm fa-fw fa-xmark"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Ticket Accepted Modal -->
<div id="accModal" class="modal fade" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="accModalLabel" class="modal-title">Terima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="accForm">
                    @csrf
                    <div class="mb-2">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" name="id" id="id" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="employee_id" class="form-label">Pelapor</label>
                        <input type="text" name="employee_id" id="employee_id" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="position" class="form-label">Jabatan</label>
                        <input type="text" name="position" id="position" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="department" class="form-label">Bidang</label>
                        <input type="text" name="department" id="department" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department" class="form-label">Sub Bidang</label>
                        <input type="text" name="sub_department" id="sub_department" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" id="category" class="form-select"></select>
                    </div>
                    <div class="mb-2">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="text" name="merk" id="merk" class="form-control text-capitalized" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" name="jenis" id="jenis" class="form-control text-capitalized" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="text" name="qty" id="qty" class="form-control text-capitalized" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="technician" class="form-label">Teknisi</label>
                        <select name="technician" id="technician" class="form-select" required>
                            @if (empty($technicians))
                            <option value="">-</option>
                            @else
                            @foreach ($technicians as $technician)
                            <option value="{{ $technician->id }}">{{ $technician->user->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control" disabled></textarea>
                    </div>
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
                <h5 id="rejectModalLabel" class="modal-title">Tolak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="rejectForm">
                @csrf
                <div class="modal-body">
                    Apakah Anda yakin akan menolak tiket dengan ID <span id="reject_id" class="fw-semibold"></span>?
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
        // Search Function
        $("#search").on("keyup", function() {
            $("#searchForm").submit();
        });

        // Reject Function
        $('button[title="Tolak"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#rejectForm").attr("action", "{{ url('admin/tickets/reject') }}/" + id);
            $("#reject_id").html($(this).parent().siblings('td[data-attr="id"]').html());
        });

        // Acc Function
        $('button[title="Terima"]').on("click", function() {
            $("#accModal").show("slow");
            let id = $(this).attr("data-attr");

            $("#accForm").attr("action", "{{ url('admin/tickets/accept') }}/" + id);
            $("#id").val($(this).parent().siblings('td[data-attr="id"]').html());
            $("#employee_id").val($(this).parent().siblings('td[data-attr="name"]').html());
            $("#position").val($(this).parent().siblings('td[data-attr="position"]').html());
            $("#department").val($(this).parent().siblings('td[data-attr="department"]').html());
            $("#sub_department").val($(this).parent().siblings('td[data-attr="subdept"]').html());
            $.ajax({
                url: "/get/category/" + id,
                method: "get",
                success: function(opt) {
                    $("#category").html(opt);
                }
            });
            $.ajax({
                url: "/get/ticket/" + id,
                method: "get",
                success: function(data) {
                    $("#description").val(data.description);
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