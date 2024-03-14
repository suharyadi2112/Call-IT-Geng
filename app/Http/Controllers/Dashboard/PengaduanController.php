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
use App\Models\IndikatorMutu;

class PengaduanController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
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

        return view('dashboard.pengaduan.pengaduan_index');
    }

    public function buatPengaduan(){
        $indikatorMutu = IndikatorMutu::select('id', 'nama_indikator')->get();
        return view('dashboard.pengaduan.pengaduan_create',['indikatorMutu' => $indikatorMutu]);
    }

    public function simpanPengaduan(Request $request){

        $validator = $this->validatePengaduan($request, null, 'insert');  
        if ($validator->fails()) {
            return redirect()->route('pengaduan.index.create')->withInput()->with('errors', $validator->errors());
        }
        try {

            $adminCheck = null;
            if(Auth::user()->jabatan == 'admin'){
                $adminCheck = Auth::user()->id;
            }

            $dataPengaduan = null;
            $paths = [];
            DB::transaction(function () use ($request, $adminCheck, &$dataPengaduan, &$paths) {
                $kodeGenerate = $this->generateCode();
                $pengaduan = Pengaduan::create([
                    'kode_laporan' => $kodeGenerate,
                    'indikator_mutu_id' => $request->input('indikator_mutu_id'),
                    'pelapor_id' => $request->input('pelapor_id'),
                    'admin_id' => $adminCheck,
                    'kategori_pengaduan_id' => $request->input('kategori_pengaduan_id'),
                    'lokasi' => $request->input('lokasi'),
                    'lantai' => $request->input('lantai'),
                    'judul_pengaduan' => $request->input('judul_pengaduan'),
                    'dekskripsi_pelaporan' => $request->input('dekskripsi_pelaporan'),
                    'prioritas' => $request->input('prioritas'),
                    'nomor_handphone' => $request->input('nomor_handphone'),
                    'status_pelaporan' => 'waiting',
                    'tanggal_pelaporan' => date('Y-m-d H:i:s'),
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

                //Notif
                event(new LaporPengaduan('Laporan Pengaduan Baru Dengan Kode Pengaduan '. $kodeGenerate. ' Lantai '. $request->input('lantai')));
                
                $dataPengaduan = $this->getPengaduanAfterCreate($pengaduan->id);
            });

            return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil disimpan!');

        } catch (\Exception $e) {
             return redirect()->route('pengaduan.index')->withInput()->with('error', $e->getMessage());
        }

    }

    public function detailPengaduan($id) {
        $pengaduan = Pengaduan::find($id);
        $indikatorMutu = IndikatorMutu::select('id', 'nama_indikator')->get();

        return view('dashboard.pengaduan.pengaduan_detail',['pengaduan' => $pengaduan, 'indikatorMutu' => $indikatorMutu]);
    }

    private function validatePengaduan(Request $request, $id, $action = 'insert')
    {   

        $messages = [
            'indikator_mutu_id.required' => 'Indikator mutu wajib diisi.',
            'indikator_mutu_id.max' => 'Indikator mutu max 100 karakter.',
            
            'pelapor_id.required' => 'Pelapor wajib diisi.',
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
            'indikator_mutu_id' => 'required|max:100',
            'pelapor_id' => 'required|max:100',
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
                    $actionBtn .= '<a href="'.route('pengaduan.kategori.destroy',$row->id).'" class="btn btn-sm round btn-outline-danger shadow" title="Delete" id="modalDelete"
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

    public function destroykategori($id)
    {
        // return response()->json($id);
        $kategori = KatPengaduan::where('id', $id)->first();
        $kategori->delete();
        return back();
    }
}
