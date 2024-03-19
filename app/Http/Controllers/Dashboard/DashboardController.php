<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $worker = User::where('divisi', 'IT')->get();
        $info = Pengaduan::latest()->take(5)->get();
        $pengaduan = Pengaduan::select('kategori_pengaduan_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_pengaduan_id')
            ->orderBy('total', 'desc')
            ->get('total', 'kategori_pengaduan_id');
        $belum = Pengaduan::where('status_pelaporan', 'waiting')->get();
        $sedang = Pengaduan::where('status_pelaporan', 'progress')->get();
        $sudah = Pengaduan::where('status_pelaporan', 'done')->get();
        $today = Pengaduan::whereDate('tanggal_pelaporan', '=', Carbon::today())->get();
        $bulan = Pengaduan::whereMonth('tanggal_pelaporan', Carbon::now()->format('m'))->get();
        $bulankategori = Pengaduan::whereMonth('tanggal_pelaporan', Carbon::now()->format('m'))
            ->select('kategori_pengaduan_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_pengaduan_id')
            ->orderBy('total', 'desc')
            ->get('total', 'kategori_pengaduan_id');
        return view(
            'dashboard.dashboard',
            [
                'worker' => $worker,
                'info' => $info,
                'pengaduan' => $pengaduan,
                'belum' => $belum,
                'sedang' => $sedang,
                'sudah' => $sudah,
                'today' => $today,
                'bulan' => $bulan,
                'bulankategori' => $bulankategori,
            ]
        );
    }
}
