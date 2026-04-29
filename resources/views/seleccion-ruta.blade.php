<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Menú Principal</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Delius', cursive; }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      background-size: 200% 200%;
      animation: gradMove 8s ease infinite;
    }

    @keyframes gradMove {
      0%   { background-position: 0% 50%; }
      50%  { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .uv-wrap {
      width: 100%;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .uv-title {
      font-size: 1.6rem;
      color: #004aad;
      margin-bottom: 1.8rem;
      font-weight: 700;
      text-align: center;
    }

    /* ── Carrusel ── */
    .uv-carousel {
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 640px;
      gap: .5rem;
    }

    .uv-arrow {
      width: 38px;
      height: 38px;
      min-width: 38px;
      border-radius: 50%;
      border: 2px solid #004aad;
      background: #fff;
      color: #004aad;
      cursor: pointer;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      z-index: 10;
      transition: background 0.2s, color 0.2s;
      box-shadow: 0 2px 8px rgba(0,74,173,0.15);
    }

    .uv-arrow:hover { background: #004aad; color: white; }

    .uv-cards-window {
      flex: 1;
      position: relative;
      height: 380px;
      overflow: visible;
    }

    /* ── Tarjetas ── */
    .uv-card {
      position: absolute;
      width: 74%;
      height: 100%;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,.15);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      top: 0;
      transition: transform 0.45s cubic-bezier(.4,0,.2,1), filter 0.45s ease, opacity 0.45s ease;
    }

    .uv-card[data-pos="center"] {
      left: 50%;
      transform: translateX(-50%) scale(1);
      filter: none;
      opacity: 1;
      z-index: 5;
    }

    .uv-card[data-pos="left"] {
      left: 50%;
      transform: translateX(calc(-50% - 58%)) scale(0.82);
      filter: blur(3px) brightness(0.85);
      opacity: 0.7;
      z-index: 2;
    }

    .uv-card[data-pos="right"] {
      left: 50%;
      transform: translateX(calc(-50% + 58%)) scale(0.82);
      filter: blur(3px) brightness(0.85);
      opacity: 0.7;
      z-index: 2;
    }

    .uv-card[data-pos="hidden-left"] {
      left: 50%;
      transform: translateX(calc(-50% - 110%)) scale(0.7);
      filter: blur(6px);
      opacity: 0;
      z-index: 1;
      pointer-events: none;
    }

    .uv-card[data-pos="hidden-right"] {
      left: 50%;
      transform: translateX(calc(-50% + 110%)) scale(0.7);
      filter: blur(6px);
      opacity: 0;
      z-index: 1;
      pointer-events: none;
    }

    /* ── Imagen superior ── */
    .uv-img-area {
      width: 100%;
      height: 180px;
      overflow: hidden;
      flex-shrink: 0;
    }

    .uv-img-area img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: 16px 16px 0 0;
    }

    /* ── Cuerpo ── */
    .uv-card-body {
      padding: 1rem;
      text-align: center;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .uv-card-body h3 {
      color: #004aad;
      font-size: .95rem;
      margin-bottom: .5rem;
    }

    .uv-card-body p {
      font-size: .8rem;
      color: #555;
      margin-bottom: .9rem;
      line-height: 1.4;
    }

    .uv-badge {
      font-size: .7rem;
      padding: 3px 10px;
      border-radius: 14px;
      margin-bottom: .5rem;
      display: inline-block;
    }

    .uv-badge-ok  { background: #e8f5e9; color: #2e7d32; }
    .uv-badge-off { background: #fff3e0; color: #e65100; }

    .uv-btn {
      padding: 8px 22px;
      border-radius: 10px;
      border: none;
      font-family: 'Delius', cursive;
      font-size: .8rem;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: background 0.2s;
    }

    .uv-btn-active          { background: #004aad; color: white; }
    .uv-btn-active:hover    { background: #003580; }
    .uv-btn-disabled        { background: #ccc; color: #777; cursor: not-allowed; }

    /* ── Dots ── */
    .uv-dots { display: flex; gap: 8px; margin-top: 1.2rem; }

    .uv-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: none;
      background: #90caf9;
      cursor: pointer;
      padding: 0;
      transition: background 0.2s, transform 0.2s;
    }

    .uv-dot.active { background: #004aad; transform: scale(1.3); }

    /* ════════════════════════════
       RESPONSIVE — Tablet ≤768px
    ════════════════════════════ */
    @media (max-width: 768px) {
      .uv-title { font-size: 1.3rem; margin-bottom: 1.4rem; }
      .uv-carousel { max-width: 100%; }
      .uv-arrow { width: 32px; height: 32px; min-width: 32px; font-size: .95rem; }
      .uv-cards-window { height: 340px; }
      .uv-card { width: 78%; }
      .uv-img-area { height: 150px; }
      .uv-card-body h3 { font-size: .9rem; }
      .uv-card-body p  { font-size: .76rem; }
    }

    /* ════════════════════════════
       RESPONSIVE — Móvil ≤480px
    ════════════════════════════ */
    @media (max-width: 480px) {
      .uv-title { font-size: 1.1rem; margin-bottom: 1rem; }
      .uv-arrow { width: 28px; height: 28px; min-width: 28px; font-size: .85rem; border-width: 1.5px; }
      .uv-cards-window { height: 310px; }
      .uv-card { width: 82%; border-radius: 12px; }
      .uv-card[data-pos="left"]  { transform: translateX(calc(-50% - 62%)) scale(0.8); }
      .uv-card[data-pos="right"] { transform: translateX(calc(-50% + 62%)) scale(0.8); }
      .uv-img-area { height: 130px; }
      .uv-card-body { padding: 0.8rem 1rem; }
      .uv-card-body h3 { font-size: .85rem; }
      .uv-card-body p  { font-size: .73rem; margin-bottom: .6rem; }
      .uv-btn { padding: 7px 16px; font-size: .76rem; }
      .uv-badge { font-size: .65rem; padding: 2px 8px; }
      .uv-dot { width: 8px; height: 8px; }
    }

    /* ════════════════════════════
       RESPONSIVE — Móvil ≤360px
    ════════════════════════════ */
    @media (max-width: 360px) {
      .uv-cards-window { height: 290px; }
      .uv-card { width: 86%; }
      .uv-img-area { height: 115px; }
      .uv-card-body h3 { font-size: .8rem; }
      .uv-card-body p  { font-size: .7rem; }
    }
  </style>
</head>

<body>
<div class="uv-wrap">

  <div class="uv-title">Selecciona una ruta</div>

  <div class="uv-carousel">
    <button class="uv-arrow" onclick="move(-1)">&#8592;</button>

    <div class="uv-cards-window" id="window">

      <!-- TARJETA 1 -->
      <div class="uv-card" data-idx="0">
        <div class="uv-img-area">
          <img src="{{ asset('img/imgRutaViolencia.jpeg') }}" alt="Ruta violencia de género">
        </div>
        <div class="uv-card-body">
          <span class="uv-badge uv-badge-ok">Disponible</span>
          <h3>Ruta de Atenci&oacute;n en Casos de Violencias Basadas en G&eacute;nero</h3>
          <p>Atenci&oacute;n a situaciones de violencia basadas en g&eacute;nero en el entorno universitario.</p>
          <a href="{{ route('dashboard.user') }}" class="uv-btn uv-btn-active">Ingresar &rarr;</a>
        </div>
      </div>

      <!-- TARJETA 2 -->
      <div class="uv-card" data-idx="1">
        <div class="uv-img-area">
          <img src="{{ asset('img/imgFuturasRutas.jpeg') }}" alt="Gestión de solicitudes">
        </div>
        <div class="uv-card-body">
          <span class="uv-badge uv-badge-off">Fuera de servicio</span>
          <h3>Ruta de Permanencia Estudiantil</h3>
          <p>La Ruta de Permanencia Estudiantil está dirigida a la identificación temprana de estudiantes con dificultades académicas, individuales, socioeconómicas o institucionales.</p>
          <button class="uv-btn uv-btn-disabled" disabled>Pr&oacute;ximamente</button>
        </div>
      </div>

      <!-- TARJETA 3 -->
      <div class="uv-card" data-idx="2">
        <div class="uv-img-area">
          <img src="{{ asset('img/imgFuturasRutas.jpeg') }}" alt="Reportes y estadísticas">
        </div>
        <div class="uv-card-body">
          <span class="uv-badge uv-badge-off">Fuera de servicio</span>
          <h3>Ruta de Atención para Estudiantes con Dificultades de Aprendizaje y Discapacidad</h3>
          <p>Esta ruta permite identificar y atender a estudiantes con dificultades de aprendizaje o discapacidad, ya sea durante la matrícula, las caracterizaciones iniciales o a partir de reportes docentes.</p>
          <button class="uv-btn uv-btn-disabled" disabled>Pr&oacute;ximamente</button>
        </div>
      </div>

      <!-- TARJETA 4 -->
      <div class="uv-card" data-idx="2">
        <div class="uv-img-area">
          <img src="{{ asset('img/imgFuturasRutas.jpeg') }}" alt="Reportes y estadísticas">
        </div>
        <div class="uv-card-body">
          <span class="uv-badge uv-badge-off">Fuera de servicio</span>
          <h3>Ruta de Salud Mental</h3>
          <p>La Ruta de Salud Mental orienta la identificación de signos y síntomas emocionales, cognitivos o comportamentales que puedan afectar el bienestar de la comunidad universitaria. </p>
          <button class="uv-btn uv-btn-disabled" disabled>Pr&oacute;ximamente</button>
        </div>
      </div>

      <!-- TARJETA 5 -->
      <div class="uv-card" data-idx="2">
        <div class="uv-img-area">
          <img src="{{ asset('img/imgFuturasRutas.jpeg') }}" alt="Reportes y estadísticas">
        </div>
        <div class="uv-card-body">
          <span class="uv-badge uv-badge-off">Fuera de servicio</span>
          <h3>Ruta de Atención por Actos de Racismo o Discriminación</h3>
          <p>Esta ruta establece el procedimiento para la atención de actos de racismo o discriminación, permitiendo el reporte por parte de la persona afectada o de quien tenga conocimiento del hecho.</p>
          <button class="uv-btn uv-btn-disabled" disabled>Pr&oacute;ximamente</button>
        </div>
      </div>




    </div>

    <button class="uv-arrow" onclick="move(1)">&#8594;</button>
  </div>

  <div class="uv-dots" id="dots"></div>
</div>

<script>
  var cards   = Array.from(document.querySelectorAll('.uv-card'));
  var total   = cards.length;
  var current = 0;
  var dotsEl  = document.getElementById('dots');

  cards.forEach(function(_, i) {
    var d = document.createElement('button');
    d.className = 'uv-dot' + (i === 0 ? ' active' : '');
    d.onclick   = function() { goTo(i); };
    dotsEl.appendChild(d);
  });

  function getPos(idx) {
    var diff = (idx - current + total) % total;
    if (diff === 0)       return 'center';
    if (diff === 1)       return 'right';
    if (diff === total-1) return 'left';
    if (diff === 2)       return 'hidden-right';
    return 'hidden-left';
  }

  function render() {
    cards.forEach(function(c, i) {
      c.setAttribute('data-pos', getPos(i));
    });
    document.querySelectorAll('.uv-dot').forEach(function(d, i) {
      d.className = 'uv-dot' + (i === current ? ' active' : '');
    });
  }

  function goTo(n) { current = (n + total) % total; render(); }
  function move(dir) { goTo(current + dir); }

  render();

  /* ── Swipe táctil para móvil ── */
  var win = document.getElementById('window');
  var touchStartX = 0;

  win.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  win.addEventListener('touchend', function(e) {
    var diff = touchStartX - e.changedTouches[0].screenX;
    if (Math.abs(diff) > 40) { move(diff > 0 ? 1 : -1); }
  }, { passive: true });
</script>
</body>
</html>