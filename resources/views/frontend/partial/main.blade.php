<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title> @yield('title')  | {{ config('app.name') }} RSUD Raja Ahmad Tabib</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        @include('frontend.partial.style')
    </head>
    <body>
        <div class="wrapper horizontal-layout">
            @include('frontend.partial.navbar')

            @yield('content')

            @include('frontend.partial.footer')
        </div>
        @include('frontend.partial.script')
    </body>
</html>