<?php
/** Tarjeta de proyecto. Recibe $proy (con 'etiquetas' y los datos de progreso) */
helper('proyectos');
$urlProyecto = site_url('proyecto/' . (int) $proy['id_proyecto']);
?>
<article class="np-card">
    <?php if (! empty($proy['portada'])): ?>
        <a href="<?= $urlProyecto ?>">
            <img class="np-card__img" src="<?= base_url('uploads/proyectos/' . $proy['portada']) ?>"
                 alt="<?= esc($proy['titulo']) ?>" loading="lazy">
        </a>
    <?php endif; ?>

    <?php if (! empty($proy['financiado_at'])): ?>
        <span class="np-chip-meta">Meta alcanzada</span>
    <?php endif; ?>

    <h3 class="np-card__title"><a href="<?= $urlProyecto ?>"><?= esc($proy['titulo']) ?></a></h3>
    <p class="np-card__autor">por <strong><?= esc($proy['autor']) ?></strong></p>
    <p class="np-card__desc"><?= esc($proy['descripcion']) ?></p>

    <?= view('Proyectos/_estrellas', ['proy' => $proy]) ?>

    <?php if (! empty($proy['etiquetas'])): ?>
        <div class="np-tags">
            <?php foreach ($proy['etiquetas'] as $et): ?>
                <a class="np-tag" href="<?= site_url('etiqueta/' . $et['slug']) ?>">#<?= esc($et['nombre']) ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= view('Proyectos/_barra', ['proy' => $proy]) ?>

    <?php if (isset($proy['mi_aporte'])): ?>
        <p class="np-card__aporte">Tu aporte: <?= dinero($proy['mi_aporte']) ?></p>
    <?php endif; ?>

    <a class="np-btn np-btn--verde np-card__cta" href="<?= $urlProyecto ?>">Ver proyecto</a>
</article>
