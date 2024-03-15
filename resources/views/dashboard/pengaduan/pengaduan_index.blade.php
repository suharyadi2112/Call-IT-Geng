@extends('partial.layout.main')
@section('title', 'Pengaduan')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Pengaduan</h4>
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

    @if (session('success'))
        <div class="alert alert-success  alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between">
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Pengaduan</h4>
                        <div class="ml-auto">
                            <a href="{{ route('pengaduan.index.create') }}" class="btn btn-sm btn-success">
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
                                    <th>Pengaduan</th>
                                    <th>Lantai</th>
                                    <th>Lokasi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Pelapor</th>
                                    <th>Pengerjaan</th>
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
                { data: 'judul_pengaduan', name: 'judul_pengaduan' },
                { data: 'lantai', name: 'lantai' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'prioritas', name: 'prioritas' },
                { data: 'status_pelaporan', name: 'status_pelaporan' },
                { data: 'pelapor.name', name: 'pelapor.name' },
                { data: 'workers.name', name: 'workers.name', defaultContent: '-' },
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
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                    '<td>Tanggal Lapor : </td>'+
                    '<td>'+d.tanggal_pelaporan+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Tanggal Selesai:</td>'+
                    '<td>'+d.tanggal_selesai+'</td>'+
                '</tr>'+
                '<tr>'+
                '<tr>'+
                    '<td>Kategori : </td>'+
                    '<td>'+d.tanggal_selesai+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Aksi</td>'+
                    '<td>'+d.action+'</td>'+
                '</tr>'+
            '</table>';
        }
    });
</script>
@endpush