@extends('frontend.partial.main')
@section('title', 'Beranda')
@section('content')
<header id="header" class="header">
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1>Call IT RSUD Raja Ahmad Tabib 
                        <p class="p-large">Dirancang untuk memudahkan bagian manajemen dan pelayanan rumah sakit dalam melaporkan keluhan atau gangguan terkait layanan IT kepada tim IT RSUD Raja Ahmad Tabib</p>
                        <a href="{{ url('/') }}" class="btn btn-secondary btn-round">Tentang</a>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <div class="">
                            <img class="img-fluid" src="{{ asset('/assets/img/smartphone.png') }}" alt="alternative" style="width: 300px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<svg class="wave" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1920 310"><defs><style>.cls-1{fill:#00BF63;}</style></defs><title>wave</title><path class="cls-1" d="M0,283.054c22.75,12.98,53.1,15.2,70.635,14.808,92.115-2.077,238.3-79.9,354.895-79.938,59.97-.019,106.17,18.059,141.58,34,47.778,21.511,47.778,21.511,90,38.938,28.418,11.731,85.344,26.169,152.992,17.971,68.127-8.255,115.933-34.963,166.492-67.393,37.467-24.032,148.6-112.008,171.753-127.963,27.951-19.26,87.771-81.155,180.71-89.341,72.016-6.343,105.479,12.388,157.434,35.467,69.73,30.976,168.93,92.28,256.514,89.405,100.992-3.315,140.276-41.7,177-64.9V0.24H0V283.054Z"/></svg>

<div class="description">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading">Tutorial</div>
                <h2 class="h2-heading">Cara Menggunakan Aplikasi</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 cal-md-12">
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{ asset('/assets/img/warning-sign.png') }}" alt="alternative" style="width: 100px;">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Laporkan Keluhan</h4>
                        <p>Anda dapat melaporkan keluhan atau gangguan terkait layanan IT kepada tim IT RSUD Raja Ahmad Tabib</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4 cal-md-12">
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{ asset('/assets/img/alarm.png') }}" alt="alternative" style="width: 100px;">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Tunggu Konfirmasi</h4>
                        <p>Setelah melaporkan keluhan, tim IT akan segera memproses dan memberikan konfirmasi kepada Anda</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4 cal-md-12">
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{ asset('/assets/img/fingerprint.png') }}" alt="alternative" style="width: 100px;">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Tindak Lanjuti</h4>
                        <p>Setelah mendapatkan konfirmasi, keluhan atau gangguan yang Anda laporkan akan segera ditindaklanjuti oleh tim IT</p>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<section class="header pb-3">
    <div class="header-content">
        <div class="container">
            <div class="row align-items-center text-white text-left">
                <div class="col-lg-6">
                    <h4>Download Aplikasi</h4>
                    <p class="lead mb-5 mb-lg-0">Dapatkan aplikasi Call IT RSUD Raja Ahmad Tabib di smartphone Anda sekarang juga</p>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <a href="javascript:void(0);" class="mr-3">
                        <img src="/assets/img/app-store-badge.svg" style="height: 3rem;">
                    </a>
                    <a href="javascript:void(0);">
                        <img src="/assets/img/google-play-badge.svg" style="height: 3rem;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection