<?php

namespace App\Http\Controllers\Api\Oncall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//model
use App\Models\OncallDetail;

class OncallController extends Controller
{
    public function GetOncallAll(){
        try {
            $query = OncallDetail::query()->orderBy('tanggal_oncall', 'asc')->get();

            return response(["status"=> "success","message"=> "Data list Oncall successfully retrieved", "data" => $query], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetOncallWhoOnThatDate(){
        try {
            
            $data =  OncallDetail::query()
            ->with('detailoncallusers')
            ->orderBy('tanggal_oncall', 'asc')
            ->whereDate('tanggal_oncall', now()->toDateString())
            ->get();

            return response(["status"=> "success","message"=> "Data list Oncall Who On That Date successfully retrieved", "data" => $data], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }
}
