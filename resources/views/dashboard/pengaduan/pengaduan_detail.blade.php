@extends('partial.layout.main')
@section('title', 'Buat Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Detail Pengaduan</h4>
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
                        <label for="name">Pelapor</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Pelapor" required value="{{ old('name') }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nomor_handphone">Nomor Telepon</label>
                        <input type="number" class="form-control" id="nomor_handphone" name="nomor_handphone" placeholder="Nomor Handphone" required value="{{ $pengaduan->nomor_handphone }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lantai">Lantai</label>
                        <input type="number" class="form-control" id="lantai" name="lantai" placeholder="Lantai" required value="{{ $pengaduan->lantai }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required value="{{ $pengaduan->lokasi }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Judul Pengaduan</label>
                        <input type="text" class="form-control" id="judul_pengaduan" name="judul_pengaduan" placeholder="Judul Pengaduan" required value="{{ $pengaduan->judul_pengaduan }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="dekskripsi_pelaporan">Deskripsi</label>
                        <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control" rows="5" placeholder="Deskripsi Pengaduan" required disabled>{{ $pengaduan->dekskripsi_pelaporan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="dekskripsi_pelaporan">Gambar Kondisi Pengaduan</label>
                        <div class="row image-gallery">
                            @foreach ($gambarPengaduan as $key => $value)
                                <a href="{{ asset('storage/'.$value->picture) }}" class="col-6 col-md-3 mb-4" data-toggle="lightbox">
                                    <img src="{{ asset('storage/'.$value->picture) }}" class="img-fluid" style="width: 100%; object-fit: cover; height: 100px;">
                                </a>   
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" id="kategori_pengaduan_id" name="kategori_pengaduan_id" disabled>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoriPengaduan as $key => $value)
                                <option value="{{ $value->id }}" {{ $pengaduan->kategori_pengaduan_id == $value->id ? 'selected' : '' }}>{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prioritas</label>
                        <select class="form-control" id="prioritas" name="prioritas" disabled>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="Rendah" {{ $pengaduan->prioritas == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="Sedang" {{ $pengaduan->prioritas == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tinggi" {{ $pengaduan->prioritas == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Indikator Mutu</label>
                        <select class="form-control" id="indikator_mutu_id" name="indikator_mutu_id" disabled>
                            @foreach ($indikatorMutu as $key => $value)
                                <option value="{{ $value->id }}" {{ $value->id == $pengaduan->indikator_mutu_id ? 'selected' : '' }}>{{ $value->nama_indikator }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ route('pengaduan.index.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Kondisi Perbaikan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dekskripsi_pelaporan">Kondisi Perbaikan</label>
                            <input type="file" class="form-control" id="imageInput" name="picture_pre[]" multiple>
                            <div id="preview" class="mt-3 row"></div>
                            <button type="button" class="btn btn-sm btn-danger mt-3" id="btnDelete" style="display:none;">Hapus Gambar</button>
                        </div>
                        <div class="form-group">
                            <label>Status Pelaporan <span class="required-label">*</span></label>
                            @php
                            $status = [
                                'waiting' => 'Menunggu',
                                'progress' => 'Proses',
                                'done' => 'Selesai',
                            ];
                            @endphp
                            <select class="form-control" id="status_pelaporan" name="status_pelaporan">
                                <option value="">-- Pilih Status Pelaporan --</option>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $pengaduan->status_pelaporan ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-black">Kembali</a>
                        <button class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('styles')
<link href="{{ asset('/assets/js/plugin/ekko-lightbox/ekko-lightbox.min.css') }}" rel="stylesheet" />    
@endpush
@push('script')
<script src="{{ asset('/assets/js/plugin/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
</script>
@endpush