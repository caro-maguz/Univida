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

// ===============================
// PÁGINAS PRINCIPALES Y BÁSICAS
// ===============================
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/rol', fn() => view('rol'))->name('rol');
Route::get('/acerca', fn() => view('about'))->name('about');
// Centro de recursos (controlador para cargar categorías desde BD)
Route::get('/recursos', [RecursoController::class, 'centro'])->name('resources');
Route::get('/servicios', fn() => view('services'))->name('services');
Route::get('/chat', fn() => view('chat'))->name('chat');
// (El formulario de reporte es servido dentro de las rutas protegidas de usuario)

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
// Procesar registro de usuario
Route::post('/registro/usuario', [App\Http\Controllers\UsuarioController::class, 'store'])->name('register.user.process');
Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('inicio.usuario');

// ===============================
// RUTAS PARA HISTORIAS
// ===============================
Route::get('/historias', fn() => view('historias'))->name('historias');
Route::get('/historias', [HistoriaController::class, 'index'])->name('historias');
Route::get('/historias/mas', [HistoriaController::class, 'mas'])->name('historias.mas');
Route::get('/historias/enviar', [HistoriaController::class, 'showForm'])->name('historias.enviar');
Route::post('/historias', [HistoriaController::class, 'store'])->name('historias.store');

// ===============================
// RUTAS PARA PSICÓLOGO
// ===============================
Route::get('/dashboard/psicologo', [PsicologoController::class, 'dashboard'])->name('dashboard.psychologist');

// Submódulos de psicólogo (protegidos por auth.psychologist)
Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psychologist/casos-reportados', 'App\Http\Controllers\ReporteController@index')->name('psychologist.reporte');
    Route::post('/psychologist/reporte/{id}/cerrar', 'App\Http\Controllers\ReporteController@cerrarReporte')->name('psychologist.reporte.cerrar');
    Route::get('/psychologist/chat-apoyo', 'App\Http\Controllers\ChatController@index')->name('psychologist.chat');
});
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

    // CRUD de recursos
    Route::get('/recursos', [RecursoController::class, 'adminIndex'])->name('administrador.recursos.index');
    Route::get('/recursos/crear', [RecursoController::class, 'create'])->name('administrador.recursos.create');
    Route::post('/recursos', [RecursoController::class, 'store'])->name('administrador.recursos.store');
    Route::get('/recursos/{id}/editar', [RecursoController::class, 'edit'])->name('administrador.recursos.edit');
    Route::put('/recursos/{id}', [RecursoController::class, 'update'])->name('administrador.recursos.update');
    Route::delete('/recursos/{id}', [RecursoController::class, 'destroy'])->name('administrador.recursos.destroy');
});

// Ruta pública para descargar recursos
Route::get('/recursos/descargar/{id}', [RecursoController::class, 'download'])->name('recursos.download');

// ===============================
// RUTAS PROTEGIDAS PARA USUARIO
// ===============================
Route::middleware(['auth.usuario'])->group(function () {
    Route::get('/dashboard/usuario', [UsuarioController::class, 'inicio'])->name('inicio.usuario');
    Route::get('/reporte', function() {
        $tiposViolencia = TipoViolencia::all();
        return view('reporte', compact('tiposViolencia'));
    })->name('reporte');
    Route::post('/reporte', [ReporteController::class, 'store'])->name('reporte.store');
    Route::get('/chat', fn() => view('chat'))->name('chat');
    Route::get('/recursos', [RecursoController::class, 'centro'])->name('resources');
    // Nota: La ruta /historias está registrada fuera de este grupo y
    // apunta a HistoriaController@index para mostrar historias públicas.
});


// ===============================
// RUTAS DE CHAT PARA USUARIO
// ===============================
Route::middleware(['auth.usuario'])->group(function () {
    Route::get('/chat', [ChatController::class, 'mostrarChat'])->name('chat');
    Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])->name('chat.enviar');
    Route::get('/chat/nuevos-mensajes', [ChatController::class, 'obtenerNuevosMensajes'])->name('chat.nuevos');
    Route::post('/chat/finalizar', [ChatController::class, 'finalizarChat'])->name('chat.finalizar');
});

// ===============================
// RUTAS DE CHAT PARA PSICÓLOGO
// ===============================
Route::middleware(['auth.psychologist'])->group(function () {
    Route::get('/psychologist/chat-apoyo', [ChatController::class, 'index'])->name('psychologist.chat');
    Route::get('/psychologist/chat/{id}', [ChatController::class, 'verChat'])->name('psychologist.chat.ver');
    Route::post('/psychologist/chat/tomar', [ChatController::class, 'tomarChat'])->name('psychologist.chat.tomar');
    Route::post('/psychologist/chat/abrir', [ChatController::class, 'abrirChatParaUsuario'])->name('psychologist.chat.abrir');
    Route::post('/psychologist/chat/enviar', [ChatController::class, 'psicologoEnviarMensaje'])->name('psychologist.chat.enviar');
});