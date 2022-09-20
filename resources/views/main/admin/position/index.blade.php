@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Jabatan</h1>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i>{{ session('msg') }}
        </div>
        @endif
        <div class="text-end py-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-fw fa-plus"></i> Tambah Data Jabatan</button>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Jabatan
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <form action="{{ route('positions.index') }}" method="get" id="searchForm">
                            @csrf
                            <div class="d-flex">
                                <label for="search" class="my-auto ms-auto me-2">Cari</label>
                                <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1">No</th>
                                <th class="col-10">Jabatan</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($positions as $position)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start" data-attr="position">{{ $position->position }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary border-0" data-bs-toggle="modal" data-bs-target="#editModal" title="Ubah" data-attr="{{ $position->id }}"><i class="fa-solid fa-sm fa-fw fa-pen-to-square"></i></button>
                                    <button class="btn btn-sm btn-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus" data-attr="{{ $position->id }}"><i class="fa-solid fa-sm fa-fw fa-trash-can"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="3">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-end">
                        {{ $positions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Create Modal -->
<div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="createModalLabel" class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('positions.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="position_create" class="form-label">Jabatan</label>
                    <input type="text" name="position_create" id="position_create" class="form-control" value="{{ old('position_create') }}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="editModalLabel" class="modal-title">Ubah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="editForm">
                @method('put')
                @csrf
                <div class="modal-body">
                    <label for="position_edit" class="form-label">Jabatan</label>
                    <input type="text" name="position_edit" id="position_edit" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="deleteModalLabel" class="moda-title">Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="post">
                @method('delete')
                @csrf
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus <span id="position_delete" class="fw-semibold"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-semibold">Hapus</button>
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

        // Edit Function
        $('button[title="Ubah"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#editForm").attr("action", "http://helpdesk.test/admin/positions/" + id);
            $("#position_edit").val($(this).parent().siblings('td[data-attr="position"]').html());
        });

        // Delete Fuction
        $('button[title="Hapus"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#deleteForm").attr("action", "http://helpdesk.test/admin/positions/" + id);
            $("#position_delete").html($(this).parent().siblings('td[data-attr="position"]').html());
        });
    });
</script>
@endsection