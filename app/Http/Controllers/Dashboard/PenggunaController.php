<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Yajra\Datatables\Datatables;

class PenggunaController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = User::latest()->where('jabatan','!=','Administrator');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('pengguna.show', $row->id).'" class="mr-2 edit btn btn-outline-primary btn-sm editPengguna"><i class="fas fa-eye"></i></a>';
                    $btn.='<button type="button" id="modalDelete" class="mr-2 btn btn-sm round btn-outline-danger shadow" title="Hapus" data-id="' . $row->id . '">
                    <i class="fa fa-lg fa-fw fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pengguna.pengguna-index');
    }

    public function create(){
        return view('dashboard.pengguna.pengguna-create');
    }

    public function store(Request $request){
        $pesan = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'handphone.required' => 'No. Handphone tidak boleh kosong',
            'handphone.numeric' => 'No. Handphone harus berupa angka',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'divisi.required' => 'Divisi tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required',
            'handphone' => 'required|numeric',
            'password' => 'required|min:6',
            'jabatan' => ['required', Rule::in(['IT Support', 'Guest'])],
            'divisi' => 'required',
        ], $pesan);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'handphone' => $request->handphone,
                    'password' => bcrypt($request->password),
                    'jabatan' => $request->jabatan,
                    'divisi' => $request->divisi,
                    'status' => '-',
                ]);
            });
            return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan');

        }catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('dashboard.pengguna.pengguna-detail', compact('user'));
    }


    public function update(Request $request, $id){
        $pesan = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'handphone.required' => 'No. Handphone tidak boleh kosong',
            'handphone.numeric' => 'No. Handphone harus berupa angka',
            'password.min' => 'Password minimal 6 karakter',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'divisi.required' => 'Divisi tidak boleh kosong',
            'divisi.in' => 'Divisi tidak valid, pastikan memilih antara IT dan Umum',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required',
            'handphone' => 'required|numeric',
            'password' => 'nullable|min:6',
            'jabatan' => 'required',
            'divisi' => ['required', Rule::in(['IT', 'Umum'])],
        ], $pesan);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        $password  = null;
        if($request->password == null){
            $password = User::where('id', $id)->first()->password;
        }else{
            $password = bcrypt($request->password);
        }

        try {
            DB::transaction(function () use ($request, $id, $password) {
                $user = User::findOrFail($id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'handphone' => $request->handphone,
                    'password' => $password,
                    'jabatan' => $request->jabatan,
                    'divisi' => $request->divisi,
                ]);
            });
            return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diubah');

        }catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }

    }

    public function destroy($id){
        try {
            DB::transaction(function () use ($id) {
                User::findOrFail($id)->delete();
            });
            return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus');
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }
}
