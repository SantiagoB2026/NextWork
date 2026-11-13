<?= view('templates/header') ?>

<main style="padding: 20px; font-family: system-ui, -apple-system, sans-serif;">
<?php if ($id_usuario_logueado): ?>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">
        <h2 style="margin: 0; color: #333; font-weight: 600;">Mis Proyectos</h2>
        <span class="np-nota">Proyectos activos: <?= (int) $proyectosActivos ?> de <?= (int) $maxProyectos ?></span>
        <?php if (empty($limiteAlcanzado)): ?>
        <button type="button" onclick="document.getElementById('formProyecto').style.display='block'" class="ew-btn" style="background-color: #28a745; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; cursor: pointer; transition: background 0.2s;">
            + Crear Nuevo Proyecto
        </button>
        <?php else: ?>
            <span class="np-chip-meta">Máximo de <?= (int) $maxProyectos ?> proyectos alcanzado</span>
        <?php endif; ?>
    </div>

    <!-- Mensajes de respuesta en Sesión -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="np-flash np-flash--ok"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>

    <!-- Formulario oculto que aparece al dar click -->
    <div id="formProyecto" style="display: <?= ! empty($abrirFormulario) ? 'block' : 'none' ?>; background-color: #ffffff; border: 1px solid #e0e0e0; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px; animation: fadeIn 0.3s ease;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 10px;">Nuevo Proyecto</h3>
        
        <form action="<?= base_url('desarrollador/proyectos/guardar') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div style="margin-bottom: 18px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 500; color: #555;">Título del proyecto:</label>
                <input type="text" name="titulo" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 500; color: #555;">Descripción:</label>
                <textarea name="descripcion" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; height: 120px; font-size: 14px; resize: vertical;"></textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 500; color: #555;">Dinero a conseguir ($):</label>
                <input type="number" name="dinero_conseguir" step="1" min="1" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 500; color: #555;">Etiquetas (máximo 5):</label>
                <?php if (! empty($etiquetas)): ?>
                    <div id="selectorEtiquetas" style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php foreach ($etiquetas as $et): ?>
                            <label style="display: inline-flex; align-items: center; gap: 6px; border: 1px solid #ccc; border-radius: 999px; padding: 6px 14px; cursor: pointer; font-size: 14px; color: #444;">
                                <input type="checkbox" name="etiquetas[]" value="<?= (int) $et['id_etiqueta'] ?>">
                                <?= esc($et['nombre']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <script>
                        // Limita la selección a 5 etiquetas (el servidor también lo valida)
                        document.getElementById('selectorEtiquetas').addEventListener('change', function () {
                            var marcadas = this.querySelectorAll('input:checked');
                            this.querySelectorAll('input:not(:checked)').forEach(function (i) {
                                i.disabled = marcadas.length >= 5;
                            });
                        });
                    </script>
                <?php else: ?>
                    <p style="margin: 0; color: #888; font-size: 14px;">Aún no hay etiquetas disponibles.</p>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 500; color: #555;">Imágenes (opcional, hasta <?= \App\Libraries\ImagenesProyecto::MAX_POR_PROYECTO ?>):</label>
                <input type="file" name="imagenes[]" accept="image/jpeg,image/png,image/webp" multiple style="font-size: 14px;">
                <p style="margin: 6px 0 0; color: #888; font-size: 13px;">JPG, PNG o WebP, de hasta 2 MB cada una. La primera será la portada.</p>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('formProyecto').style.display='none'" style="background-color: #e0e0e0; color: #333; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; cursor: pointer;">
                    Cancelar
                </button>
                <button type="submit" class="ew-btn" style="background-color: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; cursor: pointer;">
                    Guardar Proyecto
                </button>
            </div>
        </form>
    </div>
    <!-- Invitaciones a proyectos conjuntos -->
    <?php if (! empty($invitaciones)): ?>
        <section class="np-panel" style="margin-top: 25px;">
            <h2 class="np-subtitulo">Invitaciones a proyectos conjuntos</h2>
            <?php foreach ($invitaciones as $inv): ?>
                <div class="np-invitacion">
                    <span>
                        <strong>@<?= esc($inv['invitador'] ?? 'alguien') ?></strong> te invitó a colaborar en
                        <a href="<?= site_url('proyecto/' . (int) $inv['id_proyecto']) ?>">«<?= esc($inv['titulo']) ?>»</a>
                    </span>
                    <div class="np-invitacion__acciones">
                        <form action="<?= site_url('desarrollador/invitaciones/' . (int) $inv['id_proyecto'] . '/aceptar') ?>" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="np-btn np-btn--verde">Aceptar</button>
                        </form>
                        <form action="<?= site_url('desarrollador/invitaciones/' . (int) $inv['id_proyecto'] . '/rechazar') ?>" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="np-btn np-btn--gris">Rechazar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <!-- Mis proyectos publicados, con su barra de progreso -->
    <section style="margin-top: 35px;">
        <?php if (! empty($proyectos)): ?>
            <div class="np-grid">
                <?php foreach ($proyectos as $proy): ?>
                    <?= view('Proyectos/_tarjeta', ['proy' => $proy]) ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="np-vacio">Todavía no publicaste ningún proyecto.</p>
        <?php endif; ?>
    </section>
<?php endif; ?>
</main>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?= view('templates/footer') ?>
