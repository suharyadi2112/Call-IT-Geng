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
            $data = ["totalPersenPengaduan" => $totalPersenPengaduan];
    
            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $data], 200);
        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    
    protected function hitungTotalPersenPengaduan(Request $request) {

        $rules = [
            'interval' => 'in:today,month,year',
        ];
        // Pesan validasi jika diperlukan
        $messages = [
            'interval.in' => 'Interval must be one of: today, month, year.',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        // Jika validasi gagal, lempar exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        // Set tanggal sesuai dengan interval yang dipilih
        list($currentDate, $previousDate) = $this->getDateRange($request->input('interval'));

        // Hitung jumlah pengaduan
        $currentCount = $this->getPengaduanCount($currentDate, $request->interval);
        $previousCount = $this->getPengaduanCount($previousDate, $request->interval);

        // Hitung persentase peningkatan
        $increasePercentage = $this->calculateIncreasePercentage($currentCount, $previousCount);

        return [
            'current_count' => $currentCount,
            'previous_count' => $previousCount,
            'increase_percentage' => $increasePercentage,
            'interval' => $request->interval,
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

        
    protected function getPengaduanCount($date, $intvl)
    {   

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

    protected function calculateIncreasePercentage($currentCount, $previousCount)
    {
        if ($previousCount > 0) {
            return ($currentCount - $previousCount) / $previousCount * 100;
        }

        return 0;
    }



}
