<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Token de Recuperación - Univida</title>
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
      max-width: 520px;
      width: 100%;
      text-align: center;
    }

    .icon {
      font-size: 4rem;
      margin-bottom: 15px;
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

    .alert-box {
      background: #fff3cd;
      border: 2px solid #ffc107;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .alert-box p {
      color: #333;
      margin-bottom: 10px;
      font-size: 0.95rem;
    }

    .token-box {
      background: #f5f5f5;
      border: 2px dashed #004aad;
      border-radius: 10px;
      padding: 15px;
      margin: 20px 0;
      word-break: break-all;
      font-family: 'Courier New', monospace;
      font-size: 0.9rem;
      color: #004aad;
      font-weight: bold;
    }

    .copy-button {
      background: #ffc107;
      color: #333;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 0.95rem;
      transition: 0.3s;
      margin-top: 10px;
    }

    .copy-button:hover {
      background: #ffb300;
    }

    .continue-button {
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
      margin-top: 15px;
      text-decoration: none;
      display: inline-block;
    }

    .continue-button:hover {
      background: #003580;
    }

    .note {
      background: #e3f2fd;
      border-left: 4px solid #004aad;
      padding: 15px;
      border-radius: 8px;
      margin-top: 20px;
      text-align: left;
      font-size: 0.9rem;
      color: #333;
    }

    .note strong {
      color: #004aad;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="icon">✉️</div>
    <h2>¡Token Generado!</h2>
    <p class="subtitle">Se ha generado un token de recuperación para: <strong><?php echo e($correo); ?></strong></p>

    <div class="alert-box">
      <p><strong>⚠️ MODO DE DESARROLLO</strong></p>
      <p>Como no hay servidor de correo configurado, aquí está tu token de recuperación:</p>
    </div>

    <div class="token-box" id="tokenText"><?php echo e($token); ?></div>
    
    <button class="copy-button" onclick="copyToken()">📋 Copiar Token</button>

    <a href="<?php echo e(route('password.reset', $token)); ?>" class="continue-button">
      Continuar al restablecimiento →
    </a>

    <div class="note">
      <strong>📌 Nota importante:</strong><br>
      • Este token expira en 60 minutos.<br>
      • En producción, este enlace llegaría por correo electrónico.<br>
      • Guarda este token para restablecer tu contraseña.
    </div>
  </div>

  <script>
    function copyToken() {
      const tokenText = document.getElementById('tokenText').textContent;
      navigator.clipboard.writeText(tokenText).then(() => {
        const btn = document.querySelector('.copy-button');
        const originalText = btn.textContent;
        btn.textContent = '✅ ¡Copiado!';
        setTimeout(() => {
          btn.textContent = originalText;
        }, 2000);
      }).catch(err => {
        alert('No se pudo copiar el token. Cópialo manualmente.');
      });
    }
  </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/auth/token-generated.blade.php ENDPATH**/ ?>