<?= view('templates/header') ?>

<main class="ext-profile">
  <div class="ew-container">

    <div class="ew-cover"></div>

    <div class="ew-avatar" id="ewAvatar">
      <!-- Ahora usa la variable $alias que viene limpia del controlador -->
      <?= esc(mb_strtoupper(mb_substr($alias ?? '', 0, 1))) ?>
    </div>

      <div class="ew-creator">
        <h1 id="alias">
          <!-- Muestra el alias procesado (o el nombre como respaldo si no había alias) -->
          <span><?= esc($alias) ?></span>
        </h1>
        <div class="ew-handle" id="ewHandle">
          <!-- Saludo con el primer nombre -->
          <span><?= esc(strtok($nombre ?? '', ' ')) ?>!!!</span>
        </div>
      </div>

      <div class="ew-actions">
<?php if ($id_usuario_logueado !== $id_cuenta_visitada): ?>
    <button class="ew-btn" id="ewFollow" onclick="ewToggleFollow()">
        + Seguir
    </button>
<?php endif; ?>

        <button class="ew-btn ew-btn-outline" onclick="ewShare()">
          Compartir ↗
        </button>
      </div>
    </section>

    <p class="ew-bio" id="ewBio">
      Soy un creador independiente que busca convertir grandes ideas
      en proyectos reales. Explora mis proyectos y acompáñame
      en el proceso de hacerlos realidad.
    </p>

    <div class="ew-meta">
      <span>◷ Miembro desde 2026</span>
      <span>⌖ Argentina</span>
      <span>✉ Creador independiente</span>
    </div>

    <section class="ew-stats">
      <div class="ew-stat">
        <strong id="ewFollowers">0</strong>
        <span>Seguidores</span>
      </div>
      <div class="ew-stat">
        <strong>0</strong>
        <span>Proyectos publicados</span>
      </div>
      <div class="ew-stat">
        <strong>$0</strong>
        <span>Fondos recaudados</span>
      </div>
    </section>

    <section id="ewProjects">
      <div class="ew-section-title">
        <h2>Proyectos del creador</h2>

      </div>

      <div class="ew-tabs">
        <button class="ew-tab active" onclick="ewFilter('all',this)">Todos</button>
        <button class="ew-tab" onclick="ewFilter('live',this)">En financiación</button>
        <button class="ew-tab" onclick="ewFilter('soon',this)">Próximamente</button>
        <button class="ew-tab" onclick="ewFilter('finished',this)">Finalizados</button>
      </div>
<!-- Botón que solo ve el dueño del perfil -->
<a href="<?= base_url('desarrollador/proyectos/nuevo') ?>" class="btn btn-primary">
    Crear Nuevo Proyecto
</a>

      <div class="ew-grid" id="ewGrid"></div>
      <div class="ew-empty" id="ewEmpty" hidden>
        No hay proyectos en esta categoría.
      </div>
    </section>

  </div>
</main>

<?= view('templates/footer') ?>


<!-- FIN DEL PERFIL EXTWORK -->

