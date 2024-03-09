@extends('partial.layout.main')
@section('title', 'Dashboard')
@section('content')
	<div class="page-inner">
		<h4 class="page-title">Dashboard</h4>
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="card card-stats card-round">
					<div class="card-body ">
						<div class="row align-items-center">
							<div class="col-icon">
								<div class="icon-big text-center icon-primary bubble-shadow-small">
									<i class="flaticon-down-arrow-2"></i>
								</div>
							</div>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">Pengaduan Masuk</p>
									<h4 class="card-title">1,294</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-icon">
								<div class="icon-big text-center icon-danger bubble-shadow-small">
									<i class="flaticon-exclamation"></i>
								</div>
							</div>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">Belum Dikerjakan</p>
									<h4 class="card-title">1303</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-icon">
								<div class="icon-big text-center icon-warning bubble-shadow-small">
									<i class="flaticon-clock"></i>
								</div>
							</div>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">Sedang Dikerjakan</p>
									<h4 class="card-title">1345</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-icon">
								<div class="icon-big text-center icon-success bubble-shadow-small">
									<i class="flaticon-success"></i>
								</div>
							</div>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">Selesai Dikerjakan</p>
									<h4 class="card-title">576</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<div class="card-title">Top Products</div>
					</div>
					<div class="card-body pb-0">
						<div class="d-flex">
							<div class="avatar">
								<img src="../assets/img/logoproduct.svg" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="flex-1 pt-1 ml-2">
								<h6 class="fw-bold mb-1">CSS</h6>
								<small class="text-muted">Cascading Style Sheets</small>
							</div>
							<div class="d-flex ml-auto align-items-center">
								<h3 class="text-info fw-bold">+$17</h3>
							</div>
						</div>
						<div class="separator-dashed"></div>
						<div class="d-flex">
							<div class="avatar">
								<img src="../assets/img/logoproduct.svg" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="flex-1 pt-1 ml-2">
								<h6 class="fw-bold mb-1">J.CO Donuts</h6>
								<small class="text-muted">The Best Donuts</small>
							</div>
							<div class="d-flex ml-auto align-items-center">
								<h3 class="text-info fw-bold">+$300</h3>
							</div>
						</div>
						<div class="separator-dashed"></div>
						<div class="d-flex">
							<div class="avatar">
								<img src="../assets/img/logoproduct3.svg" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="flex-1 pt-1 ml-2">
								<h6 class="fw-bold mb-1">Ready Pro</h6>
								<small class="text-muted">Bootstrap 4 Admin Dashboard</small>
							</div>
							<div class="d-flex ml-auto align-items-center">
								<h3 class="text-info fw-bold">+$350</h3>
							</div>
						</div>
						<div class="separator-dashed"></div>
						<div class="pull-in">
							<canvas id="topProductsChart"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title fw-mediumbold">Suggested People</div>
						<div class="card-list">
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">Jimmy Denis</div>
									<div class="status">Graphic Designer</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">Chad</div>
									<div class="status">CEO Zeleaf</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">Talha</div>
									<div class="status">Front End Designer</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">John Doe</div>
									<div class="status">Back End Developer</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">Talha</div>
									<div class="status">Front End Designer</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
							<div class="item-list">
								<div class="avatar">
									<img src="../assets/img/user.png" alt="..." class="avatar-img rounded-circle">
								</div>
								<div class="info-user ml-3">
									<div class="username">Jimmy Denis</div>
									<div class="status">Graphic Designer</div>
								</div>
								<button class="btn btn-icon btn-primary btn-round btn-xs">
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card card-primary bg-primary-gradient">
					<div class="card-body">
						<h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Active user right now</h4>
						<h1 class="mb-4 fw-bold">17</h1>
						<h4 class="mt-3 b-b1 pb-2 mb-5 fw-bold">Page view per minutes</h4>
						<div id="activeUsersChart"></div>
						<h4 class="mt-5 pb-3 mb-0 fw-bold">Top active pages</h4>
						<ul class="list-unstyled">
							<li class="d-flex justify-content-between pb-1 pt-1"><small>/product/readypro/index.html</small> <span>7</span></li>
							<li class="d-flex justify-content-between pb-1 pt-1"><small>/product/atlantis/demo.html</small> <span>10</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection