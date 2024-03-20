<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){

        $user = auth()->user();

        return view('dashboard.profil', [
            'user' => $user
        ]);
    }

    public function update(Request $request){
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'handphone' => 'required|numeric',
            'password' => 'nullable|min:8',
            'jabatan' => 'required',
            'divisi' => 'required',

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->handphone = $request->handphone;
        $user->jabatan = $request->jabatan;
        $user->divisi = $request->divisi;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
