@extends('partial.layout.main')
@section('title', 'Buat Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Buat Pengaduan</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Pengaduan</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Pelapor</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pelapor">
                    </div>
                    <div class="form-group">
                        <label for="nomor_handphone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="nomor nomor_handphone" name="nomor_handphone" placeholder="Nama Pelapor">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" placeholder="Lokasi">
                    </div>
                    <div class="form-group">
                        <label for="lantai">Lantai</label>
                        <input type="number" class="form-control" id="lantai" placeholder="lantai">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Judul Pengaduan</label>
                        <input type="text" class="form-control" id="judul_pengaduan" placeholder="Judul Pengaduan">
                    </div>
                    <div class="form-group">
                        <label for="dekskripsi_pelaporan">Deskripsi</label>
                        <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control" rows="5" placeholder="Judul Pengaduan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dekskripsi_pelaporan">Deskripsi</label>
                        <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control" rows="5" placeholder="Judul Pengaduan"></textarea>
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
                        <select class="form-control" id="prioritas" name="prioritas">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Rendah">Jaringan</option>
                            <option value="Sedang">SIMRS</option>
                            <option value="Tinggi">Hardware</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prioritas</label>
                        <select class="form-control" id="prioritas" name="prioritas">
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>
                <div class="card-action">
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    <button class="btn btn-sm btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush