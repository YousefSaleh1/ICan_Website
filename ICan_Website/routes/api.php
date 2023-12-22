<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DemandController;
use App\Http\Controllers\API\FeedbackController;

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

Route::post('/demand_store', [DemandController::class, 'store']);

Route::post('/feedback_store', [FeedbackController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/demands', [DemandController::class, 'index']);
    Route::get('/demand/{demand}', [DemandController::class, 'show']);
    Route::delete('/demand/{demand}', [DemandController::class, 'destroy']);

    Route::get('/feedbacks', [FeedbackController::class, 'index']);
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show']);
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy']);

});
