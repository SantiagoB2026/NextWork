<?= view('templates/header') ?>

<main class="np-page">
    <div class="np-encabezado">
        <h2 class="np-detalle__titulo">#<?= esc($etiqueta['nombre']) ?></h2>
        <a class="np-volver" href="<?= site_url('etiquetas') ?>">Ver todas las etiquetas</a>
    </div>

    <?php if (! empty($proyectos)): ?>
        <div class="np-grid">
            <?php foreach ($proyectos as $proy): ?>
                <?= view('Proyectos/_tarjeta', ['proy' => $proy]) ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="np-vacio">Todavía no hay proyectos con esta etiqueta.</p>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
