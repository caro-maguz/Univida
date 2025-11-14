
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Centro de Recursos</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');

    * {
      font-family: 'Delius', cursive;
    }

    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      min-height: 100vh;
      color: #333;
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



    main {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 2rem;
    }

    .card {
      background: #fff;
      padding: 2rem 3rem;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      max-width: 900px;
      width: 100%;
    }

    .titulo {
      text-align: center;
      color: #004aad;
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
    }

    .subtitulo {
      text-align: center;
      color: #555;
      margin-bottom: 2rem;
    }

    h4 {
      margin-top: 2rem;
      margin-bottom: 0.8rem;
      font-size: 1.2rem;
    }

    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 2rem;
    }

    .list-group-item {
      background: #f9f9f9;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 0.8rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.2s ease;
    }

    .list-group-item:hover {
      background: #eaf3ff;
    }

    .list-group-item h6 {
      margin: 0;
      font-weight: bold;
    }

    .list-group-item p {
      margin: 0.2rem 0 0;
      font-size: 0.9rem;
      color: #666;
    }

    .btn-descargar {
      background-color: #ffc107;
      color: #000;
      padding: 0.5rem 1.2rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
      border: none;
    }

    .btn-descargar:hover {
      background-color: #e0a800;
    }

    @media (max-width: 768px) {
      .card {
        padding: 1.5rem;
      }
      .list-group-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="<?php echo e(route('dashboard.user')); ?>">Regresar</a>
  </header>

  <main>
    <article class="card">
      <h1 class="titulo">Centro de Recursos</h1>
      <p class="subtitulo">Accede fácilmente a protocolos, contactos de emergencia y material educativo actualizado.</p>

      
      <h4 class="text-primary">📘 Protocolos</h4>
      <ul>
        <?php $__empty_1 = true; $__currentLoopData = $protocolos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <li class="list-group-item">
            <div>
              <h6><?php echo e($item->titulo); ?></h6>
              <p><?php echo e($item->descripcion); ?></p>
            </div>
            <a href="<?php echo e(route('recursos.download', $item->id_recurso)); ?>" class="btn-descargar">Descargar</a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <li class="list-group-item text-center text-muted">No hay protocolos disponibles.</li>
        <?php endif; ?>
      </ul>

      
      <h4 class="text-danger">🚨 Contactos de Emergencia</h4>
      <ul>
        <?php $__empty_1 = true; $__currentLoopData = $emergencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <li class="list-group-item">
            <div>
              <h6><?php echo e($item->titulo); ?></h6>
              <p><?php echo e($item->descripcion); ?></p>
            </div>
            <a href="<?php echo e(route('recursos.download', $item->id_recurso)); ?>" class="btn-descargar">Descargar</a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <li class="list-group-item text-center text-muted">No hay contactos de emergencia disponibles.</li>
        <?php endif; ?>
      </ul>

      
      <h4 class="text-success">📗 Material Educativo</h4>
      <ul>
        <?php $__empty_1 = true; $__currentLoopData = $educativos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <li class="list-group-item">
            <div>
              <h6><?php echo e($item->titulo); ?></h6>
              <p><?php echo e($item->descripcion); ?></p>
            </div>
            <a href="<?php echo e(route('recursos.download', $item->id_recurso)); ?>" class="btn-descargar">Descargar</a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <li class="list-group-item text-center text-muted">No hay materiales educativos disponibles.</li>
        <?php endif; ?>
      </ul>
    </article>
  </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/centro-recursos.blade.php ENDPATH**/ ?>