<?php

namespace App\Http\Controllers\Api\KategoriPengaduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//model
use App\Models\KatPengaduan;

class KategoriPengaduan extends Controller
{
    public function GetKategoriPengaduan(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $page = $request->input('page');

        try {
        
            $query = KatPengaduan::query();
            if ($search) {
                $query->search($search);
            }
            $query->orderBy('created_at', 'desc');
            $getKatpengaduan = $query->paginate($perPage);

            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getKatpengaduan], 200);

        } catch (\Exception $e) {

            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }
}
