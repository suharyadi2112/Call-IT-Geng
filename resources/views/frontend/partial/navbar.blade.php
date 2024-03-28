<div class="main-header shadow-sm" data-background-color="white">
    <div class="nav-top">
        <div class="container d-flex flex-row">
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="icon-menu"></i>
                </span>
            </button>
            <a href="{{ route('login') }}" class="more"><i class="icon-user"></i></a>
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('/assets/img/callit.png') }}" alt="navbar brand" class="navbar-brand" style="width: 142px;">
            </a>

            <nav class="navbar navbar-header navbar-expand-lg p-0">
                <div class="container-fluid p-0">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item hidden-caret">
                            <a href="{{ url('/tentang') }}" class="nav-link">Tentang</a>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="Dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dukungan <i class="fa fa-angle-down ml-2"></i>
                            </a>
                            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <a class="see-all" href="{{ url('/kebijakan-privasi') }}">Kebijakan Privasi</a>
                                </li>
                                <li>
                                    <a class="see-all" href="{{ url('/syarat-ketentuan') }}">Syarat & Ketentuan</a>
                                </li>
                                <li>
                                    <a class="see-all" href="{{ url('/pertanyaan-umum') }}">Pertanyaan Umum</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item hidden-caret">
                            <a href="{{ route('login') }}" class="nav-link"><i class="icon-user"></i></a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="nav-bottom">
        <div class="container">
            <h3 class="title-menu d-flex d-lg-none text-primary"> 
                Menu 
                <div class="close-menu"> <i class="flaticon-cross"></i></div>
            </h3>
            <ul class="nav page-navigation page-navigation-info bg-white d-lg-none">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/tentang') }}">
                        <i class="link-icon icon-screen-desktop"></i>
                        <span class="menu-title">Tentang</span>
                    </a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link" href="#">
                        <i class="link-icon icon-grid"></i>
                        <span class="menu-title">Dukungan</span>
                    </a>
                    <div class="navbar-dropdown animated fadeIn">
                        <ul>
                            <li>
                                <a href="{{ url('/kebijakan-privasi') }}">Kebijakan Privasi</a>
                            </li>
                            <li>
                                <a href="{{ url('/syarat-ketentuan') }}">Syarat & Ketentuan</a>
                            </li>
                            <li>
                                <a href="{{ url('/pertanyaan-umum') }}">Pertanyaan Umum</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>