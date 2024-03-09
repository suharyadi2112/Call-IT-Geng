<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;

class IndikatorMutuController extends Controller
{
    // public function index()
    // {
    //     $indikators = IndikatorMutu::all();
    //     return view('dashboard.indikatormutu.index')->with('indikators', $indikators);
    // }

    public function create()
    {
        return view('dashboard.indikatormutu.ceate');
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_indikator' => 'required',
    //         'target' => 'required|integer',
    //     ]);

    //     IndikatorMutu::create([
    //         'nama_indikator'=>$request->nama_indikator,
    //         'target'=>$request->target
    //     ]);    


    //     return redirect(route('indikatormutu.index'));
    // }

}
