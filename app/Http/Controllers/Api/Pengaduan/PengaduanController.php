<?php

namespace App\Http\Controllers\Api\Pengaduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//model
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function GetPengaduan(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $page = $request->input('page');

        try {
        
            $query = Pengaduan::query()->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor');
            if ($search) {
                $query->search($search);
            }
            $query->orderBy('created_at', 'desc');
            $getPengaduan = $query->paginate($perPage);

            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getPengaduan], 200);

        } catch (\Exception $e) {

            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }
}
