<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recursos Profesionales - PsicoSalud Pro</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Delius', cursive;
    }

    :root {
      --primary: #0d47a1;
      --primary-light: #1976d2;
      --primary-bg: #e3f2fd;
      --bg-gradient: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      --card-bg: white;
      --text: #2c3e50;
      --text-light: #546e7a;
      --border: #e0e0e0;
    }

    body {
      background: var(--bg-gradient);
      color: var(--text);
      min-height: 100vh;
      padding-bottom: 40px;
    }

    header {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--primary-light);
      background: var(--primary-bg);
    }

    .page-title {
      font-size: 22px;
      font-weight: 700;
      color: var(--primary);
    }

    .main {
      max-width: 1200px;
      margin: 24px auto;
      padding: 0 20px;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 16px;
    }

    /* Botón de subir recurso */
    .upload-btn {
      background: var(--primary);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s;
    }

    .upload-btn:hover {
      background: #0a3a8a;
    }

    /* Categorías */
    .categories {
      display: flex;
      gap: 12px;
      margin-bottom: 28px;
      flex-wrap: wrap;
    }

    .category-btn {
      padding: 10px 20px;
      background: white;
      border: 1px solid #c5cae9;
      border-radius: 20px;
      color: var(--text-light);
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.25s;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .category-btn:hover {
      background: #e8eaf6;
    }

    .category-btn.active {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    /* Grid de recursos */
    .resources-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
    }

    .resource-card {
      background: var(--card-bg);
      border-radius: 18px;
      padding: 20px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      transition: all 0.3s ease;
      border: 1px solid #f0f7ff;
    }

    .resource-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(13, 71, 161, 0.12);
    }

    .resource-icon {
      width: 50px;
      height: 50px;
      background: var(--primary-bg);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      color: var(--primary);
      font-size: 22px;
    }

    .resource-title {
      font-size: 17px;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 8px;
    }

    .resource-desc {
      font-size: 14px;
      color: var(--text-light);
      margin-bottom: 14px;
      line-height: 1.5;
    }

    .resource-meta {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--text-light);
    }

    .category-tag {
      font-size: 11px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      background: var(--primary-bg);
      color: var(--primary);
    }

    .back-btn {
      background: #e3f2fd;
      color: var(--primary);
      border: none;
      padding: 8px 20px;
      border-radius: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }

    .back-btn:hover {
      background: #bbdefb;
    }

    /* Modal de subida (simulado) */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 2000;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .modal-content {
      background: white;
      width: 100%;
      max-width: 500px;
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.2);
      padding: 30px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .modal-title {
      font-size: 22px;
      color: var(--primary);
      font-weight: 700;
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #9e9e9e;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 1px solid var(--border);
      border-radius: 12px;
      font-size: 15px;
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .section-header {
        flex-direction: column;
        align-items: stretch;
      }
      .resources-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo-section">
      <img src="<?php echo e(asset('img/imagenpsicologo.png')); ?>" alt="Foto de perfil" class="avatar" onerror="this.src='https://via.placeholder.com/48/1976d2/FFFFFF?text=P';">
      <h1 class="page-title">Recursos Profesionales</h1>
    </div>
    <a href="<?php echo e(route('dashboard.psychologist')); ?>" class="back-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </header>

  <div class="main">
    <div class="section-header">
      <h2 style="font-size: 20px; color: var(--primary);">Biblioteca de recursos</h2>
     <!-- <button class="upload-btn" onclick="openUploadModal()">
        <i class="fas fa-upload"></i> Subir recurso
      </button> -->
    </div>

    <div class="categories">
      <button class="category-btn active" data-category="todos">
        <i class="fas fa-layer-group"></i> Todos
      </button>
      <!--<button class="category-btn" data-category="emergencias">
        <i class="fas fa-exclamation-triangle"></i> Emergencias
      </button>
      <button class="category-btn" data-category="prevencion">
        <i class="fas fa-shield-alt"></i> Prevención
      </button>
      <button class="category-btn" data-category="acompanamiento">
        <i class="fas fa-hand-holding-heart"></i> Acompañamiento
      </button>-->
    </div>

    <div class="resources-grid" id="resourcesGrid">
      <?php $__empty_1 = true; $__currentLoopData = $recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $nombreTipo = strtolower($recurso->tipoRecurso->nombre ?? '');
          $icon = 'fas fa-file';
          if(str_contains($nombreTipo,'emerg')) $icon='fas fa-bolt';
          elseif(str_contains($nombreTipo,'prev')) $icon='fas fa-shield-alt';
          elseif(str_contains($nombreTipo,'acom') || str_contains($nombreTipo,'apoyo')) $icon='fas fa-hand-holding-heart';
        ?>
        <div class="resource-card">
          <div class="resource-icon">
            <i class="<?php echo e($icon); ?>"></i>
          </div>
          <h3 class="resource-title"><?php echo e($recurso->titulo); ?></h3>
          <p class="resource-desc"><?php echo e($recurso->descripcion); ?></p>
          <div class="resource-meta">
            <span><?php echo e($recurso->enlace ? 'Enlace' : 'Recurso'); ?></span>
            <span class="category-tag"><?php echo e($recurso->tipoRecurso->nombre ?? '—'); ?></span>
          </div>
          <?php if($recurso->enlace): ?>
            <div style="margin-top:10px">
              <a href="<?php echo e($recurso->enlace); ?>" target="_blank" rel="noopener" class="back-btn">Abrir</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="grid-column:1/-1; text-align:center; color:#7f8c8d;">No hay recursos cargados.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Nota: la carga de recursos la gestiona el administrador -->

  <script>
    // Opcional: implementar filtros de categorías en frontend leyendo los nombres de tipo.
    document.querySelectorAll('.category-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cards = document.querySelectorAll('.resource-card');
        const cat = btn.dataset.category;
        cards.forEach(card => {
          if (cat === 'todos') { card.style.display = ''; return; }
          const label = card.querySelector('.category-tag')?.textContent.toLowerCase() || '';
          const matches = (cat === 'emergencias' && label.includes('emerg')) ||
                         (cat === 'prevencion' && label.includes('prev')) ||
                         (cat === 'acompanamiento' && (label.includes('acom') || label.includes('apoyo')));
          card.style.display = matches ? '' : 'none';
        });
      });
    });
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\univida\resources\views/psychologist/resources.blade.php ENDPATH**/ ?>