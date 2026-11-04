<?= view('templates/header') ?>

<main style="padding: 20px; max-width: 1000px; margin: 0 auto; font-family: system-ui, -apple-system, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 25px;">
        <h2 style="margin: 0; color: #333; font-weight: 600;">#<?= esc($etiqueta['nombre']) ?></h2>
        <a href="<?= site_url('etiquetas') ?>" style="color: #28a745; text-decoration: none; font-weight: 500;">Ver todas las etiquetas</a>
    </div>

    <?php if (! empty($proyectos)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            <?php foreach ($proyectos as $proy): ?>
                <article style="background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <h3 style="margin: 0 0 8px; color: #333;"><?= esc($proy['titulo']) ?></h3>
                    <p style="margin: 0 0 12px; color: #666; font-size: 14px;"><?= nl2br(esc($proy['descripcion'])) ?></p>
                    <p style="margin: 0 0 12px; font-size: 13px; color: #888;">
                        Por <strong><?= esc($proy['autor']) ?></strong> ·
                        Meta: $<?= number_format((float) $proy['dinero_conseguir'], 0, ',', '.') ?>
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <?php foreach ($proy['etiquetas'] as $et): ?>
                            <a href="<?= site_url('etiqueta/' . $et['slug']) ?>"
                               style="background: #e9f7ee; color: #1e7e34; padding: 3px 10px; border-radius: 999px; font-size: 12px; text-decoration: none;">
                                #<?= esc($et['nombre']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color: #777;">Todavía no hay proyectos con esta etiqueta.</p>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
