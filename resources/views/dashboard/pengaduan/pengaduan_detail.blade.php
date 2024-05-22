@extends('partial.layout.main')
@section('title', 'Detail Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Detail Aduan</h4>
    @include('partial.layout.error_message')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="">Detail Form Aduan</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_laporan">Kode Laporan</label>
                                <input type="text" class="form-control form-control-sm" id="kode_laporan" name="kode_laporan" placeholder="Kode Laporan" required value="{{$pengaduan->kode_laporan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_pelapor">Tanggal Pelapor</label>
                                <input type="text" class="form-control form-control-sm" id="tanggal_pelapor" name="tanggal_pelapor" placeholder="Tanggal Pelapor" required value="{{$pengaduan->tanggal_pelaporan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Pelapor</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Pelapor" required value="{{ $pengaduan->pelapor->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_handphone">Nomor Telepon</label>
                                <input type="number" class="form-control form-control-sm" id="nomor_handphone" name="nomor_handphone" placeholder="Nomor Handphone" required value="{{ $pengaduan->nomor_handphone }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lantai">Lantai</label>
                                <input type="number" class="form-control form-control-sm" id="lantai" name="lantai" placeholder="Lantai" required value="{{ $pengaduan->lantai }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi" placeholder="Lokasi" required value="{{ $pengaduan->lokasi }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi">Judul Aduan</label>
                                <input type="text" class="form-control form-control-sm" id="judul_pengaduan" name="judul_pengaduan" placeholder="Judul Pengaduan" required value="{{ $pengaduan->judul_pengaduan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control form-control-sm" id="kategori_pengaduan_id" name="kategori_pengaduan_id" disabled>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoriPengaduan as $key => $value)
                                        <option value="{{ $value->id }}" {{ $pengaduan->kategori_pengaduan_id == $value->id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dekskripsi_pelaporan">Deskripsi</label>
                                <textarea id="dekskripsi_pelaporan" name="dekskripsi_pelaporan" class="form-control form-control-sm" rows="3" placeholder="Deskripsi Pengaduan" required disabled>{{ $pengaduan->dekskripsi_pelaporan }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dekskripsi_pelaporan">Kondisi Pengaduan</label>
                                <div class="row image-gallery">
                                    @foreach ($gambarPengaduan as $key => $value)
                                        <a href="{{ $value->picture }}" class="col-6 col-md-3 mb-4" data-toggle="lightbox">
                                            <img src="{{ $value->picture }}" class="img-fluid" style="width: 100%; object-fit: cover; height: 100px;">
                                        </a>   
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @Worker
            <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" id="form-pengaduan">
                @csrf
                @method('PUT')
            @endWorker
                <div class="card">
                    <div class="card-header">
                        <div>Kondisi Pengaduan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Prioritas <span class="required-label">*</span></label>
                            <select class="form-control form-control-sm" id="prioritas" name="prioritas" @if(strtolower($pengaduan->status_pelaporan) == 'done' || auth()->user()->role == 'User') @disabled(true) @endif>
                                <option value="">-- Pilih Prioritas --</option>
                                <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Pengaduan <span class="required-label">*</span></label>
                            @php
                            $status = [
                                'waiting' => 'Menunggu',
                                'progress' => 'Proses',
                                'done' => 'Selesai',
                            ];
                            @endphp
                            <select class="form-control form-control-sm" id="status_pelaporan" name="status_pelaporan" @if(strtolower($pengaduan->status_pelaporan) == 'done' || auth()->user()->role == 'User') @disabled(true) @endif>
                                <option value="">-- Pilih Status Pengaduan --</option>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}" {{ $key == strtolower($pengaduan->status_pelaporan) ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group select2-input">
                            <label>Ditugaskan Kepada</label>
                            <select class="form-control form-control-sm" id="workers" name="workers[]" multiple required style="width: 100%" @if(strtolower($pengaduan->status_pelaporan) == 'done' || auth()->user()->role == 'User') @disabled(true) @endif>
                                @Worker
                                <option value="">-- Pilih Orang --</option>
                                @foreach ($workers as $key => $value)
                                    <option value="{{ $value->id }}" {{ in_array($value->id, $pengaduan->workers->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                                @endWorker
                            </select>
                        </div>
                        <div class="form-group" id="imageFixing">
                            <label for="dekskripsi_pelaporan">Kondisi Setelah Perbaikan</label>
                            @if(strtolower($pengaduan->status_pelaporan) != 'done') 
                            <input type="file" class="form-control" id="imageInput" name="picture_post[]" multiple  accept=".jpg, .jpeg, .png"/>
                            @endif
                            <div id="preview" class="mt-3 row"></div>
                            <button type="button" class="btn btn-sm btn-danger mt-3" id="btnDelete" style="display:none;">Hapus Gambar</button>
                            <div class="row image-gallery">
                                @if($gambarPerbaikanPengaduan->count() > 0)
                                    @foreach ($gambarPerbaikanPengaduan as $key => $value)
                                        <a href="{{ $value->picture }}" class="col-6 col-md-3 mb-4" data-toggle="lightbox">
                                            <img src="{{ $value->picture }}" class="img-fluid" style="width: 100%; object-fit: cover; height: 100px;">
                                        </a>   
                                    @endforeach
                                @else
                                <div class="col-12">
                                    <p class="text-center">Tidak ada gambar</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if(strtolower($pengaduan->status_pelaporan) != 'done') 
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="stayPaged" name="stayPaged">
                                <span class="form-check-sign">Tetap dihalaman ini</span>
                            </label>
                        </div>
                        @endif
                    </div>
                    <div class="card-action text-right">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-xs btn-black"><i class="mr-2 fa fa-arrow-left"></i> Kembali</a>
                        @Worker
                            @if($pengaduan->status_pelaporan != 'done') 
                                <button type="submit" class="btn btn-xs btn-success">Perbarui Kondisi <i class="ml-2 fa fa-save"></i></button>
                            @endif
                        @endWorker
                    </div>
                </div>
            @Worker
            </form>
            @endWorker
        </div>
    </div>
</div>
@endsection
@push('styles')
<link href="{{ asset('/assets/js/plugin/ekko-lightbox/ekko-lightbox.min.css') }}" rel="stylesheet" />  
@endpush
@push('script')
<script src="{{ asset('/assets/js/plugin/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugin/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        $("#workers").select2({
            placeholder: "-- Pilih Worker --",
            theme: 'bootstrap',
        });

        var statusPelaporan = $('#status_pelaporan');
        var inputGambar = $('#imageFixing');
        inputGambar.hide();
        function toggleInputGambar() {
            if (statusPelaporan.val() === 'done') {
                inputGambar.show();
            } else {
                inputGambar.hide();
            }
        }
        toggleInputGambar();
        statusPelaporan.change(function() {
            toggleInputGambar();
        });

        $('#form-pengaduan').submit(function(e) {
            if (statusPelaporan.val() === 'done') {
                e.preventDefault();
                swal({
                    title: "Apakah anda yakin?",
                    text: "Apakah anda yakin ingin mengubah status pelaporan menjadi selesai?, karena jika sudah selesai data tidak dapat diubah lagi",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons : {
                        cancel: {
                            text : 'Batal',
                            visible: true,
                            className : 'btn btn-secondary'
                        },
                        confirm: {
                            text : "Ya, Lanjutkan",
                            className : "btn btn-primary"
                        }
                    }
                }).then(function (submit) {
                    if (submit) {
                        $('#form-pengaduan').unbind('submit').submit();
                    }
                });
                return false;
            }
        });
    });
</script>
@endpush