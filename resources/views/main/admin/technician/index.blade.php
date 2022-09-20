@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <h1 class="mt-4">Teknisi</h1>
        <div class="my-2 text-end">
            <button type="button" class="shadow-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-fw fa-plus"></i> Tambah Data Teknisi</button>
        </div>
        <div class="mb-4 shadow-sm card">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-table"></i> List Teknisi
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('admin.index') }}" method="get" id="searchForm">
                            <div class="mb-2 d-flex">
                                <label for="search" class="my-auto me-2">Cari</label>
                                <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-2" data-attr="nip">NIP</th>
                                    <th class="col-2" data-attr="name">Nama</th>
                                    <th class="col-2">Jabatan</th>
                                    <th class="col-3">Bidang</th>
                                    <th class="col-2">Status</th>
                                    <th class="col-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($technicians as $technician)
                                <tr class="text-center">
                                    <td data-attr="nip">{{ $technician->user->nip }}</td>
                                    <td class="text-start" data-attr="name">{{ $technician->user->name }}</td>
                                    <td>{{ $technician->position->position }}</td>
                                    <td>{{ $technician->sub_department->department->department }}</td>
                                    <td>{{ $technician->technician_status->status }}</td>
                                    <td>
                                        <button type="button" class="border-0 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" title="Ubah" data-attr="{{ $technician->user->id }}"><i class="fa-solid fa-sm fa-fw fa-pen-to-square"></i></button>
                                        <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus" data-attr="{{ $technician->user->id }}"><i class="fa-solid fa-sm fa-fw fa-trash-can"></i></button>
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
                        {{ $technicians->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Create Modal -->
<div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.store') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label for="name_create" class="form-label">Nama</label>
                        <input type="text" name="name_create" id="name_create" class="form-control text-capitalize" required>
                    </div>
                    <div class="mb-2">
                        <label for="nip_create" class="form-label">NIP</label>
                        <input type="number" name="nip_create" id="nip_create" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="email_create" class="form-label">Email</label>
                        <input type="email" name="email_create" id="email_create" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="position_create" class="form-label">Jabatan</label>
                        <select name="position_create" id="position_create" class="form-select">
                            <option value="">-</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="department_create" class="form-label">Bidang</label>
                        <select name="department_create" id="department_create" class="form-select">
                            <option value="">-</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_create" class="form-label">Sub Bidang</label>
                        <select name="sub_department_create" id="sub_department_create" class="form-select">
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="gender_create" class="form-label">Jenis Kelamin</label>
                        <select name="gender_create" id="gender_create" class="form-select">
                            <option value="">-</option>
                            @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="password_create" class="form-label">Password</label>
                        <input type="password" name="password_create" id="password_create" class="form-control" minlength="8" required>
                        <small class="text-muted">Min 8 Karakter</small>
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Data Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="editForm">
                    @method('put')
                    @csrf
                    <div class="mb-2">
                        <label for="name_edit" class="form-label">Nama</label>
                        <input type="text" name="name_edit" id="name_edit" class="form-control text-capitalize" required>
                    </div>
                    <div class="mb-2">
                        <label for="nip_edit" class="form-label">NIP</label>
                        <input type="number" name="nip_edit" id="nip_edit" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="email_edit" class="form-label">Email</label>
                        <input type="email" name="email_edit" id="email_edit" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="position_edit" class="form-label">Jabatan</label>
                        <select name="position_edit" id="position_edit" class="form-select" required>
                            <option value="">-</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="department_edit" class="form-label">Bidang</label>
                        <select name="department_edit" id="department_edit" class="form-select" required>
                            <option value="">-</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_edit" class="form-label">Sub Bidang</label>
                        <select name="sub_department_edit" id="sub_department_edit" class="form-select" required>
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="gender_edit" class="form-label">Jenis Kelamin</label>
                        <select name="gender_edit" id="gender_edit" class="form-select">
                            <option value="">-</option>
                            @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="password_edit" class="form-label">Password</label>
                        <input type="password" name="password_edit" id="password_edit" class="form-control" minlength="8">
                        <small class="text-muted">Min 8 Karakter</small>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="deleteForm">
                @method('delete')
                @csrf
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus <span id="technician_delete" class="fw-semibold"></span>?
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
            $("#searchForm").submit();
        });

        // Create Funtion
        $("#department_create").on("change", function() {
            let id = $("#department_create").val();

            $.ajax({
                url: "/get/sub-department/" + id,
                method: "get",
                success: function(data) {
                    $("#sub_department_create").html(data);
                }
            });
        });

        // Edit Function
        $('button[title="Ubah"]').on("click", function() {
            $("#editModal").show("slow");
            let id = $(this).attr("data-attr");

            $("#editForm").attr("action", "{{ url('admin/technicians') }}/" + id);
            $("#nip_edit").val($(this).parent().siblings('td[data-attr="nip"]').html());
            $("#name_edit").val($(this).parent().siblings('td[data-attr="name"]').html());
            $.ajax({
                url: "/get/user/" + id,
                method: "get",
                success: function(data) {
                    $("#email_edit").val(data.email);
                }
            });
            $.ajax({
                url: "/get/position/technician/" + id,
                method: "get",
                success: function(opt) {
                    $("#position_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/technician/department/" + id,
                method: "get",
                success: function(opt) {
                    $("#department_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/technician/sub-department/" + id,
                method: "get",
                success: function(opt) {
                    $("#sub_department_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/technician/gender/" + id,
                method: "get",
                success: function(opt) {
                    $("#gender_edit").html(opt);
                }
            });

            return false;
        });

        // Delete Function
        $('button[title="Hapus"]').on("click", function() {
            let id = $(this).attr("data-attr");

            $("#deleteForm").attr("action", "{{ url('admin/technicians') }}/" + id);
            $("#technician_delete").html($(this).parent().siblings('td[data-attr="name"]').html());
        });
    });
</script>
@endsection