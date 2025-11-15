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

            // En el LoginController la sesión guarda el id común en la clave 'id'
            $usuarioId = session('id');

        // Obtener o crear chat activo para el usuario
        $chat = Chat::where('fk_usuario', $usuarioId)
            ->whereIn('estado', ['activo', 'cerrado'])
            ->first();

        if (!$chat) {
            // Crear nuevo chat
            $chat = Chat::create([
                'fk_usuario' => $usuarioId,
                'estado' => 'activo',
                'fecha_inicio' => now()
            ]);

            // Mensaje de bienvenida automático
            \App\Models\MensajeChat::create([
                'fk_chat' => $chat->id_chat,
                'emisor' => 'sistema',
                'contenido' => 'Hola, gracias por escribirnos 😊 ¿Cómo te sientes hoy?',
                'fecha_hora' => now()
            ]);
        }

        // Obtener todos los mensajes del chat
        $mensajes = \App\Models\MensajeChat::where('fk_chat', $chat->id_chat)
            ->orderBy('fecha_hora', 'asc')
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
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        $texto = $request->input('contenido') ?? $request->input('mensaje');

        // Crear el mensaje
        $mensaje = MensajeChat::create([
            'fk_chat' => $chat->id_chat,
            'tipo_remitente' => 'usuario',
            'emisor' => 'usuario',
            'contenido' => $texto,
            'fecha_hora' => now(),
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id_mensaje,
                'mensaje' => $mensaje->contenido,
                'contenido' => $mensaje->contenido,
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

        $mensajes = MensajeChat::where('fk_chat', $chatId)
            ->where('id_mensaje', '>', $ultimoMensajeId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'mensajes' => $mensajes->map(function($msg) {
                return [
                    'id' => $msg->id_mensaje,
                    'mensaje' => $msg->contenido,
                    'contenido' => $msg->contenido,
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
        $usuarioId = session('id');

        $chat = Chat::where('id_chat', $chatId)
            ->where('fk_usuario', $usuarioId)
            ->first();

        if ($chat) {
            // Usar procedimiento almacenado para cerrar el chat
            DB::statement('CALL cerrar_chat(?, @msg)', [$chatId]);
            $resultado = DB::select('SELECT @msg as mensaje');
            
            return response()->json([
                'success' => true,
                'mensaje' => $resultado[0]->mensaje
            ]);
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

        $psicologoId = session('id');

        // Obtener chats sin psicólogo asignado (en espera)
        $chatsEnEspera = Chat::where('estado', 'activo')
            ->whereNull('fk_psicologo')
            ->with('usuario')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // Chats activos del psicólogo
        // Ordenar por último mensaje (fallback fecha_inicio) sin usar updated_at inexistente
        $chatsActivos = Chat::where('fk_psicologo', $psicologoId)
            ->where('estado', 'activo')
            ->with(['usuario','ultimoMensaje'])
            ->get()
            ->sortByDesc(function($c){
                return optional(optional($c->ultimoMensaje)->created_at) ?? $c->fecha_inicio;
            })->values();

        // Chats cerrados del psicólogo
        $chatsFinalizados = Chat::where('fk_psicologo', $psicologoId)
            ->where('estado', 'cerrado')
            ->with('usuario')
            ->orderBy('fecha_fin', 'desc')
            ->limit(10)
            ->get();

        return view('psychologist.chat', compact('chatsEnEspera', 'chatsActivos', 'chatsFinalizados'));
    }

    // VER CHAT ESPECÍFICO (PSICÓLOGO)
  
    
    public function verChat($chatId)
    {
        // Verificar sesión de psicólogo
        if (!session('rol') || session('rol') !== 'psicologo') {
            return redirect()->route('login.user');
        }

        // Cargamos usuario y mensajes para que la vista legacy use $chat->mensajes
        $chat = Chat::with(['usuario','mensajes' => function($q){
            $q->orderBy('fecha_hora','asc');
        }])->findOrFail($chatId);
        
        return view('psychologist.chat-detalle', compact('chat'));
    }

  
    // TOMAR CHAT (PSICÓLOGO)

    
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
                'fecha_hora' => now(),
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
            return response()->json(['error' => 'No tienes acceso a este chat'], 403);
        }

        $texto = $request->input('contenido') ?? $request->input('mensaje');

        $mensaje = MensajeChat::create([
            'fk_chat' => $chat->id_chat,
            'tipo_remitente' => 'psicologo',
            'emisor' => 'psicologo',
            'contenido' => $texto,
            'fecha_hora' => now(),
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => [
                'id' => $mensaje->id_mensaje,
                'mensaje' => $mensaje->contenido,
                'contenido' => $mensaje->contenido,
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
        $psicologoId = session('id');

        // Buscar un chat activo del usuario
        $chat = Chat::where('fk_usuario', $usuarioId)
            ->where('estado', 'activo')
            ->first();

        if ($chat) {
            if (!$chat->fk_psicologo) {
                // Asignar psicólogo si aún no tiene
                $chat->update(['fk_psicologo' => $psicologoId]);

                MensajeChat::create([
                    'fk_chat' => $chat->id_chat,
                    'tipo_remitente' => 'sistema',
                    'emisor' => 'sistema',
                    'contenido' => 'Un profesional se ha unido a la conversación.',
                    'fecha_hora' => now(),
                    'leido' => false
                ]);
            }
        } else {
            // Crear un chat activo asignado al psicólogo
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
                'fecha_hora' => now(),
                'leido' => false
            ]);
        }

        return response()->json(['success' => true, 'chat_id' => $chat->id_chat]);
    }
}