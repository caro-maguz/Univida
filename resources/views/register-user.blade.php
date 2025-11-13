<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Registro Usuario</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
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
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .registro-container {
      background: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      max-width: 420px;
      width: 100%;
      text-align: center;
    }

    .registro-container img.logo {
      width: 90px;
      margin-bottom: 20px;
    }

    .registro-container h2 {
      font-size: 1.8rem;
      color: #004aad;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 18px;
      text-align: left;
      position: relative;
    }

    .form-group label {
      font-size: 0.95rem;
      font-weight: 600;
      color: #333;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 10px;
      outline: none;
      transition: 0.3s;
    }

    .form-group input:focus {
      border-color: #004aad;
      box-shadow: 0 0 6px rgba(0,74,173,0.4);
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 65%;
      transform: translateY(-50%);
      cursor: pointer;
      background: none;
      border: none;
      font-size: 1.1rem;
      color: #004aad;
      padding: 0;
      line-height: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .toggle-password span {
      display: inline-block;
    }

    .registro-button {
      width: 100%;
      padding: 12px;
      background: #004aad;
      color: white;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }

    .registro-button:hover {
      background: #003580;
    }

    .extra-links {
      margin-top: 15px;
      font-size: 0.9rem;
    }

    .extra-links a {
      color: #004aad;
      text-decoration: none;
      font-weight: 500;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="registro-container">
    <!-- Logo -->
    <img src="{{ asset('img/Logo.png') }}" alt="Logo Univida" class="logo">
    <h2>Registro de Usuario</h2>

    <!-- Formulario -->
    <form id="registroForm" action="{{ route('register.user.process') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="alias">Alias / Nombre de usuario</label>
        <input type="text" id="alias" name="alias" placeholder="Ej: Juan123" required minlength="3">
      </div>

      <div class="form-group">
        <label for="correo">Correo institucional</label>
        <input type="email" id="correo" name="correo" placeholder="usuario@uniautonoma.edu.co" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required minlength="6">
        <button type="button" class="toggle-password" onclick="togglePassword()">
          <span id="eyeIcon">👁️</span>
        </button>
      </div>

      <button type="submit" class="registro-button">Completar Registro</button>
    </form>

    <!-- Enlaces extra -->
    <div class="extra-links">
      <p><a href="{{ route('login.user') }}">¿Ya tienes cuenta? Inicia sesión</a></p>
    </div>
  </div>

    <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");
      
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.textContent = "👁️";
      } else {
        passwordInput.type = "password";
        eyeIcon.textContent = "👁️";
      }
    }

    document.getElementById("registroForm").addEventListener("submit", function(e) {
      const alias = document.getElementById("alias").value.trim();
      const correo = document.getElementById("correo").value.trim();
      const password = document.getElementById("password").value.trim();

      if (alias.length < 3) {
        alert("El alias debe tener al menos 3 caracteres.");
        e.preventDefault();
        return;
      }
      if (!correo.includes("@uniautonoma.edu.co")) {
        alert("Debe usar un correo institucional (@uniautonoma.edu.co).");
        e.preventDefault();
        return;
      }
      if (password.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        e.preventDefault();
        return;
      }
      // Si pasa las validaciones cliente, el formulario se enviará al servidor.
    });
  </script>
</body>
</html>