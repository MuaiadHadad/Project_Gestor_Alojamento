<?php

use App\Http\Controllers\GestorControllers;
use App\Http\Middleware\CheckGestor;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistarController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\SenhorioControllers;
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
Route::get('/inicio', function () {
    return view('inicio\index');
});

Route::get('/inicio/detalhe/quarto', function () {
    return view('inicio\detalhe_quarto');
});
Route::get('/inicio/detalhe/casa', function () {
    return view('inicio\detalhe_casa');
});


    Route::get('/Senhorio/chat', function () {
        if(session('tipo_usuario')=="senhorio"){
            return view('Page_Senhorio\conversation');
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    });
Route::post('/Senhorio/{id}/RemoverQuarto', [SenhorioControllers::class, 'RemoverQuarto']);
Route::post('/Senhorio/{id}/RemoverCasa', [SenhorioControllers::class, 'RemoverCasa']);
Route::post('/Senhorio/{id}/EstadoQuarto', [SenhorioControllers::class, 'MudarestadoQuarto']);
Route::post('/Senhorio/{id}/EstadoCasa', [SenhorioControllers::class, 'MudarestadoCasa']);
Route::post('/Senhorio/Adicionar/AddQuarto', [SenhorioControllers::class, 'AddQuarto']);
Route::post('/Senhorio/Adicionar/AddCasa', [SenhorioControllers::class, 'AddCasa']);
Route::get('/Senhorio/Adicionar', [SenhorioControllers::class, 'GetPageAddHome']);
Route::get('/Senhorio/Profile', [SenhorioControllers::class, 'GetPageProfSenhorio']);
Route::get('/Senhorio', [SenhorioControllers::class, 'GetPageSenhorio']);

Route::post('/user/{id}/update', [GestorControllers::class, 'updateProfile']);
Route::get('/Gestor/profile', [GestorControllers::class, 'GetPageProfGestor']);
Route::get('/gestor/profile', [GestorControllers::class, 'GetPageProfGestor']);
Route::get('/gestor/Adicionar_Gestor', [GestorControllers::class, 'GetPageAddGestor']);
Route::post('/AddGestor', [GestorControllers::class, 'Adicionargestor']);
Route::get('/Gestor', [GestorControllers::class, 'GetPageGestor']);
Route::post('/Gestor/{id}/EstadoUser', [GestorControllers::class, 'mudarestado']);
Route::post('/Gestor/{id}/RemoverUser', [GestorControllers::class, 'removerUser']);
Route::get('/gestor', [GestorControllers::class, 'GetPageGestor']);

Route::get('/validation', [ValidationController::class, 'GetPagevalidation']);
Route::get('/Login', [LoginController::class, 'GetPageLogin']);
Route::get('/Register', [RegistarController::class, 'GetPageRegister']);
Route::get('/login', [LoginController::class, 'GetPageLogin'])->name('LoginA');
Route::get('/register', [RegistarController::class, 'GetPageRegister']);
Route::post('/registrar', [RegistarController::class, 'registrar']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/validate-code', [ValidationController::class, 'validateCode']);
Route::get('/Reenviar-code/{email}', [ValidationController::class, 'ReenviarCode'])->name('reenviar.codigo');
Route::get('/Forget', [ForgetPasswordController::class, 'GetPageForget']);
Route::post('/RecuperarPassword', [ForgetPasswordController::class, 'RecuperarPassword']);
Route::get('/logout', [LoginController::class, 'Logout'])->name('logout');
