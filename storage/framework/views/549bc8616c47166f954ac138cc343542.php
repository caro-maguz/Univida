<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Chat de Apoyo - Univida</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">

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

    .message.psicologo {
      background: #e1f5fe;
      align-self: flex-start;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
      color:#052e44;
    }

    .message.usuario {
      background: #004aad;
      color: white;
      align-self: flex-end;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.2);
    }

    .system-line {
      align-self: center;
      font-size: 0.85rem;
      color: #555;
      padding: 2px 8px;
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
      justify-content: center;
    }

    .chat-actions button {
      border: 2px solid #d32f2f;
      padding: 0.6rem 1.4rem;
      border-radius: 50px;
      font-weight: 600;
      color: #d32f2f;
      background: white;
      cursor: pointer;
    }

    .estado-chat {
      text-align: center;
      padding: 8px;
      border-radius: 10px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    .estado-activo {
      background: #d4edda;
      color: #155724;
    }

    .estado-en-espera {
      background: #fff3cd;
      color: #856404;
    }
  </style>
</head>

<body>

<header>
  <a href="<?php echo e(route('dashboard.user')); ?>">Regresar</a>
</header>

<main>
  <article class="chat-container">

    <section class="mascota">
      <img src="<?php echo e(asset('img/img5.png')); ?>" alt="Mascota Univida">
    </section>

    <section class="chat-section">

      <h2 class="chat-header">
        Estamos contigo 💙 Tu bienestar importa
      </h2>

      <div class="estado-chat <?php echo e($chat->estado === 'activo' ? 'estado-activo' : 'estado-en-espera'); ?>">
        <?php if($chat->estado === 'en_espera'): ?>
          ⏳ Esperando a que un profesional se una...
        <?php elseif($chat->estado === 'activo'): ?>
          ✅ Conectado con un profesional
        <?php endif; ?>
      </div>

      <div class="messages" id="messages-container">

        <?php $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensaje): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <?php
            $textoMensaje = $mensaje->mensaje ?? $mensaje->contenido;

            $isSystemConnection =
              $mensaje->tipo_remitente === 'sistema' &&
              (
                str_contains($textoMensaje, 'se ha unido') ||
                str_contains($textoMensaje, 'ha iniciado')
              );
          ?>

          <?php if($isSystemConnection): ?>

            <div class="system-line" data-mensaje-id="<?php echo e($mensaje->id); ?>">
              <?php echo e($textoMensaje); ?>

              ·
              <small>
                <?php echo e(optional($mensaje->fecha_hora)->format('H:i')); ?>

              </small>
            </div>

          <?php else: ?>

            <div class="message <?php echo e($mensaje->tipo_remitente === 'sistema' ? 'psicologo' : $mensaje->tipo_remitente); ?>"
                 data-mensaje-id="<?php echo e($mensaje->id); ?>">

              <span><?php echo e($textoMensaje); ?></span>

              <div class="message-time">
                <?php echo e(optional($mensaje->fecha_hora)->format('H:i')); ?>

              </div>

            </div>

          <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      </div>

      <form class="chat-input" id="chat-form">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="chat_id" value="<?php echo e($chat->id_chat); ?>">

        <input
          type="text"
          id="mensaje-input"
          name="mensaje"
          placeholder="Escribe tu mensaje..."
          required
          maxlength="1000"
        >

        <button type="submit" id="enviar-btn">
          Enviar
        </button>
      </form>

      <div class="chat-actions">
        <button onclick="finalizarChat()">
          Finalizar Chat
        </button>
      </div>

    </section>

  </article>
</main>

<script>

  const chatId = <?php echo e($chat->id_chat); ?>;
  let ultimoMensajeId = <?php echo e($mensajes->last()->id ?? 0); ?>;

  const csrfToken =
    document.querySelector('meta[name="csrf-token"]').content;

  function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
  }

  document
    .getElementById('chat-form')
    .addEventListener('submit', async function(e) {

      e.preventDefault();

      const input = document.getElementById('mensaje-input');
      const mensaje = input.value.trim();
      const btn = document.getElementById('enviar-btn');

      if (!mensaje) return;

      btn.disabled = true;

      try {

        const response = await fetch('<?php echo e(route("chat.enviar")); ?>', {
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
        }

      } catch(error) {

        console.error(error);

        alert('Error al enviar mensaje');

      } finally {

        btn.disabled = false;

      }

    });

  function agregarMensaje(mensaje) {

    const container =
      document.getElementById('messages-container');

    let div = document.createElement('div');

    const esSistema =
      mensaje.tipo_remitente === 'sistema';

    if (esSistema) {

      div.className = 'system-line';

      div.innerHTML = `
        ${mensaje.mensaje}
        ·
        <small>${mensaje.created_at}</small>
      `;

    } else {

      div.className =
        `message ${mensaje.tipo_remitente}`;

      div.innerHTML = `
        <span>${mensaje.mensaje}</span>
        <div class="message-time">
          ${mensaje.created_at}
        </div>
      `;
    }

    container.appendChild(div);

    ultimoMensajeId = mensaje.id;
  }

  async function verificarNuevosMensajes() {

    try {

      const response = await fetch(
        `<?php echo e(route("chat.nuevos")); ?>?chat_id=${chatId}&ultimo_mensaje_id=${ultimoMensajeId}`
      );

      const data = await response.json();

      if (data.mensajes.length > 0) {

        data.mensajes.forEach(msg => {
          agregarMensaje(msg);
        });

        scrollToBottom();
      }

    } catch(error) {

      console.error(error);

    }

  }

  async function finalizarChat() {

    if (!confirm('¿Deseas finalizar el chat?')) {
      return;
    }

    try {

      const response = await fetch(
        '<?php echo e(route("chat.finalizar")); ?>',
        {
          method: 'POST',

          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },

          body: JSON.stringify({
            chat_id: chatId
          })
        }
      );

      const data = await response.json();

      if (data.success) {

        alert('Chat finalizado');

        window.location.href =
          '<?php echo e(route("dashboard.user")); ?>';
      }

    } catch(error) {

      console.error(error);

    }

  }

  setInterval(verificarNuevosMensajes, 3000);

  scrollToBottom();

</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\univida\resources\views/chat.blade.php ENDPATH**/ ?>