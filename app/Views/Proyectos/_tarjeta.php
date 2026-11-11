<?php
/** Tarjeta de proyecto. Recibe $proy (con 'etiquetas' y los datos de progreso) */
helper('proyectos');
$urlProyecto = site_url('proyecto/' . (int) $proy['id_proyecto']);
?>
<article class="np-card">
    <h3 class="np-card__title"><a href="<?= $urlProyecto ?>"><?= esc($proy['titulo']) ?></a></h3>
    <p class="np-card__autor">por <strong><?= esc($proy['autor']) ?></strong></p>
    <p class="np-card__desc"><?= esc($proy['descripcion']) ?></p>

    <?php if (! empty($proy['etiquetas'])): ?>
        <div class="np-tags">
            <?php foreach ($proy['etiquetas'] as $et): ?>
                <a class="np-tag" href="<?= site_url('etiqueta/' . $et['slug']) ?>">#<?= esc($et['nombre']) ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= view('Proyectos/_barra', ['proy' => $proy]) ?>

    <a class="np-btn np-btn--verde np-card__cta" href="<?= $urlProyecto ?>">Ver proyecto</a>
</article>
