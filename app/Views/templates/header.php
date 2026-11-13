<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Nextwork</title>
    <!-- CORREGIDO: Ruta del Favicon absoluta -->
    <link type="image/png" href="<?= base_url('assets/img/Logo_Nextwork.png') ?>" rel="icon">
    
    <!-- Importación de tipografía -->
    <link href="https://googleapis.com" rel="stylesheet">
   
    <!-- CORREGIDO: Todos los estilos locales ahora usan base_url() y nunca se romperán -->
    <link rel="stylesheet" href="<?= base_url('assets/css/todo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/perfil.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/proyectos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/comunidad.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<!-- 1. HEADER SEPARADO -->
<!-- Línea decorativa verde superior fija en el diseño -->
<div class="top-line"></div>

<header class="main-header">
    <div class="header-container">
        <!-- Contenedor del Logo -->
        <div class="brand-logo">
           <a href="<?= base_url('/') ?>">
                <!-- CORREGIDO: Imagen del logo con ruta absoluta -->
                <img src="<?= base_url('assets/img/logoverdecompleto.png') ?>" alt="Logo Nextwork">
            </a>
        </div>
       
        <!-- Formulario de Búsqueda dinámico -->
        <form action="<?= site_url('search/results') ?>" method="GET" class="search-container">
            <input type="text" name="query" class="search-input" placeholder="Search" autocomplete="off" aria-label="Buscar">
            <button type="submit" class="search-button" aria-label="Buscar"></button>
        </form>
        <!-- Grupo de Botones / Control de sesión PHP -->
        <div class="button-group">
            <?php if (session()->get('isLoggedIn')): ?>
                <?php if (in_array(session()->get('tipo'), ['desarrollador', 'inversionista'], true)): ?>
                    
                <?php endif; ?>
                <?php if (session()->get('tipo') === 'desarrollador'): ?>
                    <?php $invPendientes = (new \App\Models\ColaboradorModel())->contarPendientes((int) session()->get('id')); ?>
                    <a href="<?= site_url('desarrollador/proyectos') ?>" class="btn btn-login">Mis proyectos<?php if ($invPendientes > 0): ?> <span class="np-badge"><?= $invPendientes ?></span><?php endif; ?></a>
                <?php elseif (session()->get('tipo') === 'inversionista'): ?>
                    <a href="<?= site_url('inversionista/donaciones') ?>" class="btn btn-login">Mis inversiones</a>
                <?php endif; ?>
                <a href="<?= site_url('logout') ?>" class="btn btn-cerrar">Cerrar Sesión</a>
            <?php else: ?>
                <!-- Elementos por si no ha iniciado sesión, alineados al diseño -->
                <a href="<?= site_url('register') ?>" class="btn btn-register">Registrarse</a>
                <a href="<?= site_url('login') ?>" class="btn btn-login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
        <a href="<?= site_url('perfil') ?>" class="btn btn-login">
            <div class="avatar-img" id="ewAvatar">
                <?= esc(mb_substr(session()->get('name') ?? 'U', 0, 1)) ?>
            </div>
        </a>
    </div>

<?php
    // Etiquetas del menú (se leen de la base de datos) y etiqueta activa según la URL
    $etiquetasNav = model(\App\Models\EtiquetaModel::class)->orderBy('nombre')->findAll(10);
    $uriActual    = service('request')->getUri();
    $slugActual   = $uriActual->getSegment(1) === 'etiqueta' ? $uriActual->getSegment(2) : null;
?>
    <!-- Menú inferior de Etiquetas: cada una filtra los proyectos -->
    <nav class="nav-tags-container">
        <ul class="nav-tags">
            <?php foreach ($etiquetasNav as $et): ?>
                <li>
                    <a href="<?= site_url('etiqueta/' . $et['slug']) ?>"<?= $slugActual === $et['slug'] ? ' class="active"' : '' ?>>
                        <?= esc($et['nombre']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="divider">|</li>
            <li><a href="<?= site_url('etiquetas') ?>" class="discover-link">Descubrir</a></li>
        </ul>
    </nav>
    <style>.nav-tags a.active { font-weight: 700; text-decoration: underline; }</style>
</header>
