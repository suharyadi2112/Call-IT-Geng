<div class="main-header">
    <div class="logo-header" data-background-color="{{ config('app.themes.color.logo_header') }}"> 
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('/assets/img/callit.png') }}" alt="navbar brand" class="navbar-brand" style="width: 80%;">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="{{ config('app.themes.color.navbar_header') }}">
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ ('/assets/img/user.png') }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="u-text">
                                        <h4>Halo, {{ auth()->user()->name }}</h4>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('profil.index') }}">Profil</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" onclick="logout()">Keluar</button>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

@push('script')
<script>
    function logout(){
        if (confirm("Apakah anda yakin ingin keluar?") == true) {
            window.location.href = "{{ route('logout') }}";
         }
    }
</script>
@endpush