<div class="sidebar sidebar-style-2" data-background-color="{{ config('app.themes.color.sidebar') }}">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('pengaduan*') ? 'active' : '' }}">
                    <a href="{{ route('pengaduan.index') }}" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                        <p>Pengaduan</p>
                    </a>
                </li>

                @cekDivisi
                <li class="nav-item {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}" aria-expanded="false">
                        <i class="fas fa-list"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                @endcekDivisi

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pengaturan</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('profil*') ? 'active' : '' }}">
                    <a href="{{ route('profil.index') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Profil</p>
                    </a>
                </li>

                @cekDivisi
                <li class="nav-item {{ request()->routeIs('pengguna*') ? 'active' : '' }}">
                    <a href="{{ route('pengguna.index') }}" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <p>Master Pengguna</p>
                    </a>
                </li>
                @endcekDivisi
            </ul>
        </div>
    </div>
</div>
