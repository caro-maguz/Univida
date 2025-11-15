<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Gestión de Chats - Psicólogo</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
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
      padding: 2rem;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
    }

    h1 {
      color: #004aad;
      margin-bottom: 2rem;
      text-align: center;
    }

    .chats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .chat-section {
      background: white;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .section-title {
      font-size: 1.3rem;
      color: #004aad;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #004aad;
    }

    .chat-card {
      background: #f8f9fa;
      border-radius: 12px;
      padding: 1rem;
      margin-bottom: 1rem;
      border-left: 4px solid #004aad;
      transition: 0.3s;
    }

    .chat-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transform: translateY(-2px);
    }

    .chat-card.en-espera {
      border-left-color: #ffc107;
    }

    .chat-card.activo {
      border-left-color: #28a745;
    }

    .chat-card.finalizado {
      border-left-color: #6c757d;
      opacity: 0.8;
    }

    .chat-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.8rem;
    }

    .usuario-nombre {
      font-weight: bold;
      color: #333;
    }

    .chat-tiempo {
      font-size: 0.85rem;
      color: #666;
    }

    .ultimo-mensaje {
      color: #555;
      font-size: 0.9rem;
      margin-bottom: 0.8rem;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .chat-actions {
      display: flex;
      gap: 0.5rem;
    }

    .btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-primary {
      background: #004aad;
      color: white;
    }

    .btn-primary:hover {
      background: #003d8f;
    }

    .btn-success {
      background: #28a745;
      color: white;
    }

    .btn-success:hover {
      background: #218838;
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background: #5a6268;
    }

    .empty-state {
      text-align: center;
      padding: 2rem;
      color: #666;
    }

    .badge {
      display: inline-block;
      padding: 0.3rem 0.8rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: bold;
    }

    .badge-warning {
      background: #ffc107;
      color: #000;
    }

    .badge-success {
      background: #28a745;
      color: white;
    }

    .badge-secondary {
      background: #6c757d;
      color: white;
    }

    .header-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
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
  </style>
</head>
<body>
  <div class="container">
    <div class="header-actions">
      <h1>Gestión de Chats de Apoyo</h1>
      <a href="<?php echo e(route('dashboard.psychologist')); ?>" class="back-btn">← Regresar al Dashboard</a>
    </div>

    <div class="chats-grid">
      <!-- CHATS EN ESPERA -->
      <div class="chat-section">
        <h2 class="section-title">
          📩 Chats en Espera 
          <span class="badge badge-warning"><?php echo e($chatsEnEspera->count()); ?></span>
        </h2>
        
        <?php $__empty_1 = true; $__currentLoopData = $chatsEnEspera; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="chat-card en-espera">
            <div class="chat-info">
              <span class="usuario-nombre"><?php echo e(optional($chat->usuario)->nombre ?? 'Usuario #' . $chat->usuario_id); ?></span>
              <span class="chat-tiempo"><?php echo e(optional($chat->iniciado_en)->diffForHumans()); ?></span>
            </div>
            
            <?php if($chat->ultimoMensaje): ?>
              <div class="ultimo-mensaje">
                <?php echo e($chat->ultimoMensaje->mensaje); ?>

              </div>
            <?php endif; ?>
            
            <div class="chat-actions">
              <button class="btn btn-success" onclick="tomarChat(<?php echo e($chat->id); ?>)">
                Tomar Chat
              </button>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state">No hay chats en espera</div>
        <?php endif; ?>
      </div>

      <!-- CHATS ACTIVOS -->
      <div class="chat-section">
        <h2 class="section-title">
          💬 Mis Chats Activos 
          <span class="badge badge-success"><?php echo e($chatsActivos->count()); ?></span>
        </h2>
        
        <?php $__empty_1 = true; $__currentLoopData = $chatsActivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="chat-card activo">
            <div class="chat-info">
              <span class="usuario-nombre"><?php echo e(optional($chat->usuario)->nombre ?? 'Usuario #' . $chat->usuario_id); ?></span>
              <span class="chat-tiempo"><?php echo e(optional($chat->updated_at)->diffForHumans()); ?></span>
            </div>
            
            <?php if($chat->ultimoMensaje): ?>
              <div class="ultimo-mensaje">
                <?php echo e($chat->ultimoMensaje->mensaje); ?>

              </div>
            <?php endif; ?>
            
            <div class="chat-actions">
              <a href="<?php echo e(route('psychologist.chat.ver', $chat->id)); ?>" class="btn btn-primary">
                Ver Chat
              </a>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state">No tienes chats activos</div>
        <?php endif; ?>
      </div>

      <!-- CHATS FINALIZADOS -->
      <div class="chat-section">
        <h2 class="section-title">
          ✅ Chats Finalizados 
          <span class="badge badge-secondary"><?php echo e($chatsFinalizados->count()); ?></span>
        </h2>
        
        <?php $__empty_1 = true; $__currentLoopData = $chatsFinalizados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="chat-card finalizado">
            <div class="chat-info">
              <span class="usuario-nombre"><?php echo e(optional($chat->usuario)->nombre ?? 'Usuario #' . $chat->usuario_id); ?></span>
              <span class="chat-tiempo"><?php echo e(optional($chat->finalizado_en)->diffForHumans()); ?></span>
            </div>
            
            <?php if($chat->ultimoMensaje): ?>
              <div class="ultimo-mensaje">
                <?php echo e($chat->ultimoMensaje->mensaje); ?>

              </div>
            <?php endif; ?>
            
            <div class="chat-actions">
              <a href="<?php echo e(route('psychologist.chat.ver', $chat->id)); ?>" class="btn btn-secondary">
                Ver Historial
              </a>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state">No hay chats finalizados recientes</div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    async function tomarChat(chatId) {
      if (!confirm('¿Deseas tomar este chat?')) return;
      
      try {
        const response = await fetch('<?php echo e(route("psychologist.chat.tomar")); ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({ chat_id: chatId })
        });
        
        const data = await response.json();
        
        if (data.success) {
          window.location.href = `/psychologist/chat/${chatId}`;
        } else {
          alert('Error al tomar el chat: ' + (data.error || 'Desconocido'));
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error al tomar el chat');
      }
    }

    // Auto-refresh cada 10 segundos
    setInterval(() => {
      location.reload();
    }, 10000);
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\univida\resources\views/psychologist/chat.blade.php ENDPATH**/ ?>