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
        <div class="image-placeholder hero-image">IMG</div>
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
