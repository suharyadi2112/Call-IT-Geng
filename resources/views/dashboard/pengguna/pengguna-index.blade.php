@extends('partial.layout.main')
@section('title', 'Master Pengguna')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Pengguna</h4>
    @include('partial.layout.error_message')
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <div class="ml-auto">
                            <a href="{{ route('pengguna.create') }}" class="btn btn-sm btn-success">
                                <i class="fa fa-plus"></i> Tambah Pengguna
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Peran</th>
                                    <th>Dibuat</th>
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
@endsection

@push('style')
<style>
    td.details-control {
        background: url("{{ asset('/assets/img/details_open.png') }}") no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url("{{ asset('/assets/img/details_close.png') }}") no-repeat center center;
    }
    div.slider {
        display: none;
    }
    </style> 
@endpush

@push('script')
<script src="{{ ('/assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script >
    $(document).ready(function() {
        var table= $('#basic-datatables').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '{{ route('pengguna.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '5%', orderable: false, searchable: false},
                { data: 'name', name: 'name'},
                { data: 'jabatan', name: 'jabatan' },
                { data: 'divisi', name: 'divisi' },
                { data: 'role', name: 'role'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action', name: 'action'}
            ],
        });
        
        $('body').on('click', '#modalDelete', function() {
            var id = $(this).data('id');
            swal({
                title: 'Hapus Data',
                text: "Apakah anda yakin ingin menghapus data ini?",
                type: 'warning',
                buttons:{
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-secondary',
                    },
                    confirm: {
                        text : 'Hapus',
                        className : 'btn btn-danger'
                    },
                    
                }
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({
                        url : window.location.pathname + '/' + id + '/hapus',
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE'
                        },
                        success: function (data) {
                            table.ajax.reload();
                            swal({
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                                type: 'success',
                                timer: '1500'
                            });
                        },

                        error: function (data) {
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
        })

    });
</script>
@endpush