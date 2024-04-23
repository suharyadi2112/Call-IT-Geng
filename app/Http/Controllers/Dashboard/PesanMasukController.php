<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanMasukController extends Controller
{
    public function index()
    {
        return view('dashboard.pesanmasuk.pesanmasuk-index');
    }

    public function detail(){
        return view('dashboard.pesanmasuk.pesanmasuk-detail');
    }
}
