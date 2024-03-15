<?php

namespace App\Http\Controllers\Dashboard;

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
        if ($request->ajax()) {
            $data = IndikatorMutu::select('id', 'nama_indikator','target')
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
        return view('dashboard.indikatormutu.index');
    }

    public function store(Request $request)
    

    {
        $request->validate([
            'nama_indikator' => 'required',
            'target' => 'required',

        ], [
            'nama_indikator.required' => 'Nama indikator tidak boleh kosong',
            'target.required' => 'Target tidak boleh kosong',
            
        ]);
        IndikatorMutu::create([
            'nama_indikator' => $request->nama_indikator,
            'target' => $request->target,
        ]);
        return response()->json(['success' => 'Indikator Mutu berhasil ditambahkan']);
    }

    public function updateindikator(Request $request)
    {
        $request->validate([
            'nama_indikator_update' => 'required',
            'targetupdate' => 'required',

        ], [
            'nama_indikator_update.required' => 'Nama indikator tidak boleh kosong',
            'targetupdate.required' => 'Target tidak boleh kosong',
        ]);


        $nama_indikator_update = $request->nama_indikator_update;
        IndikatorMutu::whereId($request->idupdate)->update(
            ['nama_indikator'=>$nama_indikator_update,
            'target'=>$request->targetupdate]
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
