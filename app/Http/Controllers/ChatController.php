<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Mensaje;
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

            // En el LoginController la sesión guarda el id común en la clave 'id'
            $usuarioId = session('id');

        // Obtener o crear chat activo para el usuario
        $chat = Chat::where('usuario_id', $usuarioId)
            ->whereIn('estado', ['activo', 'en_espera'])
            ->first();

        if (!$chat) {
            // Crear nuevo chat
            $chat = Chat::create([
                'usuario_id' => $usuarioId,
                'estado' => 'en_espera',
                'iniciado_en' => now()
            ]);

            // Mensaje de bienvenida automático
            Mensaje::create([
                'chat_id' => $chat->id,
                'tipo_remitente' => 'sistema',
                'mensaje' => 'Hola, gracias por escribirnos 😊 ¿Cómo te sientes hoy?',
                'leido' => true
            ]);
        }

        // Obtener todos los mensajes del chat
        $mensajes = Mensaje::where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat', compact('chat', 'mensajes'));
    }


    // ENVIAR MENSAJE DEL USUARIO
   
    
    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:1000',
            'chat_id' => 'required|exists:chats,id'
        ]);

            $usuarioId = session('id');

        // Verificar que el chat pertenece al usuario
        $chat = Chat::where('id', $request->chat_id)
            ->where('usuario_id', $usuarioId)
            ->first();

        if (!$chat) {
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        // Crear el mensaje
        $mensaje = Mensaje::create([
            'chat_id' => $chat->id,
            'tipo_remitente' => 'usuario',
            'remitente_id' => $usuarioId,
            'mensaje' => $request->mensaje,
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id,
                'mensaje' => $mensaje->mensaje,
                'tipo_remitente' => $mensaje->tipo_remitente,
                'created_at' => $mensaje->created_at->format('H:i')
            ]
        ]);
    }

    // OBTENER NUEVOS MENSAJES (POLLING)
  
    
    public function obtenerNuevosMensajes(Request $request)
    {
        $chatId = $request->chat_id;
        $ultimoMensajeId = $request->ultimo_mensaje_id ?? 0;

        $mensajes = Mensaje::where('chat_id', $chatId)
            ->where('id', '>', $ultimoMensajeId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'mensajes' => $mensajes->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'mensaje' => $msg->mensaje,
                    'tipo_remitente' => $msg->tipo_remitente,
                    'created_at' => $msg->created_at->format('H:i')
                ];
            })
        ]);
    }


    // FINALIZAR CHAT (USUARIO)

    
    public function finalizarChat(Request $request)
    {
        $chatId = $request->chat_id;
        // Usar la clave de sesión unificada 'id' para el usuario (coherente con mostrarChat/enviarMensaje)
        $usuarioId = session('id');

        $chat = Chat::where('id', $chatId)
            ->where('usuario_id', $usuarioId)
            ->first();

        if ($chat) {
            $chat->update([
                'estado' => 'finalizado',
                'finalizado_en' => now()
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Chat no encontrado'], 404);
    }


    // VISTA DEL PSICÓLOGO
   
    
    public function index()
    {
        // Verificar sesión de psicólogo
        if (!session('rol') || session('rol') !== 'psicologo') {
            return redirect()->route('login.user');
        }

            // En el LoginController la sesión guarda el id común en la clave 'id'
            $psicologoId = session('id');

        // Obtener chats en espera y activos del psicólogo
        $chatsEnEspera = Chat::where('estado', 'en_espera')
            ->with(['usuario', 'ultimoMensaje'])
            ->orderBy('iniciado_en', 'desc')
            ->get();

        $chatsActivos = Chat::where('psicologo_id', $psicologoId)
            ->where('estado', 'activo')
            ->with(['usuario', 'ultimoMensaje'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $chatsFinalizados = Chat::where('psicologo_id', $psicologoId)
            ->where('estado', 'finalizado')
            ->with(['usuario', 'ultimoMensaje'])
            ->orderBy('finalizado_en', 'desc')
            ->limit(10)
            ->get();

        return view('psychologist.chat', compact('chatsEnEspera', 'chatsActivos', 'chatsFinalizados'));
    }

    // VER CHAT ESPECÍFICO (PSICÓLOGO)
  
    
    public function verChat($chatId)
    {
        if (!session('rol') || session('rol') !== 'psicologo') {
            return redirect()->route('login.user');
        }

        $chat = Chat::with(['usuario', 'mensajes'])->findOrFail($chatId);
        
        return view('psychologist.chat-detalle', compact('chat'));
    }

  
    // TOMAR CHAT (PSICÓLOGO)

    
    public function tomarChat(Request $request)
    {
        $chatId = $request->chat_id;
        $psicologoId = session('psicologo_id');

        $chat = Chat::where('id', $chatId)
            ->where('estado', 'en_espera')
            ->first();

        if ($chat) {
            $chat->update([
                'psicologo_id' => $psicologoId,
                'estado' => 'activo'
            ]);

            // Mensaje automático
            Mensaje::create([
                'chat_id' => $chat->id,
                'tipo_remitente' => 'sistema',
                'mensaje' => 'Un profesional se ha unido a la conversación.',
                'leido' => false
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Chat no disponible'], 404);
    }


    // ENVIAR MENSAJE (PSICÓLOGO)
   
    
    public function psicologoEnviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:1000',
            'chat_id' => 'required|exists:chats,id'
        ]);

        $psicologoId = session('psicologo_id');

        $chat = Chat::where('id', $request->chat_id)
            ->where('psicologo_id', $psicologoId)
            ->where('estado', 'activo')
            ->first();

        if (!$chat) {
            return response()->json(['error' => 'No tienes acceso a este chat'], 403);
        }

        $mensaje = Mensaje::create([
            'chat_id' => $chat->id,
            'tipo_remitente' => 'psicologo',
            'remitente_id' => $psicologoId,
            'mensaje' => $request->mensaje,
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id,
                'mensaje' => $mensaje->mensaje,
                'tipo_remitente' => $mensaje->tipo_remitente,
                'created_at' => $mensaje->created_at->format('H:i')
            ]
        ]);
    }


    // ABRIR/CREAR CHAT PARA UN USUARIO (PSICÓLOGO)
    // Usa desde el detalle del reporte: si existe un chat no finalizado lo reutiliza,
    // si está en 'en_espera' lo toma y lo activa, si no existe crea uno nuevo.
    
    public function abrirChatParaUsuario(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|integer'
        ]);

        $usuarioId = $request->usuario_id;
        $psicologoId = session('id') ?? session('psicologo_id');

        // Buscar un chat no finalizado del usuario
        $chat = Chat::where('usuario_id', $usuarioId)
            ->whereIn('estado', ['en_espera', 'activo'])
            ->first();

        if ($chat) {
            if ($chat->estado === 'en_espera') {
                $chat->update([
                    'psicologo_id' => $psicologoId,
                    'estado' => 'activo'
                ]);

                // Mensaje automático informando que el profesional se unió
                Mensaje::create([
                    'chat_id' => $chat->id,
                    'tipo_remitente' => 'sistema',
                    'mensaje' => 'Un profesional se ha unido a la conversación.',
                    'leido' => false
                ]);
            } elseif ($chat->estado === 'activo' && !$chat->psicologo_id) {
                // Asignar psicólogo si aún no tiene
                $chat->update(['psicologo_id' => $psicologoId]);
            }
        } else {
            // Crear un chat activo asignado al psicólogo
            $chat = Chat::create([
                'usuario_id' => $usuarioId,
                'psicologo_id' => $psicologoId,
                'estado' => 'activo',
                'iniciado_en' => now()
            ]);

            Mensaje::create([
                'chat_id' => $chat->id,
                'tipo_remitente' => 'sistema',
                'mensaje' => 'Un profesional ha iniciado la conversación.',
                'leido' => false
            ]);
        }

        return response()->json(['success' => true, 'chat_id' => $chat->id]);
    }
}