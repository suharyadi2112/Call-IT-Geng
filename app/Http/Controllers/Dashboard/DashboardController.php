<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $info = Pengaduan::query()->orderByRaw('CASE 
            WHEN status_pelaporan = "waiting" THEN 1
            WHEN status_pelaporan = "progress" THEN 2
            ELSE 3
        END')
        ->orderBy('created_at', 'desc')
        ->limit(10)->get();
        $pengaduan = Pengaduan::select('kategori_pengaduan_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_pengaduan_id')
            ->orderBy('total', 'desc')
            ->get('total', 'kategori_pengaduan_id');
        $belum = Pengaduan::where('status_pelaporan', 'waiting')->get();
        $sedang = Pengaduan::where('status_pelaporan', 'progress')->get();
        $sudah = Pengaduan::where('status_pelaporan', 'done')->get();
            $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dateRange = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateRange[$date->toDateString()] = 0;
        }
    
        $chartData = [];
        $data = Pengaduan::whereNull('deleted_at')
            ->groupBy(DB::raw('DATE(tanggal_pelaporan)'))
            ->selectRaw('COUNT(*) as total, DATE(tanggal_pelaporan) as tanggal_pelaporan')
            ->pluck('total', 'tanggal_pelaporan')
            ->toArray();
        foreach ($data as $tanggal => $jumlah) {
            $dateRange[$tanggal] = $jumlah;
        }
    
        $chartData = [
            'name' => 'Total Pengaduan',
            'data' => $dateRange,
        ]; 
        return view(
            'dashboard.dashboard',
            [
                'info' => $info,
                'pengaduan' => $pengaduan,
                'belum' => $belum,
                'sedang' => $sedang,
                'sudah' => $sudah,
                'chartData' => $chartData,
            ]
        );
    }
}
