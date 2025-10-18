<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Acerca de Nosotros</title>
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
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* Formas geométricas flotantes */
    body::before {
      content: '';
      position: absolute;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
      border-radius: 50%;
      top: -200px;
      right: -100px;
      animation: float 20s infinite ease-in-out;
    }

    body::after {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
      border-radius: 50%;
      bottom: -150px;
      left: -100px;
      animation: float 25s infinite ease-in-out reverse;
    }

    @keyframes float {
      0%, 100% {
        transform: translate(0, 0) scale(1) rotate(0deg);
      }
      33% {
        transform: translate(100px, -80px) scale(1.2) rotate(120deg);
      }
      66% {
        transform: translate(-80px, 100px) scale(0.9) rotate(240deg);
      }
    }

    /* Partículas flotantes */
    .particles {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      animation: particleFloat 20s infinite ease-in-out;
    }

    .particle:nth-child(1) {
      width: 10px;
      height: 10px;
      left: 10%;
      animation-duration: 15s;
      animation-delay: 0s;
    }

    .particle:nth-child(2) {
      width: 15px;
      height: 15px;
      left: 25%;
      animation-duration: 18s;
      animation-delay: 2s;
    }

    .particle:nth-child(3) {
      width: 8px;
      height: 8px;
      left: 50%;
      animation-duration: 12s;
      animation-delay: 4s;
    }

    .particle:nth-child(4) {
      width: 12px;
      height: 12px;
      left: 70%;
      animation-duration: 16s;
      animation-delay: 1s;
    }

    .particle:nth-child(5) {
      width: 10px;
      height: 10px;
      left: 85%;
      animation-duration: 14s;
      animation-delay: 3s;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(100vh) scale(0);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) scale(1);
        opacity: 0;
      }
    }

    .container {
      display: flex;
      align-items: center;
      gap: 40px;
      max-width: 1200px;
      width: 100%;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 1;
    }

    .mascot-image {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .mascot-image img {
      max-width: 300px;
      height: auto;
      border-radius: 12px;
    }

    .content {
      flex: 1;
      text-align: left;
    }

    .content h1 {
      font-size: 2.2rem;
      color: #004aad;
      margin-bottom: 20px;
    }

    .content p {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #333;
      margin-bottom: 25px;
    }

    .back-button {
      background: #004aad;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1rem;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .back-button:hover {
      background: #003580;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>
  
  <div class="container">
    <div class="mascot-image">
      <img src="{{ asset('img/mascotainicio.png') }}" alt="Mascota Univida">
    </div>
    <div class="content">
      <h1>Acerca de Nosotros</h1>
      <p>Una aplicación web dirigida a toda la comunidad universitaria — estudiantes, docentes y personal administrativo — que proporciona acompañamiento, orientación y apoyo en casos de violencia psicológica, acoso o maltrato.</p>
      <a href="{{ route('home') }}" class="back-button">Regresar al Inicio</a>
    </div>
  </div>
</body>
</html>