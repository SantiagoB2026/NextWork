<?= view('templates/header') ?>
<style>
    /* Contenedor principal que centra la tarjeta vertical y horizontalmente */
.login-page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    min-height: 80vh;
    box-sizing: border-box;
    padding: 20px;
}

/* Asegurar el orden de cajas dentro del componente */
.login-page-wrapper *, 
.login-page-wrapper *::before, 
.login-page-wrapper *::after {
    box-sizing: border-box;
}

/* Tarjeta del Login (Mismo ancho visual que el registro para consistencia) */
.login-card {
    width: 100%;
    max-width: 520px; /* Un poco más angosta que el registro al tener menos campos */
    background-color: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 45px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
}

/* Título */
.login-card .card-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #ffffff;
    text-align: center;
    margin: 0 0 35px 0;
}

/* Estructura de campos */
.login-card .form-group {
    margin-bottom: 25px;
    display: flex;
    flex-direction: column;
}

/* Etiquetas */
.login-card .form-label {
    font-size: 1.05rem;
    font-weight: 500;
    color: #cbd5e1;
    margin-bottom: 10px;
}

/* Inputs de texto grandes */
.login-card .form-input {
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

.login-card .form-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
}

/* Estilización del PlaceHolder */
.login-card .form-input::placeholder {
    color: #475569;
}

/* Manejo del input de contraseña compuesto */
.login-card .password-input-wrapper {
    display: flex;
    position: relative;
    width: 100%;
}

.login-card .password-field {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* Botón "Mostrar" Cuadrado */
.login-card .btn-toggle-password {
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

.login-card .btn-toggle-password:hover {
    background-color: #475569;
    border-color: #475569;
}

/* Alertas de error y éxito */
.login-card .error-alert,
.login-card .success-alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    font-size: 1rem;
}

.login-card .error-alert {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

.login-card .error-alert ul {
    margin: 0;
    padding-left: 20px;
}

.login-card .success-alert {
    background-color: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #a7f3d0;
}

/* Botón de Enviar (Ingresar) */
.login-card .form-actions {
    margin-top: 35px;
}

.login-card .btn-submit {
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

.login-card .btn-submit:hover {
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.45);
}

.login-card .btn-submit:active {
    transform: scale(0.99);
}

/* Enlace inferior del footer */
.login-card .card-footer {
    text-align: center;
    margin-top: 25px;
}

.login-card .register-redirect-link {
    color: #10b981;
    font-size: 1.05rem;
    text-decoration: none;
    font-weight: 500;
}

.login-card .register-redirect-link:hover {
    text-decoration: underline;
    color: #34d399;
}

</style>
<div class="login-page-wrapper">
    <div class="login-card">
        <h3 class="card-title">Iniciar Sesión</h3>

        <!-- Muestra el mensaje de éxito si el usuario viene directo de registrarse -->
        <?php if (session()->getFlashdata('exito')): ?>
            <div class="success-alert">
                <?= session()->getFlashdata('exito') ?>
            </div>
        <?php endif; ?>

        <!-- Muestra errores si las credenciales son incorrectas -->
        <?php if (session()->getFlashdata('errores')): ?>
            <div class="error-alert">
                <ul>
                <?php foreach (session()->getFlashdata('errores') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="login" method="post" class="login-form">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="correo_electronico" class="form-label">Email:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="form-input" placeholder="ejemplo@correo.com" required value="<?= old('correo_electronico') ?>">
            </div>
            
            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <div class="password-input-wrapper">
                    <input type="password" id="contraseña" name="contraseña" class="form-input password-field" placeholder="Contraseña" required>
                    <button class="btn-toggle-password" type="button" id="btnTogglePassword">Mostrar</button>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Ingresar</button>
            </div>
        </form>
        
        <div class="card-footer">
            <a href="register" class="register-redirect-link">¿No tienes cuenta? Regístrate aquí.</a>
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
