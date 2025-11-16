<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer Contraseña - Univida</title>
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
      padding: 2rem;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .container {
      background: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      max-width: 420px;
      width: 100%;
      text-align: center;
    }

    .container img.logo {
      width: 90px;
      margin-bottom: 20px;
    }

    h2 {
      font-size: 1.8rem;
      color: #004aad;
      margin-bottom: 15px;
    }

    .subtitle {
      color: #666;
      font-size: 0.95rem;
      margin-bottom: 25px;
      line-height: 1.5;
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

    .submit-button {
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

    .submit-button:hover {
      background: #003580;
    }

    .error-message {
      background: #ffebee;
      color: #c62828;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.9rem;
      border-left: 4px solid #c62828;
    }

    .back-link {
      display: inline-block;
      margin-top: 15px;
      color: #004aad;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .icon {
      font-size: 3rem;
      margin-bottom: 15px;
    }

    .info-box {
      background: #e3f2fd;
      border-left: 4px solid #004aad;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: left;
      font-size: 0.9rem;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="<?php echo e(asset('img/Logo.png')); ?>" alt="Logo Univida" class="logo">
    <div class="icon">🔑</div>
    <h2>Nueva Contraseña</h2>
    <p class="subtitle">Ingresa el código de 4 dígitos que recibiste y tu nueva contraseña.</p>

    <?php if($errors->any()): ?>
      <div class="error-message">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          • <?php echo e($error); ?><br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <div class="info-box">
      <strong>📌 Requisitos:</strong><br>
      • Código de verificación de 4 dígitos<br>
      • Contraseña mínimo 6 caracteres<br>
      • Ambas contraseñas deben coincidir
    </div>

    <form action="<?php echo e(route('password.update')); ?>" method="POST">
      <?php echo csrf_field(); ?>

      <div class="form-group">
        <label for="correo">Correo institucional</label>
        <input type="email" id="correo" name="correo" placeholder="usuario@uniautonoma.edu.co" required value="<?php echo e(old('correo')); ?>">
      </div>

      <div class="form-group">
        <label for="codigo">Código de Verificación (4 dígitos)</label>
        <input type="text" id="codigo" name="codigo" placeholder="0000" required maxlength="4" pattern="[0-9]{4}" style="text-align: center; font-size: 1.5rem; letter-spacing: 0.5rem;" value="<?php echo e(old('codigo')); ?>">
      </div>

      <div class="form-group">
        <label for="password">Nueva Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required minlength="6">
        <button type="button" class="toggle-password" onclick="togglePassword('password', 'eyeIcon1')">
          <span id="eyeIcon1">👁️</span>
        </button>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña" required minlength="6">
        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
          <span id="eyeIcon2">👁️</span>
        </button>
      </div>

      <button type="submit" class="submit-button">Restablecer Contraseña</button>
    </form>

    <a href="<?php echo e(route('login.user')); ?>" class="back-link">← Volver al inicio de sesión</a>
  </div>

  <script>
    function togglePassword(inputId, iconId) {
      const passwordInput = document.getElementById(inputId);
      const eyeIcon = document.getElementById(iconId);
      
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
<?php /**PATH C:\xampp\htdocs\univida\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>