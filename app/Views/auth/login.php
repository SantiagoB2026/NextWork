<?= view('templates/header') ?>

<div class="login-page-wrapper">
    <div class="login-card">
        <h3 class="card-title">Iniciar Sesión</h3>
        <p class="login-subtitle">Ingresa tus credenciales de Nextwork.</p>

        <!-- Muestra el mensaje de éxito si el usuario viene directo de registrarse -->
        <?php if (session()->getFlashdata('exito')): ?>
            <div class="success-alert">
                <?php echo session()->getFlashdata('exito'); ?>
            </div>
        <?php endif; ?>


        <!-- Muestra errores si las credenciales son incorrectas -->
        <?php if (session()->getFlashdata('errores')): ?>
            <div class="error-alert">
                <ul>
                <?php foreach (session()->getFlashdata('errores') as $error): ?>
                    <li><?php echo esc($error); ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <form action="login" method="post" class="login-form">
            <?php echo csrf_field(); ?>
           
            <div class="form-group">
                <label for="correo_electronico" class="form-label">Email</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="form-input" placeholder="ejemplo@correo.com" required value="<?php echo old('correo_electronico'); ?>">
            </div>
           
            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña</label>
                <div class="password-input-wrapper">
                    <input type="password" id="contraseña" name="contraseña" class="form-input password-field" placeholder="Tu contraseña" required>
                    <button class="btn-toggle-password" type="button" id="btnTogglePassword">Mostrar</button>
                </div>
            </div>
           
            <div class="form-actions">
                <button type="submit" class="btn-submit">Ingresar</button>
            </div>
        </form>
       
        <div class="card-footer">
            <a href="register" class="register-redirect-link">¿No tienes cuenta? <span>Regístrate aquí</span></a>
        </div>
    </div>
</div>

<script>
    // Manejo de alternancia de contraseña idéntico y funcional
    document.getElementById('btnTogglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('contraseña');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
    });
</script>

<?= view('templates/footer') ?>
