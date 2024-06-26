<?php

namespace App\Http\Controllers\Api\Pengaduan;

use App\Http\Controllers\Controller;
use App\Events\LaporPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Bunny\Client;

//model
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\DetailIPengaduan;
use App\Models\KatPengaduan;
use App\Models\ChatList;
use App\Models\ChatRoom;

class PengaduanController extends Controller
{

    protected $rabbitmqHost;
    protected $rabbitmqPort;
    protected $rabbitmqUser;
    protected $rabbitmqPassword;

    public function __construct()
    {
        $this->rabbitmqHost = env('RABBITMQ_HOST');
        $this->rabbitmqPort = env('RABBITMQ_PORT');
        $this->rabbitmqUser = env('RABBITMQ_USER');
        $this->rabbitmqPassword = env('RABBITMQ_PASSWORD');
    }

    protected function sendMessageWAToRabbitMQ($message, $noTarget, $maxRetry = 3, $retryCount = 0){
        $client = new Client([
            'host' => $this->rabbitmqHost,
            'port' => $this->rabbitmqPort,
            'user' => $this->rabbitmqUser,
            'password' => $this->rabbitmqPassword,
        ]);
    
        $client->connect();
        $channel = $client->channel();
        $channel->queueDeclare('sendWaPengaduan', false, true, false, false);
    
        try {

            $data = [ //format data
                'message' => $message,
                'recipient' => $noTarget,
            ];
            $message = json_encode($data);
            
            $channel->publish($message, [], '', 'sendWaPengaduan');
            Log::info("success send message");
        } catch (\Exception $e) {
            if ($retryCount < $maxRetry) {
                Log::error("Failed to send message. Retrying... Attempt $retryCount");
                $this->sendMessageWAToRabbitMQ($message,$noTarget, $maxRetry, ++$retryCount);
            } else {
                Log::error("Failed to send message after $maxRetry attempts. Error: " . $e->getMessage());
            }
        } finally {
            $channel->close();
            $client->disconnect();
            Log::info("client closed");
        }
    }    

    public function GetPengaduan(Request $request){
        
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        
        $pelapor_id = $request->input('pelapor_id');
        $kategori_pengaduan_id = $request->input('kategori_pengaduan_id');
        $status_pelaporan = $request->input('status_pelaporan');
        $lantai = $request->input('lantai');
        $prioritas = $request->input('prioritas');

        $page = $request->input('page');

        try {
        
            $query = Pengaduan::query()->with('detailpengaduan', 'kategoripengaduan','indikatormutu','pelapor', 'workers');
            if ($search) {
                $query->search($search);
            }

            if ($pelapor_id) {
                $query->where('pelapor_id', strtolower($request->input('pelapor_id')));
            }
            if ($kategori_pengaduan_id) {
                $query->where('kategori_pengaduan_id', strtolower($request->input('kategori_pengaduan_id')));
            }
            if ($status_pelaporan) {
                $query->where('status_pelaporan', strtolower($request->input('status_pelaporan')));
            }
            if ($lantai) {
                $query->where('lantai', strtolower($request->input('lantai')));
            }
            if ($prioritas) {
                $query->where('prioritas', strtolower($request->input('prioritas')));
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

    public function GetPengaduanNotAssign(Request $request){
           
        $perPage = $request->input('per_page');
        $search = $request->input('search');

        try {
            $query = Pengaduan::query()
            ->with('detailpengaduan', 'kategoripengaduan', 'indikatormutu', 'pelapor','workers')
            ->whereDoesntHave('workers')// pengaduan belum/tidak ada di pivot workers
            ->where('status_pelaporan', 'waiting')
            ->orderBy('created_at', 'desc');

            if ($search) { //jika pakai pencarian
                $query->search($search);
            }

            if ($request->tanggal_pelaporan && $request->tanggal_pelaporan != "all") {
                $query->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan);
            } else if ($request->tanggal_pelaporan == "all") { //tampilkan semua data, yang belum di assign
                
            } else {
                $query->whereDate('tanggal_pelaporan', now()->toDateString()); //tanggal hari ini
            }
            
            if ($request->status_pelaporan) {
                $query->where('status_pelaporan', $request->status_pelaporan); //berdasarkan status laporan
            }
            if ($perPage) { //jika menggunakan paging
                $results = $query->paginate($perPage);
            }else{
                $results = $query->get();
            }
            return response(["status"=> "success","message"=> "Data list pengaduan not assign successfully retrieved", "data" => $results], 200);

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

    public function GetPengaduanAdditionalInfo(){
        try {
            $prioritasList = Pengaduan::distinct('prioritas')->pluck('prioritas');

            $pelaporList = Pengaduan::with('pelapor')->distinct()->get()->pluck('pelapor.name', 'pelapor.id')->unique();
            $kategoriList = Pengaduan::with('kategoripengaduan')->distinct()->get()->pluck('kategoripengaduan.nama', 'kategoripengaduan.id')->unique();

            $statusPelaporan = Pengaduan::distinct('status_pelaporan')->pluck('status_pelaporan');
            $lantaiList = Pengaduan::distinct('lantai')->pluck('lantai');

            $items = [
                'prioritasList' => $prioritasList,
                'pelaporList' => $pelaporList,
                'kategoriList' => $kategoriList,
                'statusPelaporan' => $statusPelaporan,
                'lantaiList' => $lantaiList,
            ];

            return response(["status"=> "success","message"=> "Data list additional successfully retrieved", "data" => $items], 200);
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

                    try { //send message assign 
                        $message = "Pengaduan dengan kode laporan ".$pengaduan->kode_laporan."  diassign ke kamuhh, tolong dikerjakan yaa :)";
    
                        $noTarget = User::where('id', $idUser)->first()->handphone; //"+6282288184788" format valid
                        $fixFormatHP = $this->formatNomorHP($noTarget);
                        
                        $this->sendMessageWAToRabbitMQ($message, $fixFormatHP);
                    } catch (\Exception $e) {
                        Log::error("Failed to send message to RabbitMQ: " . $e->getMessage());
                    }
                }

                $pengaduan->workers()->attach($dataPekerja); // Lampirkan pekerja dengan data pivot

                //chat 
                $existingChatRoom = ChatRoom::where('pengaduan_id', $pengaduan->id)->first();
                if ($existingChatRoom) {
                    $room_id = $existingChatRoom->id;
                
                    $existingChatRoom->chatLists()->createMany(array_map(function($data) use ($room_id) {
                        return ['chat_room_id' => $room_id, 'user_id' => $data['user_id']];
                    }, $dataPekerja));
                }
                
                //return data
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

            DB::transaction(function () use ($pengaduan, $idWorker) {

                $workerExists = $pengaduan->workers()->where('user_id', $idWorker)->exists();
                if (!$workerExists) {
                    throw new \Exception('Worker di pengajuan ini tidak ada');
                }

                $pengaduan->workers()->detach($idWorker); // usir worker dari pengaduan #lu tu ngk diajak 

                //chat list user juga dihapus
                $existingChatList = ChatList::whereHas('chatRoom', function($query) use ($pengaduan) {
                    $query->where('pengaduan_id', $pengaduan->id);
                })
                ->where('user_id', $idWorker)
                ->get();
            
                foreach ($existingChatList as $chatList) {
                    $chatList->delete();
                }

            });

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
                    $this->UpdatePrioritasPengaduan($request, $pengaduan->id);
                }

                //Notif
                event(new LaporPengaduan('Laporan Pengaduan Baru Dengan Kode Pengaduan '. $kodeGenerate. ' Lantai '. $request->input('lantai')));

                try { //send message pengaduan 
                    $message = "Pengaduan baru dengan kode laporan ".$pengaduan->kode_laporan." silahkan dicek dan dikerjakan yaa :)";
                    $noTargetadmin = User::where('role', "admin")->orWhere('role', "Admin")->get(); 
                    foreach ($noTargetadmin as $noAdmin) { //"+6282288184788"
                        $fixFormatHP = $this->formatNomorHP($noAdmin->handphone); 
                        $this->sendMessageWAToRabbitMQ($message, $fixFormatHP);
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send message to RabbitMQ: " . $e->getMessage());
                }
                
                $dataPengaduan = $this->getPengaduanAfterCreate($pengaduan->id);
            });

            return response()->json(["status"=> "success","message"=> "Pengaduan successfully stored", "data" => $dataPengaduan], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function UpdatePrioritasPengaduan(Request $request, $idPengaduan){
        try {  

            $currentPrioritas = Pengaduan::find($idPengaduan);

            $priority = $request->prioritas;
       
            $messages = [
                'prioritas.in' => 'Tingkat kesulitan hanya bisa Tinggi, Sedang, atau Rendah.',
            ];

            $validator = Validator::make($request->all(), [
                'prioritas' => 'required|in:tinggi,sedang,rendah',
            ], $messages);

            if (Str::lower($currentPrioritas->status_pelaporan) === 'done') {
                $validator->after(function ($validator) {
                    $validator->errors()->add('prioritas', 'Pengaduan sudah selesai dengan status Done, tidak bisa mengganti Prioritas.');
                });
            }

            if ($validator->fails()) {
                return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => $priority], 400);
            }

            DB::transaction(function () use (&$priority, $idPengaduan) {
                $pengaduanDataPrioritas = Pengaduan::find($idPengaduan);
            
                if (!$pengaduanDataPrioritas) {
                    throw new \Exception('pengaduan not found');
                }
                $pengaduanDataPrioritas->prioritas = $priority;
                $pengaduanDataPrioritas->save();

            });

            return response()->json(['status' => 'success', 'message' => 'prioritas pengaduan updated successfully', 'data' => $priority], 200);

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


            $validator = $this->validateStatusPengaduan($request->status_pelaporan, $validator, $pengaduan); //validasi status
            
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

    private function validateStatusPengaduan($status, $validator, $dataPengaduan) {
        
        if (Str::lower($status) === 'progress') {
            if (!$dataPengaduan->workers()->exists()) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('worker', 'Workers harus terisi untuk status yang dipilih.');
                });
            }
        }

        if (Str::lower($status) === 'done') {
            if (!$dataPengaduan->workers()->exists()) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('worker', 'Workers harus terisi untuk status yang dipilih.');
                });
            }
            if (!$dataPengaduan->detailpengaduan()->where('tipe', 'pre')->exists()) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('picture_pre', 'Picture Pre harus terisi untuk status yang dipilih.');
                });
            }
            if (!$dataPengaduan->detailpengaduan()->where('tipe', 'post')->exists()) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('picture_post', 'Picture post harus terisi untuk status yang dipilih.');
                });
            }
        }
        return $validator;
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

    private function formatNomorHP($nomor_hp) { 

        if (substr($nomor_hp, 0, 1) === "0") {
            $nomor_hp = "+62" . substr($nomor_hp, 1);
        } elseif (substr($nomor_hp, 0, 3) !== "+62") {
            $nomor_hp = "+62" . $nomor_hp;
        }
    
        return $nomor_hp;
    }
}
