<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <span class="d-sm-none d-lg-inline-block">{{ auth()->user()->name }}</span>
                <span class="badge badge-primary ml-2">{{ auth()->user()->getRoleNames()->first() ?? '-' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    {{ auth()->user()->cabang->nama_cabang ?? 'Kantor Pusat' }}
                </div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-left w-100 border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
