<?= view('templates/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="mb-4 text-center">Registro de Usuario</h3>

            <?php if (session()->getFlashdata('errores')): ?>
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="register" method="post" class="needs-validation">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="alias" class="form-label">Nombre de Usuario (Alias):</label>
                    <input type="text" id="alias" name="alias" class="form-control" required value="<?= old('alias') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= old('nombre') ?>">
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required value="<?= old('apellido') ?>">
                </div>

                <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Email:</label>
                    <input type="email" id="correo_electronico" name="correo_electronico" class="form-control" required value="<?= old('correo_electronico') ?>">
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" min="1926-01-01" max="2026-10-16" class="form-control" required value="<?= old('fecha_nacimiento') ?>">
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required >
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Rol:</label>
                       <select name="tipo" id="tipo" class="form-control" required>
                            <option value="">Selecciona un rol</option>
                            <option value="inversionista">Inversionista</option> 
                            <option value="desarrollador">Desarrollador</option> 
</select>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p><a href="login" class="text-decoration-none">¿Ya tenés una cuenta? Iniciá sesión aquí.</a></p>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>




 /**blabal */