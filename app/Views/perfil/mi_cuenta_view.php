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
<?php if (! $es_el_propio_perfil): ?>
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
      <?php if ($tipo === 'inversionista'): ?>
        Inversionista en Nextwork. Apoyo los proyectos que creo que pueden convertir
        grandes ideas en realidad.
      <?php else: ?>
        Soy un creador independiente que busca convertir grandes ideas
      en proyectos reales. Explora mis proyectos y acompáñame
      en el proceso de hacerlos realidad.
      <?php endif; ?>
    </p>

    <div class="ew-meta">
      <span>◷ Miembro desde 2026</span>
      <span>⌖ Argentina</span>
      <span>✉ <?= $tipo === 'inversionista' ? 'Inversionista' : 'Creador independiente' ?></span>
    </div>

    <?php helper('proyectos'); ?>
    <section class="ew-stats">
      <div class="ew-stat">
        <strong id="ewFollowers">0</strong>
        <span>Seguidores</span>
      </div>
      <?php if ($tipo === 'desarrollador'): ?>
        <div class="ew-stat">
          <strong><?= (int) $stats['publicados'] ?></strong>
          <span>Proyectos publicados</span>
        </div>
        <div class="ew-stat">
          <strong><?= dinero($stats['fondos']) ?></strong>
          <span>Fondos recaudados</span>
        </div>
      <?php elseif ($tipo === 'inversionista' && $es_el_propio_perfil): ?>
        <div class="ew-stat">
          <strong><?= (int) $stats['invertidos'] ?></strong>
          <span>Proyectos invertidos</span>
        </div>
        <div class="ew-stat">
          <strong><?= dinero($stats['donado']) ?></strong>
          <span>Dinero donado</span>
        </div>
      <?php endif; ?>
    </section>

    <?php if ($tipo === 'desarrollador' || ($tipo === 'inversionista' && $es_el_propio_perfil)): ?>
    <section id="ewProjects">
      <div class="ew-section-title">
        <h2><?= $tipo === 'desarrollador' ? 'Proyectos del creador' : 'Proyectos invertidos' ?></h2>
      </div>

      <?php if (! empty($proyectos)): ?>
        <div class="ew-tabs">
          <button class="ew-tab active" onclick="npFiltrarPerfil('all', this)">Todos</button>
          <button class="ew-tab" onclick="npFiltrarPerfil('live', this)">En financiación</button>
          <button class="ew-tab" onclick="npFiltrarPerfil('finished', this)">Finalizados</button>
        </div>

        <div class="np-grid" id="ewGrid">
          <?php foreach ($proyectos as $proy): ?>
            <div data-estado="<?= ! empty($proy['financiado_at']) ? 'finished' : 'live' ?>">
              <?= view('Proyectos/_tarjeta', ['proy' => $proy]) ?>
            </div>
          <?php endforeach; ?>
        </div>

        <script>
          function npFiltrarPerfil(estado, boton) {
            document.querySelectorAll('.ew-tab').forEach(function (t) { t.classList.remove('active'); });
            boton.classList.add('active');
            document.querySelectorAll('#ewGrid [data-estado]').forEach(function (c) {
              c.style.display = (estado === 'all' || c.dataset.estado === estado) ? '' : 'none';
            });
          }
        </script>
      <?php else: ?>
        <p class="np-vacio">
          <?= $tipo === 'desarrollador' ? 'Todavía no hay proyectos publicados.' : 'Todavía no invertiste en ningún proyecto.' ?>
        </p>
      <?php endif; ?>

      <?php if (! empty($puede_crear)): ?>
        <!-- Botón que solo ve el dueño del perfil (desarrollador) -->
        <a href="<?= base_url('desarrollador/proyectos/nuevo') ?>" class="btn btn-primary">
          Crear Nuevo Proyecto
        </a>
      <?php elseif (! empty($limite_alcanzado)): ?>
        <p class="np-nota">Alcanzaste el máximo de <?= (int) $max_proyectos ?> proyectos.</p>
      <?php endif; ?>
    </section>
    <?php endif; ?>

  </div>

  <?= view('templates/footer') ?>
</main>




<!-- FIN DEL PERFIL EXTWORK -->

