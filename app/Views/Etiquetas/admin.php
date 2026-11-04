<?= view('templates/header') ?>

<main style="padding: 20px; max-width: 800px; margin: 0 auto; font-family: system-ui, -apple-system, sans-serif;">
    <h2 style="margin: 0 0 25px; color: #333; font-weight: 600; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">
        Administrar etiquetas
    </h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('exito')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <?= esc(session()->getFlashdata('exito')) ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('Administrador/etiquetas/guardar') ?>" method="POST" style="display: flex; gap: 10px; margin-bottom: 30px;">
        <?= csrf_field() ?>
        <input type="text" name="nombre" maxlength="30" required placeholder="Nombre de la nueva etiqueta"
               value="<?= esc(old('nombre')) ?>"
               style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        <button type="submit" style="background-color: #28a745; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; cursor: pointer;">
            Crear etiqueta
        </button>
    </form>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee; color: #555;">
                <th style="padding: 10px;">Etiqueta</th>
                <th style="padding: 10px;">URL</th>
                <th style="padding: 10px;">Proyectos</th>
                <th style="padding: 10px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etiquetas as $et): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 10px;"><?= esc($et['nombre']) ?></td>
                    <td style="padding: 10px; color: #888;">/etiqueta/<?= esc($et['slug']) ?></td>
                    <td style="padding: 10px;"><?= (int) $et['total_proyectos'] ?></td>
                    <td style="padding: 10px; text-align: right;">
                        <form action="<?= site_url('Administrador/etiquetas/eliminar/' . (int) $et['id_etiqueta']) ?>" method="POST"
                              onsubmit="return confirm('¿Eliminar la etiqueta «<?= esc($et['nombre'], 'js') ?>»? Se quitará de todos los proyectos.');">
                            <?= csrf_field() ?>
                            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($etiquetas)): ?>
                <tr><td colspan="4" style="padding: 15px; color: #777;">Todavía no hay etiquetas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?= view('templates/footer') ?>
