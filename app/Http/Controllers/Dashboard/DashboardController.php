<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $worker=User::where('divisi','IT')->get();
        return view('dashboard.dashboard',['worker'=>$worker]);
    }
}
