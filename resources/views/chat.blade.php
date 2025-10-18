<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat de Apoyo - Univida</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    *{
      font-family: 'Delius', cursive;
    }
    body {
      font-family: 'Quicksand', sans-serif;
      margin: 0;
      padding: 0;
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
    }

    .message {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 20px;
      font-size: 1rem;
      line-height: 1.5;
      display: flex;
      align-items: flex-start;
      gap: 8px;
    }

    .message img {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      object-fit: cover;
    }

    .profesional {
      background: #e1f5fe;
      align-self: flex-start;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
    }

    .usuario {
      background: #004aad;
      color: white;
      align-self: flex-end;
      box-shadow: 2px 2px 6px rgba(0,0,0,0.2);
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

    .chat-actions {
      margin-top: 1rem;
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .chat-actions a {
      border: 2px solid #004aad;
      padding: 0.6rem 1.4rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      color: #004aad;
      transition: 0.3s;
    }

    .chat-actions a:hover {
      background: #ffd54f;
      border-color: #ffd54f;
      color: #222;
    }

    .chat-actions a.primary {
      background: #004aad;
      color: white;
    }

    .chat-actions a.primary:hover {
      background: #ffd54f;
      color: #222;
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
  <!-- Header -->
  <header>
    <a href="{{ route('dashboard.user') }}">Regresar</a>
  </header>

  <main>
    <article class="chat-container">
      <!-- Mascota -->
      <section class="mascota">
        <img src="{{ asset('img/mascotainicio.png') }}" alt="Mascota Univida sonriente">
      </section>

      <!-- Chat -->
      <section class="chat-section">
        <h2 class="chat-header">Estamos contigo 💙 Tu bienestar importa</h2>
        
        <div class="messages" aria-live="polite">
          <div class="message profesional">
            <span>Hola, gracias por escribirnos 😊 ¿Cómo te sientes hoy?</span>
          </div>
          <div class="message usuario">
            <span>Me siento un poco ansioso...</span>
          </div>
        </div>

        <form class="chat-input" action="#" method="post">
          <input type="text" placeholder="Escribe tu mensaje..." required>
          <button type="submit">Enviar</button>
        </form>

        <div class="chat-actions">
          <a href="{{ route('dashboard.user') }}" class="danger">Finalizar Chat</a>
        </div>
      </section>
    </article>
  </main>
</body>
</html>