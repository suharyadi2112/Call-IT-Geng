@extends('partial.layout.main')
@section('title', 'Kategori')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Kategori</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Daftar Kategori</h4>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <i class="fa fa-plus"></i> Tambah Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Action</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Input Data Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Kategori</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control form-control-border border-width-2" placeholder="Nama Kategori"
                                required>
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
                        <h5 class="modal-title" id="updateModalLabel">Update Data Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Kategori</label>
                            <input type="text" name="namaupdate" id="namaupdate"
                                class="form-control form-control-border border-width-2" placeholder="Nama Kategori"
                                required>
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
                ajax: "{{ route('kategori.index') }}",
                columns: [{
                        data: 'nama',
                        name: 'nama'
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
                $('#postForm').trigger("reset");
                $('#modal-title').html("Tambah Data");
                // $('#modalOpen').modal('show');
            });

            

            $('body').on('click', '#modalEdit', function() {
                var id = $(this).data('id');
                // alert(id);
                $.get("{{ route('kategori.index') }}" + '/show/' + id, function(data) {
                    $('#modal-title').html("Edit Data");
                    $('#updateBtn').val("create-data");
                    $('#updateModal').modal('show');
                    $('#idupdate').val(data.id);
                    $('#namaupdate').val(data.nama);
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
                    url: "{{ route('kategori.update') }}",
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
                    url: "{{ route('kategori.store') }}",
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
