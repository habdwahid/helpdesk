<nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
    <div class="container-fluid">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle"><i class="fa-solid fa-fw fa-bars"></i></button>
        <!-- Navbar Brand-->
        <span class="navbar-brand ps-lg-2">
            <img src="{{ asset('assets/img/Logo_kabupaten_serang.png') }}" alt="Logo Kabupaten Serang" class="d-inline-block align-text-top" height="35">
            <span class="text-primary">Helpdesk</span> Information System
        </span>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-fw fa-user"></i></a>
                <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal" onclick="logout(`{{ route('logout') }}`)"><i class="fa-solid fa-fw fa-right-from-bracket"></i> Logout</button>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>