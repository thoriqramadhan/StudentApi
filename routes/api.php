<?php

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

Route::get('/contest',[ContestController::class, 'index']);
Route::get('/contest/{id}',[ContestController::class, 'show']);
Route::get('/contest2/{id}',[ContestController::class, 'show2']);
