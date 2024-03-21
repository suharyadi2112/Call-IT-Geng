<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            'email' =>'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email wajib berformat email dengan @.',
            'password.required' => 'Password wajib diisi.',
            'password.min:8' => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors(['The provided credentials do not match our records.']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
