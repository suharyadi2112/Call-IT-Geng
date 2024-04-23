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
                @checkRole
                    <li class="nav-item {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                        <a href="{{ route('kategori.index') }}" aria-expanded="false">
                            <i class="fas fa-list"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('indikatormutu*') ? 'active' : '' }}">
                        <a href="{{ route('indikatormutu.index') }}" aria-expanded="false">
                            <i class="fas fa-chart-pie"></i>
                            <p>Indikator Mutu</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <a href="{{ route('laporan.index') }}" aria-expanded="false">
                            <i class="fas fa-file"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('laporanindikatormutu.*') ? 'active' : '' }}">
                        <a href="{{ route('laporanindikatormutu.index') }}" aria-expanded="false">
                            <i class="fas fa-file-contract"></i>
                            <p>Laporan Indikator Mutu</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('jadwal-oncall.*') ? 'active' : '' }}">
                        <a href="{{ route('jadwal-oncall.index') }}" aria-expanded="false">
                            <i class="fas fa-clock"></i>
                            <p>Jadwal Oncall</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('pesan-masuk.*') ? 'active' : '' }}">
                        <a href="{{ route('pesan-masuk.index') }}" aria-expanded="false">
                            <i class="far fa-paper-plane"></i>
                            <p>Pesan Masuk</p>
                        </a>
                    </li>
                @endcheckRole
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
                @checkRole
                    <li class="nav-item {{ request()->routeIs('pengguna*') ? 'active' : '' }}">
                        <a href="{{ route('pengguna.index') }}" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <p>Master Pengguna</p>
                        </a>
                    </li>
                @endcheckRole
            </ul>
        </div>
    </div>
</div>
