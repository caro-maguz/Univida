<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enviar Historia Anónima - Univida</title>
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

    label {
      display: block;
      margin: 1rem 0 0.5rem;
      font-weight: 600;
    }

    textarea {
      width: 100%;
      padding: 14px;
      border: 1px solid #ccc;
      border-radius: 14px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s;
      height: 120px;
      resize: none;
    }

    textarea:focus {
      border-color: #004aad;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 1.2rem 0;
    }

    .checkbox-container input {
      transform: scale(1.2);
      cursor: pointer;
    }

    .checkbox-container label {
      cursor: pointer;
      font-weight: normal;
    }

    button {
      background: #004aad;
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      padding: 14px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
      margin-top: 1rem;
    }

    button:hover {
      background: #ffd54f;
      color: #222;
    }

    /* Mensaje de éxito */
    .success-message {
      display: none;
      background: #d4edda;
      color: #155724;
      padding: 1rem;
      border-radius: 16px;
      text-align: center;
      margin-top: 1rem;
      font-weight: 600;
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
        <h2 id="titulo-formulario">Enviar Historia Anónima</h2>
        <p>Escribe tu historia aquí. Tu identidad será protegida.</p>

        <form action="#" method="post" onsubmit="event.preventDefault(); mostrarExito();">
          <label for="historia">Tu historia</label>
          <textarea id="historia" name="historia" placeholder="Escribe aquí tu historia..." required></textarea>

          <div class="checkbox-container">
            <input type="checkbox" id="anonimo" name="anonimo" checked>
            <label for="anonimo">Enviar de forma anónima</label>
          </div>

          <button type="submit">Enviar Historia</button>
        </form>

        <!-- Mensaje de éxito -->
        <div id="successMessage" class="success-message">
          Mensaje anónimo enviado exitosamente 💙
        </div>
      </section>
    </article>
  </main>

  <script>
    function mostrarExito() {
      document.getElementById("successMessage").style.display = "block";
      // Opcional: redirigir después de 2 segundos
      setTimeout(() => {
        window.location.href = "{{ route('historias') }}";
      }, 2000);
    }
  </script>
</body>
</html>