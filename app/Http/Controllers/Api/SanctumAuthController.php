<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
}
