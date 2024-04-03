<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DataTables;

//model
use App\Models\User;


class SanctumAuthController extends Controller
{
    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email wajib berformat email dengan @.',
            'password.required' => 'Password wajib diisi.',
            'password.min:8' => 'Password minimal 8 karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
        }

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

            try {
                $user = Auth::user();
                $token = $user->createToken("callitgeng");
                return response()->json(
                    [
                        "status"  => "success",
                        "message" => "Success login",
                        "data"    => [
                            "token_type"   => "Bearer",
                            "access_token" => $token->plainTextToken,
                            "user_info"    => $user,
                        ],
                    ], 200);

            } catch (\Exception $e) {
                return response()->json(["status" => "fail", "message" => $e->getMessage(), "data" => null], 500);
            }
        } else {
            return response()->json(["status" => "fails", "message" => "Unauthorized", "data" => null], 401);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return response()->json(["status" => "success", "message" => "Logout Success", "data" => null], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "fail", "message" => $e->getMessage(), "data" => null], 500);
        }
    }

    public function GetUsers(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 per page
        $search = $request->input('search');
        $page = $request->input('page');

        try {
            $query = User::query();

            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }

            $query->orderBy('created_at', 'desc');
            $getUsers = $query->paginate($perPage);

            return response([
                "status" => "success",
                "message" => "Users retrieved successfully",
                "data" => $getUsers,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "status" => "fail",
                "message" => "An error occurred while fetching users: " . $e->getMessage(),
                "data" => null,
            ], 500);
        }
    }

    public function GetUsersYajra(){
        try {
            $model = User::query();
            return DataTables::eloquent($model)->toJson();
        } 
        catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetUsersByID($id){
        try {
            $getData = User::query()->find($id);

            if (!$getData) {
                throw new \Exception('User not found');
            }
            return response()->json(["status"=> "success","message"=> "Data successfully retrieved", "data" => $getData], 200);
        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function CheckValidToken(){ //cek valid token
        if (Auth::guard('sanctum')->check()) {
            return response()->json(["status"=> "success","message"=> "valid","data" => null], 200);
        } else {
            return response()->json(["status"=> "fail","message"=> "invalid authorization","data" => null], 400);
        }
    }

    public function GetUserList(){
        try {
            $queryy = User::query();
            $getUserList = $queryy->orderBy('created_at', 'desc')->select("id","name")->get(); 
            return response(["status"=> "success","message"=> "Data list user successfully retrieved", "data" => $getUserList], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function GetUsersWorker(){
        try {
            $queryy = User::query();
            $getUserWorker = $queryy->orderBy('created_at', 'desc')
            ->where('role','=','worker')
            ->get(); 
            return response(["status"=> "success","message"=> "Data list user only worker successfully retrieved", "data" => $getUserWorker], 200);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function StoreUser(Request $request){

        $validator = $this->validateUser($request, null , 'insert');  
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => null], 400);
        }
        try {
            DB::transaction(function () use ($request) {
                User::create([
                    'name' => strtolower($request->input('name')),
                    'email' => strtolower($request->input('email')),
                    'password' => Hash::make($request->input('password')), 
                    'handphone' => $request->input('handphone'),
                    'jabatan' => $request->input('jabatan'),
                    'role' => $request->input('role'),
                    'status' => 'Active',
                    'divisi' => $request->input('divisi'),
                ]);
            });
            return response()->json(["status"=> "success","message"=> "User successfully stored", "data" => $request->all()], 200);

        } catch (\Exception $e) {
            return response()->json(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }

    }

    public function DelUser($id){
        $nameUser = null;
        try{
            DB::transaction(function () use (&$nameUser, $id) {
                $userData = User::find($id);

                if (!$userData) {
                    throw new \Exception('user not found');
                }

                $nameUser = $userData->nama;
                $userData->delete();//SoftDelete
            });
            return response()->json(['status' => 'success', 'message' => 'user deleted successfully', 'data' => $nameUser], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function ChangePasswordUser(Request $request, $id)
    {
        try{

            if(Auth::user()->id != $id){
                throw new \Exception('user not matching');
            }

            $messages = [
                'password.required' => 'Password wajib diisi.',
                'password.max' => 'Password tidak boleh lebih dari 10 karakter.',
                'password.min' => 'Password tidak boleh kurang dari 8 karakter.',
                'password.confirmed' => 'Password password tidak sesuai.',
            ];

            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|max:10|confirmed',
            ], $messages);

            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            });
        
            return response()->json(['status' => 'success', 'message' => 'password change successfully', 'data' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function ResetPassword(Request $request, $id)
    {
        try{
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);

                $user->update([
                    'password' => Hash::make('12345678'),
                ]);
            });

            return response()->json(['status' => 'success', 'message' => 'password reset successfully', 'data' => null], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function UpdateUser(Request $request, $id){
        try {
            
            DB::transaction(function () use ($request, $id) {
                $userData = User::find($id);

                if (!$userData) {
                    throw new \Exception('user not found');
                }

                $validator = $this->validateUser($request, $id, 'update');
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $userData->fill($request->all());
                $userData->save();
            });

            return response()->json(['status' => 'success', 'message' => 'user updated successfully', 'data' => $request->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function ChangeEmail(Request $req, $id){

        try {

            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }
    
            $pesan = [
                'email.required' => 'Email wajib diisi.',
                'email.max' => 'Email max 50 karakter',
            ];
    
            $validator = Validator::make($req->all(), [
                'email' => 'required|max:50',
            ], $pesan);
    
            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            DB::transaction(function () use ($req, $user) {
                
                $user->fill($req->all());
                $user->save();
                
            });

            return response()->json(['status' => 'success', 'message' => 'email updated successfully', 'data' => $req->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }

    }

    public function ChangeNoHP(Request $req, $id){

        try {

            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }
    
            $pesan = [
                'handphone.required' => 'Handphone wajib diisi.',
                'handphone.max' => 'Handphone max 50 karakter',
            ];
    
            $validator = Validator::make($req->all(), [
                'handphone' => 'required|max:50',
            ], $pesan);
    
            if ($validator->fails()) {
                return response()->json(["status" => "fail", "message" => $validator->errors(), "data" => null], 400);
            }

            DB::transaction(function () use ($req, $user) {
                
                $user->fill($req->all());
                $user->save();
                
            });

            return response()->json(['status' => 'success', 'message' => 'handphone updated successfully', 'data' => $req->all()], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'fail', 'message' => $e->errors(), 'data' => null], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(), 'data' => null], 500);
        }

    }

    private function validateUser(Request $request, $id, $action = 'insert')
    {   

        $messages = [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.max' => 'Nama pengguna tidak boleh lebih dari 300 karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.max' => 'Email tidak boleh lebih dari 50 karakter.',
            'email.email' => 'Email wajib berformat email (@).',
            
            'password.required' => 'Password wajib diisi.',
            'password.max' => 'Password tidak boleh lebih dari 10 karakter.',
            'password.min' => 'Password tidak boleh kurang dari 8 karakter.',

            'handphone.required' => 'Handphone wajib diisi.',
            'handphone.between' => 'Handphone tidak boleh lebih dari 20 angka dan tidak kurang dari 10 angka',
            
            'jabatan.required' => 'jabatan wajib diisi.',
            'jabatan.max' => 'jabatan tidak boleh lebih dari 50 karakter.',
            
            'status.required' => 'Status wajib diisi.',
            'status.max' => 'Status tidak boleh lebih dari 20 karakter.',
            
            'divisi.required' => 'Divisi wajib diisi.',
            'divisi.max' => 'Divisi tidak boleh lebih dari 50 karakter.',
        ];

        $rules =  [
            'name' => 'required|max:300',
            'email' => ['required','max:50','email','unique:users,id',
                function ($attribute,$value, $fail) use ($request, $action, $id) {
                    $query = User::withTrashed()->where('email', $value)->where('deleted_at' , null);

                    if ($action === 'update') {
                        $query->where('id', '!=', $id);
                    }
                    
                    $existingData = $query->count();

                    if ($existingData > 0) {
                        $fail('Email sudah ada sebelumnya, gunakan email lain.');
                    }
                },
            ],
            'handphone' => 'required|string|between:10,20',
            'jabatan' => 'required|max:50',
            'status' => 'max:20',
            'divisi' => 'required|max:50',
        ];
        
        if ($action === 'insert') {
            $rules['password'] = 'required|min:8|max:10';
        }
        
        $validator = Validator::make($request->all(), $rules, $messages);
     
        return $validator;
    }
}
