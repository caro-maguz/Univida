<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Inicio</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Delius', cursive;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      background-size: 200% 200%;
      animation: gradientMove 8s ease infinite;
      min-height: 100vh;
      color: #333;
      display: flex;
      flex-direction: column;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding: 1rem 2rem;
      background: rgba(255, 255, 255, 0.9);
      border-bottom: 3px solid #004aad;
      position: relative;
    }

    .user-menu {
      position: relative;
      cursor: pointer;
    }

    .user-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #004aad;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
      font-size: 1rem;
      transition: 0.3s;
    }

    .user-icon:hover {
      background: #ffc107;
      color: #000;
    }

    .dropdown {
      position: absolute;
      right: 0;
      top: 55px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      display: none;
      flex-direction: column;
      min-width: 150px;
      z-index: 100;
    }

    .dropdown a {
      padding: 12px;
      text-decoration: none;
      color: #333;
      font-size: 0.95rem;
      transition: background 0.3s;
    }

    .dropdown a:hover {
      background: #f1f1f1;
    }

    .user-menu.active .dropdown {
      display: flex;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      gap: 2rem;
      padding: 2rem 3rem;
      max-width: 1000px;
      width: 100%;
    }

    .contenido {
      flex: 1;
    }

    .contenido h1 {
      font-size: 1.8rem;
      color: #004aad;
      margin-bottom: 1rem;
    }

    .contenido p {
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      color: #444;
    }

    .buttons {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      max-width: 500px;
    }

    .btn {
      display: block;
      padding: 1rem;
      border-radius: 10px;
      text-align: center;
      font-weight: bold;
      text-decoration: none;
      font-size: 1rem;
      transition: 0.3s;
      background: #004aad;
      color: #fff;
    }

    .btn:hover {
      background: #ffc107;
      color: #000;
    }

    .mascota img {
      max-width: 300px;
      height: auto;
    }

    footer {
      text-align: center;
      padding: 1rem;
      font-size: 0.9rem;
      color: #333;
      background: rgba(255, 255, 255, 0.9);
      border-top: 2px solid #004aad;
    }

    @media (max-width: 768px) {
      .card {
        flex-direction: column;
        text-align: center;
      }
      .buttons {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="user-menu" onclick="toggleMenu()">
    <div class="user-icon">{{ strtoupper(substr(session('nombre', 'U'), 0, 1)) }}</div>
    <div class="dropdown">
      <form action="{{ route('logout.usuario') }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" style="width:100%; text-align:left; padding:12px; background:none; border:none; cursor:pointer; font-family:'Delius', cursive; font-size:0.95rem; color:#333;">
          Cerrar sesión
        </button>
      </form>
    </div>
  </div>
</header>

<main>
  <div class="card">
    <section class="contenido">
      <h1>Estoy aquí para ayudarte a encontrar apoyo y recursos.</h1>
      <p>Cada día es una nueva oportunidad para avanzar. Estamos aquí para apoyarte.</p>

      <div class="buttons">
        <a href="{{ route('reporte') }}" class="btn">Reportar Caso</a>
        <a href="{{ route('chat') }}" class="btn">Chat de Apoyo</a>
        <a href="{{ route('test.mostrar') }}" class="btn">🧠 Realizar Test</a>
        <a href="{{ route('resources') }}" class="btn">Ver Recursos</a>
        <a href="{{ route('historias') }}" class="btn">Historias Anónimas</a>
        <a href="{{ route('test.historial') }}" class="btn">📊 Mi Historial</a>

        <!-- 🔥 NUEVO BOTÓN CHAT JURÍDICO -->
        <a href="{{ route('chat.juridico') }}" class="btn">⚖️ Chat Jurídico</a>
      </div>

      <div style="margin-top: 1.5rem; padding: 1rem; border:1px solid #cfe2ff; background:#f8fbff; border-radius:12px; max-width:400px;">
        <h3 style="color:#004aad; font-size:1.1rem; margin-bottom:0.6rem;">Mensajes motivacionales</h3>
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
          <label for="freq" style="min-width:140px;">Frecuencia:</label>
          <select id="freq" style="padding:8px 10px; border-radius:8px; border:1px solid #ccc;">
            <option value="diaria">Diaria</option>
            <option value="semanal">Semanal</option>
            <option value="mensual">Mensual</option>
          </select>
          <button id="saveFreq" class="btn" style="padding:10px 16px;">Guardar</button>
          <span id="saveMsg" style="color:#2e7d32; display:none;">Guardado ✅</span>
        </div>
      </div>
    </section>

    <div class="mascota">
      <img src="{{ asset('img/img4.png') }}" alt="Mascota Univida">
    </div>
  </div>
</main>

<footer>
  Cada día es una nueva oportunidad para avanzar. Estamos aquí para apoyarte.
</footer>

<script>
  function toggleMenu() {
    document.querySelector(".user-menu").classList.toggle("active");
  }
</script>

</body>
</html>