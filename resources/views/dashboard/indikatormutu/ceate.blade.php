@extends('partial.layout.main')
@section('title', 'Indikator Mutu')
@section('content')
    <div class="page-inner">
        <h4 class="page-title">Tambah Indikator Mutu
        </h4>
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="POST" action="{{ route('indikatormutu.store') }}">
                                @csrf
                                <table id="basic-datatables" class="  table ">

                                    <tbody>
                                        <tr>
                                            <td width="30%">Nama Indikator</td>
                                            <td width="70%">
                                                <input type="text" name="nama_indikator"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('nama_indikator') }}" />
                                                @error('nama_indikator')
                                                    <span class="text-danger">Nama Indiktor Harus di Isi</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Target (Persentase)</td>
                                            <td>
                                                <input type="number" name="target" class="form-control form-control-sm" />
                                                @error('target')
                                                    <span class="text-danger">Persentase Target Harus Diisi</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input type="submit" value="Simpan" class="btn btn-primary btn-sm" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
