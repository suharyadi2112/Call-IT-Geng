<?php

namespace App\Http\Controllers;

use App\Exports\PengaduanExport;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
// use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    //
    public function index()
    {
        $tahun = Pengaduan::selectRaw('year(tanggal_pelaporan) year')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        $pengaduan = Pengaduan::get();
        // dd($tahun);
        return view('dashboard.laporan.index', ['tahun' => $tahun, 'pengaduan' => $pengaduan]);
    }

    public function getlaporan(Request $request)
    {
        $pengaduan = Pengaduan::select('id')
            ->with('pelapor:name') // Memuat relasi pelapor dengan hanya mengambil kolom id dan name
            ->whereMonth('tanggal_pelaporan', $request->bulan)
            ->whereYear('tanggal_pelaporan', $request->tahun)
            ->get();

        return Excel::download(new PengaduanExport($pengaduan), 'laporan.xlsx');
    }
}
