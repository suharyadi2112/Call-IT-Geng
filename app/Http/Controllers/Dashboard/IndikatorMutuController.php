<?php

namespace App\Http\Controllers\Dashboard;

// use App\Http\Controllers\Api\KategoriPengaduan\KategoriPengaduan;
use App\Models\KatPengaduan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


//model
use App\Models\IndikatorMutu;
use Illuminate\Validation\Rules\Exists;

class IndikatorMutuController extends Controller
{
    public function index(Request $request)
    {
        $kategoriPengaduan = KatPengaduan::get();
        if ($request->ajax()) {
            $data = IndikatorMutu::select('id', 'nama_indikator','target','n','d')
                ->latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="mr-2 btn btn-sm round btn-outline-primary shadow" title="Edit" id="modalEdit" data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-edit"></i>
                    </button>';
                    $actionBtn .= '<a href="' . route('indikatormutu.destroy', $row->id) . '" class="btn btn-sm round btn-outline-danger shadow" title="Delete" id="modalDelete"
                    data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.indikatormutu.index',['kategoriPengaduan'=>$kategoriPengaduan]);
    }

    public function store(Request $request)
    

    {
        $request->validate([
            'nama_indikator' => 'required',
            'target' => 'required',
            'kategori_pengaduan_id' => 'required',
            'n' => 'required',
            'd' => 'required',

        ], [
            'nama_indikator.required' => 'Nama indikator tidak boleh kosong',
            'target.required' => 'Target tidak boleh kosong',
            'kategori_pengaduan_id.required' => 'Target tidak boleh kosong',
            'n.required' => 'N tidak boleh kosong',
            'd.required' => 'D tidak boleh kosong',
            
        ]);
        IndikatorMutu::create([
            'nama_indikator' => $request->nama_indikator,
            'target' => $request->target,
            'kategori_pengaduan_id'=>$request->kategori_pengaduan_id,
            'n'=>$request->n,
            'd'=>$request->d,
        ]);
        return response()->json(['success' => 'Indikator Mutu berhasil ditambahkan']);
    }

    public function updateindikator(Request $request)
    {
        $request->validate([
            'nama_indikator_update' => 'required',
            'targetupdate' => 'required',
            'kategori_pengaduan_id_update' => 'required',
            'n' => 'required',
            'd' => 'required',


        ], [
            'nama_indikator_update.required' => 'Nama indikator tidak boleh kosong',
            'targetupdate.required' => 'Target tidak boleh kosong',
            'kategori_pengaduan_id_update.required' => 'Kategori tidak boleh kosong',
            'n_update.required' => 'N tidak boleh kosong',
            'd_update.required' => 'D tidak boleh kosong',
        ]);


        $nama_indikator_update = $request->nama_indikator_update;
        IndikatorMutu::whereId($request->idupdate)->update(
            ['nama_indikator'=>$nama_indikator_update,
            'target'=>$request->targetupdate,
            'kategori_pengaduan_id'=>$request->kategori_pengaduan_id_update,
            'n'=>$request->n_update,
            'd'=>$request->d_update,
            ]
        );
        return response()->json(['success' => 'Kategori berhasil diupdate']);
    }
    public function destroyindikator($id)
    {
        // return response()->json($id);
        $indikator = IndikatorMutu::where('id', $id)->first();
        $indikator->delete();
        return back();
    }
    public function showindikator($id, Request $request)
    {
        $indikator = IndikatorMutu::where('id', $id)->first();
        if ($request->ajax()) {
            return response()->json($indikator);
        } else {
            return redirect()->route('indikatormutu.index');
        }
    }

}