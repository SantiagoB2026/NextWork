<?= view('templates/header') ?>


<div class="registration-page-wrapper">
    <div class="registration-container">
        
        <div class="register-header">
            <h3 class="card-title">Registro de Usuario</h3>
            <p class="register-subtitle">Ingresá tus datos para empezar en Nextwork.</p>
        </div>

        <?php if (session()->getFlashdata('errores')): ?>
            <div class="error-alert">
                <ul>
                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="register" method="post" class="registration-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="alias" class="form-label">Nombre de Usuario (Alias)</label>
                <input type="text" id="alias" name="alias" class="form-input" required value="<?= old('alias') ?>">
            </div>

            <!-- Fila de dos columnas nativa para Nombre y Apellido -->
            <div class="form-row-2col">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" required value="<?= old('nombre') ?>">
                </div>
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="form-input" required value="<?= old('apellido') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="correo_electronico" class="form-label">Email</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="form-input" required value="<?= old('correo_electronico') ?>">
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" min="1926-01-01" max="2026-10-16" class="form-input" required value="<?= old('fecha_nacimiento') ?>">
            </div>

            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña</label>
                <div class="password-input-wrapper">
                    <input type="password" id="contraseña" name="contraseña" class="form-input password-field" required>
                    <button class="btn-toggle-password" type="button" id="btnTogglePassword">Mostrar</button>
                </div>
            </div>

            <!-- Selector de Rol - Vacio por defecto -->
            <div class="form-group">
                <label class="form-label">Selecciona tu Rol</label>
                <div class="role-selector-container">
                    <input type="radio" class="radio-hidden" name="tipo" id="rol_inversionista" value="inversionista" required <?= old('tipo') == 'inversionista' ? 'checked' : '' ?>>
                    <label class="role-btn-label" for="rol_inversionista">Inversionista</label>
                    
                    <input type="radio" class="radio-hidden" name="tipo" id="rol_desarrollador" value="desarrollador" <?= old('tipo') == 'desarrollador' ? 'checked' : '' ?>>
                    <label class="role-btn-label" for="rol_desarrollador">Desarrollador</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Crear cuenta</button>
            </div>
        </form>

        <div class="card-footer">
            <a href="login" class="login-redirect-link">¿Ya tienes una cuenta? <span>Inicia sesión</span></a>
        </div>

    </div>
</div>

<script>
document.getElementById('btnTogglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('contraseña');
    const isPassword = passwordField.getAttribute('type') === 'password';
    
    passwordField.setAttribute('type', isPassword ? 'text' : 'password');
    this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
});
</script>

<?= view('templates/footer') ?>
