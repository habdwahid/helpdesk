@extends('main.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Frequently Asked Questions</h1>
        <div class="my-5">
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Apa itu Sistem Informasi Helpdesk?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p style="text-align: justify;">Sistem Informasi Helpdesk adalah sebuah aplikasi berbasis website yang bertugas menjembatani pengguna untuk menyampaikan keluhan terkait aset yang terdapat pada Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu, Kab. Serang.</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Bagaimana cara mengajukan keluhan?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p style="text-align: justify;">Cara mengajukan keluhan cukup mudah. Kunjungi halaman <a href="{{ route('tickets.create') }}" class="fw-semibold text-decoration-none">Buat Tiket</a>, lalu pilih kategori di kolom <span class="fw-semibold">Kategori</span> dan deskripsikan masalah yang kamu hadapi di kolom <span class="fw-semibold">Deskripsi Masalah</span>. Selanjutnya, klik tombol <span class="btn btn-sm btn-primary fw-semibold">Kirim</span> di bawah kolom <span class="fw-semibold">Deskripsi Masalah</span> untuk mengirim keluhan yang kamu hadapi.</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5 style="text-align: justify;">Apa yang harus saya lakukan setelah mengirim keluhan?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p style="text-align: justify;">Kamu hanya perlu menunggu dan memantau proses sampai Tim Lapangan kami membereskan masalah kamu.</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Di mana saya dapat memantau proses keluhan yang saya adukan?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p style="text-align: justify;">Kamu dapat memantau proses keluhan kamu pada menu <a href="{{ route('tickets.show') }}" class="text-decoration-none fw-semibold">Tiket Saya</a>.</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Jenis keluhan apa saja yang dapat ditangani?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p class="mb-0" style="text-align: justify;">Jenis keluhan yang dapat ditangani antara lain:</p>
                        <p class="mb-0" style="text-align: justify;">- Internet lambat,</p>
                        <p class="mb-0" style="text-align: justify;">- Komputer tidak menyala,</p>
                        <p class="mb-0" style="text-align: justify;">- Mouse error atau tidak terhubung,</p>
                        <p class="mb-0" style="text-align: justify;">- Tidak terhubung ke internet,</p>
                        <p class="mb-0" style="text-align: justify;">- Tinta printer macet,</p>
                        <p class="mb-0" style="text-align: justify;">- dll.</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Jenis keluhan apa saja yang termasuk dalam kategori Urgent?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p class="mb-0" style="text-align: justify;">Jenis keluhan yang termasuk dalam kategori <span class="fw-semibold">Urgent</span> yaitu keluhan yang sekiranya dapat menganggu aktivitas pekerjaan.</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <h5>Q :</h5>
                    </div>
                    <div class="col-10 col-md-11">
                        <h5>Jenis keluhan apa saja yang termasuk dalam kategori Not Urgent?</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 col-md-1 text-end">
                        <p>A :</p>
                    </div>
                    <div class="col-10 col-md-11">
                        <p class="mb-0" style="text-align: justify;">Jenis keluhan yang termasuk dalam kategori <span class="fw-semibold">Not Urgent</span> yaitu keluhan yang sekiranya tidak terlalu menganggu aktivitas pekerjaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection