<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
Route::get("/", [UrlController::class, 'index']);
Route::get("/home", [UrlController::class, 'index']);
Route::post("sendUrl", [UrlController::class, 'insertUrl']);
Route::get("redirect", [UrlController::class, 'redirectUrl']);

