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
                <li class="nav-item {{ request()->routeIs('pengaduan*') ? 'active submenu' : '' }}">
                    <a data-toggle="collapse" href="#pengaduan">
                        <i class="fas fa-layer-group"></i>
                        <p>Pengaduan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('pengaduan*') ? 'show' : '' }}" id="pengaduan">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('pengaduan.index*') ? 'active' : '' }}">
                                <a href="{{ route('pengaduan.index') }}">
                                    <span class="sub-item">Daftar Pengaduan</span>
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('pengaduan.kategori') ? 'active' : '' }}">
                                <a href="{{ route('pengaduan.kategori') }}">
                                    <span class="sub-item">Kategori</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ request()->routeIs('indikatormutu*') ? 'active' : '' }}">
                    <a href="{{ route('indikatormutu.index') }}" aria-expanded="false">
                        <i class="fas fa-bullseye"></i>
                        <p>Indikator Mutu</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Setting</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('profil*') ? 'active' : '' }}">
                    <a href="{{ route('profil.index') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Profil</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
