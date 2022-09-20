<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>404 Not Found</title>
    <!-- Style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
</head>

<body>
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="mb-4 img-error" src="{{ asset('assets/img/error-404-monochrome.svg') }}" />
                                <p class="lead">Hmm... Sepertinya kamu tersesat.<br>Halaman yang kamu cari tidak tersedia.</p>
                                <a href="{{ url()->previous() }}">
                                    <i class="fa-solid fa-fw fa-arrow-left me-1"></i>Kembali Ke Jalan Yang Benar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu, Kab. Serang 2022</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>

</html>