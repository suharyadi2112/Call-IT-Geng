<?php

namespace App\Http\Controllers\Api\DashboardHome;

use App\Http\Controllers\Controller;
use App\Events\LaporPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//model
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\DetailIPengaduan;
use App\Models\KatPengaduan;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class DashboardHomeController extends Controller
{
    
    public function DataDashboardHome(Request $request){

        try {

            $totalPersenPengaduan = $this->hitungTotalPersenPengaduan($request);
            $totalPersenPrioritas = $this->hitungTotalPersenPrioritas($request);
            $totalPersenKategori = $this->hitungTotalKategori($request);
            $totalPersenLantai = $this->hitungTotalLantai($request);
            $getPengaduanActivity = $this->getPengaduanActivity();
            $data = [
                    "totalPersenPengaduan" => $totalPersenPengaduan,
                    "totalPersenPrioritas" => $totalPersenPrioritas,
                    "totalPersenKategori" => $totalPersenKategori,
                    "totalPersenLantai" => $totalPersenLantai,
                    "getPengaduanActivity" => $getPengaduanActivity,
                    ];
    
            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $data], 200);
        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    
    protected function hitungTotalPersenPengaduan(Request $request) {

        $rules = [
            'interval' => 'in:today,month,year',
        ];
        $messages = [
            'interval.in' => 'Interval must be one of: today, month, year.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        list($currentDate, $previousDate) = $this->getDateRange($request->input('interval'));

        $currentCount = $this->getPengaduanCount($currentDate, $request->interval);
        $previousCount = $this->getPengaduanCount($previousDate, $request->interval);

        $increasePercentage = $this->calculateIncreasePercentage($currentCount, $previousCount);

        return [
            'current_count' => $currentCount,
            'previous_count' => $previousCount,
            'increase_percentage' => $increasePercentage,
            'interval' => $request->interval,
        ];
    }

    protected function hitungTotalLantai(Request $request) {

        $lantai = $request->lantai;

        if ($lantai == '-') {

            $lantai = $this->getRandomLantaiMostMonth();

        }

        list($currentDate, $previousDate) = $this->getDateRange($request->input('intervalLantai'));

        $currentCount = $this->getLantaiCount($currentDate, $request->intervalLantai, $lantai);
        $previousCount = $this->getLantaiCount($previousDate, $request->intervalLantai, $lantai);
        
        $increasePercentage = $this->calculateIncreasePercentage($currentCount, $previousCount);

        return [
            'current_count' => $lantai ? $currentCount : 0,
            'previous_count' => $lantai ? $previousCount : 0,
            'increase_percentage' => $lantai ? $increasePercentage : 0,
            'interval' => $request->intervalLantai,
            'lantai' => $lantai ? $lantai : '-',
        ];
    }

    protected function hitungTotalKategori(Request $request) {

        $kategoriId = $request->kategori_id;

        if ($kategoriId == '-') {

            $kategoriId = $this->getRandomkategoriMostMonth();

        }

        list($currentDate, $previousDate) = $this->getDateRange($request->input('intervalKategori'));

        $currentCount = $this->getKategoriCount($currentDate, $request->intervalKategori, $kategoriId);
        $previousCount = $this->getKategoriCount($previousDate, $request->intervalKategori, $kategoriId);
        
        $increasePercentage = $this->calculateIncreasePercentage($currentCount, $previousCount);

        $kategoriName = Pengaduan::with('kategoripengaduan')->where('kategori_pengaduan_id', $kategoriId)->first(); //hanya ambil nama

        return [
            'current_count' => $kategoriId ? $currentCount : 0,
            'previous_count' => $kategoriId ? $previousCount : 0,
            'increase_percentage' => $kategoriId ? $increasePercentage : 0,
            'interval' => $request->intervalKategori,
            'kategori' => $kategoriId ? $kategoriName->kategoripengaduan->nama : '-',
        ];
    }


    protected function hitungTotalPersenPrioritas(Request $request) {

        $rules = [
            'intervalPrioritas' => 'in:today,month,year',
            'prioritas' => 'in:tinggi,sedang,rendah',
        ];
        $messages = [
            'intervalPrioritas.in' => 'Interval must be one of: today, month, year.',
            'prioritas.in' => 'Prioritas must be one of: tinggi, sedang, rendah.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        list($currentDate, $previousDate) = $this->getDateRange($request->input('intervalPrioritas'));

        $currentCount = $this->getPrioritasCount($currentDate, $request->intervalPrioritas, $request->prioritas);
        $previousCount = $this->getPrioritasCount($previousDate, $request->intervalPrioritas, $request->prioritas);

        $increasePercentage = $this->calculateIncreasePercentage($currentCount, $previousCount);

        return [
            'current_count' => $currentCount,
            'previous_count' => $previousCount,
            'increase_percentage' => $increasePercentage,
            'prioritas' => $request->prioritas,
            'interval' => $request->intervalPrioritas,
        ];
    }

    protected function getDateRange($interval){
        switch ($interval) {
            case 'today':
                $currentDate = date('Y-m-d');
                $previousDate = date('Y-m-d', strtotime('-1 day'));
                break;
            case 'month':
                $currentDate = date('m');
                $previousDate = date('m', strtotime('-1 month'));
                break;
            case 'year':
                $currentDate = date('Y');
                $previousDate = date('Y', strtotime('-1 year'));
                break;
            default: //default bulan
                throw new \InvalidArgumentException("Invalid interval");
        }

        return [$currentDate, $previousDate];
    }

        
    protected function getPengaduanCount($date, $intvl){   

        if($intvl == "today"){
            $currentCount = Pengaduan::whereDate('tanggal_pelaporan', $date)->count();
        }else if($intvl == "month"){
            $currentCount = Pengaduan::whereMonth('tanggal_pelaporan', $date)
            ->count();
        }else if($intvl == "year"){
            $currentCount = Pengaduan::whereYear('tanggal_pelaporan', $date)->count();
        }

        return $currentCount;
    }

    protected function getLantaiCount($date, $intvl, $lantai){   

        if($intvl == "today"){
            $currentCount = Pengaduan::where('lantai', $lantai)->whereDate('tanggal_pelaporan', $date)->count();
        }else if($intvl == "month"){
            $currentCount = Pengaduan::where('lantai', $lantai)->whereMonth('tanggal_pelaporan', $date)->count();
        }else if($intvl == "year"){
            $currentCount = Pengaduan::where('lantai', $lantai)->whereYear('tanggal_pelaporan', $date)->count();
        }

        return $currentCount;
    }

    protected function getPrioritasCount($date, $intvl, $prioritas){   

        if($intvl == "today"){
            $currentCount = Pengaduan::where('prioritas', $prioritas)->whereDate('tanggal_pelaporan', $date)->count();
        }else if($intvl == "month"){
            $currentCount = Pengaduan::where('prioritas', $prioritas)->whereMonth('tanggal_pelaporan', $date)->count();
        }else if($intvl == "year"){
            $currentCount = Pengaduan::where('prioritas', $prioritas)->whereYear('tanggal_pelaporan', $date)->count();
        }

        return $currentCount;
    }

    protected function getKategoriCount($date, $intvl, $kategoriId){   
        if ($intvl == "today") {
            $currentCount = Pengaduan::where('kategori_pengaduan_id', $kategoriId)->whereDate('tanggal_pelaporan', $date)->count();
        } else if ($intvl == "month") {
            $currentCount = Pengaduan::where('kategori_pengaduan_id', $kategoriId)->whereMonth('tanggal_pelaporan', $date)->count();
        } else if ($intvl == "year") {
            $currentCount = Pengaduan::where('kategori_pengaduan_id', $kategoriId)->whereYear('tanggal_pelaporan', $date)->count();
        }

        return $currentCount;
    }

    protected function getRandomkategoriMostMonth(){
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $jumlahPerKategori = Pengaduan::whereBetween('tanggal_pelaporan', [$startDate, $endDate])
            ->select('kategori_pengaduan_id', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_pengaduan_id')
            ->orderByDesc('total')
            ->first();

        if ($jumlahPerKategori) {
            $kategoriTerbanyakId = $jumlahPerKategori->kategori_pengaduan_id;
            
            return $kategoriTerbanyakId;
        } else {
            return false;
        }
    }

    protected function getRandomLantaiMostMonth(){
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $jumlahPerLantai = Pengaduan::whereBetween('tanggal_pelaporan', [$startDate, $endDate])
            ->select('lantai', DB::raw('COUNT(*) as total'))
            ->groupBy('lantai')
            ->orderByDesc('total')
            ->first();

        if ($jumlahPerLantai) {
            $lantaiTerbanyak = $jumlahPerLantai->lantai;
            
            return $lantaiTerbanyak;
        } else {
            return false;
        }
    }

    protected function calculateIncreasePercentage($currentCount, $previousCount)
    {
        if ($previousCount > 0) {
            return ($currentCount - $previousCount) / $previousCount * 100;
        }

        return 0;
    }

    protected function calculatePriority($currentCount,$previousCount){

        if ($previousCount > 0) {
            return ($currentCount - $previousCount) / $previousCount * 100;
        }

        return 0;
    }

    protected function calculateKategori($currentCount,$previousCount){

        if ($previousCount > 0) {
            return ($currentCount - $previousCount) / $previousCount * 100;
        }

        return 0;
    }


    // -----------------recent activity--------------------//
    protected function getPengaduanActivity(){
        $pengaduan = Pengaduan::select('id', 'judul_pengaduan', 'prioritas', 'tanggal_pelaporan')->orderBy('tanggal_pelaporan', 'desc')->limit(10)->get();

        // Memeriksa apakah data pengaduan kosong
        if ($pengaduan->isEmpty()) {
            return null;
        }

        foreach ($pengaduan as $p) {
            $tanggalPelaporan = strtotime($p->tanggal_pelaporan);
            $tanggalSekarang = time();
            $selisihDetik = $tanggalSekarang - $tanggalPelaporan;
        
            // Hitung selisih waktu dalam tahun, bulan, hari, dan jam
            $tahun = floor($selisihDetik / (365 * 24 * 3600));
            $sisaDetik = $selisihDetik % (365 * 24 * 3600);
            $bulan = floor($sisaDetik / (30 * 24 * 3600));
            $sisaDetik %= (30 * 24 * 3600);
            $hari = floor($sisaDetik / (24 * 3600));
            $sisaDetik %= (24 * 3600);
            $jam = floor($sisaDetik / 3600);
        
            $lamaWaktu = "";
            if ($tahun > 0) {
                $lamaWaktu .= $tahun . " tahun ";
            }
            if ($bulan > 0) {
                $lamaWaktu .= $bulan . " bulan ";
            }
            if ($hari > 0) {
                $lamaWaktu .= $hari . " hari ";
            }
            if ($jam > 0) {
                $lamaWaktu .= $jam . " jam ";
            }
            $lamaWaktu = rtrim($lamaWaktu);
        
            $p->lama_waktu = $lamaWaktu;
        }

        return $pengaduan;
    }

}
