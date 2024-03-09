@extends('partial.layout.main')
@section('title', 'Indikator Mutu')
@section('content')
    <div class="page-inner">
        {{-- <h4 class="page-title">Indikator Mutu <a href="{{ route('indikatormutu.create') }}"
                class="btn btn-sm btn-primary float-right">Tambah Indikator</a>
        </h4> --}}
        <div class="row">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Indikator Mutu</th>
                                    <th>Target</th>
                                    <th> </th>

                                </tr>
                            </thead>

                            {{-- <tbody>
                                @forelse ($indikators as $i=> $indikator)
                                    <tr>
                                        <td> {{ $i + 1 }}</td>
                                        <td>{{ $indikator->nama_indikator }}</td>
                                        <td>{{ $indikator->target }} %</td>
                                        <td>
                                            <i class="fa fa-edit m-3"></i>
                                            <i class="fa fa-trash"></i>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan=4>Tidak Ada data Indikator Mutu</td>

                                    </tr>
                                @endforelse

                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
