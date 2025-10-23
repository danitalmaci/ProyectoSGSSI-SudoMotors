<?php 
  $pageTitle = "Inicio - SudoMotors";
  include("includes/head.php");
?>

<style>
  /* --- Ajustes solo para esta página --- */
  body {
    display: block;
    text-align: left;
  }
  main {
    max-width: none;
    padding: 0;
  }

  /* --- Banner superior --- */
  .header-banner {
    background-color: #ff7b00; /* Naranja principal */
    color: white;
    text-align: center;
    padding: 1.5rem 0;
    font-size: 1.8rem;
    font-weight: bold;
  }

  /* --- Contenedor principal dividido --- */
  .main-container {
    display: flex;
    flex-wrap: wrap;
    border-top: 2px solid #000;
  }

  .left-column, .right-column {
    flex: 1;
    min-width: 300px;
    padding: 2rem;
    box-sizing: border-box;
  }

  /* --- Slider --- */
  .slider {
    position: relative;
    overflow: hidden;
  }
  .slides {
    display: flex;
    transition: transform 0.4s ease-in-out;
  }
  .slide {
    min-width: 100%;
    opacity: 0;
    transition: opacity 0.4s;
  }
  .slide.active {
    opacity: 1;
  }
  .slide img {
    width: 100%;
    max-height: 250px;
    object-fit: contain;
  }
  .prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #000;
  }
  .prev { left: 10px; }
  .next { right: 10px; }

  /* --- Dots --- */
  .dots {
    text-align: center;
    margin-top: 10px;
  }
  .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 0 4px;
    border-radius: 50%;
    background: #ccc;
    cursor: pointer;
  }
  .dot.active {
    background: #ff7b00;
  }

  /* --- Botones --- */
  .btn, .contrast {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background: #ff7b00;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 1rem;
  }
  .btn:hover {
    background: #e86c00;
  }

  .catalog-button {
    text-align: center;
    margin-top: 1rem;
  }

  .right-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
  }
</style>

<header class="header-banner">
  SUDOMOTORS
</header>

<section class="main-container">
  <!-- Columna izquierda -->
  <div class="left-column">
    <div class="slider">
      <div class="slides">
        <div class="slide active">
          <img src="/media/coche1.png" alt="Auto 1">
        </div>
        <div class="slide">
          <img src="/media/coche2.png" alt="Auto 2">
        </div>
        <div class="slide">
          <img src="/media/coche3.png" alt="Auto 3">
        </div>
      </div>

      <button class="prev">&#10094;</button>
      <button class="next">&#10095;</button>

      <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>

    <div class="catalog-button">
      <a href="items.php" class="btn">Ver catálogo</a>
    </div>
  </div>

  <!-- Columna derecha -->
  <div class="right-column">
    <a href="login.php" class="btn">Iniciar sesión</a>
    <a href="register.php" class="btn">Registrarse</a>
  </div>
</section>

<?php include("includes/footer.php"); ?>

<!-- Script slider -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  let slides = document.querySelectorAll(".slide");
  let dots = document.querySelectorAll(".dot");
  let current = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
      dots[i].classList.toggle("active", i === index);
    });
  }

  document.querySelector(".next").addEventListener("click", () => {
    current = (current + 1) % slides.length;
    showSlide(current);
  });

  document.querySelector(".prev").addEventListener("click", () => {
    current = (current - 1 + slides.length) % slides.length;
    showSlide(current);
  });

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      current = i;
      showSlide(current);
    });
  });
});
</script>
