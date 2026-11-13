<?= view('templates/header') ?>
<?php helper('proyectos'); ?>

<main class="np-page np-page--angosta">
    <h1 class="np-detalle__titulo">Mis inversiones</h1>
    <p class="np-card__autor">Total aportado: <strong><?= dinero($totalAportado) ?></strong></p>

    <?php if (! empty($aportes)): ?>
        <table class="np-tabla">
            <thead><tr><th>Proyecto</th><th>Mi aporte</th><th>Aportes</th><th>Último</th></tr></thead>
            <tbody>
                <?php foreach ($aportes as $a): ?>
                    <tr>
                        <td><a href="<?= site_url('proyecto/' . (int) $a['id_proyecto']) ?>"><?= esc($a['titulo']) ?></a><br>
                            <small>por <?= esc($a['autor']) ?></small></td>
                        <td><?= dinero($a['mi_aporte']) ?></td>
                        <td><?= (int) $a['veces'] ?></td>
                        <td><?= esc(date('d/m/Y', strtotime($a['ultimo']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="np-vacio">Todavía no has donado a ningún proyecto. <a href="<?= site_url('/') ?>#destacados">Mira los proyectos destacados</a>.</p>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
