<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Protocolos y Contactos</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    *{
      font-family: 'Delius', cursive;
    }
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      min-height: 100vh;
      color: #333;
    }

    header {
      display: flex;
      justify-content: flex-end;
      padding: 1rem 2rem;
      border-bottom: 3px solid #0077cc;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(4px);
    }

    /* Botón Regresar al Inicio con borde azul */
    header a {
      background: transparent;
      border: 2px solid #0077cc;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      text-decoration: none;
      color: #0077cc;
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    header a:hover {
      background: #0077cc;
      color: #fff;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 70px);
      padding: 2rem;
    }

    .card {
      display: flex;
      align-items: center;
      gap: 2rem;
      background: #fff;
      padding: 2rem 3rem;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      max-width: 900px;
      width: 100%;
    }

    .mascotainicio img, 
    .contenido h1 img {
      border: none;
      outline: none;
      max-width: 100%;
      height: auto;
    }

    .mascotainicio img {
      max-width: 300px;
    }

    .contenido {
      flex: 1;
    }

    .contenido h1 {
      font-size: 1.8rem;
      color: #004aad;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0 0 1rem;
    }

    .contenido h1 img {
      height: 40px;
    }

    .contenido p {
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }

    .contenido ul {
      margin: 1rem 0;
      padding-left: 1.2rem;
      font-size: 1rem;
    }

    .contenido li {
      margin-bottom: 0.6rem;
    }

    .btn {
      display: inline-block;
      background-color: #ffc107;
      color: #000;
      padding: 0.9rem 1.8rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #e0a800;
    }

    @media (max-width: 768px) {
      .card {
        flex-direction: column;
        text-align: center;
      }
      .contenido h1 {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="{{ route('inicio.usuario') }}">Regresar</a>
  </header>

  <main>
    <article class="card">
      <!-- Imagen del búho -->
      <div class="mascotainicio">
        <img src="img/img1.png" alt="mascotainicio Univida">
      </div>

      <!-- Contenido de texto -->
      <section class="contenido">
        <h1>
          <img src="img/Logo.png" alt="Logo Univida"> Univida
        </h1>
        <p>Aquí encuentras teléfonos y protocolos de apoyo.</p>
        <ul>
          <li>Protocolos (PDF)</li>
          <li>Teléfonos de emergencia</li>
          <li>Contacto rápido</li>
        </ul>
        <a href="recursos.php" class="btn">Descargar Recursos</a>
      </section>
    </article>
  </main>

</body>
</html>