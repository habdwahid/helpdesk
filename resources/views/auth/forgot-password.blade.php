@extends('auth.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 rounded-4 mt-5">
            <div class="card-body px-lg-4">
                <img src="{{ asset('assets/img/Logo_kabupaten_serang.png') }}" alt="Kabupaten Serang Logo" class="img-fluid mx-auto d-block" style="width: 50px;">
                <h4 class="text-center font-weight-light mt-4">Sistem Informasi Helpdesk</h4>
                <h6 class="text-center font-weight-light mb-4">Dinas Penanaman Modal dan Pelayanan Terpadu<br>Satu Pintu</h6>
                <hr class="text-muted">
                @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-fw fa-circle-check"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control text-muted @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autofocus autocomplete="off" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('login') }}" class="small text-decoration-none my-auto">Login</a>
                        <button type="submit" class="btn btn-primary ms-auto">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection