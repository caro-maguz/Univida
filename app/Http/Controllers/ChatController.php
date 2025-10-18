<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::with('usuario')->where('estado', 'activo')->get();
        return view('psychologist.chat', compact('chats'));
    }
}