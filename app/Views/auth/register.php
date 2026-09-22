<?= view('templates/header') ?>

<div>
    <div>
        <div>
            <h3>Registro de Usuario</h3>

            <?php if (session()->getFlashdata('errores')): ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="register" method="post">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                </div>
                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                </div>
                <button type="submit">Registrar</button>
            </form>
            <div>
                <p><a href="login">¿No tenés una cuenta? Inicia sesión aquí.</a></p>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>
