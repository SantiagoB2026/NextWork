<style>
.ext-profile {
  --ew-green: #00bd68;
  --ew-dark: #222;
  --ew-muted: #777;
  --ew-border: #e9e9e9;
  color: var(--ew-dark);
  font-family: Arial, Helvetica, sans-serif;
  padding: 35px 20px 70px;
  min-height: 650px;
  background: #fff;
}

.ext-profile * { box-sizing: border-box; }

.ew-container {
  max-width: 1120px;
  margin: auto;
}

/* Portada */
.ew-cover {
  height: 210px;
  border-radius: 8px;
  background:
    linear-gradient(110deg, #004b2b, #00bd68 60%, #b8f4d3);
  position: relative;
  overflow: hidden;
}

.ew-cover::before {
  content: "";
  position: absolute;
  width: 400px;
  height: 400px;
  border: 60px solid #ffffff13;
  border-radius: 50%;
  right: 5%;
  top: -210px;
}

.ew-cover::after {
  content: "EXTWORK";
  position: absolute;
  right: 30px;
  bottom: 20px;
  color: #ffffff35;
  font-size: clamp(25px, 5vw, 55px);
  font-weight: 900;
  letter-spacing: 3px;
}

/* Datos del creador */
.ew-profile-info {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  padding: 0 22px;
  margin-top: -43px;
  position: relative;
}

.ew-avatar {
  width: 100px;
  height: 100px;
  flex-shrink: 0;
  border-radius: 50%;
  border: 5px solid white;
  background: #e2f8eb;
  color: #009e56;
  display: grid;
  place-items: center;
  font-size: 35px;
  font-weight: 800;
}

.ew-creator {
  flex: 1;
  min-width: 180px;
  padding-top: 48px;
}

.ew-creator h1 {
  font-size: 27px;
  margin: 0 0 8px;
}

.ew-handle {
  color: var(--ew-muted);
  font-size: 14px;
}

.ew-verified {
  display: inline-block;
  color: #009f58;
  margin-left: 5px;
}

.ew-actions {
  display: flex;
  gap: 10px;
  padding-top: 45px;
}

.ew-btn {
  border: 1px solid var(--ew-green);
  border-radius: 5px;
  padding: 11px 19px;
  background: var(--ew-green);
  color: white;
  font-weight: 600;
  cursor: pointer;
  transition: .2s;
}

.ew-btn:hover { background: #009e58; }

.ew-btn-outline {
  color: #222;
  background: white;
  border-color: #ddd;
}

.ew-btn-outline:hover {
  background: #f5f5f5;
}

/* Biografía */
.ew-bio {
  margin: 23px 22px;
  max-width: 700px;
  line-height: 1.7;
  color: #555;
  font-size: 15px;
}

.ew-meta {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin: 0 22px 25px;
  color: #777;
  font-size: 13px;
}

.ew-meta span {
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Estadísticas */
.ew-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  border: 1px solid var(--ew-border);
  border-radius: 7px;
  margin: 0 0 42px;
}

.ew-stat {
  text-align: center;
  padding: 22px 10px;
}

.ew-stat + .ew-stat {
  border-left: 1px solid var(--ew-border);
}

.ew-stat strong {
  display: block;
  font-size: 25px;
  margin-bottom: 8px;
}

.ew-stat span {
  color: #777;
  font-size: 13px;
}

/* Proyectos */
.ew-section-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 20px;
}

.ew-section-title h2 {
  font-size: 23px;
  margin: 0;
}

.ew-project-count {
  font-size: 13px;
  color: #777;
}

.ew-tabs {
  display: flex;
  gap: 26px;
  border-bottom: 1px solid var(--ew-border);
  overflow-x: auto;
}

.ew-tab {
  padding: 14px 2px;
  background: transparent;
  border: 0;
  border-bottom: 3px solid transparent;
  color: #666;
  cursor: pointer;
  white-space: nowrap;
}

.ew-tab.active {
  color: #009f58;
  border-bottom-color: var(--ew-green);
  font-weight: 700;
}

.ew-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 22px;
  margin-top: 25px;
}

.ew-card {
  border: 1px solid var(--ew-border);
  border-radius: 7px;
  overflow: hidden;
  background: white;
  transition: .2s;
}

.ew-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px #0000000c;
}

.ew-project-img {
  height: 175px;
  background: #e8eee9;
  overflow: hidden;
  position: relative;
}

.ew-project-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.ew-badge {
  position: absolute;
  left: 12px;
  top: 12px;
  background: white;
  color: #008d4e;
  padding: 7px 10px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 700;
}

.ew-card-content { padding: 17px; }

.ew-category {
  color: #009f58;
  text-transform: uppercase;
  letter-spacing: .7px;
  font-size: 10px;
  font-weight: 700;
}

.ew-card h3 {
  margin: 9px 0;
  font-size: 18px;
}

.ew-description {
  color: #777;
  font-size: 13px;
  line-height: 1.6;
  min-height: 42px;
}

.ew-progress {
  height: 6px;
  background: #e8eee9;
  border-radius: 10px;
  overflow: hidden;
  margin: 19px 0 11px;
}

.ew-progress div {
  height: 100%;
  background: var(--ew-green);
}

.ew-progress-info {
  display: flex;
  justify-content: space-between;
  gap: 8px;
  font-size: 12px;
  color: #777;
}

.ew-progress-info strong { color: #008d4e; }

.ew-project-footer {
  border-top: 1px solid #eee;
  padding-top: 14px;
  margin-top: 15px;
  color: #777;
  font-size: 12px;
}

.ew-empty {
  padding: 30px 0;
  color: #777;
}

@media (max-width: 760px) {
  .ew-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .ew-profile-info { padding: 0 8px; gap: 12px; }
  .ew-creator h1 { font-size: 22px; }
  .ew-actions { padding-top: 5px; width: 100%; }
  .ew-actions button { flex: 1; }
  .ew-bio, .ew-meta { margin-left: 8px; margin-right: 8px; }
}

@media (max-width: 480px) {
  .ext-profile { padding: 20px 13px 45px; }
  .ew-cover { height: 155px; }
  .ew-grid { grid-template-columns: 1fr; }
  .ew-project-img { height: 210px; }
  .ew-avatar { width: 82px; height: 82px; font-size: 29px; }
  .ew-creator { min-width: 140px; }
  .ew-creator h1 { font-size: 20px; }
  .ew-stats { margin-bottom: 32px; }
  .ew-stat strong { font-size: 21px; }
  .ew-stat span { font-size: 11px; }
}
</style>
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
<?php if ($id_usuario_logueado === $id_cuenta_visitada): ?>
    <div style="margin: 20px 0;">
        <h2>Mis Proyectos</h2>
        <button type="button" onclick="document.getElementById('formProyecto').style.display='block'" class="ew-btn">
            + Crear Nuevo Proyecto
        </button>
    </div>

    <!-- Formulario oculto que aparece al dar click -->
    <div id="formProyecto" style="display:none; border: 1px solid #ccc; padding: 20px; border-radius: 8px; margin-top: 15px;">
        <h3>Nuevo Proyecto</h3>
        <!-- El action ahora apunta a la ruta correcta que procesará tu controlador -->
<form action="<?= base_url('perfil/guardarProyecto') ?>" method="POST" id="formProyecto">
    <?= csrf_field() ?>

    <!-- Bloque para mostrar errores si la base de datos o validación fallan -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 15px;">
        <label for="titulo" style="font-weight: bold;">Título del Proyecto:</label>
        <input type="text" 
               id="titulo"
               name="titulo" 
               value="<?= old('titulo') ?>" 
               required 
               maxlength="15" 
               style="width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="descripcion" style="font-weight: bold;">Descripción:</label>
        <textarea id="descripcion"
                  name="descripcion" 
                  required 
                  maxlength="500" 
                  style="width: 100%; padding: 8px; height: 120px; margin-top: 5px; box-sizing: border-box; resize: vertical;"><?= old('descripcion') ?></textarea>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="dinero_objetivo" style="font-weight: bold;">Dinero a conseguir ($):</label>
        <input type="number" 
               id="dinero_objetivo"
               name="dinero_objetivo" 
               value="<?= old('dinero_objetivo') ?>" 
               min="1" 
               required 
               style="width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box;">
    </div>

    <div style="display: flex; gap: 10px;">
        <button type="submit" class="ew-btn">Guardar Proyecto</button>
        <button type="button" 
                onclick="document.getElementById('formProyecto').style.display='none'" 
                style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; cursor: pointer; border-radius: 4px;">
            Cancelar
        </button>
    </div>
</form>

<?php endif; ?>

      <div class="ew-grid" id="ewGrid"></div>
      <div class="ew-empty" id="ewEmpty" hidden>
        No hay proyectos en esta categoría.
      </div>
    </section>

  </div>
</main>

<?= view('templates/footer') ?>


<!-- FIN DEL PERFIL EXTWORK -->

