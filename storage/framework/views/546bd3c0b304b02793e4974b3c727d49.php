<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel de Administrador - Univida</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { unividaBlue: '#004aad', unividaYellow: '#f5c518' }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{
      font-family: 'Delius', cursive;
    }
    .section { display: none; }
    .section.active { display: block; animation: fadeIn 0.3s; }
    @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
  </style>
</head>

<body class="bg-gray-100">
  <!-- Sidebar -->
  <div class="fixed top-0 left-0 w-64 h-full bg-unividaBlue text-white">
    <div class="p-5 border-b border-blue-400">
      <h1 class="text-xl font-bold flex items-center gap-2">
        <i class="fas fa-lock text-unividaYellow"></i> Univida
      </h1>
      <p class="text-blue-200 text-sm">Panel de Administrador</p>
    </div>
    <nav class="p-4">
      <button onclick="showSection('dashboard')" class="block w-full text-left p-2 hover:bg-blue-600 rounded-lg">
        <i class="fas fa-home mr-2"></i> Dashboard
      </button>
      <button onclick="showSection('crud')" class="block w-full text-left p-2 hover:bg-blue-600 rounded-lg">
        <i class="fas fa-user-cog mr-2"></i> Psicólogos
      </button>
      <a href="<?php echo e(route('administrador.recursos.index')); ?>" class="block w-full text-left p-2 hover:bg-blue-600 rounded-lg">
        <i class="fas fa-book mr-2"></i> Recursos
      </a>
      <a href="<?php echo e(route('administrador.historias.index')); ?>" class="block w-full text-left p-2 hover:bg-blue-600 rounded-lg relative">
        <i class="fas fa-comments mr-2"></i> Historias
        <?php if(isset($historiasPendientes) && $historiasPendientes > 0): ?>
          <span class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
            <?php echo e($historiasPendientes); ?>

          </span>
        <?php endif; ?>
      </a>
    </nav>
    <div class="absolute bottom-0 w-full p-4 border-t border-blue-400">
    <form action="<?php echo e(route('logout.admin')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="flex items-center text-red-200 hover:text-white w-full border-none bg-transparent p-2 cursor-pointer">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
        </button>
    </form>
</div>

  </div>

  <!-- Contenido principal -->
  <div class="ml-64 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
      Bienvenido, <?php echo e(session('admin_nombre')); ?>

    </h1>

    <!-- Sección Dashboard -->
    <div id="dashboard" class="section active">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow border-l-4 border-unividaBlue">
          <p class="text-gray-600 text-sm">Psicólogos registrados</p>
          <p class="text-3xl font-bold mt-2 text-unividaBlue"><?php echo e($psicologos->count()); ?></p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow border-l-4 border-yellow-500">
          <p class="text-gray-600 text-sm">Historias pendientes</p>
          <p class="text-3xl font-bold mt-2 text-yellow-600"><?php echo e($historiasPendientes ?? 0); ?></p>
          <a href="<?php echo e(route('administrador.historias.index')); ?>" class="text-sm text-blue-600 hover:underline mt-2 inline-block">
            Ver historias →
          </a>
        </div>
      </div>
    </div>

    <!-- CRUD de Psicólogos -->
    <div id="crud" class="section">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gestión de psicólogos</h2>
        <a href="<?php echo e(route('administrador.create')); ?>" class="bg-unividaBlue text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i class="fas fa-plus"></i> Agregar
        </a>
      </div>

      <?php if(session('success')): ?>
        <div class="mb-4 text-green-600 font-semibold"><?php echo e(session('success')); ?></div>
      <?php endif; ?>

      <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nombre</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Correo</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $psicologos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psicologo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="px-6 py-4"><?php echo e($psicologo->id_psicologo); ?></td>
                <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($psicologo->nombre); ?></td>
                <td class="px-6 py-4 text-gray-600"><?php echo e($psicologo->correo); ?></td>
                <td class="px-6 py-4 flex items-center space-x-3">
                  <a href="<?php echo e(route('administrador.edit', $psicologo->id_psicologo)); ?>" class="text-blue-600"><i class="fas fa-edit"></i></a>
                  <form action="<?php echo e(route('administrador.destroy', $psicologo->id_psicologo)); ?>" method="POST" onsubmit="return confirm('¿Eliminar este psicólogo?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-red-600"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function showSection(id) {
      document.querySelectorAll('.section').forEach(el => el.classList.remove('active'));
      document.getElementById(id).classList.add('active');
    }
  </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/administrador/dashboard.blade.php ENDPATH**/ ?>