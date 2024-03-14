@extends('partial.layout.main')
@section('title', 'Pengaduan')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Pengaduan</h4>
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

@push('script')
<script src="{{ ('/assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script >
    $(document).ready(function() {
            $('#basic-datatables').DataTable({
                processing: true,
                serverSide: true,
                sortable: false,
                ajax: {
                    url : window.location.origin + '/api/get_pengaduan_yajra',
                    type: 'GET',
                    headers: {"Authorization": localStorage.getItem('access_token')}
                },
                columns: [
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
                            return '<a href="/kategori_pengaduan/'+row.id+'/edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> <button data-id="'+row.id+'" type="button" class="btn btn-danger btn-sm" id="hapus">Hapus</button>';
                        }
                    }
                ],
            });


            $(document).on('click', '#hapus', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    title: 'Hapus Data',
                    text: "Apakah kamu yakin ingin menghapus ini",
                    type: 'warning',
                    buttons: {
                        cancel: {
                            visible: true,
                            text : 'Batal',
                            className: 'btn btn-danger'
                        },        			
                        confirm: {
                            text : 'Hapus',
                            className : 'btn btn-success'
                        }
                    }
                }).then((Delete) => {
                    if (Delete) {
                        $.ajax({
                            url : window.location.origin + '/api/del_worker_from_pengaduan/'+id,
                            type: 'DELETE',
                            headers: {"Authorization": localStorage.getItem('access_token')},
                            success: function(response) {
                                console.log(response);
                                swal({
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus',
                                    type: 'success',
                                    timer: '1500'
                                });
                                $('#basic-datatables').DataTable().ajax.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                swal({
                                    title: 'Gagal',
                                    text: 'Data gagal dihapus',
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



            // $.ajax({
            //     url : window.location.origin + '/api/get_pengaduan_yajra',
            //     type: 'GET',
            //     headers: {"Authorization": localStorage.getItem('access_token')}
            // }).done(function(response){
            //     console.log(response);
            // }).fail(function(error){
            //     console.log(error);
            // });
 
        });
    
</script>
@endpush