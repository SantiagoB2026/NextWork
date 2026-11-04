<?= view('templates/header') ?>

<main style="padding: 20px; max-width: 1000px; margin: 0 auto; font-family: system-ui, -apple-system, sans-serif;">
    <h2 style="margin: 0 0 25px; color: #333; font-weight: 600; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">
        Descubrir por etiqueta
    </h2>

    <?php if (! empty($etiquetas)): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
            <?php foreach ($etiquetas as $et): ?>
                <a href="<?= site_url('etiqueta/' . $et['slug']) ?>"
                   style="background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 12px 18px; text-decoration: none; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <strong>#<?= esc($et['nombre']) ?></strong>
                    <span style="color: #888; font-size: 13px;">
                        · <?= (int) $et['total_proyectos'] ?> <?= ((int) $et['total_proyectos'] === 1) ? 'proyecto' : 'proyectos' ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color: #777;">Aún no hay etiquetas creadas.</p>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
