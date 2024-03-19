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
						<div class="name">{{ auth()->user()->name }}</div>
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
					@if ($errors->any())
						<div class="alert alert-danger  alert-dismissible fade show" role="alert">
							<ul>
								@foreach ($errors->all() as $error)
									<li class="text-danger">{{ $error }}</li>
								@endforeach
							</ul>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
                	@endif

					@if (session('success'))
						<div class="alert alert-success  alert-dismissible fade show" role="alert">
							<div class="d-flex justify-content-between">
								<div>
									{{ session('success') }}
								</div>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
                            </div>
						</div>
					@endif


					<form action="{{ route('profil.update') }}" method="post">
						@csrf
						@method('POST')
						<div class="form-group">
							<label for="name">Nama <span class="required-label">*</span></label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ $user->name }}" required>
						</div>
						<div class="form-group">
							<label for="email">Email <span class="required-label">*</span></label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email }}">
						</div>
						<div class="form-group">
							<label for="handphone">No Handphone <span class="required-label">*</span></label>
							<input type="text" class="form-control" id="handphone" name="handphone" placeholder="No Handphone" required value="{{ $user->handphone }}"/>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
						<div class="text-right mt-3 mb-3">
							<button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection