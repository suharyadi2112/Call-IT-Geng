@extends('partial.layout.main')
@section('title', 'Profil')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Profil</h4>
	<div class="row">
		<div class="col-md-4">
			<div class="card card-profile">
				<div class="card-header">
					<div class="profile-picture">
						<div class="avatar avatar-xl">
							<img src="{{ asset('/assets/img/user.png') }}" alt="..." class="avatar-img rounded-circle">
						</div>
					</div>
					
				</div>
				<div class="card-body">
					<div class="user-profile text-center">
						<div class="name">Administrator</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-with-nav">
				<div class="card-header">
					<h4 class="card-title">Detail Profil</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label for="name">Nama</label>
						<input type="text" class="form-control" id="name" placeholder="Nama">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" placeholder="Password">
					</div>
					<div class="text-right mt-3 mb-3">
						<button class="btn btn-sm btn-primary">Simpan Perubahan</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection