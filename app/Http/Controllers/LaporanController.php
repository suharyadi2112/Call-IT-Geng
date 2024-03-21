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
        $pengaduan = Pengaduan::selectRaw('ROW_NUMBER() OVER (ORDER BY a_pengaduan.id) as no, 
        (SELECT name FROM users WHERE users.id = a_pengaduan.pelapor_id) as name,
        a_pengaduan.lokasi,
        DATE_FORMAT(a_pengaduan.tanggal_pelaporan, "%d-%M-%Y") as tanggal_pelaporan,
        DATE_FORMAT(a_pengaduan.tanggal_pelaporan, "%H:%i") as jam,
        DATE_FORMAT(a_pengaduan.tanggal_selesai, "%d-%M-%Y") as tanggal_selesai,
        DATE_FORMAT(a_pengaduan.tanggal_selesai, "%H:%i") as jam_selesai,
        SEC_TO_TIME(TIMESTAMPDIFF(SECOND, a_pengaduan.tanggal_pelaporan, a_pengaduan.tanggal_selesai)) as durasi,
        a_pengaduan.status_pelaporan,
        CASE 
            WHEN a_pengaduan.status_pelaporan = "done" THEN "Selesai"
            ELSE a_pengaduan.status_pelaporan
        END as status_pelaporan,
        "" as kolom_kosong,
        users.name as worker')
            ->leftJoin('a_pivot_worker_pengaduan as pivot', 'a_pengaduan.id', '=', 'pivot.pengaduan_id')
            ->leftJoin('users', 'pivot.user_id', '=', 'users.id')
            ->whereMonth('a_pengaduan.tanggal_pelaporan', $request->bulan)
            ->whereYear('a_pengaduan.tanggal_pelaporan', $request->tahun)
            ->get();

        return Excel::download(new PengaduanExport($pengaduan), 'laporan.xlsx');
    }
}
