@extends('partial.layout.main')
@section('title', 'Buat Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Buat Pengaduan</h4>
    @include('partial.layout.error_message')
    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form Pengaduan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Pelapor</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Pelapor" required value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nomor_handphone">Nomor Telepon <span class="required-label">*</span></label>
                            <input type="number" class="form-control" id="nomor_handphone" name="nomor_handphone" placeholder="Nomor Handphone" required value="{{ auth()->user()->handphone }}">
                        </div>
                        <div class="form-group">
                            @php
                                $lantai = [
                                    'basement' => 'Basement',
                                    '01' => '01',
                                    '02' => '02',
                                    '03' => '03',
                                    '04' => '04',
                                    '05' => '05',
                                    '06' => '06',
                                    '07' => '07',
                                    '08' => '08',
                                ];
                            @endphp
                            <label for="lantai">Lantai <span class="required-label">*</span></label>
                            <select class="form-control" id="prioritas" name="lantai">
                                <option value="">-- Pilih Lantai --</option>
                                @foreach ($lantai as $key => $value)
                                    <option value="{{ $key }}" {{ old('lantai') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi <span class="required-label">*</span></label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required value="{{ old('lokasi') }}">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Judul Aduan <span class="required-label">*</span></label>
                            <input type="text" class="form-control" id="judul_pengaduan" name="judul_pengaduan" placeholder="Judul Pengaduan" required value="{{ old('judul_pengaduan') }}">
                        </div>
                        <div class="form-group">
                            <label for="dekskripsi_pelaporan">Deskripsi <span class="required-label">*</span></label>
                            <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control" rows="5" placeholder="Deskripsi Pengaduan" required>{{ old('dekskripsi_pelaporan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="dekskripsi_pelaporan">Kondisi Pengaduan <span class="required-label">*</span></label>
                            <input type="file" class="form-control" id="imageInput" name="picture_pre[]" multiple required accept=".jpg, .jpeg, .png"/>
                            <div id="preview" class="mt-3 row"></div>
                            <button type="button" class="btn btn-sm btn-danger mt-3" id="btnDelete" style="display:none;">Hapus Gambar</button>
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
                            <label>Kategori <span class="required-label">*</span></label>
                            <select class="form-control" id="kategori_pengaduan_id" name="kategori_pengaduan_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriPengaduan as $key => $value)
                                    <option value="{{ $value->id }}" {{ old('kategori_pengaduan_id') == $value->id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prioritas <span class="required-label">*</span></label>
                            <select class="form-control" id="prioritas" name="prioritas">
                                <option value="">-- Pilih Prioritas --</option>
                                <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
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

    $('#imageInput').change(function() {
        var files = this.files;
        if (files && files.length > 0) {
            $('#preview').html('');
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var imageUrl = event.target.result;
                    $('#preview').append(
                        '<div class="col-6 col-md-3 mb-4">' +    
                        '<a href="' + imageUrl + '" data-toggle="lightbox">' +    
                        '<img src="' + imageUrl + '" class="img-fluid" style="width: 100%; object-fit: cover; height: 100px;">' +
                        '</a></div>'
                    );
                };
                reader.readAsDataURL(files[i]);
            }
            $('#btnDelete').show();
        }
    });

    $('#btnDelete').click(function() {
        $('#imageInput').val('');
        $('#preview').html('');
        $(this).hide();
        $('.custom-file-label').text('Pilih Gambar');
    });
});

  
</script>
@endpush