<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\SliderController;



use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\EmployeeController;

use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DemandController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\PartnerController;

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

Route::post('message', [MessageController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/demands', [DemandController::class, 'index']);
    Route::get('/demand/{demand}', [DemandController::class, 'show']);
    Route::delete('/demand/{demand}', [DemandController::class, 'destroy']);

    Route::get('/feedbacks', [FeedbackController::class, 'index']);
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show']);
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy']);

    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blog_store', [BlogController::class, 'store']);
    Route::get('/blog/{blog}', [BlogController::class, 'show']);
    Route::post('/blog_update/{blog}', [BlogController::class, 'update']);
    Route::delete('/blog/{blog}', [BlogController::class, 'destroy']);

    Route::get('/partners', [PartnerController::class, 'index']);
    Route::post('/partner_store', [PartnerController::class, 'store']);
    Route::get('/partner/{partner}', [PartnerController::class, 'show']);
    Route::post('/partner_update/{partner}', [PartnerController::class, 'update']);
    Route::delete('/partner/{partner}', [PartnerController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category_store', [CategoryController::class, 'store']);
    Route::get('/category/{category}', [CategoryController::class, 'show']);
    Route::post('/category_update/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

    Route::get('/message', [MessageController::class, 'index']);
    Route::get('/message/{message}', [MessageController::class, 'show']);
    Route::delete('/message/{message}', [MessageController::class, 'destroy']);

    Route::post('employee', [EmployeeController::class, 'store']);
    Route::post('employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy']);

    Route::post('job', [JobController::class, 'store']);
    Route::post('job/{id}', [JobController::class, 'update']);
    Route::delete('job/{id}', [JobController::class, 'destroy']);

    Route::get('slider', [SliderController::class, 'index']);
    Route::get('slider/{id}', [SliderController::class, 'show']);
    Route::post('slider', [SliderController::class, 'store']);
    Route::delete('slider/{id}', [SliderController::class, 'destroy']);

});


Route::get('employee', [EmployeeController::class, 'index']);
Route::get('employee/{id}', [EmployeeController::class, 'show']);

Route::get('job', [JobController::class, 'index']);
Route::get('job/{id}', [JobController::class, 'show']);

