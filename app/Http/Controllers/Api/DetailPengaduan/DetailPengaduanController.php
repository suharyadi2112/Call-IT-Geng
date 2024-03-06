<?php

namespace App\Http\Controllers\Api\DetailPengaduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//model
use App\Models\DetailIPengaduan;

class DetailPengaduanController extends Controller
{
    public function GetDetailPengaduan(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $page = $request->input('page');

        try {
        
            $query = DetailIPengaduan::query();
            if ($search) {
                $query->search($search);
            }
            $query->orderBy('created_at', 'desc');
            $getDetailPengaduan = $query->paginate($perPage);

            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getDetailPengaduan], 200);

        } catch (\Exception $e) {

            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }
}

