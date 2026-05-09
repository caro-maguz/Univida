<?php

use Illuminate\Support\Facades\Route;
use App\Models\TipoViolencia;
use App\Http\Controllers\{
    ChatController,
    ReporteController,
    RecursoController,
    EstadisticaController,
    AdminController,
    LoginController,
    PsicologoController,
    UsuarioController,
    HistoriaController,
    ChatJuridicoController
};

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/rol', fn() => view('rol'))->name('rol');
Route::get('/acerca', fn() => view('about'))->name('about');
Route::get('/servicios', fn() => view('services'))->name('services');

/*
|--------------------------------------------------------------------------
| RECURSOS
|--------------------------------------------------------------------------
*/
Route::get('/recursos', [RecursoController::class, 'centro'])->name('resources');
Route::get('/recursos/descargar/{id}', [RecursoController::class, 'download'])->name('recursos.download');

/*
|--------------------------------------------------------------------------
| HISTORIAS (PÚBLICAS)
|--------------------------------------------------------------------------
*/
Route::get('/historias', [HistoriaController::class, 'index'])->name('historias');
Route::get('/historias/mas', [HistoriaController::class, 'mas'])->name('historias.mas');
Route::get('/historias/enviar', [HistoriaController::class, 'showForm'])->name('historias.enviar');
Route::post('/historias', [HistoriaController::class, 'store'])->name('historias.store');

/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.user');
Route::post('/login', [LoginController::class, 'login'])->name('login.user.process');

Route::post('/logout/usuario', [LoginController::class, 'logoutUsuario'])->name('logout.usuario');
Route::post('/logout/psicologo', [LoginController::class, 'logoutPsicologo'])->name('logout.psicologo');
Route::post('/logout/admin', [LoginController::class, 'logoutAdmin'])->name('logout.admin');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'mostrarFormularioSolicitud'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'enviarTokenRecuperacion'])->name('password.email');
Route::get('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'mostrarFormularioRestablecimiento'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'restablecerContrasena'])->name('password.update');

/*
|--------------------------------------------------------------------------
| USUARIO
|--------------------------------------------------------------------------
*/
Route::get('/registro/usuario', fn() => view('register-user'))->name('register.user');
Route::post('/registro/usuario', [UsuarioController::class, 'store'])->name('register.user.process');
Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('dashboard.user');

Route::middleware(['auth.usuario'])->group(function () {

    Route::get('/reporte', function () {
        $tiposViolencia = TipoViolencia::all();
        return view('reporte', compact('tiposViolencia'));
    })->name('reporte');

    Route::post('/reporte', [ReporteController::class, 'store'])->name('reporte.store');

    Route::get('/chat', [ChatController::class, 'mostrarChat'])->name('chat');
    Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])->name('chat.enviar');
    Route::get('/chat/nuevos-mensajes', [ChatController::class, 'obtenerNuevosMensajes'])->name('chat.nuevos');
    Route::post('/chat/finalizar', [ChatController::class, 'finalizarChat'])->name('chat.finalizar');

    Route::get('/test', [App\Http\Controllers\TestController::class, 'mostrar'])->name('test.mostrar');
    Route::post('/test/procesar', [App\Http\Controllers\TestController::class, 'procesar'])->name('test.procesar');
    Route::get('/test/historial', [App\Http\Controllers\TestController::class, 'historial'])->name('test.historial');

    Route::post('/notificacion/config', [App\Http\Controllers\NotificacionMotivacionalController::class, 'guardarConfig'])->name('notificacion.config');
    Route::get('/notificacion/siguiente', [App\Http\Controllers\NotificacionMotivacionalController::class, 'siguiente'])->name('notificacion.siguiente');
    Route::post('/notificacion/leida', [App\Http\Controllers\NotificacionMotivacionalController::class, 'marcarLeida'])->name('notificacion.leida');

    Route::get('/seleccion-ruta', fn() => view('seleccion-ruta'))->name('menu');
});

/*
|--------------------------------------------------------------------------
| PSICÓLOGO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.psychologist'])->group(function () {

    Route::get('/recursos-profesionales', [PsicologoController::class, 'recursos'])
        ->name('psychologist.resources');

    Route::get('/psychologist/estadisticos', [PsicologoController::class, 'estadisticos'])
        ->name('psychologist.estadisticos');

});
Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psychologist/historias/moderar', [HistoriaController::class, 'moderar'])
        ->name('psychologist.historias.moderar');
});
Route::get('/dashboard/psicologo', [PsicologoController::class, 'dashboard'])->name('dashboard.psychologist');
Route::prefix('psychologist')->middleware('auth.psychologist')->group(function () {
    Route::get('/recursos', [PsicologoController::class, 'recursos']);
    Route::get('/estadisticos', [PsicologoController::class, 'estadisticos']);
});
Route::middleware(['auth.psychologist'])->group(function () {

    Route::get('/psychologist/casos-reportados', [ReporteController::class, 'index'])->name('psychologist.reporte');
    Route::post('/psychologist/reporte/{id}/cerrar', [ReporteController::class, 'cerrarReporte'])->name('psychologist.reporte.cerrar');

    Route::get('/psychologist/chat-apoyo', [ChatController::class, 'index'])->name('psychologist.chat');
    Route::get('/psychologist/chat/{id}', [ChatController::class, 'verChat'])->name('psychologist.chat.ver');

    Route::post('/psychologist/chat/tomar', [ChatController::class, 'tomarChat'])->name('psychologist.chat.tomar');
    Route::post('/psychologist/chat/abrir', [ChatController::class, 'abrirChatParaUsuario'])->name('psychologist.chat.abrir');
    Route::post('/psychologist/chat/enviar', [ChatController::class, 'psicologoEnviarMensaje'])->name('psychologist.chat.enviar');

    Route::get('/chat-juridico', [ChatJuridicoController::class, 'iniciar'])->name('chat.juridico');
    Route::get('/chat-juridico/{id}', [ChatJuridicoController::class, 'ver'])->name('chat.juridico.ver');
    Route::post('/chat-juridico/enviar', [ChatJuridicoController::class, 'enviar'])->name('chat.juridico.enviar');
});

Route::middleware(['auth.psychologist'])->group(function () {

    // === Recursos profesionales ===
    Route::get('/recursos-profesionales', [PsicologoController::class, 'recursos'])
        ->name('psychologist.resources');
    Route::get('psychologist/estadisticos', [PsicologoController::class, 'estadisticos'])
        ->name('psychologist.estadisticos');

});

/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::prefix('administrador')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administrador.dashboard');

    Route::get('/', [AdminController::class, 'index'])->name('administrador.index');
    Route::get('/crear', [AdminController::class, 'create'])->name('administrador.create');
    Route::post('/', [AdminController::class, 'store'])->name('administrador.store');
    Route::get('/editar/{id}', [AdminController::class, 'edit'])->name('administrador.edit');
    Route::put('/actualizar/{id}', [AdminController::class, 'update'])->name('administrador.update');
    Route::delete('/eliminar/{id}', [AdminController::class, 'destroy'])->name('administrador.destroy');

    Route::get('/recursos', [RecursoController::class, 'adminIndex'])->name('administrador.recursos.index');
    Route::get('/recursos/crear', [RecursoController::class, 'create'])->name('administrador.recursos.create');
    Route::post('/recursos', [RecursoController::class, 'store'])->name('administrador.recursos.store');
    Route::get('/recursos/{id}/editar', [RecursoController::class, 'edit'])->name('administrador.recursos.edit');
    Route::put('/recursos/{id}', [RecursoController::class, 'update'])->name('administrador.recursos.update');
    Route::delete('/recursos/{id}', [RecursoController::class, 'destroy'])->name('administrador.recursos.destroy');
});

    // CHAT DE APOYO
Route::get('/chat', [ChatController::class, 'mostrarChat'])
    ->name('chat');

// ESTA RUTA FALTABA
Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])
    ->name('chat.enviar');

// OBTENER NUEVOS MENSAJES
Route::get('/chat/nuevos-mensajes', [ChatController::class, 'obtenerNuevosMensajes'])
    ->name('chat.nuevos');

// FINALIZAR CHAT
Route::post('/chat/finalizar', [ChatController::class, 'finalizarChat'])
    ->name('chat.finalizar');


Route::middleware(['auth.psychologist'])->group(function () {

    Route::get('/chat-juridico', [ChatJuridicoController::class, 'iniciar'])->name('chat.juridico');
    Route::get('/chat-juridico/{id}', [ChatJuridicoController::class, 'ver'])->name('chat.juridico.ver');
    Route::post('/chat-juridico/enviar', [ChatJuridicoController::class, 'enviar'])->name('chat.juridico.enviar');

});

