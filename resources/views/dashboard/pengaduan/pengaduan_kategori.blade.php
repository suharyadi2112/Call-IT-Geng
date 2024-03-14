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
                                <button type="button" class="btn btn-sm btn-success" id="alert_demo_5">
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


@endsection

@push('script')
    <script src="{{ '/assets/js/plugin/datatables/datatables.min.js' }}"></script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({
                processing: true,
                serverSide: true,
                sortable: false,
                ajax: {
                    url: window.location.origin + '/api/get_kategori_pengaduan_yajra',
                    type: 'GET',
                    headers: {
                        "Authorization": '   Bearer ' + localStorage.getItem('access_token')
                    }
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return '<a href="/pengaduan_kategori/' + row.id +
                                '/edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a> <button data-id="' +
                                row.id +
                                '" type="button" class="btn btn-danger btn-sm" id="hapus">Hapus</button>';
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
                            text: 'Batal',
                            className: 'btn btn-danger'
                        },
                        confirm: {
                            text: 'Hapus',
                            className: 'btn btn-success'
                        }
                    }
                }).then((Delete) => {
                    if (Delete) {
                        $.ajax({
                            url: window.location.origin + '/api/del_kategori_pengaduan/' +
                                id,
                            type: 'DELETE',
                            headers: {
                                "Authorization": localStorage.getItem('access_token')
                            },
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
            //     url: window.location.origin + '/api/get_kategori_pengaduan_yajra',
            //     type: 'GET',
            //     headers: {
            //         "Authorization": '   Bearer '+localStorage.getItem('access_token')
            //     }
            // }).done(function(response) {
            //     console.log(response);
            // }).fail(function(error) {
            //     console.log(error);
            // });

        });
    </script>
    <script>
        //== Class definition
        var SweetAlert2Demo = function() {

            //== Demos
            var initDemos = function() {
                //== Sweetalert Demo 1


                $('#alert_demo_5').click(function(e) {
                    swal({
                        title: 'Nama Kategori',
                        html: '<br><input class="form-control" placeholder="Nama Kategori" name="nama" id="input-field">',
                        content: {
                            element: "input",
                            attributes: {
                                placeholder: "Nama Kategori",
                                type: "text",
                                name: "nama",
                                id: "input-field",
                                className: "form-control"
                            },
                        },
                        buttons: {
                            cancel: {
                                visible: true,
                                className: 'btn btn-danger'
                            },
                            confirm: {
                                className: 'btn btn-success'
                            }
                        },
                    }).then(
                        function() {
                            swal("", "You entered : " + $('#input-field').val(), "success");
                        }
                    );
                });



            };

            return {
                //== Init
                init: function() {
                    initDemos();
                },
            };
        }();

        //== Class Initialization
        jQuery(document).ready(function() {
            SweetAlert2Demo.init();
        });
    </script>
@endpush
