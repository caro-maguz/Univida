<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña - Univida</title>
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
  </style>
</head>
<body>
  <div class="container">
    <img src="<?php echo e(asset('img/Logo.png')); ?>" alt="Logo Univida" class="logo">
    <div class="icon">🔐</div>
    <h2>Recuperar Contraseña</h2>
    <p class="subtitle">Ingresa tu correo institucional y te enviaremos un enlace para restablecer tu contraseña.</p>

    <?php if($errors->any()): ?>
      <div class="error-message">
        <?php echo e($errors->first()); ?>

      </div>
    <?php endif; ?>

    <form action="<?php echo e(route('password.email')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="form-group">
        <label for="correo">Correo institucional</label>
        <input type="email" id="correo" name="correo" placeholder="usuario@uniautonoma.edu.co" required value="<?php echo e(old('correo')); ?>">
      </div>

      <button type="submit" class="submit-button">Enviar enlace de recuperación</button>
    </form>

    <a href="<?php echo e(route('login.user')); ?>" class="back-link">← Volver al inicio de sesión</a>
  </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>