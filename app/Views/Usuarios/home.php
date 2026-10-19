<?= view('templates/header') ?>

 <main class="main-content">
        <div class="welcome-container">
            <?php if (!session()->get('isLoggedIn')): ?>
            <h1 class="title-welcome">BIENVENIDO A <span class="brand-name">NEXTWORK</span></h1>
            
            <div class="button-group">
                <a href="<?= site_url('register') ?>" class="btn btn-dark">Crear cuenta</a>
                <a href="<?= site_url('login') ?>" class="btn btn-green">Ya tengo cuenta</a>

                <div class="d-flex align-items-center text-white">
                <?php elseif (session()->get('isLoggedIn')): ?>
                <span class="me-3 small">Bienvenido <?= esc(strtok(session()->get('nombre') ?? '', ' ')) ?>!!!</span>
                <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?= view('templates/footer') ?>