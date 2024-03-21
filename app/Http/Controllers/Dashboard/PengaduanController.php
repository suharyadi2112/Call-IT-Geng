<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Events\LaporPengaduan;
use Yajra\Datatables\Datatables;


//model
use App\Models\Pengaduan;
use App\Models\KatPengaduan;
use App\Models\DetailIPengaduan;
use App\Models\User;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->divisi == 'IT'){
                $model = Pengaduan::query()->with('kategoripengaduan', 'pelapor', 'workers')
                ->orderBy('created_at', 'desc');
            }else{
                $model = Pengaduan::query()->with('kategoripengaduan', 'pelapor', 'workers')
                ->where('pelapor_id', auth()->user()->id)
                ->orderBy('created_at', 'desc');
            }

            return DataTables::of($model)
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="'.route('pengaduan.detail',$row->id).'" class="mr-2 btn btn-sm round btn-outline-primary shadow" title="Detail" data-id="' . $row->id . '">
                <i class="fa fa-lg fa-fw fa-eye"></i></a>';
                if (Auth::user()->divis == 'IT') {
                    $actionBtn.= '<button type="button" id="modalDelete" class="mr-2 btn btn-sm round btn-outline-danger shadow" title="Hapus" data-id="'. $row->id. '">
                    <i class="fa fa-lg fa-fw fa-trash"></i></button>';
                }
                return $actionBtn;
            })
            ->editColumn('status_pelaporan', function ($row) {
                return '<span class="badge badge-'.($row->status_pelaporan == 'waiting' ? 'warning' : ($row->status_pelaporan == 'progress' ? 'info' : 'success')).'">'.ucfirst($row->status_pelaporan).'</span>';
            })
            ->editColumn('prioritas', function ($row) {
                return '<span class="badge badge-'.($row->prioritas == 'Tinggi'? 'danger' : ($row->prioritas == 'Sedang'? 'warning' :'success')).'">'.ucfirst($row->prioritas).'</span>';
            })
            ->editColumn('tanggal_pelaporan', function ($row) {
                return date('d-m-Y H:i', strtotime($row->tanggal_pelaporan));
            })
            ->editColumn('tanggal_selesai', function ($row) {
                if ($row->tanggal_selesai == null) {
                    return '-';
                }
                return date('d-m-Y H:i', strtotime($row->tanggal_selesai));
            })
            ->rawColumns(['action', 'status_pelaporan', 'prioritas'])
            ->make(true);
        }

        return view('dashboard.pengaduan.pengaduan_index');
    }

    public function buatPengaduan()
    {
        $kategoriPengaduan = KatPengaduan::select('id', 'nama')->get();
        return view('dashboard.pengaduan.pengaduan_create', ['kategoriPengaduan' => $kategoriPengaduan]);
    }

    public function simpanPengaduan(Request $request)
    {
        $validator = $this->validatePengaduan($request, null, 'insert');
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }
        try {

            $adminCheck = null;
            if (Auth::user()->jabatan == 'Administrator') {
                $adminCheck = Auth::user()->id;
            }

            $dataPengaduan = null;
            $paths = [];
            DB::transaction(function () use ($request, $adminCheck, &$dataPengaduan, &$paths) {
                $kodeGenerate = $this->generateCode();
                $pengaduan = Pengaduan::create([
                    'kode_laporan' => $kodeGenerate,
                    'pelapor_id' => Auth::user()->id,
                    'admin_id' => $adminCheck,
                    'kategori_pengaduan_id' => $request->input('kategori_pengaduan_id'),
                    'indikator_mutu_id' => '-',
                    'lokasi' => $request->input('lokasi'),
                    'lantai' => $request->input('lantai'),
                    'judul_pengaduan' => $request->input('judul_pengaduan'),
                    'dekskripsi_pelaporan' => $request->input('dekskripsi_pelaporan'),
                    'prioritas' => $request->input('prioritas'),
                    'nomor_handphone' => $request->input('nomor_handphone'),
                    'status_pelaporan' => 'waiting',
                    'tanggal_pelaporan' => date('Y-m-d H:i:s'),
                ]);

                if ($request->file('picture_pre')) {

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

                //Notif
                event(new LaporPengaduan('Laporan Pengaduan Baru Dengan Kode Pengaduan ' . $kodeGenerate . ' Lantai ' . $request->input('lantai')));

                $dataPengaduan = $this->getPengaduanAfterCreate($pengaduan->id);
            });

            return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function detailPengaduan($id)
    {
        $pengaduan = Pengaduan::with('workers', 'pelapor')->findOrFail($id);
        $gambarPengaduan = DetailIPengaduan::where('pengaduan_id', $pengaduan->id)->get();
        $gambarPerbaikanPengaduan = DetailIPengaduan::where('pengaduan_id', $pengaduan->id)->where('tipe', 'post')->get();
        $kategoriPengaduan = KatPengaduan::select('id', 'nama')->get();
        $workers = User::whereIn('role', ['Worker'])->get();
        return view('dashboard.pengaduan.pengaduan_detail', [
            'pengaduan' => $pengaduan, 
            'kategoriPengaduan' => $kategoriPengaduan, 
            'gambarPengaduan' => $gambarPengaduan,
            'gambarPerbaikanPengaduan' => $gambarPerbaikanPengaduan,
            'workers' => $workers
        ]);
    }

    public function updatePengaduan(Request $request, $id){
        $pesan = [
            'status_pelaporan.required' => 'Status pelaporan wajib dipilih.',
            'status_pelaporan.max' => 'Status pelaporan max 50 karakter',
            'picture_post.*.file' => 'Picture Pre harus berupa file',
            'picture_post.*.mimes' => 'Picture Pre harus jpg,jpeg,png',
            'picture_post.*.required' => 'Picture Pre wajib diisi',
            'picture_post.*.max' => 'Picture Pre maksimal 5 mb',
            'workers.required' => 'Pekerja wajib dipilih.',
        ];

        $validator = Validator::make($request->all(), [
            'status_pelaporan' => 'required|max:50',
            'workers' => 'required|array',
            'picture_post.*' => 'required|file|mimes:jpg,jpeg,png|max:5048',
            'picture_post' => 'array',
        ], $pesan);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        try {
            $pengaduan = Pengaduan::findOrfail($id);
            DB::transaction(function () use ($request, $pengaduan) {  
                $idUserAsWorkers = $request->input('workers');
                $dataPekerja = [];
                foreach ($idUserAsWorkers as $idUser) {
                    $dataPekerja[] = [
                        'user_id' => $idUser,
                        'tanggal_assesment' => date('Y-m-d'),
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }

                $pengaduan->workers()->sync($dataPekerja);

                if ($request->input('status_pelaporan') == 'done') {
                    if ($pengaduan->tanggal_selesai == null) {
                        $pengaduan->tanggal_selesai = date('Y-m-d H:i:s');
                    }
                }

                $pengaduan->fill($request->all());
                $pengaduan->save();

                if ($request->file('picture_post')) {

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
                }
            });
            if($request->input('stayPaged') == 'on'){
                return redirect()->back()->with('success', 'Status pelaporan berhasil diupdate!');
            }
            return redirect()->route('pengaduan.index')->with('success', 'Status pelaporan berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function hapusPengaduan($id){

        try {
            $pengaduan = Pengaduan::findOrfail($id);
            $pengaduan->delete();
            return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    private function getPengaduanAfterCreate($idPengaduan){
        
        $dataPengaduan = Pengaduan::query()
        ->with('detailpengaduan', 'kategoripengaduan','pelapor', 'detailpengaduan')
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

            'prioritas.required' => 'Prioritas pelaporan wajib diisi.',
            'prioritas.max' => 'Prioritas pelaporan max 100 karakter.',

            'nomor_handphone.max' => 'Nomor handphone max 50 karakter.',

            'tanggal_pelaporan.date' => 'Tanggal pelaporan tidak bertipe tanggal(date).',

            'tanggal_pelaporan.date' => 'Tanggal pelaporan tidak bertipe tanggal(date).',

            'picture_pre.*.file' => 'Picture Pre harus berupa file',
            'picture_pre.*.mimes' => 'Picture Pre harus jpg,jpeg,png',
            'picture_pre.*.required' => 'Picture Pre wajib diisi',
            'picture_pre.*.max' => 'Picture Pre maksimal 5 mb',
        ];
        $validator = Validator::make($request->all(), [
            'pelapor_id' => 'max:100',
            'kategori_pengaduan_id' => 'required|max:100',
            'lokasi' => 'required|max:500',
            'lantai' => [
                'required', 'max:50',
                function ($attribute, $value, $fail) use ($request, $action) {
                    if (!in_array($value, ['basement', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10'])) {
                        $fail('Lantai input tidak valid (contoh, basement, 01, 02, 03, 04, 05, 06, 07,08 ,09 ,10)');
                    }
                    return true;
                },
            ],
            'judul_pengaduan' => 'required|max:500',
            'dekskripsi_pelaporan' => 'required|max:1000',
            'prioritas' => 'required|max:100',
            'nomor_handphone' => 'max:20',
            'tanggal_pelaporan' => 'date',

            'picture_pre' => 'array',
            'picture_pre.*' => 'required|file|mimes:jpg,jpeg,png|max:5048',
        ], $messages);

        return $validator;
    }

    public function kategori(Request $request)
    {
        if ($request->ajax()) {
            $data = KatPengaduan::select('id', 'nama')
                ->latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="mr-2 btn btn-sm round btn-outline-primary shadow" title="Edit" id="modalEdit" data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-edit"></i>
                    </button>';
                    $actionBtn .= '<a href="' . route('kategori.destroy', $row->id) . '" class="btn btn-sm round btn-outline-danger shadow" title="Delete" id="modalDelete"
                    data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pengaduan.pengaduan_kategori');
    }

    public function storekategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',

        ], [
            'nama.required' => 'Nama kategori tidak boleh kosong',
            // 'nama.min' => 'Nama kategori minimal 5 karakter',
            'nama.max' => 'Nama kategori maksimal 50 karakter',
        ]);


        $nama = $request->nama;
        KatPengaduan::updateOrCreate(
            ['id' => $request->id],
            ['nama' => $nama]
        );
        return response()->json(['success' => 'Kategori berhasil ditambahkan']);
    }

    public function updatekategori(Request $request)
    {
        $request->validate([
            'namaupdate' => 'required|max:50',

        ], [
            'namaupdate.required' => 'Nama kategori tidak boleh kosong',
            // 'nama.min' => 'Nama kategori minimal 5 karakter',
            'namaupdate.max' => 'Nama kategori maksimal 50 karakter',
        ]);


        $namaupdate = $request->namaupdate;
        KatPengaduan::whereId($request->idupdate)->update(['nama'=>$namaupdate]);
        return response()->json(['success' => 'Kategori berhasil diupdate']);
    }
    public function destroykategori($id)
    {
        // return response()->json($id);
        $kategori = KatPengaduan::where('id', $id)->first();
        $kategori->delete();
        return back();
    }
    public function showkategori($id, Request $request)
    {
        $kategori = KatPengaduan::where('id', $id)->first();
        if ($request->ajax()) {
            return response()->json($kategori);
        } else {
            return redirect()->route('kategori.index');
        }
    }
}
