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
                                <a href="" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Tambah Kategori
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $m)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$m->nama}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
            $('#basic-datatables').DataTable({});
        });
    </script>
@endpush
