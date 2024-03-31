<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistarController;
use App\Http\Controllers\ValidationController;

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
Route::get('/inicio/detalhe/quarto', function () {
    return view('inicio\detalhe_quarto');
});
Route::get('/inicio/detalhe/casa', function () {
    return view('inicio\detalhe_casa');
});
Route::get('/email', function () {
    return view('User\Email');
});

Route::get('/validation', [ValidationController::class, 'GetPagevalidation']);
Route::get('/Login', [LoginController::class, 'GetPageLogin']);
Route::get('/Register', [RegistarController::class, 'GetPageRegister']);
Route::get('/login', [LoginController::class, 'GetPageLogin']);
Route::get('/register', [RegistarController::class, 'GetPageRegister']);
Route::post('/registrar', [RegistarController::class, 'registrar']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/validate-code', [ValidationController::class, 'validateCode']);
Route::get('/Reenviar-code/{email}', [ValidationController::class, 'ReenviarCode'])->name('reenviar.codigo');
