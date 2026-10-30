<?= view('templates/header') ?>

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<style>
    /* Contenedor principal que centra el formulario en un espacio limpio y blanco */
    .login-page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 80vh;
        box-sizing: border-box;
        padding: 40px 20px;
        background-color: #ffffff;
    }

<<<<<<< HEAD

    /* Asegurar el orden de cajas dentro del componente */
    .login-page-wrapper *,
    .login-page-wrapper *::before,
    .login-page-wrapper *::after {
        box-sizing: border-box;
    }


    /* Contenedor minimalista sin cajas pesadas ni sombras oscuras */
    .login-card {
        width: 100%;
        max-width: 360px; /* Tamaño compacto y estilizado a juego con el registro */
    }


    /* Título */
    .login-card .card-title {
        font-size: 26px;
        font-weight: 700;
        color: #000000;
        text-align: center;
        margin: 0 0 6px 0;
        letter-spacing: -0.5px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    /* Texto de bienvenida sutil debajo del título */
    .login-subtitle {
        font-size: 13.5px;
        color: #666666;
        text-align: center;
        margin-bottom: 40px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    /* Estructura de campos */
    .login-card .form-group {
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
    }


    /* Etiquetas (Labels) en mayúsculas sutiles */
    .login-card .form-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #000000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    /* Entradas de Texto Premium Minimalistas */
    .login-card .form-input {
        width: 100%;
        background-color: #fafafa;
        border: 1px solid #eaeaea;
        color: #000000;
        border-radius: 6px;
        font-size: 14px;
        padding: 12px 14px;
        outline: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }


    .login-card .form-input:focus {
        background-color: #ffffff;
        border-color: #000000;
    }


    /* Estilización del PlaceHolder en gris suave */
    .login-card .form-input::placeholder {
        color: #a0a0a0;
    }


    /* Manejo del input de contraseña compuesto */
    .login-card .password-input-wrapper {
        display: flex;
        position: relative;
        width: 100%;
    }


    .login-card .password-field {
        padding-right: 75px; /* Espacio para que el texto no pise el botón */
    }


    /* Botón "Mostrar" integrado de forma invisible a la derecha */
    .login-card .btn-toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666666;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: color 0.15s ease;
    }


    .login-card .btn-toggle-password:hover {
        color: #000000;
    }


    /* Alertas de error y éxito limpias */
    .login-card .error-alert,
    .login-card .success-alert {
        padding: 14px;
        border-radius: 6px;
        margin-bottom: 24px;
        font-size: 13px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    .login-card .error-alert {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        color: #991b1b;
    }


    .login-card .error-alert ul {
        margin: 0;
        padding-left: 16px;
    }


    .login-card .success-alert {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }


    /* Botón de Enviar (Ingresar) Minimalista */
    .login-card .form-actions {
        margin-top: 32px;
    }


    .login-card .btn-submit {
        width: 100%;
        background-color: #00c774; /* Verde Nextwork corporativo */
        border: none;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        padding: 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: opacity 0.15s ease;
    }


    .login-card .btn-submit:hover {
        opacity: 0.9;
    }


    /* Enlace inferior del footer */
    .login-card .card-footer {
        text-align: center;
        margin-top: 28px;
    }


    .login-card .register-redirect-link {
        color: #666666;
        font-size: 13px;
        text-decoration: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    .login-card .register-redirect-link span {
        color: #000000;
        font-weight: 500;
        border-bottom: 1px solid #000000;
    }


=======
    /* Asegurar el orden de cajas dentro del componente */
    .login-page-wrapper *, 
    .login-page-wrapper *::before, 
    .login-page-wrapper *::after {
        box-sizing: border-box;
    }

    /* Contenedor minimalista sin cajas pesadas ni sombras oscuras */
    .login-card {
        width: 100%;
        max-width: 360px; /* Tamaño compacto y estilizado a juego con el registro */
    }

    /* Título */
    .login-card .card-title {
        font-size: 26px;
        font-weight: 700;
        color: #000000;
        text-align: center;
        margin: 0 0 6px 0;
        letter-spacing: -0.5px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Texto de bienvenida sutil debajo del título */
    .login-subtitle {
        font-size: 13.5px;
        color: #666666;
        text-align: center;
        margin-bottom: 40px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Estructura de campos */
    .login-card .form-group {
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
    }

    /* Etiquetas (Labels) en mayúsculas sutiles */
    .login-card .form-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #000000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Entradas de Texto Premium Minimalistas */
    .login-card .form-input {
        width: 100%;
        background-color: #fafafa;
        border: 1px solid #eaeaea;
        color: #000000;
        border-radius: 6px;
        font-size: 14px;
        padding: 12px 14px;
        outline: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .login-card .form-input:focus {
        background-color: #ffffff;
        border-color: #000000;
    }

    /* Estilización del PlaceHolder en gris suave */
    .login-card .form-input::placeholder {
        color: #a0a0a0;
    }

    /* Manejo del input de contraseña compuesto */
    .login-card .password-input-wrapper {
        display: flex;
        position: relative;
        width: 100%;
    }

    .login-card .password-field {
        padding-right: 75px; /* Espacio para que el texto no pise el botón */
    }

    /* Botón "Mostrar" integrado de forma invisible a la derecha */
    .login-card .btn-toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666666;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: color 0.15s ease;
    }

    .login-card .btn-toggle-password:hover {
        color: #000000;
    }

    /* Alertas de error y éxito limpias */
    .login-card .error-alert,
    .login-card .success-alert {
        padding: 14px;
        border-radius: 6px;
        margin-bottom: 24px;
        font-size: 13px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .login-card .error-alert {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        color: #991b1b;
    }

    .login-card .error-alert ul {
        margin: 0;
        padding-left: 16px;
    }

    .login-card .success-alert {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    /* Botón de Enviar (Ingresar) Minimalista */
    .login-card .form-actions {
        margin-top: 32px;
    }

    .login-card .btn-submit {
        width: 100%;
        background-color: #00c774; /* Verde Nextwork corporativo */
        border: none;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        padding: 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        transition: opacity 0.15s ease;
    }

    .login-card .btn-submit:hover {
        opacity: 0.9;
    }

    /* Enlace inferior del footer */
    .login-card .card-footer {
        text-align: center;
        margin-top: 28px;
    }

    .login-card .register-redirect-link {
        color: #666666;
        font-size: 13px;
        text-decoration: none;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .login-card .register-redirect-link span {
        color: #000000;
        font-weight: 500;
        border-bottom: 1px solid #000000;
    }

>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
    .login-card .register-redirect-link:hover span {
        color: #00c774;
        border-bottom-color: #00c774;
    }
</style>

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<div class="login-page-wrapper">
    <div class="login-card">
        <h3 class="card-title">Iniciar Sesión</h3>
        <p class="login-subtitle">Ingresa tus credenciales de Nextwork.</p>
<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee

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
<<<<<<< HEAD
           
=======
            
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
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

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<script>
    // Manejo de alternancia de contraseña idéntico y funcional
    document.getElementById('btnTogglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('contraseña');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
    });
</script>

<<<<<<< HEAD

=======
>>>>>>> 4ed7080bf701aa57d3d755a39201d214068d1dee
<?= view('templates/footer') ?>
