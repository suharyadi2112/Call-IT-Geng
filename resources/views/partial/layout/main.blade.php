<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> @yield('title') - {{ config('app.name') }}</title>
	@include('partial.asset.head')
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
	@include('partial.asset.script')
    @stack('script')
</body>
</html>