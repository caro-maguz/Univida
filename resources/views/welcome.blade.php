<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Univida - Acompañamiento y Prevención</title>
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
    background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
    background-size: 200% 200%;
    animation: gradientMove 10s ease infinite;
    color: #2c3e50;
  }

  @keyframes gradientMove {
    0%, 100% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
  }

  /* ----- Header ----- */
  header {
    background: #e3f2fd;
    color: white;
    padding: 12px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .Logo {
    display: flex;
    align-items: center;
  }

  .Logo a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
  }

  .Logo img {
    height: 36px;
    margin-right: 10px;
  }

.Logo-text {
  font-size: 18px;
  font-weight: bold;
  color: #3b3b98; 
}

  .nav-links a {
    text-decoration: none;
  }

  .login-button {
    background: #3b3b98;
    color: #ffffffff;
    border: none;
    padding: 8px 18px;
    font-size: 0.9rem;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
  }

  .login-button:hover {
    background: #ffe100eb;
    color:  #3b3b98;
  }

  /* ----- Hero Section con Carrusel ----- */
  .hero-section {
    position: relative;
    height: 60vh;
    min-height: 450px;
    max-height: 550px;
    overflow: hidden;
    border-radius: 20px;
    overflow: hidden;
    margin: 40px auto;
    width: 90%;
    max-width: 2100px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    background: white;
    border: 1px solid rgba(255, 255, 255, 0.6);
  }

  .carousel {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }


  .carousel img {
    border-radius: 20px;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center center;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    background: white;
  }

  .carousel img.active {
    opacity: 1;
  }

  .hero-text {
    position: absolute;
    bottom: 50px;
    left: 5px;
    max-width: 400px;
    padding: 25px 30px;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(8px);
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.4);
  }

  .hero-text h1 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #3b3b98;
    margin-bottom: 12px;
    line-height: 1.3;
  }

  .hero-text p {
    font-size: 1rem;
    color: #555;
    font-weight: 600;
    line-height: 1.5;
  }

  /* ----- Info Cards ----- */
  .info-cards {
    padding: 60px 10%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
  }

  .card {
    background: #ffffffc9;
    backdrop-filter: blur(10px);
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.6);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
  }

  .card-icon {
    font-size: 2.4rem;
    margin-bottom: 15px;
    color: #bbdefb;
  }

  .card h3 {
    margin-bottom: 12px;
    font-size: 1.25rem;
    color: #3b3b98;
  }

  .card p {
    color: #555;
    line-height: 1.5;
  }

  

  /* ----- Footer ----- */
  footer {
    background: #3b3b98;
    color: #ffffffff;
    text-align: center;
    padding: 16px;
    margin-top: 100px;
    box-shadow: 0 -3px 10px rgba(0,0,0,0.05);
  }

  @media (max-width: 768px) {
    .hero-section {
      height: 55vh;
      min-height: 400px;
      max-height: 500px;
    }

    .hero-text {
      bottom: 30px;
      left: 25px;
      right: 25px;
      max-width: none;
      padding: 20px 25px;
    }

    .hero-text h1 {
      font-size: 1.3rem;
    }

    .hero-text p {
      font-size: 0.9rem;
    }

    .info-cards {
      padding: 40px 5%;
    }
  }
</style>


</head>
<body>
  <!-- Header/Navbar -->
  <header>
    <div class="Logo">
      <a href="{{ route('about') }}">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo Univida">
        <span class="Logo-text">Univida</span>
      </a>
    </div>
    <div class="nav-links">
      <a href="{{ route('login.user') }}"><button class="login-button">Iniciar Sesión</button></a>
    </div>
  </header>

  <!-- Sección con carrusel -->
  <section class="hero-section">
    <div class="carousel">
      <img src="{{ asset('img/imagen1.png') }}" class="active" alt="Fondo 1">
      <img src="{{ asset('img/imagen2.png') }}" alt="Fondo 2">
      <img src="{{ asset('img/imagen3.png') }}" alt="Fondo 3">
    </div>

    <div class="hero-text">
      <h1>Univida: Acompañamiento y prevención de violencia en la comunidad universitaria</h1>
      <p>Estamos aquí para escucharte, apoyarte y darte las herramientas que necesitas.</p>
    </div>
  </section>


  <footer>
    <p>&copy; 2025 Univida. Todos los derechos reservados.</p>
  </footer>

  <!-- Script del carrusel -->
  <script>
    let index = 0;
    const images = document.querySelectorAll(".carousel img");

    function startCarousel() {
      setInterval(() => {
        images[index].classList.remove("active");
        index = (index + 1) % images.length;
        images[index].classList.add("active");
      }, 5000);
    }

    window.addEventListener('DOMContentLoaded', startCarousel);
  </script>
</body>
</html>