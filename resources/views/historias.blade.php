<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historias Anónimas - Univida</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
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
      text-decoration: none; /* Agregado para quitar subrayado de los enlaces */
      display: flex;
      justify-content: center;
      align-items: center;
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
    <a href="{{ route('inicio.usuario') }}">Regresar</a>
  </header>

  <!-- Main -->
  <main>
    <article class="container">
      <!-- Mascota -->
      <section class="image-section" aria-hidden="true">
        <img src="{{ asset('img/img3.png') }}" alt="Mascota Univida animada">
      </section>

      <!-- Formulario -->
      <section class="form-section" aria-labelledby="titulo-formulario">
        <h2 id="titulo-formulario">Historias Anónimas</h2>
        <p>Estas son historias reales que nos ayudan a entender y prevenir.</p>

        @if(session('success'))
          <div style="background:#e6ffed;border:1px solid #b7f2c7;padding:10px;border-radius:8px;margin-bottom:12px;color:#064e1b;">
            {{ session('success') }}
          </div>
        @endif

        <div class="history-list">
          @if(isset($historias) && $historias->count() > 0)
            @foreach($historias->take(3) as $h)
              <div style="margin-bottom:8px;padding-bottom:8px;border-bottom:1px dashed #e6eef8;">
                <p style="margin:0;"><small style="color:#54718a">{{ $h->created_at ? $h->created_at->format('d/m/Y') : '' }}</small></p>
                <p style="margin:6px 0 0;">{!! nl2br(e(\Illuminate\Support\Str::limit($h->contenido, 350))) !!}</p>
              </div>
            @endforeach
          @else
            <p>No hay historias por mostrar.</p>
          @endif
        </div>

        <div class="buttons">
          <a href="{{ route('historias.enviar') }}" class="btn">Enviar Historia</a>
          <a href="{{ route('historias.mas') }}" class="btn">Ver más Historias</a>
        </div>
      </section>
    </article>
  </main>
</body>
</html>