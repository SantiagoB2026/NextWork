<?= view('templates/header') ?>
<main>
<?php if ($id_usuario_logueado): ?>
    <div style="margin: 20px 0;">
        <h2>Mis Proyectos</h2>
        <button type="button" onclick="document.getElementById('formProyecto').style.display='block'" class="ew-btn">
            + Crear Nuevo Proyecto
        </button>
    </div>

    <!-- Formulario oculto que aparece al dar click -->
    <div id="formProyecto" style="display:none; border: 1px solid #ccc; padding: 20px; border-radius: 8px; margin-top: 15px;">
        <h3>Nuevo Proyecto</h3>
        <form action="<?= base_url('desarrollador/perfil/guardarProyecto') ?>" method="POST">
            <?= csrf_field() ?>

            <div style="margin-bottom: 10px;">
                <label>Título:</label><br>
                <input type="text" name="titulo" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label>Descripción:</label><br>
                <textarea name="descripcion" required style="width: 100%; padding: 8px; height: 100px Meso;"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Dinero a conseguir ($):</label><br>
                <input type="number" name="dinero_conseguir" step="0.01" required style="width: 100%; padding: 8px;">
            </div>

            <button type="submit" class="ew-btn">Guardar Proyecto</button>
            <button type="button" onclick="document.getElementById('formProyecto').style.display='none'">Cancelar</button>
        </form>
    </div>
<?php endif; ?>
</main>

<?= view('templates/footer') ?>
