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
Route::get('/test', function () {
    return view('inicio\test');
});
Route::get('/Gestor', function () {
    return view('Page_Gestor\Gestor');
});
Route::get('/gestor', function () {
    return view('Page_Gestor\Gestor');
});
Route::get('/Gestor/profile', function () {
    return view('Page_Gestor\Profile');
});
Route::get('/gestor/Adicionar_Gestor', function () {
    return view('Page_Gestor\Adicionar_Gestor');
});
Route::get('/validation', function () {
    return view('User\validation');
});
Route::get('/Senhorio', function () {
    return view('Page_Senhorio\Senhorio_Principal_page');
});
Route::get('/Senhorio/Profile', function () {
    return view('Page_Senhorio\Profile_Senhorio');
});
Route::get('/Senhorio/chat', function () {
    return view('Page_Senhorio\conversation');
});
Route::get('/Senhorio/Adicionar', function () {
    return view('Page_Senhorio\Adicionar_alojamento');
});
Route::get('/inicio/detalhe', function () {
    return view('inicio\detalhe_quarto');
});
Route::get('/Login', [LoginController::class, 'GetPageLogin']);
Route::get('/Register', [RegistarController::class, 'GetPageRegister']);
Route::get('/login', [LoginController::class, 'GetPageLogin']);
Route::get('/register', [RegistarController::class, 'GetPageRegister']);
