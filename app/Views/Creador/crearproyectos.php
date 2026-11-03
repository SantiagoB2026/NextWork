<?= view('templates/header') ?>

<main style="padding: 20px; font-family: system-ui, -apple-system, sans-serif;">
<?php if ($id_usuario_logueado): ?>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">
        <h2 style="margin: 0; color: #333; font-weight: 600;">Mis Proyectos</h2>
        <button type="button" onclick="document.getElementById('formProyecto').style.display='block'" class="ew-btn" style="background-color: #28a745; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; cursor: pointer; transition: background 0.2s;">
            + Crear Nuevo Proyecto
        </button>
    </div>

    <!-- Mensajes de respuesta en Sesión -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Formulario oculto que aparece al dar click -->
    <div id="formProyecto" style="display:none; background-color: #ffffff; border: 1px solid #e0e0e0; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px; animation: fadeIn 0.3s ease;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 10px;">Nuevo Proyecto</h3>
        
        <form action="<?= base_url('desarrollador/proyectos/guardar') ?>" method="POST">
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
                <input type="number" name="dinero_conseguir" step="0.01" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
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
<?php endif; ?>
</main>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?= view('templates/footer') ?>
