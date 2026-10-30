<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
</head>
<body>

    <!-- ELIMINAMOS EL FORMULARIO REPETIDO QUE ESTABA ACÁ -->

    <?php if (!empty($keyword)): ?>
        <h2>Resultados para: "<?= esc($keyword) ?>"</h2>

        <!-- SECCIÓN USUARIOS -->
        <h3>Usuarios Encontrados (<?= count($usuarios) ?>)</h3>
        <?php if (!empty($usuarios)): ?>
            <ul>
                <?php foreach ($usuarios as $user): ?>
                    <li>
                        <strong><?= esc($user['alias']) ?></strong> - <?= esc($user['nombre']) ?> <?= esc($user['apellido']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se encontraron usuarios con ese criterio.</p>
        <?php endif; ?>

        <hr>

        <!-- SECCIÓN PROYECTOS -->
        <h3>Proyectos Encontrados (<?= count($proyectos) ?>)</h3>
        <?php if (!empty($proyectos)): ?>
            <ul>
                <?php foreach ($proyectos as $proy): ?>
                    <li>
                        <strong><?= esc($proy['titulo'] ?? 'Sin título') ?></strong> 
                        <p><?= esc($proy['descripcion']) ?></p>
                        <small>Etiqueta: <?= esc($proy['etiqueta'] ?? 'Ninguna') ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se encontraron proyectos con ese criterio.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Por favor, ingresá un término de búsqueda en la barra superior.</p>
    <?php endif; ?>

</body>
</html>