<?php

namespace App\Http\Controllers\Api\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//model
use App\Models\IndikatorMutu;

class IndikatorMutuController extends Controller
{
    public function GetIndikatorMutu(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $page = $request->input('page');

        try {
        
            $query = IndikatorMutu::query();
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
