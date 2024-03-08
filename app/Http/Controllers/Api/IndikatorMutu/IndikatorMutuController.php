<?php

namespace App\Http\Controllers\Api\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;
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

    //datatable
    public function GetIndikatorMutuYajra(){
        try {
            $model = IndikatorMutu::query();
            return DataTables::eloquent($model)->toJson();
        } 
        catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetIndikatorMutuByID($id){

        try {
            $getIndikatorMutuByID = IndikatorMutu::query()->find($id);

            if (!$getIndikatorMutuByID) {
                throw new \Exception('Indikator mutu not found');
            }
            return response()->json(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getIndikatorMutuByID], 200);
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetIndikatorMutuList(){
        try {
            $queryy = IndikatorMutu::query();
            $getIndiktorMutuList = $queryy->orderBy('created_at', 'desc')->select("id","nama_indikator","target")->get(); 
            return response(["status"=> "success","message"=> "Data list indikator mutu successfully retrieved", "data" => $getIndiktorMutuList], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function StoreIndikatorMutu(Request $request){

        $validator = $this->validateIndikatorMutu($request, null, 'insert');  
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => null], 400);
        }
        try {
            
            DB::transaction(function () use ($request) {
                IndikatorMutu::create([
                    'nama_indikator' => strtolower($request->input('nama_indikator')),
                    'target' => strtolower($request->input('target')),
                ]);
            });
            return response()->json(["status"=> "success","message"=> "Data indikator mutu successfully stored", "data" => $request->all()], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function UpdateIndikatorMutu(Request $request, $idIndikator){

        try {
            $validator = $this->validateIndikatorMutu($request, $idIndikator, 'update');
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        
            DB::transaction(function () use ($request, $idIndikator) {
                $indikatorMutu = IndikatorMutu::find($idIndikator);

                if (!$indikatorMutu) {
                    throw new \Exception('indikator not found');
                }
                $indikatorMutu->fill($request->all());
                $indikatorMutu->save();
            });

            return response()->json(['status' => 'success', 'message' => 'indikator updated successfully', 'data' => $request->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function DelIndikatorMutu($idIndikator){

        $indikatorName = null;
        try{
            DB::transaction(function () use (&$indikatorName, $idIndikator) {
                $indikatorMutuData = IndikatorMutu::find($idIndikator);

                if (!$indikatorMutuData) {
                    throw new \Exception('indikator mutu not found');
                }

                $indikatorName = $indikatorMutuData->nama_indikator;
                $indikatorMutuData->delete();//SoftDelete
            });
            return response()->json(['status' => 'success', 'message' => 'indikator deleted successfully', 'data' => $indikatorName], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    private function validateIndikatorMutu(Request $request, $id, $action = 'insert')
    {   

        $messages = [
            'nama_indikator.required' => 'Nama indikator wajib diisi.',
            'nama_indikator.max' => 'Nama indikator tidak boleh lebih dari 500 karakter.',
            'nama_indikator.unique' => 'Nama indikator sudah ada. Silakan gunakan nama yang berbeda.',
            'target.required' => 'Target wajib diisi',
            'target.max' => 'target tidak boleh lebih dari 500 karakter.',
        ];
        $validator = Validator::make($request->all(), [
            'nama_indikator' => ['required','max:500',

                function ($attribute,$value, $fail) use ($request, $action, $id) {
                    $query = IndikatorMutu::withTrashed()->where('nama_indikator', $value)->where('deleted_at' , null);

                    if ($action === 'update') {
                        $query->where('id', '!=', $id);
                    }
                    
                    $existingData = $query->count();

                    if ($existingData > 0) {
                        $fail('Nama indikator sudah ada sebelumnya.');
                    }
                },
            ],
            'target' => 'required|max:500',
        ], $messages);
     
        return $validator;
    }

}
