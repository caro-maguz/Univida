<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $__env->yieldContent('title', 'Univida'); ?></title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    * { font-family: 'Delius', cursive; }
    body { background: #f7fbff; }
    header.navbar { background: rgba(255,255,255,.9); border-bottom: 1px solid #eaf2fb; }
  </style>
</head>
<body>
  <header class="navbar navbar-expand-lg sticky-top">
    <div class="container py-2">
      <a class="navbar-brand text-primary fw-bold" href="<?php echo e(route('home')); ?>">Univida</a>
      <div class="ms-auto d-flex gap-2">
        <?php if(session('rol') === 'usuario'): ?>
          <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('inicio.usuario')); ?>">Panel Usuario</a>
        <?php elseif(session('rol') === 'psicologo'): ?>
          <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('dashboard.psychologist')); ?>">Panel Psicólogo</a>
        <?php elseif(session('rol') === 'admin'): ?>
          <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('administrador.dashboard')); ?>">Panel Admin</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="py-4">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/layouts/app.blade.php ENDPATH**/ ?>