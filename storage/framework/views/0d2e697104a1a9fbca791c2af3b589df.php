<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Psicólogo</title>
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
      text-align: center;
      color: #2563eb;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      margin: 0 auto;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background: #2563eb;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #1e40af;
    }
    a {
      display: inline-block;
      margin-top: 10px;
      color: white;
      background: #3b82f6;
      padding: 8px 12px;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <h1>Editar Psicólogo</h1>

  <form action="<?php echo e(route('administrador.update', $administrador->id_psicologo)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <input type="text" name="nombre" value="<?php echo e($administrador->nombre); ?>" required>
    <input type="email" name="correo" value="<?php echo e($administrador->correo); ?>" required>
    <input type="password" name="contrasena" placeholder="Nueva contraseña (opcional)">
    <button type="submit">Actualizar</button>
  </form>

  <!-- Botón volver al inicio -->
  <div style="text-align:center; margin-top:15px;">
    <a href="<?php echo e(route('administrador.dashboard')); ?>">⬅ Volver al inicio</a>
  </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\univida\resources\views/administrador/edit.blade.php ENDPATH**/ ?>