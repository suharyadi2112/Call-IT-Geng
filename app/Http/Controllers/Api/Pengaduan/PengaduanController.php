<?php

namespace App\Http\Controllers\Api\Pengaduan;

use App\Http\Controllers\Controller;
use App\Events\LaporPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use DataTables;


//model
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\DetailIPengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function GetPengaduan(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $page = $request->input('page');

        try {
        
            $query = Pengaduan::query()->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor', 'workers');
            if ($search) {
                $query->search($search);
            }
            $query->orderByRaw('CASE status_pelaporan
                WHEN "Waiting" THEN 1
                WHEN "Progress" THEN 2
                ELSE 3
            END')->orderByRaw('CASE prioritas
                WHEN "Tinggi" THEN 1
                WHEN "Sedang" THEN 2
                ELSE 3
            END')->orderBy('created_at', 'desc');
            $getPengaduan = $query->paginate($perPage);

            return response(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getPengaduan], 200);

        } catch (\Exception $e) {

            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetPengaduanAll(Request $request){

        try {
            $query = Pengaduan::query()
            ->with('detailpengaduan', 'kategoripengaduan', 'indikatormutu', 'pelapor','workers')
            ->orderBy('created_at', 'desc');

            if (strtolower(Auth::user()->role) == "admin") {
            
            } else if (strtolower(Auth::user()->role) == "worker"){
              
                $query->whereHas('workers', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            
            } else {
                $query->where('pelapor_id', Auth::user()->id);
            }

            if ($request->tanggal_pelaporan) {
                $query->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan);
            } else {
                $query->whereDate('tanggal_pelaporan', now()->toDateString()); // Jika tanggal kosong, gunakan tanggal hari ini
            }
            
            if ($request->status_pelaporan) {
                $query->where('status_pelaporan', $request->status_pelaporan);
            }

            $results = $query->get();

            return response(["status"=> "success","message"=> "Data list pengaduan all by user successfully retrieved", "data" => $results], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetPengaduanYajra(){
        try {
            $model = Pengaduan::query()->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor', 'workers')
            ->orderByRaw('CASE status_pelaporan
                WHEN "Waiting" THEN 1
                WHEN "Progress" THEN 2
                ELSE 3
            END')
            ->orderByRaw('CASE prioritas
                WHEN "Tinggi" THEN 1
                WHEN "Sedang" THEN 2
                ELSE 3
            END')
            ->orderBy('created_at', 'desc');
            return DataTables::eloquent($model)->toJson();
        } 
        catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetPengaduanByWorker($id_worker){
        try {

            $dataPivot = User::find($id_worker)->load('pengaduan')->only('name', 'pengaduan');
            return response(["status"=> "success","message"=> "Data list pengaduan by worker successfully retrieved", "data" => $dataPivot], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetPengaduanList(){
        try {
            $queryy = Pengaduan::query()
            ->with(['pelapor' => function($query) {
                $query->select('id', 'name', 'email'); // Pilih kolom 'nama' dan 'email' saja
            }])
            ->orderBy('created_at', 'desc')
            ->select("id","judul_pengaduan","prioritas", "tanggal_pelaporan", "created_at","dekskripsi_pelaporan", "status_pelaporan", "pelapor_id")
            ->get(); 
            return response(["status"=> "success","message"=> "Data list pengaduan successfully retrieved", "data" => $queryy], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetPengaduanByID($idPengaduan){
        try {
            $getPengaduanByID = Pengaduan::query()->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor', 'workers')->find($idPengaduan);

            if (!$getPengaduanByID) {
                throw new \Exception('pengaduan not found');
            }
            return response()->json(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getPengaduanByID], 200);
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function AssignWorkerToPengaduan(Request $request, $idPengaduan){

        try {

            $pengaduan = Pengaduan::find($idPengaduan);
            if (!$pengaduan) {
                throw new \Exception('Pengaduan not found');
            }

            $pesan = [
                'user_id.required' => 'Workers wajib dipilih.',
                'user_id.min' => 'Wajib memilih worker minimal 1 orang.',
                'user_id.max' => 'Wajib memilih worker maksimal 5 orang.',
            ];

            $validator = Validator::make($request->all(), [
                'user_id' => 'array',
                'user_id' => ['required','min:1','max:5',
                    function ($attribute,$value, $fail) use ($request, $pengaduan) {
                        $failedUsers = [];

                        $assignedUsers = $pengaduan->workers()->pluck('users.id')->toArray();

                        foreach ($request->user_id as $userId) {
                            if (!User::find($userId)) {
                                $failedUsers['user_id_' . $userId] = 'User dengan ID ' . $userId . ' tidak ditemukan.';
                            } elseif (in_array($userId, $assignedUsers)) {
                                // Periksa apakah user sudah di-assign ke pengaduan
                                $failedUsers['user_id_' . $userId] = 'Worker dengan ID ' . $userId . ' sudah diassign ke pengaduan ini sebelumnya.';
                            }
                        }
                        if (!empty($failedUsers)) {
                            return $fail($failedUsers);
                        }

                        if (count(array_unique($value)) !== count($value)) {
                            return $fail('List Workers ' . $attribute . ' duplikat.');
                        }
                    },
                ]
            ], $pesan);

            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            $dataPivot = null;
            DB::transaction(function () use ($request, $pengaduan, &$dataPivot) {
                $idUserAsWorkers = $request->input('user_id'); // Dapatkan semua ID pekerja
                
                $dataPekerja = [];
                foreach ($idUserAsWorkers as $idUser) {
                    $dataPekerja[] = [
                        'user_id' => $idUser,
                        'tanggal_assesment' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }

                $pengaduan->workers()->attach($dataPekerja); // Lampirkan pekerja dengan data pivot

                $dataPivot = Pengaduan::query()->with(['workers' => function ($query) {
                    $query->select('users.id', 'users.name', 'users.handphone');
                    $query->withPivot('tanggal_assesment');
                }])->where('a_pengaduan.id', $pengaduan->id)->get();
            });


            return response(["status"=> "success","message"=> "Assign worker successfully store", "data" => $dataPivot], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function DelWorkerFromPengaduan($idPengaduan, $idWorker){
        
        try {
            $pengaduan = Pengaduan::find($idPengaduan);
            if (!$pengaduan) {
                throw new \Exception('Pengaduan not found');
            }

            $workerExists = $pengaduan->workers()->where('user_id', $idWorker)->exists();
            if (!$workerExists) {
                throw new \Exception('Worker di pengajuan ini tidak ada');
            }

            $pengaduan->workers()->detach($idWorker); // usir worker dari pengaduan #lu tu ngk diajak

            return response()->json(["status"=> "success","message"=> "Worker has been deleted #lu ngk diajak", "data" => null], 200);
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function DelPicture($idPicture){
        
        try {
            $dataPicturePre = DetailIPengaduan::find($idPicture);
            if (!$dataPicturePre) {
                throw new \Exception('Picture pre not found');
            }

            DB::transaction(function () use ($dataPicturePre) {
                $dataPicturePre->delete();
            });

            $path = 'storage/'.$dataPicturePre->picture;
            $pathh = public_path($path);

            if (unlink($path)) {
                return response()->json(["status"=> "success","message"=> "Picture Pre has been deleted", "data" => $pathh], 200);
            }
            
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function StorePengaduan(Request $request){

        $validator = $this->validatePengaduan($request, null, 'insert');  
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => null], 400);
        }
        try {

            $adminCheck = "-";
            if(Auth::user()->jabatan == 'admin'){
                $adminCheck = Auth::user()->id;
            }

            $dataPengaduan = null;
            $paths = [];
            DB::transaction(function () use ($request, $adminCheck, &$dataPengaduan, &$paths) { //& ubah nilai didalam closure 
                $kodeGenerate = $this->generateCode();
                $pengaduan = Pengaduan::create([
                    'kode_laporan' => $kodeGenerate,
                    'pelapor_id' => Auth::user()->id,
                    'admin_id' => $adminCheck,
                    'kategori_pengaduan_id' => $request->input('kategori_pengaduan_id'),
                    'lokasi' => $request->input('lokasi'),
                    'lantai' => $request->input('lantai'),
                    'judul_pengaduan' => $request->input('judul_pengaduan'),
                    'dekskripsi_pelaporan' => $request->input('dekskripsi_pelaporan'),
                    'nomor_handphone' => $request->input('nomor_handphone'),
                    'status_pelaporan' => 'waiting',
                    'tanggal_pelaporan' => date('Y-m-d H:i:s'),
                    'prioritas' => "-",
                    'indikator_mutu_id' => "-",
                    'tanggal_selesai' => "-",
                ]);

                if ($request->file('picture_pre')) { //unggah file
            
                    $files = $request->file('picture_pre');
                    $names = [];
                    foreach ($files as $file) {
                        $names[] = Str::random(5) . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                    }

                    foreach ($files as $key => $file) {
                        $paths[] = $file->storeAs('detail_pengaduan/picture_pre', $names[$key], 'public');
                      }

                    foreach ($paths as $path) {
                        DetailIPengaduan::create([
                            'pengaduan_id' => $pengaduan->id,
                            'picture' => $path,
                            'tipe' => 'pre'
                        ]);
                    }
                }

                if ($request->has('user_id')) { //jika worker disertakan
                    $this->AssignWorkerToPengaduan($request, $pengaduan->id);
                }
                
                if ($request->has('prioritas')) { //jika prioritas disertakan
                    $this->UpdatePrioritasPengaduan($request->prioritas, $pengaduan->id);
                }

                //Notif
                event(new LaporPengaduan('Laporan Pengaduan Baru Dengan Kode Pengaduan '. $kodeGenerate. ' Lantai '. $request->input('lantai')));
                
                $dataPengaduan = $this->getPengaduanAfterCreate($pengaduan->id);
            });

            return response()->json(["status"=> "success","message"=> "Pengaduan successfully stored", "data" => $dataPengaduan], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function UpdatePrioritasPengaduan($prioritas, $idPengaduan){
        try {
          
            DB::transaction(function () use ($prioritas, $idPengaduan) {
                $pengaduanDataPrioritas = Pengaduan::find($idPengaduan);
            
                if (!$pengaduanDataPrioritas) {
                    throw new \Exception('pengaduan not found');
                }
                $pengaduanDataPrioritas->prioritas = $prioritas;
                $pengaduanDataPrioritas->save();

            });

            return response()->json(['status' => 'success', 'message' => 'prioritas pengaduan updated successfully', 'data' => $prioritas], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function StorePicturePre(Request $request, $id){

        try {

            $messages = [
                'picture_pre.*.file' => 'Picture Pre harus berupa file',
                'picture_pre.*.mimes' => 'Picture Pre harus jpg,jpeg,png',
                'picture_pre.*.max' => 'Picture Pre maksimal 5 mb',
            ];

            $validator = Validator::make($request->all(), [
                'picture_pre' => 'array',
                'picture_pre.*' => 'file|mimes:jpg,jpeg,png|max:5048',
            ], $messages);

            if ($validator->fails()) {
                return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => null], 400);
            }

            if ($request->file('picture_pre')) { //unggah file
                
                $files = $request->file('picture_pre');
                $names = [];
                foreach ($files as $file) {
                    $names[] = Str::random(5) . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                }

                foreach ($files as $key => $file) {
                    $paths[] = $file->storeAs('detail_pengaduan/picture_pre', $names[$key], 'public');
                }

                foreach ($paths as $path) {
                    DetailIPengaduan::create([
                        'pengaduan_id' => $id,
                        'picture' => $path,
                        'tipe' => 'pre'
                    ]);
                }
            }

            return response()->json(["status"=> "success","message"=> "Picture Pre Standalone successfully stored", "data" => $paths], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function DeletePengaduan($idPengaduan){
        try {
            
            DB::transaction(function () use ($idPengaduan) {
                $pengaduanData = Pengaduan::find($idPengaduan);

                if (!$pengaduanData) {
                    throw new \Exception('pengaduan not found');
                }
                
                $pengaduanData->delete();
            });
            return response()->json(['status' => 'success', 'message' => 'pengaduan deleted successfully', 'data' => null], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function UpdatePengaduan(Request $request, $idPengaduan){

        try {
            $validator = $this->validatePengaduan($request, $idPengaduan, 'update');
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::transaction(function () use ($request, $idPengaduan) {
                $pengaduanData = Pengaduan::find($idPengaduan);
            
                if (!$pengaduanData) {
                    throw new \Exception('pengaduan not found');
                }
            
                $adminCheck = "-";
                if (Auth::user()->jabatan == 'admin') {
                    $adminCheck = Auth::user()->id;
                }
            
                $dataToUpdate = $request->all();
                if ($adminCheck !== null || $adminCheck !== "-") {
                    $dataToUpdate['admin_id'] = $adminCheck;
                }
            
                $pengaduanData->update($dataToUpdate);
            });

            return response()->json(['status' => 'success', 'message' => 'pengaduan updated successfully', 'data' => $request->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function UpdateStatusPengaduan(Request $request, $idPengaduan){

        try {

            $pengaduan = Pengaduan::find($idPengaduan);
            if (!$pengaduan) {
                throw new \Exception('Pengaduan not found');
            }
    
            $pesan = [
                'status_pelaporan.required' => 'Status pelaporan wajib dipilih.',
                'status_pelaporan.max' => 'Status pelaporan max 50 karakter',
            ];
    
            $validator = Validator::make($request->all(), [
                'status_pelaporan' => 'required|max:50',
            ], $pesan);

            if (Str::lower($request->status_pelaporan) === 'progress') {
                if (!$pengaduan->workers()->exists()) {
                    $validator->after(function ($validator) {
                        $validator->errors()->add('worker', 'Belum ada workers untuk pengaduan ini.');
                    });
                }
            }
            
            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            DB::transaction(function () use ($request, $pengaduan) {
                
                $pengaduan->fill($request->all());
                $pengaduan->save();
                
            });

            return response()->json(['status' => 'success', 'message' => 'status pelaporan updated successfully', 'data' => $request->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }

    }

    public function StorePicturePost(Request $request, $idPengaduan){// photo setelah pengaduan diselesaikan

        try {
            $pengaduan = Pengaduan::find($idPengaduan);

            if (!$pengaduan) {
                throw new \Exception('Pengaduan not found');
            }

            $pesan = [
                'picture_post.*.file' => 'Picture Pre harus berupa file',
                'picture_post.*.mimes' => 'Picture Pre harus jpg,jpeg,png',
                'picture_post.*.required' => 'Picture Pre wajib diisi',
                'picture_post.*.max' => 'Picture Pre maksimal 5 mb',
            ];
    
            $validator = Validator::make($request->all(), [
                'picture_post.*' => 'required|file|mimes:jpg,jpeg,png|max:5048',
                'picture_post' => 'array',
            ], $pesan);
    
            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            $dataPengaduan = null;
            $paths = [];
            DB::transaction(function () use ($request, $pengaduan, &$dataPengaduan, &$paths) {

                    $files = $request->file('picture_post');
                    $names = [];
                    foreach ($files as $file) {
                        $names[] = Str::random(5) . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                    }

                    foreach ($files as $key => $file) {
                        $paths[] = $file->storeAs('detail_pengaduan/picture_post', $names[$key], 'public');
                    }

                    foreach ($paths as $path) {
                        DetailIPengaduan::create([
                            'pengaduan_id' => $pengaduan->id,
                            'picture' => $path,
                            'tipe' => 'post'
                        ]);
                    }
                
                
                $dataPengaduan = $this->getPengaduanAfterCreate($pengaduan->id);
            });

            return response()->json(['status' => 'success', 'message' => 'picture post pelaporan stored successfully', 'data' => $dataPengaduan], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }

    }

    private function validatePengaduan(Request $request, $id, $action = 'insert')
    {   

        $messages = [
            'pelapor_id.max' => 'Pelapor max 100 karakter.',
            
            'kategori_pengaduan_id.required' => 'Kategori pengaduan wajib diisi.',
            'kategori_pengaduan_id.max' => 'Kategori pengaduan max 100 karakter.',
            
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.max' => 'Lokasi max 100 karakter.',
            
            'lantai.required' => 'Lantai wajib diisi.',
            'lantai.max' => 'Lantai max 50 karakter.',
            
            'judul_pengaduan.required' => 'Judul pengaduan wajib diisi.',
            'judul_pengaduan.max' => 'Judul pengaduan max 500 karakter.',

            'dekskripsi_pelaporan.required' => 'Deskripsi pelapporan wajib diisi.',
            'dekskripsi_pelaporan.max' => 'Deskripsi pelapporan max 1000 karakter.',
            
            'nomor_handphone.max' => 'Nomor handphone max 50 karakter.',
            
            'tanggal_pelaporan.date' => 'Tanggal pelaporan tidak bertipe tanggal(date).',
            
            'tanggal_pelaporan.date' => 'Tanggal pelaporan tidak bertipe tanggal(date).',

            'picture_pre.*.file' => 'Picture Pre harus berupa file',
            'picture_pre.*.mimes' => 'Picture Pre harus jpg,jpeg,png',
            // 'picture_pre.*.required' => 'Picture Pre wajib diisi',
            'picture_pre.*.max' => 'Picture Pre maksimal 5 mb',
        ];
        $validator = Validator::make($request->all(), [
            'pelapor_id' => 'max:100',
            'kategori_pengaduan_id' => 'required|max:100',
            'lokasi' => 'required|max:500',
            'lantai' => ['required', 'max:50',
                function ($attribute,$value, $fail) use ($request, $action) {
                    if (!in_array($value, ['basement', '01', '02', '03','04','05','06','07','08', '09', '10'])) {
                        $fail('Lantai input tidak valid (contoh, basement, 01, 02, 03, 04, 05, 06, 07,08 ,09 ,10)');
                    }
                    return true;
                },
            ],
            'judul_pengaduan' => 'required|max:500',
            'dekskripsi_pelaporan' => 'required|max:1000',
            'nomor_handphone' => 'max:20',
            'tanggal_pelaporan' => 'date',

            'picture_pre' => 'array',
            'picture_pre.*' => 'file|mimes:jpg,jpeg,png|max:5048',
        ], $messages);
     
        return $validator;
    }

    private function getPengaduanAfterCreate($idPengaduan){
        
        $dataPengaduan = Pengaduan::query()
        ->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor', 'detailpengaduan')
        ->where('a_pengaduan.id', $idPengaduan)->get();

        return $dataPengaduan;
    }
    
    private function generateCode() {
        $kode = date('YmdHis');
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < 4; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $kode.'-'.$code;
    }
}
