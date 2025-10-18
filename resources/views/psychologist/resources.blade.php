<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recursos Profesionales - PsicoSalud Pro</title>
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
      <img src="{{ asset('img/imagenpsicologo.png') }}" alt="Foto de perfil" class="avatar" onerror="this.src='https://via.placeholder.com/48/1976d2/FFFFFF?text=P';">
      <h1 class="page-title">Recursos Profesionales</h1>
    </div>
    <a href="{{ route('dashboard.psychologist') }}" class="back-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </header>

  <div class="main">
    <div class="section-header">
      <h2 style="font-size: 20px; color: var(--primary);">Biblioteca de recursos</h2>
      <button class="upload-btn" onclick="openUploadModal()">
        <i class="fas fa-upload"></i> Subir recurso
      </button>
    </div>

    <div class="categories">
      <button class="category-btn active" data-category="todos">
        <i class="fas fa-layer-group"></i> Todos
      </button>
      <button class="category-btn" data-category="emergencias">
        <i class="fas fa-exclamation-triangle"></i> Emergencias
      </button>
      <button class="category-btn" data-category="prevencion">
        <i class="fas fa-shield-alt"></i> Prevención
      </button>
      <button class="category-btn" data-category="acompanamiento">
        <i class="fas fa-hand-holding-heart"></i> Acompañamiento
      </button>
    </div>

    <div class="resources-grid" id="resourcesGrid">
      <!-- Se llenará con JavaScript -->
    </div>
  </div>

  <!-- Modal para subir recurso -->
  <div class="modal" id="uploadModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Subir nuevo recurso</h3>
        <button class="close-modal" onclick="closeUploadModal()">&times;</button>
      </div>
      <form id="uploadForm">
        <div class="form-group">
          <label for="title">Título del recurso</label>
          <input type="text" id="title" required placeholder="Ej. Protocolo de crisis suicida">
        </div>
        <div class="form-group">
          <label for="category">Categoría</label>
          <select id="category" required>
            <option value="emergencias">Emergencias</option>
            <option value="prevencion">Prevención</option>
            <option value="acompanamiento">Acompañamiento</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea id="description" placeholder="Breve descripción del contenido..."></textarea>
        </div>
        <div class="form-group">
          <label for="file">Archivo (PDF, DOC, etc.)</label>
          <input type="file" id="file" accept=".pdf,.doc,.docx,.txt">
          <small style="color:#7f8c8d; display:block; margin-top:6px;">Solo para simulación. En producción se integraría con backend.</small>
        </div>
        <button type="submit" class="submit-btn">Guardar recurso</button>
      </form>
    </div>
  </div>

  <script>
    // Recursos iniciales (biblioteca base)
    let recursos = [
      {
        id: 1,
        titulo: "Protocolo de intervención en crisis suicida",
        descripcion: "Guía paso a paso para evaluación y manejo inmediato.",
        categoria: "emergencias",
        fecha: "2024-01-15",
        tipo: "PDF"
      },
      {
        id: 2,
        titulo: "Técnicas de respiración para ansiedad",
        descripcion: "Ejercicios prácticos para pacientes con trastornos de ansiedad.",
        categoria: "prevencion",
        fecha: "2024-02-10",
        tipo: "PDF"
      },
      {
        id: 3,
        titulo: "Guía de acompañamiento en duelo",
        descripcion: "Estrategias terapéuticas para procesos de duelo complicado.",
        categoria: "acompanamiento",
        fecha: "2024-03-05",
        tipo: "PDF"
      },
      {
        id: 4,
        titulo: "Lista de verificación: Riesgo autolesivo",
        descripcion: "Instrumento clínico para evaluación rápida de riesgo.",
        categoria: "emergencias",
        fecha: "2024-04-20",
        tipo: "PDF"
      },
      {
        id: 5,
        titulo: "Taller: Resiliencia en adolescentes",
        descripcion: "Material didáctico para talleres grupales.",
        categoria: "prevencion",
        fecha: "2024-03-22",
        tipo: "DOCX"
      }
    ];

    let recursosFiltrados = [...recursos];

    // Renderizar recursos
    function renderRecursos(data) {
      const container = document.getElementById('resourcesGrid');
      container.innerHTML = '';

      if (data.length === 0) {
        container.innerHTML = `<p style="grid-column:1/-1; text-align:center; color:#7f8c8d;">No hay recursos en esta categoría.</p>`;
        return;
      }

      data.forEach(recurso => {
        const card = document.createElement('div');
        card.className = 'resource-card';
        const iconMap = {
          emergencias: 'fas fa-bolt',
          prevencion: 'fas fa-shield-alt',
          acompanamiento: 'fas fa-hand-holding-heart'
        };
        const icon = iconMap[recurso.categoria] || 'fas fa-file';
        const categoryName = {
          emergencias: 'Emergencias',
          prevencion: 'Prevención',
          acompanamiento: 'Acompañamiento'
        };

        card.innerHTML = `
          <div class="resource-icon">
            <i class="${icon}"></i>
          </div>
          <h3 class="resource-title">${recurso.titulo}</h3>
          <p class="resource-desc">${recurso.descripcion}</p>
          <div class="resource-meta">
            <span>${recurso.tipo}</span>
            <span class="category-tag">${categoryName[recurso.categoria]}</span>
          </div>
        `;
        container.appendChild(card);
      });
    }

    // Filtros por categoría
    document.querySelectorAll('.category-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cat = btn.dataset.category;
        if (cat === 'todos') {
          recursosFiltrados = [...recursos];
        } else {
          recursosFiltrados = recursos.filter(r => r.categoria === cat);
        }
        renderRecursos(recursosFiltrados);
      });
    });

    // Modal de subida
    function openUploadModal() {
      document.getElementById('uploadModal').style.display = 'flex';
    }

    function closeUploadModal() {
      document.getElementById('uploadModal').style.display = 'none';
    }

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const titulo = document.getElementById('title').value;
      const categoria = document.getElementById('category').value;
      const descripcion = document.getElementById('description').value || "Sin descripción";
      
      const nuevoRecurso = {
        id: recursos.length + 1,
        titulo,
        descripcion,
        categoria,
        fecha: new Date().toISOString().split('T')[0],
        tipo: "PDF"
      };
      
      recursos.push(nuevoRecurso);
      recursosFiltrados = [...recursos];
      
      renderRecursos(recursosFiltrados);
      closeUploadModal();
      this.reset();
      alert("✅ Recurso agregado a tu biblioteca.");
    });

    window.onclick = (e) => {
      if (e.target === document.getElementById('uploadModal')) closeUploadModal();
    };

    // Inicializar
    renderRecursos(recursos);
  </script>
</body>
</html>