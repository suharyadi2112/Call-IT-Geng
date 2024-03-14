<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KatPengaduan;

class PengaduanController extends Controller
{
    public function index(){
        return view('dashboard.pengaduan.pengaduan_index');
    }


    public function kategori(){
        $kategori=KatPengaduan::all();
        return view('dashboard.pengaduan.pengaduan_kategori',['kategori' => $kategori]);
    }
}