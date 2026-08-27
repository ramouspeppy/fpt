<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Sistem Info Surplus Ikan')</title>

    <!-- Tabler CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="{{ url('/') }}">Info Surplus Ikan</a>
                </h1>
                <div class="navbar-collapse collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span class="nav-link-icon"><i class="ti ti-home"></i></span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('penawaran.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('penawaran.index') }}">
                                <span class="nav-link-icon"><i class="ti ti-fish"></i></span>
                                <span class="nav-link-title">Penawaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('permintaan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('permintaan.index') }}">
                                <span class="nav-link-icon"><i class="ti ti-clipboard-list"></i></span>
                                <span class="nav-link-title">Permintaan</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('match.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('match.index') }}">
                                <span class="nav-link-icon"><i class="ti ti-arrows-left-right"></i></span>
                                <span class="nav-link-title">Kecocokan</span>
                            </a>
                        </li>
                        @role('Admin')
                            <li class="nav-item {{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('cabang.index') }}">
                                    <span class="nav-link-icon"><i class="ti ti-building-store"></i></span>
                                    <span class="nav-link-title">Cabang</span>
                                </a>
                            </li>
                        @endrole
                    </ul>
                </div>
            </div>
        </aside>

        <div class="page-wrapper">
            <!-- Header -->
            <div class="page-header d-print-none">
                <div class="container-xl d-flex justify-content-between align-items-center py-2">
                    <h2 class="page-title">@yield('title', 'Dashboard')</h2>
                    <div class="dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                            <span class="d-none d-xl-block ps-2">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-muted">{{ auth()->user()->cabang->nama_cabang ?? 'Pusat' }}</div>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-body">
                <div class="container-xl">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    @yield('scripts')
</body>

</html>
