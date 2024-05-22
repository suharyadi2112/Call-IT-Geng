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
                            <div>Daftar Kategori</div>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-xs btn-success" data-toggle="modal"
                                    data-target="#insertModal" id="insertModalBtn">
                                    <i class="fa fa-plus"></i> Tambah Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data" class="table table-bordered"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="categoryForm" name="categoryForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">Input Data Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Kategori</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-border border-width-2" placeholder="Nama Kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar Kategori</label>
                            <input type="file" name="gambar" id="gambar" class="form-control form-control-border border-width-2" placeholder="Gambar Kategori" required accept=".jpg, .jpeg, .png"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveOrUpdateBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection

@push('style')
    <style>
    th.dt-center, td.dt-center { text-align: center; }
    </style> 
@endpush

@push('script')
    <script src="{{ '/assets/js/plugin/datatables/datatables.min.js' }}"></script>
    <script>
        $(function() {
            var table = $('#data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '{{ route('kategori.index') }}',
                pageLength : 20,
                columns: [
                    {
                        class : "dt-center",
                        data : 'gambar',
                        name : 'gambar',
                        width : '10%',
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });


            $('#insertModalBtn').click(function() {
                clearForm();
                $('#saveOrUpdateBtn').val("create-data");
                $('#categoryModalLabel').html("Tambah Data");
                $('#saveOrUpdateBtn').html('Simpan');
                $('#categoryModal').modal('show');
            });

            $('body').on('click', '#modalEdit', function() {
                var id = $(this).data('id');
                $.get("{{ route('kategori.index') }}" + '/show/' + id, function(data) {
                    clearForm();
                    $('#categoryModalLabel').html("Edit Data");
                    $('#saveOrUpdateBtn').val("update-data");
                    $('#saveOrUpdateBtn').html('Simpan');
                    $('#categoryModal').modal('show');
                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                });
            });

            function clearForm() {
                $('#categoryForm').trigger("reset");
                $('#saveOrUpdateBtn').val("");
                $('#id').val('');
                $('#saveOrUpdateBtn').prop("disabled", false);
            }

            $('#saveOrUpdateBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Mengirim...');
                $('#saveOrUpdateBtn').prop("disabled", true);
                $('.alert').remove();

                var formData = new FormData($('#categoryForm')[0]);
                var url = $('#saveOrUpdateBtn').val() == "create-data" ? "{{ route('kategori.store') }}" : "{{ route('kategori.update') }}";
                
                $.ajax({
                    data: formData,
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#saveOrUpdateBtn').html('Simpan');
                        clearForm();
                        table.draw();
                        $('#categoryModal').modal('hide');
                    },
                    error: function(data) {
                        var errorList = '<ul>';
                        $.each(data.responseJSON.errors, function(key, value) {
                            $.each(value, function(i, error) {
                                errorList += '<li>' + error + '</li>';
                            });
                        });
                        errorList += '</ul>';
                        $('.modal-body').prepend(
                            '<div class="alert alert-danger" role="alert">' + errorList + '</div>'
                        );
                        $('#saveOrUpdateBtn').html('Simpan');
                        $('#saveOrUpdateBtn').prop("disabled", false);
                    }
                });
            });

            $('body').on('click', '#modalDelete', function() {
                var id = $(this).data('id');
                swal({
                    title: 'Hapus Data',
                    text: "Apakah anda yakin ingin menghapus data ini?",
                    type: 'warning',
                    buttons: {
                        cancel: {
                            visible: true,
                            text: 'Batal',
                            className: 'btn btn-secondary',
                        },
                        confirm: {
                            text: 'Hapus',
                            className: 'btn btn-danger'
                        },
                    }
                }).then((Delete) => {
                    if (Delete) {
                        $.ajax({
                            url: window.location.pathname + '/' + id + '/hapus',
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE'
                            },
                            success: function(data) {
                                table.ajax.reload();
                                swal({
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus',
                                    type: 'success',
                                    timer: '1500'
                                });
                            },
                            error: function(data) {
                                swal({
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan! Coba lagi',
                                    type: 'error',
                                    timer: '1500'
                                });
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
            });



        });
    </script>
@endpush
