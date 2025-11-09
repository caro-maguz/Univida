<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chat - Usuario #{{ $chat->usuario_id }}</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Delius', cursive;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background: white;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-info h1 {
      color: #004aad;
      font-size: 1.5rem;
    }

    .header-info p {
      color: #666;
      font-size: 0.9rem;
      margin-top: 0.3rem;
    }

    .back-btn {
      background: white;
      color: #004aad;
      border: 2px solid #004aad;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #004aad;
      color: white;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .chat-container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 6px 25px rgba(0,0,0,0.15);
      max-width: 900px;
      width: 100%;
      height: 600px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .chat-header {
      background: #004aad;
      color: white;
      padding: 1.2rem;
      text-align: center;
      font-weight: bold;
      font-size: 1.2rem;
    }

    .messages {
      flex: 1;
      overflow-y: auto;
      padding: 1.5rem;
      background: #f8f9fa;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .message {
      max-width: 70%;
      padding: 1rem 1.2rem;
      border-radius: 18px;
      line-height: 1.5;
      word-wrap: break-word;
    }

    .message.usuario {
      background: #e3f2fd;
      align-self: flex-start;
      border: 2px solid #90caf9;
    }

    .message.psicologo {
      background: #004aad;
      color: white;
      align-self: flex-end;
    }

    .message.sistema {
      background: #fff3cd;
      color: #856404;
      align-self: center;
      text-align: center;
      max-width: 85%;
      border: 1px solid #ffc107;
    }

    .message-time {
      font-size: 0.75rem;
      opacity: 0.7;
      margin-top: 0.4rem;
    }

    .chat-input-container {
      padding: 1.2rem;
      background: white;
      border-top: 2px solid #e0e0e0;
    }

    .chat-input {
      display: flex;
      gap: 0.8rem;
    }

    .chat-input input {
      flex: 1;
      padding: 1rem;
      border-radius: 50px;
      border: 2px solid #ccc;
      font-size: 1rem;
      outline: none;
      transition: 0.3s;
    }

    .chat-input input:focus {
      border-color: #004aad;
    }

    .chat-input button {
      background: #004aad;
      color: white;
      border: none;
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .chat-input button:hover {
      background: #003d8f;
    }

    .chat-input button:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .estado-badge {
      display: inline-block;
      padding: 0.3rem 1rem;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: bold;
      margin-left: 1rem;
    }

    .badge-activo {
      background: #d4edda;
      color: #155724;
    }

    .badge-finalizado {
      background: #f8d7da;
      color: #721c24;
    }

    .chat-disabled-overlay {
      padding: 1rem;
      background: #f8d7da;
      color: #721c24;
      text-align: center;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-info">
      <h1>
        💬 Chat con Usuario #{{ $chat->usuario_id }}
        <span class="estado-badge {{ $chat->estado === 'activo' ? 'badge-activo' : 'badge-finalizado' }}">
          {{ $chat->estado === 'activo' ? 'Activo' : 'Finalizado' }}
        </span>
      </h1>
      <p>Iniciado: {{ $chat->iniciado_en->format('d/m/Y H:i') }}</p>
    </div>
    <a href="{{ route('psychologist.chat') }}" class="back-btn">← Volver</a>
  </header>

  <main>
    <div class="chat-container">
      <div class="chat-header">
        Conversación de Apoyo
      </div>

      <div class="messages" id="messages-container">
        @foreach($chat->mensajes as $mensaje)
          <div class="message {{ $mensaje->tipo_remitente }}" data-mensaje-id="{{ $mensaje->id }}">
            <div>{{ $mensaje->mensaje }}</div>
            <div class="message-time">{{ $mensaje->created_at->format('H:i') }}</div>
          </div>
        @endforeach
      </div>

      @if($chat->estado === 'activo')
        <div class="chat-input-container">
          <form class="chat-input" id="chat-form">
            @csrf
            <input 
              type="text" 
              id="mensaje-input" 
              name="mensaje" 
              placeholder="Escribe tu respuesta..." 
              required 
              maxlength="1000"
              autocomplete="off">
            <button type="submit" id="enviar-btn">Enviar</button>
          </form>
        </div>
      @else
        <div class="chat-disabled-overlay">
          Este chat ha sido finalizado y no se pueden enviar más mensajes
        </div>
      @endif
    </div>
  </main>

  <script>
    const chatId = {{ $chat->id }};
    const chatActivo = {{ $chat->estado === 'activo' ? 'true' : 'false' }};
    let ultimoMensajeId = {{ $chat->mensajes->last()->id ?? 0 }};
    let polling;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function scrollToBottom() {
      const container = document.getElementById('messages-container');
      container.scrollTop = container.scrollHeight;
    }

    // Enviar mensaje
    if (chatActivo) {
      document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('mensaje-input');
        const mensaje = input.value.trim();
        const btn = document.getElementById('enviar-btn');
        
        if (!mensaje) return;
        
        btn.disabled = true;
        
        try {
          const response = await fetch('{{ route("psychologist.chat.enviar") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
              chat_id: chatId,
              mensaje: mensaje
            })
          });
          
          const data = await response.json();
          
          if (data.success) {
            agregarMensaje(data.mensaje);
            input.value = '';
            scrollToBottom();
          } else {
            alert('Error: ' + (data.error || 'No se pudo enviar el mensaje'));
          }
        } catch (error) {
          console.error('Error al enviar mensaje:', error);
          alert('Error al enviar el mensaje. Intenta de nuevo.');
        } finally {
          btn.disabled = false;
          input.focus();
        }
      });
    }

    function agregarMensaje(mensaje) {
      const container = document.getElementById('messages-container');
      const div = document.createElement('div');
      div.className = `message ${mensaje.tipo_remitente}`;
      div.setAttribute('data-mensaje-id', mensaje.id);
      div.innerHTML = `
        <div>${mensaje.mensaje}</div>
        <div class="message-time">${mensaje.created_at}</div>
      `;
      container.appendChild(div);
      ultimoMensajeId = mensaje.id;
    }

    // Polling para nuevos mensajes
    async function verificarNuevosMensajes() {
      try {
        const response = await fetch(`{{ route("chat.nuevos") }}?chat_id=${chatId}&ultimo_mensaje_id=${ultimoMensajeId}`);
        const data = await response.json();
        
        if (data.mensajes && data.mensajes.length > 0) {
          data.mensajes.forEach(msg => {
            agregarMensaje(msg);
          });
          scrollToBottom();
        }
      } catch (error) {
        console.error('Error al verificar mensajes:', error);
      }
    }

    if (chatActivo) {
      polling = setInterval(verificarNuevosMensajes, 3000);
    }

    scrollToBottom();
  </script>
</body>
</html>