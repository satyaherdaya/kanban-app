<?php

use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/register/process', [UserController::class, 'register']);
Route::post('/login/process', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::middleware('myauth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
});
