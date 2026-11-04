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

      <?php if ($es_el_propio_perfil): ?>
          <a href="<?= base_url('desarrollador/proyectos/nuevo') ?>" class="btn btn-primary">
              Crear Nuevo Proyecto
          </a>
      <?php endif; ?>

      <div class="ew-grid" id="ewGrid"></div>
      <div class="ew-empty" id="ewEmpty" hidden>
        No hay proyectos en esta categoría.
      </div>
    </section>

  </div>
</main>

<?= view('templates/footer') ?>
