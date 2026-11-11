<?php
/** Barra de progreso. Recibe $proy con: recaudado, dinero_conseguir, porcentaje */
helper('proyectos');
$cumplida = (float) $proy['porcentaje'] >= 100;
?>
<div class="np-progreso">
    <div class="np-barra" role="progressbar" aria-label="Progreso de financiación"
         aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= (int) round(min(100, (float) $proy['porcentaje'])) ?>">
        <div class="np-barra__relleno<?= $cumplida ? ' np-barra__relleno--meta' : '' ?>"
             style="--ancho: <?= ancho_barra($proy['porcentaje']) ?>%"></div>
    </div>
    <div class="np-progreso__texto">
        <span><strong><?= dinero($proy['recaudado']) ?></strong> de <?= dinero($proy['dinero_conseguir']) ?></span>
        <span class="np-progreso__pct"><?= porcentaje_texto($proy['porcentaje']) ?>%</span>
    </div>
</div>
