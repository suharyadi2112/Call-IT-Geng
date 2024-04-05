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
        // Ambil data indikator mutu
        $indikator = IndikatorMutu::select('id', 'nama_indikator', 'n', 'd', 'target','kategori_pengaduan_id')->get();

        // Ambil jumlah pengaduan berdasarkan kategori pengaduan
        $jumlahPengaduan = DB::table('a_pengaduan')
            ->select('kategori_pengaduan_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('kategori_pengaduan_id')
            ->get();

        // Memasukkan informasi jumlah pengaduan ke dalam data indikator
        foreach ($indikator as $key => $value) {
            $indikator[$key]->jumlah_pengaduan = 0; // Inisialisasi jumlah pengaduan menjadi 0

            foreach ($jumlahPengaduan as $pengaduan) {
                if ($value->kategori_pengaduan_id == $pengaduan->kategori_pengaduan_id) {
                    $indikator[$key]->jumlah_pengaduan = $pengaduan->jumlah;
                    break; // Keluar dari loop setelah menemukan kecocokan
                }
            }
        }

        // Download file Excel
        return Excel::download(new LaporanIndikatorMutuExport($indikator), 'Laporan Indikator Mutu.xlsx');
    }
}
