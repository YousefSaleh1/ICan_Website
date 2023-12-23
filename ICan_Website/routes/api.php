<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\MessageController;
use App\Models\Message;

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/message', [MessageController::class, 'index']);
    Route::get('/message/{message}', [MessageController::class, 'show']);
    Route::delete('/message/{message}', [MessageController::class, 'destroy']);

    Route::get('employee', [EmployeeController::class, 'index']);
    Route::get('employee/{id}', [EmployeeController::class, 'show']);
    Route::post('employee', [EmployeeController::class, 'store']);
    Route::post('employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy']);

});
Route::post('message', [MessageController::class, 'store']);


