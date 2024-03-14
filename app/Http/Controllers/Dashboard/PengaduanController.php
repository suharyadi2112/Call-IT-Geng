<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KatPengaduan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengaduanController extends Controller
{
    public function index()
    {
        return view('dashboard.pengaduan.pengaduan_index');
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
