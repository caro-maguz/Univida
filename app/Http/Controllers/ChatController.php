<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\MensajeChat;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    // VISTA DEL USUARIO

    public function mostrarChat()
    {
        // Verificar sesión de usuario
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user');
        }

        $usuarioId = session('id');

        // Obtener chat activo del usuario
        $chat = Chat::where('fk_usuario', $usuarioId)
            ->where('estado', 'activo')
            ->first();

        if (!$chat) {

            // Crear nuevo chat
            $chat = Chat::create([
                'fk_usuario' => $usuarioId,
                'estado' => 'activo',
                'fecha_inicio' => now()
            ]);

            // Mensaje automático
            MensajeChat::create([
                'fk_chat' => $chat->id_chat,
                'emisor' => 'sistema',
                'tipo_remitente' => 'sistema',
                'contenido' => 'Hola, gracias por escribirnos 😊 ¿Cómo te sientes hoy?',
                'created_at' => now(),
                'leido' => false
            ]);
        }

        // Obtener mensajes
        $mensajes = MensajeChat::where('fk_chat', $chat->id_chat)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat', compact('chat', 'mensajes'));
    }


    // ENVIAR MENSAJE DEL USUARIO

    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chat,id_chat',
            'contenido' => 'required_without:mensaje|string|max:1000',
            'mensaje' => 'required_without:contenido|string|max:1000'
        ]);

        $usuarioId = session('id');

        // Verificar que el chat pertenece al usuario
        $chat = Chat::where('id_chat', $request->chat_id)
            ->where('fk_usuario', $usuarioId)
            ->first();

        if (!$chat) {
            return response()->json([
                'error' => 'Chat no encontrado'
            ], 404);
        }

        $texto = $request->input('contenido') ?? $request->input('mensaje');

        // Crear mensaje
        $mensaje = MensajeChat::create([
            'fk_chat' => $chat->id_chat,
            'tipo_remitente' => 'usuario',
            'emisor' => 'usuario',
            'contenido' => $texto,
            'created_at' => now(),
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id_mensaje,
                'mensaje' => $mensaje->contenido,
                'contenido' => $mensaje->contenido,
                'tipo_remitente' => $mensaje->tipo_remitente,
                'created_at' => $mensaje->created_at
                    ? $mensaje->created_at->format('H:i')
                    : now()->format('H:i')
            ]
        ]);
    }


    // OBTENER NUEVOS MENSAJES

    public function obtenerNuevosMensajes(Request $request)
    {
        $chatId = $request->chat_id;
        $ultimoMensajeId = $request->ultimo_mensaje_id ?? 0;

        $mensajes = MensajeChat::where('fk_chat', $chatId)
            ->where('id_mensaje', '>', $ultimoMensajeId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'mensajes' => $mensajes->map(function ($msg) {

                return [
                    'id' => $msg->id_mensaje,
                    'mensaje' => $msg->contenido,
                    'contenido' => $msg->contenido,
                    'tipo_remitente' => $msg->tipo_remitente,
                    'created_at' => $msg->created_at
                        ? $msg->created_at->format('H:i')
                        : now()->format('H:i')
                ];
            })
        ]);
    }


    // FINALIZAR CHAT
public function finalizarChat(Request $request)
{
    $chatId = $request->chat_id;
    $usuarioId = session('id');

    $chat = Chat::where('id_chat', $chatId)
        ->where('fk_usuario', $usuarioId)
        ->first();

    if (!$chat) {
        return response()->json([
            'success' => false,
            'error' => 'Chat no encontrado'
        ], 404);
    }

    // Cerrar chat directamente SIN procedimiento almacenado
    $chat->update([
        'estado' => 'cerrado',
        'fecha_fin' => now()
    ]);

    return response()->json([
        'success' => true,
        'mensaje' => 'Chat finalizado correctamente'
    ]);
}


    // PANEL DEL PSICÓLOGO

    public function index()
    {
        if (!session('rol') || session('rol') !== 'psicologo') {
            return redirect()->route('login.user');
        }

        $psicologoId = session('id');

        // Chats en espera
        $chatsEnEspera = Chat::where('estado', 'activo')
            ->whereNull('fk_psicologo')
            ->with('usuario')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // Chats activos
        $chatsActivos = Chat::where('fk_psicologo', $psicologoId)
            ->where('estado', 'activo')
            ->with(['usuario', 'ultimoMensaje'])
            ->get()
            ->sortByDesc(function ($c) {

                return optional(optional($c->ultimoMensaje)->created_at)
                    ?? $c->fecha_inicio;
            })
            ->values();

        // Chats finalizados
        $chatsFinalizados = Chat::where('fk_psicologo', $psicologoId)
            ->where('estado', 'cerrado')
            ->with('usuario')
            ->orderBy('fecha_fin', 'desc')
            ->limit(10)
            ->get();

        return view('psychologist.chat', compact(
            'chatsEnEspera',
            'chatsActivos',
            'chatsFinalizados'
        ));
    }


    // VER CHAT

    public function verChat($chatId)
    {
        if (!session('rol') || session('rol') !== 'psicologo') {
            return redirect()->route('login.user');
        }

        $chat = Chat::with([
            'usuario',
            'mensajes' => function ($q) {
                $q->orderBy('created_at', 'asc');
            }
        ])->findOrFail($chatId);

        return view('psychologist.chat-detalle', compact('chat'));
    }


    // TOMAR CHAT

    public function tomarChat(Request $request)
    {
        $chatId = $request->chat_id;
        $psicologoId = session('id');

        $chat = Chat::where('id_chat', $chatId)
            ->where('estado', 'activo')
            ->whereNull('fk_psicologo')
            ->first();

        if ($chat) {

            $chat->update([
                'fk_psicologo' => $psicologoId
            ]);

            // Mensaje automático
            MensajeChat::create([
                'fk_chat' => $chat->id_chat,
                'tipo_remitente' => 'sistema',
                'emisor' => 'sistema',
                'contenido' => 'Un profesional se ha unido a la conversación.',
                'created_at' => now(),
                'leido' => false
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => 'Chat no disponible'
        ], 404);
    }


    // MENSAJE DEL PSICÓLOGO

    public function psicologoEnviarMensaje(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chat,id_chat',
            'contenido' => 'required_without:mensaje|string|max:1000',
            'mensaje' => 'required_without:contenido|string|max:1000'
        ]);

        $psicologoId = session('id');

        $chat = Chat::where('id_chat', $request->chat_id)
            ->where('fk_psicologo', $psicologoId)
            ->where('estado', 'activo')
            ->first();

        if (!$chat) {

            return response()->json([
                'error' => 'No tienes acceso a este chat'
            ], 403);
        }

        $texto = $request->input('contenido') ?? $request->input('mensaje');

        $mensaje = MensajeChat::create([
            'fk_chat' => $chat->id_chat,
            'tipo_remitente' => 'psicologo',
            'emisor' => 'psicologo',
            'contenido' => $texto,
            'created_at' => now(),
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id_mensaje,
                'mensaje' => $mensaje->contenido,
                'contenido' => $mensaje->contenido,
                'tipo_remitente' => $mensaje->tipo_remitente,
                'created_at' => $mensaje->created_at
                    ? $mensaje->created_at->format('H:i')
                    : now()->format('H:i')
            ]
        ]);
    }


    // ABRIR CHAT PARA USUARIO

    public function abrirChatParaUsuario(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|integer'
        ]);

        $usuarioId = $request->usuario_id;
        $psicologoId = session('id');

        // Buscar chat activo
        $chat = Chat::where('fk_usuario', $usuarioId)
            ->where('estado', 'activo')
            ->first();

        if ($chat) {

            if (!$chat->fk_psicologo) {

                $chat->update([
                    'fk_psicologo' => $psicologoId
                ]);

                MensajeChat::create([
                    'fk_chat' => $chat->id_chat,
                    'tipo_remitente' => 'sistema',
                    'emisor' => 'sistema',
                    'contenido' => 'Un profesional se ha unido a la conversación.',
                    'created_at' => now(),
                    'leido' => false
                ]);
            }

        } else {

            // Crear nuevo chat
            $chat = Chat::create([
                'fk_usuario' => $usuarioId,
                'fk_psicologo' => $psicologoId,
                'estado' => 'activo',
                'fecha_inicio' => now()
            ]);

            MensajeChat::create([
                'fk_chat' => $chat->id_chat,
                'tipo_remitente' => 'sistema',
                'emisor' => 'sistema',
                'contenido' => 'Un profesional ha iniciado la conversación.',
                'created_at' => now(),
                'leido' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id_chat
        ]);
    }
}