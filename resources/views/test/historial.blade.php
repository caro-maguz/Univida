<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Tests - Univida</title>
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
      padding: 2rem;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding: 2rem 3rem;
    }

    h1 {
      color: #004aad;
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2rem;
    }

    .volver {
      display: inline-block;
      margin-bottom: 1rem;
      color: #004aad;
      text-decoration: none;
      font-weight: 600;
    }

    .volver:hover {
      text-decoration: underline;
    }

    .test-card {
      background: #f9f9f9;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .test-info h3 {
      color: #004aad;
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
    }

    .test-fecha {
      color: #666;
      font-size: 0.95rem;
    }

    .badge {
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-weight: bold;
      font-size: 0.95rem;
    }

    .badge.alto { background: #ffebee; color: #d32f2f; }
    .badge.moderado { background: #fff3e0; color: #f57c00; }
    .badge.bajo { background: #e3f2fd; color: #1976d2; }
    .badge.sin-riesgo { background: #e8f5e9; color: #388e3c; }

    .empty {
      text-align: center;
      padding: 3rem;
      color: #999;
    }

    .empty-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .btn {
      background: #004aad;
      color: #fff;
      padding: 1rem 2rem;
      border-radius: 12px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      margin-top: 1rem;
      transition: 0.3s;
    }

    .btn:hover {
      background: #ffc107;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="{{ route('dashboard.user') }}" class="volver">← Volver al inicio</a>
    
    <h1>📊 Historial de Tests</h1>

    @if($tests->isEmpty())
      <div class="empty">
        <div class="empty-icon">📋</div>
        <p>Aún no has realizado ningún test.</p>
        <a href="{{ route('test.mostrar') }}" class="btn">Realizar Test Ahora</a>
      </div>
    @else
      @foreach($tests as $test)
        <div class="test-card">
          <div class="test-info">
            <h3>Test de Evaluación Emocional</h3>
            <p class="test-fecha">
              📅 Realizado el: {{ \Carbon\Carbon::parse($test->fecha)->format('d/m/Y H:i') }}
            </p>
          </div>
          <div>
            @php
              $clasesBadge = [
                'Riesgo Alto' => 'alto',
                'Riesgo Moderado' => 'moderado',
                'Bajo Riesgo' => 'bajo',
                'Sin Riesgo Aparente' => 'sin-riesgo',
              ];
              $clase = $clasesBadge[$test->resultado] ?? 'bajo';
            @endphp
            <span class="badge {{ $clase }}">{{ $test->resultado }}</span>
          </div>
        </div>
      @endforeach

      <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('test.mostrar') }}" class="btn">🔄 Realizar Nuevo Test</a>
      </div>
    @endif
  </div>
</body>
</html>
