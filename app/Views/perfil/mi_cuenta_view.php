<?= view('templates/header') ?>

<main class="ext-profile">
  <div class="ew-container">

    <!-- Mensajes de feedback -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div style="color: green; padding: 10px; background: #e6ffe6; margin-bottom: 10px; border-radius: 5px;">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red; padding: 10px; background: #ffe6e6; margin-bottom: 10px; border-radius: 5px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="ew-cover"></div>

    <!-- AVATAR MODIFICADO (Si hay foto, se inyecta el background-image y se oculta el texto interior) -->
    <div class="ew-avatar" id="ewAvatar" style="position: relative; overflow: hidden; background-size: cover; background-position: center; <?= (!empty($foto_perfil)) ? "background-image: url('".base_url('uploads/perfiles/'.$foto_perfil)."'); color: transparent;" : '' ?>">
      
      <!-- Solo muestra la inicial si NO hay una foto cargada -->
      <?php if (empty($foto_perfil)): ?>
          <?= esc(mb_strtoupper(mb_substr($alias ?? '', 0, 1))) ?>
      <?php endif; ?>

      <!-- Formulario para cambiar la foto (Solo visible para el dueño) -->
      <?php if ($es_el_propio_perfil): ?>
          <form action="<?= base_url('perfil/subirFoto') ?>" method="post" enctype="multipart/form-data" id="formFoto" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); padding: 5px 0; text-align: center; line-height: 1;">
              <?= csrf_field() ?>    
              <label for="inputFoto" style="color: white; cursor: pointer; font-size: 12px; display: block; width: 100%; margin: 0;">
                  📷 Cambiar
              </label>
              <input type="file" name="foto" id="inputFoto" accept="image/*" style="display: none;" onchange="document.getElementById('formFoto').submit();">
          </form>
      <?php endif; ?>
    </div>

    <!-- SECCIÓN DE PRESENTACIÓN GENERAL (Se corrigió la apertura que faltaba aquí) -->
    <section class="ew-profile-header">
      <div class="ew-creator">
        <h1 id="alias">
          <span><?= esc($alias) ?></span>
        </h1>
        <div class="ew-handle" id="ewHandle">
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
        <!-- Botón que  solo ve el dueño del perfil (desarrollador) -->
        <a href="<?= base_url('desarrollador/proyectos/nuevo') ?>" class="btn btn-primary">
          Crear Nuevo Proyecto
        </a>
      <?php elseif (! empty($limite_alcanzado)): ?>
        <p class="np-nota">Alcanzaste el máximo de <?= (int) $max_proyectos ?> proyectos.</p>
      <?php endif; ?>
    </section>
    <?php endif; ?>

  </div>
</main>
  <?= view('templates/footer') ?>