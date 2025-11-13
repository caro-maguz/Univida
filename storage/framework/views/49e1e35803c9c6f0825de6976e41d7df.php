<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Iniciar Sesión Usuario</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
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

    .login-container {
      background: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      max-width: 420px;
      width: 100%;
      text-align: center;
    }

    .login-container img.logo {
      width: 90px;
      margin-bottom: 20px;
    }

    .login-container h2 {
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

    .login-button {
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

    .login-button:hover {
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
      display: block;
      margin: 8px 0;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    .recover-password {
      display: inline-block;
      margin-top: 8px;
      color: #004aad;
      text-decoration: none;
      font-weight: 500;
    }

    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- Logo -->
    <img src="<?php echo e(asset('img/Logo.png')); ?>" alt="Logo Univida" class="logo">
    <h2>Iniciar Sesión</h2>

    <!-- Formulario funcional -->
    <form action="<?php echo e(route('login.user.process')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="form-group">
        <label for="email">Correo institucional</label>
        <input type="email" id="email" name="correo" placeholder="---@uniautonoma.edu.co" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="contrasena" placeholder="••••••••" required>
        <button type="button" class="toggle-password" onclick="togglePassword()">
          <span id="eyeIcon">👁️</span>
        </button>
      </div>

      <button type="submit" class="login-button">Ingresar</button>

      <?php if(session('success')): ?>
        <p style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 8px; margin-top: 10px; font-size: 0.9rem; border-left: 4px solid #2e7d32;">
          <?php echo e(session('success')); ?>

        </p>
      <?php endif; ?>

      <?php $__errorArgs = ['login_error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="error-message"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </form>

    <!-- Enlace para recuperar contraseña -->
    <a href="<?php echo e(route('password.request')); ?>" class="recover-password">¿Olvidaste tu contraseña?</a>

    <!-- Enlaces extra -->
    <div class="extra-links">
      <p><a href="<?php echo e(route('register.user')); ?>">Crear cuenta nueva</a></p>
      <p><a href="<?php echo e(route('home')); ?>">← Regresar</a></p>
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
  </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/login-user.blade.php ENDPATH**/ ?>