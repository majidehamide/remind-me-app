<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\ErrorType;
use App\Enums\ErrorMessage;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService\UserService;


class AuthController extends Controller
{
    public function registration(StoreUserRequest $request, UserService $userService)
    {
        try {
            //create user
            $user =  $userService->create($request->toDTO());
            //return response JSON user is created
            return JsonResponseHelper::successRegister(new UserResource($user));
        } catch (\Exception $e) {
            //return JSON process insert failed 
            return JsonResponseHelper::internalError(ErrorType::INTERNAL_ERROR_TYPE, ErrorMessage::INTERNAL_ERROR_MESSAGE);
        }
    }

    public function login(Request $request) 
    {
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

    public function refreshToken(Request $request)
    {
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
