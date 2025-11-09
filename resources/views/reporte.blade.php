<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte Confidencial - Univida</title>
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

    /* Header */
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

    /* Main layout */
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

    select, textarea, input[type="date"] {
      width: 100%;
      padding: 14px;
      border: 1px solid #ccc;
      border-radius: 14px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s;
    }

    select:focus, textarea:focus, input[type="date"]:focus {
      border-color: #004aad;
    }

    textarea {
      height: 120px;
      resize: none;
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
    <a href="{{ route('inicio.usuario') }}">Regresar</a>
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
        <h2 id="titulo-formulario">Tu información es confidencial 💙</h2>
        @if(session('success'))
          <div style="background:#e8f5e9;padding:12px;border-radius:10px;margin-bottom:12px;color:#2e7d32;border:1px solid #c8e6c9;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div style="background:#ffebee;padding:12px;border-radius:10px;margin-bottom:12px;color:#c62828;border:1px solid #ffcdd2;">
            <ul style="margin:0;padding-left:18px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form action="{{ route('reporte.store') }}" method="post">
          @csrf
          <label for="violencia">Tipo de violencia</label>
          <select id="violencia" name="fk_tipo_violencia" required>
            <option value="">Selecciona un tipo</option>
            @foreach($tiposViolencia ?? [] as $tipo)
              <option value="{{ $tipo->id_tipo_violencia ?? $tipo->id }}">{{ $tipo->nombre ?? $tipo->tipo }}</option>
            @endforeach
          </select>

          <label for="descripcion">Descripción del caso</label>
          <textarea id="descripcion" name="descripcion" placeholder="Escribe aquí tu reporte..." required></textarea>

          <label for="fecha">Fecha</label>
          <input type="date" id="fecha" name="fecha" required>

          <div class="checkbox-container">
            <input type="checkbox" id="anonimo" name="anonimo" value="1">
            <label for="anonimo">Reporte anónimo</label>
          </div>

          <button type="submit">Enviar Reporte</button>
        </form>
      </section>
    </article>
  </main>
</body>
</html>