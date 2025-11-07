<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\UsuarioController;

// ===============================
// PÁGINAS PRINCIPALES Y BÁSICAS
// ===============================
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/rol', fn() => view('rol'))->name('rol');
Route::get('/acerca', fn() => view('about'))->name('about');
Route::get('/recursos', fn() => view('resources'))->name('resources');
Route::get('/servicios', fn() => view('services'))->name('services');
Route::get('/chat', fn() => view('chat'))->name('chat');
Route::get('/reporte', fn() => view('reporte'))->name('reporte');

// ===============================
// LOGIN Y LOGOUT GENERAL
// ===============================
// Mostrar formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.user');

// Procesar login
Route::post('/login', [LoginController::class, 'login'])->name('login.user.process');

// Logout para cada tipo de usuario (POST)
Route::post('/logout/usuario', [LoginController::class, 'logoutUsuario'])->name('logout.usuario');
Route::post('/logout/psicologo', [LoginController::class, 'logoutPsicologo'])->name('logout.psicologo');
Route::post('/logout/admin', [LoginController::class, 'logoutAdmin'])->name('logout.admin');

// ===============================
// RUTAS PARA USUARIO
// ===============================
Route::get('/registro/usuario', fn() => view('register-user'))->name('register.user');
Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('inicio.usuario');

// ===============================
// RUTAS PARA HISTORIAS
// ===============================
Route::get('/historias', fn() => view('historias'))->name('historias');
Route::get('/historias/mas', fn() => view('historias.mas'))->name('historias.mas');
Route::get('/historias/enviar', fn() => view('historias.enviar'))->name('historias.enviar');

// ===============================
// RUTAS PARA PSICÓLOGO
// ===============================
Route::get('/dashboard/psicologo', [PsicologoController::class, 'dashboard'])->name('dashboard.psychologist');

// Submódulos de psicólogo
Route::get('/psychologist/casos-reportados', [ReporteController::class, 'index'])->name('psychologist.reporte');
Route::get('/psychologist/chat-apoyo', [ChatController::class, 'index'])->name('psychologist.chat');
Route::get('/psychologist/recursos-profesionales', [RecursoController::class, 'index'])->name('psychologist.resources');
Route::get('/psychologist/reportes-estadisticos', [EstadisticaController::class, 'index'])->name('psychologist.estadisticos');

// CRUD de Psicólogos (protegido)
Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psicologos', [PsicologoController::class, 'index'])->name('psicologos.index');
    Route::get('/psicologos/crear', [PsicologoController::class, 'create'])->name('psicologos.create');
    Route::post('/psicologos', [PsicologoController::class, 'store'])->name('psicologos.store');
    Route::get('/psicologos/{id}/editar', [PsicologoController::class, 'edit'])->name('psicologos.edit');
    Route::put('/psicologos/{id}', [PsicologoController::class, 'update'])->name('psicologos.update');
    Route::delete('/psicologos/{id}', [PsicologoController::class, 'destroy'])->name('psicologos.destroy');
});

// ===============================
// RUTAS PARA ADMINISTRADOR
// ===============================
Route::prefix('administrador')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administrador.dashboard');

    // CRUD de administradores
    Route::get('/', [AdminController::class, 'index'])->name('administrador.index');
    Route::get('/crear', [AdminController::class, 'create'])->name('administrador.create');
    Route::post('/', [AdminController::class, 'store'])->name('administrador.store');
    Route::get('/editar/{id}', [AdminController::class, 'edit'])->name('administrador.edit');
    Route::put('/actualizar/{id}', [AdminController::class, 'update'])->name('administrador.update');
    Route::delete('/eliminar/{id}', [AdminController::class, 'destroy'])->name('administrador.destroy');
});

// ===============================
// RUTAS PROTEGIDAS PARA USUARIO
// ===============================
Route::middleware(['auth.usuario'])->group(function () {
    Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('inicio.usuario');
    Route::get('/reporte', fn() => view('reporte'))->name('reporte');
    Route::get('/chat', fn() => view('chat'))->name('chat');
    Route::get('/recursos', fn() => view('resources'))->name('resources');
    Route::get('/historias', fn() => view('historias'))->name('historias');
});