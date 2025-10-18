<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chat de Apoyo - PsicoSalud Pro</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: font-family: 'Delius', cursive;
    }

    :root {
      --primary: #0d47a1;
      --primary-light: #1976d2;
      --primary-bg: #e3f2fd;
      --bg-gradient: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      --card-bg: white;
      --text: #2c3e50;
      --text-light: #546e7a;
      --border: #e0e0e0;
      --user-msg-bg: #e3f2fd;
      --other-msg-bg: #f5f5f5;
    }

    body {
      background: var(--bg-gradient);
      color: var(--text);
      min-height: 100vh;
    }

    header {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--primary-light);
      background: var(--primary-bg);
    }

    .page-title {
      font-size: 22px;
      font-weight: 700;
      color: var(--primary);
    }

    .main {
      max-width: 1400px;
      margin: 20px auto;
      padding: 0 20px;
      display: flex;
      gap: 24px;
      height: calc(100vh - 140px);
    }

    /* Panel de chats */
    .chats-sidebar {
      width: 320px;
      background: var(--card-bg);
      border-radius: 18px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .sidebar-header {
      padding: 20px;
      border-bottom: 1px solid var(--border);
      font-weight: 700;
      color: var(--primary);
      font-size: 18px;
    }

    .chat-list {
      flex: 1;
      overflow-y: auto;
      padding: 10px;
    }

    .chat-item {
      display: flex;
      gap: 14px;
      padding: 14px;
      border-radius: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .chat-item:hover {
      background: #f9fbfd;
    }

    .chat-item.active {
      background: var(--primary-bg);
      border-left: 3px solid var(--primary);
    }

    .chat-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-weight: bold;
    }

    .chat-info {
      flex: 1;
      min-width: 0;
    }

    .chat-name {
      font-weight: 600;
      color: var(--text);
      margin-bottom: 4px;
    }

    .chat-preview {
      font-size: 13px;
      color: var(--text-light);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .chat-time {
      font-size: 11px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* Panel de chat principal */
    .chat-main {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: var(--card-bg);
      border-radius: 18px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      overflow: hidden;
    }

    .chat-header {
      padding: 18px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .chat-header-info {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .main-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--primary-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-weight: bold;
    }

    .header-text h3 {
      font-size: 18px;
      color: var(--text);
      margin-bottom: 4px;
    }

    .header-text p {
      font-size: 14px;
      color: var(--text-light);
    }

    .quick-actions {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      padding: 8px 16px;
      border: none;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-escalar { background: #ffebee; color: #c62828; }
    .btn-urgente { background: #fff8e1; color: #f57c00; }

    .messages-container {
      flex: 1;
      padding: 24px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .message {
      max-width: 70%;
      padding: 12px 16px;
      border-radius: 18px;
      font-size: 15px;
      line-height: 1.5;
    }

    .message.received {
      align-self: flex-start;
      background: var(--other-msg-bg);
      border-bottom-left-radius: 4px;
    }

    .message.sent {
      align-self: flex-end;
      background: var(--user-msg-bg);
      color: var(--primary);
      border-bottom-right-radius: 4px;
    }

    .message-time {
      font-size: 11px;
      color: var(--text-light);
      text-align: right;
      margin-top: 4px;
    }

    /* Input de mensaje */
    .message-input-area {
      padding: 18px 24px;
      border-top: 1px solid var(--border);
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .attach-btn {
      background: none;
      border: none;
      color: var(--text-light);
      font-size: 20px;
      cursor: pointer;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: background 0.2s;
    }

    .attach-btn:hover {
      background: #f0f7ff;
    }

    .message-input {
      flex: 1;
      padding: 14px 18px;
      border: 1px solid var(--border);
      border-radius: 24px;
      font-size: 15px;
      resize: none;
      min-height: 20px;
      max-height: 100px;
    }

    .send-btn {
      background: var(--primary);
      color: white;
      border: none;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 18px;
      transition: background 0.2s;
    }

    .send-btn:hover {
      background: #0a3a8a;
    }

    .back-btn {
      background: #e3f2fd;
      color: var(--primary);
      border: none;
      padding: 8px 20px;
      border-radius: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }

    .back-btn:hover {
      background: #bbdefb;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .main {
        flex-direction: column;
        height: auto;
      }
      .chats-sidebar {
        width: 100%;
        max-height: 300px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo-section">
      <img src="{{ asset('img/imagenpsicologo.png') }}" alt="Foto de perfil" class="avatar" onerror="this.src='https://via.placeholder.com/48/1976d2/FFFFFF?text=P';">
      <h1 class="page-title">Chat de Apoyo</h1>
    </div>
    <a href="{{ route('dashboard.psychologist') }}" class="back-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </header>

  <div class="main">
    <!-- Lista de chats -->
    <div class="chats-sidebar">
      <div class="sidebar-header">
        <i class="fas fa-comments"></i> Chats activos
      </div>
      <div class="chat-list" id="chatList">
        <!-- Se llenará con JS -->
      </div>
    </div>

    <!-- Ventana de chat principal -->
    <div class="chat-main">
      <div class="chat-header">
        <div class="chat-header-info">
          <div class="main-avatar" id="currentAvatar">A</div>
          <div class="header-text">
            <h3 id="currentName">Selecciona un chat</h3>
            <p id="currentStatus">—</p>
          </div>
        </div>
        <div class="quick-actions">
          <button class="action-btn btn-escalar" onclick="alert('Caso escalado a supervisor.')">
            <i class="fas fa-level-up-alt"></i> Escalar caso
          </button>
          <button class="action-btn btn-urgente" onclick="marcarUrgente()">
            <i class="fas fa-exclamation-triangle"></i> Marcar urgente
          </button>
        </div>
      </div>

      <div class="messages-container" id="messagesContainer">
        <p style="align-self:center; color:#7f8c8d;">Selecciona un chat para ver el historial.</p>
      </div>

      <div class="message-input-area">
        <button class="attach-btn" title="Adjuntar guía o documento">
          <i class="fas fa-paperclip"></i>
        </button>
        <textarea class="message-input" id="messageInput" placeholder="Escribe un mensaje..."></textarea>
        <button class="send-btn" onclick="sendMessage()">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>

  <script>
    // Datos de ejemplo
    const chats = [
      {
        id: "chat1",
        name: "Anonimo1",
        lastMessage: "Hola, necesito apoyo con mi ansiedad...",
        time: "10:30",
        status: "En proceso",
        messages: [
          { text: "Hola, ¿en qué puedo ayudarte hoy?", sender: "me", time: "10:25" },
          { text: "Hola, necesito apoyo con mi ansiedad...", sender: "them", time: "10:30" }
        ]
      },
      {
        id: "chat2",
        name: "Anonimo2",
        lastMessage: "Gracias por la guía de respiración.",
        time: "Ayer",
        status: "En proceso",
        messages: [
          { text: "Te comparto esta guía de relajación.", sender: "me", time: "09:15" },
          { text: "Gracias por la guía de respiración.", sender: "them", time: "09:20" }
        ]
      },
      {
        id: "chat3",
        name: "Anonimo3",
        lastMessage: "No me siento bien...",
        time: "Hoy",
        status: "Urgente",
        urgent: true,
        messages: [
          { text: "¿Cómo te sientes hoy?", sender: "me", time: "08:00" },
          { text: "No me siento bien...", sender: "them", time: "08:05" }
        ]
      }
    ];

    let currentChat = null;

    // Renderizar lista de chats
    function renderChatList() {
      const container = document.getElementById('chatList');
      container.innerHTML = '';

      chats.forEach(chat => {
        const item = document.createElement('div');
        item.className = 'chat-item';
        if (currentChat && currentChat.id === chat.id) {
          item.classList.add('active');
        }
        item.innerHTML = `
          <div class="chat-avatar">${chat.name.charAt(0)}</div>
          <div class="chat-info">
            <div class="chat-name">${chat.name} ${chat.urgent ? '<span style="color:#c62828; font-size:12px;">● Urgente</span>' : ''}</div>
            <div class="chat-preview">${chat.lastMessage}</div>
            <div class="chat-time">${chat.time}</div>
          </div>
        `;
        item.onclick = () => openChat(chat);
        container.appendChild(item);
      });
    }

    // Abrir chat
    function openChat(chat) {
      currentChat = chat;
      renderChatList();

      document.getElementById('currentName').textContent = chat.name;
      document.getElementById('currentStatus').textContent = chat.status;
      document.getElementById('currentAvatar').textContent = chat.name.charAt(0);

      const messagesContainer = document.getElementById('messagesContainer');
      messagesContainer.innerHTML = '';

      chat.messages.forEach(msg => {
        const msgEl = document.createElement('div');
        msgEl.className = `message ${msg.sender === 'me' ? 'sent' : 'received'}`;
        msgEl.innerHTML = `
          ${msg.text}
          <div class="message-time">${msg.time}</div>
        `;
        messagesContainer.appendChild(msgEl);
      });

      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Enviar mensaje
    function sendMessage() {
      const input = document.getElementById('messageInput');
      const text = input.value.trim();
      if (!text || !currentChat) return;

      const now = new Date();
      const time = `${now.getHours()}:${String(now.getMinutes()).padStart(2, '0')}`;

      currentChat.messages.push({ text, sender: 'me', time });
      currentChat.lastMessage = text;
      currentChat.time = "Ahora";

      openChat(currentChat);
      input.value = '';
    }

    // Marcar como urgente
    function marcarUrgente() {
      if (!currentChat) {
        alert("Selecciona un chat primero.");
        return;
      }
      currentChat.urgent = true;
      currentChat.status = "Urgente";
      renderChatList();
      alert(`El caso de ${currentChat.name} ha sido marcado como URGENTE.`);
    }

    // Inicializar
    renderChatList();

    // Permitir enviar con Enter
    document.getElementById('messageInput').addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });
  </script>
</body>
</html>