<?= view('templates/header') ?>
<?php
helper('proyectos');
$idProyecto = (int) $proyecto['id_proyecto'];
$falta      = max(0, (float) $proyecto['dinero_conseguir'] - (float) $proyecto['recaudado']);
?>

<main class="np-page">
    <?php if (session()->getFlashdata('exito')): ?>
        <div class="np-flash np-flash--ok"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="np-flash np-flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <a class="np-volver" href="<?= site_url('/') ?>">&larr; Volver al inicio</a>

    <div class="np-detalle">
        <section class="np-detalle__main">
            <?php if ($tipo === 'inversionista'): ?>
                <span class="np-insignia">Vista de inversionista</span>
            <?php elseif ($esDueno): ?>
                <span class="np-insignia">Tu proyecto</span>
            <?php endif; ?>

            <h1 class="np-detalle__titulo"><?= esc($proyecto['titulo']) ?></h1>
            <p class="np-card__autor">
                por <strong><?= esc($proyecto['autor']) ?></strong>
                · publicado el <?= esc(date('d/m/Y', strtotime($proyecto['fecha_publicacion']))) ?>
            </p>

            <?php if (! empty($proyecto['etiquetas'])): ?>
                <div class="np-tags">
                    <?php foreach ($proyecto['etiquetas'] as $et): ?>
                        <a class="np-tag" href="<?= site_url('etiqueta/' . $et['slug']) ?>">#<?= esc($et['nombre']) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <p class="np-detalle__desc"><?= nl2br(esc($proyecto['descripcion'])) ?></p>
        </section>

        <aside class="np-panel">
            <?= view('Proyectos/_barra', ['proy' => $proyecto]) ?>

            <ul class="np-stats">
                <li><strong><?= (int) $proyecto['donantes'] ?></strong> <?= ((int) $proyecto['donantes'] === 1) ? 'inversionista' : 'inversionistas' ?></li>
                <li><strong><?= (int) $proyecto['total_donaciones'] ?></strong> <?= ((int) $proyecto['total_donaciones'] === 1) ? 'aporte' : 'aportes' ?></li>
                <li>
                    <?php if ($falta > 0): ?>
                        Faltan <strong><?= dinero($falta) ?></strong>
                    <?php else: ?>
                        <strong>¡Meta alcanzada!</strong>
                    <?php endif; ?>
                </li>
            </ul>

            <?php if ($tipo === 'inversionista'): ?>
                <?php if ($miAporte > 0): ?>
                    <p class="np-miaporte">Tu aporte hasta ahora: <strong><?= dinero($miAporte) ?></strong></p>
                <?php endif; ?>
                <a class="np-btn np-btn--verde np-btn--block" href="<?= site_url('inversionista/proyectos/' . $idProyecto . '/donar') ?>">
                    Donar a este proyecto
                </a>
            <?php elseif ($esDueno): ?>
                <p class="np-nota">Así ven los inversionistas tu proyecto. La barra se llena con cada donación.</p>
            <?php elseif ($tipo === null): ?>
                <a class="np-btn np-btn--verde np-btn--block" href="<?= site_url('login') ?>">Inicia sesión para donar</a>
                <p class="np-nota">Solo las cuentas de inversionista pueden donar.</p>
            <?php else: ?>
                <p class="np-nota">Solo las cuentas de inversionista pueden donar a los proyectos.</p>
            <?php endif; ?>
        </aside>
    </div>

    <?php if ($esDueno): ?>
        <section class="np-panel np-panel--ancho">
            <h2 class="np-subtitulo">Últimos aportes</h2>
            <?php if (! empty($recientes)): ?>
                <table class="np-tabla">
                    <thead><tr><th>Inversionista</th><th>Monto</th><th>Fecha</th></tr></thead>
                    <tbody>
                        <?php foreach ($recientes as $r): ?>
                            <tr>
                                <td><?= esc($r['alias'] ?? 'Cuenta eliminada') ?></td>
                                <td><?= dinero($r['monto']) ?></td>
                                <td><?= esc(date('d/m/Y H:i', strtotime($r['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="np-vacio">Todavía no hay aportes en este proyecto.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
