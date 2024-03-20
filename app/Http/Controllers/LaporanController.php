<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        return view('dashboard.laporan.index', ['tahun' => $tahun,'pengaduan' => $pengaduan]);
    }

    public function getlaporan(Request $request)
    {
        $tahun = Pengaduan::selectRaw('year(tanggal_pelaporan) year')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        $pengaduan = Pengaduan::whereMonth('tanggal_pelaporan', $request->bulan)
            ->whereYear('tanggal_pelaporan', $request->tahun)
            ->get();
        return view('dashboard.laporan.index', ['tahun' => $tahun,'pengaduan' => $pengaduan]);
    }

}
