<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserReminderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("ping", function(){
    return response()->json(["data" => "pong"]);
})->middleware(['auth:sanctum']);

Route::post("register", [AuthController::class, 'registration']);
Route::post("session", [AuthController::class, 'login']);
Route::put("session", [AuthController::class, 'refreshToken'])->middleware(['auth:sanctum']);

Route::prefix('reminders')->group(function () {
    Route::post('/', [UserReminderController::class, 'store']);
})->middleware(['auth:sanctum', 'ability:access-token']);