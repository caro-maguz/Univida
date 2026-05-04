<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReporteController;
use App\Models\TipoViolencia;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\ChatJuridicoController;


// PÁGINAS PRINCIPALES Y BÁSICAS
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/rol', fn() => view('rol'))->name('rol');
Route::get('/acerca', fn() => view('about'))->name('about');
Route::get('/recursos', [RecursoController::class, 'centro'])->name('resources');
Route::get('/servicios', fn() => view('services'))->name('services');
Route::get('/chat', fn() => view('chat'))->name('chat');


// LOGIN Y LOGOUT GENERAL
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.user');
Route::post('/login', [LoginController::class, 'login'])->name('login.user.process');

Route::post('/logout/usuario', [LoginController::class, 'logoutUsuario'])->name('logout.usuario');
Route::post('/logout/psicologo', [LoginController::class, 'logoutPsicologo'])->name('logout.psicologo');
Route::post('/logout/admin', [LoginController::class, 'logoutAdmin'])->name('logout.admin');


// RECUPERACIÓN DE CONTRASEÑA
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'mostrarFormularioSolicitud'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'enviarTokenRecuperacion'])->name('password.email');
Route::get('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'mostrarFormularioRestablecimiento'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'restablecerContrasena'])->name('password.update');


// RUTAS PARA USUARIO
Route::get('/registro/usuario', fn() => view('register-user'))->name('register.user');
Route::post('/registro/usuario', [App\Http\Controllers\UsuarioController::class, 'store'])->name('register.user.process');
Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('dashboard.user');


// RUTAS PARA HISTORIAS
Route::get('/historias', [HistoriaController::class, 'index'])->name('historias');
Route::get('/historias/mas', [HistoriaController::class, 'mas'])->name('historias.mas');
Route::get('/historias/enviar', [HistoriaController::class, 'showForm'])->name('historias.enviar');
Route::post('/historias', [HistoriaController::class, 'store'])->name('historias.store');


// RUTAS PARA PSICÓLOGO
Route::get('/dashboard/psicologo', [PsicologoController::class, 'dashboard'])->name('dashboard.psychologist');

Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psychologist/casos-reportados', 'App\Http\Controllers\ReporteController@index')->name('psychologist.reporte');
    Route::post('/psychologist/reporte/{id}/cerrar', 'App\Http\Controllers\ReporteController@cerrarReporte')->name('psychologist.reporte.cerrar');
    Route::get('/psychologist/chat-apoyo', 'App\Http\Controllers\ChatController@index')->name('psychologist.chat');
});

Route::get('/psychologist/recursos-profesionales', [RecursoController::class, 'index'])->name('psychologist.resources');
Route::get('/psychologist/reportes-estadisticos', [EstadisticaController::class, 'index'])->name('psychologist.estadisticos');

Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psychologist/estadisticas-fecha', [EstadisticaController::class, 'estadisticasPorFecha'])->name('psychologist.estadisticas.fecha');
    Route::get('/psychologist/reportes-recientes', [ReporteController::class, 'reportesRecientes'])->name('psychologist.reportes.recientes');
});

Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psicologos', [PsicologoController::class, 'index'])->name('psicologos.index');
    Route::get('/psicologos/crear', [PsicologoController::class, 'create'])->name('psicologos.create');
    Route::post('/psicologos', [PsicologoController::class, 'store'])->name('psicologos.store');
    Route::get('/psicologos/{id}/editar', [PsicologoController::class, 'edit'])->name('psicologos.edit');
    Route::put('/psicologos/{id}', [PsicologoController::class, 'update'])->name('psicologos.update');
    Route::delete('/psicologos/{id}', [PsicologoController::class, 'destroy'])->name('psicologos.destroy');
});


// RUTAS PARA ADMINISTRADOR
Route::prefix('administrador')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administrador.dashboard');
    Route::get('/', [AdminController::class, 'index'])->name('administrador.index');
    Route::get('/crear', [AdminController::class, 'create'])->name('administrador.create');
    Route::post('/', [AdminController::class, 'store'])->name('administrador.store');
    Route::get('/editar/{id}', [AdminController::class, 'edit'])->name('administrador.edit');
    Route::put('/actualizar/{id}', [AdminController::class, 'update'])->name('administrador.update');
    Route::delete('/eliminar/{id}', [AdminController::class, 'destroy'])->name('administrador.destroy');
});


// RUTAS PROTEGIDAS PARA USUARIO
Route::middleware(['auth.usuario'])->group(function () {

    Route::get('/reporte', function() {
        $tiposViolencia = TipoViolencia::all();
        return view('reporte', compact('tiposViolencia'));
    })->name('reporte');

    Route::post('/reporte', [ReporteController::class, 'store'])->name('reporte.store');

    Route::get('/chat', [ChatController::class, 'mostrarChat'])->name('chat');

    Route::get('/test', [App\Http\Controllers\TestController::class, 'mostrar'])->name('test.mostrar');
    Route::get('/test/historial', [App\Http\Controllers\TestController::class, 'historial'])->name('test.historial');

    //  CHAT JURÍDICO (CORREGIDO)
    Route::get('/chat-juridico', [ChatJuridicoController::class, 'iniciar'])->name('chat.juridico');
    Route::get('/chat-juridico/{id}', [ChatJuridicoController::class, 'ver'])->name('chat.juridico.ver');
    Route::post('/chat-juridico/enviar', [ChatJuridicoController::class, 'enviar'])->name('chat.juridico.enviar');
});


// CAMBIOS NUEVOS 
Route::middleware(['auth.usuario'])->group(function () {
    Route::get('/seleccion-ruta', fn() => view('seleccion-ruta'))->name('menu');
});