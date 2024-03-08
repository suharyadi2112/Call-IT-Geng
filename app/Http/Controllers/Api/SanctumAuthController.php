<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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


}
