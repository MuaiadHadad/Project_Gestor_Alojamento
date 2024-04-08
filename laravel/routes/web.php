<?php

use App\Http\Controllers\GestorControllers;
use App\Http\Controllers\PaginaInicialControllers;
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

    Route::get('/Senhorio/chat', function () {
        if(session('tipo_usuario')=="senhorio"){
            return view('Page_Senhorio\conversation');
        }else{
            abort(403, 'Acesso não autorizado.');
        }
    });

Route::get('/', [PaginaInicialControllers::class, 'GetPageInicial']);
Route::get('/inicio', [PaginaInicialControllers::class, 'GetPageInicial']);
Route::get('/inicio/{id}/quarto', [PaginaInicialControllers::class, 'GetPageDetalheQuarto']);
Route::get('/inicio/{id}/casa', [PaginaInicialControllers::class, 'GetPageDetalheCasa']);
Route::post('/inicio', [PaginaInicialControllers::class, 'Filtrar']);
Route::get('/pagina/{pagina?}', [PaginaInicialControllers::class, 'index']);

Route::post('/Senhorio/{id}/RemoverQuarto', [SenhorioControllers::class, 'RemoverQuarto']);
Route::post('/Senhorio/{id}/RemoverCasa', [SenhorioControllers::class, 'RemoverCasa']);
Route::post('/Senhorio/Adicionar/AddQuarto', [SenhorioControllers::class, 'AddQuarto']);
Route::post('/Senhorio/Adicionar/AddCasa', [SenhorioControllers::class, 'AddCasa']);
Route::get('/Senhorio/Adicionar', [SenhorioControllers::class, 'GetPageAddHome']);
Route::get('/Senhorio/Profile', [SenhorioControllers::class, 'GetPageProfSenhorio']);
Route::get('/Senhorio', [SenhorioControllers::class, 'GetPageSenhorio']);

Route::get('/Gestor/{id}/quarto', [GestorControllers::class, 'GetPageDetalheQuarto']);
Route::get('/Gestor/{id}/casa', [GestorControllers::class, 'GetPageDetalheCasa']);
Route::get('/Gestor/{id}/AprovarQuarto', [GestorControllers::class, 'AprovarQuarto']);
Route::get('/Gestor/{id}/ReprovarQuarto', [GestorControllers::class, 'ReprovarQuarto']);
Route::get('/Gestor/{id}/AprovarCasa', [GestorControllers::class, 'AprovarCasa']);
Route::get('/Gestor/{id}/ReprovarCasa', [GestorControllers::class, 'ReprovarCasa']);
Route::post('/Gestor/{id}/EstadoQuarto', [GestorControllers::class, 'MudarestadoQuarto']);
Route::post('/Gestor/{id}/EstadoCasa', [GestorControllers::class, 'MudarestadoCasa']);
Route::post('/user/{id}/update', [GestorControllers::class, 'updateProfile']);
Route::get('/Gestor/profile', [GestorControllers::class, 'GetPageProfGestor']);
Route::get('/gestor/profile', [GestorControllers::class, 'GetPageProfGestor']);
Route::get('/gestor/Adicionar_Gestor', [GestorControllers::class, 'GetPageAddGestor']);
Route::post('/AddGestor', [GestorControllers::class, 'Adicionargestor']);
Route::get('/Gestor', [GestorControllers::class, 'GetPageGestor']);
Route::post('/Gestor/{id}/EstadoUser', [GestorControllers::class, 'mudarestado']);
Route::post('/Gestor/{id}/RemoverUser', [GestorControllers::class, 'removerUser']);
Route::get('/gestor', [GestorControllers::class, 'GetPageGestor'])->name('/gestor');

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
