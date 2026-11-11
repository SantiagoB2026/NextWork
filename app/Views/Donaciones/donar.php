<?= view('templates/header') ?>
<?php $idProyecto = (int) $proyecto['id_proyecto']; ?>

<main class="np-page np-page--angosta">
    <a class="np-volver" href="<?= site_url('proyecto/' . $idProyecto) ?>">&larr; Volver al proyecto</a>

    <h1 class="np-detalle__titulo">Donar a «<?= esc($proyecto['titulo']) ?>»</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="np-flash np-flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="np-panel">
        <?= view('Proyectos/_barra', ['proy' => $proyecto]) ?>

        <form action="<?= site_url('inversionista/proyectos/' . $idProyecto . '/donar') ?>" method="POST" class="np-form">
            <?= csrf_field() ?>

            <label for="monto" class="np-form__label">¿Cuánto quieres aportar? ($)</label>

            <div class="np-presets">
                <?php foreach ([10, 25, 50, 100] as $preset): ?>
                    <button type="button" class="np-preset" data-monto="<?= $preset ?>">$<?= $preset ?></button>
                <?php endforeach; ?>
            </div>

            <input type="number" id="monto" name="monto" class="np-form__input" min="1" step="0.01" required
                   placeholder="Otro monto" value="<?= esc(old('monto')) ?>">

            <button type="submit" class="np-btn np-btn--verde np-btn--block">Confirmar donación</button>
            <p class="np-nota">Al confirmar, tu aporte se suma de inmediato a la barra de progreso del proyecto.</p>
        </form>
    </div>
</main>

<script>
    // Los botones de monto rápido rellenan el campo
    document.querySelectorAll('.np-preset').forEach(function (boton) {
        boton.addEventListener('click', function () {
            document.getElementById('monto').value = this.dataset.monto;
        });
    });
</script>

<?= view('templates/footer') ?>
