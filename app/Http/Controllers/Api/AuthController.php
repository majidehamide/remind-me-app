<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        //if validation fails
        if ($validator->fails()) {
            
            return response()->json(
                [
                    'success' => false,
                    'errors'    => $validator->errors(), 
                ], 422);
        }

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => new UserResource($user),  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 401);
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "ok"=> false,
                "err"=> "ERR_INVALID_CREDS",
                "msg"=> "incorrect username or password"
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $accessToken = $user->createToken('auth_token',['token-access'], now()->addMinutes(10))->plainTextToken;
        $refreshToken = $user->createToken('refresh_token', ['token-refresh'], now()->addWeek())->plainTextToken;
        return response()->json([
            "ok"=> true,
            "data"=> [
                "user"=> new UserResource($user),
                "access_token"=> $accessToken,
                "refresh_token"=> $refreshToken
            ]
        ]);
    }

    public function refreshToken(Request $request){
        if ($request->user()->tokenCan('token-refresh')) {
            return response()->json([
                "ok"=> true,
                "data"=> [
                    "access_token"=> $request->user()->createToken('auth_token',['token-access'], now()->addMinutes(10))->plainTextToken
                ]
            ]);
        }
        return response()->json([
            "ok"=> false,
            "err"=> "ERR_INVALID_CREDS",
            "msg"=> "incorrect username or password"
        ], 401);
        
    }

}
