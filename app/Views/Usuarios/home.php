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
<div id="carouselExampleDark" class="carousel carousel-overlay slide" data-bs-theme="dark">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="..." class="d-block w-100 rounded-5" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="..." class="d-block w-100 rounded-5" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100 rounded-5" alt="...">
    </div>
  </div>
  <div class="carousel-overlay-controls">
    <button class="btn-icon btn-sm btn-subtle theme-secondary" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
      <span class="carousel-icon-prev" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <button class="btn-icon btn-sm btn-subtle theme-secondary" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
      <span class="carousel-icon-next" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
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



<?= view('templates/footer') ?>
