@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Pegawai</h1>
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('msg') }}
        </div>
        @endif
        <div class="my-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-fw fa-plus"></i> Tambah Data Pegawai</button>
        </div>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-sm fa-table"></i> List Pegawai
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('employees.index') }}" method="get" id="searchForm">
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
                                <th class="col-2">NIP</th>
                                <th class="col-3">Nama</th>
                                <th class="col-3">Jabatan</th>
                                <th class="col-3">Bidang</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                            <tr class="text-center">
                                <td data-attr="nip">{{ $employee->user->nip }}</td>
                                <td class="text-start" data-attr="name">{{ $employee->user->name }}</td>
                                <td data-attr="position">{{ $employee->position->position }}</td>
                                <td class="text-start" data-attr="department">{{ (($employee->sub_department_id) ? $employee->sub_department->department->department : '-') }}</td>
                                <td>
                                    <button type="button" class="border-0 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" title="Ubah" data-attr="{{ $employee->user->id }}"><i class="fa-solid fa-fw fa-sm fa-pen-to-square"></i></button>
                                    <button type="button" class="border-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-attr="{{ $employee->user->id }}" title="Hapus"><i class="fa-solid fa-fw fa-sm fa-trash-can"></i></button>
                                </td>
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
                    {{ $employees->links() }}
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
                <h5 id="createModalLabel" class="modal-title">Tambah Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.store') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label for="name_add" class="form-label">Nama</label>
                        <input type="text" name="name_add" id="name_add" class="form-control text-capitalize @error('name_add') is-invalid @enderror" value="{{ old('name_add') }}" required>
                        @error('name_add')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="nip_add" class="form-label">NIP</label>
                        <input type="number" name="nip_add" id="nip_add" class="form-control @error('nip_add') is-invalid @enderror" value="{{ old('nip_add') }}" required>
                        @error('nip_add')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="email_add" class="form-label">Email</label>
                        <input type="email" name="email_add" id="email_add" class="form-control @error('email_add') is-invalid @enderror" value="{{ old('email_add') }}" required>
                        @error('email_add')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="position_add" class="form-label">Jabatan</label>
                        <select name="position_add" id="position_add" class="form-select" required>
                            <option value="">-</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="department_add" class="form-label">Bidang</label>
                        <select name="department_add" id="department_add" class="form-select">
                            <option value="">-</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_add" class="form-label">Sub Bidang</label>
                        <select name="sub_department_add" id="sub_department_add" class="form-select">
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="gender_add" class="form-label">Jenis Kelamin</label>
                        <select name="gender_add" id="gender_add" class="form-select" required>
                            <option>-</option>
                            @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="password_add" class="form-label">Password</label>
                        <input type="password" name="password_add" id="password_add" class="form-control @error('password_add') is-invalid @enderror" minlength="8" required>
                        <small class="text-muted">Min 8 Karakter</small>
                        @error('password_add')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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

<!-- Edit Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Data Pegawai</h5>
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
                        <select name="position_edit" id="position_edit" class="form-select">
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="department_edit" class="form-label">Bidang</label>
                        <select name="department_edit" id="department_edit" class="form-select"></select>
                    </div>
                    <div class="mb-2">
                        <label for="sub_department_edit" class="form-label">Sub Bidang</label>
                        <select name="sub_department_edit" id="sub_department_edit" class="form-select"></select>
                    </div>
                    <div class="mb-2">
                        <label for="gender_edit" class="form-label">Jenis Kelamin</label>
                        <select name="gender_edit" id="gender_edit" class="form-select"></select>
                    </div>
                    <div class="mb-2">
                        <label for="password_edit" class="form-label">Password</label>
                        <input type="password" name="password_edit" id="password_edit" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
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
                    Apakah Anda yakin akan menghapus <span id="deleteName" class="fw-semibold"></span>?
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

        // Create Function
        $('#department_add').on("change", function() {
            let id = $(this).val();

            $.ajax({
                url: '/get/sub-department/' + id,
                type: "get",
                success: function(opt) {
                    $("#sub_department_add").html(opt);
                }
            });

            return false;
        });

        // Edit Function
        $('button[title="Ubah"]').click(function() {
            $("#editModal").show("slow");
            let id = $(this).attr("data-attr");

            $("#editForm").attr("action", "{{ url('admin/employees') }}/" + id);
            $("#name_edit").attr("value", $(this).parent().siblings('td[data-attr="name"]').html());
            $("#nip_edit").attr("value", $(this).parent().siblings('td[data-attr="nip"]').html());
            $.ajax({
                url: "/get/user/" + id,
                method: "get",
                success: function(data) {
                    $("#email_edit").attr("value", data.email);
                }
            });
            $.ajax({
                url: "/get/position/" + id,
                method: "get",
                success: function(opt) {
                    $("#position_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/department/" + id,
                method: "get",
                success: function(opt) {
                    $("#department_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/sub-department/" + id,
                method: "get",
                success: function(opt) {
                    $("#sub_department_edit").html(opt);
                }
            });
            $.ajax({
                url: "/get/selected/gender/" + id,
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

            $("#deleteForm").attr("action", "{{ url('admin/employees') }}/" + id);
            $("#deleteName").html($(this).parent().siblings('td[data-attr="name"]').html());

            return false;
        });
    });
</script>
@endsection