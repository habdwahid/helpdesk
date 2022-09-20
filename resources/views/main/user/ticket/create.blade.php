@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Buat Tiket</h1>
        <div class="card mb-4 mt-2">
            <div class="card-header">
                <i class="fa-solid fa-sm fa-fw fa-table"></i> Buat Tiket
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col col-md-6 col-lg-4">
                        <div class="mb-2">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="mb-2">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" value="{{ auth()->user()->nip }}" disabled>
                        </div>
                    </div>
                    <div class="col col-md-6 col-lg-4">
                        <div class="mb-2">
                            <label for="department" class="form-label">Bidang</label>
                            <input type="text" name="department" id="department" class="form-control" value="@if (!empty(auth()->user()->employee->sub_department_id)) {{ auth()->user()->employee->sub_department->department->department }} @else {{ '-' }} @endif" disabled>
                        </div>
                        <div class="mb-2">
                            <label for="sub_department" class="form-label">Sub Bidang</label>
                            <input type="text" name="sub_department" id="sub_department" class="form-control" value="@if (!empty(auth()->user()->employee->sub_department_id)) {{ auth()->user()->employee->sub_department->sub_department }} @else {{ '-' }} @endif" disabled>
                        </div>
                    </div>
                </div>
                <hr class="text-muted">
                <form action="" method="post">
                    @csrf
                    <div class="row justify-content-between">
                        <div class="col col-md-5">
                            <div class="mb-2">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" id="category" class="form-select">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-5">
                            <div class="mb-2">
                                <label for="solved_at" class="form-label">Selesai Dalam</label>
                                <input type="date" name="solved_at" id="solved_at" class="form-control text-muted" value="{{ old('solved_at') }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Keterangan" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#category").change(function() {
            if ($("option:selected").text() == "Permintaan Barang") {
                $("#category").after(
                    '<input type="text" name="merk" id="merk" class="form-control text-capitalize text-muted mt-2" placeholder="Merk" required><input type="text" name="jenis" id="jenis" class="form-control text-capitalize text-muted mt-2" placeholder="Jenis" required><input type="number" name="qty" id="qty" class="form-control text-muted mt-2" placeholder="Quantity" required>'
                );
            } else {
                $("#merk").remove();
                $("#jenis").remove();
                $("#qty").remove();
            }
        });
    });
</script>
@endsection