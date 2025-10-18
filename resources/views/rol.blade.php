<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Selección de Rol</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{
      font-family: 'Delius', cursive;
    }
    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
      background-size: 200% 200%;
      animation: gradientMove 8s ease infinite;
      position: relative;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .back-button {
      position: absolute;
      top: 30px;
      left: 30px;
      background: rgba(255, 255, 255, 0.95);
      color: #004aad;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 0.95rem;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .back-button:hover {
      background: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .back-button::before {
      content: '←';
      font-size: 1.2rem;
    }

    .container {
      background: white;
      padding: 40px;
      padding-bottom: 30px;
      border-radius: 16px;
      text-align: center;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    img {
      width: 100px;
      margin-bottom: 20px;
    }

    h2 {
      margin-bottom: 25px;
      color: #004aad;
    }

    button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      background: #004aad;
      color: white;
      transition: 0.3s;
    }

    button:hover {
      background: #003580;
    }

    .container-back-button {
      background: transparent;
      color: #004aad;
      border: 2px solid #004aad;
      margin-top: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .container-back-button:hover {
      background: #f0f7ff;
      border-color: #003580;
      color: #003580;
    }

    .container-back-button::before {
      content: '←';
      font-size: 1.1rem;
    }

    @media (max-width: 768px) {
      .back-button {
        top: 15px;
        left: 15px;
        padding: 8px 16px;
        font-size: 0.9rem;
      }

      .container {
        margin: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="{{ asset('img/Logo.png') }}" alt="Logo Univida">
    <h2>¿Cómo deseas ingresar?</h2>
    <button onclick="window.location.href='{{ route('login.user') }}'">Usuario</button>
    <button onclick="window.location.href='{{ route('login.admin') }}'">Administrativo</button>
    <button onclick="window.location.href='{{ route('login.psychologist') }}'">Psicólogo</button>
    
    <button class="container-back-button" onclick="window.location.href='{{ route('home') }}'">
      Volver al Inicio
    </button>
  </div>
</body>
</html>