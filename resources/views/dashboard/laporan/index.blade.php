@extends('partial.layout.main')
@section('title', 'Pengaduan')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Laporan</h4>
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Laporan</h4>
                        {{-- <div class="ml-auto">
                            <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-success">
                                <i class="fa fa-plus"></i> Tambah Pengaduan
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Aduan</th>
                                    <th>Lantai</th>
                                    <th>Lokasi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection