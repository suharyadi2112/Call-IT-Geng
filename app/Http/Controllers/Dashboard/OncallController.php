<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OncallDetail;
use App\Models\User;
use Illuminate\Http\Request;

class OncallController extends Controller
{
    public function index(){
        $user_worker  = User::where('role', 'worker')->get();
        $jadwal_oncall = OncallDetail::with('detailoncallusers')->get();
        return view('dashboard.oncall.oncall_index', compact('user_worker', 'jadwal_oncall'));
    }

    public function getOncall(Request $request){
        if ($request->ajax()) {
            $data = OncallDetail::with('detailoncallusers')->
                   //wheredata on this month
                     whereMonth('tanggal_oncall', date('m'))->
                    get(['id', 'id_users', 'tanggal_oncall', 'tipe_oncall', 'created_at', 'updated_at']);
            return response()->json($data);
        }

        // return redirect()->route('jadwal-oncall.index');
    }


    public function store(Request $request){
        $request->validate([
            'id_user' => 'required',
            'tipe_oncall' => 'required',
            'tanggal_oncall' => 'required',
        ],[
            'id_user.required' => 'Nama Worker tidak boleh kosong',
            'tipe_oncall.required' => 'Tipe oncall tidak boleh kosong',
            'tanggal_oncall.required' => 'Tanggal oncall tidak boleh kosong',
        ]);
        switch ($request->type) {
            case 'add' :
                try {
                    OncallDetail::create([
                        'id_users' => $request->id_user,
                        'tipe_oncall' => $request->tipe_oncall,
                        'tanggal_oncall' => $request->tanggal_oncall,
                    ]);
                    return response()->json(['message' => 'Data berhasil ditambahkan']);
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()]);
                }
                break; 
            case 'edit' :
                try {
                    OncallDetail::where('id', $request->id)->update([
                        'id_users' => $request->id_user,
                        'tipe_oncall' => $request->tipe_oncall,
                        'tanggal_oncall' => $request->tanggal_oncall,
                    ]);
                    return response()->json(['message' => 'Data berhasil diubah']);
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()]);
                }
                break;

            case 'delete' :
                try {
                    OncallDetail::where('id', $request->id)->delete();
                    return response()->json(['message' => 'Data berhasil dihapus']);
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()]);
                }
                break;
            default:
                return response()->json(['message' => 'Data gagal disimpan']);
                break;

        }

        return redirect()->route('jadwal-oncall.index');
    }
}
