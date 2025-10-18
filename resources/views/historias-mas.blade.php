<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historias Anónimas - Univida</title>
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    *{
      font-family: 'Delius', cursive;
    }
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #fff9f0);
      margin: 0;
      padding: 0;
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
      border-bottom: 2px solid #004aad20;
    }

    header a {
      border: 2px solid #004aad;
      color: #004aad;
      text-decoration: none;
      padding: 0.6rem 1.4rem;
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

    .container {
      display: flex;
      align-items: center;
      gap: 2rem;
      max-width: 1100px;
      width: 100%;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Sección formulario */
    .form-section {
      flex: 1;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 6px 30px rgba(0,0,0,0.1);
      padding: 2rem;
      min-width: 320px;
    }

    h2 {
      color: #004aad;
      margin-bottom: 1.2rem;
      font-size: 1.6rem;
      text-align: center;
    }

    p {
      color: #444;
      margin-bottom: 1.5rem;
      line-height: 1.5;
    }

    .history-list {
      margin: 1.5rem 0;
      padding: 1rem;
      background: #f1f6fb;
      border-radius: 16px;
      font-size: 1rem;
      line-height: 1.6;
    }

    .buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      margin-top: 1.5rem;
    }

    .btn {
      background: #004aad;
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      padding: 14px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      transition: 0.3s;
      width: 100%;
    }

    .btn:hover {
      background: #ffd54f;
      color: #222;
    }

    /* Mascota */
    .image-section {
      flex: 0.8;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    .image-section img {
      max-width: 280px;
      height: auto;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        text-align: center;
      }
      .form-section {
        order: 2;
      }
      .image-section {
        order: 1;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <a href="{{ route('historias') }}">Regresar a Historias</a>
  </header>

  <!-- Main -->
  <main>
    <article class="container">
      <!-- Mascota -->
      <section class="image-section" aria-hidden="true">
        <img src="{{ asset('img/mascotainicio.png') }}" alt="Mascota Univida animada">
      </section>

      <!-- Formulario -->
      <section class="form-section" aria-labelledby="titulo-formulario">
        <h2 id="titulo-formulario">Historias Anónimas</h2>
        <p>Estas son historias reales que nos ayudan a entender y prevenir.</p>

        <div class="history-list">
          <p><strong>Historia 1:</strong> Texto de la historia 1</p>
          <p><strong>Historia 2:</strong> Texto de la historia 2</p>
          <p><strong>Historia 3:</strong> Texto de la historia 3</p>
          <p><strong>Historia 4:</strong> Texto de la historia 4</p>
        </div>

      </section>
    </article>
  </main>
</body>
</html>