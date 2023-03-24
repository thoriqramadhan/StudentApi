<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/contest',[ContestController::class, 'index']);
    Route::get('/contest/{id}',[ContestController::class, 'show']);
    Route::post('/contest', [ContestController::class, 'store']);
    Route::patch('/contest/{id}', [ContestController::class, 'update'])->middleware(['contest.owner']);
    Route::delete('/contest/{id}', [ContestController::class, 'delete'])->middleware(['contest.owner']);


    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('comment.owner');
    Route::delete('/comment/{id}', [CommentController::class, 'delete'])->middleware('comment.owner');

    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'checkUser']);
});
Route::get('/contest2/{id}',[ContestController::class, 'show2']);

// Authentication
Route::post('/register', [AuthenticationController::class, '__invoke']);
Route::post('/login', [AuthenticationController::class, 'login']);
