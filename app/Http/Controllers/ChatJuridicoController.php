<?php

namespace App\Http\Controllers;

use App\Models\ChatJuridico;
use App\Models\MensajeChatJuridico;
use Illuminate\Http\Request;

class ChatJuridicoController extends Controller
{
    public function iniciar()
    {
        $usuario_id = session('usuario_id');

        $chat = ChatJuridico::create([
            'fk_usuario' => $usuario_id,
            'fk_consultor' => 1,
            'estado' => 'activo'
        ]);

        return redirect()->route('chat.juridico.ver', $chat->id_chat);
    }

    public function ver($id)
    {
        $chat = ChatJuridico::findOrFail($id);
        $mensajes = MensajeChatJuridico::where('fk_chat', $id)->get();

        return view('chat_juridico', compact('chat', 'mensajes'));
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'mensaje' => 'required'
        ]);

        MensajeChatJuridico::create([
            'contenido' => $request->mensaje,
            'emisor' => 'usuario',
            'fk_chat' => $request->chat_id
        ]);

        return back();
    }
}