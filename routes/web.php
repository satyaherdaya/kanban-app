<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
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
Route::post('/register/process', [UserController::class, 'register']);

Route::get('/login', function () {
    return view('login');
});
Route::post('/login/process', [UserController::class, 'login']);

Route::middleware('myauth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/logout', [UserController::class, 'logout']);

    Route::prefix('/category')->group(function () {
        Route::get('/create', function () {
            return view('create_category');
        });
        Route::post('/process', [CategoryController::class, 'save']);

        Route::get('/update/{id}', [CategoryController::class, 'updateView']);
        Route::post('/update/process/{id}', [CategoryController::class, 'update']);

        Route::get('/delete/{id}', [CategoryController::class, 'delete']);
    });

    Route::prefix('/task')->group(function () {
        Route::get('/create/{id}', [TaskController::class, 'viewCreate']);
        Route::post('/process', [TaskController::class, 'save']);

        Route::get('/update/{id}', [TaskController::class, 'updateView']);
        Route::post('/update/process/{id}', [TaskController::class, 'update']);

        Route::get('/delete/{id}', [TaskController::class, 'delete']);

        Route::post('/update/category', [TaskController::class, 'updateTaskCategory']);
    });
});
