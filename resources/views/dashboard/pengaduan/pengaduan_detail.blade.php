@extends('partial.layout.main')
@section('title', 'Buat Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Buat Pengaduan</h4>
    <form action="{{ route('pengaduan.index.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
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
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form Pengaduan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Pelapor</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pelapor" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_handphone">Nomor Telepon</label>
                            <input type="number" class="form-control" id="nomor_handphone" name="nomor_handphone" placeholder="Nomor Handphone" required value="{{ old('nomor_handphone') }}">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required value="{{ old('lokasi') }}">
                        </div>
                        <div class="form-group">
                            <label for="lantai">Lantai</label>
                            <input type="number" class="form-control" id="lantai" name="lantai" placeholder="Lantai" required value="{{ old('lantai') }}">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Judul Pengaduan</label>
                            <input type="text" class="form-control" id="judul_pengaduan" name="judul_pengaduan" placeholder="Judul Pengaduan" required value="{{ old('judul_pengaduan') }}">
                        </div>
                        <div class="form-group">
                            <label for="dekskripsi_pelaporan">Deskripsi</label>
                            <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control" rows="5" placeholder="Deskripsi Pengaduan" required>{{ old('dekskripsi_pelaporan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="dekskripsi_pelaporan">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pilihan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            @php
                                $kategori = [
                                    1 => 'Jaringan',
                                    2 => 'SIMRS',
                                    3 => 'Hardware',
                                    4 => 'Lainnya',
                                ];
                            @endphp
                            <select class="form-control" id="kategori_pengaduan_id" name="kategori_pengaduan_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $key => $value)
                                    <option value="{{ $key }}" {{ old('kategori_pengaduan_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prioritas</label>
                            <select class="form-control" id="prioritas" name="prioritas">
                                <option value="">-- Pilih Prioritas --</option>
                                <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Indikator Mutu</label>
                            <select class="form-control" id="indikator_mutu_id" name="indikator_mutu_id">
                                <option value="">-- Pilih Indikator Mutu --</option>
                                @foreach ($indikatorMutu as $key => $value)
                                    <option value="{{ $value->id }}" {{ old('indikator_mutu_id') == $value->id ? 'selected' : '' }}>{{ $value->nama_indikator }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-black">Kembali</a>
                        <button class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
@endpush