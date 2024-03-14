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
                            <a href="{{ route('pengaduan.index.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Tambah Pengaduan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Judul Pengaduan</th>
                                    <th>Lantai</th>
                                    <th>Lokasi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Tgl Lapor</th>
                                    <th>Pelapor</th>
                                    <th>Pengerjaan</th>
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


@endsection

@push('style')

<style>
    td.details-control {
        background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_close.png') no-repeat center center;
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
            $('#basic-datatables').DataTable({
                processing: true,
                serverSide: true,
                sortable: false,
                ajax: '{{ route('pengaduan.index') }}',
                columns: [
                    {
                        class:          "details-control",
                        orderable:      false,
                        defaultContent: "",
                    }, 
                    { data: 'judul_pengaduan', name: 'judul_pengaduan' },
                    { data: 'lantai', name: 'lantai' },
                    { data: 'lokasi', name: 'lokasi' },
                    { data: 'prioritas', name: 'prioritas' },
                    { data: 'status_pelaporan', name: 'status_pelaporan' },
                    { data: 'tanggal_pelaporan', name: 'tanggal_pelaporan' },
                    { data: 'pelapor.name', name: 'pelapor.name' },
                    { data: 'workers.name', name: 'workers.name', defaultContent: '-' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return '<a href="/dashboard/pengaduan/'+row.id+'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>';
                        }
                    }
                ],
            });

            
 
        });
    
</script>
@endpush