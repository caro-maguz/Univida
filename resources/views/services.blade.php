<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>¿Cómo te podemos ayudar?</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Delius', cursive;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #fff9f0);
      color: #ffffff;
      padding: 30px 20px;
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }


    .title-bar {
      background: #2c5aa0; 
      padding: 24px;
      border-radius: 16px;
      margin-bottom: 30px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    .title-bar h1 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #ffffff;
      margin: 0;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Botón Volver */
    .back-button {
      position: absolute;
      top: 20px;
      right: 20px;
      background: transparent;
      border: 2px solid #ffffff;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      color: #ffffff;
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .back-button:hover {
      background: #ffffff;
      color: #1e3a5f;
    }

    /* Contenedor principal: dos columnas */
    .main-layout {
      display: flex;
      gap: 40px;
      align-items: flex-start;
    }

    /* Columna izquierda: solo Quimerito */
    .left-column {
      width: 35%;
      min-width: 300px;
    }

    .logo-img {
      width: 100%;
      height: auto;
      border-radius: 16px;
      object-fit: cover;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .logo-img:hover {
      transform: scale(1.03);
    }

    /* Columna derecha: Tarjetas */
    .right-column {
      flex: 1;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 24px;
    }

    .service-card {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 24px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: all 0.25s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      cursor: pointer;
    }

    .service-card:hover {
      background: rgba(255, 255, 255, 0.18);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }

    .icon {
      font-size: 2.4rem;
      margin-bottom: 12px;
      display: block;
      color: #4a90e2;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .service-card p {
      font-size: 0.95rem;
      font-weight: 600;
      line-height: 1.4;
      color: #004aad;
      margin: 0;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    /* Responsive */
    @media (max-width: 900px) {
      .main-layout {
        flex-direction: column;
        align-items: stretch;
      }
      .left-column {
        width: auto;
        text-align: center;
      }
      .logo-img {
        max-width: 300px;
        margin: 0 auto;
      }
      .title-bar h1 {
        font-size: 2.4rem;
      }
      .back-button {
        top: 20px;
        right: 20px;
        padding: 6px 12px;
        font-size: 0.8rem;
      }
    }

    @media (max-width: 600px) {
      .services-grid {
        grid-template-columns: 1fr;
      }
      .title-bar h1 {
        font-size: 2rem;
      }
      .logo-img {
        max-width: 250px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Título en barra azul arriba -->
    <div class="title-bar">
      <h1>¿Cómo te podemos ayudar?</h1>
      <!-- Botón Volver -->
      <a href="{{ route('home') }}" class="back-button">← Regresar</a>
    </div>

    <!-- Contenido: Quimerito + Tarjetas -->
    <div class="main-layout">
      <!-- Columna izquierda: Quimerito -->
      <div class="left-column">
        <img src="{{ asset('img/mascotainicio.png') }}" alt="Quimerito, tu amigo de apoyo" class="logo-img">
      </div>

      <!-- Columna derecha: Tarjetas -->
      <div class="right-column">
        <div class="services-grid">
          <div class="service-card"><span class="icon">✅</span><p>Canal de reporte seguro</p></div>
          <div class="service-card"><span class="icon">💬</span><p>Chat de apoyo psicológico</p></div>
          <div class="service-card"><span class="icon">📋</span><p>Test de autoevaluación</p></div>
          <div class="service-card"><span class="icon">📚</span><p>Información y recursos</p></div>
          <div class="service-card"><span class="icon">📍</span><p>Derivación de apoyo</p></div>
          <div class="service-card"><span class="icon">💙</span><p>Mensajes motivacionales</p></div>
          <div class="service-card"><span class="icon">🗨</span><p>Historias anónimas</p></div>
          <div class="service-card"><span class="icon">🔔</span><p>Notificaciones web</p></div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>