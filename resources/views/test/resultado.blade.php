<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultado del Test - Univida</title>
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
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .container {
      max-width: 700px;
      width: 100%;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding: 3rem;
      text-align: center;
    }

    .icon {
      font-size: 4rem;
      margin-bottom: 1rem;
    }

    h1 {
      color: #004aad;
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .resultado-box {
      padding: 2rem;
      border-radius: 12px;
      margin: 2rem 0;
    }

    .resultado-box.danger {
      background: #ffebee;
      border: 2px solid #d32f2f;
    }

    .resultado-box.warning {
      background: #fff3e0;
      border: 2px solid #f57c00;
    }

    .resultado-box.info {
      background: #e3f2fd;
      border: 2px solid #1976d2;
    }

    .resultado-box.success {
      background: #e8f5e9;
      border: 2px solid #388e3c;
    }

    .resultado-box h2 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }

    .resultado-box.danger h2 { color: #d32f2f; }
    .resultado-box.warning h2 { color: #f57c00; }
    .resultado-box.info h2 { color: #1976d2; }
    .resultado-box.success h2 { color: #388e3c; }

    .mensaje {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #333;
      margin-bottom: 1rem;
    }

    .puntuacion {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin: 1.5rem 0;
      flex-wrap: wrap;
    }

    .stat {
      background: #f5f5f5;
      padding: 1rem 1.5rem;
      border-radius: 10px;
    }

    .stat-label {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 0.3rem;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: bold;
      color: #004aad;
    }

    .recomendaciones {
      background: #f0f7ff;
      border-left: 4px solid #004aad;
      padding: 1.5rem;
      text-align: left;
      border-radius: 8px;
      margin-top: 2rem;
    }

    .recomendaciones h3 {
      color: #004aad;
      margin-bottom: 1rem;
    }

    .recomendaciones ul {
      margin-left: 1.5rem;
      line-height: 1.8;
    }

    .acciones {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    .btn {
      padding: 1rem 2rem;
      border-radius: 12px;
      text-decoration: none;
      font-weight: bold;
      font-size: 1rem;
      transition: 0.3s;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: #004aad;
      color: #fff;
    }

    .btn-primary:hover {
      background: #003b89;
    }

    .btn-secondary {
      background: #ffc107;
      color: #000;
    }

    .btn-secondary:hover {
      background: #e0a800;
    }

    .btn-outline {
      background: transparent;
      border: 2px solid #004aad;
      color: #004aad;
    }

    .btn-outline:hover {
      background: #004aad;
      color: #fff;
    }

    .nota-privacidad {
      margin-top: 2rem;
      font-size: 0.9rem;
      color: #666;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="icon">
      @if($color === 'danger')
        ⚠️
      @elseif($color === 'warning')
        🟡
      @elseif($color === 'info')
        ℹ️
      @else
        ✅
      @endif
    </div>

    <h1>Resultados de tu Evaluación</h1>

    <div class="resultado-box {{ $color }}">
      <h2>{{ $resultado }}</h2>
      <p class="mensaje">{{ $mensaje }}</p>
    </div>

    <div class="puntuacion">
      <div class="stat">
        <div class="stat-label">Respuestas "Sí"</div>
        <div class="stat-value">{{ $respuestasSi }}/{{ $totalPreguntas }}</div>
      </div>
      <div class="stat">
        <div class="stat-label">Porcentaje de Alerta</div>
        <div class="stat-value">{{ $porcentajeAlerta }}%</div>
      </div>
    </div>

    <div class="recomendaciones">
      <h3>📋 Recomendaciones personalizadas:</h3>
      <ul>
        @foreach($recomendaciones as $recomendacion)
          <li>{{ $recomendacion }}</li>
        @endforeach
      </ul>
    </div>

    <div class="acciones">
      <a href="{{ route('chat') }}" class="btn btn-primary">💬 Chat de Apoyo</a>
      <a href="{{ route('resources') }}" class="btn btn-secondary">📚 Ver Recursos</a>
      <a href="{{ route('inicio.usuario') }}" class="btn btn-outline">⬅ Volver al Inicio</a>
    </div>

    <p class="nota-privacidad">
      🔒 Tus respuestas son confidenciales y están protegidas. Nadie tiene acceso a tus resultados personales.
    </p>
  </div>
</body>
</html>
