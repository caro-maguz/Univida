<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Casos Reportados - PsicoSalud Pro</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
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

    .search-box {
      position: relative;
      min-width: 280px;
      flex: 1;
      max-width: 400px;
    }

    .search-box input {
      width: 100%;
      padding: 12px 16px 12px 44px;
      border: 1px solid var(--border);
      border-radius: 14px;
      font-size: 15px;
      transition: all 0.3s;
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
    }

    .search-box i {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
    }

    /* Filtros tipo pestañas */
    .filters {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .filter-btn {
      padding: 8px 18px;
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

    .filter-btn:hover {
      background: #e8eaf6;
    }

    .filter-btn.active {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    /* Tarjetas de casos */
    .cases-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
    }

    .case-card {
      background: var(--card-bg);
      border-radius: 18px;
      padding: 20px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      transition: all 0.3s ease;
      cursor: pointer;
      border: 1px solid #eef4ff;
    }

    .case-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(13, 71, 161, 0.12);
    }

    .case-header {
      display: flex;
      justify-content: space-between;
      align-items: start;
      margin-bottom: 14px;
    }

    .case-name {
      font-size: 18px;
      font-weight: 700;
      color: var(--primary);
    }

    .case-id {
      font-size: 12px;
      color: var(--text-light);
      background: #f0f7ff;
      padding: 2px 8px;
      border-radius: 12px;
    }

    .case-date {
      font-size: 14px;
      color: var(--text-light);
      margin-bottom: 12px;
    }

    .case-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px dashed #e0e0e0;
    }

    .urgency-badge {
      font-size: 12px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .urgency-alta { background: #ffebee; color: #c62828; }
    .urgency-media { background: #fff8e1; color: #f57c00; }
    .urgency-baja { background: #e8f5e9; color: #2e7d32; }

    .status-badge {
      font-size: 12px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      color: white;
    }

    .status-nuevo { background: #2e7d32; }
    .status-proceso { background: var(--primary); }
    .status-cerrado { background: #9e9e9e; }
    .status-urgente { background: #c62828; }

    /* Modal de detalle */
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
      max-width: 750px;
      border-radius: 22px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.2);
      max-height: 90vh;
      overflow-y: auto;
    }

    .modal-header {
      padding: 28px 32px 20px;
      border-bottom: 1px solid #f0f7ff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-title {
      font-size: 24px;
      font-weight: 800;
      color: var(--primary);
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 28px;
      cursor: pointer;
      color: #9e9e9e;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: background 0.2s;
    }

    .close-modal:hover {
      background: #f5f5f5;
    }

    .modal-body {
      padding: 24px 32px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 24px;
    }

    .info-item p {
      margin: 4px 0;
      font-size: 15px;
    }

    .info-label {
      font-weight: 700;
      color: var(--primary);
      font-size: 14px;
    }

    .info-value {
      color: var(--text);
    }

    .history-section h3,
    .actions h3 {
      font-size: 18px;
      color: var(--primary);
      margin-bottom: 16px;
      padding-bottom: 8px;
      border-bottom: 1px solid #f0f7ff;
    }

    .interaction {
      padding: 12px;
      background: #f9fbfd;
      border-radius: 14px;
      margin-bottom: 10px;
      font-size: 14px;
      color: var(--text);
      border-left: 3px solid var(--primary-light);
    }

    .actions {
      margin-top: 28px;
    }

    .action-buttons {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
    }

    .btn-action {
      padding: 12px 24px;
      border: none;
      border-radius: 14px;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.2s;
      flex: 1;
      min-width: 180px;
      text-align: center;
    }

    .btn-cita { background: #2e7d32; color: white; }
    .btn-mensaje { background: var(--primary); color: white; }
    .btn-resuelto { background: #616161; color: white; }

    .btn-action:hover {
      transform: translateY(-2px);
      opacity: 0.95;
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

    @media (max-width: 768px) {
      .section-header {
        flex-direction: column;
        align-items: stretch;
      }
      .search-box {
        max-width: 100%;
      }
      .cases-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo-section">
      <img src="{{ asset('img/imagenpsicologo.png') }}" alt="Foto de perfil" class="avatar" onerror="this.src='https://via.placeholder.com/48/1976d2/FFFFFF?text=P';">
      <h1 class="page-title">Casos Reportados</h1>
    </div>
    <a href="{{ route('dashboard.psychologist') }}" class="back-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </header>

  <div class="main">
    <div class="section-header">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Buscar por nombre o ID...">
      </div>
      <div class="filters">
        <button class="filter-btn active" data-filter="todos">
          <i class="fas fa-layer-group"></i> Todos
        </button>
        <button class="filter-btn" data-filter="nuevo">
          <i class="fas fa-inbox"></i> Nuevo
        </button>
        <button class="filter-btn" data-filter="proceso">
          <i class="fas fa-sync-alt"></i> En proceso
        </button>
        <button class="filter-btn" data-filter="urgente">
          <i class="fas fa-exclamation-circle"></i> Urgente
        </button>
        <button class="filter-btn" data-filter="cerrado">
          <i class="fas fa-check-circle"></i> Cerrado
        </button>
      </div>
    </div>

    <div class="cases-grid" id="casesGrid">
      @if(!empty($reportes) && $reportes->count() > 0)
        @foreach($reportes as $r)
    <div class="case-card" tabindex="0" role="button"
  data-id="R{{ $r->id_reporte ?? $r->id ?? $loop->index }}"
  data-reporte-id="{{ $r->id_reporte ?? $r->id ?? $loop->index }}"
        data-usuario-id="{{ $r->fk_usuario ?? optional($r->usuario)->id_usuario ?? '' }}"
      data-nombre="{{ optional($r->usuario)->nombre ?? ($r->anonimo ? 'Anónimo' : 'Desconocido') }}"
      data-fecha="{{ $r->fecha }}"
      data-urgencia="media"
      data-estado="{{ $r->estado ?? 'nuevo' }}"
      data-detalles="{{ $r->descripcion }}">
            <div class="case-header">
              <div>
                <div class="case-name">{{ optional($r->usuario)->nombre ?? ($r->anonimo ? 'Anónimo' : 'Desconocido') }}</div>
                <div class="case-id">R{{ $r->id ?? $loop->index }}</div>
              </div>
              <span class="urgency-badge urgency-media">Media</span>
            </div>
            <div class="case-date">📅 {{ date('d/m/Y', strtotime($r->fecha)) }}</div>
            <div class="case-footer">
              <span class="status-badge status-{{ $r->estado ?? 'nuevo' }}">{{ ucfirst($r->estado ?? 'nuevo') }}</span>
            </div>
          </div>
        @endforeach
      @else
        <p style="grid-column:1/-1; text-align:center; color:#7f8c8d;">No hay casos reportados.</p>
      @endif
    </div>
  </div>

  <!-- Modal de detalle -->
  <div class="modal" id="caseModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="modalTitle">Detalle del caso</h2>
        <button class="close-modal" onclick="closeModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="info-grid" id="caseInfo"></div>

        <div class="history-section">
          <h3><i class="fas fa-history"></i> Historial de interacciones</h3>
          <div id="caseHistory"></div>
        </div>


        <div class="actions">
          <h3>Acciones rápidas</h3>
          <div class="action-buttons">
            <!--<button class="btn-action btn-cita">
              <i class="fas fa-calendar-check"></i> Asignar cita
            </button>-->
            <button class="btn-action btn-mensaje">
              <i class="fas fa-comment-dots"></i> Enviar mensaje
            </button>
            <button class="btn-action btn-resuelto" type="button">
              <i class="fas fa-check"></i> Cerrar reporte
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const csrfToken = '{{ csrf_token() }}';
    // Filtrado y búsqueda sobre los elementos ya renderizados en el DOM
    const cards = Array.from(document.querySelectorAll('.case-card'));

    function applyFilters() {
      const term = document.getElementById('searchInput').value.toLowerCase();
      const activeFilter = document.querySelector('.filter-btn.active')?.dataset.filter || 'todos';

      cards.forEach(card => {
        const nombre = (card.dataset.nombre || '').toLowerCase();
        const id = (card.dataset.id || '').toLowerCase();
        const estado = (card.dataset.estado || '').toLowerCase();

        const matchesSearch = nombre.includes(term) || id.includes(term);
        const matchesFilter = activeFilter === 'todos' || (activeFilter === 'urgente' ? card.dataset.urgencia === 'alta' : estado === activeFilter);

        card.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
      });
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
      });
    });

    document.getElementById('searchInput').addEventListener('input', applyFilters);

    // Modal: abrir con dataset del elemento
    function openCaseFromElement(el) {
      const nombre = el.dataset.nombre || 'Desconocido';
      const id = el.dataset.id || '';
      const usuarioId = el.dataset.usuarioId || '';
      const fecha = el.dataset.fecha || '';
      const urgencia = el.dataset.urgencia || 'media';
      const estado = el.dataset.estado || '';
      const detalles = el.dataset.detalles || '';

      document.getElementById('modalTitle').textContent = `${nombre} (${id})`;

      const infoContainer = document.getElementById('caseInfo');
      infoContainer.innerHTML = `
        <div class="info-item">
          <p class="info-label">ID del caso</p>
          <p class="info-value">${id}</p>
        </div>
        <div class="info-item">
          <p class="info-label">Nombre (Alias)</p>
          <p class="info-value">${nombre}</p>
        </div>
        <div class="info-item">
          <p class="info-label">Fecha de reporte</p>
          <p class="info-value">${new Date(fecha).toLocaleDateString('es-ES')}</p>
        </div>
        <div class="info-item">
          <p class="info-label">Nivel de urgencia</p>
          <p class="info-value"><span class="urgency-badge urgency-${urgencia}">${urgencia.charAt(0).toUpperCase() + urgencia.slice(1)}</span></p>
        </div>
        <div class="info-item">
          <p class="info-label">Estado actual</p>
          <p class="info-value"><span class="status-badge status-${estado}">${estado.charAt(0).toUpperCase() + estado.slice(1)}</span></p>
        </div>
        <div class="info-item" style="grid-column:1/-1;">
          <p class="info-label">Detalles confidenciales</p>
          <p class="info-value">${detalles}</p>
        </div>
      `;

      document.getElementById('caseHistory').innerHTML = '';
      // Guardar usuario id en el botón de enviar mensaje para usar luego
      const btnMensaje = document.querySelector('.btn-mensaje');
      if (btnMensaje) btnMensaje.dataset.usuarioId = usuarioId;
      
    // Guardar reporte id en el botón 'resuelto'
    const btnResuelto = document.querySelector('.btn-resuelto');
    const reporteId = el.dataset.reporteId;
    if (btnResuelto && reporteId) {
      btnResuelto.dataset.reporteId = reporteId;
    }

    document.getElementById('caseModal').style.display = 'flex';
  }

    function closeModal() {
      document.getElementById('caseModal').style.display = 'none';
    }

    window.onclick = (e) => {
      if (e.target === document.getElementById('caseModal')) closeModal();
    };

    // Attach click handlers to cards
    cards.forEach(card => card.addEventListener('click', () => openCaseFromElement(card)));

    // Acción del botón 'Enviar mensaje' del modal: abre/crea chat y redirige
    const btnMensajeGlobal = document.querySelector('.btn-mensaje');
    if (btnMensajeGlobal) {
      btnMensajeGlobal.addEventListener('click', async () => {
        const usuarioId = btnMensajeGlobal.dataset.usuarioId || '';
        if (!usuarioId) {
          alert('No se pudo determinar el usuario destino del mensaje');
          return;
        }

        try {
          const res = await fetch('{{ route("psychologist.chat.abrir") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ usuario_id: usuarioId })
          });

          const data = await res.json();
          if (data.success && data.chat_id) {
            window.location.href = `/psychologist/chat/${data.chat_id}`;
          } else {
            alert('No se pudo abrir el chat: ' + (data.error || 'Error desconocido'));
          }
        } catch (err) {
          console.error(err);
          alert('Error al abrir el chat');
        }
      });
    }

      // Acción del botón 'Marcar como resuelto' (mejor manejo de errores para diagnóstico)
      const btnResueltoGlobal = document.querySelector('.btn-resuelto');
      if (btnResueltoGlobal) {
        btnResueltoGlobal.addEventListener('click', async () => {
          const reporteId = btnResueltoGlobal.dataset.reporteId || '';
          if (!reporteId) {
            alert('Primero abre un caso para poder cerrarlo.');
            return;
          }
          if (!confirm('¿Cerrar este reporte? Se marcará como resuelto.')) return;
          try {
            const url = `{{ url('/psychologist/reporte') }}/${reporteId}/cerrar`;
            const res = await fetch(url, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
              }
            });
            const data = await res.json();
            if (res.ok && data.success) {
              alert('Reporte cerrado');
              location.reload();
            } else {
              alert(data.error || 'No se pudo cerrar el reporte');
            }
          } catch (e) {
            alert('Error de red al cerrar el reporte');
            console.error(e);
          }
        });
      }
  </script>
</body>
</html>