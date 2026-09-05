<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ config('app.name', 'Info Surplus Ikan') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('penawaran.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penawaran.index') }}">
                    <i class="fas fa-fish"></i> <span>Penawaran</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('permintaan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('permintaan.index') }}">
                    <i class="fas fa-clipboard-list"></i> <span>Permintaan</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('match.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('match.index') }}">
                    <i class="fas fa-random"></i> <span>Kecocokan</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('project.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('project.index') }}">
                    <i class="fas fa-folder-open"></i> <span>Project</span>
                </a>
            </li>

            <!-- v9.8: Master Komoditi & Cabang sekarang bisa dilihat SEMUA role yang login
                 (visibility only) - aksi kelola tetap dibatasi lewat controller/route -->
            <li class="menu-header">Data Master</li>
            <li class="{{ request()->routeIs('komoditi.index') || request()->routeIs('komoditi.size.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('komoditi.index') }}">
                    <i class="fas fa-list"></i> <span>Master Komoditi & Size</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cabang.index') }}">
                    <i class="fas fa-store"></i> <span>Cabang</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
