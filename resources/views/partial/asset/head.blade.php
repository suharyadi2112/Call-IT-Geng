<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('/assets/img/callit.ico') }}" type="image/x-icon"/>

<script src="{{ asset('/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {"families":["Lato:300,400,700,900"]},
        custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('/assets/css/fonts.min.css') }}']},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/atlantis.css') }}">
<style>
    .alert .close {
        top: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }
    .form-control:disabled{
        opacity: 1 !important;
    }
</style>