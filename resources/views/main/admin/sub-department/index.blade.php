@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Sub Bidang</h1>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <div class="my-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-fw fa-plus"></i> Tambah Data Sub Bidang</button>
        </div>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> List Sub Bidang
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('sub-departments.index') }}" method="get" id="subDepartmentSearch">
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
                                <th class="col-1">No</th>
                                <th class="col-4">Bidang</th>
                                <th class="col-6">Sub Bidang</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sub_departments as $sub_dept)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start" data-attr="department">{{ $sub_dept->department->department }}</td>
                                <td class="text-start" data-attr="sub_department">{{ $sub_dept->sub_department }}</td>
                                <td>
                                    <button type="button" class="border-0 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" title="Ubah" data-attr="{{ $sub_dept->id }}"><i class="fa-solid fa-sm fa-fw fa-pen-to-square"></i></button>
                                    <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus" data-attr="{{ $sub_dept->id }}"><i class="fa-solid fa-sm fa-fw fa-trash-can"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="4">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    {{ $sub_departments->links() }}
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
                <h5 id="createModalLabel" class="modal-title">Tambah Data Sub Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sub-departments.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="department_create" class="form-label">Bidang</label>
                        <select name="department_create" id="department_create" class="form-select">
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                            <option>Tambah Baru</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_create" class="form-label">Sub Bidang</label>
                        <input type="text" name="sub_department_create" id="sub_department_create" class="form-control" value="{{ old('sub_department_create') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
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
                <h5 id="editModalLabel" class="modal-title">Ubah Data Sub Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="editForm">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="department_edit" class="form-label">Bidang</label>
                        <input type="text" name="department_edit" id="department_edit" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_edit" class="form-label">Sub Bidang</label>
                        <input type="text" name="sub_department_edit" id="sub_department_edit" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
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
                    Apakah Anda yakin akan menghapus <span id="sub_department_delete" class="fw-semibold"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
            $("#subDepartmentSearch").submit();
        });

        $("#department_create").change(function() {
            if ($("option:selected").text() == "Tambah Baru") {
                $("#department_create").after('<input type="text" name="newDept" id="newDept" class="mt-2 form-control text-muted text-capitalize" placeholder="Nama Bidang" autocomplete="off">');
            } else {
                $("#newDept").remove();
            }
        });

        // Edit Function
        $('button[title="Ubah"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#editForm").attr("action", "http://helpdesk.test/admin/sub-departments/" + id);
            $("#department_edit").val($(this).parent().siblings('td[data-attr="department"]').html());
            $("#sub_department_edit").val($(this).parent().siblings('td[data-attr="sub_department"]').html());
        });

        // Delete Function
        $('button[title="Hapus"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#deleteForm").attr("action", "http://helpdesk.test/admin/sub-departments/" + id);
            $("#sub_department_delete").html($(this).parent().siblings('td[data-attr="sub_department"]').html());
        });
    });
</script>
@endsection