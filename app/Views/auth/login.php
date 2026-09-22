<?= view('templates/header') ?>

<div>
    <div>
        <div>
            <h3>Iniciar Sesión</h3>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('exito')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
            <?php endif; ?>

            <form action="login" method="post">
                <div>
               <input type="email" placeholder="email"></input>
                </div>
                <div>
               <input type="text" placeholder="Contraseña" ></input>
                </div>
                <button type="submit">Enviar</button>
            <div>
            <p><a href="register">¿Ya tenés una cuenta? Registrate aquí.</a></p>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>