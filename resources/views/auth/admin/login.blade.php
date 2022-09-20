@extends('auth.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="mt-5 border-0 shadow-sm card rounded-4">
            <div class="card-body px-lg-4">
                <img src="{{ asset('assets/img/Logo_kabupaten_serang.png') }}" alt="Kabupaten Serang Logo" class="mx-auto img-fluid d-block" style="width: 50px;">
                <h4 class="mt-4 text-center font-weight-light">Sistem Informasi Helpdesk</h4>
                <h6 class="mb-4 text-center font-weight-light">Dinas Penanaman Modal dan Pelayanan Terpadu<br>Satu Pintu, Kabupaten Serang</h6>
                <hr class="text-muted">
                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label for="login" class="form-label">NIP atau Email</label>
                        <input class="form-control text-muted @error('login') is-invalid @enderror" id="login" name="login" type="text" value="{{ old('login') }}" autofocus autocomplete="off" required>
                        @error('login')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control text-muted @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <hr class="text-muted">
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection