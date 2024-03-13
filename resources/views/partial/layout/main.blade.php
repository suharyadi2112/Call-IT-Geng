<!DOCTYPE html>
<html lang="en">
<head>
	<script>
		fetch(window.location.origin + '/api/check_valid_token', {
            method: 'GET',
            headers: {
                'Authorization': localStorage.getItem('access_token')
            }
        })
        .then(response => {
			if (response.ok) {
				return response.json();
			}
			throw new Error('Network response was not ok.');
		})
		.then(data => {
			if(!data.status =='success'){
                
                window.location.href = "{{ route('login.index') }}";

			}
		})
    </script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> @yield('title') - {{ config('app.name') }}</title>
	@include('partial.asset.head')
	@include('partial.asset.script')
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