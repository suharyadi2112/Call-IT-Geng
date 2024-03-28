<footer class="footer" style="border-top: none !important;">
    <div class="container">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/kebijakan-privasi') }}">
                        Kebijakan Privasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('syarat-ketentuan') }}">
                        Syarat dan Ketentuan
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            Copyright {{ date('Y') }}, dibuat oleh <a href="{{ url('/') }}">{{ config('app.themes.footer.author') }}</a>
        </div>				
    </div>
</footer>