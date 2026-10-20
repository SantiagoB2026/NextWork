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
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

    <!-- 1. HEADER SEPARADO -->
    <header class="main-header">
        <div class="header-container">
            <div class="brand-logo">
               <a href="/">
                    <img src="../assets/img/Logo_Nextwork.png" alt="Logo Nextwork">
                </a>
            </div>
            <form action="<?= site_url('search/results') ?>" method="GET" class="search-container">
    <input type="text" name="query" class="search-input" placeholder="Search" autocomplete="off">
    <button type="submit" class="search-button">Search</button>
</form>
            <div class="user-avatar"></div>

        </div>
                            <div class="d-flex align-items-center text-white">
                        <?php if (session()->get('isLoggedIn')): ?>
                        <span class="me-3 small">Bienvenido <?= esc(strtok(session()->get('nombre') ?? '', ' ')) ?>!!!</span>
                        <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
                        <?php endif; ?>
                    </div>
        <div class="header-border"></div>
    </header>