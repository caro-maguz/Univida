<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chat de Apoyo - Univida</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    *{
      font-family: 'Delius', cursive;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #fff9f0);
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      display: flex;
      justify-content: flex-end;
      padding: 1rem 2rem;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(8px);
    }

    header a {
      border: 2px solid #004aad;
      color: #004aad;
      text-decoration: none;
      padding: 0.5rem 1.2rem;
      border-radius: 50px;
      font-weight: 600;
      transition: 0.3s;
    }

    header a:hover {
      background: #ffd54f;
      border-color: #ffd54f;
      color: #222;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .chat-container {
      display: flex;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 6px 30px rgba(0,0,0,0.15);
      max-width: 1100px;
      width: 100%;
      overflow: hidden;
    }

    .mascota {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f9f9f9;
      padding: 30px;
    }

    .mascota img {
      max-width: 250px;
      height: auto;
      border-radius: 20px;
    }

    .chat-section {
      flex: 2;
      display: flex;
      flex-direction: column;
      padding: 30px;
      background: #fafbff;
    }

    .chat-header {
      font-size: 1.6rem;
      font-weight: bold;
      color: #004aad;
      margin-bottom: 1rem;
      text-align: center;
    }

    .messages {
      flex: 1;
      overflow-y: auto;
      padding: 15px;
      border-radius: 16px;
      background: #f1f6fb;
      display: flex;
      flex-direction: column;
      gap: 12px;
      min-height: 400px;
      max-height: 500px;
    }

    .message {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 20px;
      font-size: 1rem;
      line-height: 1.5;
      word-wrap: break-word;
    }

    .message.profesional, .message.sistema {
      background: #e1f5fe;
      align-self: flex-start;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
    }

    .message.usuario {
      background: #004aad;
      color: white;
      align-self: flex-end;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.2);
    }

    .message-time {
      font-size: 0.75rem;
      opacity: 0.7;
      margin-top: 4px;
    }

    .chat-input {
      display: flex;
      gap: 10px;
      margin-top: 1rem;
    }

    .chat-input input {
      flex: 1;
      padding: 14px;
      border-radius: 50px;
      border: 1px solid #ccc;
      font-size: 1rem;
      outline: none;
    }

    .chat-input button {
      background: #004aad;
      color: #fff;
      border: none;
      padding: 12px 22px;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .chat-input button:hover {
      background: #ffd54f;
      color: #222;
    }

    .chat-input button:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .chat-actions {
      margin-top: 1rem;
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .chat-actions button {
      border: 2px solid #d32f2f;
      padding: 0.6rem 1.4rem;
      border-radius: 50px;
      font-weight: 600;
      color: #d32f2f;
      background: white;
      cursor: pointer;
      transition: 0.3s;
    }

    .chat-actions button:hover {
      background: #d32f2f;
      color: white;
    }

    .estado-chat {
      text-align: center;
      padding: 8px;
      border-radius: 10px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    .estado-en-espera {
      background: #fff3cd;
      color: #856404;
    }

    .estado-activo {
      background: #d4edda;
      color: #155724;
    }

    @media (max-width: 768px) {
      .chat-container {
        flex-direction: column;
      }
      .mascota {
        order: -1;
      }
    }
  </style>
</head>
<body>
  <header>
    <a href="{{ route('inicio.usuario') }}">Regresar</a>
  </header>

  <main>
    <article class="chat-container">
      <section class="mascota">
        <img src="{{ asset('img/mascotainicio.png') }}" alt="Mascota Univida sonriente">
      </section>

      <section class="chat-section">
        <h2 class="chat-header">Estamos contigo 💙 Tu bienestar importa</h2>
        
        <div class="estado-chat {{ $chat->estado === 'activo' ? 'estado-activo' : 'estado-en-espera' }}">
          @if($chat->estado === 'en_espera')
            ⏳ Esperando a que un profesional se una...
          @elseif($chat->estado === 'activo')
            ✅ Conectado con un profesional
          @endif
        </div>
        
        <div class="messages" id="messages-container" aria-live="polite">
          @foreach($mensajes as $mensaje)
            <div class="message {{ $mensaje->tipo_remitente }}" data-mensaje-id="{{ $mensaje->id }}">
              <span>{{ $mensaje->mensaje }}</span>
              <div class="message-time">{{ $mensaje->created_at->format('H:i') }}</div>
            </div>
          @endforeach
        </div>

        <form class="chat-input" id="chat-form">
          @csrf
          <input type="hidden" name="chat_id" value="{{ $chat->id }}">
          <input type="text" id="mensaje-input" name="mensaje" placeholder="Escribe tu mensaje..." required maxlength="1000">
          <button type="submit" id="enviar-btn">Enviar</button>
        </form>

        <div class="chat-actions">
          <button onclick="finalizarChat()">Finalizar Chat</button>
        </div>
      </section>
    </article>
  </main>

  <script>
    const chatId = {{ $chat->id }};
    let ultimoMensajeId = {{ $mensajes->last()->id ?? 0 }};
    let polling;

    // Configurar CSRF token para todas las peticiones AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Scroll automático al último mensaje
    function scrollToBottom() {
      const container = document.getElementById('messages-container');
      container.scrollTop = container.scrollHeight;
    }

    // Enviar mensaje
    document.getElementById('chat-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const input = document.getElementById('mensaje-input');
      const mensaje = input.value.trim();
      const btn = document.getElementById('enviar-btn');
      
      if (!mensaje) return;
      
      btn.disabled = true;
      
      try {
        const response = await fetch('{{ route("chat.enviar") }}', {
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
          // Agregar mensaje al chat
          agregarMensaje(data.mensaje);
          input.value = '';
          scrollToBottom();
        }
      } catch (error) {
        console.error('Error al enviar mensaje:', error);
        alert('Error al enviar el mensaje. Intenta de nuevo.');
      } finally {
        btn.disabled = false;
        input.focus();
      }
    });

    // Agregar mensaje al DOM
    function agregarMensaje(mensaje) {
      const container = document.getElementById('messages-container');
      const div = document.createElement('div');
      div.className = `message ${mensaje.tipo_remitente}`;
      div.setAttribute('data-mensaje-id', mensaje.id);
      div.innerHTML = `
        <span>${mensaje.mensaje}</span>
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

    // Finalizar chat
    async function finalizarChat() {
      if (!confirm('¿Estás seguro de que deseas finalizar este chat?')) {
        return;
      }
      
      try {
        const response = await fetch('{{ route("chat.finalizar") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({
            chat_id: chatId
          })
        });
        
        const data = await response.json();
        
        if (data.success) {
          clearInterval(polling);
          alert('Chat finalizado. Gracias por usar nuestro servicio.');
          window.location.href = '{{ route("inicio.usuario") }}';
        }
      } catch (error) {
        console.error('Error al finalizar chat:', error);
        alert('Error al finalizar el chat.');
      }
    }

    // Iniciar polling cada 3 segundos
    polling = setInterval(verificarNuevosMensajes, 3000);

    // Scroll inicial
    scrollToBottom();
  </script>
</body>
</html>