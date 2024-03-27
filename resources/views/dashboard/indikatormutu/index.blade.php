@extends('partial.layout.main')
@section('title', 'Indikator Mutu')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Indikator Mutu</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Daftar Indikator Mutu</h4>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <i class="fa fa-plus"></i> Tambah Indikator Mutu
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Indikator Mutu</th>
                                        <th>Target</th>
                                        <th>N</th>
                                        <th>D</th>
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="postForm" name="postForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Data Indikator Mutu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_indikator">Nama Indikator Mutu</label>
                            <input type="text" name="nama_indikator" id="nama_indikator"
                                class="form-control form-control-border border-width-2" placeholder="Nama Indikator Mutu"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="target">Target</label>
                            <input type="number" name="target" id="target"
                                class="form-control form-control-border border-width-2" placeholder="Target" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" id="kategori_pengaduan_id" name="kategori_pengaduan_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriPengaduan as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ old('kategori_pengaduan_id') == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="n">N</label>
                            <input type="text" name="n" id="n"
                                class="form-control form-control-border border-width-2" placeholder="N" required>
                        </div>
                        <div class="form-group">
                            <label for="d">D</label>
                            <input type="text" name="d" id="d"
                                class="form-control form-control-border border-width-2" placeholder="D" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateForm" name="updateForm">
                    <input type="hidden" name="idupdate" id="idupdate">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Data Indikator Mutu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Indikator Mutu</label>
                            <input type="text" name="nama_indikator_update" id="nama_indikator_update"
                                class="form-control form-control-border border-width-2" placeholder="Nama Indikator Mutu"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="target">Target</label>
                            <input type="number" name="targetupdate" id="targetupdate"
                                class="form-control form-control-border border-width-2" placeholder="Target" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" id="kategori_pengaduan_id_update" name="kategori_pengaduan_id_update">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriPengaduan as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ old('kategori_pengaduan_id') == $value->id ? 'selected' : '' }}>
                                        {{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="n">N</label>
                            <input type="text" name="n_update" id="n_update"
                                class="form-control form-control-border border-width-2" placeholder="N" required>
                        </div>
                        <div class="form-group">
                            <label for="d">D</label>
                            <input type="text" name="d_update" id="d_update"
                                class="form-control form-control-border border-width-2" placeholder="D" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ '/assets/js/plugin/datatables/datatables.min.js' }}"></script>
    <script>
        $(function() {
            var table = $('#basic-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('indikatormutu.index') }}",
                columns: [{
                        data: 'nama_indikator',
                        name: 'nama_indikator'
                    },
                    {
                        data: 'target',
                        name: 'target'
                    },
                    {
                        data: 'n',
                        name: 'n'
                    },
                    {
                        data: 'd',
                        name: 'd'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });


            $('#exampleModal').click(function() {
                $('#saveBtn').val("create-data");
                $('#id').val('');
                $('#modal-title').html("Tambah Data");
            });



            $('body').on('click', '#modalEdit', function() {
                var id = $(this).data('id');
                // alert(id);
                $.get("{{ route('indikatormutu.index') }}" + '/show/' + id, function(data) {
                    $('#modal-title').html("Edit Data");
                    $('#updateBtn').val("create-data");
                    $('#updateModal').modal('show');
                    $('#idupdate').val(data.id);
                    $('#nama_indikator_update').val(data.nama_indikator);
                    $('#targetupdate').val(data.target);
                    $('#kategori_pengaduan_id_update').val(data.kategori_pengaduan_id);
                    $('#n_update').val(data.n);
                    $('#d_update').val(data.d);
                })
            });

            function clearForm() {
                $('#postForm').trigger("reset");
                $('#updateForm').trigger("reset");
                $('#saveBtn').val("create-data");
                $('#updateBtn').val("edit-data");
                $('#id').val('');
                $('#saveBtn').prop("disabled", false);
                $('#updateBtn').prop("disabled", false);
            }

            $('#updateBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Mengirim');
                $('#updateBtn').prop("disabled", true);
                $('.alert').remove();
                $.ajax({
                    enctype: 'multipart/form-data',
                    data: new FormData($('#updateForm')[0]),
                    url: "{{ route('indikatormutu.update') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        $('#updateBtn').html('Update');
                        clearForm();
                        table.draw();
                        $('#updateModal').modal('hide');

                    },
                    error: function(data) {
                        console.log(data);
                        var errorList = '<ul>';
                        $.each(data.responseJSON.errors, function(key, value) {
                            $.each(value, function(i, error) {
                                errorList += '<li>' + error + '</li>';
                            });
                        });
                        errorList += '</ul>';
                        $('.modal-body').prepend(
                            '<div class="alert alert-danger" role="alert">' + errorList +
                            '</div>');
                        $('#updateBtn').html('Update');
                        $('#updateBtn').prop("disabled", false);
                    }
                });
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Mengirim');
                $('#saveBtn').prop("disabled", true);
                $('.alert').remove();
                $.ajax({
                    enctype: 'multipart/form-data',
                    data: new FormData($('#postForm')[0]),
                    url: "{{ route('indikatormutu.store') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        $('#saveBtn').html('Simpan');
                        clearForm();
                        table.draw();
                        $('#exampleModal').modal('hide');

                    },
                    error: function(data) {
                        console.log(data);
                        var errorList = '<ul>';
                        $.each(data.responseJSON.errors, function(key, value) {
                            $.each(value, function(i, error) {
                                errorList += '<li>' + error + '</li>';
                            });
                        });
                        errorList += '</ul>';
                        $('.modal-body').prepend(
                            '<div class="alert alert-danger" role="alert">' + errorList +
                            '</div>');
                        $('#saveBtn').html('Simpan');
                        $('#saveBtn').prop("disabled", false);
                    }
                });
            });


        });
    </script>
@endpush
