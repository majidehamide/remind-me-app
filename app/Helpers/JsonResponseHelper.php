<?php

namespace App\Helpers;

use App\Enums\HttpStatus;

class JsonResponseHelper
{
    public static function successRegister($user){
        return response()->json([
            "success" =>true,
            "user" => $user
        ], HttpStatus::SUCCESS);
    }

    public static function internalError($errorType, $errorMessage){
        return response()->json([
                "ok"=> false,
                "err"=> $errorType,
                "msg"=> $errorMessage
        ], HttpStatus::UNPROCESSABLE_ENTITY);
    }
}
