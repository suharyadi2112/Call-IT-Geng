@extends('frontend.partial.main')
@section('title', 'Pertanyaan Umum')
@section('content')
<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Pertanyaan Umum</h4>
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
                    <a href="#!">Pertanyaan Umum</a>
                </li>
            </ul>
        </div>
        


        <div>
            <div class="accordion accordion-secondary">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="span-title">
                            1. Apa itu Aplikasi Call IT RSUD Raja Ahmad Tabib?
                        </div>
                        <div class="span-mode"></div>
                    </div>
            
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Aplikasi Call IT RSUD Raja Ahmad Tabib adalah platform yang dirancang untuk memfasilitasi pelaporan keluhan atau gangguan terkait dengan layanan IT di RSUD Raja Ahmad Tabib. Aplikasi ini memungkinkan bagian manajemen dan pelayanan rumah sakit untuk melaporkan masalah IT kepada tim IT untuk ditindaklanjuti.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <div class="span-title">
                            2. Siapakah yang dapat menggunakan Aplikasi Call IT?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            Aplikasi Call IT RSUD Raja Ahmad Tabib dapat digunakan oleh anggota tim manajemen dan pelayanan rumah sakit yang memiliki hak akses untuk melaporkan masalah atau keluhan terkait dengan layanan IT.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <div class="span-title">
                            3. Bagaimana cara menggunakan Aplikasi Call IT?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            Untuk menggunakan Aplikasi Call IT, Anda perlu masuk ke aplikasi dengan menggunakan kredensial yang diberikan oleh administrator sistem. Setelah masuk, Anda akan menemukan formulir pelaporan yang dapat Anda isi dengan detail keluhan atau gangguan yang ingin Anda laporkan.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <div class="span-title">
                            4. Apa yang terjadi setelah saya melaporkan keluhan atau gangguan?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            Tim IT RSUD Raja Ahmad Tabib akan menanggapi keluhan atau gangguan yang dilaporkan sesegera mungkin. Mereka akan meninjau laporan Anda dan mengambil langkah-langkah yang diperlukan untuk memperbaiki masalah yang dilaporkan.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <div class="span-title">
                            5. Bagaimana saya dapat melacak status keluhan atau gangguan yang saya laporkan?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            Anda dapat melacak status keluhan atau gangguan yang Anda laporkan melalui Aplikasi Call IT. Setelah laporan Anda diproses, Anda akan menerima pembaruan melalui aplikasi atau kontak yang Anda berikan dalam laporan.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        <div class="span-title">
                            6. Apakah informasi yang saya berikan melalui Aplikasi Call IT akan aman?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="card-body">
                            Kami mengambil langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda yang Anda berikan melalui Aplikasi Call IT. Informasi Anda akan dijaga kerahasiaannya dan tidak akan dibagikan kepada pihak ketiga tanpa izin Anda, kecuali jika diperlukan oleh hukum atau aturan yang berlaku.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        <div class="span-title">
                            7. Apakah Aplikasi Call IT tersedia untuk platform selain yang dimaksudkan?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                        <div class="card-body">
                            Saat ini, Aplikasi Call IT RSUD Raja Ahmad Tabib hanya tersedia untuk platform yang telah ditetapkan oleh RSUD Raja Ahmad Tabib.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header collapsed" id="headingEight" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <div class="span-title">
                            8. Bagaimana jika saya memiliki pertanyaan atau masalah teknis terkait dengan penggunaan Aplikasi Call IT?
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
                        <div class="card-body">
                            Jika Anda memiliki pertanyaan atau mengalami masalah teknis saat menggunakan Aplikasi Call IT, Anda dapat menghubungi tim dukungan teknis yang ditentukan oleh RSUD Raja Ahmad Tabib melalui kontak yang tersedia dalam Aplikasi.
                        </div>
                    </div>
                </div>
            </div>
            <p>
                Jika Anda memiliki pertanyaan lain yang tidak tercakup dalam FAQ ini, jangan ragu untuk menghubungi kami melalui Aplikasi Call IT RSUD Raja Ahmad Tabib. Terima kasih atas partisipasi Anda dalam meningkatkan layanan kami.
            </p>
        </div>

    </div>
</div>
@endsection