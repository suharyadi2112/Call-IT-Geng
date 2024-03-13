<!DOCTYPE html>
<html lang="en">
<head>
	@include('partial.asset.head')
	@include('partial.asset.script')
	<script>
        if(!localStorage.getItem('access_token')){
            window.location.href = "{{ route('login.index') }}";
		}
    </script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> @yield('title') - {{ config('app.name') }}</title>
	
    @stack('style')
</head>
<body data-background-color="{{ config('app.themes.color.background') }}">
	<div class="wrapper">	
		@include('partial.layout.header')
        @include('partial.layout.sidebar')
		<div class="main-panel">
			<div class="container">
				@yield('content')
			</div>
			@include('partial.layout.footer')
		</div>
	</div>
	
    @stack('script')
</body>
</html>