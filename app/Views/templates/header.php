    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenido a Nextwork</title>
    <link rel="icon" type="image/png" href="../assets/img/Logo_Nextwork.png">
        <!-- Importación de tipografía -->
        <link href="https://googleapis.com" rel="stylesheet">
       
        <!-- ESTILOS INTERNOS (Para evitar problemas de rutas de carpetas) -->
        <link rel="stylesheet" href="../assets/css/todo.css">
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
           <a href="/">
                <img src="../assets/img/logoverdecompleto.png" alt="Logo Nextwork">
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
                <a href="<?= site_url('logout') ?>" class="btn btn-cerrar">Cerrar Sesión</a>
            <?php else: ?>
                <!-- Elementos por si no ha iniciado sesión, alineados al diseño -->
                <a href="<?= site_url('register') ?>" class="btn btn-register">Registrarse</a>
                <a href="<?= site_url('login') ?>" class="btn btn-login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
<a href="<?= site_url('perfil') ?>" class="btn btn-login"><div class="avatar-img" id="ewAvatar">
  <?= esc(mb_substr(session()->get('name'), 0, 1)) ?>
</div></a>
    </div>


    <!-- Menú inferior de Etiquetas requerido por el mockup -->
    <nav class="nav-tags-container">
        <ul class="nav-tags">
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li><a href="#">Etiqueta</a></li>
            <li class="divider">|</li>
            <li><a href="#" class="discover-link">Descubrir</a></li>

            
        </ul>
    </nav>
</header>
