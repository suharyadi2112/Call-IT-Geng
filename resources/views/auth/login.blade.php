<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - {{ config('app.name') }}</title>
	@include('partial.asset.head')
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login">
			<h3 class="text-center">
                <img src="{{ asset('/assets/img/logologin.png') }}" alt="" style="width: 70%">
            </h3>
			<div class="login-form">
                @include('partial.layout.error_message')
                <form method="post" action="{{ route('login.post') }}" id="login">
                    @csrf
                    <div class="form-group form-floating-label">
                        <input id="email" name="email" type="email" class="form-control input-border-bottom" value="{{ old('email') }}">
                        <label for="email" class="placeholder">Email</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom">
                        <label for="password" class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-rounded btn-login" style="background-color: #00BF63;color:white">Sign In</button>
                    </div>
                </form>
			</div>
		</div>
	</div>        
    @include('partial.asset.script')
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
</body>
</html>