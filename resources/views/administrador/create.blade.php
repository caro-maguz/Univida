<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar psicologo</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{
      font-family: 'Delius', cursive;
    }
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    h1 {
      text-align: center;
      color: #2563eb;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      transition: border-color 0.3s;
    }
    input:focus {
      border-color: #2563eb;
    }
    button {
      width: 100%;
      background: #2563eb;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #1e40af;
    }
    a {
      display: inline-block;
      margin-top: 10px;
      text-align: center;
      width: 100%;
      color: #2563eb;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Agregar psicologo</h1>
    <form action="{{ route('administrador.store') }}" method="POST">
      @csrf
      <label>Nombre:</label>
      <input type="text" name="nombre" required>

      <label>Correo:</label>
      <input type="email" name="correo" required>

      <label>Contraseña:</label>
      <input type="password" name="contrasena" required>


      <button type="submit">Guardar</button>
    </form>
    <a href="{{ route('administrador.index') }}">← Volver</a>
  </div>
</body>
</html>
