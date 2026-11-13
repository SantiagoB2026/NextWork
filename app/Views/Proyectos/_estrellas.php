<?php
/** Promedio de calificaciones. Recibe $proy con: calificacion (promedio) y total_calificaciones */
$promedio = (float) ($proy['calificacion'] ?? 0);
$total    = (int) ($proy['total_calificaciones'] ?? 0);
$llenas   = (int) round($promedio);
?>
<div class="np-estrellas">
    <span class="np-estrellas__icons" aria-hidden="true"><?php for ($i = 1; $i <= 5; $i++): ?><span class="<?= $i <= $llenas ? 'on' : '' ?>">★</span><?php endfor; ?></span>
    <span class="np-estrellas__texto">
        <?php if ($total > 0): ?>
            <?= esc(number_format($promedio, 1, ',', '.')) ?> (<?= $total ?>)
        <?php else: ?>
            Sin calificaciones
        <?php endif; ?>
    </span>
</div>
