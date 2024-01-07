<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorType;
use App\Enums\ErrorMessage;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Services\AuthService\AuthServiceInterface;
use App\Services\UserService\UserServiceInterface;


class AuthController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(UserServiceInterface $userService, AuthServiceInterface $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    //registration method
    public function registration(StoreUserRequest $request)
    {
        try {
            //create user
            $user =  $this->userService->create($request->toDTO());
            //return response JSON user is created
            return JsonResponseHelper::successRegister(new UserResource($user));
        } catch (\Exception $e) {
            //return JSON process insert failed 
            return JsonResponseHelper::internalError(ErrorType::INTERNAL_ERROR_TYPE, ErrorMessage::INTERNAL_ERROR_MESSAGE);
        }
    }

    //login method
    public function login(LoginRequest $request) 
    {
        try {
            //attempt to login
            if (!Auth::attempt($request->toDTO->toArray())) {
                return JsonResponseHelper::unauthorizedErrorLogin();
            }
            //get user by email
            $user =  $this->userService->getByEmail($request->email);
            $accessToken = $this->authService->createAccessToken($user);
            $refreshToken = $this->authService->createRefreshToken($user);
            return JsonResponseHelper::successLogin(new UserResource($user), $accessToken, $refreshToken);
        } catch (\Exception $e) {
            //return JSON process failed 
            return JsonResponseHelper::internalError(ErrorType::INTERNAL_ERROR_TYPE, ErrorMessage::INTERNAL_ERROR_MESSAGE);
        }
        
    }
    //refresh user Token method
    public function refreshToken(Request $request)
    {
        try {
            $accessToken = $this->authService->createAccessToken($request->user());
            return JsonResponseHelper::successRefreshToken($accessToken);
        } catch (\Exception $e) {
            //return JSON process failed 
            return JsonResponseHelper::internalError(ErrorType::INTERNAL_ERROR_TYPE, ErrorMessage::INTERNAL_ERROR_MESSAGE);
        }
    }

}
