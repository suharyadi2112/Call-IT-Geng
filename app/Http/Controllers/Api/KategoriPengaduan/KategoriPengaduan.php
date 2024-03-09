<?php

namespace App\Http\Controllers\Api\KategoriPengaduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use DataTables;

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

    public function GetKategoriPengaduanYajra(){
        try {
            $model = KatPengaduan::query();
            return DataTables::eloquent($model)->toJson();
        } 
        catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetKategoriPengaduanList(){
        try {
            $queryy = KatPengaduan::query();
            $getKategoriPengaduanList = $queryy->orderBy('created_at', 'desc')->select("id","nama")->get(); 
            return response(["status"=> "success","message"=> "Data list kategori pengaduan successfully retrieved", "data" => $getKategoriPengaduanList], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetKategoriPengaduanByID($id){
        try {
            $getData = KatPengaduan::query()->find($id);

            if (!$getData) {
                throw new \Exception('Kategori pengaduan not found');
            }
            return response()->json(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getData], 200);
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function StoreKategoriPengaduan(Request $request){

        $validator = $this->validateKategoriPengaduan($request, null , 'insert');  
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => null], 400);
        }
        try {
            DB::transaction(function () use ($request) {
                KatPengaduan::create([
                    'nama' => strtolower($request->input('nama')),
                ]);
            });
            return response()->json(["status"=> "success","message"=> "Data kategori pengaduan successfully stored", "data" => $request->all()], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function DelKategoriPengaduan($id){

        $kategoriPengaduanName = null;
        try{
            DB::transaction(function () use (&$kategoriPengaduanName, $id) {
                $KatPengaduanData = KatPengaduan::find($id);

                if (!$KatPengaduanData) {
                    throw new \Exception('indikator mutu not found');
                }

                $kategoriPengaduanName = $KatPengaduanData->nama;
                $KatPengaduanData->delete();//SoftDelete
            });
            return response()->json(['status' => 'success', 'message' => 'kategori pengaduan deleted successfully', 'data' => $kategoriPengaduanName], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }

    }

    public function UpdateKategoriPengaduan(Request $request, $id){
        try {
            $validator = $this->validateKategoriPengaduan($request, $id, 'update');
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        
            DB::transaction(function () use ($request, $id) {
                $kategoriPengaduan = KatPengaduan::find($id);

                if (!$kategoriPengaduan) {
                    throw new \Exception('kategori pengaduan not found');
                }
                $kategoriPengaduan->fill($request->all());
                $kategoriPengaduan->save();
            });

            return response()->json(['status' => 'success', 'message' => 'kategori pengaduan updated successfully', 'data' => $request->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    private function validateKategoriPengaduan(Request $request, $id, $action = 'insert')
    {   

        $messages = [
            'nama.required' => 'Nama Kategori Pengaduan wajib diisi.',
            'nama.max' => 'Nama Kategori Pengaduan tidak boleh lebih dari 400 karakter.',
            'nama.unique' => 'Nama Kategori Pengaduan sudah ada. Silakan gunakan nama yang berbeda.',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => ['required','max:400',

                function ($attribute,$value, $fail) use ($request, $action, $id) {
                    $query = KatPengaduan::withTrashed()->where('nama', $value)->where('deleted_at' , null);

                    if ($action === 'update') {
                        $query->where('id', '!=', $id);
                    }
                    
                    $existingData = $query->count();

                    if ($existingData > 0) {
                        $fail('Nama kategori pengaduan sudah ada sebelumnya.');
                    }
                },
            ],
        ], $messages);
     
        return $validator;
    }

}
