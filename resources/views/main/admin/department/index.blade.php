@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Bidang</h1>
        <div class="my-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-fw fa-plus"></i>Tambah Data Bidang</button>
        </div>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Bidang
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="mb-2 col-6 col-md-4 col-lg-3">
                        <form action="{{ route('departments.index') }}" method="get" id="searchForm">
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
                                <th>No</th>
                                <th>Bidang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($departments->isEmpty())
                            <tr class="text-center">
                                <td colspan="3">-</td>
                            </tr>
                            @else
                            @foreach ($departments as $department)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start" data-attr="department">{{ $department->department }}</td>
                                <td>
                                    <button type="button" class="border-0 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" title="Ubah" data-attr="{{ $department->id }}"><i class="fa-solid fa-sm fa-fw fa-pen-to-square"></i></button>
                                    <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus" data-attr="{{ $department->id }}"><i class="fa-solid fa-sm fa-fw fa-trash-can"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    {{ $departments->links() }}
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
            <form action="{{ route('departments.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="department_create" class="form-label">Bidang</label>
                    <input type="text" name="department_create" id="department_create" class="form-control" required>
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
                <h5 id="editModalLabel" class="modal-title">Ubah Data Bidang</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="editForm">
                @method('put')
                @csrf
                <div class="modal-body">
                    <label for="department_edit" class="form-label">Bidang</label>
                    <input type="text" name="department_edit" id="department_edit" class="form-control" required>
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
                <h5 id="deleteModalLabel" class="modal-title">Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="deleteForm">
                @method('delete')
                @csrf
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus <span id="department_delete" class="fw-semibold"></span>?
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

            $("#editForm").attr("action", "http://helpdesk.test/admin/departments/" + id);
            $("#department_edit").val($(this).parent().siblings('td[data-attr="department"]').html());
        });

        // Delete Function
        $('button[title="Hapus"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#deleteForm").attr("action", "http://helpdesk.test/admin/departments/" + id);
            $("#department_delete").html($(this).parent().siblings('td[data-attr="department"]').html());
        });
    });
</script>
@endsection