<?= view('templates/header') ?>

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<style>
/* Contenedor principal que centra el formulario en un espacio limpio y blanco */
.registration-page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    min-height: 85vh;
    box-sizing: border-box;
    padding: 40px 20px;
    background-color: #ffffff;
}

<<<<<<< HEAD

.registration-page-wrapper *,
.registration-page-wrapper *::before,
=======
.registration-page-wrapper *, 
.registration-page-wrapper *::before, 
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.registration-page-wrapper *::after {
    box-sizing: border-box;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Contenedor minimalista sin cajas pesadas ni sombras oscuras */
.registration-container {
    width: 100%;
    max-width: 420px; /* Tamaño estilizado y compacto */
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Encabezado y Título */
.register-header {
    margin-bottom: 40px;
    text-align: center;
<<<<<<< HEAD
=======
}

.card-title {
    font-size: 26px;
    font-weight: 700;
    color: #000000;
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
}

.register-subtitle {
    font-size: 13.5px;
    color: #666666;
    margin: 0;
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
}


.card-title {
    font-size: 26px;
    font-weight: 700;
    color: #000000;
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
}


.register-subtitle {
    font-size: 13.5px;
    color: #666666;
    margin: 0;
}


/* Grupos de formularios */
.form-group {
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
}


/* Fila de 2 columnas nativa para Nombre/Apellido */
.form-row-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
@media (max-width: 576px) {
    .form-row-2col {
        grid-template-columns: 1fr;
        gap: 0;
    }
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Etiquetas (Labels) en mayúsculas sutiles */
.form-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #000000;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Entradas de Texto Premium Minimalistas */
.form-input {
    width: 100%;
    background-color: #fafafa;
    border: 1px solid #eaeaea;
    color: #000000;
    border-radius: 6px;
    font-size: 14px;
    padding: 12px 14px;
    outline: none;
    font-family: inherit;
    transition: background-color 0.15s ease, border-color 0.15s ease;
}


.form-input:focus {
    background-color: #ffffff;
    border-color: #000000;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Corrección visual para el selector de fecha en modo claro */
input[type="date"].form-input {
    color: #000000;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Contenedor del campo de contraseña */
.password-input-wrapper {
    display: flex;
    position: relative;
    width: 100%;
}


.password-field {
    padding-right: 75px; /* Espacio para que el texto no pise el botón */
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Botón "Mostrar" integrado de forma invisible a la derecha */
.btn-toggle-password {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666666;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    transition: color 0.15s ease;
}


.btn-toggle-password:hover {
    color: #000000;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* --- Selector de Rol Unificado y Minimalista --- */
.role-selector-container {
    display: flex;
    width: 100%;
    border: 1px solid #eaeaea;
    border-radius: 6px;
    overflow: hidden;
    background-color: #fafafa;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.radio-hidden {
    display: none;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.role-btn-label {
    flex: 1;
    text-align: center;
    padding: 12px 0;
    background-color: #fafafa;
    color: #666666;
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.role-btn-label:not(:last-child) {
    border-right: 1px solid #eaeaea;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* CUANDO ESTÁ SELECCIONADO: Cambio limpio a Negro y Verde Corporativo */
.radio-hidden:checked + .role-btn-label {
    background-color: #00c774; /* Verde Nextwork */
    color: #ffffff;
    font-weight: 600;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Botón de Enviar Registrar Minimalista */
.form-actions {
    margin-top: 28px;
}


.btn-submit {
    width: 100%;
    background-color: #00c774; /* Verde Nextwork */
    border: none;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    padding: 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: opacity 0.15s ease;
}


.btn-submit:hover {
    opacity: 0.9;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
/* Alertas de error limpias */
.error-alert {
    background-color: #fef2f2;
    border: 1px solid #fee2e2;
    color: #991b1b;
    padding: 14px;
    border-radius: 6px;
    margin-bottom: 24px;
    font-size: 13px;
}


.error-alert ul {
    margin: 0;
    padding-left: 16px;
}


/* Enlace inferior */
.card-footer {
    text-align: center;
    margin-top: 28px;
}


.login-redirect-link {
    color: #666666;
    font-size: 13px;
    text-decoration: none;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.login-redirect-link span {
    color: #000000;
    font-weight: 500;
    border-bottom: 1px solid #000000;
}

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
.login-redirect-link:hover span {
    color: #00c774;
    border-bottom-color: #00c774;
}
</style>


<div class="registration-page-wrapper">
    <div class="registration-container">
<<<<<<< HEAD
       
=======
        
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
        <div class="register-header">
            <h3 class="card-title">Registro de Usuario</h3>
            <p class="register-subtitle">Ingresá tus datos para empezar en Nextwork.</p>
        </div>
<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee

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

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
            <div class="form-group">
                <label for="alias" class="form-label">Nombre de Usuario (Alias)</label>
                <input type="text" id="alias" name="alias" class="form-input" required value="<?= old('alias') ?>">
            </div>

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
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

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
            <!-- Selector de Rol - Vacio por defecto -->
            <div class="form-group">
                <label class="form-label">Selecciona tu Rol</label>
                <div class="role-selector-container">
                    <input type="radio" class="radio-hidden" name="tipo" id="rol_inversionista" value="inversionista" required <?= old('tipo') == 'inversionista' ? 'checked' : '' ?>>
                    <label class="role-btn-label" for="rol_inversionista">Inversionista</label>
<<<<<<< HEAD
                   
=======
                    
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
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

<<<<<<< HEAD

    </div>
</div>


=======
    </div>
</div>

>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<script>
document.getElementById('btnTogglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('contraseña');
    const isPassword = passwordField.getAttribute('type') === 'password';
<<<<<<< HEAD
   
=======
    
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
    passwordField.setAttribute('type', isPassword ? 'text' : 'password');
    this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
});
</script>

<<<<<<< HEAD

<?= view('templates/footer') ?>



=======
<?= view('templates/footer') ?>
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
