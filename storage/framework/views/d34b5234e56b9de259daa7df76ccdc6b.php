<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel de Control - Psicología</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Delius', cursive;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      color: #2c3e50;
      min-height: 100vh;
    }

    header {
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 16px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    /* Avatar circular con letra "U" en la esquina superior derecha */
    .avatar-circle {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: #0d47a1;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: absolute;
      top: 8px; 
      right: 30px;
      z-index: 1000;
    }

    .welcome-text h2 {
      font-size: 20px;
      font-weight: 700;
      color: #0d47a1;
    }

    /* Menú desplegable */
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 56px; 
      right: 30px;
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      z-index: 1000;
      min-width: 160px;
    }

    .dropdown-menu a {
      display: block;
      padding: 12px 24px;
      color: #333;
      text-decoration: none;
      font-weight: 500;
    }

    .dropdown-menu a:hover {
      background: #f1f6fb;
      color: #0d47a1;
    }

    .dropdown-menu a:last-child {
      color: #c62828;
      font-weight: 600;
    }

    .dropdown-menu a:last-child:hover {
      background: #ffebee;
      color: #c62828;
    }

    .main {
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .hero {
      text-align: center;
      margin-bottom: 30px;
      background: white;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }

    .hero h1 {
      font-size: 28px;
      color: #0d47a1;
      margin-bottom: 12px;
    }

    .hero p {
      color: #666;
      margin-bottom: 20px;
    }

    .mascotainicio {
      width: 150px;
      height: 150px;
      margin: 0 auto 20px;
      border-radius: 16px;
      object-fit: contain;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border: 2px solid #e1f5fe;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 24px;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      text-align: center;
      transition: transform 0.2s ease;
      position: relative;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-icon {
      font-size: 32px;
      margin-bottom: 16px;
    }

    .new-cases .card-icon { color: #2e7d32; }
    .active-chats .card-icon { color: #1565c0; }
    .urgent-alerts .card-icon { color: #c62828; }
    .stats .card-icon { color: #6a1b9a; }

    .card-value {
      font-size: 32px;
      font-weight: 800;
      color: #0d47a1;
      margin-bottom: 8px;
    }

    .card-label {
      font-size: 14px;
      color: #666;
      font-weight: 500;
    }

    .card-link {
      display: block;
      margin-top: 12px;
      color: #0d47a1;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      text-align: center;
    }

    .card-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <div class="user-info">
      <div class="welcome-text">
        <h2>Bienvenido, Dr. <?php echo e(session('nombre')); ?></h2>
      </div>
    </div>

    <!-- Avatar circular con letra inicial -->
    <div class="avatar-circle" id="userMenuBtn">
      <?php echo e(strtoupper(substr(session('nombre'), 0, 1))); ?>

    </div>

    <!-- Menú desplegable -->
     <div class="dropdown-menu" id="dropdownMenu">
     <!-- <a href="#">Mi Perfil</a>
      <a href="#">Configuración</a>-->
      <form action="<?php echo e(route('logout.psicologo')); ?>" method="POST" style="margin:0;">
        <?php echo csrf_field(); ?>
        <button type="submit" style="width:100%; text-align:left; padding:12px; background:none; border:none; cursor:pointer; font-family:'Delius', cursive; font-size:0.95rem; color:#333;">
          Cerrar sesión
        </button>
      </form>
    </div>


  </header>

  <main class="main">
    <section class="hero">
      <h1>Panel de Control - Psicología</h1>
      <p>Gestiona tus casos, pacientes y actividades desde aquí</p>
      <img src="<?php echo e(asset('img/mascotainicio.png')); ?>" alt="mascotainicio" class="mascotainicio">
    </section>

    <div class="cards">
      <!-- Casos Reportados -->
      <div class="card new-cases">
        <div class="card-icon"><i class="fas fa-file-medical"></i></div>
              <!--<div class="card-value">12</div>-->
        <div class="card-label">Casos Reportados</div>
        <a href="<?php echo e(route('psychologist.reporte')); ?>" class="card-link">Ver detalles</a>
      </div>
      
      <!-- Chat de Apoyo -->
      <div class="card active-chats">
        <div class="card-icon"><i class="fas fa-comments"></i></div>
        <!--<div class="card-value">8</div>-->
        <div class="card-label">Chat de Apoyo</div>
        <a href="<?php echo e(route('psychologist.chat')); ?>" class="card-link">Ir al chat</a>
      </div>
      
      <!-- Recursos Profesionales -->
      <div class="card urgent-alerts">
        <div class="card-icon"><i class="fas fa-book"></i></div>
        <!-- <div class="card-value">24</div>-->
        <div class="card-label">Recursos Profesionales</div>
        <a href="<?php echo e(route('psychologist.resources')); ?>" class="card-link">Explorar recursos</a>
      </div>
      
      <!-- Reportes Estadísticos -->
      <div class="card stats">
        <div class="card-icon"><i class="fas fa-chart-bar"></i></div>
         <!--<div class="card-value">96%</div> -->
        <div class="card-label">Reportes Estadísticos</div>
        <a href="<?php echo e(route('psychologist.estadisticos')); ?>" class="card-link">Ver reportes</a>
      </div>
    </div>
  </main>

  <script>
    // Obtener elementos
    const userMenuBtn = document.getElementById('userMenuBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Mostrar/ocultar menú al hacer clic en el avatar
    userMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Cerrar menú al hacer clic en cualquier parte de la pantalla
    document.addEventListener('click', function(e) {
      if (!userMenuBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.style.display = 'none';
      }
    });

    // Opcional: cerrar menú al hacer clic en cualquier opción
    dropdownMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', function() {
        dropdownMenu.style.display = 'none';
      });
    });
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\univida\resources\views/dashboard-psychologist.blade.php ENDPATH**/ ?>