@extends('partial.layout.main')
@section('title', 'Buat Pengaduan')
@section('content')
<div class="page-inner">
    <h4 class="page-title">Buat Pengaduan</h4>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Pengaduan</div>
                </div>
                <div class="card-body">
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
                </div>
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <button class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pilihan</div>
                </div>
                <div class="card-body">
                    <label class="mb-3"><b>Form Group Default</b></label>
                    <div class="form-group form-group-default">
                        <label>Input</label>
                        <input id="Name" type="text" class="form-control" placeholder="Fill Name">
                    </div>
                    <div class="form-group form-group-default">
                        <label>Select</label>
                        <select class="form-control" id="formGroupDefaultSelect">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <label class="mt-3 mb-3"><b>Form Floating Label</b></label>
                    <div class="form-group form-floating-label">
                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required>
                        <label for="inputFloatingLabel" class="placeholder">Input</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <select class="form-control input-border-bottom" id="selectFloatingLabel" required>
                            <option value="">&nbsp;</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <label for="selectFloatingLabel" class="placeholder">Select</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="inputFloatingLabel2" type="text" class="form-control input-solid" required>
                        <label for="inputFloatingLabel2" class="placeholder">Input</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <select class="form-control input-solid" id="selectFloatingLabel2" required>
                            <option value="">&nbsp;</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <label for="selectFloatingLabel2" class="placeholder">Select</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush