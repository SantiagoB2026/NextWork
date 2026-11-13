<?= view('templates/header') ?>

<main class="np-page np-page--angosta">
    <h1 class="np-detalle__titulo">Mensajes</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="np-flash np-flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (! empty($conversaciones)): ?>
        <ul class="np-conv">
            <?php foreach ($conversaciones as $c): ?>
                <li>
                    <a class="np-conv__item" href="<?= site_url('mensajes/' . (int) $c['id_usuario']) ?>">
                        <span class="np-avatar"><?= esc(mb_strtoupper(mb_substr($c['alias'], 0, 1))) ?></span>
                        <span class="np-conv__info">
                            <span class="np-conv__nombre">
                                @<?= esc($c['alias']) ?>
                                <small class="np-conv__rol"><?= esc(ucfirst($c['tipo'])) ?></small>
                            </span>
                            <span class="np-conv__texto">
                                <?= ((int) $c['ultimo_emisor'] !== (int) session()->get('id')) ? '' : 'Tú: ' ?><?= esc(mb_strimwidth($c['ultimo_texto'], 0, 60, '…')) ?>
                            </span>
                        </span>
                        <span class="np-conv__lado">
                            <small><?= esc(date('d/m H:i', strtotime($c['ultima_fecha']))) ?></small>
                            <?php if ((int) $c['no_leidos'] > 0): ?>
                                <span class="np-badge"><?= (int) $c['no_leidos'] ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="np-vacio">
            Todavía no tienes conversaciones. Entra a un proyecto y toca «Escribir», o busca a alguien con el buscador.
        </p>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
