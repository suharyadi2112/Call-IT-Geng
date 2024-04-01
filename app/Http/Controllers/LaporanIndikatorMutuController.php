<?php

namespace App\Http\Controllers;

use App\Exports\LaporanIndikatorMutuExport;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\IndikatorMutu;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
// use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;



class LaporanIndikatorMutuController extends Controller
{
    public function index()
    {
        $tahun = Pengaduan::selectRaw('year(tanggal_pelaporan) year')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        return view('dashboard.laporanindikatormutu.index', ['tahun' => $tahun]);
    }

    public function getlaporan(Request $request)
    {

        $indikator = IndikatorMutu::select('nama_indikator') // Menambahkan a_pengaduan.id ke dalam GROUP BY
            ->get();
        return Excel::download(new LaporanIndikatorMutuExport($indikator), 'Laporan Indikator Mutu.xlsx');
    }
}
