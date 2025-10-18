<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\AdminController;

// ===============================
// PÁGINA PRINCIPAL Y BÁSICAS
// ===============================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/rol', function () {
    return view('rol');
})->name('rol');

Route::get('/acerca', fn() => view('about'))->name('about');
Route::get('/recursos', fn() => view('resources'))->name('resources');
Route::get('/servicios', fn() => view('services'))->name('services');
Route::get('/chat', fn() => view('chat'))->name('chat');
Route::get('/reporte', fn() => view('reporte'))->name('reporte');

// ===============================
// RUTAS PARA USUARIO
// ===============================
Route::get('/login/user', fn() => view('login-user'))->name('login.user');
Route::get('/registro/usuario', fn() => view('register-user'))->name('register.user');

Route::get('/dashboard/usuario', fn() => view('dashboard-user'))->name('dashboard.user');

// ===============================
// RUTAS PARA HISTORIAS
// ===============================
Route::get('/historias', fn() => view('historias'))->name('historias');
Route::get('/historias/mas', fn() => view('historias-mas'))->name('historias.mas');
Route::get('/historias/enviar', fn() => view('historias-enviar'))->name('historias.enviar');

// ===============================
// RUTAS PARA PSICÓLOGO
// ===============================
Route::get('/login/psychologist', [PsychologistController::class, 'showLoginForm'])->name('login.psychologist');
Route::post('/login/psychologist', [PsychologistController::class, 'login'])->name('login.psychologist.post');
Route::post('/logout', [PsychologistController::class, 'logout'])->name('logout');

Route::get('/dashboard-psicologo', [PsychologistController::class, 'index'])->name('dashboard.psychologist');

// Submódulos de psicólogo
Route::get('/psychologist/casos-reportados', [ReporteController::class, 'index'])->name('psychologist.reporte');
Route::get('/psychologist/chat-apoyo', [ChatController::class, 'index'])->name('psychologist.chat');
Route::get('/psychologist/recursos-profesionales', [RecursoController::class, 'index'])->name('psychologist.resources');
Route::get('/psychologist/reportes-estadisticos', [EstadisticaController::class, 'index'])->name('psychologist.estadisticos');

// CRUD de Psicólogos (protegido)
Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psicologos', [PsychologistController::class, 'index'])->name('psicologos.index');
    Route::get('/psicologos/crear', [PsychologistController::class, 'create'])->name('psicologos.create');
    Route::post('/psicologos', [PsychologistController::class, 'store'])->name('psicologos.store');
    Route::get('/psicologos/{id}/editar', [PsychologistController::class, 'edit'])->name('psicologos.edit');
    Route::put('/psicologos/{id}', [PsychologistController::class, 'update'])->name('psicologos.update');
    Route::delete('/psicologos/{id}', [PsychologistController::class, 'destroy'])->name('psicologos.destroy');
});

// ===============================
// RUTAS PARA ADMINISTRADOR
// ===============================

Route::prefix('administrador')->group(function () {
    // 🔹 LOGIN Y DASHBOARD
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login.admin');
    Route::post('/login', [AdminController::class, 'login'])->name('login.admin.post');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administrador.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('administrador.logout');

    // 🔹 CRUD DE ADMINISTRADORES
    Route::get('/', [AdminController::class, 'index'])->name('administrador.index');
    Route::get('/crear', [AdminController::class, 'create'])->name('administrador.create');
    Route::post('/', [AdminController::class, 'store'])->name('administrador.store');
    Route::get('/editar/{id}', [AdminController::class, 'edit'])->name('administrador.edit');
    Route::put('/actualizar/{id}', [AdminController::class, 'update'])->name('administrador.update');
    Route::delete('/eliminar/{id}', [AdminController::class, 'destroy'])->name('administrador.destroy');
});


