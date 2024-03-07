<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(){
        return view('dashboard.pengaduan.pengaduan_index');
    }


    public function kategori(){
        return view('dashboard.pengaduan.pengaduan_kategori');
    }
}