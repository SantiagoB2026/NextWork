<?= view('templates/header') ?>

<main class="main-content">
    <!-- Contenedor dinámico según el estado de la sesión -->
    <div class="welcome-container">
        <!-- Bloque de bienvenida para usuarios NO logueados -->
        <?php if (!session()->get('isLoggedIn')): ?>
        

        <!-- Insignia del rol del usuario (Inversionista / Desarrollador) -->
        <div class="user-badge">
            <?php if (session()->get('tipo') === 'inversionista'): ?>
                <h1 class="badge-title">Inversionista</h1>
            <?php elseif (session()->get('tipo') === 'desarrollador'): ?>
                <h1 class="badge-title">Desarrollador</h1>
            <?php endif; ?>
        </div>
    </div>

    <!-- ESTRUCTURA DEL PROTOTIPO GRÁFICO -->
    <!-- Sección 1: Bloque Principal -->
    <section class="mockup-section">
        <h2 class="section-title">Haz tus proyectos realidad</h2>
<div class="carrusel-contenedor">
  <!-- 1. Controladores ocultos para saber en qué diapositiva estamos -->
  <input type="radio" name="carrusel-grupo" id="slide-control-1" checked>
  <input type="radio" name="carrusel-grupo" id="slide-control-2">
  <input type="radio" name="carrusel-grupo" id="slide-control-3">

  <!-- 2. Contenedor de las imágenes que se van a mover -->
  <div class="carousel-inner-css">
    <div class="carousel-item-css">
      <img src="../assets/img/idea.png" class="img-slide" alt="Slide 1">
    </div>
    <div class="carousel-item-css">
      <img src="../assets/img/idea.png" class="img-slide" alt="Slide 2">
    </div>
    <div class="carousel-item-css">
      <img src="..." class="img-slide" alt="Slide 3">
    </div>
  </div>

  <!-- 3. Flechas estáticas (cada par se muestra solo cuando corresponde) -->
  <div class="carousel-arrows-static">
    <!-- Flechas que aparecen cuando está activo el Slide 1 -->
    <div class="arrows-set set-1">
      <label for="slide-control-3" class="btn-flecha prev">&#10094;</label>
      <label for="slide-control-2" class="btn-flecha next">&#10095;</label>
    </div>
    
    <!-- Flechas que aparecen cuando está activo el Slide 2 -->
    <div class="arrows-set set-2">
      <label for="slide-control-1" class="btn-flecha prev">&#10094;</label>
      <label for="slide-control-3" class="btn-flecha next">&#10095;</label>
    </div>

    <!-- Flechas que aparecen cuando está activo el Slide 3 -->
    <div class="arrows-set set-3">
      <label for="slide-control-2" class="btn-flecha prev">&#10094;</label>
      <label for="slide-control-1" class="btn-flecha next">&#10095;</label>
    </div>
  </div>
</div>


    </section>

    <!-- Sección 2: Bloque de Proyectos Destacados -->
    <section class="mockup-section">
        <h2 class="section-title">Proyectos destacados</h2>
        <div class="projects-grid">
            <div class="image-placeholder project-card">IMG</div>
            <div class="image-placeholder project-card">IMG</div>
        </div>
    </section>
</main>
<?php endif; ?>

<script>
  const carousel = new bootstrap.Carousel('#myCarousel')
</script>
<?= view('templates/footer') ?>
