<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reportes y Estadísticas - PsicoSalud Pro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      margin-bottom: 28px;
      flex-wrap: wrap;
      gap: 16px;
    }

    .download-btn {
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

    .download-btn:hover {
      background: #0a3a8a;
    }

    /* Grid de gráficas */
    .charts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 28px;
    }

    .chart-card {
      background: var(--card-bg);
      border-radius: 18px;
      padding: 24px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      border: 1px solid #f0f7ff;
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .chart-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--primary);
    }

    .chart-container {
      height: 280px;
      position: relative;
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
      .charts-grid {
        grid-template-columns: 1fr;
      }
      .chart-container {
        height: 240px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo-section">
      <img src="<?php echo e(asset('img/imagenpsicologo.png')); ?>" alt="Foto de perfil" class="avatar" onerror="this.src='https://via.placeholder.com/48/1976d2/FFFFFF?text=P';">
      <h1 class="page-title">Reportes y Estadísticas</h1>
    </div>
    <a href="<?php echo e(route('dashboard.psychologist')); ?>" class="back-btn">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </header>

  <div class="main">
    <div class="section-header">
      <h2 style="font-size: 20px; color: var(--primary);">Resumen de actividad</h2>
      <button class="download-btn" onclick="descargarPDF()">
        <i class="fas fa-file-pdf"></i> Descargar reporte PDF
      </button>
    </div>

    <div class="charts-grid">
      <!-- Casos atendidos -->
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Casos atendidos</h3>
          <span style="font-size:13px; color:var(--text-light);">Últimos 30 días</span>
        </div>
        <div class="chart-container">
          <canvas id="casosChart"></canvas>
        </div>
      </div>

      <!-- Tiempo de respuesta -->
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Tiempo de respuesta</h3>
          <span style="font-size:13px; color:var(--text-light);">Promedio por día</span>
        </div>
        <div class="chart-container">
          <canvas id="tiempoChart"></canvas>
        </div>
      </div>

      <!-- Estado de casos -->
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Estado de casos</h3>
          <span style="font-size:13px; color:var(--text-light);">Total activos</span>
        </div>
        <div class="chart-container">
          <canvas id="estadoChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    // === Gráfica 1: Casos atendidos (semana/mes) ===
    const ctx1 = document.getElementById('casosChart').getContext('2d');
    new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
        datasets: [{
          label: 'Casos atendidos',
          data: [12, 18, 15, 22],
          backgroundColor: 'rgba(13, 71, 161, 0.7)',
          borderColor: 'rgba(13, 71, 161, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 5 }
          }
        }
      }
    });

    // === Gráfica 2: Tiempo de respuesta ===
    const ctx2 = document.getElementById('tiempoChart').getContext('2d');
    new Chart(ctx2, {
      type: 'line',
      data: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        datasets: [{
          label: 'Tiempo promedio (min)',
          data: [22, 18, 25, 20, 15, 30, 12],
          fill: true,
          backgroundColor: 'rgba(25, 118, 210, 0.2)',
          borderColor: 'rgba(25, 118, 210, 1)',
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 10 }
          }
        }
      }
    });

    // === Gráfica 3: Estado de casos ===
    const ctx3 = document.getElementById('estadoChart').getContext('2d');
    new Chart(ctx3, {
      type: 'doughnut',
      data: {
        labels: ['Abiertos', 'En seguimiento', 'Cerrados'],
        datasets: [{
          data: [8, 14, 22],
          backgroundColor: [
            '#ffebee', // Rojo suave
            '#e3f2fd', // Azul suave
            '#e8f5e9'  // Verde suave
          ],
          borderColor: [
            '#c62828',
            '#1976d2',
            '#2e7d32'
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true
            }
          }
        }
      }
    });

    // === Descargar PDF (simulado) ===
    function descargarPDF() {
      alert("📄 Generando reporte en PDF...\n\nEn una versión real, se descargaría un archivo con estas estadísticas.");
      // En producción, usarías una librería como jsPDF + html2canvas
    }
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\univida\resources\views/psychologist/estadisticos.blade.php ENDPATH**/ ?>