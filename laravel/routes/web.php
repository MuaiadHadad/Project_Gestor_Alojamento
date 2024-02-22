<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistarController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('inicio\index');
});
Route::get('/home', function () {
    return view('inicio\index');
});
Route::get('/inicio', function () {
    return view('inicio\index');
});
Route::get('/Login', [LoginController::class, 'GetPageLogin']);
Route::get('/Register', [RegistarController::class, 'GetPageRegister']);
Route::get('/login', [LoginController::class, 'GetPageLogin']);
Route::get('/register', [RegistarController::class, 'GetPageRegister']);
