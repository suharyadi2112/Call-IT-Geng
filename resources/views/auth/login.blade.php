<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - {{ config('app.name') }}</title>
	@include('partial.asset.head')
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login">
			<h3 class="text-center">Call IT</h3>
			<div class="login-form">
                <form method="post" action="{{ route('login.index') }}">
                    @csrf
                    <div class="form-group form-floating-label">
                        <input id="email" name="email" type="email" class="form-control input-border-bottom">
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
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
    @include('partial.asset.script')

    <script>
        fetch('http://127.0.0.1:8000/api/user', {
  headers: {Authorization: 'Bearer 4|He9ImONgG2fm5jDwq3SzpUrsY0gh9tEhBd8e06tD754462f3'}
})
   .then(resp => resp.json())
   .then(json => console.log(JSON.stringify(json)))
    </script>
</body>
</html>