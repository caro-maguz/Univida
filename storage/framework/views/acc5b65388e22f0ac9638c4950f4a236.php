<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administradores</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{
      font-family: 'Delius', cursive;
    }
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f3f4f6;
      padding: 40px;
    }
    h1 {
      color: #2563eb;
      text-align: center;
    }
    .success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #10b981;
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
      animation: fadeOut 6s forwards;
    }
    @keyframes fadeOut {
      0%, 90% { opacity: 1; }
      100% { opacity: 0; display: none; }
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #e5e7eb;
      padding: 12px;
      text-align: center;
    }
    th {
      background: #2563eb;
      color: white;
    }
    a, button {
      background: #2563eb;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      transition: background 0.3s;
    }
    a:hover, button:hover {
      background: #1e40af;
    }
    form {
      display: inline;
    }
    .add {
      display: inline-block;
      margin-bottom: 15px;
      background: #16a34a;
    }
    .add:hover {
      background: #15803d;
    }
  </style>
</head>
<body>
  <h1>Lista de psicólogos</h1>

  <?php if(session('success')): ?>
    <div class="success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <!-- Botón volver al dashboard -->
  <a href="<?php echo e(route('administrador.dashboard')); ?>" class="add" style="background:#3b82f6; margin-right:10px;">
    ⬅ Volver al inicio
  </a>

  <a href="<?php echo e(route('administrador.create')); ?>" class="add">+ Agregar psicólogo</a>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $administradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($admin->id_psicologo); ?></td>
        <td><?php echo e($admin->nombre); ?></td>
        <td><?php echo e($admin->correo); ?></td>
        <td>
          <a href="<?php echo e(route('administrador.edit', $admin->id_psicologo)); ?>">Editar</a>
          <form action="<?php echo e(route('administrador.destroy', $admin->id_psicologo)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit">Eliminar</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/administrador/index.blade.php ENDPATH**/ ?>