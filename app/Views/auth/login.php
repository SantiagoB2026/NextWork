<?= view('templates/header') ?>

<div>
    <div>
        <div>
            <h3>Iniciar Sesión</h3>

            <!-- Muestra el mensaje de éxito si el usuario viene directo de registrarse -->
            <?php if (session()->getFlashdata('exito')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('exito') ?>
                </div>
            <?php endif; ?>

            <!-- Muestra errores si las credenciales son incorrectas -->
            <?php if (session()->getFlashdata('errores')): ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="login" method="post">
                <?= csrf_field() ?>
                
                <div>
                    <label for="correo_electronico">Email:</label>
                    <input type="email" id="correo_electronico" name="correo_electronico" placeholder="ejemplo@correo.com" required value="<?= old('correo_electronico') ?>">
                </div>
                
                <div>
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword">
                        Mostrar
                    </button>
                </div>
                
                <button type="submit">Enviar</button>
            </form>
            
            <div>
                <p><a href="register">¿No tienes cuenta? Registrate aquí.</a></p>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>
<script>document.getElementById('btnTogglePassword').addEventListener('click', function () {
  const passwordInput = document.getElementById('contraseña');
  
  // Alternar el tipo de input
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    this.textContent = 'Ocultar';
  } else {
    passwordInput.type = 'password';
    this.textContent = 'Mostrar';
  }
});</script>