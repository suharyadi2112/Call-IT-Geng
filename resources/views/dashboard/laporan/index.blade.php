@extends('partial.layout.main')
@section('title', 'Laporan')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Laporan</h4>
        <div class="row">
            <div class="col-md-3">
                <form action="{{ route('laporan.get') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Filter Laporan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Bulan :</label>
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="">Pilih</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Tahun :</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    @foreach ($tahun as $tahun)
                                        <option value="">Pilih</option>
                                        <option value="{{ $tahun->year }}">{{ $tahun->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-action">

                            <button class="btn btn-sm btn-primary float-right">SET</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Laporan</h4>
                        </div>
                        {{-- <button class="btn btn-md btn-success float-right">Export .xls</button> --}}
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pelapor</th>
                                    <th scope="col">Tanggal Laporan</th>
                                    <th scope="col">Laporan Kerusakan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengaduan as $key => $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->pelapor->name }}</td>
                                        <td>{{ Carbon\Carbon::parse($p->tanggal_pelaporan)->format('d-M-Y') }}</td>
                                        <td>{{ $p->judul_pengaduan }}</td>
                                        <td>{{ $p->status_pelaporan }}</td>
                                        <td>{{ $p->workers[$key]->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
