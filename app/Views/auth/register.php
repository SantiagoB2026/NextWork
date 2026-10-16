<?= view('templates/header') ?>
<style>
    /* Contenedor principal que centra la tarjeta vertical y horizontalmente */
.registration-page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    min-height: 85vh;
    box-sizing: border-box;
    padding: 20px;
}

/* Aplicar box-sizing global dentro del componente */
.registration-page-wrapper *, 
.registration-page-wrapper *::before, 
.registration-page-wrapper *::after {
    box-sizing: border-box;
}

/* Tarjeta contenedora principal (Escalada a tamaño grande) */
.registration-card {
    width: 100%;
    max-width: 650px;
    background-color: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 45px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
}

/* Título */
.card-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #ffffff;
    text-align: center;
    margin: 0 0 35px 0;
    font-family: inherit;
}

/* Grupos de formularios */
.form-group {
    margin-bottom: 25px;
    display: flex;
    flex-direction: column;
}

/* Fila de 2 columnas nativa para Nombre/Apellido */
.form-row-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Pantallas pequeñas: Nombre y Apellido se apilan */
@media (max-width: 576px) {
    .form-row-2col {
        grid-template-columns: 1fr;
        gap: 0;
    }
}

/* Etiquetas (Labels) */
.form-label {
    font-size: 1.05rem;
    font-weight: 500;
    color: #cbd5e1;
    margin-bottom: 10px;
}

/* Entradas de Texto e Inputs grandes */
.form-input {
    width: 100%;
    background-color: #0f172a;
    border: 1px solid #334155;
    color: #ffffff;
    border-radius: 8px;
    font-size: 1.15rem;
    padding: 14px 16px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
}

/* Corrección visual para el selector de fecha */
input[type="date"].form-input::-webkit-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
    transform: scale(1.2);
}

/* Contenedor del campo de contraseña y botón */
.password-input-wrapper {
    display: flex;
    position: relative;
    width: 100%;
}

.password-field {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* Botón "Mostrar" Cuadrado */
.btn-toggle-password {
    background-color: #334155;
    border: 1px solid #334155;
    border-left: none;
    color: #ffffff;
    font-size: 1.05rem;
    font-weight: 500;
    padding: 0 25px;
    border-radius: 0 8px 8px 0;
    cursor: pointer;
    transition: background-color 0.2s;
    white-space: nowrap;
}

.btn-toggle-password:hover {
    background-color: #475569;
    border-color: #475569;
}

/* --- Selector de Rol en Botones Juntos --- */
.role-selector-container {
    display: flex;
    width: 100%;
    border: 1px solid #334155;
    border-radius: 8px;
    overflow: hidden;
    background-color: #0f172a;
}

/* Esconder el radio button original circular */
.radio-hidden {
    display: none;
}

/* El label que actúa como botón */
.role-btn-label {
    flex: 1;
    text-align: center;
    padding: 16px 0;
    background-color: #0f172a;
    color: #94a3b8;
    font-size: 1.15rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}

.role-btn-label:grid-area {
    background-color: #1e293b;
}

.role-btn-label:not(:last-child) {
    border-right: 1px solid #334155;
}

/* CUANDO ESTÁ SELECCIONADO: Se vuelve verde Nextwork */
.radio-hidden:checked + .role-btn-label {
    background-color: #10b981;
    color: #0f172a;
}

/* Botón de Enviar Registrar Grande */
.form-actions {
    margin-top: 35px;
}

.btn-submit {
    width: 100%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: #ffffff;
    font-size: 1.3rem;
    font-weight: 700;
    padding: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: box-shadow 0.2s, transform 0.1s;
}

.btn-submit:hover {
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.45);
}

.btn-submit:active {
    transform: scale(0.99);
}

/* Alertas de error nativas */
.error-alert {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.error-alert ul {
    margin: 0;
    padding-left: 20px;
}

/* Enlace inferior */
.card-footer {
    text-align: center;
    margin-top: 25px;
}

.login-redirect-link {
    color: #10b981;
    font-size: 1.05rem;
    text-decoration: none;
    font-weight: 500;
}

.login-redirect-link:hover {
    text-decoration: underline;
    color: #34d399;
}

</style>

<div class="registration-page-wrapper">
    <div class="registration-card">
        <h3 class="card-title">Registro de Usuario</h3>

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
                <label for="alias" class="form-label">Nombre de Usuario (Alias):</label>
                <input type="text" id="alias" name="alias" class="form-input" required value="<?= old('alias') ?>">
            </div>
            
            <!-- Fila de dos columnas nativa para Nombre y Apellido -->
            <div class="form-row-2col">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" required value="<?= old('nombre') ?>">
                </div>
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" class="form-input" required value="<?= old('apellido') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="correo_electronico" class="form-label">Email:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="form-input" required value="<?= old('correo_electronico') ?>">
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" min="1926-01-01" max="2026-10-16" class="form-input" required value="<?= old('fecha_nacimiento') ?>">
            </div>

            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <div class="password-input-wrapper">
                    <input type="password" id="contraseña" name="contraseña" class="form-input password-field" required>
                    <button class="btn-toggle-password" type="button" id="btnTogglePassword">Mostrar</button>
                </div>
            </div>

            <!-- Selector de Rol con botones juntos en CSS Puro -->
            <div class="form-group">
                <label class="form-label">Selecciona tu Rol:</label>
                <div class="role-selector-container">
                    <input type="radio" class="radio-hidden" name="tipo" id="rol_inversionista" value="inversionista" required <?= old('tipo') == 'inversionista' ? 'checked' : '' ?>>
                    <label class="role-btn-label" for="rol_inversionista">Inversionista</label>

                    <input type="radio" class="radio-hidden" name="tipo" id="rol_desarrollador" value="desarrollador" <?= old('tipo') == 'desarrollador' ? 'checked' : '' ?>>
                    <label class="role-btn-label" for="rol_desarrollador">Desarrollador</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Registrar</button>
            </div>
        </form>

        <div class="card-footer">
            <a href="login" class="login-redirect-link">¿Ya tenés una cuenta? Iniciá sesión aquí.</a>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>

<script>
document.getElementById('btnTogglePassword').addEventListener('click', function () {
  const passwordInput = document.getElementById('contraseña');
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    this.textContent = 'Ocultar';
  } else {
    passwordInput.type = 'password';
    this.textContent = 'Mostrar';
  }
});
</script>
