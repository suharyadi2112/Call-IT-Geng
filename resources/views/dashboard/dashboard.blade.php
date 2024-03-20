@extends('partial.layout.main')
@section('title', 'Dashboard')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Dashboard</h4>

        @if (Auth::user()->divisi == 'IT')
            <div class="row row-card-no-pd">
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
                                        <h4 class="card-title">{{ $pengaduan->count() }}</h4>
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
                                        <h4 class="card-title">{{ $belum->count() }}</h4>
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
                                        <h4 class="card-title">{{ $sedang->count() }}</h4>
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
                                        <h4 class="card-title">{{ $sudah->count() }}</h4>
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
                            <div class="card-title">Statistik Pengaduan</div>
                        </div>
                        <div class="card-body pb-0">
                            @foreach ($pengaduan as $p)
                                {{-- @php dd($p->kategoripengaduan->nama); @endphp --}}
                                <div class="d-flex">
                                    <div class="avatar">
                                        <span class="avatar-title rounded-circle border border-white bg-success">
                                            @php
                                                echo substr($p->kategoripengaduan->nama, 0, 1);
                                            @endphp
                                        </span>
                                    </div>
                                    <div class="flex-1 pt-1 ml-2">
                                        <h6 class="fw-bold mb-1">{{ $p->kategoripengaduan->nama }}</h6>
                                        <small class="text-muted">Total pengaduan gangguan
                                            {{ $p->kategoripengaduan->nama }}:</small>
                                    </div>
                                    <div class="d-flex ml-auto align-items-center">
                                        <h3 class="text-dark fw-bold">{{ $p->total }}</h3>
                                    </div>
                                </div>
                                <div class="separator-dashed"></div>
                            @endforeach


                            {{-- <div class="pull-in">
                                <canvas id="topProductsChart"></canvas>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-success bg-success-gradient">
                        <div class="card-body">
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Pengaduan Masuk Bulan Ini :</h4>
                            <h1 class="mb-4 fw-bold">{{ $bulan->count() }}</h1>
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Pengaduan Masuk Hari Ini :</h4>
                            <h1 class="mb-4 fw-bold">{{ $today->count() }}</h1>
                            {{-- <h4 class="mt-3 b-b1 pb-2 mb-5 fw-bold">{{ $today->count() }} Pengaduan hari ini</h4>
                            <div id="activeUsersChart"></div> --}}
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Kategori Pengaduan Terbanyak Bulan Ini :</h4>
                            <ul class="list-unstyled">
                                @foreach ($bulankategori as $bk)
                                    <li class="d-flex justify-content-between pb-1 pt-1">
                                        <small>{{ $bk->kategoripengaduan->nama }}</small>
                                        <span>{{ $bk->total }}</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card  full-height card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Pengaduan</div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($info as $i)
                                <div class="d-flex">
                                    <div class="avatar">
                                        <span class="avatar-title rounded-circle border border-white bg-info">
                                            @php
                                                echo substr($i->pelapor->name, 0, 1);
                                            @endphp
                                        </span>
                                    </div>
                                    <div class="flex-1 ml-3 pt-1">
                                        <h6 class="text-uppercase fw-bold mb-1">{{ $i->pelapor->name }}
                                            @if ($i->status_pelaporan == 'waiting')
                                                <span class="btn btn-danger btn-round  btn-xs">Belum Dikerjakan</span>
                                            @elseif($i->status_pelaporan == 'progress')
                                                <span class="btn btn-warning btn-round  btn-xs">Sedang Dikerjakan</span>
                                            @else
                                                <span class="btn btn-success btn-round  btn-xs">Selesai
                                                    Dikerjakan</span>
                                            @endif

                                        </h6>
                                        <span class="text-muted">{!! $i->dekskripsi_pelaporan !!}</span>
                                    </div>
                                    <div class="float-right pt-1">
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($i->tanggal_pelaporan)->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="separator-dashed"></div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card  full-height card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Riwayat Pengaduan</div>
                            </div>
                        </div>
                        <div class="card-body">

                            @foreach ($info as $i)
                                @if (Auth::user()->id == $i->pelapor_id)
                                    <div class="d-flex">
                                        <div class="avatar">
                                            <span class="avatar-title rounded-circle border border-white bg-info">
                                                @php
                                                    echo substr($i->pelapor->name, 0, 1);
                                                @endphp
                                            </span>
                                        </div>
                                        <div class="flex-1 ml-3 pt-1">
                                            <h6 class="text-uppercase fw-bold mb-1">{{ $i->pelapor->name }}
                                                @if ($i->status_pelaporan == 'waiting')
                                                    <span class="btn btn-danger btn-round  btn-xs">Belum Dikerjakan</span>
                                                @elseif($i->status_pelaporan == 'progress')
                                                    <span class="btn btn-warning btn-round  btn-xs">Sedang
                                                        Dikerjakan</span>
                                                @else
                                                    <span class="btn btn-success btn-round  btn-xs">Selesai
                                                        Dikerjakan</span>
                                                @endif

                                            </h6>
                                            <span class="text-muted">{!! $i->dekskripsi_pelaporan !!}</span>
                                        </div>
                                        <div class="float-right pt-1">
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($i->tanggal_pelaporan)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="separator-dashed"></div>
                                @else
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
