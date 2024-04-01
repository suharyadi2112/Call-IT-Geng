@extends('partial.layout.main')
@section('title', 'Pengaduan')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Pengaduan</h4>
    @include('partial.layout.error_message')
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Pengaduan</h4>
                        <div class="ml-auto">
                            <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-success">
                                <i class="fa fa-plus"></i> Tambah Pengaduan
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
                                    <th>Kode Laporan</th>
                                    <th>Aduan</th>
                                    <th>Lantai</th>
                                    <th>Lokasi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Pelapor</th>
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
            ajax: '{{ route('pengaduan.index') }}',
            columns: [
                {
                    class : "details-control",
                    orderable : false,
                    defaultContent : "",
                }, 
                { data: 'kode_laporan', name: 'kode_laporan' , width: '5%'},
                { data: 'judul_pengaduan', name: 'judul_pengaduan' },
                { data: 'lantai', name: 'lantai' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'prioritas', name: 'prioritas' },
                { data: 'status_pelaporan', name: 'status_pelaporan' },
                { data: 'pelapor.name', name: 'pelapor.name' },
            ],
        });

        $('#basic-datatables tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            table.rows().every(function () {
                if (this.child.isShown() && !$(this.node()).is(tr)) {
                    this.child.hide();
                    $(this.node()).removeClass('shown');
                }
            });

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
        function format ( d ) {
            let workerData = '';
            if (Object.keys(d.workers).length !== 0) {
                workerData += '<tr><td>Pengerjaan:</td><td>';
                for (let key in d.workers) {
                    if (d.workers.hasOwnProperty(key)) {
                        workerData += d.workers[key].name + '<br>';
                    }
                }
                workerData += '</td></tr>';
            }
            return '<table class="display table table-bordered" style="width: 100%">'+
                '<tr>'+
                    '<td>Kategori : </td>'+
                    '<td>'+d.kategoripengaduan.nama+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Tanggal Lapor : </td>'+
                    '<td>'+d.tanggal_pelaporan+'</td>'+
                    '<td>Tanggal Selesai:</td>'+
                    '<td>'+d.tanggal_selesai+'</td>'+
                '</tr>'+
                    workerData + 
                '<tr>'+
                    '<td>Aksi</td>'+
                    '<td>'+d.action+'</td>'+
                '</tr>'+
            '</table>';
        }

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