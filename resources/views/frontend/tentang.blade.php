@extends('frontend.partial.main')
@section('title', 'Tentang')
@section('content')
<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tentang</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ url('/') }}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#!">Tentang</a>
                </li>
            </ul>
        </div>
        <div >
            <p>
                Aplikasi Call IT RSUD Raja Ahmad Tabib adalah sebuah platform yang dirancang khusus untuk memudahkan bagian manajemen dan pelayanan rumah sakit dalam melaporkan keluhan atau gangguan terkait layanan IT kepada tim IT RSUD Raja Ahmad Tabib. Aplikasi ini memfasilitasi proses pelaporan secara efisien dan cepat, memastikan bahwa setiap masalah teknis atau keluhan terkait IT dapat segera ditangani dan diselesaikan.
            </p>
            <h2>Fitur Aplikasi:</h2>
            <ol>
                <li>
                    Pelaporan Keluhan atau Gangguan: Aplikasi ini memungkinkan pengguna, seperti bagian manajemen dan pelayanan rumah sakit, untuk melaporkan keluhan atau gangguan terkait layanan IT dengan mudah dan cepat.
                </li>
                <li>
                    Prioritas dan Tindak Lanjut: Setiap keluhan atau gangguan yang dilaporkan akan ditangani dengan cepat oleh tim IT RSUD Raja Ahmad Tabib. Setiap laporan akan diberi prioritas dan dipantau secara berkala hingga masalah diselesaikan.
                </li>
                <li>
                    Komunikasi Terintegrasi: Aplikasi ini menyediakan jalur komunikasi terintegrasi antara pengguna dan tim IT RSUD Raja Ahmad Tabib, memungkinkan klarifikasi dan pertanyaan tambahan terkait keluhan atau gangguan yang dilaporkan.
                </li>
                <li>
                    Keamanan Informasi: Kami mengutamakan keamanan informasi yang dilaporkan melalui Aplikasi ini. Semua data yang dikirimkan melalui Aplikasi akan dienkripsi dan disimpan dengan aman.
                </li>
            </ol>
        </div>
    </div>
</div>
@endsection