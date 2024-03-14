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
            'password' => 'nullable|min:8'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
