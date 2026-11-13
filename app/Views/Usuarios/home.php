<?= view('templates/header') ?>
<style>

</style>
<main class="main-content">
    <!-- Contenedor dinámico según el estado de la sesión -->
    <div class="welcome-container">
        <!-- Bloque de bienvenida para usuarios NO logueados -->
        <?php if (session()->get('isLoggedIn')): ?>
        <!-- Insignia del rol del usuario -->
        <div class="user-badge">
            <?php if (session()->get('tipo') === 'inversionista'): ?>
                <h1 class="badge-title">Inversionista</h1>
            <?php elseif (session()->get('tipo') === 'desarrollador'): ?>
                <h1 class="badge-title">Desarrollador</h1>
            <?php elseif (session()->get('tipo') === 'admin'): ?>
                <h1 class="badge-title">Administrador</h1>
            <?php endif; ?>
        </div>
        <?php endif; ?>
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
<!-- CÓDIGO COMPLETO: EFECTO ESTELA DE ILUMINACIÓN INTERACTIVA VERDE -->

<div class="carousel-inner-css">
  
  <!-- SLIDE 1 (Fondo Negro con Estela de Luz Interactiva) -->
  <div class="carousel-item-css interactive-light-slide" id="auroraSlide">
    <!-- El lienzo donde se dibuja el rastro de luz neón -->
    <canvas id="lightCanvas"></canvas>
    
    <!-- Contenido frontal fijo (Textos y Botón) -->
    <div class="slide-content-overlay">
      <div>
        <img src="<?= base_url('assets/img/Logo_Nextwork_Blanco.png') ?>" alt="Nextwork">
      </div>

      <h2 class="main-title-text">
        Es hora de crear tu 
        <span>proyecto soñado</span>
      </h2>

      <button class="cta-btn-css">Botón</button>
    </div>
  </div>

  <!-- SLIDE 2 (Normal) -->
  <div class="carousel-item-css">
    <img src="../assets/img/2.png" class="img-slide" alt="Slide 2">
  </div>

  <!-- SLIDE 3 (Normal) -->
  <div class="carousel-item-css">
    <img src="../assets/img/3.png" class="img-slide" alt="Slide 3">
  </div>

</div>

<style>
  @import url('https://googleapis.com');

  /* Contenedor del Slide: Fondo Negro Absoluto */
  .carousel-item-css.interactive-light-slide {
    position: relative;
    overflow: hidden;
    height: 450px; /* Ajusta a la altura de tu carrusel */
    background-color: #000000; 
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Montserrat', sans-serif;
  }

  /* El Canvas se expande por todo el fondo del slide por debajo de las letras */
  #lightCanvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none; /* Deja pasar los eventos al contenedor padre */
  }

  /* Capa de interfaz de usuario por encima de la luz */
  .slide-content-overlay {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 35px 20px;
    color: #ffffff;
    text-align: center;
    pointer-events: none; /* Permite que el mouse traspase el texto y dibuje en todo el contenedor */
  }

  /* Forzamos que el botón sí sea clickeable */
  .cta-btn-css {
    pointer-events: auto;
  }

  /* Estilos de maquetación basados en tu imagen */
  .top-text { font-size: 13px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.8; margin-bottom: 5px; }
  .logo-text { font-size: 36px; font-weight: 900; letter-spacing: 4px; }

  .main-title-text {
    font-size: 42px;
    font-weight: 700;
    text-transform: uppercase;
    line-height: 1.1;
    color: transparent;
    -webkit-text-stroke: 2px #22c55e;
    filter: drop-shadow(0 0 15px rgba(34, 197, 94, 0.5));
  }

  .main-title-text span {
    display: block;
    font-family: 'Georgia', serif;
    font-style: italic;
    font-weight: normal;
    color: #ffffff;
    -webkit-text-stroke: 0px;
    text-transform: lowercase;
    margin-top: 2px;
  }

  .cta-btn-css {
    background-color: rgba(6, 78, 59, 0.6);
    border: 1px solid #10b981;
    color: #ffffff;
    padding: 10px 40px;
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 4px;
    cursor: pointer;
    backdrop-filter: blur(4px);
    transition: all 0.3s ease;
  }

  .cta-btn-css:hover {
    background-color: #10b981;
    box-shadow: 0 0 15px #10b981;
  }

  .img-slide { width: 100%; height: 450px; object-fit: cover; }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const slide = document.getElementById('auroraSlide');
    const canvas = document.getElementById('lightCanvas');
    const ctx = canvas.getContext('2d');

    // Configurar tamaño inicial del lienzo
    let width = canvas.width = slide.offsetWidth;
    let height = canvas.height = slide.offsetHeight;

    // Historial de posiciones del mouse para generar el trazo continuado
    let mouse = { x: 0, y: 0, lastX: 0, lastY: 0, active: false };

    window.addEventListener('resize', () => {
      width = canvas.width = slide.offsetWidth;
      height = canvas.height = slide.offsetHeight;
    });

    // Detectar entrada y movimiento del cursor
    slide.addEventListener('mouseenter', (e) => {
      const rect = slide.getBoundingClientRect();
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;
      mouse.lastX = mouse.x;
      mouse.lastY = mouse.y;
      mouse.active = true;
    });

    slide.addEventListener('mousemove', (e) => {
      const rect = slide.getBoundingClientRect();
      mouse.lastX = mouse.x;
      mouse.lastY = mouse.y;
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;
      mouse.active = true;
    });

    slide.addEventListener('mouseleave', () => {
      mouse.active = false;
    });

    // Bucle de animación (Ejecución constante a 60fps)
    function drawLoop() {
      // El truco de la estela: En lugar de borrar todo el lienzo, pintamos un rectángulo negro semitransparente.
      // Un valor menor (ej. 0.05) dejará una estela más larga. Un valor mayor (ej. 0.15) la desvanecerá más rápido.
      ctx.fillStyle = 'rgba(0, 0, 0, 0.08)';
      ctx.fillRect(0, 0, width, height);

      if (mouse.active) {
        ctx.save();
        
        // Modo 'screen' hace que las luces neón se sumen de forma brillante y orgánica
        ctx.globalCompositeOperation = 'screen';

        // Creamos un degradado radial (brillo circular) centrado en la punta del mouse
        let radius = 90; // Tamaño de la iluminación de la linterna
        let glow = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, radius);
        
        // Colores del destello de neón (verde intenso al centro, transparente hacia afuera)
        glow.addColorStop(0, 'rgba(34, 197, 94, 1)');      /* Verde centro brillante */
        glow.addColorStop(0.2, 'rgba(16, 185, 129, 0.6)');  /* Verde esmeralda */
        glow.addColorStop(0.6, 'rgba(34, 197, 94, 0.15)');  /* Difuminado suave */
        glow.addColorStop(1, 'rgba(0, 0, 0, 0)');           /* Desvanecimiento total */

        ctx.strokeStyle = glow;
        ctx.lineWidth = radius * 1.5; // Ancho del trazo iluminado
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Dibujar la línea de luz uniendo la última posición con la actual
        ctx.beginPath();
        ctx.moveTo(mouse.lastX, mouse.lastY);
        ctx.lineTo(mouse.x, mouse.y);
        ctx.stroke();

        ctx.restore();

        // Igualar posiciones para mantener fluidez matemática en el siguiente cuadro
        mouse.lastX = mouse.x;
        mouse.lastY = mouse.y;
      }

      requestAnimationFrame(drawLoop);
    }

    // Arrancar el renderizado
    drawLoop();
  });
</script>

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

    <!-- Sección 2: Proyectos destacados (los que más dinero llevan recaudado) -->
    <section class="mockup-section" id="destacados">
        <h2 class="section-title">Proyectos destacados</h2>
        <?php if (! empty($destacados)): ?>
            <div class="np-grid">
                <?php foreach ($destacados as $proy): ?>
                    <?= view('Proyectos/_tarjeta', ['proy' => $proy]) ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="np-vacio">Todavía no hay proyectos publicados.</p>
        <?php endif; ?>
    </section>
</main>

<script>
  const carousel = new bootstrap.Carousel('#myCarousel')
</script>
<?= view('templates/footer') ?>
