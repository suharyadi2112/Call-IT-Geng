<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

use App\Models\KatPengaduan;

class KategoriPengaduanController extends Controller
{
    public function kategori(Request $request)
    {
        if ($request->ajax()) {
            $data = KatPengaduan::select('id', 'nama', 'gambar')
                ->latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('gambar', function ($row) {
                    return '<img src="' . asset('storage/' . $row->gambar) . '" class="img-thumbnail" width="30" height="30" style="background-color: #28a745;">';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="mr-2 btn btn-xs round btn-primary shadow" title="Edit" id="modalEdit" data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-edit"></i>
                    </button>';
                    $actionBtn .= '<button type="button" class="btn btn-xs round btn-danger shadow" title="Delete" id="modalDelete"
                    data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('dashboard.pengaduan.pengaduan_kategori');
    }

    public function storekategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'gambar'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:512'

        ], [
            'nama.required' => 'Nama kategori tidak boleh kosong',
            'nama.min' => 'Nama kategori minimal 3 karakter',
            'nama.max' => 'Nama kategori maksimal 50 karakter',
            'gambar.required' => 'Gambar kategori tidak boleh kosong',
            'gambar.image' => 'Gambar kategori harus berupa gambar',
            'gambar.mimes' => 'Gambar kategori harus berupa gambar',
        ]);

        $path = '-';
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $filename = Str::slug($request->nama, '-'). $file->getClientOriginalExtension();
            $path = $file->storeAs('kategori', $filename, 'public');
        }
        KatPengaduan::Create([
            'nama' => $request->nama,
            'gambar' => $path,
            ]);
        return response()->json(['success' => 'Kategori berhasil ditambahkan']);
    }

    public function updatekategori(Request $request)
    {
        $request->validate([
            'namaupdate' => 'required|min:3|max:50',
            'gambar'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512'

        ], [
            'namaupdate.required' => 'Nama kategori tidak boleh kosong',
            'nama.min' => 'Nama kategori minimal 3 karakter',
            'namaupdate.max' => 'Nama kategori maksimal 50 karakter',
            'gambar.image' => 'Gambar kategori harus berupa gambar',
            'gambar.mimes' => 'Gambar kategori harus berupa gambar',
        ]);

        $id = $request->idupdate;
        $kategori = KatPengaduan::whereId($id)->first();

        $path = $kategori->gambar;
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $filename = Str::slug($request->namaupdate, '-'). $file->getClientOriginalExtension();
            $path = $file->storeAs('kategori', $filename, 'public');
        }

        KatPengaduan::whereId($id)->update([
            'nama' => $request->namaupdate,
            'gambar' => $path,
            ]);

        return response()->json(['success' => 'Kategori berhasil diubah']);
    }

    public function destroykategori($id)
    {
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
