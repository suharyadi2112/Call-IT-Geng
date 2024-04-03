<?php

namespace App\Http\Controllers\Api\Oncall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//model
use App\Models\OncallSchedule;

class OncallController extends Controller
{
    public function GetOncallAll(Request $request){
        try {
            $query = OncallSchedule::query()
            ->with(['detailoncall' => function ($query) {
                $query->orderBy('tanggal_oncall', 'asc'); 
            }])
            ->get();

            return response(["status"=> "success","message"=> "Data list Oncall successfully retrieved", "data" => $query], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }
}
