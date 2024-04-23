@extends('partial.layout.main')
@section('title', 'Dashboard')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Dashboard</h4>
        @if (in_array(Auth::user()->role, ['Admin', 'Worker']))
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Statistik Pengaduan</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="multipleLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Pengaduan Masuk</div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($pengaduan->count() == 0)
                                <div class="d-flex">
                                    <div class="flex-1 pt-1 ml-2">
                                        <h6 class="fw-bold mb 1">Belum Ada Pengaduan</h6>
                                    </div>
                                </div>
                            @else
                                @foreach ($info as $i)
                                    <a href="{{ route('pengaduan.detail', $i->id) }}" class="d-flex">
                                        <div class="flex-1 pt-1">
                                            <h6 class="text-uppercase fw-bold mb-1">{{ $i->pelapor->name }}
                                                @if ($i->status_pelaporan == 'waiting')
                                                    <span class="text-warning pl-2">Menunggu</span>
                                                @elseif($i->status_pelaporan == 'progress')
                                                    <span class="text-info pl-2">Proses</span>
                                                @else
                                                    <span class="text-success pl-2">Selesai</span>
                                                @endif
                                            </h6>
                                            <div class="text-muted">{!! strlen($i->judul_pengaduan) > 50 ? substr($i->judul_pengaduan, 0, 50) . '...' : $i->judul_pengaduan !!}</div>
                                        </div>
                                        <div class="float-right pt-1">
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($i->tanggal_pelaporan)->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                    <div class="separator-dashed"></div>
                                @endforeach
                            @endif
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-success btn-block btn-sm">Lihat Semua</a>
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
                                <div class="card-tools">
                                    <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> Tambah Pengaduan
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            @if ($pengaduan->count() == 0)
                                <div class="d-flex">
                                    <div class="flex-1 pt-1 ml-2">
                                        <h6 class="fw-bold mb 1">Belum Ada Pengaduan</h6>
                                    </div>
                                </div>
                            @else
                                @foreach ($info as $i)
                                    @if (Auth::user()->id == $i->pelapor_id)
                                        <a href="{{ route('pengaduan.detail', $i->id) }}" class="d-flex">
                                            <div class="flex-1 ml-3 pt-1">
                                                <h6 class="text-uppercase fw-bold mb-1">{{ $i->pelapor->name }}
                                                    @if ($i->status_pelaporan == 'waiting')
                                                    <span class="text-warning pl-2">Menunggu</span>
                                                @elseif($i->status_pelaporan == 'progress')
                                                    <span class="text-info pl-2">Proses</span>
                                                @else
                                                    <span class="text-success pl-2">Selesai</span>
                                                @endif

                                                </h6>
                                                <div class="text-muted">{!! strlen($i->judul_pengaduan) > 50 ? substr($i->judul_pengaduan, 0, 50) . '...' : $i->judul_pengaduan !!}</div>
                                            </div>
                                            <div class="float-right pt-1">
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($i->tanggal_pelaporan)->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                        <div class="separator-dashed"></div>
                                    @endif
                                @endforeach
                                <a href="{{ route('pengaduan.index') }}" class="btn btn-success btn-block btn-sm">Lihat Semua</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@push('styles')
@endpush

@push('script')
<script src="/assets/js/plugin/chart.js/chart.min.js"></script>
<script>
    var multipleLineChart = document.getElementById('multipleLineChart').getContext('2d');
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth() + 1;
    var currentYear = currentDate.getFullYear();
    var daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    var labels = [];
    for (var i = 1; i <= daysInMonth; i++) {
        labels.push(currentYear + '-' + currentMonth + '-' + i);
    }
		var myMultipleLineChart = new Chart(multipleLineChart, {
			type: 'line',
			data: {
                labels: labels,
                datasets: [
                    {
                        label: '{!! $chartData["name"] !!}',
                        data: [{{ implode(',', $chartData["data"]) }}],
                        fill: false,
                        borderColor: '#00BF63',
                    },
                ]
            },
            options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'bottom',
				},
            }
		});
</script>
@endpush
