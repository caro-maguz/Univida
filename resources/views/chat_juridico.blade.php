<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat Jurídico</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #e3f2fd, #90caf9);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CONTENEDOR PRINCIPAL */
.chat-container {
    width: 90%;
    max-width: 900px;
    height: 90vh;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* HEADER */
.chat-header {
    background: #004aad;
    color: white;
    padding: 15px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chat-header span {
    font-size: 14px;
    opacity: 0.8;
}

/* MENSAJES */
.chat-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f4f8ff;
}

/* BURBUJAS */
.message {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 15px;
    margin-bottom: 10px;
    font-size: 14px;
}

/* USUARIO */
.user {
    background: #004aad;
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 0;
}

/* CONSULTOR */
.consultor {
    background: #e3f2fd;
    color: #333;
    margin-right: auto;
    border-bottom-left-radius: 0;
}

/* INPUT */
.chat-footer {
    padding: 15px;
    display: flex;
    gap: 10px;
    border-top: 1px solid #ddd;
}

.chat-footer input {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

.chat-footer button {
    background: #004aad;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.chat-footer button:hover {
    background: #ffc107;
    color: black;
}
</style>
</head>

<body>

<div class="chat-container">

    <!-- HEADER -->
    <div class="chat-header">
        ⚖️ Chat con Consultor Jurídico
        <span>En línea</span>
    </div>

    <!-- MENSAJES -->
    <div class="chat-body" id="chat-body">

        <!-- MENSAJE DE BIENVENIDA -->
        <div class="message consultor">
            👋 Hola, soy tu consultor jurídico. ¿En qué puedo ayudarte?
        </div>

        <!-- MENSAJES DINÁMICOS -->
        @foreach($mensajes ?? [] as $msg)
            <div class="message {{ $msg->emisor == 'usuario' ? 'user' : 'consultor' }}">
                {{ $msg->mensaje }}
            </div>
        @endforeach

    </div>

    <!-- INPUT -->
    <form class="chat-footer" method="POST" action="{{ route('chat.juridico.enviar') }}">
        @csrf
        <input type="hidden" name="chat_id" value="{{ $chat->id_chat ?? '' }}">
        
        <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>

        <button type="submit">Enviar</button>
    </form>

</div>

<script>
// AUTO SCROLL
const chatBody = document.getElementById('chat-body');
chatBody.scrollTop = chatBody.scrollHeight;
</script>

</body>
</html>