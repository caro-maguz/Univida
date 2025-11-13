<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test de Evaluación - Univida</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
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
      max-width: 900px;
      margin: 0 auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding: 2rem 3rem;
    }

    h1 {
      color: #004aad;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .intro {
      background: #f0f7ff;
      border-left: 4px solid #004aad;
      padding: 1rem 1.5rem;
      margin-bottom: 2rem;
      border-radius: 8px;
    }

    .intro p {
      color: #333;
      line-height: 1.6;
      margin-bottom: 0.5rem;
    }

    .pregunta {
      background: #fafafa;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .pregunta h3 {
      color: #004aad;
      margin-bottom: 1rem;
      font-size: 1.1rem;
    }

    .opciones {
      display: flex;
      gap: 0.8rem;
      flex-wrap: wrap;
    }

    .opcion {
      flex: 1;
      min-width: 80px;
      text-align: center;
    }

    .opcion input[type="radio"] {
      display: none;
    }

    .opcion label {
      display: block;
      padding: 0.8rem;
      border: 2px solid #ddd;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s;
      background: #fff;
      font-weight: 600;
      color: #555;
    }

    .opcion input[type="radio"]:checked + label {
      background: #004aad;
      color: #fff;
      border-color: #004aad;
    }

    .opcion label:hover {
      border-color: #004aad;
      background: #f0f7ff;
    }

    .escala-info {
      display: flex;
      justify-content: space-between;
      margin: 1rem 0;
      font-size: 0.9rem;
      color: #666;
    }

    .btn-enviar {
      background: #004aad;
      color: #fff;
      border: none;
      padding: 1rem 2rem;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 1rem;
      transition: 0.3s;
    }

    .btn-enviar:hover {
      background: #ffc107;
      color: #000;
    }

    .btn-enviar:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .alert {
      background: #fff3cd;
      border: 1px solid #ffc107;
      color: #856404;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1rem;
      text-align: center;
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

    .progress-bar {
      height: 8px;
      background: #e0e0e0;
      border-radius: 10px;
      margin-bottom: 2rem;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: #004aad;
      width: 0%;
      transition: width 0.3s;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="<?php echo e(route('inicio.usuario')); ?>" class="volver">← Volver al inicio</a>
    
    <h1>🧠 Test de Evaluación Emocional</h1>
    
    <div class="intro">
      <p><strong>📌 Objetivo:</strong> Este test evalúa diferentes tipos de violencia (psicológica, emocional, física, sexual y económica) para identificar señales de alerta en tu bienestar.</p>
      <p><strong>📝 Instrucciones:</strong> Son 20 preguntas breves sobre diferentes tipos de violencia. Lee cuidadosamente cada una y responde con <strong>Sí</strong> o <strong>No</strong> según tu experiencia.</p>
      <p><strong>📊 Cómo responder:</strong></p>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1rem 0;">
        <div style="background: #ffebee; padding: 1rem; border-radius: 10px; border: 2px solid #ef5350;">
          <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">❌</div>
          <strong>Responde SÍ</strong><br>
          <small>Si has experimentado esto</small>
        </div>
        <div style="background: #e8f5e9; padding: 1rem; border-radius: 10px; border: 2px solid #66bb6a;">
          <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">✅</div>
          <strong>Responde NO</strong><br>
          <small>Si no lo has experimentado</small>
        </div>
      </div>
      <p style="color: #d32f2f; font-weight: bold; margin-top: 1rem;">🔒 Este test es completamente confidencial. Tus respuestas nos ayudarán a brindarte el apoyo adecuado.</p>
      <p style="color: #666; font-size: 0.95rem;">⏱️ Tiempo estimado: 3-5 minutos</p>
    </div>

    <?php if($errors->any()): ?>
      <div class="alert">
        <?php echo e($errors->first()); ?>

      </div>
    <?php endif; ?>

    <div class="progress-bar">
      <div class="progress-fill" id="progressBar"></div>
    </div>

    <form action="<?php echo e(route('test.procesar')); ?>" method="POST" id="testForm">
      <?php echo csrf_field(); ?>
      
      <?php
        $categoriaActual = null;
        $categoriaColors = [
          'Psicológica' => '#e1bee7',
          'Emocional' => '#ffccbc',
          'Física' => '#ffcdd2',
          'Sexual' => '#f8bbd0',
          'Económica' => '#c5cae9',
          'General' => '#b2dfdb'
        ];
        $categoriaIcons = [
          'Psicológica' => '🧩',
          'Emocional' => '💔',
          'Física' => '🚨',
          'Sexual' => '⚠️',
          'Económica' => '💰',
          'General' => '🧠'
        ];
      ?>
      
      <?php $__currentLoopData = $preguntas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($pregunta->categoria !== $categoriaActual): ?>
          <?php $categoriaActual = $pregunta->categoria; ?>
          <div style="background: <?php echo e($categoriaColors[$categoriaActual] ?? '#e0e0e0'); ?>; padding: 0.8rem 1rem; border-radius: 10px; margin: 1.5rem 0 1rem 0; font-weight: bold; color: #333; font-size: 1.05rem;">
            <?php echo e($categoriaIcons[$categoriaActual] ?? '📋'); ?> 
            <?php if($categoriaActual === 'General'): ?>
              Bienestar General
            <?php else: ?>
              Violencia <?php echo e($categoriaActual); ?>

            <?php endif; ?>
          </div>
        <?php endif; ?>
        
        <div class="pregunta">
          <h3><?php echo e($index + 1); ?>. <?php echo e($pregunta->enunciado); ?></h3>
          
          <div class="opciones">
            <div class="opcion" style="flex: 1;">
              <input type="radio" 
                     name="respuestas[<?php echo e($pregunta->id_pregunta); ?>]" 
                     value="si" 
                     id="p<?php echo e($pregunta->id_pregunta); ?>_si"
                     onchange="actualizarProgreso()">
              <label for="p<?php echo e($pregunta->id_pregunta); ?>_si" style="font-size: 1.1rem;">
                <strong>SÍ</strong>
              </label>
            </div>
            <div class="opcion" style="flex: 1;">
              <input type="radio" 
                     name="respuestas[<?php echo e($pregunta->id_pregunta); ?>]" 
                     value="no" 
                     id="p<?php echo e($pregunta->id_pregunta); ?>_no"
                     onchange="actualizarProgreso()">
              <label for="p<?php echo e($pregunta->id_pregunta); ?>_no" style="font-size: 1.1rem;">
                <strong>NO</strong>
              </label>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <button type="submit" class="btn-enviar" id="btnEnviar" disabled>
        Enviar Respuestas y Ver Resultados
      </button>
    </form>
  </div>

  <script>
    const totalPreguntas = <?php echo e(count($preguntas)); ?>;
    
    function actualizarProgreso() {
      const respondidas = document.querySelectorAll('input[type="radio"]:checked').length;
      const progreso = (respondidas / totalPreguntas) * 100;
      document.getElementById('progressBar').style.width = progreso + '%';
      
      // Habilitar botón solo si todas están respondidas
      document.getElementById('btnEnviar').disabled = respondidas < totalPreguntas;
    }

    // Confirmación antes de enviar
    document.getElementById('testForm').addEventListener('submit', function(e) {
      if (!confirm('¿Estás seguro/a de enviar tus respuestas? Una vez enviadas, no podrás modificarlas.')) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/test/realizar.blade.php ENDPATH**/ ?>