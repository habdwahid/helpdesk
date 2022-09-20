<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                @can('admin')
                <a class="nav-link @if (Request::is('admin/dashboard')) active @endif" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link @if (Request::is('admin/tickets')) active @endif" href="{{ route('tickets.index') }}">
                    Tiket
                </a>
                <a class="nav-link @if (Request::is('admin/positions*')) active @endif" href="{{ route('positions.index') }}">
                    Jabatan
                </a>
                <a class="nav-link @if (Request::is('admin/sub-departments*')) active @endif" href="{{ route('sub-departments.index') }}">
                    Divisi
                </a>
                <a class="nav-link @if (Request::is('admin/employees*')) active @endif" href="{{ route('employees.index') }}">
                    Pegawai
                </a>
                <a href="{{ route('admin.index') }}" class="nav-link @if (Request::is('admin/technicians*')) active @endif">
                    Teknisi
                </a>
                @endcan

                @can('technician')
                <a href="{{ route('technicians.index') }}" class="nav-link @if (Request::is('technician')) active @endif">
                    Dashboard
                </a>
                <a href="{{ route('technicians.show') }}" class="nav-link @if (Request::is('technician/tickets')) active @endif">
                    Tiket
                </a>
                <a href="{{ route('technicians.report') }}" class="nav-link @if (request()->routeIs('technicians.report')) active @endif">
                    Laporan
                </a>
                @endcan

                @can('user')
                @cannot('kepala')
                <a class="nav-link @if (Request::is('/')) active @endif" href="{{ route('tickets.create') }}">
                    Buat Tiket
                </a>
                <a class="nav-link @if (Request::is('tickets/my-ticket')) active @endif" href="{{ route('tickets.show') }}">
                    Tiket Saya
                </a>
                @endcannot
                @endcan

                @if (auth()->user()->user_role->role_id === 2)
                @else
                @can('kepala')
                <a class="nav-link @if (Request::is('dashboard')) active @endif" href="{{ route('user.dashboard') }}">
                    Dashboard
                </a>
                <a href="{{ route('tickets.report') }}" class="nav-link @if (Request::is('tickets/report')) active @endif">
                    Laporan
                </a>
                @endcan
                @endif

                @can('user')
                @cannot('kepala')
                <a class="nav-link @if (Request::is('faq')) active @endif" href="{{ route('faq.index') }}">
                    FAQ
                </a>
                @endcannot
                @endcan

                @can('manajer')
                <a href="{{ route('manager.dashboard') }}" class="nav-link @if (request()->routeIs('manager.dashboard')) active @endif">Dashboard</a>
                <a class="nav-link @if (Request::is('manager/tickets/approval*')) active @endif" href="{{ route('tickets.approval') }}">
                    Permintaan Tiket
                </a>
                <a href="{{ route('manager.tickets.index') }}" class="nav-link @if (request()->routeIs('manager.tickets.index')) active @endif">Tiket</a>
                @endcan
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Login sebagai:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>